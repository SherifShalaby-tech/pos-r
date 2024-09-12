<div class="col-md-12" style="margin-top: 10px;">
    <div class="search-box input-group">
        <button type="button" class="btn btn-secondary btn-lg" id="search_button"><i class="fa fa-search"></i></button>
        <input type="text" name="search_product" id="search_product"
            placeholder="@lang('lang.enter_product_name_to_print_labels')" class="form-control ui-autocomplete-input"
            autocomplete="off">
        @if (isset($weighing_scale_setting['enable']) &&
        $weighing_scale_setting['enable'])
        <button type="button" class="btn btn-default bg-white btn-flat" id="weighing_scale_btn" data-toggle="modal"
            data-target="#weighing_scale_modal" title="@lang('lang.weighing_scale')"><i
                class="fa fa-balance-scale text-primary fa-lg"></i></button>
        @endif
        <button type="button" class="btn btn-primary btn-lg btn-modal"
            data-href="{{ action('ProductController@create') }}?quick_add=1" data-container=".view_modal"><i
                class="fa fa-plus"></i></button>
    </div>
</div>