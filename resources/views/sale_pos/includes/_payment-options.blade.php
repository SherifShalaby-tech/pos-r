@php

use App\Models\PaymentMethod;

function getOrCreatePaymentMethod($payment_method_name) {
    $method = PaymentMethod::where('name', $payment_method_name)->first();

    if (!$method) {
        $method = PaymentMethod::create([
            'name' => $payment_method_name,
            'is_default' => 1,
            'is_active' => 1
        ]);
    }

    return $method->is_active;
}

$pay_button_show = getOrCreatePaymentMethod("Pay");
$quick_pay_button_show = getOrCreatePaymentMethod("Quick Pay");
$other_online_payments_button_show = getOrCreatePaymentMethod("Other Online Payments");
$draft_button_show = getOrCreatePaymentMethod("Draft");
$view_draft_button_show = getOrCreatePaymentMethod("View Draft");
$online_orders_button_show = getOrCreatePaymentMethod("Online Orders");
$pay_later_button_show = getOrCreatePaymentMethod("Pay Later");
$recent_transaction_button_show = getOrCreatePaymentMethod("Recent Transactions");
$bank_transfer_button_show = getOrCreatePaymentMethod("Bank Transfer");

$payment_methods = PaymentMethod::where('is_default', 0)->get();

@endphp

<div class="payment-options mt-2 d-flex flex-wrap justify-content-start flex-row-reverse pb-2 table_room_hide dev_not_room"
    style="gap:10px;">
    {{-- <div class="">
        <button data-method="card" style="background: #0984e3" type="button" class="btn btn-custom payment-btn"
            data-toggle="modal" data-target="#add-payment" id="credit-card-btn"><i class="fa fa-credit-card"></i>
            @lang('lang.card')</button>
    </div> --}}

    @if ($pay_button_show)
    <div class="">
        <button data-method="cash" style="background: var(--primary-color)" type="button"
            class="btn btn-custom payment-btn payment-modal-btn" data-toggle="modal" data-target="#add-payment"
            data-backdrop="static" data-keyboard="false" id="cash-btn"><i class="fa fa-money"></i>
            @lang('lang.pay')</button>
    </div>
    @endif

    @if ($quick_pay_button_show)
    <div class="">
        <button data-method="cash" style="background: var(--primary-color)" type="button" class="btn btn-custom"
            id="quick-pay-btn"><i class="fa fa-money"></i>
            @lang('lang.quick_pay')</button>
    </div>
    @endif
    {{-- <div class="">
        <button data-method="coupon" style="background: var(--primary-color)" type="button" class="btn btn-custom"
            data-toggle="modal" data-target="#coupon_modal" id="coupon-btn"><i class="fa fa-tag"></i>
            @lang('lang.coupon')</button>
    </div> --}}
    @if ($other_online_payments_button_show)
    @if (session('system_mode') != 'restaurant')
    <div class="">
        <button data-method="paypal" style="background-color: var(--primary-color)" type="button"
            class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment" data-backdrop="static"
            data-keyboard="false" id="paypal-btn"><i class="fa fa-paypal"></i>
            @lang('lang.other_online_payments')</button>
    </div>
    @endif
    @endif

    @if ($draft_button_show)
    <div class="">
        <button data-method="draft" style="background-color: var(--primary-color)" type="button" data-toggle="modal"
            data-target="#sale_note_modal" class="btn btn-custom"><i class="dripicons-flag"></i>
            @lang('lang.draft')</button>
    </div>
    @endif
    @if ($view_draft_button_show)
    <div class="">
        <button data-method="draft" style="background-color: var(--primary-color)" type="button" class="btn btn-custom"
            id="view-draft-btn" data-href="{{ action('SellPosController@getDraftTransactions') }}"><i
                class="dripicons-flag"></i>
            @lang('lang.view_draft')</button>
    </div>
    @endif

    @if ($online_orders_button_show)
    <div class="">
        <button data-method="online-order" style="background-color: var(--primary-color)" type="button"
            class="btn btn-custom" id="view-online-order-btn"
            data-href="{{ action('SellPosController@getOnlineOrderTransactions') }}"><img
                src="{{ asset('images/online_order.png') }}" style="height: 25px; width: 35px;" alt="icon">
            @lang('lang.online_orders') <span class="badge badge-danger online-order-badge">0</span></button>
    </div>
    @endif
    {{-- <div class="">
        <button data-method="cheque" style="background-color: var(--primary-color)" type="button"
            class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment" id="cheque-btn"><i
                class="fa fa-money"></i>
            @lang('lang.cheque')</button>
    </div> --}}
    {{-- <div class="">
        <button data-method="bank_transfer" style="background-color: var(--primary-color)" type="button"
            class="btn btn-custom payment-btn" id="bank-transfer-btn"><i class="fa fa-building-o"></i>
            @lang('lang.bank_transfer')</button>
    </div> --}}
    @if ($pay_later_button_show)

    <div class="">
        <button data-method="pay-later" style="background-color: var(--primary-color)" type="button"
            class="btn btn-custom" id="pay-later-btn"><i class="fa fa-hourglass-start"></i>
            @lang('lang.pay_later')</button>
    </div>
    @endif
    {{-- <div class="">
        <button data-method="gift_card" style="background-color: var(--primary-color)" type="button"
            class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment" id="gift-card-btn"><i
                class="fa fa-credit-card-alt"></i>
            @lang('lang.gift_card')</button>
    </div> --}}
    {{-- <div class="">
        <button data-method="deposit" style="background-color: var(--primary-color)" type="button"
            class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment" id="deposit-btn"><i
                class="fa fa-university"></i>
            @lang('lang.use_the_balance')</button>
    </div> --}}

    @if ($recent_transaction_button_show)

    <div class="">
        <button style="background-color: var(--primary-color);" type="button" class="btn btn-custom"
            id="recent-transaction-btn"><i class="dripicons-clock"></i>
            @lang('lang.recent_transactions')</button>
    </div>
    @endif

    @if ($bank_transfer_button_show)
    <div class="">
        <button style="background-color: var(--primary-color);" type="button" class="btn btn-custom"
            id="bank-transfer-btn">
            @lang('lang.bank_transfer')</button>
    </div>
    @endif

    @foreach ($payment_methods as $method)
    @if ($method->is_active)

    <div class="">
        <button data-method="cash" style="background: var(--primary-color)" type="button"
            data-method-id="{{ $method->id }}"
            data-method-types='@json(App\Models\PaymentMethodType::where("payment_method_id", $method->id)->pluck("name"))'
            class="btn btn-custom payment-btn payment-modal-btn" data-toggle="modal" data-target="#add-payment"
            data-backdrop="static" data-keyboard="false"><i class="fa fa-money"></i>
            {{ $method->name }}</button>
    </div>
    @endif
    @endforeach

    @if(auth()->user()->can('sp_module.sales_promotion.view')
    || auth()->user()->can('sp_module.sales_promotion.create_and_edit')
    || auth()->user()->can('sp_module.sales_promotion.delete'))
    <button type="button" class="btn py-2 col-md-2 mr-2 btn-md btn-primary payment-btn text-white" data-toggle="modal"
        data-target="#discount_modal">@lang('lang.random_discount')</button>
    @endif

    <div class="">
        <button type="button" class="btn w-100 btn-danger" id="cancel-btn" onclick="return confirmCancel()"><i
                class="fa fa-close"></i>
            @lang('lang.cancel')</button>
    </div>
</div>


{{-- @include('sale_pos.includes._payment-methods-modals') --}}
