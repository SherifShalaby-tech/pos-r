<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Manufacturing;
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
        $quick_add = request()->quick_add ?? null;
        $type = request()->type ?? null;
        $product_classes = ProductClass::orderBy('name', 'asc')->pluck('name', 'id');

        return view('manufacturers.create')->with(compact(
            'type',
            'quick_add',
            'product_classes'
        ));
    }
    public function used($id=null)
    {
        $recipe = Recipe::find($id);
        if(!$recipe && Recipe::first()){
            $recipe = Recipe::first();

        }elseif(!$recipe){
            $output = [
                'success' => false,
                'msg' =>__('lang.error_recipe')
            ];
            return redirect()->back()->with('status', $output);


        }
        // return $recipe->id;
        $raw_materials  = Product::where('is_raw_material', 1)->orderBy('name', 'asc')->pluck('name', 'id');
        $raw_material_units  = Unit::orderBy('name', 'asc')->pluck('name', 'id');
        $recipes=  DB::table('recipes')
            ->join('products','products.id','recipes.material_id')
            ->join('variations','products.id','variations.product_id')
            ->select('recipes.id','recipes.name','products.name as product_name','variations.name as variation_name')
            ->get();
        $stores = Store::getDropdown();
        $manufacturers = Manufacturer::getDropdown();


        return view('manufacturings.used')
            ->with(compact(
                'recipe',
                'raw_materials',
                'stores',
                'recipes',
                'manufacturers',
                'raw_material_units',
            ));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'store_id' => ['required', 'numeric',Rule::exists(Store::class,'id')],
                'manufacturer_id' => ['required', 'numeric',Rule::exists(Manufacturer::class,'id')],
                'recipe_id' => ['required', 'numeric',Rule::exists(Recipe::class,'id')],
                'quantity_product' => ['required', 'numeric'],
            ]
        );
        try {

            $data = $request->only('store_id', 'manufacturer_id','recipe_id', 'quantity_product');
            $data["created_by"]=auth()->id();
            DB::beginTransaction();
            $manufacturing = Manufacturing::firstOrCreate($data);
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
        return  $output;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        $product_classes = ProductClass::orderBy('name', 'asc')->pluck('name', 'id');
        return view('manufacturers.edit')->with(compact(
            'manufacturer',
            'product_classes'
        ));
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
     * @param  int  $id
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
