@extends('layouts.app')
@section('title', __('lang.dining_in_sales'))

@section('content')

<section class="forms py-2">

    <div class="container-fluid px-2">

        <div class="col-md-12 px-0  no-print">
            <x-page-title>
                <h4>@lang('lang.dining_in_sales')</h4>
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
                                    {!! Form::label('start_date', __('lang.start_date'), ['class' =>
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('start_date', request()->start_date, ['class' => 'form-control
                                    filter']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('start_time', __('lang.start_time'), ['class' =>
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('start_time', null, ['class' => 'form-control time_picker filter'])
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('end_date', __('lang.end_date'), ['class' => app()->isLocale('ar') ?
                                    'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('end_date', request()->end_date, ['class' => 'form-control filter'])
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('end_time', __('lang.end_time'), ['class' => app()->isLocale('ar') ?
                                    'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('end_time', null, ['class' => 'form-control time_picker filter']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('dining_room_id', __('lang.dining_room'), ['class' =>
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('dining_room_id', $dining_rooms, request()->dining_room_id,
                                    ['class' => 'form-control filter', 'placeholder' => __('lang.all'),
                                    'data-live-search' => 'true']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('dining_table_id', __('lang.dining_table'), ['class' =>
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('dining_table_id', $dining_tables, request()->dining_table_id,
                                    ['class' => 'form-control filter', 'placeholder' => __('lang.all'),
                                    'data-live-search' => 'true']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('method', __('lang.payment_type'), ['class' => app()->isLocale('ar')
                                    ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('method', $payment_types, request()->method, ['class' =>
                                    'form-control filter', 'placeholder' => __('lang.all'), 'data-live-search' =>
                                    'true']) !!}
                                </div>
                            </div>

                            <div class="col-md-2 d-flex align-items-end justify-content-center mb-11px">

                                <button href="{{ action('ReportController@getDiningRoomReport') }}" type="button"
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
                        <table class="table" id="sales_table">
                            <thead>
                                <tr>
                                    <th>@lang('lang.date')</th>
                                    <th>@lang('lang.reference')</th>
                                    <th>@lang('lang.customer')</th>
                                    <th>@lang('lang.dining_room')</th>
                                    <th>@lang('lang.dining_table')</th>
                                    <th class="sum">@lang('lang.amount')</th>
                                    <th class="sum">@lang('lang.paid')</th>
                                    <th class="sum">@lang('lang.due')</th>
                                    <th>@lang('lang.payment_type')</th>
                                    <th class="notexport">@lang('lang.action')</th>
                                </tr>
                            </thead>

                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
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
    </div>
</section>

<!-- This will be printed -->
<section class="invoice print_section print-only" id="receipt_section"> </section>
@endsection


@section('javascript')
<script>
    $(document).ready(function() {
            sales_table = $("#sales_table").DataTable({
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
                    url: "/report/get-dining-report",
                    data: function(d) {
                        d.dining_room_id = $("#dining_room_id").val();
                        d.dining_table_id = $("#dining_table_id").val();
                        d.method = $("#method").val();
                        d.start_date = $("#start_date").val();
                        d.start_time = $("#start_time").val();
                        d.end_date = $("#end_date").val();
                        d.end_time = $("#end_time").val();
                        d.created_by = $("#created_by").val();
                    },
                },
                columnDefs: [{
                        targets: "date",
                        type: "date-eu",
                    },
                    {
                        targets: [8],
                        orderable: false,
                        searchable: false,
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
                        data: "dining_room",
                        name: "dining_rooms.name"
                    },
                    {
                        data: "dining_table",
                        name: "dining_tables.name"
                    },
                    {
                        data: "final_total",
                        name: "final_total"
                    },
                    {
                        data: "paid",
                        name: "transaction_payments.amount",
                        searchable: false
                    },
                    {
                        data: "due",
                        name: "transaction_payments.amount",
                        searchable: false
                    },
                    {
                        data: "method",
                        name: "transaction_payments.method",
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
                initComplete: function (settings, json) {
                // Move elements into the .top-controls div after DataTable initializes
                $('.top-controls').append($('.dataTables_length').addClass('d-flex col-lg-3 col-9 mb-3 mb-lg-0 justify-content-center'));
                $('.top-controls').append($('.dt-buttons').addClass('col-lg-6 col-12 mb-3 mb-lg-0 d-flex dt-gap justify-content-center'));
                $('.top-controls').append($('.dataTables_filter').addClass('col-lg-3 col-9'));


                $('.bottom-controls').append($('.dataTables_paginate').addClass('col-lg-2 col-9 p-0'));
                $('.bottom-controls').append($('.dataTables_info'));
                }
            });
            $(document).on('change', '.filter', function() {
                sales_table.ajax.reload();
            });
        })
        $(document).on('click', '.clear_filter', function() {
            $('.filter').val('');
            $('.filter').selectpicker('refresh');
            sales_table.ajax.reload();
        });
        $('.time_picker').focusout(function(event) {
            sales_table.ajax.reload();
        });

        $(document).on('change', '#dining_room_id', function() {
            let dining_room_id = $(this).val();

            $.ajax({
                method: 'GET',
                url: '/dining-table/get-dropdown-by-dining-room/' + dining_room_id,
                data: {},
                success: function(result) {
                    $('#dining_table_id').html(result);
                    $('#dining_table_id').selectpicker('refresh');
                },
            });

        });

        $(document).on('click', '.print-invoice', function() {
            $('.view_modal').modal('hide')
            $.ajax({
                method: 'get',
                url: $(this).data('href'),
                data: {},
                success: function(result) {
                    if (result.success) {
                        pos_print(result.html_content);
                    }
                },
            });
        })

        function pos_print(receipt) {
            $("#receipt_section").html(receipt);
            __currency_convert_recursively($("#receipt_section"));
            __print_receipt("receipt_section");
        }
</script>
@endsection
