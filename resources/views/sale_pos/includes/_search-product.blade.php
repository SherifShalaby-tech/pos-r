<div class="d-flex col-md-6 px-1 flex-column align-items-center">

    <div class="col-md-12 px-0 my-1 d-flex" style="gap: 7px">
        @if (session('system_mode') == 'restaurant')
        <button type=" button" style="padding: 0px !important;" data-toggle="modal" data-target="#dining_model" {{--
            data-href="/dining-room/get-dining-modal/0/0/0/0" data-container="#dining_model" --}}
            class="btn btn-modal pull-right col-md-6 mx-auto dining-btn">
            <span class="badge badge-danger table-badge">0</span>
            <img src="{{ asset('images/black-table.jpg') }}" alt="black-table"
                style="width: 40px; height: 33px; margin-top: 7px;"></button>
        @endif


    </div>
    <div class="col-md-12 px-0">
        <div class="search-box input-group">
            <button type="button" class="btn btn-secondary " id="search_button"
                style="border-radius: .25rem 0 0 .25rem;"><i class="fa fa-search"></i></button>
            <input type="text" name="search_product" id="search_product"
                placeholder="@lang('lang.enter_product_name_to_print_labels')"
                class="form-control ui-autocomplete-input" autocomplete="off">
            @if (isset($weighing_scale_setting['enable']) &&
            $weighing_scale_setting['enable'])
            <button type="button" class="btn btn-default bg-white btn-flat" id="weighing_scale_btn" data-toggle="modal"
                data-target="#weighing_scale_modal" title="@lang('lang.weighing_scale')"><i
                    class="fa fa-balance-scale text-primary fa-lg"></i></button>
            @endif
            <button type="button" class="btn btn-primary  btn-modal" style="border-radius: 0 .25rem .25rem 0;"
                data-href="{{ action('ProductController@create') }}?quick_add=1" data-container=".view_modal"><i
                    class="fa fa-plus"></i></button>
        </div>
    </div>
</div>