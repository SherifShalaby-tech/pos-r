@extends('layouts.app')
@section('title', __('lang.product'))
@php
use Illuminate\Support\Facades\Cache;
@endphp
@section('content')

<section class="forms pt-2">

    <div class="container-fluid">


        <x-page-title>
            @if (request()->segment(1) == 'product')
            <h4 class="print-title">@lang('lang.product_lists')</h4>
            @endif
            @if (request()->segment(1) == 'product-stocks')
            <h4 class="print-title">@lang('lang.product_stocks')</h4>
            @endif

            <x-slot name="buttons">
                <div>
                    @if (empty($page))
                    @can('product_module.product.create_and_edit')
                    <a href="{{ action('ProductController@create') }}" class="btn btn-primary py-2"><i
                            class="dripicons-plus"></i>
                        @lang('lang.add_product')</a>
                    @endcan
                    <a href="{{ action('ProductController@getImport') }}" class="btn btn-primary py-2"><i
                            class="fa fa-arrow-down"></i>
                        @lang('lang.import')</a>
                    @else
                    <a href="{{ action('AddStockController@getImport') }}" class="btn btn-primary py-2"><i
                            class="fa fa-arrow-down"></i>
                        @lang('lang.import')</a>
                    @endif
                </div>
            </x-slot>
        </x-page-title>

        <x-collapse collapse-id="Filter" button-class="d-flex btn-secondary" group-class="mb-1" body-class="py-1">

            <x-slot name="button">
                {{-- @lang('lang.filter') --}}
                <div style="width: 20px">
                    <img class="w-100" src="{{ asset('front/white-filter.png') }}" alt="">
                </div>
            </x-slot>

            <div class="col-md-12">
                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div class="col-md-2 px-2">
                        <div class="form-group">
                            {!! Form::label('product_class_id', session('system_mode') == 'restaurant' ?
                            __('lang.category')
                            : __('lang.product_class') , ['class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('product_class_id', $product_classes, request()->product_class_id, [
                            'class' => 'form-control filter_product
                            selectpicker',
                            'data-live-search' => 'true',
                            'placeholder' => __('lang.all'),
                            ]) !!}
                        </div>
                    </div>
                    @if (session('system_mode') != 'restaurant')
                    <div class="col-md-2 px-2">
                        <div class="form-group">
                            {!! Form::label('category_id', __('lang.category') , ['class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('category_id', $categories, request()->category_id, [
                            'class' => 'form-control filter_product
                            selectpicker',
                            'data-live-search' => 'true',
                            'placeholder' => __('lang.all'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2 px-2">
                        <div class="form-group">
                            {!! Form::label('sub_category_id', __('lang.sub_category') , ['class' =>
                            app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('sub_category_id', $sub_categories, request()->sub_category_id, [
                            'class' => 'form-control filter_product
                            selectpicker',
                            'data-live-search' => 'true',
                            'placeholder' => __('lang.all'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2 px-2">
                        <div class="form-group">
                            {!! Form::label('brand_id', __('lang.brand') , ['class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('brand_id', $brands, request()->brand_id, [
                            'class' => 'form-control
                            filter_product
                            selectpicker',
                            'data-live-search' => 'true',
                            'placeholder' => __('lang.all'),
                            ]) !!}
                        </div>
                    </div>
                    @endif
                    <div class="col-md-2 px-2">
                        <div class="form-group">
                            {!! Form::label('supplier_id', __('lang.supplier') , ['class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('supplier_id', $suppliers, request()->supplier_id, [
                            'class' => 'form-control
                            filter_product
                            selectpicker',
                            'data-live-search' => 'true',
                            'placeholder' => __('lang.all'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2 px-2">
                        <div class="form-group">
                            {!! Form::label('unit_id', __('lang.unit') , ['class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('unit_id', $units, request()->unit_id, [
                            'class' => 'form-control
                            filter_product
                            selectpicker',
                            'data-live-search' => 'true',
                            'placeholder' => __('lang.all'),
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-md-2 px-2">
                        <div class="form-group">
                            {!! Form::label('size_id', __('lang.size') , ['class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('size_id', $sizes, request()->size_id, [
                            'class' => 'form-control
                            filter_product
                            selectpicker',
                            'data-live-search' => 'true',
                            'placeholder' => __('lang.all'),
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-md-2 px-2">
                        <div class="form-group">
                            {!! Form::label('tax_id', __('lang.tax') , ['class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('tax_id', $taxes, request()->tax_id, [
                            'class' => 'form-control
                            filter_product
                            selectpicker',
                            'data-live-search' => 'true',
                            'placeholder' => __('lang.all'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2 px-2">
                        <div class="form-group">
                            {!! Form::label('store_id', __('lang.store'), ['class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('store_id', $stores, request()->store_id, ['class' => 'form-control
                            filter_product', 'placeholder' => __('lang.all'), 'data-live-search' => 'true']) !!}
                        </div>
                    </div>
                    <div class="col-md-2 px-2">
                        <div class="form-group">
                            {!! Form::label('customer_type_id', __('lang.customer_type') , ['class' =>
                            app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('customer_type_id', $customer_types, request()->customer_type_id, [
                            'class' => 'form-control filter_product
                            selectpicker',
                            'data-live-search' => 'true',
                            'placeholder' => __('lang.all'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2 px-2">
                        <div class="form-group">
                            {!! Form::label('created_by', __('lang.created_by') , ['class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('created_by', $users, request()->created_by, [
                            'class' => 'form-control filter_product
                            selectpicker',
                            'data-live-search' => 'true',
                            'placeholder' => __('lang.all'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2 px-2">
                        <div class="form-group">
                            {!! Form::label('active', __('lang.active') , ['class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('active', [0 => __('lang.no'), 1 => __('lang.yes')], request()->active, [
                            'class' => 'form-control filter_product
                            selectpicker',
                            'data-live-search' => 'true',
                            'placeholder' => __('lang.all'),
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-md-2 px-2 d-flex justify-content-center align-items-end mb-11px">
                        <button class="btn w-100 btn-danger clear_filters">@lang('lang.clear_filters')</button>
                    </div>
                    <div class="col-md-2 px-2 d-flex justify-content-center align-items-end mb-11px">
                        <a data-href="{{ action('ProductController@multiDeleteRow') }}" id="delete_all"
                            data-check_password="{{ action('UserController@checkPassword', Auth::user()->id) }}"
                            class="btn btn-danger text-white w-100 delete_all"><i class="fa fa-trash"></i>
                            @lang('lang.delete_all')</a>
                    </div>

                    <div class="col-md-3 px-2 d-flex justify-content-end align-items-center">
                        <div class="form-group toggle-pill-color d-flex flex-row mb-0 align-items-center justify-content-center"
                            style="gap: 10px">
                            {{-- {!! Form::label('show_zero_stocks',"Don't show zero stocks" ) !!} --}}
                            {!! Form::checkbox('show_zero_stocks', 1, false, ['class' => '
                            show_zero_stocks','data-live-search' => 'true',
                            'id' => 'show_zero_stocks'
                            ], request()->show_zero_stocks ? true : false) !!}

                            <label class="mb-0" for="show_zero_stocks">
                            </label>
                            <span>Don't show zero stocks</span>
                        </div>
                    </div>

                    <input type="hidden" name="product_id" id="product_id" value="">

                    <div class="col-md-2 px-2 d-flex justify-content-center align-items-center">
                        <button type="button" class="badge badge-pill badge-primary column-toggle send_to_branch"
                            id="send_to_branch">@lang('lang.send_to_branch')</button>
                    </div>
                </div>
            </div>

        </x-collapse>

        {{-- <div class="row">
            <div class="col-md-12">
                <button type="button" value="1"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.image')</button>
                <button type="button" value="4" class="badge badge-pill badge-primary column-toggle">
                    @if (session('system_mode') == 'restaurant')
                    @lang('lang.category')
                    @else
                    @lang('lang.class')
                    @endif
                </button>
                @if (session('system_mode') != 'restaurant')
                <button type="button" value="5"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.category')</button>
                <button type="button" value="6"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.sub_category')</button>
                @endif
                <button type="button" value="5"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.purchase_history')</button>
                <button type="button" value="6"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.batch_number')</button>
                <button type="button" value="7"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.selling_price')</button>
                <button type="button" value="8"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.tax')</button>
                @if (session('system_mode') != 'restaurant')
                <button type="button" value="9"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.brand')</button>
                @endif
                <button type="button" value="9"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.unit')</button>

                <button type="button" value="10"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.size')</button>

                @if (empty($page))
                <button type="button" value="11"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.current_stock')</button>
                @endif
                @if (!empty($page))
                <button type="button" value="12"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.current_stock_value')</button>
                @endif
                <button type="button" value="13"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.customer_type')</button>
                <button type="button" value="14"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.expiry_date')</button>
                <button type="button" value="15"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.manufacturing_date')</button>
                <button type="button" value="16"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.discount')</button>
                @can('product_module.purchase_price.view')
                <button type="button" value="17"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.purchase_price')</button>
                @endcan
                <button type="button" value="18"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.supplier')</button>
                <button type="button" value="19"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.active')</button>
                <button type="button" value="20"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.created_by')</button>
                <button type="button" value="22"
                    class="badge badge-pill badge-primary column-toggle">@lang('lang.edited_by')</button>
            </div>
        </div> --}}




        <div
            class="top-controls py-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">

        </div>

        <div class="card mt-1 mb-0">
            <div class="card-body py-2 px-4">

                <div class="table-responsive">
                    <table id="product_table" class="table" style="width: auto;margin-top: 5px !important;">
                        <thead>
                            <tr>
                                @if(env('ENABLE_POS_Branch',false))
                                <th>@lang('lang.select')</th>
                                @endif
                                <th>@lang('lang.select_to_delete')<br>
                                    <input type="checkbox" name="product_delete_all" class="product_delete_all" />
                                </th>

                                <th>@lang('lang.image')</th>
                                <th>@lang('lang.name')</th>
                                <th>@lang('lang.product_code')</th>
                                <th>
                                    @lang('lang.category')

                                </th>
                                <th>@lang('lang.purchase_history')</th>
                                <th>@lang('lang.batch_number')</th>
                                <th>@lang('lang.selling_price')</th>
                                <th>@lang('lang.tax')</th>
                                <th>@lang('lang.unit')</th>
                                <th>@lang('lang.size')</th>
                                <th class="sum">@lang('lang.current_stock')</th>
                                <th class="sum">@lang('lang.current_stock_value')</th>
                                <th>@lang('lang.customer_type')</th>
                                <th>@lang('lang.expiry_date')</th>
                                <th>@lang('lang.manufacturing_date')</th>
                                <th>@lang('lang.discount')</th>
                                @can('product_module.purchase_price.view')
                                <th>@lang('lang.purchase_price')</th>
                                @endcan
                                <th>@lang('lang.supplier')</th>
                                <th>@lang('lang.active')</th>
                                <th>@lang('lang.created_by')</th>
                                <th>@lang('lang.date_of_creation')</th>
                                <th>@lang('lang.edited_by')</th>
                                <th>@lang('lang.edited_at')</th>
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th style="text-align: right">@lang('lang.total')</th>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div
            class="bottom-controls mt-1 p-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">
            <!-- Pagination and other controls can go here -->
        </div>
    </div>
</section>


@endsection
@push('javascripts')
<script>
    $(document).on('click', '#delete_all', function() {
            var checkboxes = document.querySelectorAll('input[name="product_selected_delete"]');
            var selected_delete_ids = [];
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    selected_delete_ids.push(checkboxes[i].value);
                }
            }
            if (selected_delete_ids.length ==0){
                swal({
                    title: 'Warning',
                    text: "@lang('lang.sorry you should select products to continue delete')",
                    icon: 'warning',
                })
            }else{
                swal({
                    title: 'Are you sure?',
                    text: "@lang('lang.all_transactions_related_to_this_products_will_be_deleted')",
                    icon: 'warning',
                }).then(willDelete => {
                    if (willDelete) {
                        var check_password = $(this).data('check_password');
                        var href = $(this).data('href');
                        var data = $(this).serialize();

                        swal({
                            title: 'Please Enter Your Password',
                            content: {
                                element: "input",
                                attributes: {
                                    placeholder: "Type your password",
                                    type: "password",
                                    autocomplete: "off",
                                    autofocus: false,
                                },
                            },
                            inputAttributes: {
                                autocapitalize: 'off',
                                autoComplete: 'off',
                            },
                            focusConfirm: true
                        }).then((result) => {
                            if (result) {
                                $.ajax({
                                    url: check_password,
                                    method: 'POST',
                                    data: {
                                        value: result
                                    },
                                    dataType: 'json',
                                    success: (data) => {

                                        if (data.success == true) {
                                            swal(
                                                'Success',
                                                'Correct Password!',
                                                'success'
                                            );
                                            $.ajax({
                                                method: 'POST',
                                                url: "{{ action("ProductController@multiDeleteRow") }}",
                                                dataType: 'json',
                                                data: {
                                                    "ids": selected_delete_ids
                                                },
                                                success: function(result) {
                                                    if (result.success == true) {
                                                        swal(
                                                            'Success',
                                                            result.msg,
                                                            'success'
                                                        );
                                                        setTimeout(() => {
                                                            location
                                                                .reload();
                                                        }, 1500);
                                                        location.reload();
                                                    } else {
                                                        swal(
                                                            'Error',
                                                            result.msg,
                                                            'error'
                                                        );
                                                    }
                                                },
                                            });

                                        } else {
                                            swal(
                                                'Failed!',
                                                'Wrong Password!',
                                                'error'
                                            )

                                        }
                                    }
                                });
                            }
                        });
                    }
                });
            }








        });
</script>

@endpush

@section('javascript')
<script>
    var product_selected_send = [];
        $(document).ready(function() {
            // $('.column-toggle').each(function(i, obj) {
            //     if (i > 0) {
            //         i = i + 2;
            //     }
            //     @if (session('system_mode') != 'restaurant')
            //         @if (empty($page))
            //             if (i > 15) {
            //                 i = i + 1;
            //             }
            //         @else
            //             if (i > 14) {
            //                 i = i + 1;
            //             }
            //         @endif
            //     @else
            //         @if (empty($page))
            //             if (i > 12) {
            //                 i = i + 1;
            //             }
            //         @else
            //             if (i > 11) {
            //                 i = i + 1;
            //             }
            //         @endif
            //     @endif
            //     $(obj).val(i)
            // });
            product_table = $('#product_table').DataTable({
                lengthChange: true,
                paging: true,
                info: false,
                bAutoWidth: false,
                order: [],
                language: {
                    url: dt_lang_url,
                },
                lengthMenu: [
                    [10, 25, 50, 75, 100, 200, 500, -1],
                    [10, 25, 50, 75, 100, 200, 500, "All"],
                ],
                dom: "lBfrtip",
                // stateSave: true,
                buttons: buttons,
                processing: true,
                serverSide: true,
                aaSorting: [
                    [2, 'asc']
                ],
                "ajax": {
                    "url": "/product",
                    "data": function(d) {
                        d.product_id = $('#product_id').val();
                        d.product_class_id = $('#product_class_id').val();
                        d.category_id = $('#category_id').val();
                        d.sub_category_id = $('#sub_category_id').val();
                        d.brand_id = $('#brand_id').val();
                        d.supplier_id = $('#supplier_id').val();
                        d.unit_id = $('#unit_id').val();
                        d.size_id = $('#size_id').val();

                        d.tax_id = $('#tax_id').val();
                        d.store_id = $('#store_id').val();
                        d.customer_type_id = $('#customer_type_id').val();
                        d.active = $('#active').val();
                        d.created_by = $('#created_by').val();
                        d.show_zero_stocks = $('#show_zero_stocks').val();
                    }
                },
                columnDefs: [{
                    "targets": [0, 3],
                    "orderable": false,
                    "searchable": true
                }],
                columns: [
                    @if(env('ENABLE_POS_Branch',false))
                        {
                            data: "selection_checkbox_send",
                            name: "selection_checkbox_send",
                            searchable: false,
                            orderable: false,
                        },
                    @endif
                    {
                        data: "selection_checkbox_delete",
                        name: "selection_checkbox_delete",
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'variation_name',
                        name: 'products.name'
                    },
                    {
                        data: 'sub_sku',
                        name: 'variations.sub_sku'
                    },
                    {
                        data: 'product_class',
                        name: 'product_classes.name'
                    },
                     {
                        data: 'purchase_history',
                        name: 'purchase_history'
                    },
                    {
                        data: 'batch_number',
                        name: 'add_stock_lines.batch_number'
                    },
                    {
                        data: 'default_sell_price',
                        name: 'variations.default_sell_price'
                    },
                    {
                        data: 'tax',
                        name: 'taxes.name'
                    },
                   {
                        data: 'unit',
                        name: 'units.name'
                    },

                    {
                        data: 'size',
                        name: 'sizes.name'
                    },

                    {
                        data: 'current_stock',
                        name: 'current_stock',
                        searchable: false
                    },
                    {
                        data: 'current_stock_value',
                        name: 'current_stock_value',
                        searchable: false
                        @if (empty($page))
                            , visible: false
                        @endif
                    },
                    {
                        data: 'customer_type',
                        name: 'customer_type'
                    },
                    {
                        data: 'exp_date',
                        name: 'add_stock_lines.expiry_date'
                    },
                    {
                        data: 'manufacturing_date',
                        name: 'add_stock_lines.manufacturing_date'
                    },
                    {
                        data: 'discount',
                        name: 'discount'
                    },
                   @can('product_module.purchase_price.view')
                        {
                            data: 'default_purchase_price',
                            name: 'default_purchase_price',
                            searchable: false
                        },
                    @endcan
                    {
                        data: 'supplier_name',
                        name: 'supplier.name'
                    },
                    {
                        data: 'active',
                        name: 'active'
                    },
                    {
                        data: 'created_by',
                        name: 'users.name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'edited_by_name',
                        name: 'edited.name'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },

                ],
                createdRow: function(row, data, dataIndex) {

                },
                fnDrawCallback: function(oSettings) {
                    var intVal = function(i) {
                        return typeof i === "string" ?
                            i.replace(/[\$,]/g, "") * 1 :
                            typeof i === "number" ?
                            i :
                            0;
                    };

                    this.api()
                        .columns(".sum", {
                            page: "current"
                        })
                        .every(function() {
                            var column = this;
                            if (column.data().count()) {
                                var sum = column.data().reduce(function(a, b) {
                                    a = intVal(a);
                                    if (isNaN(a)) {
                                        a = 0;
                                    }

                                    b = intVal(b);
                                    if (isNaN(b)) {
                                        b = 0;
                                    }

                                    return a + b;
                                });
                                $(column.footer()).html(
                                    __currency_trans_from_en(sum, false)
                                );
                            }

                        });

                },

                initComplete: function(settings, json) {
                // Move elements into the .top-controls div after DataTable initializes
                $('.top-controls').append($('.dataTables_length').addClass('d-flex col-lg-3 col-9 mb-3 mb-lg-0 justify-content-center'));
                $('.top-controls').append($('.dt-buttons').addClass('col-lg-6 col-12 mb-3 mb-lg-0 d-flex dt-gap justify-content-center'));
                $('.top-controls').append($('.dataTables_filter').addClass('col-lg-3 col-9'));


                $('.bottom-controls').append($('.dataTables_paginate').addClass('col-lg-2 col-9 p-0'));
                $('.bottom-controls').append($('.dataTables_info'));
                }

            });
            $('#product_table').on('change', '.product_delete_all', function() {
                var isChecked = $(this).prop('checked');
                product_table.rows().nodes().to$().find('.product_selected_delete').prop('checked', isChecked);
            });


        });

        $(document).ready(function() {
            var hiddenColumnArray = JSON.parse('{!! addslashes(json_encode(Cache::get("key_" . auth()->id(), []))) !!}');

            $.each(hiddenColumnArray, function(index, value) {
                $('.column-toggle').each(function() {
                if ($(this).val() == value) {
                    toggleColumnVisibility(value, $(this));
                }
                });
            });

            $(document).on('click', '.column-toggle', function() {
                var column_index = parseInt($(this).val());
                toggleColumnVisibility(column_index, $(this));

                if (hiddenColumnArray.includes(column_index)) {
                hiddenColumnArray.splice(hiddenColumnArray.indexOf(column_index), 1);
                } else {
                hiddenColumnArray.push(column_index);
                }

                hiddenColumnArray = [...new Set(hiddenColumnArray)]; // Remove duplicates

                // Update the columnVisibility cache data
                $.ajax({
                url: '/update-column-visibility', // Replace with your route or endpoint for updating cache data
                method: 'POST',
                data: { columnVisibility: hiddenColumnArray },
                    success: function() {
                        console.log('Column visibility updated successfully.');
                    }
                });
            });

            function toggleColumnVisibility(column_index, this_btn) {
                var column = product_table.column(column_index);
                column.visible(!column.visible());

                if (column.visible()) {
                $(this_btn).addClass('badge-primary').removeClass('badge-warning');
                } else {
                $(this_btn).removeClass('badge-primary').addClass('badge-warning');
                }
            }
        });

        // var hiddenColumnArray = localStorage.getItem('columnVisibility') ? JSON.parse(localStorage.getItem('columnVisibility')) : [];
        // $(document).ready(function() {
        //     $.each(hiddenColumnArray, function(index, value) {
        //         $('.column-toggle').each(function() {
        //         if ($(this).val() == value) {
        //             toggleColumnVisibility(value, $(this));
        //         }
        //         });
        //     });
        // });

        // $(document).on('click', '.column-toggle', function() {
        //     var column_index = parseInt($(this).val());
        //     toggleColumnVisibility(column_index, $(this));
        //     if (hiddenColumnArray.includes(column_index)) {
        //         hiddenColumnArray.splice(hiddenColumnArray.indexOf(column_index), 1);
        //     } else {
        //         hiddenColumnArray.push(column_index);
        //     }

        //     // Remove duplicates from the hiddenColumnArray
        //     hiddenColumnArray = hiddenColumnArray.filter(function(value, index, self) {
        //         return self.indexOf(value) === index;
        //     });

        //     localStorage.setItem('columnVisibility', JSON.stringify(hiddenColumnArray));
        // });

        // function toggleColumnVisibility(column_index, this_btn) {
        //     var column = product_table.column(column_index);
        //     column.visible(!column.visible());

        //     if (column.visible()) {
        //         $(this_btn).addClass('badge-primary').removeClass('badge-warning');
        //     } else {
        //         $(this_btn).removeClass('badge-primary').addClass('badge-warning');
        //     }
        // }
        $(document).on('change', '.filter_product', function() {
            product_table.ajax.reload();
        })
        $(document).on('click', '.clear_filters', function() {
            $('.filter_product').val('');
            $('.filter_product').selectpicker('refresh');
            $('#product_id').val('');
            $('.show_zero_stocks').val(1);
            product_table.ajax.reload();
        });
        $(document).on('change', '.show_zero_stocks', function() {
            if(this.checked) {
                $('.show_zero_stocks').val(0);
            }else{
                $('.show_zero_stocks').val(1);
            }
            product_table.ajax.reload();
        });

        @if (!empty(request()->product_id))
            $(document).ready(function() {
                $('#product_id').val({{ request()->product_id }});
                product_table.ajax.reload();

                var container = '.view_modal';
                $.ajax({
                    method: 'get',
                    url: '/product/{{ request()->product_id }}',
                    dataType: 'html',
                    success: function(result) {
                        $(container).html(result).modal('show');
                    },
                });
            });
        @endif

        $(document).on('click', '.delete_product', function(e) {
            e.preventDefault();
            swal({
                title: 'Are you sure?',
                text: "@lang('lang.all_transactions_related_to_this_product_will_be_deleted')",
                icon: 'warning',
            }).then(willDelete => {
                if (willDelete) {
                    var check_password = $(this).data('check_password');
                    var href = $(this).data('href');
                    var data = $(this).serialize();

                    swal({
                        title: 'Please Enter Your Password',
                        content: {
                            element: "input",
                            attributes: {
                                placeholder: "Type your password",
                                type: "password",
                                autocomplete: "off",
                                autofocus: true,
                            },
                        },
                        inputAttributes: {
                            autocapitalize: 'off',
                            autoComplete: 'off',
                        },
                        focusConfirm: true
                    }).then((result) => {
                        if (result) {
                            $.ajax({
                                url: check_password,
                                method: 'POST',
                                data: {
                                    value: result
                                },
                                dataType: 'json',
                                success: (data) => {

                                    if (data.success == true) {
                                        swal(
                                            'Success',
                                            'Correct Password!',
                                            'success'
                                        );

                                        $.ajax({
                                            method: 'DELETE',
                                            url: href,
                                            dataType: 'json',
                                            data: data,
                                            success: function(result) {
                                                if (result.success ==
                                                    true) {
                                                    swal(
                                                        'Success',
                                                        result.msg,
                                                        'success'
                                                    );
                                                    setTimeout(() => {
                                                        location
                                                            .reload();
                                                    }, 1500);
                                                    location.reload();
                                                } else {
                                                    swal(
                                                        'Error',
                                                        result.msg,
                                                        'error'
                                                    );
                                                }
                                            },
                                        });

                                    } else {
                                        swal(
                                            'Failed!',
                                            'Wrong Password!',
                                            'error'
                                        )

                                    }
                                }
                            });
                        }
                    });
                }
            });
        });
        $(document).on("change", ".product_selected_send", function () {
            let this_variation_id = $(this).val();
            let this_product_id = $(this).data("product_id");
            if ($(this).prop("checked")) {
                var obj = {};
                obj["product_id"] = this_product_id;
                obj["variation_id"] = this_variation_id;
                product_selected_send.push(obj);
            } else {
                product_selected_send = product_selected_send.filter(function (item) {
                    return (
                        item.product_id !== this_product_id &&
                        item.variation_id !== this_variation_id
                    );
                });
            }
            //remove duplicate object from array
            product_selected_send = product_selected_send.filter(
                (value, index, self) =>
                    index ===
                    self.findIndex(
                        (t) =>
                            t.product_id === value.product_id &&
                            t.variation_id === value.variation_id
                    )
            );
            if(product_selected_send.length > 0){
                $('#send_to_branch').css('display','block');
            }else{
                $('#send_to_branch').css('display','none');
            }
        });

        $('#send_to_branch').click(function (e) {
            e.preventDefault();
            console.log(product_selected_send);
            $.ajax({
                method: "GET",
                url: '/product-send-branch',
                data: {
                    store_id: product_selected_send
                },
                success: function (result) {
                    if (result.success) {
                        $('#product_table').find('.product_selected_send').each(function(item) {
                            $(this).prop('checked', false)
                        });
                        $('#send_to_branch').css('display','none');
                        swal("Success!", result.msg, "success");

                    } else {
                        $('#send_to_branch').css('display','none');
                        $('#product_table').find('.product_selected_send').each(function(item) {
                            $(this).prop('checked', false)
                        });
                        swal("Error!", result.msg, "error");

                    }
                },
            });
        })

</script>
@endsection