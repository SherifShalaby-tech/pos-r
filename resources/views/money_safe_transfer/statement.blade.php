@extends('layouts.app')
@section('title', __('lang.statement'))

@section('content')

<section class="forms py-2">

    <div class="container-fluid px-2">

        <div class="col-md-12 px-0 no-print">

            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('start_date', __('lang.start_date'), []) !!}
                                    {!! Form::text('start_date', request()->start_date, ['class' => 'form-control
                                    sale_filter']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('end_date', __('lang.end_date'), []) !!}
                                    {!! Form::text('end_date', request()->end_date, ['class' => 'form-control
                                    sale_filter']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="button"
                                    class="btn btn-danger mt-4 ml-2 clear_filter">@lang('lang.clear_filter')</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="safe_statement_table">
                            <thead>
                                <tr>
                                    <th>@lang('lang.date')</th>
                                    <th>@lang('lang.source')</th>
                                    <th>@lang('lang.job')</th>
                                    <th>@lang('lang.store')</th>
                                    <th>@lang('lang.comments')</th>
                                    <th class="currencies">@lang('lang.currency')</th>
                                    <th>@lang('lang.amount')</th>
                                    <th class="balance">@lang('lang.balance')</th>
                                    <th>@lang('lang.created_by')</th>
                                    <th>@lang('lang.date_and_time')</th>
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
                                    <th class="table_totals">@lang('lang.totals')</th>
                                    <td></td>
                                    <td></td>
                                    <td class="footer_balance">{{ @num_format($balance) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
            safe_statement_table = $("#safe_statement_table").DataTable({
                lengthChange: false,
                paging: false,
                searching: false,
                info: false,
                bAutoWidth: false,
                language: {
                    url: dt_lang_url,
                },
                dom: "lBfrtip",
                stateSave: true,
                buttons: buttons,
                processing: true,
                serverSide: true,
                ordering: false,
                aaSorting: [
                    // [0, "desc"]
                ],
                initComplete: function() {
                    $(this.api().table().container()).find('input').parent().wrap('<form>').parent()
                        .attr('autocomplete', 'off');
                },
                ajax: {
                    url: "/money-safe-transfer/get-statement/{{ $money_safe->id }}",
                    data: function(d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    },
                },
                columns: [{
                        data: "transaction_date",
                        name: "transaction_date"
                    },
                    {
                        data: "source",
                        name: "source"
                    },
                    {
                        data: "job_type",
                        name: "job_type.job_title"
                    },
                    {
                        data: "store_name",
                        name: "stores.name"
                    },
                    {
                        data: "comments",
                        name: "comments"
                    },
                    {
                        data: "currency",
                        name: "currencies.symbol"
                    },
                    {
                        data: "amount",
                        name: "amount"
                    },
                    {
                        data: "balance",
                        name: "balance"
                    },
                    {
                        data: "created_by_user",
                        name: "created_by_user.name"
                    },
                    {
                        data: "created_at",
                        name: "created_at"
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
                    var footer_html = '';
                    var column = this.api()
                        .columns(".balance", {
                            page: "current"
                        });
                    $.each(currency_obj, function(key, value) {
                        var balance = 0;
                        var currency_id = value.currency_id;
                        column.every(function() {
                            this.data().each(function(cell, i) {
                                console.log($(cell)
                                    .attr('class'));
                                if ('currency_id' + value.currency_id == $(cell)
                                    .attr('class')) {
                                    balance = intVal($(cell).text());
                                }
                            });

                        })
                        footer_html +=
                            `<h6 class="currency_total currency_total_${value.currency_id}" data-currency_id="${value.currency_id}" data-is_default="${value.is_default}" data-conversion_rate="${value.conversion_rate}" data-base_conversion="${balance * value.conversion_rate}" data-orig_value="${balance}">${__currency_trans_from_en(balance, false)}</h6>`
                    });
                    $('.footer_balance').html(
                        footer_html
                    );
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
            $(document).on('click', '.clear_filter', function() {
                $('.sale_filter').val('');
                $('.sale_filter').selectpicker('refresh');
                safe_statement_table.ajax.reload();
            });
            $(document).on('change', '.sale_filter', function() {
                safe_statement_table.ajax.reload();
            });
        })
</script>
@endsection
