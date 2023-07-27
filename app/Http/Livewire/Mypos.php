<?php

namespace App\Http\Livewire;

use App\Http\Requests\CustomerInsurance\Store;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\DeliveryZone;
use App\Models\DiningRoom;
use App\Models\DiningTable;
use App\Models\Employee;
use App\Models\Product;
use App\Models\ProductClass;
use App\Models\ServiceFee;
use App\Models\StorePos;
use App\Models\System;
use App\Models\Tax;
use App\Models\TermsAndCondition;
use App\Utils\CashRegisterUtil;
use App\Utils\MoneySafeUtil;
use App\Utils\NotificationUtil;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Utils\Util;
class Mypos extends Component
{
    public $payment_types,$exchange_rate_currencies,$customers,$stores;
    public $department_id = 0 , $products = [],$items = [],$price, $tax, $total = 0, $discount,$qty,$itemcount ,$customer_id;
    public function mount()
    {
        $this->department_id = 0;
    }
    public function updatedDepartmentId($department_id)
    {
        $this->products = $department_id > 0? Product::where('product_class_id', $department_id)->get() : Product::get();
    }
    public function add_product(Product $product){
        $newArr = array_filter($this->items, function ($item) use ($product) {
            return $item['product_id'] == $product->id;
        });
        if (count($newArr) > 0) {
            $key = array_keys($newArr)[0];
            ++$this->items[$key]['quantity'];
        }else{
            $this->items[] = [
                'itemno' => 1,
                'product_id' => $product->id,
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->sell_price,
            ];
        }
        $this->computeForAll();
    }
    public function increment($key)

    {
        $this->items[$key]['quantity']++;
        $this->computeForAll();
    }

    public function decrement($key)

    {
        $this->items[$key]['quantity']--;

        if ($this->items[$key]['quantity'] == 0) {
            $this->items[$key]['quantity']++;
        }
        $this->computeForAll();
    }
    public function delete_item($key)
    {
        unset($this->items[$key]);
        $this->computeForAll();
    }
    public function computeForAll()
    {
        $this->itemcount  = array_reduce($this->items, function ($qu, $item) {
            $qu +=$item['itemno'];
            return $qu;
        });
        $this->qty  = array_reduce($this->items, function ($q, $item) {
            $q +=$item['quantity'];
            return $q;
        });

        $this->price = array_reduce($this->items, function ($carry, $item) {
            $carry += $item['price'] * $item['quantity'];
            return $carry;
        });
        $this->total = $this->price ;
    }
    public function render()
    {
        // $categories = Category::whereNull('parent_id')->groupBy('categories.id')->get();
        // $sub_categories = Category::whereNotNull('parent_id')->groupBy('categories.id')->get();
        // $brands = Brand::all();
        $product_classes = ProductClass::orderBy('sort', 'asc')->select('name', 'id')->get();
        $clients = Customer::get(['id','name','mobile_number']);
        $delivery_zones = DeliveryZone::pluck('name', 'id');
        // $delivery_men = Employee::getDropdownByJobType('Deliveryman');
        $deliverymen = Employee::getDropdownByJobType('Deliveryman');

        // $customers = Customer::getCustomerArrayWithMobile();
        // $payment_types = $this->commonUtil->getPaymentTypeArrayForPos();
        // $cashiers = Employee::getDropdownByJobType('Cashier', true, true);

        $store_pos = StorePos::where('user_id', Auth::user()->id)->first();
        // $stores = Store::getDropdown();
        $store_poses = [];
        // $products = Product::get(['id','name']);
        $taxes = Tax::getDropdown();
        $tac = TermsAndCondition::getDropdownInvoice();
        // $walk_in_customer = Customer::where('is_default', 1)->first();
        // $store_poses = [];
        // $weighing_scale_setting = System::getProperty('weighing_scale_setting') ?  json_decode(System::getProperty('weighing_scale_setting'), true) : [];
        $languages = System::getLanguageDropdown();
        $service_fees = ServiceFee::pluck('name', 'id');
        // $exchange_rate_currencies = $this->commonUtil->getCurrenciesExchangeRateArray(true);
        $employees = Employee::getCommissionEmployeeDropdown();
        $tables=DiningTable::pluck('name', 'id');
        $watsapp_numbers = System::getProperty('watsapp_numbers');
        // if (empty($store_pos)) {
        //     $output = [
        //         'success' => false,
        //         'msg' => __('lang.kindly_assign_pos_for_that_user_to_able_to_use_it')
        //     ];

        //     return redirect()->to('/home')->with('status', $output);
        // }
        // $dining_rooms = DiningRoom::all();
        // $active_tab_id = null;
        return view('livewire.mypos',compact([
            // 'categories','sub_categories','brands',
            'product_classes','clients','delivery_zones','deliverymen'
            ,'store_pos','languages','taxes','service_fees','tables','tac','employees','watsapp_numbers','store_poses'

            // 'dining_rooms','active_tab_id','walk_in_customer','deliverymen',
            // 'tac','store_pos','clients','products','stores',
            // 'store_poses','cashiers','taxes','payment_types',
            // 'weighing_scale_setting','languages','service_fees','delivery_zones',
            // 'employees','delivery_men','exchange_rate_currencies','tables'
        ]));
    }


}
