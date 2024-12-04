@extends('layouts.app')
@section('title', __('lang.expenses'))


@section('content')
<section class="forms py-2">


    <div class="container-fluid px-2">

        <x-page-title>

            <h4 class="print-title">@lang('lang.expenses')</h4>

            <x-slot name="buttons">
                <x-collapse-button collapse-id="Filter" button-class="d-inline btn-secondary">
                    <div style="width: 20px">
                        <img class="w-100" src="{{ asset('front/white-filter.png') }}" alt="">
                    </div>
                </x-collapse-button>
            </x-slot>
        </x-page-title>
        <x-collapse-body collapse-id="Filter">
            <div class="col-md-12">
                {{-- <form action=""> --}}
                    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('expense_category_id', __('lang.expense_category'),
                                ['class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                {!! Form::select('expense_category_id', $expense_categories,
                                request()->expense_category_id, ['class' => 'form-control',
                                'placeholder' => __('lang.all'), 'data-live-search' =>
                                'true','id'=>'expense_category_id']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('expense_beneficiary_id',
                                __('lang.expense_beneficiary'), ['class' => app()->isLocale('ar') ? 'mb-1 label-ar' :
                                'mb-1 label-en']) !!}
                                {!! Form::select('expense_beneficiary_id', $expense_beneficiaries,
                                request()->expense_beneficiary_id, ['class' => 'form-control',
                                'placeholder' => __('lang.all'), 'data-live-search' =>
                                'true','id'=>'expense_beneficiary_id']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('store_id', __('lang.store'), ['class' => app()->isLocale('ar') ? 'mb-1
                                label-ar' : 'mb-1 label-en']) !!}
                                {!! Form::select('store_id', $stores, request()->store_id, ['class'
                                => 'form-control', 'placeholder' => __('lang.all'),
                                'data-live-search' => 'true','id'=>'store_id']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('store_paid_id', __('lang.store') . ' ' .
                                __('lang.paid_by'), ['class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1
                                label-en']) !!}
                                {!! Form::select('store_paid_id', $stores, request()->store_paid_id,
                                ['class' => 'form-control', 'placeholder' => __('lang.all'),
                                'data-live-search' => 'true','id'=>'store_paid_id']) !!}
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('start_date', __('lang.start_date'), ['class' => app()->isLocale('ar') ?
                                'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                {!! Form::text('start_date', request()->start_date, ['class' =>
                                'form-control','id'=>'start_date']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('start_time', __('lang.start_time'), ['class' => app()->isLocale('ar') ?
                                'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                {!! Form::text('start_time', request()->start_time, ['class' =>
                                'form-control time_picker sale_filter','id'=>'start_time']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('end_date', __('lang.end_date'), ['class' => app()->isLocale('ar') ?
                                'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                {!! Form::text('end_date', request()->end_date, ['class' =>
                                'form-control','id'=>'end_date']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('end_time', __('lang.end_time'), ['class' => app()->isLocale('ar') ?
                                'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                {!! Form::text('end_time', request()->end_time, ['class' =>
                                'form-control time_picker sale_filter','id'=>'end_time']) !!}
                            </div>
                        </div>
                        <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                            <button type="button"
                                class="btn btn-primary w-100 filter_product">@lang('lang.filter')</button>
                        </div>
                        <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">

                            <button class="btn btn-danger w-100 clear_filters">@lang('lang.clear_filters')</button>

                        </div>
                    </div>
                    {{--
                </form> --}}
            </div>
        </x-collapse-body>

        <div class="card mt-1 mb-0">
            <div class="card-body py-2 px-4">
                <div class="table-responsive">
                    <table class="table" style="width: auto" id="expense_table">
                        <thead>
                            <tr>
                                <th>@lang('lang.expense_category')</th>
                                <th>@lang('lang.beneficiary')</th>
                                <th>@lang('lang.store')</th>
                                <th class="sum">@lang('lang.amount_paid')</th>
                                <th>@lang('lang.created_by')</th>
                                <th>@lang('lang.creation_date')</th>
                                <th>@lang('lang.payment_date')</th>
                                <th>@lang('lang.next_payment_date')</th>
                                <th>@lang('lang.store') @lang('lang.paid_by')</th>
                                <th>@lang('lang.source_of_payment')</th>
                                <th>@lang('lang.files')</th>
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-right"><strong>@lang('lang.total')</strong></td>
                                <td class="sum"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>



    </div>

</section>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
            store_table = $('#expense_table').DataTable({
                lengthChange: true,
                paging: true,
                info: false,
                bAutoWidth: false,
                order: ['class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'],
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
                bSortable: true,
                bRetrieve: true,
                "ajax": {
                    "url": "/expense",
                    "data": function(d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.expense_category_id = $('#expense_category_id').val()
                        d.expense_beneficiary_id = $('#expense_beneficiary_id').val()
                        d.store_id = $('#store_id').val()
                        d.store_paid_id = $('#store_paid_id').val()
                        d.start_time = $('#start_time').val()
                        d.end_time = $('#end_time').val()
                    }
                },
                columnDefs: [{
                    // "targets": [0,2, 3],
                    "orderable": true,
                    "searchable": true
                },
                {
                    "targets": [2],
                    "orderable": true,
                    "searchable": true
                }],
                columns: [
                    {
                        data: 'expense_category',
                        name: 'expense_category'
                    },
                    {
                        data: 'beneficiary',
                        name: 'beneficiary'
                    },
                    {
                        data: 'store',
                        name: 'store'
                    },
                    {
                        data: 'final_total',
                        name: 'final_total'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        data: 'creation_date',
                        name: 'transaction_date'
                    },
                    {
                        data: 'payment_date',
                        name: 'payment_date'
                    },
                    {
                        data: 'next_payment_date',
                        name: 'next_payment_date'
                    },
                    {
                        data: 'paid_by',
                        name: 'paid_by'
                    },
                    {
                        data: 'source_name',
                        name: 'source_name'
                    },
                    {
                        data: 'files',
                        name: 'files'
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
                initComplete: function (settings, json) {
                // Move elements into the .top-controls div after DataTable initializes
                $('.top-controls').append($('.dataTables_length').addClass('d-flex col-lg-3 col-9 mb-3 mb-lg-0 justify-content-center'));
                $('.top-controls').append($('.dt-buttons').addClass('col-lg-6 col-12 mb-3 mb-lg-0 d-flex dt-gap justify-content-center'));
                $('.top-controls').append($('.dataTables_filter').addClass('col-lg-3 col-9'));


                $('.bottom-controls').append($('.dataTables_paginate').addClass('col-lg-2 col-9 p-0'));
                $('.bottom-controls').append($('.dataTables_info'));
                }
            });

        });
        $(document).on('click', '.filter_product', function() {
            store_table.ajax.reload();
        })
        $(document).on('click', '.clear_filters', function(e) {
            $('#start_date').val('');
            $('#end_date').val('');
            $('#expense_category_id').val('')
            $('#expense_beneficiary_id').val('')
            $('#store_id').val('')
            $('#store_paid_id').val('')
            $('#start_time').val('')
            $('#end_time').val('')
            store_table.ajax.reload();
        });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
@endsection