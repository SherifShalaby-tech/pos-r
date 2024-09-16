@extends('layouts.app')
@section('title', __('lang.receivable_report'))

@section('content')
<section class="forms py-2">

    <div class="container-fluid px-2">
        <div class="col-md-12 px-0  no-print">

            <x-page-title>
                <h4 class="print-title">@lang('lang.receivable_report')</h4>
            </x-page-title>

            <x-collapse collapse-id="Filter" button-class="d-flex btn-secondary" group-class="mb-1" body-class="py-1">

                <x-slot name="button">
                    {{-- @lang('lang.filter') --}}
                    <div style="width: 20px">
                        <img class="w-100" src="{{ asset('front/white-filter.png') }}" alt="">
                    </div>
                </x-slot>
                <div class="col-md-12">
                    <form action="">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('start_date', __('lang.start_date'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('start_date', request()->start_date, ['class' => 'form-control
                                    sale_filter'])
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('start_time', __('lang.start_time'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('start_time', request()->start_time, ['class' => 'form-control
                                    sale_filter
                                    time_picker sale_filter']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('end_date', __('lang.end_date'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('end_date', request()->end_date, ['class' => 'form-control
                                    sale_filter']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('end_time', __('lang.end_time'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('end_time', request()->end_time, ['class' => 'form-control
                                    sale_filter
                                    time_picker
                                    sale_filter']) !!}
                                </div>
                            </div>

                            <div class="col-md-2 ">
                                <div class="form-group">
                                    {!! Form::label('customer_id', __('lang.customer'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('customer_id', $customers, request()->customer_id, ['class'
                                    =>
                                    'form-control sale_filter', 'placeholder' =>
                                    __('lang.all'),'data-live-search'=>"true"]) !!}
                                </div>
                            </div>
                            <div class="col-md-2 ">
                                <div class="form-group">
                                    {!! Form::label('customer_type_id', __('lang.customer_type'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('customer_type_id', $customer_types, request()->customer_type_id,
                                    ['class'
                                    =>
                                    'form-control sale_filter', 'placeholder' =>
                                    __('lang.all'),'data-live-search'=>"true"]) !!}
                                </div>
                            </div>
                            @if(session('user.is_superadmin'))
                            <div class="col-md-2 ">
                                <div class="form-group">
                                    {!! Form::label('store_id', __('lang.store'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('store_id', $stores, request()->store_id, ['class' =>
                                    'form-control sale_filter', 'placeholder' =>
                                    __('lang.all'),'data-live-search'=>"true"]) !!}
                                </div>
                            </div>
                            <div class="col-md-2 ">
                                <div class="form-group">
                                    {!! Form::label('pos_id', __('lang.pos'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('pos_id', $store_pos, request()->pos_id, ['class' =>
                                    'form-control sale_filter', 'placeholder' =>
                                    __('lang.all'),'data-live-search'=>"true"]) !!}
                                </div>
                            </div>
                            @endif
                            <div class="col-md-2 ">
                                <div class="form-group">
                                    {!! Form::label('product_id', __('lang.product'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('product_id', $products, request()->product_id, ['class' =>
                                    'form-control sale_filter', 'placeholder' =>
                                    __('lang.all'),'data-live-search'=>"true"]) !!}
                                </div>
                            </div>

                            <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                                <button type="button"
                                    class="btn btn-danger w-100 clear_filter">@lang('lang.clear_filter')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </x-collapse>


            <div
                class="top-controls py-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">

            </div>
            <div class="card mt-1 mb-0">
                <div class="card-body py-2 px-4">
                    <div class="table-responsive">
                        <table id="receivable_report_table" class="table">
                            <thead>
                                <tr>
                                    <th>@lang('lang.date')</th>
                                    <th>@lang('lang.reference')</th>
                                    <th>@lang('lang.customer')</th>
                                    <th>@lang('lang.sale_status')</th>
                                    <th>@lang('lang.payment_status')</th>
                                    <th class="currencies">@lang('lang.received_currency')</th>
                                    <th class="sum">@lang('lang.grand_total')</th>
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
                                    <th class="table_totals text-primary" style="text-align: right">@lang('lang.totals')
                                    </th>
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
    </div>
</section>
@endsection

@section('javascript')
<script>
    $(document).on('click', '.print-invoice', function(){
        $.ajax({
            method: 'get',
            url: $(this).data('href'),
            data: {  },
            success: function(result) {
                if(result.success){
                    pos_print(result.html_content);
                }
            },
        });
    });

    $(document).ready(function() {
            receivable_report_table = $("#receivable_report_table").DataTable({
                lengthChange: true,
                paging: true,
                info: false,
                bAutoWidth: false,
                // order: [],
                language: {
                    url: dt_lang_url,
                },
                lengthMenu: [
                    [10, 25, 50, 75, 100, 200, 500, -1],
                    [10, 25, 50, 75, 100, 200, 500, "All"],
                ],
                dom: "lBfrtip",
                stateSave: true,
                buttons: buttons,
                processing: true,
                serverSide: true,
                aaSorting: [
                    [0, "desc"]
                ],
                initComplete: function() {
                    $(this.api().table().container()).find('input').parent().wrap('<form>').parent()
                        .attr('autocomplete', 'off');
                },
                ajax: {
                    url: "/report/get-receivable-report",
                    data: function(d) {
                        d.customer_id = $("#customer_id").val();
                        d.customer_type_id = $("#customer_type_id").val();
                        d.store_id = $("#store_id").val();
                        d.pos_id = $("#pos_id").val();
                        d.start_date = $("#start_date").val();
                        d.start_time = $("#start_time").val();
                        d.end_date = $("#end_date").val();
                        d.end_time = $("#end_time").val();
                    },
                },
                columnDefs: [{
                        targets: "date",
                        type: "date-eu",
                    },
                ],
                columns: [{
                        data: "transaction_date",
                        name: "transaction_date"
                    },
                    {
                        data: "invoice_no",
                        name: "invoice_no"
                    },
                    {
                        data: "customer_name",
                        name: "customers.name"
                    },

                    {
                        data: "status",
                        name: "transactions.status"
                    },
                    {
                        data: "payment_status",
                        name: "transactions.payment_status"
                    },
                    {
                        data: "received_currency_symbol",
                        name: "received_currency_symbol",
                        searchable: false
                    },
                    {
                        data: "final_total",
                        name: "final_total"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                createdRow: function(row, data, dataIndex) {},
                footerCallback: function(row, data, start, end, display) {
                    var intVal = function(i) {
                        return typeof i === "string" ?
                            i.replace(/[\$,]/g, "") * 1 :
                            typeof i === "number" ?
                            i :
                            0;
                    };

                    this.api()
                        .columns(".currencies", {
                            page: "current"
                        }).every(function() {
                            var column = this;
                            let currencies_html = '';
                            $.each(currency_obj, function(key, value) {
                                currencies_html +=
                                    `<h6 class="footer_currency" data-is_default="${value.is_default}"  data-currency_id="${value.currency_id}">${value.symbol}</h6>`
                                $(column.footer()).html(currencies_html);
                            });
                        })
                    this.api()
                        .columns(".sum", {
                            page: "current"
                        })
                        .every(function() {
                            var column = this;
                            var currency_total = [];
                            $.each(currency_obj, function(key, value) {
                                currency_total[value.currency_id] = 0;
                            });
                            column.data().each(function(group, i) {
                                b = $(group).text();
                                currency_id = $(group).data('currency_id');

                                $.each(currency_obj, function(key, value) {
                                    if (currency_id == value.currency_id) {
                                        currency_total[value.currency_id] += intVal(
                                            b);
                                    }
                                });
                            });
                            var footer_html = '';
                            $.each(currency_obj, function(key, value) {
                                footer_html +=
                                    `<h6 class="currency_total currency_total_${value.currency_id}" data-currency_id="${value.currency_id}" data-is_default="${value.is_default}" data-conversion_rate="${value.conversion_rate}" data-base_conversion="${currency_total[value.currency_id] * value.conversion_rate}" data-orig_value="${currency_total[value.currency_id]}">${__currency_trans_from_en(currency_total[value.currency_id], false)}</h6>`
                            });
                            $(column.footer()).html(
                                footer_html
                            );
                        });
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
            $(document).on('change', '.sale_filter', function() {
                receivable_report_table.ajax.reload();
            });
        })

        $(document).on('click', '.clear_filter', function() {
            $('.sale_filter').val('');
            $('.sale_filter').selectpicker('refresh');
            receivable_report_table.ajax.reload();
        });
</script>
@endsection
