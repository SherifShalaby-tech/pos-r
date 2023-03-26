<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Manufacturing;
use App\Models\manufacturingProduct;
use App\Models\Product;
use App\Models\ProductClass;
use App\Models\ProductStore;
use App\Models\Recipe;
use App\Models\Store;
use App\Models\Unit;
use App\Utils\Util;
use Doctrine\DBAL\Exception\DatabaseDoesNotExist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ManufacturingController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $commonUtil;

    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }

    public function index()
    {
        $manufacturings = Manufacturing::all();
        return view('manufacturings.index')->with(compact(
            'manufacturings'
        ));
    }

    public function create()
    {
        $store_query = '';
        $products = Product::leftjoin('variations', function ($join) {
            $join->on('products.id', 'variations.product_id')->whereNull('variations.deleted_at');
        })
            ->leftjoin('add_stock_lines', function ($join) {
                $join->on('variations.id', 'add_stock_lines.variation_id')->where('add_stock_lines.expiry_date', '>=', date('Y-m-d'));
            })
            ->leftjoin('colors', 'variations.color_id', 'colors.id')
            ->leftjoin('sizes', 'variations.size_id', 'sizes.id')
            ->leftjoin('grades', 'variations.grade_id', 'grades.id')
            ->leftjoin('units', 'variations.unit_id', 'units.id')
            ->leftjoin('product_classes', 'products.product_class_id', 'product_classes.id')
            ->leftjoin('categories', 'products.category_id', 'categories.id')
            ->leftjoin('categories as sub_categories', 'products.sub_category_id', 'sub_categories.id')
            ->leftjoin('brands', 'products.brand_id', 'brands.id')
            ->leftjoin('supplier_products', 'products.id', 'supplier_products.product_id')
            ->leftjoin('users', 'products.created_by', 'users.id')
            ->leftjoin('users as edited', 'products.edited_by', 'users.id')
            ->leftjoin('taxes', 'products.tax_id', 'taxes.id')
            ->leftjoin('product_stores', 'variations.id', 'product_stores.variation_id');
        $products = $products->select(
            'products.*',
            'add_stock_lines.batch_number',
            'variations.sub_sku',
            'product_classes.name as product_class',
            'categories.name as category',
            'sub_categories.name as sub_category',
            'brands.name as brand',
            'colors.name as color',
            'sizes.name as size',
            'grades.name as grade',
            'units.name as unit',
            'taxes.name as tax',
            'variations.id as variation_id',
            'variations.name as variation_name',
            'variations.default_purchase_price',
            'variations.default_sell_price as default_sell_price',
            'add_stock_lines.expiry_date as exp_date',
            'users.name as created_by_name',
            'edited.name as edited_by_name',
            DB::raw('(SELECT SUM(product_stores.qty_available) FROM product_stores JOIN variations as v ON product_stores.variation_id=v.id WHERE v.id=variations.id ' . $store_query . ') as current_stock'),
        )->with(['supplier'])
            ->groupBy('variations.id')
            ->get();

        $stores = Store::getDropdown();
        $manufacturers = Manufacturer::getDropdown();


        return view('manufacturings.create')
            ->with(compact(
                'stores',
                'products',
                'manufacturers',
            ));
    }


    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'store_id' => ['required', 'numeric'],
                'manufacturer_id' => ['required', 'numeric'],
            ]
        );
        try {

            $data = $request->only('store_id', 'manufacturer_id');
            $data["created_by"] = auth()->id();
            DB::beginTransaction();
            $manufacturing = Manufacturing::firstOrCreate($data);
            foreach ($request->product_quentity as $product_quentity) {
                $manufacturingProducts = manufacturingProduct::query()->firstOrCreate([
                    "manufacturing_id" => $manufacturing->id,
                    "product_id" => $product_quentity->product_id,
                    "quantity" => $product_quentity->quantity,
                ]);
            }
            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];

        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return $output;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $manufacturing = Manufacturing::findOrFail($id);
        return view('manufacturings.edit', compact('manufacturing'));
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            ['name' => ['required', 'max:255']]
        );

        try {
            $data = $request->only('name', 'translations');
            $data['translations'] = !empty($data['translations']) ? $data['translations'] : [];
            DB::beginTransaction();
            $manufacturer = Manufacturer::find($id);
            $manufacturer->update([
                "name" => $data["name"],
                "translations" => $data["translations"]
            ]);
            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        return redirect()->back()->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Manufacturer::find($id)->delete();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        return $output;
    }
}
