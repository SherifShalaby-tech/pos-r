<?php

namespace App\Http\Controllers;

use App\Models\AddStockLine;
use App\Models\CashRegisterTransaction;
use App\Models\ConsumptionProduction;
use App\Models\MoneySafe;
use App\Models\MoneySafeTransaction;
use App\Models\Product;
use App\Models\Production;
use App\Models\ProductStore;
use App\Models\Recipe;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\Supplier;
use App\Models\System;
use App\Models\Transaction;
use App\Models\TransactionSellLine;
use App\Models\Unit;
use App\Models\User;
use App\Models\Variation;
use App\Utils\CashRegisterUtil;
use App\Utils\MoneySafeUtil;
use App\Utils\NotificationUtil;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class RecipeController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $commonUtil;
    protected $transactionUtil;
    protected $productUtil;
    protected $notificationUtil;
    protected $cashRegisterUtil;
    protected $moneysafeUtil;
    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil, ProductUtil $productUtil, TransactionUtil $transactionUtil, NotificationUtil $notificationUtil, CashRegisterUtil $cashRegisterUtil, MoneySafeUtil $moneysafeUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
        $this->notificationUtil = $notificationUtil;
        $this->cashRegisterUtil = $cashRegisterUtil;
        $this->moneysafeUtil = $moneysafeUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::leftjoin('users', 'recipes.created_by', 'users.id')
            ->leftjoin('users as edited', 'recipes.edited_by', 'users.id')
            ->leftjoin('products', 'recipes.material_id', 'products.id')
            ->leftjoin('variations', 'variations.product_id', 'products.id')
            ->leftjoin('units', 'recipes.multiple_units', 'units.id')
            ->select(
                'recipes.*',
                'variations.name as variation_name',
                'products.name as material_name',
                'units.name as unit_name',
                'users.name as created_by_name',
                'edited.name as edited_by_name',
            )->get();
        return view('recipe.index')->with(compact(
            'recipes'
        ));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ProductionIndex()
    {
        $recipes = Production::leftjoin('users', 'productions.created_by', 'users.id')
            ->leftjoin('users as edited', 'productions.edited_by', 'edited.id')
            ->leftjoin('recipes', 'productions.recipe_id', 'recipes.id')
            ->leftjoin('products', 'recipes.material_id', 'products.id')
            ->leftjoin('variations', 'variations.product_id', 'products.id')
            ->leftjoin('units', 'recipes.multiple_units', 'units.id')
            ->select(
                'productions.*',
                'recipes.name',
                'variations.name as variation_name',
                'products.name as material_name',
                'units.name as unit_name',
                'users.name as created_by_name',
                'edited.name as edited_by_name',
            )->get();

        return view('recipe.production.index')->with(compact(
            'recipes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $quick_add = request()->quick_add ?? null;
        $is_raw_material_recipe = request()->is_raw_material_recipe ?? 0;

        $raw_materials  = Product::where('is_raw_material', 1)->orderBy('name', 'asc')->pluck('name', 'id');
        $raw_material_units  = Unit::orderBy('name', 'asc')->pluck('name', 'id');
        if ($quick_add) {
            return view('recipe.create_quick_add')->with(compact(
                'raw_materials',
                'raw_material_units'
            ));
        }
        return view('recipe.create')->with(compact(
            'raw_materials',
            'raw_material_units'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            ['name' => ['required', 'max:25']],
            ['purchase_price' => ['required', 'max:25', 'decimal']],
        );




        try {


            $data = [
                'name' => $request->name,
                'material_id' => $request->material_id,
                'multiple_units' => (int)$request->unit_id_material,
                'translations' => !empty($request->translations) ? $request->translations : [],
                'other_cost' => !empty($request->other_cost) ? $this->commonUtil->num_uf($request->other_cost) : 0,
                'purchase_price' => $this->commonUtil->num_uf($request->purchase_price),
                'quantity_product' => $this->commonUtil->num_uf($request->quantity_product),
                'price_based_on_raw_material' => !empty($request->price_based_on_raw_material) ? 1 : 0,
                'automatic_consumption' => !empty($request->automatic_consumption) ? 1 : 0,
                'active' => !empty($request->active) ? 1 : 0,
                'created_by' => Auth::user()->id
            ];

            DB::beginTransaction();
            $recipe = Recipe::create($data);
            if (!empty($request->consumption_details)) {
                $this->commonUtil->createOrUpdateRawMaterialToRecipe($recipe->id, $request->consumption_details);
            }
            DB::commit();

            $output = [
                'success' => true,
                'recipe_id' => $recipe->id,
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function used($id = null)
    {
        $recipe = Recipe::find($id);
        if (!$recipe && Recipe::first()) {
            $recipe = Recipe::first();
        } elseif (!$recipe) {
            $output = [
                'success' => false,
                'msg' => __('lang.error_recipe')
            ];
            return redirect()->back()->with('status', $output);
        }
        // return $recipe->id;
        $raw_materials  = Product::where('is_raw_material', 1)->orderBy('name', 'asc')->pluck('name', 'id');
        $raw_material_units  = Unit::orderBy('name', 'asc')->pluck('name', 'id');
        $recipes =  DB::table('recipes')
            ->join('products', 'products.id', 'recipes.material_id')
            ->join('variations', 'products.id', 'variations.product_id')
            ->select('recipes.id', 'recipes.name', 'products.name as product_name', 'variations.name as variation_name')
            ->get();
        $stores = Store::getDropdown();


        return view('recipe.production.used')
            ->with(compact(
                'recipe',
                'raw_materials',
                'stores',
                'recipes',
                'raw_material_units',
            ));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendUesd(Request $request)
    {

        try {
            $data = $request->except('_token');
            $data['po_no'] = Carbon::now()->toDateString();
            if (!empty($data['po_no'])) {
                $ref_transaction_po = Transaction::find($data['po_no']);
            }

            $supplier = Supplier::where('is_kichen', 1)->first();

            if (!$supplier) {
                $supplier = Supplier::create([
                    'name' => 'مطبخ رئيسي',
                    'company_name' => 'مطبخ رئيسي',
                    'products' => [],
                    'is_kichen' => 1
                ]);
            }
            $transaction_data = [
                'store_id' => $data['store_id'],
                'supplier_id' => $supplier->id,
                "is_raw_material" => "1",
                'type' => 'add_stock',
                'status' => 'received',
                'paying_currency_id' => System::getProperty('currency'),
                'default_currency_id' => System::getProperty('currency'),
                'exchange_rate' => $this->commonUtil->num_uf(1),
                'order_date' =>  Carbon::now(),
                'transaction_date' =>   Carbon::now(),
                'payment_status' => 'paid',
                'po_no' =>  null,
                'purchase_order_id' =>  null,
                'grand_total' => $this->productUtil->num_uf($data['sell_price']),
                'final_total' => $this->productUtil->num_uf($data['sell_price']),
                'discount_amount' =>  $this->commonUtil->num_uf(0),
                'other_payments' => $this->commonUtil->num_uf(0),
                'other_expenses' =>  $this->commonUtil->num_uf(0),
                'notes' => null,
                'details' =>  null,
                'invoice_no' =>  $this->productUtil->getNumberByType('production'),
                'due_date' =>  null,
                'notify_me' =>  0,
                'notify_before_days' =>  0,
                'created_by' => Auth::user()->id,
                'source_id' => 2,
                'source_type' => 'user',
                'is_raw_material' => 1,
            ];
            $storepos = StorePos::where('user_id', Auth::user()->id)->first();
            if (!$storepos)
                return [
                    'success' => false,
                    'msg' => __('lang.StorePosReq')
                ];

            $transaction_data_sell = [
                'store_id' => $storepos->store_id,
                'customer_id' => null,
                'store_pos_id' => $storepos->id,
                'exchange_rate' => 1,
                'default_currency_id' => System::getProperty('currency'),
                'received_currency_id' =>  System::getProperty('currency'),
                'type' => 'sell',
                'grand_total' => $this->productUtil->num_uf($data['sell_price']),
                'final_total' => $this->productUtil->num_uf($data['sell_price']),
                'gift_card_id' => null,
                'coupon_id' => null,
                'transaction_date' => Carbon::now(),
                'payment_status' => 'pending',
                'invoice_no' => $this->productUtil->getNumberByType('sell'),
                'ticket_number' => $this->transactionUtil->getTicketNumber($storepos->store_id),
                'is_direct_sale' => 0,
                'status' => 'final',
                'sale_note' =>  null,
                'staff_note' => null,
                'customer_size_id' => null,
                'fabric_name' => null,
                'fabric_squatch' =>  null,
                'prova_datetime' => null,
                'delivery_datetime' => null,
                'discount_type' => null,
                'discount_value' => $this->commonUtil->num_uf(0),
                'discount_amount' => $this->commonUtil->num_uf(0),
                'current_deposit_balance' => $this->commonUtil->num_uf(0),
                'used_deposit_balance' => $this->commonUtil->num_uf(0),
                'remaining_deposit_balance' => $this->commonUtil->num_uf(0),
                'add_to_deposit' => $this->commonUtil->num_uf(0),
                'tax_id' => null,
                'tax_method' =>  null,
                'tax_rate' => 0,
                'total_tax' => $this->commonUtil->num_uf(0),
                'total_item_tax' => $this->commonUtil->num_uf(0),
                'sale_note' =>  null,
                'staff_note' =>  null,
                'terms_and_condition_id' =>  null,
                'delivery_zone_id' =>  null,
                'manual_delivery_zone' => null,
                'deliveryman_id' => null,
                'delivery_status' => null,
                'delivery_cost' => $this->commonUtil->num_uf(0),
                'delivery_address' => null,
                'delivery_cost_paid_by_customer' => 0,
                'delivery_cost_given_to_deliveryman' =>  0,
                'dining_table_id' =>  null,
                'dining_room_id' =>  null,
                'service_fee_id' => null,
                'service_fee_rate' =>  null,
                'service_fee_value' => null,
                'commissioned_employees' =>  [],
                'shared_commission' =>  0,
                'created_by' => Auth::user()->id,
            ];
            DB::beginTransaction();
            $transaction = Transaction::create($transaction_data);
            $transaction_sell = Transaction::create($transaction_data_sell);

            $production = Production::create([
                'store_id' => $request->store_id,
                'transaction_id' => $transaction->id,
                'recipe_id' => $request->recipe_id,
                'quantity_product' => $request->quantity_product,
                'other_cost' => $request->other_cost,
                'purchase_price' => $request->purchase_price,
                'sell_price' => $request->sell_price,
                'edited_by' => null,
                'created_by' => Auth::user()->id,
            ]);
            $recipe = Recipe::whereid($request->recipe_id)->first();
            $variation = Variation::where('product_id', $recipe->material_id)->first();

            if (!empty($request->consumption_details)) {
                $this->commonUtil->createOrUpdateRawMaterialToProduction($production->id, $request->consumption_details);
                $price_one = $data['sell_price'] / $data['quantity_product'];
                $transaction_sell_line = [
                    0 => [
                        "is_service" => "0",
                        "product_id" => $variation->product_id,
                        "variation_id" => $variation->id,
                        "price_hidden" => $this->productUtil->num_uf($price_one),
                        "purchase_price" => $this->productUtil->num_uf($data['purchase_price_per_unit']),
                        "tax_id" => null,
                        "tax_method" => null,
                        "tax_rate" => "0.00",
                        "item_tax" => "0",
                        "coupon_discount" => "0",
                        "coupon_discount_type" => null,
                        "coupon_discount_amount" => "0",
                        "promotion_purchase_condition" => "0",
                        "promotion_purchase_condition_amount" => "0",
                        "promotion_discount" => "0",
                        "promotion_discount_type" => "0",
                        "promotion_discount_amount" => "0",
                        "quantity" => $this->productUtil->num_uf($data['quantity_product']),
                        "sell_price" => $this->productUtil->num_uf($price_one),
                        "product_discount_type" => "fixed",
                        "product_discount_value" => "0",
                        "product_discount_amount" => "0.00",
                        "sub_total" => $this->productUtil->num_uf($data['sell_price']),
                    ]
                ];
                $this->transactionUtil->createOrUpdateTransactionSellLine($transaction_sell, $transaction_sell_line);
                $this->transactionUtil->createOrUpdateRawMaterialConsumptionForRecipe($transaction_sell, $request->consumption_details, $recipe->automatic_consumption);
            }

            $production->transactions()->attach([$transaction->id, $transaction_sell->id]);

            $add_stock_lines = [
                0 => [
                    "is_service" => "0",
                    "product_id" => $recipe->material_id,
                    "variation_id" => $variation->id,
                    "quantity" => $request->quantity_product,
                    "purchase_price" => $request->purchase_price_per_unit,
                    "final_cost" => $request->purchase_price_per_unit,
                    "sub_total" => $request->sell_price,
                    "batch_number" => null,
                    "manufacturing_date" => null,
                    "expiry_date" => null,
                    "expiry_warning" => null,
                    "convert_status_expire" => null
                ]
            ];
            $this->productUtil->createOrUpdateAddStockLines($add_stock_lines, $transaction);


            $payment_data = [
                'transaction_id' => $transaction->id,
                'amount' => $this->commonUtil->num_uf($request->sell_price),
                'method' => 'cash',
                'paid_on' => Carbon::now(),
                'ref_number' => null,
                'source_id' => 2,
                'source_type' => 'user',
                'bank_deposit_date' =>  null,
                'bank_name' => null,
            ];
            $transaction_payment = $this->transactionUtil->createOrUpdateTransactionPayment($transaction_sell, $payment_data);


            $user_id = $request->source_id;

            if (!empty($user_id)) {
                $this->cashRegisterUtil->addPayments($transaction_sell, $payment_data, 'debit', $user_id);
            }

            $this->transactionUtil->updateTransactionPaymentStatus($transaction_sell->id);

            //update product status to active if not //added quick product from purchase order
            foreach ($transaction->add_stock_lines as $line) {
                Product::where('id', $line->product_id)->update(['active' => 1]);
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

        return  $output;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recipe = Recipe::find($id);

        $raw_materials  = Product::where('is_raw_material', 1)->orderBy('name', 'asc')->pluck('name', 'id');
        $raw_material_units  = Unit::orderBy('name', 'asc')->pluck('name', 'id');
        return view('recipe.edit')->with(compact(
            'recipe',
            'raw_materials',
            'raw_material_units',
        ));
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

        try {
            $data = [
                'name' => $request->name,
                'material_id' => $request->material_id,
                'multiple_units' => (int)$request->unit_id_material,
                'translations' => !empty($request->translations) ? $request->translations : [],
                'other_cost' => !empty($request->other_cost) ? $this->commonUtil->num_uf($request->other_cost) : 0,
                'purchase_price' => $this->commonUtil->num_uf($request->purchase_price),
                'quantity_product' => $this->commonUtil->num_uf($request->quantity_product),
                'price_based_on_raw_material' => !empty($request->price_based_on_raw_material) ? 1 : 0,
                'automatic_consumption' => !empty($request->automatic_consumption) ? 1 : 0,
                'active' => !empty($request->active) ? 1 : 0,
                'created_by' => Auth::user()->id
            ];


            DB::beginTransaction();
            $recipe =  Recipe::findOrFail($id); //where('id', $id)->update($data);
            $recipe->update($data);
            if (!empty($request->consumption_details)) {
                $this->commonUtil->createOrUpdateRawMaterialToRecipe($recipe->id, $request->consumption_details);
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
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProduction($id)
    {
        $production = Production::with('consumption_products')->find($id);
        $recipe = Recipe::where('id', $production->recipe_id)->first();


        $raw_materials  = Product::where('is_raw_material', 1)->orderBy('name', 'asc')->pluck('name', 'id');
        $raw_material_units  = Unit::orderBy('name', 'asc')->pluck('name', 'id');
        $recipes =  DB::table('recipes')
            ->join('products', 'products.id', 'recipes.material_id')
            ->join('variations', 'products.id', 'variations.product_id')
            ->select(
                'recipes.id',
                'recipes.name',
                'products.name as product_name',
                'variations.name as variation_name'
            )
            ->get();
        $stores = Store::getDropdown();
        return view('recipe.production.edit')->with(compact(
            'recipe',
            'production',
            'recipes',
            'stores',
            'raw_materials',
            'raw_material_units',
        ));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProduction(Request $request, $id)
    {
        try {

            $data = $request->except('_token');
            $data['po_no'] = Carbon::now()->toDateString();
            if (!empty($data['po_no'])) {
                $ref_transaction_po = Transaction::find($data['po_no']);
            }

            $supplier = Supplier::where('is_kichen', 1)->first();

            if (!$supplier) {
                Supplier::create([
                    'name' => 'مطبخ رئيسي',
                    'company_name' => 'مطبخ رئيسي',
                    'products' => [],
                    'is_kichen' => 1
                ]);
            }

            $production = Production::where('id', $id)->first();



            $transaction_data = [
                'store_id' => $data['store_id'],
                'supplier_id' => $supplier->id,
                'paying_currency_id' => System::getProperty('currency'),
                'default_currency_id' => System::getProperty('currency'),
                'order_date' =>  Carbon::now(),
                'transaction_date' =>   Carbon::now(),
                'grand_total' => $this->productUtil->num_uf($data['sell_price']),
                'final_total' => $this->productUtil->num_uf($data['sell_price']),
                'invoice_no' =>  $this->productUtil->getNumberByType('production'),

            ];
            $storepos = StorePos::where('user_id', Auth::user()->id)->first();
            if (!$storepos)
                return [
                    'success' => false,
                    'msg' => __('lang.StorePosReq')
                ];



            $transaction_data_sell = [
                'store_id' => $storepos->store_id,
                'store_pos_id' => $storepos->id,
                'default_currency_id' => System::getProperty('currency'),
                'received_currency_id' =>  System::getProperty('currency'),
                'grand_total' => $this->productUtil->num_uf($data['sell_price']),
                'final_total' => $this->productUtil->num_uf($data['sell_price']),
                'invoice_no' => $this->productUtil->getNumberByType('sell'),
                'ticket_number' => $this->transactionUtil->getTicketNumber($storepos->store_id),
                'discount_value' => $this->commonUtil->num_uf(0),
                'discount_amount' => $this->commonUtil->num_uf(0),
                'current_deposit_balance' => $this->commonUtil->num_uf(0),
                'used_deposit_balance' => $this->commonUtil->num_uf(0),
                'remaining_deposit_balance' => $this->commonUtil->num_uf(0),
                'add_to_deposit' => $this->commonUtil->num_uf(0),
            ];
            $recipe = Recipe::whereid($request->recipe_id)->first();
            $variation = Variation::where('product_id', $recipe->material_id)->first();

            DB::beginTransaction();
            $production->update([
                'store_id' => $request->store_id,
                'recipe_id' => $request->recipe_id,
                'quantity_product' => $request->quantity_product,
                'other_cost' => $request->other_cost,
                'purchase_price' => $request->purchase_price,
                'sell_price' => $request->sell_price,
                'edited_by' => Auth::user()->id,
            ]);
            $transaction = Transaction::wherehas('productions', function ($qu) use ($id) {
                $qu->where('productions.id', $id);
            })->where('type', 'add_stock')->first();

            $transaction_sell = Transaction::wherehas('productions', function ($qu) use ($id) {
                $qu->where('productions.id', $id);
            })->where('type', 'sell')->first();

            if ($transaction) {
                $transaction->update($transaction_data);
            }
            if ($transaction_sell) {
                $transaction_sell->update($transaction_data_sell);
            }

            if (!empty($request->consumption_details)) {
                $this->commonUtil->createOrUpdateRawMaterialToProduction($production->id, $request->consumption_details);
                $price_one = $data['sell_price'] / $data['quantity_product'];
                $transaction_sell_line_m = TransactionSellLine::where('transaction_id', $transaction_sell->id)->first();

                $transaction_sell_line = [
                    0 => [
                        "is_service" => "0",
                        "product_id" => $variation->product_id,
                        "variation_id" => $variation->id,
                        "price_hidden" => $this->productUtil->num_uf($price_one),
                        "purchase_price" => $this->productUtil->num_uf($data['purchase_price_per_unit']),
                        "tax_id" => null,
                        "tax_method" => null,
                        "tax_rate" => "0.00",
                        "item_tax" => "0",
                        "coupon_discount" => "0",
                        "coupon_discount_type" => null,
                        "coupon_discount_amount" => "0",
                        "promotion_purchase_condition" => "0",
                        "promotion_purchase_condition_amount" => "0",
                        "promotion_discount" => "0",
                        "promotion_discount_type" => "0",
                        "promotion_discount_amount" => "0",
                        "quantity" => $this->productUtil->num_uf($data['quantity_product']),
                        "sell_price" => $this->productUtil->num_uf($price_one),
                        "product_discount_type" => "fixed",
                        "product_discount_value" => "0",
                        "product_discount_amount" => "0.00",
                        "sub_total" => $this->productUtil->num_uf($data['sell_price']),
                    ]
                ];
                if ($transaction_sell_line_m)
                    $transaction_sell_line[0]['transaction_sell_line_id'] = $transaction_sell_line_m->id;



                $this->transactionUtil->createOrUpdateTransactionSellLine($transaction_sell, $transaction_sell_line);
                $this->transactionUtil->createOrUpdateRawMaterialConsumptionForRecipe($transaction_sell, $request->consumption_details, $recipe->automatic_consumption);
            }

            $add_stock_line_id =  AddStockLine::where('transaction_id', $transaction->id)->first();

            $add_stock_lines = [
                0 => [
                    "is_service" => "0",
                    "product_id" => $recipe->material_id,
                    "variation_id" => $variation->id,
                    "quantity" => $request->quantity_product,
                    "purchase_price" => $request->purchase_price_per_unit,
                    "final_cost" => $request->purchase_price_per_unit,
                    "sub_total" => $request->sell_price,
                    "batch_number" => null,
                    "manufacturing_date" => null,
                    "expiry_date" => null,
                    "expiry_warning" => null,
                    "convert_status_expire" => null
                ]
            ];
            if ($add_stock_line_id)
                $add_stock_lines[0]['add_stock_line_id'] = $add_stock_line_id->id;
            $this->productUtil->createOrUpdateAddStockLines($add_stock_lines, $transaction);


            $payment_data = [
                'transaction_id' => $transaction->id,
                'amount' => $this->commonUtil->num_uf($request->sell_price),
                'method' => 'cash',
                'paid_on' => Carbon::now(),
                'ref_number' => null,
                'source_id' => 2,
                'source_type' => 'user',
                'bank_deposit_date' =>  null,
                'bank_name' => null,
            ];
            $transaction_payment = $this->transactionUtil->createOrUpdateTransactionPayment($transaction, $payment_data);


            $user_id = $request->source_id;

            if (!empty($user_id)) {
                $this->cashRegisterUtil->addPayments($transaction, $payment_data, 'debit', $user_id);
            }




            $this->transactionUtil->updateTransactionPaymentStatus($transaction->id);



            //update product status to active if not //added quick product from purchase order
            foreach ($transaction->add_stock_lines as $line) {
                Product::where('id', $line->product_id)->update(['active' => 1]);
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

        return  $output;
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
            Recipe::find($id)->delete();
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyProduction($id)
    {
        try {
            $add_stock = Transaction::wherehas('productions', function ($qu) use ($id) {
                $qu->where('productions.id', $id);
            })->where('type', 'add_stock')->first();

            $transaction_sell = Transaction::wherehas('productions', function ($qu) use ($id) {
                $qu->where('productions.id', $id);
            })->where('type', 'sell')->first();
            $add_stock_lines = $add_stock ? $add_stock->add_stock_lines : [];
            DB::beginTransaction();
            $transaction_sell_lines = TransactionSellLine::where('transaction_id', $transaction_sell->id)->get();
            foreach ($transaction_sell_lines as $transaction_sell_line) {
                //                    if ($transaction_sell->status == 'final') {
                //                        $product = Product::find($transaction_sell_line->product_id);
                //                        if (!$product->is_service) {
                //
                //                            $this->productUtil
                //                                ->updateProductQuantityStore(
                //                                            $transaction_sell_line->product_id,
                //                                            $transaction_sell_line->variation_id, $transaction_sell->store_id,
                //                                 $transaction_sell_line->quantity - $transaction_sell_line->quantity_returned);
                //
                //                        }
                //                    }
                $transaction_sell_line->delete();
            }
            if ($add_stock->status != 'received') {
                $add_stock_lines->delete();
            } else {
                $delete_add_stock_line_ids = [];

                foreach ($add_stock_lines as $line) {
                    $delete_add_stock_line_ids[] = $line->id;
                    $this->productUtil->decreaseProductQuantity($line->product_id, $line->variation_id, $add_stock->store_id, $line->quantity);
                }

                if (!empty($delete_add_stock_line_ids)) {
                    AddStockLine::where('transaction_id', $id)->whereIn('id', $delete_add_stock_line_ids)->delete();
                }
            }
            $ConsumptionProduction = ConsumptionProduction::where('production_id', $id)->get();


            foreach ($ConsumptionProduction as $item_con) {
                $variation = Variation::where('product_id', $item_con->raw_material_id)->first();
                $this->productUtil
                    ->updateProductQuantityStore(
                        $item_con->raw_material_id,
                        $variation->id,
                        $transaction_sell->store_id,
                        $item_con->amount_used
                    );
            }
            Transaction::where('return_parent_id', $transaction_sell->id)->delete();
            Transaction::where('parent_sale_id', $transaction_sell->id)->delete();
            CashRegisterTransaction::wherein('transaction_id', [$add_stock->id, $transaction_sell->id])->delete();
            MoneySafeTransaction::where('transaction_id', $add_stock->id)->delete();
            $add_stock->delete();

            Production::find($id)->delete();
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



    /**
     * get recipe drop down list
     *
     * @return void
     */
    public function getDropdown()
    {
        $recipe = Recipe::orderBy('name', 'asc')->pluck('name', 'id');
        $recipe_dp = $this->commonUtil->createDropdownHtml($recipe, 'Please Select');

        return $recipe_dp;
    }

    /**
     * get recipe details
     *
     * @param int $id
     * @return void
     */
    public function getRecipeDetails($id)
    {
        $recipe = Recipe::find($id);
        return ['recipe' => $recipe];
    }

    /**
     * get raw material details
     *
     * @param int $raw_material_id
     * @return void
     */
    public function getRecipeDetail($raw_recipe_id)
    {
        $raw_recipe = Recipe::find($raw_recipe_id);
        $raw_materials  = Product::where('is_raw_material', 1)->orderBy('name', 'asc')->pluck('name', 'id');
        $raw_material_units  = Unit::orderBy('name', 'asc')->pluck('name', 'id');
        $view = '';
        foreach ($raw_recipe->consumption_products as $index => $consumption_product) {

            $view .=   view('recipe.partial.raw_material_row', [
                'row_id' => $index,
                'consumption_product' => $consumption_product,
                'quantity_product' => $raw_recipe->quantity_product,
                'raw_material_units' => $raw_material_units,
                'raw_materials' => $raw_materials
            ]);
        }
        return ['view' => $view, 'recipe' => $raw_recipe->toarray()];
    }
}
