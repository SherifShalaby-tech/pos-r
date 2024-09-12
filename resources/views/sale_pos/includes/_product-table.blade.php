<div class="col-md-12" style="margin-top: 5px; padding: 0px; ">
    <div class="table-responsive transaction-list">
        <table id="product_table" style="width: 100% " class="table table-hover table-striped order-list table-fixed">
            <thead>
                <tr>
                    <th
                        style="width: @if (session('system_mode') != 'restaurant') 1% @else 2% @endif; font-size: 12px !important;">
                        <label class=" checkboxes">
                            <input class="" type="checkbox" checked id="pay-all" value="" aria-label="...">
                        </label>
                    </th>
                    <th
                        style="width: @if (session('system_mode') != 'restaurant') 12% @else 17% @endif; font-size: 12px !important;">
                        @lang('lang.product')</th>
                    <th
                        style="width: @if (session('system_mode') != 'restaurant') 12% @else 17% @endif; font-size: 12px !important;">
                        @lang('lang.quantity')</th>
                    <th
                        style="width: @if (session('system_mode') != 'restaurant') 12% @else 12% @endif; font-size: 12px !important;">
                        @lang('lang.price')</th>
                    <th
                        style="width: @if (session('system_mode') != 'restaurant') 9% @else 8% @endif; font-size: 12px !important;">
                        @lang('lang.extension')</th>
                    <th
                        style="width: @if (session('system_mode') != 'restaurant') 11% @else 12% @endif; font-size: 12px !important;">
                        @lang('lang.discount')</th>
                    <th
                        style="width: @if (session('system_mode') != 'restaurant') 11% @else 13% @endif; font-size: 12px !important;">
                        @lang('lang.category_discount')</th>
                    <th
                        style="width: @if (session('system_mode') != 'restaurant') 9% @else 10% @endif; font-size: 12px !important;">
                        @lang('lang.sub_total')</th>
                    @if (session('system_mode') != 'restaurant')
                    <th
                        style="width: @if (session('system_mode') != 'restaurant') 9% @else 10% @endif; font-size: 12px !important;">
                        @lang('lang.current_stock')</th>
                    @endif
                    <th
                        style="width: @if (session('system_mode') != 'restaurant') 8% @else 8% @endif; font-size: 12px !important;">
                        @lang('lang.action')</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>