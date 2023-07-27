<?php

namespace App\Http\Controllers;

use App\Events\PrinterEvent;
use App\Models\Brand;
use App\Models\CashRegister;
use App\Models\CashRegisterTransaction;
use App\Models\Category;
use App\Models\ConnectedPrinter;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\DeliveryZone;
use App\Models\DiningRoom;
use App\Models\Employee;
use App\Models\Extension;
use App\Models\GiftCard;
use App\Models\Product;
use App\Models\ProductClass;
use App\Models\ProductExtension;
use App\Models\SalesPromotion;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\System;
use App\Models\Tax;
use App\Models\TermsAndCondition;
use App\Models\Transaction;
use App\Models\DiningTable;
use App\Models\MoneySafeTransaction;
use App\Models\Printer;
use App\Models\PrinterProduct;
use App\Models\ProductDiscount;
use App\Models\ServiceFee;
use App\Models\TableReservation;
use App\Models\TransactionPayment;
use App\Models\TransactionSellLine;
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
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Eloquent\Builder;
use Pusher\Pusher;
use Spatie\Browsershot\Browsershot;
use Str;
use Illuminate\Support\Facades\Cache;

class MyposController extends Controller
{
    protected $commonUtil;
    protected $transactionUtil;
    protected $productUtil;
    protected $notificationUtil;
    protected $cashRegisterUtil;
    protected $moneysafeUtil;
    public function __construct(Util $commonUtil,
            ProductUtil $productUtil, TransactionUtil $transactionUtil,
            NotificationUtil $notificationUtil, CashRegisterUtil $cashRegisterUtil,
            MoneySafeUtil $moneysafeUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
        $this->notificationUtil = $notificationUtil;
        $this->cashRegisterUtil = $cashRegisterUtil;
        $this->moneysafeUtil = $moneysafeUtil;
    }
    public function index()
    {
          // Get the current date
          $currentDate = Carbon::today();
          // Retrieve the last execution date from the cache or database
          $lastExecutionDate = Cache::get('last_execution_date');
          // Check if the last execution date is not today
          if (!$lastExecutionDate || $lastExecutionDate < $currentDate) {
              // Call the function or perform the desired task
              $this->notificationUtil->checkExpiary();
              // Store the current date as the last execution date
              Cache::put('last_execution_date', $currentDate, 1440); // 1440 minutes = 1 day
          }
         //Check if there is a open register, if no then redirect to Create Register screen.
         if ($this->cashRegisterUtil->countOpenedRegister() == 0) {
             return redirect()->to('/cash-register/create?is_pos=1');
         }
        $customers = Customer::getCustomerArrayWithMobile();
        $payment_types = $this->commonUtil->getPaymentTypeArrayForPos();
        $cashiers = Employee::getDropdownByJobType('Cashier', true, true);
        $deliverymen = Employee::getDropdownByJobType('Deliveryman');
        $delivery_men = Employee::getDropdownByJobType('Deliveryman');
        $exchange_rate_currencies = $this->commonUtil->getCurrenciesExchangeRateArray(true);
        $stores = Store::getDropdown();
        $store_poses = [];
       return view('pos.create',compact(['customers','payment_types','cashiers','stores','store_poses',
       'deliverymen','delivery_men','exchange_rate_currencies']));
    }

}

