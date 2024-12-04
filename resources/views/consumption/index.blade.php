@extends('layouts.app')
@section('title', __('lang.list_view_the_consumption_of_raw_material'))

@section('content')
<section class="forms py-2">


    <div class="container-fluid px-2">
        <x-page-title>

            <h4 class="print-title">@lang('lang.list_view_the_consumption_of_raw_material')</h4>

            <x-slot name="buttons">
                @can('product_module.consumption.create_and_edit')
                <a style="color: white" href="{{action('ConsumptionController@create')}}" class="btn btn-primary"><i
                        class="dripicons-plus"></i>
                    @lang('lang.add_manual_consumption')</a>
                @endcan

                <x-collapse-button collapse-id="Filter" button-class="d-inline btn-secondary">
                    <div style="width: 20px">
                        <img class="w-100" src="{{ asset('front/white-filter.png') }}" alt="">
                    </div>
                </x-collapse-button>
            </x-slot>
        </x-page-title>

        <x-collapse-body collapse-id="Filter">
            <div class="col-md-12">

                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('start_date', __('lang.start_date'), [ 'class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::text('start_date', request()->start_date, ['class' => 'form-control filter']) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('start_time', __('lang.start_time'), [ 'class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::text('start_time', null, ['class' => 'form-control time_picker filter']) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('end_date', __('lang.end_date'), [ 'class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::text('end_date', request()->end_date, ['class' => 'form-control filter']) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('end_time', __('lang.end_time'), [ 'class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::text('end_time', null, ['class' => 'form-control time_picker filter']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('raw_material_id', __('lang.raw_material') . ':
                            ('.__('lang.that_raw_materials_are_used_for').')', [ 'class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('raw_material_id', $raw_materials, request()->raw_material_id, ['class'
                            => 'form-control filter
                            selectpicker', 'data-live-search' =>'true', 'placeholder' => __('lang.all')]) !!}
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('brand_id', __('lang.brand'), [ 'class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('brand_id', $brands, request()->brand_id, ['class' => 'form-control
                            filter
                            selectpicker', 'data-live-search' =>'true', 'placeholder' => __('lang.all')]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('variation_id', __('lang.product'), [ 'class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('variation_id', $products, request()->variation_id, ['class'
                            => 'form-control filter
                            selectpicker', 'data-live-search' =>'true', 'placeholder' => __('lang.all')]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('store_id', __('lang.store'), [ 'class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('store_id', $stores, request()->store_id, ['class' =>
                            'form-control filter', 'placeholder' => __('lang.all'),'data-live-search'=>"true"])
                            !!}
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('created_by', __('lang.chef'), [ 'class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::select('created_by', $users, request()->created_by, ['class'
                            => 'form-control filter
                            selectpicker', 'data-live-search' =>'true', 'placeholder' => __('lang.all')]) !!}
                        </div>
                    </div>
                    <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                        <button class="btn w-100 btn-danger clear_filters">@lang('lang.clear_filters')</button>
                    </div>
                </div>
            </div>
        </x-collapse-body>


        <div
            class="top-controls py-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">

        </div>

        <div class="card mt-1 mb-0">
            <div class="card-body py-2 px-4">
                <div class="table-responsive">
                    <table id="raw_material_table" class="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>@lang('lang.raw_material')</th>
                                <th>@lang('lang.current_stock')</th>
                                <th>@lang('lang.value_of_current_stock')</th>
                                <th>@lang('lang.products')</th>
                                <th>@lang('lang.chef')</th>
                                <th>@lang('lang.remaining_qty_sufficient_for')</th>

                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
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

@section('javascript')
<script>
    $(document).ready( function(){
        raw_material_table = $('#raw_material_table').DataTable({
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
            buttons: buttons,
            processing: true,
            serverSide: true,
            aaSorting: [[2, 'asc']],
             "ajax": {
                "url": "/consumption",
                "data": function ( d ) {
                    d.raw_material_id = $('#raw_material_id').val();
                    d.variation_id = $('#variation_id').val();
                    d.brand_id = $('#brand_id').val();
                    d.store_id = $('#store_id').val();
                    d.created_by = $('#created_by').val();
                    d.start_date = $("#start_date").val();
                    d.start_time = $("#start_time").val();
                    d.end_date = $("#end_date").val();
                    d.end_time = $("#end_time").val();
                }
            },
            columnDefs: [ {
                "targets": [5],
                "orderable": false,
                "searchable": false
            } ],
            columns: [
                { data: 'raw_material_name', name: 'raw_material.name'  },
                { data: 'product_current_stock', name: 'product_current_stock', searchable: false},
                { data: 'value_of_current_stock', name: 'value_of_current_stock', searchable: false  },
                { data: 'products', name: 'products.name'},
                { data: 'chef', name: 'users.name'},
                { data: 'remaining_qty_sufficient_for', name: 'remaining_qty_sufficient_for'},
                { data: 'action', name: 'action'},

            ],
            createdRow: function( row, data, dataIndex ) {

            },
            fnDrawCallback: function(oSettings) {
                __currency_convert_recursively($('#raw_material_table'));
            },
            initComplete: function (settings, json) {
            // Move elements into the .top-controls div after DataTable initializes
            $('.top-controls').append($('.dataTables_length').addClass('d-flex col-lg-3 col-9 mb-3 mb-lg-0 justify-content-center'));
            $('.top-controls').append($('.dt-buttons').addClass('col-lg-6 col-12 mb-3 mb-lg-0 d-flex dt-gap justify-content-center'));
            $('.top-controls').append($('.dataTables_filter').addClass('col-lg-3 col-9'));


            $('.bottom-controls').append($('.dataTables_paginate').addClass('col-lg-2 col-9 p-0'));
            $('.bottom-controls').append($('.dataTables_info'));
            }
        });

        $(document).on('change', '.filter', function(){
            raw_material_table.ajax.reload();
        })
        $(document).on('click', '.clear_filters', function(){
            $('.filter').val('');
            $('.filter').selectpicker('refresh')
            raw_material_table.ajax.reload();
        })
        $('.time_picker').focusout(function (event) {
            raw_material_table.ajax.reload();
        });
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
@endsection