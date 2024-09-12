<div class="col-12 totals table_room_hide" style="border-top: 2px solid #e4e6fc; padding-top: 10px;">
    <div class="row">
        <div class="col-sm-4">
            <span class="totals-title">{{ __('lang.items') }}</span><span id="item">0</span>
            <br>
            <span class="totals-title  text-dark" style="font-weight:1000">{{
                __('lang.quantity') }}</span><span id="item-quantity">0</span>
        </div>
        <div class="col-sm-4">
            <span class="totals-title">{{ __('lang.total') }}</span><span id="subtotal">0.00</span>
        </div>
        <div class="col-sm-4">
            @if(auth()->user()->can('sp_module.sales_promotion.view')
            || auth()->user()->can('sp_module.sales_promotion.create_and_edit')
            || auth()->user()->can('sp_module.sales_promotion.delete'))
            <button style="background-color: #d63031" type="button" class="btn btn-md payment-btn text-white"
                data-toggle="modal" data-target="#discount_modal">@lang('lang.random_discount')</button>
            @endif
            {{-- <span id="discount">0.00</span> --}}
        </div>

        <div class="col-sm-4">
            <span class="totals-title">{{ __('lang.tax') }} </span><span id="tax">0.00</span>
        </div>
        <div class="col-sm-4">
            <span class="totals-title">{{ __('lang.delivery') }}</span><span id="delivery-cost">0.00</span>
        </div>
        <div class="col-sm-4">
            <span class="totals-title">{{ __('lang.Insurance') }}</span><span id="delivery-cost">0.00</span>
            <div class=" red">
                <span class="totals-title red">{{ __('lang.sales_promotion')
                    }}</span><span id="sales_promotion-cost_span">0.00</span>
                <input type="hidden" id="sales_promotion-cost" value="0">
            </div>
        </div>
    </div>
</div>