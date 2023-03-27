<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\Grade;
use App\Models\Manufacturer;
use App\Models\Manufacturing;
use App\Models\manufacturingProduct;
use App\Models\Product;
use App\Models\ProductClass;
use App\Models\ProductStore;
use App\Models\Recipe;
use App\Models\Size;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use App\Utils\ProductUtil;
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
    protected $productUtil;

    public function __construct(Util $commonUtil, ProductUtil $productUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->productUtil = $productUtil;
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
//        $products =all();
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        $po_nos = Transaction::where('type', 'purchase_order')->where('status', '!=', 'received')->pluck('po_no', 'id');
        $status_array = $this->commonUtil->getPurchaseOrderStatusArray();
        $payment_status_array = $this->commonUtil->getPaymentStatusArray();
        $payment_type_array = $this->commonUtil->getPaymentTypeArray();
        $payment_types = $payment_type_array;
        $taxes = Tax::pluck('name', 'id');
        $variation_id = request()->get('variation_id');
        $product_id = request()->get('product_id');
        $is_raw_material = request()->segment(1) == 'raw-material' ? true : false;
        $product_classes = ProductClass::orderBy('name', 'asc')->pluck('name', 'id');
        $categories = Category::whereNull('parent_id')->orderBy('name', 'asc')->pluck('name', 'id');
        $sub_categories = Category::whereNotNull('parent_id')->orderBy('name', 'asc')->pluck('name', 'id');
        $brands = Brand::orderBy('name', 'asc')->pluck('name', 'id');
        $units = Unit::orderBy('name', 'asc')->pluck('name', 'id');
        $colors = Color::orderBy('name', 'asc')->pluck('name', 'id');
        $sizes = Size::orderBy('name', 'asc')->pluck('name', 'id');
        $grades = Grade::orderBy('name', 'asc')->pluck('name', 'id');
        $taxes_array = Tax::orderBy('name', 'asc')->pluck('name', 'id');
        $customer_types = CustomerType::orderBy('name', 'asc')->pluck('name', 'id');
        $discount_customer_types = Customer::getCustomerTreeArray();
        $exchange_rate_currencies = $this->commonUtil->getCurrenciesExchangeRateArray(true);
        $stores = Store::getDropdown();
        $users = User::Notview()->pluck('name', 'id');
        $stores = Store::getDropdown();
        $manufacturers = Manufacturer::getDropdown();


        return view('manufacturings.create')
            ->with(compact(
                'stores',
                'manufacturers',
                'is_raw_material',
                'suppliers',
                'status_array',
                'payment_status_array',
                'payment_type_array',
                'stores',
                'variation_id',
                'product_id',
                'po_nos',
                'taxes',
                'product_classes',
                'payment_types',
                'payment_status_array',
                'categories',
                'sub_categories',
                'brands',
                'units',
                'colors',
                'sizes',
                'grades',
                'taxes_array',
                'customer_types',
                'exchange_rate_currencies',
                'discount_customer_types',
                'users',
            ));
    }


    public function store(Request $request)
    {
//        dd($request->all());
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
            $manufacturing = Manufacturing::create($data);
            foreach ($request->product_quentity as $key => $product_quentity) {
                $product = Product::find($key);
                $product->product_stores->first()->decrement("qty_available", $product_quentity["quantity"]);
                $manufacturingProducts = manufacturingProduct::create([
                    "manufacturing_id" => $manufacturing->id,
                    "product_id" => $key,
                    "quantity" => $product_quentity["quantity"],
                ]);
            }

            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
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

    public function getReceivedProductsPage($id)
    {
        $manufacturing = Manufacturing::findOrFail($id);
        $store = Store::where("id", $manufacturing->store_id)->first();
        $manufacturer = Manufacturer::where("id", $manufacturing->manufacturer_id)->first();
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $po_nos = Transaction::where('type', 'purchase_order')->where('status', '!=', 'received')->pluck('po_no', 'id');
        $status_array = $this->commonUtil->getPurchaseOrderStatusArray();
        $payment_status_array = $this->commonUtil->getPaymentStatusArray();
        $payment_type_array = $this->commonUtil->getPaymentTypeArray();
        $payment_types = $payment_type_array;
        $taxes = Tax::pluck('name', 'id');
        $variation_id = request()->get('variation_id');
        $product_id = request()->get('product_id');
        $is_raw_material = request()->segment(1) == 'raw-material' ? true : false;
        $product_classes = ProductClass::orderBy('name', 'asc')->pluck('name', 'id');
        $categories = Category::whereNull('parent_id')->orderBy('name', 'asc')->pluck('name', 'id');
        $sub_categories = Category::whereNotNull('parent_id')->orderBy('name', 'asc')->pluck('name', 'id');
        $brands = Brand::orderBy('name', 'asc')->pluck('name', 'id');
        $units = Unit::orderBy('name', 'asc')->pluck('name', 'id');
        $colors = Color::orderBy('name', 'asc')->pluck('name', 'id');
        $sizes = Size::orderBy('name', 'asc')->pluck('name', 'id');
        $grades = Grade::orderBy('name', 'asc')->pluck('name', 'id');
        $taxes_array = Tax::orderBy('name', 'asc')->pluck('name', 'id');
        $customer_types = CustomerType::orderBy('name', 'asc')->pluck('name', 'id');
        $discount_customer_types = Customer::getCustomerTreeArray();
        $exchange_rate_currencies = $this->commonUtil->getCurrenciesExchangeRateArray(true);
        $stores = Store::getDropdown();
        $users = User::Notview()->pluck('name', 'id');

        return view('manufacturings.receivedProductsPage')
            ->with(compact(
                'store',
                'manufacturer',
                'manufacturing',
                'is_raw_material',
                'suppliers',
                'status_array',
                'payment_status_array',
                'payment_type_array',
                'stores',
                'variation_id',
                'product_id',
                'po_nos',
                'taxes',
                'product_classes',
                'payment_types',
                'payment_status_array',
                'categories',
                'sub_categories',
                'brands',
                'units',
                'colors',
                'sizes',
                'grades',
                'taxes_array',
                'customer_types',
                'exchange_rate_currencies',
                'discount_customer_types',
                'users',
            ));
    }

    public function postReceivedProductsPage(Request $request)
    {
        $data = $request->product_quentity;
        try {
            $manufacturing = Manufacturing::find($request->manufacturing_id);
            DB::beginTransaction();
            foreach ($data as $productId => $quantity) {
                $product = Product::find($productId);
                $product->product_stores->first()->increment("qty_available", $quantity["quantity"]);
                $manufacturingProducts = manufacturingProduct::create([
                    "status" => "1",
                    "manufacturing_id" => $manufacturing->id,
                    "product_id" => $productId,
                    "quantity" => $quantity["quantity"],
                ]);

            }

            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return $output;

    }

    public function edit($id)
    {
        $manufacturing = Manufacturing::findOrFail($id);
        $underManufacturings = manufacturingProduct::query()->where('manufacturing_id',$id)->where("status","0")->get();
        $manufactureds = manufacturingProduct::query()->where("manufacturing_id",$id)->where("status","1")->get();
        $product_ids = manufacturingProduct::query()->where("manufacturing_id",$id)->pluck("quantity","product_id")->toArray();
        return view('manufacturings.edit', compact('manufacturing','underManufacturings','manufactureds','product_ids'));
    }

    public function updates(Request $request)
    {
        $manufacturing = Manufacturing::find($request->manufacturing_id);
        try {
            DB::beginTransaction();
            if (isset($request->product_material_recived) && is_array($request->product_material_recived) && count($request->product_material_recived) > 0) {
                $deleted_product_material_recived = array_values(array_diff($manufacturing->material_recived->pluck("product_id")->toArray(), array_keys($request->product_material_recived)));
                if (isset($deleted_product_material_recived) && is_array($deleted_product_material_recived) && count($deleted_product_material_recived) > 0) {
                    foreach ($deleted_product_material_recived as $deleted_product_id) {
                        $manufacturingDeletedProduct = manufacturingProduct::query()->where("manufacturing_id", $manufacturing->id)->where("product_id", $deleted_product_id)->where("status", "1")->first();
                        $product = Product::find($deleted_product_id);
                        $product->product_stores->first()->increment("qty_available", $manufacturingDeletedProduct->quantity);
                        $manufacturingDeletedProduct->delete();
                    }
                }
                foreach ($request->product_material_recived as $product_id => $material_recived) {
                    $manufacturingProduct = manufacturingProduct::query()->where("manufacturing_id", $manufacturing->id)->where("product_id", $product_id)->where("status", $material_recived["status"])->first();
                    $product = Product::find($product_id);
                    $manufacturingProductOldQuantity = $manufacturingProduct->quantity;
                    $manufacturingProductNewQuantity = (double)$material_recived["quantity"];
                    if ($manufacturingProductOldQuantity < $manufacturingProductNewQuantity) {
                        $increased = $manufacturingProductNewQuantity - $manufacturingProductOldQuantity;
                        $manufacturingProduct->update(["quantity" => $manufacturingProductNewQuantity]);
                        $product->product_stores->first()->increment("qty_available", $increased);
                    } else {
                        $decreased = $manufacturingProductOldQuantity - $manufacturingProductNewQuantity;
                        $manufacturingProduct->update(["quantity" => $manufacturingProductNewQuantity]);
                        $product->product_stores->first()->decrement("qty_available", $decreased);
                    }
                }
            }
            if (isset($request->product_material_under_manufactured) && is_array($request->product_material_under_manufactured) && count($request->product_material_under_manufactured) > 0) {
                $deleted_product_material_under_manufactured = array_values(array_diff($manufacturing->materials->pluck("product_id")->toArray(), array_keys($request->product_material_under_manufactured)));
                if (isset($deleted_product_material_under_manufactured) && is_array($deleted_product_material_under_manufactured) && count($deleted_product_material_under_manufactured) > 0) {
                    foreach ($deleted_product_material_under_manufactured as $deleted_product_id) {
                        $manufacturingDeletedProduct = manufacturingProduct::query()->where("manufacturing_id", $manufacturing->id)->where("product_id", $deleted_product_id)->where("status", "1")->first();
                        $product = Product::find($deleted_product_id);
                        $product->product_stores->first()->increment("qty_available", $manufacturingDeletedProduct->quantity);
                        $manufacturingDeletedProduct->delete();
                    }
                }
                foreach ($request->product_material_under_manufactured as $p_id => $material_under_manufactured) {
                    $manufacturingProduct = manufacturingProduct::query()->where("manufacturing_id", $manufacturing->id)->where("product_id", $p_id)->where("status", $material_under_manufactured["status"])->first();
                    $product = Product::find($p_id);
                    $manufacturingProductOldQuantity = $manufacturingProduct->quantity;
                    $manufacturingProductNewQuantity = $material_under_manufactured["quantity"];
                    $ProductStock = $product->product_stores->pluck("qty_available")->first();
                    if ($manufacturingProductNewQuantity  < ($ProductStock+$manufacturingProductNewQuantity)) {
                        if ($manufacturingProductNewQuantity < $manufacturingProductOldQuantity){
                            $increased = $manufacturingProductOldQuantity - $manufacturingProductNewQuantity;
                            $product->product_stores->first()->increment("qty_available", $increased);
                        }else if ($manufacturingProductNewQuantity > $manufacturingProductOldQuantity && $manufacturingProductNewQuantity < ($ProductStock+$manufacturingProductOldQuantity)){
                            $decreased = $manufacturingProductNewQuantity - $manufacturingProductOldQuantity;
                            $product->product_stores->first()->decrement("qty_available", $decreased);

                        }else{
                            // error new value out of stock
                        }
                    } else {
                        // error new value out of stock
                    }
                }
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

    public function addProductRow(Request $request)
    {
        if ($request->ajax()) {
            $currency_id = $request->currency_id;
            $currency = Currency::find($currency_id);
            $exchange_rate = $this->commonUtil->getExchangeRateByCurrency($currency_id, $request->store_id);
            $product_id = $request->input('product_id');
            $variation_id = $request->input('variation_id');
            $store_id = $request->input('store_id');

            if (!empty($product_id)) {
                $index = $request->input('row_count');
                $products = $this->productUtil->getDetailsFromProduct($product_id, $variation_id, $store_id);
                return view('manufacturings.partials.product_row')
                    ->with(compact('products', 'index', 'currency', 'exchange_rate'));
            }
        }
    }

    public function add_product_stock(Request $request)
    {
        if ($request->ajax()) {
            $currency_id = $request->currency_id;
            $currency = Currency::find($currency_id);
            $exchange_rate = $this->commonUtil->getExchangeRateByCurrency($currency_id, $request->store_id);
            $product_id = $request->input('product_id');
            $variation_id = $request->input('variation_id');
            $store_id = $request->input('store_id');

            if (!empty($product_id)) {
                $index = $request->input('row_count');
                $products = $this->productUtil->getDetailsFromProduct($product_id, $variation_id, $store_id);
                return view('manufacturings.partials.product_row_add_to_stock')
                    ->with(compact('products', 'index', 'currency', 'exchange_rate'));
            }
        }
    }

    public function destroy($id)
    {
        try {
            $manufacturing = Manufacturing::find($id);
            if (isset($manufacturing->material_recived)  && count($manufacturing->material_recived) > 0) {
                    foreach ($manufacturing->material_recived as $deleted_product) {
                        $product = Product::find($deleted_product->product_id);
//                        $product->product_stores->first()->increment("qty_available", $deleted_product->quantity);
//                        $deleted_product->delete();
                    }
            }

            if (isset($manufacturing->materials)  && count($manufacturing->materials) > 0) {
                    foreach ($manufacturing->materials as $deleted_product) {
                        $product = Product::find($deleted_product->product_id);
//                        $product->product_stores->first()->increment("qty_available", $deleted_product->quantity);
//                        $deleted_product->delete();
                    }
            }
//            $manufacturing->delete();
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
