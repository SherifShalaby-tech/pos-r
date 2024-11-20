<div class="payment-options d-flex flex-wrap justify-content-start flex-row-reverse pb-2 table_room_hide dev_not_room"
    style="gap:10px;">
    {{-- <div class="">
        <button data-method="card" style="background: #0984e3" type="button" class="btn btn-custom payment-btn"
            data-toggle="modal" data-target="#add-payment" id="credit-card-btn"><i class="fa fa-credit-card"></i>
            @lang('lang.card')</button>
    </div> --}}
    <div class="">
        <button data-method="cash" style="background: var(--primary-color)" type="button"
            class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment" data-backdrop="static"
            data-keyboard="false" id="cash-btn"><i class="fa fa-money"></i>
            @lang('lang.pay')</button>
    </div>
    <div class="">
        <button data-method="cash" style="background: var(--primary-color)" type="button" class="btn btn-custom"
            id="quick-pay-btn"><i class="fa fa-money"></i>
            @lang('lang.quick_pay')</button>
    </div>
    <div class="">
        <button data-method="coupon" style="background: var(--primary-color)" type="button" class="btn btn-custom"
            data-toggle="modal" data-target="#coupon_modal" id="coupon-btn"><i class="fa fa-tag"></i>
            @lang('lang.coupon')</button>
    </div>
    @if (session('system_mode') != 'restaurant')
    <div class="">
        <button data-method="paypal" style="background-color: var(--primary-color)" type="button"
            class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment" data-backdrop="static"
            data-keyboard="false" id="paypal-btn"><i class="fa fa-paypal"></i>
            @lang('lang.other_online_payments')</button>
    </div>
    @endif
    <div class="">
        <button data-method="draft" style="background-color: var(--primary-color)" type="button" data-toggle="modal"
            data-target="#sale_note_modal" class="btn btn-custom"><i class="dripicons-flag"></i>
            @lang('lang.draft')</button>
    </div>
    <div class="">
        <button data-method="draft" style="background-color: var(--primary-color)" type="button" class="btn btn-custom"
            id="view-draft-btn" data-href="{{ action('SellPosController@getDraftTransactions') }}"><i
                class="dripicons-flag"></i>
            @lang('lang.view_draft')</button>
    </div>
    <div class="">
        <button data-method="online-order" style="background-color: var(--primary-color)" type="button"
            class="btn btn-custom" id="view-online-order-btn"
            data-href="{{ action('SellPosController@getOnlineOrderTransactions') }}"><img
                src="{{ asset('images/online_order.png') }}" style="height: 25px; width: 35px;" alt="icon">
            @lang('lang.online_orders') <span class="badge badge-danger online-order-badge">0</span></button>
    </div>
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
    <div class="">
        <button data-method="pay-later" style="background-color: var(--primary-color)" type="button"
            class="btn btn-custom" id="pay-later-btn"><i class="fa fa-hourglass-start"></i>
            @lang('lang.pay_later')</button>
    </div>
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
    <div class="">
        <button type="button" class="btn w-100 btn-danger" id="cancel-btn" onclick="return confirmCancel()"><i
                class="fa fa-close"></i>
            @lang('lang.cancel')</button>
    </div>
    <div class="">
        <button style="background-color: var(--primary-color);" type="button" class="btn btn-custom"
            id="recent-transaction-btn"><i class="dripicons-clock"></i>
            @lang('lang.recent_transactions')</button>
    </div>
    <div class="">
        <button style="background-color: var(--primary-color);" type="button" class="btn btn-custom"
            id="bank-transfer-btn">
            @lang('lang.bank_transfer')</button>
    </div>


</div>
