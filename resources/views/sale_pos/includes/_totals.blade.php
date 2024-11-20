<div class="col-12 px-1 totals table_room_hide dev_not_room" style=" padding-top: 10px;">
    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif justify-content-center align-items-center"
        style="gap: 2px">

        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
            style="padding: 5px;min-width: 60px;">
            <span class="totals-title text-center text-primary w-100 px-1 bg-white rounded"
                style="font-weight:600;font-size: 14px">{{
                __('lang.items') }}</span>


            <span style="font-weight: 600;font-size: 14px" id="item">0</span>
        </div>

        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
            style="padding: 5px;min-width: 60px;">
            <span class="totals-title text-center  text-primary w-100 px-1 bg-white rounded"
                style="font-weight:600;font-size: 14px">{{
                __('lang.quantity') }}</span><span style="font-weight: 600;font-size: 14px" id="item-quantity">0</span>
        </div>

        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
            style="padding: 5px;min-width: 60px;">


            <span class="totals-title text-center text-primary w-100 px-1 bg-white rounded"
                style="font-weight:600;font-size: 14px">{{
                __('lang.total') }}</span>


            <span style="font-weight: 600;font-size: 14px" id="subtotal">0.00</span>
        </div>

        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
            style="padding: 5px;min-width: 60px;">
            <span class="totals-title text-center text-primary w-100 px-1 bg-white rounded"
                style="font-weight:600;font-size: 14px">{{
                __('lang.tax') }} </span>
            <span style="font-weight: 600;font-size: 14px" id=" tax">0.00</span>
        </div>
        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
            style="padding: 5px;min-width: 60px;">
            <span class="totals-title text-center text-primary w-100 px-1 bg-white rounded"
                style="font-weight:600;font-size: 14px">{{
                __('lang.delivery') }}</span><span style="font-weight: 600;font-size: 14px"
                id=" delivery-cost">0.00</span>
        </div>
        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
            style="padding: 5px;min-width: 60px;">
            <span class="totals-title text-center text-primary w-100 px-1 bg-white rounded"
                style="font-weight:600;font-size: 14px">{{
                __('lang.Insurance') }}</span>
            <span style="font-weight: 600;font-size: 14px" id=" delivery-cost">0.00</span>
        </div>

        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
            style="padding: 5px;min-width: 60px;">

            <span class="totals-title text-center  text-primary w-100 px-1 bg-white rounded"
                style="font-weight:600;font-size: 14px">{{
                __('lang.sales_promotion')
                }}</span>
            <span style="font-weight: 600;font-size: 14px" id="sales_promotion-cost_span">0.00</span>
            <input type="hidden" id="sales_promotion-cost" value="0">
        </div>


        <div class="">
            @if(auth()->user()->can('sp_module.sales_promotion.view')
            || auth()->user()->can('sp_module.sales_promotion.create_and_edit')
            || auth()->user()->can('sp_module.sales_promotion.delete'))
            <button style="background-color: #d63031" type="button" class="btn btn-md payment-btn text-white"
                data-toggle="modal" data-target="#discount_modal">@lang('lang.random_discount')</button>
            @endif
            {{-- <span style="font-weight: 600;font-size: 14px" id="discount">0.00</span> --}}
        </div>


    </div>
</div>
