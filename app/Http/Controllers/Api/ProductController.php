<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Grade;
use App\Models\Product;
use App\Models\ProductClass;
use App\Models\ProductStore;
use App\Models\Size;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Variation;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    /**
     * All Utils instance.
     *
     */
    protected $commonUtil;
    protected $productUtil;

    /**
     * Constructor
     *
     * @param transactionUtil $transactionUtil
     * @param Util $commonUtil
     * @param ProductUtils $productUtil
     * @return void
     */
    public function __construct(Util $commonUtil, ProductUtil $productUtil, TransactionUtil $transactionUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::where('is_raw_material', 0)->get();
        return $this->handleResponse(ProductResource::collection($product), 'Products have been retrieved!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->handleError($validator->errors());
        }

        try {
            $product_data = [
                'name' => $input['name'],
                'translations' => $input['translations'],
                'product_class_id' => $input['product_class_id'],
                'product_details' => $input['product_details'],
                'purchase_price' => $input['purchase_price'],
                'sell_price' => $input['sell_price'],
                'discount_type' => $input['discount_type'],
                'discount' => $input['discount'],
                'discount_start_date' => $input['discount_start_date'],
                'discount_end_date' => $input['discount_end_date'],
                'type' => $input['type'],
                'active' => $input['active'],
                'created_by' => 1
            ];

            DB::beginTransaction();
            $product = Product::create($product_data);

            if (!empty($input['image'])) {
                $product->addMediaFromUrl($input['image'])->toMediaCollection('product');
            }

            $v = $input['variations'];

            foreach ($v as $vv) {
                $variation_data = $vv;
                $variation_data['restaurant_model_id'] = $vv['id'];
                $variation_data['product_id'] = $product->id;

                if (!empty($vv['size']['pos_model_id'])) {
                    $size = Size::where('id', $vv['size']['pos_model_id'])->first();
                    $variation_data['size_id'] = !empty($size)  ? $size->id : null;
                }
                unset($vv['id']);
                Variation::create($variation_data);
            }

            DB::commit();

            return $this->handleResponse(new ProductResource($product), 'Product created!');
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            return $this->handleError($e->getMessage(), [__('lang.something_went_wrong')], 503);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function savePoductOut(Request $request)
    {
        $products = $request->products;
        try {
            DB::beginTransaction();
            foreach ($products as $product){
                $old_product =  Product::where('parent_branch_id',$product['id'])->first();
                if(!$old_product){
                    $product_class_id=null;
                    if($product['product_class_id'] != null){
                        $product_class= ProductClass::where('name',$product['product_class']['name'])->first();
                        if(!$product_class){
                            $product_class= ProductClass::create([
                                "name" => $product['product_class']['name'],
                                "description" => $product['product_class']['description'],
                                "sort" => $product['product_class']['sort'],
                                "status" => $product['product_class']['status'],
                                "translations" => $product['product_class']['translations'],
                            ]);
                        }
                        $product_class_id=$product_class->id;
                    }
                    $category_id=null;
                    if($product['category_id'] != null){
                        $product_category= Category::where('name',$product['category']['name'])->first();
                        if(!$product_category){
                            $product_category= Category::create([
                                "name" => $product['category']['name'],
                                "description" => $product['category']['description'],
                                "product_class_id" => $product_class_id,
                                "parent_id" => null,
                                "translations" => $product['category']['translations'],
                            ]);
                        }
                        $category_id=$product_category->id;
                    }
                    $sub_category_id=null;
                    if($product['sub_category_id'] != null){
                        $product_sub_category= Category::where('name',$product['sub_category']['name'])->first();
                        if(!$product_sub_category){
                            $product_sub_category= Category::create([
                                "name" => $product['sub_category']['name'],
                                "description" => $product['sub_category']['description'],
                                "product_class_id" => $product_class_id,
                                "parent_id" => $category_id,
                                "translations" => $product['sub_category']['translations'],
                            ]);
                        }
                        $sub_category_id=$product_sub_category->id;
                    }

                    $brand_id=null;
                    if($product['brand_id'] != null){
                        $product_brand= Brand::where('name',$product['brand']['name'])->first();
                        if(!$product_brand){
                            $product_brand= Brand::create([
                                "name" => $product['brand']['name'],
                                "category_id" => $category_id,
                            ]);
                        }
                        $brand_id=$product_brand->id;
                    }
                    $alert_quantity_unit_id=null;
                    if($product['alert_quantity_unit_id'] != null){
                        $product_alert_quantity_unit= Unit::where('name',$product['alert_quantity_unit']['name'])->first();
                        if(!$product_alert_quantity_unit){
                            $product_alert_quantity_unit= Unit::create([
                                "name" => $product['alert_quantity_unit']['name'],
                                'description'=> $product['alert_quantity_unit']['description'],
                                'is_active'=> $product['alert_quantity_unit']['is_active'],
                                'base_unit_id'=> $product['alert_quantity_unit']['base_unit_id'],
                                'base_unit_multiplier'=> $product['alert_quantity_unit']['base_unit_multiplier'],
                                'is_raw_material_unit'=> $product['alert_quantity_unit']['is_raw_material_unit'],
                                'parent_id'=> $product['alert_quantity_unit']['parent_id']
                            ]);
                        }
                        $alert_quantity_unit_id=$product_alert_quantity_unit->id;
                    }
                    $product_units=[];
                    foreach ($product['units'] as $unit) {
                        $old_unit= Unit::where('name',$unit['name'])->first();
                        if(!$old_unit){
                            $old_unit= Unit::create([
                                "name" => $unit['name'],
                                'description'=> $unit['description'],
                                'is_active'=> $unit['is_active'],
                                'base_unit_id'=> $unit['base_unit_id'],
                                'base_unit_multiplier'=> $unit['base_unit_multiplier'],
                                'is_raw_material_unit'=> $unit['is_raw_material_unit'],
                                'parent_id'=> $unit['parent_id']
                            ]);
                        }
                        array_push($product_units,$old_unit->id);
                    }
                    $product_colors=[];
                    foreach ($product['colors'] as $color) {
                        $old_color= Color::where('name',$color['name'])->first();
                        if(!$old_color){
                            $old_color= Color::create([
                                "name" => $color['name'],
                                "color_hex" => $color['color_hex']
                            ]);
                        }
                        array_push($product_colors,$old_color->id);
                    }
                    $product_sizes=[];
                    foreach ($product['sizes'] as $size) {
                        $old_size= Size::where('name',$size['name'])->first();
                        if(!$old_size){
                            $old_size= Size::create([
                                "name" => $size['name'],
                                "size_code" => $size['size_code']
                            ]);
                        }
                        array_push($product_sizes,$old_size->id);
                    }
                    $product_grades=[];
                    foreach ($product['grades'] as $grade) {
                        $old_grade= Grade::where('name',$grade['name'])->first();
                        if(!$old_grade){
                            $old_grade= Grade::create([
                                "name" => $grade['name']
                            ]);
                        }
                        array_push($product_grades,$old_grade->id);
                    }

                    $tax_id=null;
                    if($product['tax_id'] != null){
                        $product_tax= Tax::where('name',$product['tax']['name'])->first();
                        if(!$product_tax){
                            $product_tax= Tax::create([
                                "name" => $product['tax']['name'],
                                "rate" => $product['tax']['rate'],
                                "type" => $product['tax']['type'],
                                "tax_method" => $product['tax']['tax_method']
                            ]);
                        }
                        $tax_id=$product_tax->id;
                    }



                    $data_product=[
                        'parent_branch_id'=>  $product['id'],
                        'name'=>  $product['name'],
                        'translations'=>  $product['translations'],
                        'product_class_id'=>  $product_class_id,
                        'category_id'=>  $category_id,
                        'sub_category_id'=>  $sub_category_id,
                        'brand_id'=>  $brand_id,
                        'sku'=>  $product['sku'],
                        'multiple_units'=>  $product_units,
                        'multiple_colors'=>  $product_colors,
                        'multiple_sizes'=>  $product_sizes,
                        'multiple_grades'=>  $product_grades,
                        'is_service'=>  $product['is_service'],
                        'product_details'=>  $product['product_details'],
                        'barcode_type'=>  $product['barcode_type'],
                        'alert_quantity'=>  $product['alert_quantity'],
                        'alert_quantity_unit_id'=>  $alert_quantity_unit_id,
                        'other_cost'=>  $product['other_cost'],
                        'purchase_price'=>  $product['purchase_price'],
                        'sell_price'=>  $product['sell_price'],
                        'tax_id'=>  $tax_id,
                        'tax_method'=>  $product['tax_method'],
                        'discount_type'=>  $product['discount_type'],
                        'discount'=>  $product['discount'],
                        'discount_start_date'=>  $product['discount_start_date'],
                        'discount_end_date'=>  $product['discount_end_date'],
                        "discount_customer_types" => [],
                        "discount_customers" =>  [],
                        "show_to_customer" => $product['show_to_customer'],
                        "show_to_customer_types" => null,
                        "different_prices_for_stores" => 0,
                        "this_product_have_variant" =>$product['this_product_have_variant'],
                        'type'=>  $product['type'],
                        'active'=>  $product['active'],
                        'price_based_on_raw_material'=>  $product['price_based_on_raw_material'],
                        'is_raw_material'=>  $product['is_raw_material'],
                        'automatic_consumption'=>  $product['automatic_consumption'],
                        'buy_from_supplier'=>  $product['buy_from_supplier'],
                        'created_by'=>  Auth()->id(),
                        "edited_by" => null
                    ];
                    $old_product=Product::create($data_product);
                }
                foreach ($product['variations_with'] as $variation ){
                    $old_variation =  Variation::where('variation_branch_id',$variation['id'])->first();
                    if(!$old_variation){
                        $color_id=null;
                        if($variation['color_id'] != null){
                            $variation_color= Color::where('name',$variation['color']['name'])->first();
                            if(!$variation_color){
                                $variation_color= Color::create([
                                    "name" => $variation['color']['name'],
                                    "size_code" => $variation['color']['size_code']
                                ]);
                            }
                            $color_id=$variation_color->id;
                        }

                        $size_id=null;
                        if($variation['size_id'] != null){
                            $variation_size= Size::where('name',$variation['size']['name'])->first();
                            if(!$variation_size){
                                $variation_size= Size::create([
                                    "name" => $variation['size']['name'],
                                    "color_hex" => $variation['size']['color_hex']
                                ]);
                            }
                            $size_id=$variation_size->id;
                        }
                        $grade_id=null;
                        if($variation['grade_id'] != null){
                            $variation_grade= Grade::where('name',$variation['grade']['name'])->first();
                            if(!$variation_grade){
                                $variation_grade= Grade::create([
                                    "name" => $variation['grade']['name']
                                ]);
                            }
                            $grade_id=$variation_grade->id;
                        }
                        $unit_id=null;
                        if($variation['unit_id'] != null){
                            $variation_unit= Unit::where('name',$variation['unit']['name'])->first();
                            if(!$variation_unit){
                                $variation_unit= Grade::create([
                                    "name" => $variation['unit']['name'],
                                    'description'=> $variation['unit']['description'],
                                    'is_active'=> $variation['unit']['is_active'],
                                    'base_unit_id'=> $variation['unit']['base_unit_id'],
                                    'base_unit_multiplier'=> $variation['unit']['base_unit_multiplier'],
                                    'is_raw_material_unit'=> $variation['unit']['is_raw_material_unit'],
                                    'parent_id'=> $variation['unit']['parent_id']
                                ]);
                            }
                            $unit_id=$variation_unit->id;
                        }
                        $data_variation=[
                            "variation_branch_id" => $variation['id'],
                            "name" => $variation['name'],
                            "sub_sku" =>$variation['name'],
                            "product_id" => $old_product->id,
                            "color_id" => $color_id,
                            "size_id" => $size_id,
                            "grade_id" => $grade_id,
                            "unit_id" => $unit_id,
                            "default_purchase_price"=>$variation['default_purchase_price'],
                            "default_sell_price"=>$variation['default_sell_price'],
                            "is_dummy"=>$variation['is_dummy'],
                            "restaurant_model_id"=>$variation['restaurant_model_id'],
                            "number_vs_base_unit"=>$variation['number_vs_base_unit']?:0
                        ];
                        Variation::create($data_variation);
                    }


                }
            }
            DB::commit();
            return $this->handleResponse([], 'Product deleted!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            return $this->handleError($e->getMessage(), [__('lang.something_went_wrong')], 503);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->handleError('Product not found!');
        }
        return $this->handleResponse(new ProductResource($product), 'Product retrieved.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->handleError($validator->errors());
        }
        try {
            $product_data = [
                'name' => $input['name'],
                'translations' => $input['translations'],
                'product_class_id' => $input['product_class_id'],
                'product_details' => $input['product_details'],
                'purchase_price' => $input['purchase_price'],
                'sell_price' => $input['sell_price'],
                'discount_type' => $input['discount_type'],
                'discount' => $input['discount'],
                'discount_start_date' => $input['discount_start_date'],
                'discount_end_date' => $input['discount_end_date'],
                'type' => $input['type'],
                'active' => $input['active'],
            ];

            DB::beginTransaction();
            $product = Product::where('id', $id)->first();
            $product->update($product_data);

            if (!empty($input['image'])) {
                $product->addMediaFromUrl($input['image'])->toMediaCollection('product');
            }

            $v = $input['variations'];

            foreach ($v as $vv) {
                $variation_data = $vv;
                $variation_data['restaurant_model_id'] = $vv['id'];
                $variation_data['product_id'] = $product->id;

                if (!empty($vv['size']['pos_model_id'])) {
                    $size = Size::where('id', $vv['size']['pos_model_id'])->first();
                    $variation_data['size_id'] = !empty($size)  ? $size->id : null;
                }
                unset($vv['id']);
                if (!empty($vv['pos_model_id'])) {
                    $variation = Variation::where('id', $vv['pos_model_id'])->first();
                    $variation->update($variation_data);
                } else {
                    Variation::create($variation_data);
                }
            }
            DB::commit();

            return $this->handleResponse(new ProductResource($product), 'Product successfully updated!');
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            return $this->handleError($e->getMessage(), [__('lang.something_went_wrong')], 503);
        }
    }
    public function update_requst(Request $request, $id)
    {
        $product = Product::find($id);
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->handleError($validator->errors());
        }
        try {
            $discount_customers = $this->getDiscountCustomerFromType($request->discount_customer_types);
            $product_data = [
                'name' => $request->name,
                'translations' => !empty($request->translations) ? $request->translations : [],
                'product_class_id' => $request->product_class_id,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'brand_id' => $request->brand_id,
                'sku' => $request->sku,
                'multiple_units' => $request->multiple_units,
                'multiple_colors' => $request->multiple_colors,
                'multiple_sizes' => $request->multiple_sizes,
                'multiple_grades' => $request->multiple_grades,
                'is_service' => !empty($request->is_service) ? 1 : 0,
                'product_details' => $request->product_details,
                'barcode_type' => $request->barcode_type ?? 'C128',
                'alert_quantity' => $request->alert_quantity,
                'other_cost' => !empty($request->other_cost) ? $this->commonUtil->num_uf($request->other_cost) : 0,
                'purchase_price' => $this->commonUtil->num_uf($request->purchase_price),
                'sell_price' => $this->commonUtil->num_uf($request->sell_price),
                'tax_id' => $request->tax_id,
                'tax_method' => $request->tax_method,
                'discount_type' => $request->discount_type,
                'discount_customer_types' => $request->discount_customer_types,
                'discount_customers' => $discount_customers,
                'discount' => $this->commonUtil->num_uf($request->discount),
                'discount_start_date' => !empty($request->discount_start_date) ? $this->commonUtil->uf_date($request->discount_start_date) : null,
                'discount_end_date' => !empty($request->discount_end_date) ? $this->commonUtil->uf_date($request->discount_end_date) : null,
                'show_to_customer' => !empty($request->show_to_customer) ? 1 : 0,
                'show_to_customer_types' => $request->show_to_customer_types,
                'different_prices_for_stores' => !empty($request->different_prices_for_stores) ? 1 : 0,
                'this_product_have_variant' => !empty($request->this_product_have_variant) ? 1 : 0,
                'price_based_on_raw_material' => !empty($request->price_based_on_raw_material) ? 1 : 0,
                'automatic_consumption' => !empty($request->automatic_consumption) ? 1 : 0,
                'buy_from_supplier' => !empty($request->buy_from_supplier) ? 1 : 0,
                'type' => !empty($request->this_product_have_variant) ? 'variable' : 'single',
                'active' => !empty($request->active) ? 1 : 0,
                'edited_by' => Auth::user()->id,
            ];

            DB::beginTransaction();
            $product = Product::where('parent_branch_id',$id)->first();

            $product->update($product_data);


            $variations = $request->variations;
            $keey_variations = [];
            if (!empty($variations)) {
                foreach ($variations as $v) {
                    $c = Variation::where('product_id', $product->id)
                            ->count() + 1;
                    if ($v['name'] == 'Default') {
                        $sub_sku = $product->sku;
                    } else {
                        $sub_sku = !empty($v['sub_sku']) ? $v['sub_sku'] : $this->productUtil->generateSubSku($product->sku, $c, $product->barcode_type);
                    }

                    if (!empty($v['id'])) {
                        $v['default_purchase_price'] = (float)$this->commonUtil->num_uf($v['default_purchase_price']);
                        $v['default_sell_price'] = (float)$this->commonUtil->num_uf($v['default_sell_price']);
                        $variation = Variation::where('variation_branch_id',$v['id'])->first();
                        $variation->name = $v['name'];
                        $variation->sub_sku = $sub_sku;
                        $variation->color_id = $v['color_id'] ?? null;
                        $variation->size_id = $v['size_id'] ?? null;
                        $variation->grade_id = $v['grade_id'] ?? null;
                        $variation->unit_id = $v['unit_id'] ?? null;
                        $variation->number_vs_base_unit= $v['number_vs_base_unit'] ?? 0;
                        $variation->default_purchase_price = !empty($v['default_purchase_price']) ? $this->commonUtil->num_uf($v['default_purchase_price']) : $this->commonUtil->num_uf($product->purchase_price);
                        $variation->default_sell_price = !empty($v['default_sell_price']) ? $this->commonUtil->num_uf($v['default_sell_price']) : $this->commonUtil->num_uf($product->sell_price);

                        $variation->save();
                        $variation_array[] = ['variation' => $variation, 'variant_stores' => $v['variant_stores']];
                        $keey_variations[] = $variation->id;
                    } else {
                        $variation_data['name'] = $v['name'];
                        $variation_data['product_id'] = $product->id;
                        $variation_data['sub_sku'] = !empty($v['sub_sku']) ? $v['sub_sku'] : $this->productUtil->generateSubSku($product->sku, $c, $product->barcode_type);
                        $variation_data['color_id'] = $v['color_id'] ?? null;
                        $variation_data['size_id'] = $v['size_id'] ?? null;
                        $variation_data['grade_id'] = $v['grade_id'] ?? null;
                        $variation_data['unit_id'] = $v['unit_id'] ?? null;
                        $variation_data['number_vs_base_unit']= $v['number_vs_base_unit'] ?? 0;
                        $variation_data['default_purchase_price'] = !empty($v['default_purchase_price']) ? $this->commonUtil->num_uf($v['default_purchase_price']) : $this->commonUtil->num_uf($product->purchase_price);
                        $variation_data['default_sell_price'] = !empty($v['default_sell_price']) ? $this->commonUtil->num_uf($v['default_sell_price']) : $this->commonUtil->num_uf($product->sell_price);
                        $variation_data['is_dummy'] = 0;

                        $variation = Variation::create($variation_data);
                        $variation_array[] = ['variation' => $variation, 'variant_stores' => $v['variant_stores']];
                        $keey_variations[] = $variation->id;
                    }
                }
            } else {
                $variation_data['name'] = 'Default';
                $variation_data['product_id'] = $product->id;
                $variation_data['sub_sku'] = $product->sku;
                $variation_data['color_id'] = !empty($request->multiple_colors) ? $request->multiple_colors[0] : null;
                $variation_data['size_id'] = !empty($request->multiple_sizes) ? $request->multiple_sizes[0] : null;
                $variation_data['grade_id'] = !empty($request->multiple_grades) ? $request->multiple_grades[0] : null;
                $variation_data['unit_id'] = !empty($request->multiple_units) ? $request->multiple_units[0] : null;

                $variation_data['is_dummy'] = 1;
                $variation_data['default_purchase_price'] = $this->commonUtil->num_uf($product->purchase_price);
                $variation_data['default_sell_price'] = $this->commonUtil->num_uf($product->sell_price);

                $variation = Variation::create($variation_data);
                $variation_array[] = ['variation' => $variation, 'variant_stores' =>  []];
                $keey_variations[] = $variation->id;
            }

            if (!empty($keey_variations)) {
                //delete the variation removed by user
                Variation::where('product_id', $product->id)->whereNotIn('id', $keey_variations)->delete();
                ProductStore::where('product_id', $product->id)->whereNotIn('variation_id', $keey_variations)->delete();
            }
            foreach ($variation_array as $array) {
                $this->productUtil->createOrUpdateProductStore($product, $array['variation'], $request, $array['variant_stores']);
            }


            if (!empty($request->consumption_details)) {
                $variations = $product->variations()->get();
                foreach ($variations as $variation) {
                    $this->productUtil->createOrUpdateRawMaterialToProduct(
                        $variation->id, $request->consumption_details);
                }
            }
            if (!empty($request->extension_details)) {
                $variations = $product->variations()->get();
                foreach ($variations as $variation) {
                    $this->productUtil->createOrUpdateExtensionToProduct(
                        $variation->id,
                        $request->extension_details);
                }

            }
            if ($request->getFirstMediaUrl_re) {
                $product->clearMediaCollection('product');
                $product->addMediaFromUrl($request->getFirstMediaUrl_re)->toMediaCollection('product');

            }
            DB::commit();

            return $this->handleResponse(new ProductResource($product), 'Product successfully updated!');
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            return $this->handleError($e->getMessage(), [__('lang.something_went_wrong')], 503);
        }
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
            $product = Product::find($id);
            Variation::where('product_id', $id)->delete();
            $product->delete();
            return $this->handleResponse([], 'Product deleted!');
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            return $this->handleError($e->getMessage(), [__('lang.something_went_wrong')], 503);
        }
    }
    public function delete_product($id)
    {
        try {

            $variation = Variation::where('variation_branch_id',$id)->first();
            $variation_count = Variation::where('product_id', $variation->product_id)->count();
            if ($variation_count > 1) {
                ProductStore::where('variation_id', $variation->id)->delete();
                $variation->delete();
                $output = [
                    'success' => true,
                    'msg' => __('lang.deleted')
                ];
            } else {
                ProductStore::where('product_id', $variation->product_id)->delete();
                $product = Product::where('id', $variation->product_id)->first();
                $product->clearMediaCollection('product');
                $product->delete();
                $variation->delete();
            }
            return $this->handleResponse([], 'Product deleted!');
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            return $this->handleError($e->getMessage(), [__('lang.something_went_wrong')], 503);
        }
    }

    public function getDiscountCustomerFromType($customer_types)
    {
        $discount_customers = [];
        if (!empty($customer_types)) {
            $customers = Customer::whereIn('customer_type_id', $customer_types)->get();
            foreach ($customers as $customer) {
                $discount_customers[] = $customer->id;
            }
        }

        return $discount_customers;
    }
}
