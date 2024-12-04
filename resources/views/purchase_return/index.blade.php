@extends('layouts.app')
@section('title', __('lang.purchase_return'))

@section('content')

<section class="forms py-2">

    <div class="container-fluid px-2 no-print">

        <x-page-title>

            <h4 class="print-title">@lang('lang.all_return_purchase')</h4>

            <x-collapse-button collapse-id="Filter" button-class="d-inline btn-secondary">
                <div style="width: 20px">
                    <img class="w-100" src="{{ asset('front/white-filter.png') }}" alt="">
                </div>
            </x-collapse-button>
        </x-page-title>

        <x-collapse-body collapse-id="Filter">
            <div class="col-md-12">

                <form action="">
                    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('supplier_id', __('lang.supplier'), ['class' =>
                                app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                {!! Form::select('supplier_id', $suppliers, request()->supplier_id, ['class' =>
                                'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('payment_status', __('lang.payment_status'), ['class' =>
                                app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                {!! Form::select('payment_status', $payment_status_array,
                                request()->payment_status,
                                ['class' =>
                                'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('start_date', __('lang.start_date'), ['class' =>
                                app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                {!! Form::text('start_date', request()->start_date, ['class' => 'form-control'])
                                !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('end_date', __('lang.end_date'), ['class' => app()->isLocale('ar') ?
                                'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                {!! Form::text('end_date', request()->end_date, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">

                            <button type="submit" class="btn btn-primary w-100">@lang('lang.filter')</button>
                        </div>
                        <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                            <a href="{{action('PurchaseReturnController@index')}}"
                                class="btn btn-danger w-100">@lang('lang.clear_filter')</a>
                        </div>
                    </div>
                </form>
            </div>
        </x-collapse-body>
        <div
            class="top-controls py-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">

        </div>
        <div class="card mt-1 mb-0">
            <div class="card-body py-2 px-4">
                <div class="table-responsive no-print">
                    <table id="sales_table" class="table dataTable">
                        <thead>
                            <tr>
                                <th>@lang('lang.date')</th>
                                <th>@lang('lang.reference')</th>
                                <th>@lang('lang.supplier')</th>
                                <th>@lang('lang.payment_status')</th>
                                <th>@lang('lang.payment_type')</th>
                                <th class="sum">@lang('lang.grand_total')</th>
                                <th>@lang('lang.createdBy')</th>
                                <th>@lang('lang.returned_by')</th>
                                <th class="sum">@lang('lang.paid')</th>
                                <th class="sum">@lang('lang.due')</th>
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total_paid = 0;
                            $total_due = 0;
                            @endphp
                            @foreach($purchase_returns as $sale)
                            <tr>
                                <td>{{@format_date($sale->transaction_date)}}</td>
                                <td>{{$sale->invoice_no}}</td>
                                <td>@if(!empty($sale->supplier)){{$sale->supplier->name}}@endif</td>
                                <td>@if(!empty($payment_status_array[$sale->payment_status])){{$payment_status_array[$sale->payment_status]}}@endif
                                </td>
                                <td>@if(!empty($sale->transaction_payments->count() >
                                    0)){{$payment_types[$sale->transaction_payments->first()->method]}}@endif
                                </td>
                                <td>{{@num_format($sale->final_total)}}</td>
                                <td>{{$sale->created_by_user->name}}</td>
                                <td>{{$sale->created_by_user->name}}</td>
                                <td>{{@num_format($sale->transaction_payments->sum('amount'))}}</td>
                                <td>{{@num_format($sale->final_total - $sale->transaction_payments->sum('amount'))}}
                                </td>

                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">@lang('lang.action')
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                            user="menu">
                                            @can('return.purchase_return.view')
                                            <li>

                                                <a data-href="{{action('PurchaseReturnController@show', $sale->id)}}"
                                                    data-container=".view_modal" class="btn btn-modal"><i
                                                        class="fa fa-eye"></i>
                                                    @lang('lang.view')</a>
                                            </li>
                                            <li class="divider"></li>
                                            @endcan
                                            @can('return.purchase_return.create_and_edit')
                                            <li>
                                                <a href="{{action('PurchaseReturnController@edit', $sale->id)}}"
                                                    class="btn"><i class="dripicons-document-edit"></i>
                                                    @lang('lang.edit')</a>
                                            </li>
                                            <li class="divider"></li>
                                            @endcan
                                            @can('return.purchase_return_pay.create_and_edit')
                                            @if($sale->payment_status != 'paid')
                                            <li>
                                                <a data-href="{{action('TransactionPaymentController@addPayment', ['id' => $sale->id])}}"
                                                    data-container=".view_modal" class="btn btn-modal"><i
                                                        class="fa fa-plus"></i>
                                                    @lang('lang.add_payment')</a>
                                            </li>
                                            @endif
                                            @endcan
                                            @can('return.purchase_return_pay.view')
                                            @if($sale->payment_status != 'pending')
                                            <li>
                                                <a data-href="{{action('TransactionPaymentController@show', $sale->id)}}"
                                                    data-container=".view_modal" class="btn btn-modal"><i
                                                        class="fa fa-money"></i>
                                                    @lang('lang.view_payments')</a>
                                            </li>
                                            @endif
                                            @endcan
                                            @can('return.purchase_return.delete')
                                            <li>
                                                <a data-href="{{action('PurchaseReturnController@destroy', $sale->id)}}"
                                                    data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
                                                    class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                    @lang('lang.delete')</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @php
                            $total_paid += $sale->transaction_payments->sum('amount');
                            $total_due += $sale->final_total - $sale->transaction_payments->sum('amount');
                            @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th style="text-align: right">@lang('lang.totals')</th>
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
<!-- This will be printed -->
<section class="invoice print_section print-only" id="receipt_section"> </section>
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
    })

    function pos_print(receipt) {
        $("#receipt_section").html(receipt);
        __currency_convert_recursively($("#receipt_section"));
        __print_receipt("receipt_section");
    }

    table
    .column( '0:visible' )
    .order( 'desc' )
    .draw();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
@endsection