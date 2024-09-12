@extends('layouts.app')
@section('title', __('lang.money_safe'))

@section('content')

<section class="forms pt-2">

    <div class="container-fluid">

        <div class="col-md-12 px-0 no-print">

            <x-page-title>
                <h4 class="print-title">@lang('lang.money_safe')</h4>

                <x-slot name="buttons">
                    @can('safe_module.money_safe.create_and_edit')
                    <a style="color: white" data-href="{{ action('MoneySafeController@create') }}"
                        data-container=".view_modal" class="btn btn-modal btn-primary"><i class="dripicons-plus"></i>
                        @lang('lang.add_money_safe')</a>
                    @endcan

                </x-slot>
            </x-page-title>

            <div
                class="top-controls py-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">

            </div>
            <div class="card mt-1 mb-0">
                <div class="card-body py-2 px-4">
                    <div class="table-responsive">
                        <table class="table" id="money_safe_table">
                            <thead>
                                <tr>
                                    <th>@lang('lang.store')</th>
                                    <th>@lang('lang.safe_name')</th>
                                    <th>@lang('lang.type')</th>
                                    <th>@lang('lang.IBAN')</th>
                                    <th class="">@lang('lang.current_balance')</th>
                                    <th>@lang('lang.creation_date')</th>
                                    <th>@lang('lang.created_by')</th>
                                    <th>@lang('lang.edited_by')</th>
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
                                    <th class="table_totals">@lang('lang.totals')</th>
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
    @endsection

    @section('javascript')
    <script>
        $(document).ready(function() {
            money_safe_table = $("#money_safe_table").DataTable({
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
                    url: "/money-safe",
                    data: function(d) {

                    },
                },
                columns: [{
                        data: "store_name",
                        name: "stores.name"
                    },

                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "type",
                        name: "type"
                    },
                    {
                        data: "IBAN",
                        name: "IBAN"
                    },
                    // {
                    //     data: "currency",
                    //     name: "currencies.symbol"
                    // },
                    {
                        data: "balance",
                        name: "balance"
                    },
                    {
                        data: "created_at",
                        name: "created_at"
                    },
                    {
                        data: "created_by_user",
                        name: "created_by_user.name"
                    },
                    {
                        data: "edited_by_user",
                        name: "edited_by_user.name"
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
                money_safe_table.ajax.reload();
            });
        });

        $(document).on("click", ".currency_total_ms", function() {
            let currency_id = $(this).data("currency_id");
            let h6 = $(this).parent("h6");

            $.each(currency_obj, function(key, value) {
                if (currency_id == value.currency_id) {
                    converted_to_rate = value.conversion_rate;
                }
            });

            let this_ele = $(h6).find(".currency_total_" + currency_id);
            let conversion_rate = this_ele.data("conversion_rate");
            let total_base_value = parseFloat(this_ele.data("base_conversion"));
            $(h6)
                .siblings()
                .find(".currency_total")
                .each(function() {
                    total_base_value += parseFloat($(this).data("base_conversion"));
                    $(this).find(".total").text(__currency_trans_from_en(0, false));
                });
            let converted_value = total_base_value / conversion_rate;
            $(this_ele)
                .find(".total")
                .text(__currency_trans_from_en(converted_value, false));
        });
    </script>
    @endsection