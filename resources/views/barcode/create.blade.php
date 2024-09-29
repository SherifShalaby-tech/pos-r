@extends('layouts.app')
@section('title', __('lang.print_barcode'))

@section('content')
<section class="forms py-2">
    <div class="container-fluid px-2">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>
                    <h4>@lang('lang.print_barcode')</h4>
                </x-page-title>


                {!! Form::open(['url' => '#', 'method' => 'post', 'id' => 'preview_setting_form', 'onsubmit' =>
                'return false']) !!}

                {{-- <input type="hidden" name="is_add_stock" id="is_add_stock" value="1"> --}}
                <input type="hidden" name="row_count" id="row_count" value="0">
                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div
                            class="row justify-content-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-2 mb-2">
                                @include('quotation.partial.product_selection')
                            </div>
                            <div class="col-md-12">
                                <div class="search-box input-group">
                                    <button type="button" class="btn btn-secondary btn-lg"><i
                                            class="fa fa-search"></i></button>
                                    <input type="text" name="search_product" id="search_product_for_label"
                                        placeholder="@lang('lang.enter_product_name_to_print_labels')"
                                        class="form-control ui-autocomplete-input" autocomplete="off">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped table-condensed" id="product_table">
                                    <thead>
                                        <tr>
                                            <th style="width: 33%" class="col-sm-8">@lang('lang.products')</th>
                                            <th style="width: 33%" class="col-sm-4">@lang('lang.sku')</th>
                                            <th style="width: 33%" class="col-sm-4">@lang('lang.no_of_labels')
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                            <div class="col-md-4">
                                <div class="i-checks toggle-pill-color">
                                    <input id="product_name" name="product_name" type="checkbox" checked value="1"
                                        class="form-control-custom">
                                    <label for="product_name"></label>
                                    <span>
                                        <strong>@lang('lang.product_name')</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="i-checks toggle-pill-color">
                                    <input id="price" name="price" type="checkbox" checked value="1"
                                        class="form-control-custom">
                                    <label for="price"></label>
                                    <span>
                                        <strong>@lang('lang.price')</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="i-checks toggle-pill-color">
                                    <input id="size" name="size" type="checkbox" checked value="1"
                                        class="form-control-custom">
                                    <label for="size"></label>
                                    <span>
                                        <strong>@lang('lang.size')</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="i-checks toggle-pill-color">
                                    <input id="color" name="color" type="checkbox" checked value="1"
                                        class="form-control-custom">
                                    <label for="color"></label>
                                    <span>
                                        <strong>@lang('lang.color')</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="i-checks toggle-pill-color">
                                    <input id="grade" name="grade" type="checkbox" checked value="1"
                                        class="form-control-custom">
                                    <label for="grade"></label>
                                    <span>
                                        <strong>@lang('lang.grade')</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="i-checks toggle-pill-color">
                                    <input id="unit" name="unit" type="checkbox" checked value="1"
                                        class="form-control-custom">
                                    <label for="unit"></label>
                                    <span>
                                        <strong>@lang('lang.unit')</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="i-checks toggle-pill-color">
                                    <input id="size_variations" name="size_variations" type="checkbox" checked value="1"
                                        class="form-control-custom">
                                    <label for="size_variations"></label>
                                    <span>
                                        <strong>@lang('lang.size')
                                            @lang('lang.variations')</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="i-checks toggle-pill-color">
                                    <input id="color_variations" name="color_variations" type="checkbox" checked
                                        value="1" class="form-control-custom">
                                    <label for="color_variations"></label>
                                    <span>
                                        <strong>@lang('lang.color')
                                            @lang('lang.variations')</strong>
                                    </span>
                                </div>
                            </div>
                            @foreach ($stores as $key => $store)
                            <div class="col-md-4">
                                <div class="i-checks toggle-pill-color">
                                    <input id="store{{ $key }}" name="store[{{ $key }}]" type="checkbox"
                                        value="{{ $key }}" @if($loop->index == 0 ) checked @endif
                                    class="form-control-custom">
                                    <label for="store{{ $key }}"></label>
                                    <span>
                                        <strong>{{ $store }}</strong>
                                    </span>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-md-4">
                                <div class="i-checks toggle-pill-color">
                                    <input id="site_title" name="site_title" type="checkbox" checked value="1"
                                        class="form-control-custom">
                                    <label for="site_title"></label>
                                    <span>
                                        <strong>{{
                                            App\Models\System::getProperty('site_title')
                                            }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                        for="">@lang('lang.text')</label>
                                    <input class="form-control" type="text" name="free_text" id="free_text" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                        for="">@lang('lang.paper_size'):</label>
                                    <select class="form-control" name="paper_size" required id="paper-size"
                                        tabindex="-98">
                                        <option value="0">Select paper size...</option>
                                        <option value="36">36 mm (1.4 inch)</option>
                                        <option value="24">24 mm (0.94 inch)</option>
                                        <option value="18">18 mm (0.7 inch)</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>




                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-sm-12">
                                <button type="button" id="labels_preview"
                                    class="btn btn-primary pull-right btn-flat">@lang('lang.submit')</button>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

</section>
@endsection

@section('javascript')
<script src="{{ asset('js/barcode.js') }}"></script>
<script src="{{ asset('js/product_selection.js') }}"></script>
<script type="text/javascript">
    $(document).on('click', '#add-selected-btn', function() {
            $('#select_products_modal').modal('hide');
            $.each(product_selected, function(index, value) {
                get_label_product_row(value.product_id, value.variation_id);
            });
            product_selected = [];
            product_table.ajax.reload();
        });
        $('#product_selection_table').on('change', '.product_select_all', function() {
                var isChecked = $(this).prop('checked');
                product_table.rows().nodes().to$().find('.product_selected').prop('checked', isChecked);
                $('.product_selected').change();
            });
        $(document).on('click', '.remove_row', function() {
            $(this).closest('tr').remove();
        });
</script>
@endsection
