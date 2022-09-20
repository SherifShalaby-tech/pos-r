<?php

namespace App\Http\Controllers;

use App\Imports\PurchaseOrderLineImport;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\Grade;
use App\Models\Product;
use App\Models\ProductClass;
use App\Models\PurchaseOrderLine;
use App\Models\Size;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use App\Models\Variation;
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
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Tag\Sup;
use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderController extends Controller
{

    /**
     * All Utils instance.
     *
     */
    protected $commonUtil;
    protected $transactionUtil;
    protected $productUtil;
    protected $notificationUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil, ProductUtil $productUtil, TransactionUtil $transactionUtil, NotificationUtil $notificationUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
        $this->notificationUtil = $notificationUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $store_id = $this->transactionUtil->getFilterOptionValues($request)['store_id'];
        $pos_id = $this->transactionUtil->getFilterOptionValues($request)['pos_id'];

        $query = Transaction::where('type', 'purchase_order')->where('status', '!=', 'draft');

        if (!empty($store_id)) {
            $query->where('transactions.store_id', $store_id);
        }
        if (!empty(request()->supplier_id)) {
            $query->where('supplier_id', request()->supplier_id);
        }
        if (!empty(request()->start_date)) {
            $query->where('transaction_date', '>=', request()->start_date);
        }
        if (!empty(request()->end_date)) {
            $query->where('transaction_date', '<=', request()->end_date);
        }
        // TODO: condition for superadmin --sent_admin and for other user as draft
        $purchase_orders = $query->get();

        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id');
        $stores = Store::getDropdown();
        $status_array = $this->commonUtil->getPurchaseOrderStatusArray();

        return view('purchase_order.index')->with(compact(
            'purchase_orders',
            'suppliers',
            'stores',
            'status_array'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id');
        $stores = Store::getDropdown();

        $po_no = $this->productUtil->getNumberByType('purchase_order');
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
        $users = User::Notview()->pluck('name', 'id');

        return view('purchase_order.create')->with(compact(
            'suppliers',
            'stores',
            'product_classes',
            'categories',
            'sub_categories',
            'brands',
            'units',
            'colors',
            'sizes',
            'grades',
            'taxes_array',
            'customer_types',
            'users',

            'po_no'
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

        try {
            $data = $request->except('_token');

            $transaction_data = [
                'store_id' => $data['store_id'],
                'supplier_id' => $data['supplier_id'],
                'type' => 'purchase_order',
                'status' => 'pending',
                'order_date' => Carbon::now(),
                'transaction_date' => Carbon::now(),
                'payment_status' => 'due',
                'po_no' => $data['po_no'],
                'grand_total' => $this->productUtil->num_uf($data['final_total']),
                'final_total' => $this->productUtil->num_uf($data['final_total']),
                'details' => $data['details'],
                'created_by' => Auth::user()->id
            ];

            if ($data['submit'] == 'sent_admin') {
                $transaction_data['status'] = 'sent_admin';
            }
            if ($data['submit'] == 'sent_supplier') {
                $transaction_data['status'] = 'sent_supplier';
            }

            DB::beginTransaction();
            $transaction = Transaction::create($transaction_data);

            $this->productUtil->createOrUpdatePurchaseOrderLines($request->purchase_order_lines, $transaction);

            if ($data['submit'] == 'sent_admin') {
                $superadmins = User::where('is_superadmin', 1)->get();
                $notification_data = [
                    'user_id' => null,
                    'transaction_id' => $transaction->id,
                    'type' => $transaction->type,
                    'status' => 'unread',
                    'created_by' => Auth::user()->id,
                ];
                foreach ($superadmins as $admin) {
                    $notification_data['user_id'] = $admin->id;
                    $this->notificationUtil->createNotification($notification_data);
                }
            }
            DB::commit();
            if ($data['submit'] == 'print') {
                $print = 'print';
                $url = action('PurchaseOrderController@show', $transaction->id) . '?print=' . $print;

                return Redirect::to($url);
            }
            if ($data['submit'] == 'sent_supplier') {
                $this->notificationUtil->sendPurchaseOrderToSupplier($transaction->id);
            }

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase_order = Transaction::find($id);

        $supplier = Supplier::find($purchase_order->supplier_id);

        return view('purchase_order.show')->with(compact(
            'purchase_order',
            'supplier'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase_order = Transaction::find($id);

        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id');
        $stores = Store::getDropdown();
        $status_array = $this->commonUtil->getPurchaseOrderStatusArray();

        return view('purchase_order.edit')->with(compact(
            'purchase_order',
            'status_array',
            'suppliers',
            'stores'
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
            $data = $request->except('_token', '_method');

            $transaction_data = [
                'store_id' => $data['store_id'],
                'supplier_id' => $data['supplier_id'],
                'type' => 'purchase_order',
                'status' => $data['status'],
                'order_date' => Carbon::now(),
                'transaction_date' => Carbon::now(),
                'payment_status' => 'due',
                'po_no' => $data['po_no'],
                'grand_total' => $this->productUtil->num_uf($data['final_total']),
                'final_total' => $this->productUtil->num_uf($data['final_total']),
                'details' => $data['details'],
                'created_by' => Auth::user()->id
            ];

            if ($data['submit'] == 'sent_admin') {
                $transaction_data['status'] = 'sent_admin';
            }
            if ($data['submit'] == 'sent_supplier') {
                $transaction_data['status'] = 'sent_supplier';
            }

            DB::beginTransaction();
            $transaction = Transaction::find($id);
            $transaction->update($transaction_data);

            $this->productUtil->createOrUpdatePurchaseOrderLines($request->purchase_order_lines, $transaction);

            if ($data['submit'] == 'sent_admin') {
                $superadmins = User::where('is_superadmin', 1)->get();
                $notification_data = [
                    'user_id' => null,
                    'transaction_id' => $transaction->id,
                    'type' => $transaction->type,
                    'status' => 'unread',
                    'created_by' => Auth::user()->id,
                ];
                foreach ($superadmins as $admin) {
                    $notification_data['user_id'] = $admin->id;
                    $this->notificationUtil->createNotification($notification_data);
                }
            }


            DB::commit();

            if ($data['submit'] == 'print') {
                $print = 'print';
                $url = action('PurchaseOrderController@show', $transaction->id) . '?print=' . $print;

                return Redirect::to($url);
            }
            if ($data['submit'] == 'sent_supplier') {
                $this->notificationUtil->sendPurchaseOrderToSupplier($transaction->id);
            }

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
            $purchase_order = Transaction::find($id)->delete();
            PurchaseOrderLine::where('transaction_id', $id)->delete();

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

    public function getProducts()
    {
//        if (request()->ajax()) {

            $term = request()->term;

            if (empty($term)) {
                return json_encode([]);
            }

            $q = Product::leftJoin(
                'variations',
                'products.id',
                '=',
                'variations.product_id'
            )->leftjoin('product_stores', 'variations.id', 'product_stores.variation_id')
                ->where(function ($query) use ($term) {
                    $query->where('products.name', 'like', '%' . $term . '%');
                    $query->orWhere('variations.name', 'like', '%' . $term . '%');
                    $query->orWhere('sku', 'like', '%' . $term . '%');
                    $query->orWhere('sub_sku', 'like', '%' . $term . '%');
                })
                ->whereNull('variations.deleted_at')
                ->where('is_service', 0)
                ->select(
                    'products.*',
                    'products.id as product_id',
                    // 'products.sku as sku',
                    'variations.id as variation_id',
                    'variations.name as variation',
                    'variations.sub_sku as sub_sku'
                );

            if (!empty(request()->store_id)) {
                $q->where('product_stores.store_id', request()->store_id);
            }
//            if (!empty(request()->is_raw_material)) {
//                $q->where('products.is_raw_material', 1);
//            } else {
//                $q->where('products.is_raw_material', 0);
//            }
            $products = $q->groupBy('variation_id')->get();

            $products_array = [];
            foreach ($products as $product) {
                $products_array[$product->product_id]['name'] = $product->name;
                $products_array[$product->product_id]['sku'] = $product->sub_sku;
                $products_array[$product->product_id]['type'] = $product->type;
                $products_array[$product->product_id]['image'] = !empty($product->getFirstMediaUrl('product')) ? $product->getFirstMediaUrl('product') : asset('/uploads/' . session('logo'));
                $products_array[$product->product_id]['variations'][]
                    = [
                        'variation_id' => $product->variation_id,
                        'variation_name' => $product->variation,
                        'sub_sku' => $product->sub_sku
                    ];
            }

            $result = [];
            $i = 1;
            $no_of_records = $products->count();
            if (!empty($products_array)) {
                foreach ($products_array as $key => $value) {
                    // if ($no_of_records > 1 && $value['type'] != 'single') {
                    //     $result[] = [
                    //         'id' => $i,
                    //         'text' => $value['name'] . ' - ' . $value['sku'],
                    //         'variation_id' => 0,
                    //         'product_id' => $key
                    //     ];
                    // }
                    $name = $value['name'];
                    foreach ($value['variations'] as $variation) {
                        $text = $name;
                        if ($value['type'] == 'variable') {
                            if ($variation['variation_name'] != 'Default') {
                                $text = $text . ' (' . $variation['variation_name'] . ')';
                            }
                        }
                        $i++;
                        $result[] = [
                            'id' => $i,
                            'text' => $text . ' - ' . $variation['sub_sku'],
                            'product_id' => $key,
                            'variation_id' => $variation['variation_id'],
                            'image' => $value['image'],
                        ];
                    }
                    $i++;
                }
            }

            return json_encode($result);
//        }
    }


    /**
     * Returns the html for product row
     *
     * @return \Illuminate\Http\Response
     */
    public function addProductRow(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->input('product_id');
            $variation_id = $request->input('variation_id');

            if (!empty($product_id)) {
                $index = $request->input('row_count');
                $products = $this->productUtil->getDetailsFromProduct($product_id, $variation_id);

                return view('purchase_order.partials.product_row')
                    ->with(compact('products', 'index'));
            }
        }
    }

    /**
     * getPoNumber
     *
     * @param Request $request
     * @return string
     */
    public function getPoNumber(Request $request)
    {

        $po_no = $this->productUtil->getNumberByType('purchase_order', request()->store_id);

        return $po_no;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDraftPurchaseOrder()
    {
        $query = Transaction::where('type', 'purchase_order')->where('status', 'draft');

        if (!empty(request()->supplier_id)) {
            $query->where('supplier_id', request()->supplier_id);
        }
        if (!empty(request()->start_date)) {
            $query->where('transaction_date', '>=', request()->start_date);
        }
        if (!empty(request()->end_date)) {
            $query->where('transaction_date', '<=', request()->end_date);
        }

        $purchase_orders = $query->orderBy('created_at', 'desc')->get();

        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id');
        $stores = Store::getDropdown();
        $status_array = $this->commonUtil->getPurchaseOrderStatusArray();

        return view('purchase_order.index')->with(compact(
            'purchase_orders',
            'suppliers',
            'stores',
            'status_array'
        ));
    }
    /**
     *  quick add purchase order as draft invoked from pos page if product stock is low
     *
     * @return \Illuminate\Http\Response
     */
    public function quickAddDraft(Request $request)
    {
        $variation = Variation::find($request->variation_id);

        try {
            $transaction_data = [
                'store_id' => $request->store_id,
                'supplier_id' => null,
                'type' => 'purchase_order',
                'status' => 'draft',
                'order_date' => Carbon::now(),
                'transaction_date' => Carbon::now(),
                'payment_status' => 'due',
                'po_no' =>  $this->productUtil->getNumberByType('purchase_order'),
                'final_total' => $this->productUtil->num_uf($variation->default_purchase_price),
                'details' => 'Created from POS page',
                'created_by' => Auth::user()->id
            ];

            DB::beginTransaction();
            $transaction = Transaction::create($transaction_data);

            $purchase_order_line_data = [
                'transaction_id' => $transaction->id,
                'product_id' => $request->product_id,
                'variation_id' => $request->variation_id,
                'quantity' => 1,
                'purchase_price' => $this->productUtil->num_uf($variation->default_purchase_price),
                'sub_total' => $this->productUtil->num_uf($variation->default_purchase_price * 1),
            ];

            PurchaseOrderLine::create($purchase_order_line_data);

            $notification_data = [
                'user_id' => Auth::user()->id,
                'transaction_id' => $transaction->id,
                'type' => $transaction->type,
                'status' => 'unread',
                'created_by' => Auth::user()->id,
            ];
            $this->notificationUtil->createNotification($notification_data);

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

    public function getImport()
    {
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id');
        $stores = Store::getDropdown();

        return view('purchase_order.import')->with(compact(
            'suppliers',
            'stores',
        ));
    }

    public function saveImport(Request $request)
    {
        try {
            $data = $request->except('_token');

            $transaction_data = [
                'store_id' => $data['store_id'],
                'supplier_id' => $data['supplier_id'],
                'type' => 'purchase_order',
                'status' => 'pending',
                'order_date' => Carbon::now(),
                'transaction_date' => Carbon::now(),
                'payment_status' => 'due',
                'po_no' => $data['po_no'],
                'grand_total' => 0,
                'final_total' => 0,
                'details' => $data['details'],
                'created_by' => Auth::user()->id
            ];

            if ($data['submit'] == 'sent_admin') {
                $transaction_data['status'] = 'sent_admin';
            }
            if ($data['submit'] == 'sent_supplier') {
                $transaction_data['status'] = 'sent_supplier';
            }

            DB::beginTransaction();
            $transaction = Transaction::create($transaction_data);

            Excel::import(new PurchaseOrderLineImport($transaction->id), $request->file);

            $final_total = PurchaseOrderLine::where('transaction_id', $transaction->id)->sum('sub_total');
            $transaction->grand_total = $final_total;
            $transaction->final_total = $final_total;
            $transaction->save();

            DB::commit();

            if ($data['submit'] == 'print') {
                $print = 'print';
                $url = action('PurchaseOrderController@show', $transaction->id) . '?print=' . $print;

                return Redirect::to($url);
            }
            if ($data['submit'] == 'sent_supplier') {
                $this->notificationUtil->sendPurchaseOrderToSupplier($transaction->id);
            }

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
    public function getProduct(Request $request)
    {
        if (request()->ajax()) {

            $products = Product::Active()->leftjoin('variations', function ($join) {
                $join->on('products.id', 'variations.product_id')
                    ->whereNull('variations.deleted_at');
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

            $store_id = $this->transactionUtil->getFilterOptionValues($request)['store_id'];

            $store_query = '';
            if (!empty($store_id)) {
                // $products->where('product_stores.store_id', $store_id);
                $store_query = 'AND store_id=' . $store_id;
            }

            if (!empty(request()->product_id)) {
                $products->where('products.id', request()->product_id);
            }

            if (!empty(request()->product_class_id)) {
                $products->where('products.product_class_id', request()->product_class_id);
            }

            if (!empty(request()->category_id)) {
                $products->where('products.category_id', request()->category_id);
            }

            if (!empty(request()->sub_category_id)) {
                $products->where('products.sub_category_id', request()->sub_category_id);
            }

            if (!empty(request()->tax_id)) {
                $products->where('tax_id', request()->tax_id);
            }

            if (!empty(request()->brand_id)) {
                $products->where('products.brand_id', request()->brand_id);
            }

            if (!empty(request()->supplier_id)) {
                $products->where('supplier_products.supplier_id', request()->supplier_id);
            }

            if (!empty(request()->unit_id)) {
                $products->where('variations.unit_id', request()->unit_id);
            }

            if (!empty(request()->color_id)) {
                $products->where('variations.color_id', request()->color_id);
            }

            if (!empty(request()->size_id)) {
                $products->where('variations.size_id', request()->size_id);
            }

            if (!empty(request()->grade_id)) {
                $products->where('variations.grade_id', request()->grade_id);
            }

            if (!empty(request()->customer_type_id)) {
                $products->whereJsonContains('show_to_customer_types', request()->customer_type_id);
            }

            if (!empty(request()->created_by)) {
                $products->where('products.created_by', request()->created_by);
            }
            if (request()->active == '1' || request()->active == '0') {
                $products->where('products.active', request()->active);
            }


            $is_add_stock = request()->is_add_stock;
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
                'variations.default_sell_price',
                'add_stock_lines.expiry_date as exp_date',
                'users.name as created_by_name',
                'edited.name as edited_by_name',
                DB::raw('(SELECT SUM(product_stores.qty_available) FROM product_stores JOIN variations as v ON product_stores.variation_id=v.id WHERE v.id=variations.id ' . $store_query . ') as current_stock'),
            )->with(['supplier'])
                ->groupBy('variations.id');
            return DataTables::of($products)
                ->addColumn('image', function ($row) {
                    $image = $row->getFirstMediaUrl('product');
                    if (!empty($image)) {
                        return '<img src="' . $image . '" height="50px" width="50px">';
                    } else {
                        return '<img src="' . asset('/uploads/' . session('logo')) . '" height="50px" width="50px">';
                    }
                })
                ->editColumn('variation_name', '@if($variation_name != "Default"){{$variation_name}} @else {{$name}}
                @endif')
                ->editColumn('sub_sku', '{{$sub_sku}}')
                ->addColumn('product_class', '{{$product_class}}')
                ->addColumn('category', '{{$category}}')
                ->addColumn('sub_category', '{{$sub_category}}')
                ->addColumn('purchase_history', function ($row) {
                    $html = '<a data-href="' . action('ProductController@getPurchaseHistory', $row->id) . '"
                    data-container=".view_modal" class="btn btn-modal">' . __('lang.view') . '</a>';
                    return $html;
                })
                ->editColumn('supplier_name', function ($row) {
                    return $row->supplier->name ?? '';
                })
                ->editColumn('batch_number', '{{$batch_number}}')
                ->editColumn('default_sell_price', '{{@num_format($default_sell_price)}}')
                ->addColumn('tax', '{{$tax}}')
                ->editColumn('brand', '{{$brand}}')
                ->editColumn('unit', '{{$unit}}')
                ->editColumn('color', '{{$color}}')
                ->editColumn('size', '{{$size}}')
                ->editColumn('grade', '{{$grade}}')
                ->editColumn('current_stock', '@if($is_service){{@num_format(0)}} @else{{@num_format($current_stock)}}@endif')
                ->addColumn('current_stock_value', function ($row) {
                    return $this->productUtil->num_f($row->current_stock * $row->default_purchase_price);
                })
                ->addColumn('customer_type', function ($row) {
                    return $row->customer_type;
                })
                ->editColumn('exp_date', '@if(!empty($exp_date)){{@format_date($exp_date)}}@endif')
                ->addColumn('manufacturing_date', '@if(!empty($manufacturing_date)){{@format_date($manufacturing_date)}}@endif')
                ->editColumn('discount', '{{@num_format($discount)}}')
                ->editColumn('default_purchase_price', '{{@num_format($default_purchase_price)}}')
                ->editColumn('active', function ($row) {
                    if ($row->active) {
                        return __('lang.yes');
                    } else {
                        return __('lang.no');
                    }
                })
                ->editColumn('created_by', '{{$created_by_name}}')
                ->addColumn('supplier', function ($row) {
                    $query = Transaction::leftjoin('add_stock_lines', 'transactions.id', '=', 'add_stock_lines.transaction_id')
                        ->leftjoin('suppliers', 'transactions.supplier_id', '=', 'suppliers.id')
                        ->where('transactions.type', 'add_stock')
                        ->where('add_stock_lines.product_id', $row->id)
                        ->select('suppliers.name')
                        ->orderBy('transactions.id', 'desc')
                        ->first();
                    return $query->name ?? '';
                })
                ->addColumn('selection_checkbox', function ($row) use ($is_add_stock) {

                            $html = '<input type="checkbox" name="product_selected" class="product_selected" value="' . $row->variation_id . '" data-product_id="' . $row->id . '" />';



                    return $html;
                })
                ->addColumn(
                    'action',
                    function ($row) {
                        $html =
                            '<div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">' . __('lang.action') .
                            '<span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">';

                        if (auth()->user()->can('product_module.product.view')) {
                            $html .=
                                '<li><a data-href="' . action('ProductController@show', $row->id) . '"
                                data-container=".view_modal" class="btn btn-modal"><i class="fa fa-eye"></i>
                                ' . __('lang.view') . '</a></li>';
                        }
                        $html .= '<li class="divider"></li>';
                        if (auth()->user()->can('product_module.product.create_and_edit')) {
                            $html .=
                                '<li><a href="' . action('ProductController@edit', $row->id) . '" class="btn"
                            target="_blank"><i class="dripicons-document-edit"></i> ' . __('lang.edit') . '</a></li>';
                        }
                        $html .= '<li class="divider"></li>';
                        if (auth()->user()->can('stock.add_stock.create_and_edit')) {
                            $html .=
                                '<li><a target="_blank" href="' . action('AddStockController@create', ['variation_id' => $row->variation_id, 'product_id' => $row->id]) . '" class="btn"
                            target="_blank"><i class="fa fa-plus"></i> ' . __('lang.add_new_stock') . '</a></li>';
                        }
                        $html .= '<li class="divider"></li>';
                        if (auth()->user()->can('product_module.product.delete')) {
                            $html .=
                                '<li>
                            <a data-href="' . action('ProductController@destroy', $row->variation_id) . '"
                                data-check_password="' . action('UserController@checkPassword', Auth::user()->id) . '"
                                class="btn text-red delete_product"><i class="fa fa-trash"></i>
                                ' . __('lang.delete') . '</a>
                        </li>';
                        }

                        $html .= '</ul></div>';

                        return $html;
                    }
                )

                ->setRowAttr([
                    'data-href' => function ($row) {
                        if (auth()->user()->can("product.view")) {
                            return  action('ProductController@show', [$row->id]);
                        } else {
                            return '';
                        }
                    }
                ])
                ->rawColumns([
                    'selection_checkbox',
                    'image',
                    'variation_name',
                    'sku',
                    'product_class',
                    'category',
                    'sub_category',
                    'purchase_history',
                    'batch_number',
                    'sell_price',
                    'tax',
                    'brand',
                    'unit',
                    'color',
                    'size',
                    'grade',
                    'is_service',
                    'customer_type',
                    'expiry',
                    'manufacturing_date',
                    'discount',
                    'purchase_price',
                    'created_by',
                    'action',
                ])
                ->make(true);
        }



    }

}
