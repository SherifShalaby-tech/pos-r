<div class="col-12 totals table_room_hide" style="border-top: 2px solid #e4e6fc; padding-top: 10px;">
    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif justify-content-between align-items-center"
        style="gap: 8px">

        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
            style="padding: 5px;min-width: 100px;">
            <span class="totals-title text-center text-primary w-100 px-3 bg-white rounded" style="font-weight:600">{{
                __('lang.items') }}</span>


            <span id="item">0</span>
        </div>

        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
            style="padding: 5px;min-width: 100px;">
            <span class="totals-title text-center  text-primary w-100 px-3 bg-white rounded" style="font-weight:600">{{
                __('lang.quantity') }}</span><span id="item-quantity">0</span>
        </div>

        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
            style="padding: 5px;min-width: 100px;">


            <span class="totals-title text-center text-primary w-100 px-3 bg-white rounded" style="font-weight:600">{{
                __('lang.total') }}</span>


            <span id="subtotal">0.00</span>
        </div>




        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
            style="padding: 5px;min-width: 100px;">
            <span class="totals-title text-center text-primary w-100 px-3 bg-white rounded" style="font-weight:600">{{
                __('lang.tax') }} </span><span id=" tax">0.00</span>
        </div>
        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
            style="padding: 5px;min-width: 100px;">
            <span class="totals-title text-center text-primary w-100 px-3 bg-white rounded" style="font-weight:600">{{
                __('lang.delivery') }}</span><span id=" delivery-cost">0.00</span>
        </div>
        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
            style="padding: 5px;min-width: 100px;">
            <span class="totals-title text-center text-primary w-100 px-3 bg-white rounded" style="font-weight:600">{{
                __('lang.Insurance') }}</span>
            <span id=" delivery-cost">0.00</span>
        </div>


        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
            style="padding: 5px;min-width: 100px;">

            <span class="totals-title text-center  text-primary w-100 px-3 bg-white rounded" style="font-weight:600">{{
                __('lang.sales_promotion')
                }}</span>
            <span id="sales_promotion-cost_span">0.00</span>
            <input type="hidden" id="sales_promotion-cost" value="0">
        </div>


        <div class="col-sm-3">
            @if(auth()->user()->can('sp_module.sales_promotion.view')
            || auth()->user()->can('sp_module.sales_promotion.create_and_edit')
            || auth()->user()->can('sp_module.sales_promotion.delete'))
            <button style="background-color: #d63031" type="button" class="btn btn-md payment-btn text-white"
                data-toggle="modal" data-target="#discount_modal">@lang('lang.random_discount')</button>
            @endif
            {{-- <span id="discount">0.00</span> --}}
        </div>

    </div>
</div>
