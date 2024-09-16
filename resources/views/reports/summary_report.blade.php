@extends('layouts.app')
@section('title', __('lang.summary_report'))

@section('content')
<section class="forms py-2">

    <div class="container-fluid px-2">
        <div class="col-md-12 px-0 no-print">
            <x-page-title>

                <h4>@lang('lang.summary_report')</h4>


                <x-slot name="buttons">

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
                    <form action="">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('start_date', __('lang.start_date'), ['class' =>
                                    app()->isLocale('ar') ?
                                    'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('start_date', request()->start_date, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('start_time', __('lang.start_time'), ['class' =>
                                    app()->isLocale('ar') ?
                                    'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('start_time', request()->start_time, [
                                    'class' => 'form-control
                                    time_picker sale_filter',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('end_date', __('lang.end_date'), ['class' => app()->isLocale('ar') ?
                                    'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('end_date', request()->end_date, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('end_time', __('lang.end_time'), ['class' => app()->isLocale('ar') ?
                                    'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('end_time', request()->end_time, [
                                    'class' => 'form-control time_picker
                                    sale_filter',
                                    ]) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('supplier_id', __('lang.supplier'), ['class' =>
                                    app()->isLocale('ar') ?
                                    'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('supplier_id', $suppliers, request()->supplier_id, ['class'
                                    =>
                                    'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                </div>
                            </div>
                            @if(session('user.is_superadmin'))
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('store_id', __('lang.store'), ['class' => app()->isLocale('ar') ?
                                    'mb-1
                                    label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('store_id', $stores, request()->store_id, ['class' =>
                                    'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('pos_id', __('lang.pos'), ['class' => app()->isLocale('ar') ? 'mb-1
                                    label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('pos_id', $store_pos, request()->pos_id, ['class' =>
                                    'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                </div>
                            </div>
                            @endif
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('product_id', __('lang.product'), ['class' => app()->isLocale('ar')
                                    ?
                                    'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('product_id', $products, request()->product_id, ['class' =>
                                    'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                </div>
                            </div>

                            <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                                <button type="submit" class="btn btn-primary w-100">@lang('lang.filter')</button>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                                <a href="{{action('ReportController@getPayableReport')}}"
                                    class="btn btn-danger w-100">@lang('lang.clear_filter')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </x-collapse>


            <div class="row px-2">
                <div class="col-md-2 px-1 mb-1">
                    <div class="card mt-1 mb-0 h-100">
                        <div class="card-body py-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="font-size: 1.2 rem; color: var(--primary-color);">
                                            <h5
                                                class="mb-0 @if (app()->isLocale('ar')) text-right @else text-left @endif ">
                                                @lang('lang.purchase')</h5>
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>@lang('lang.amount')</td>
                                        <td style="text-align: right">{{@num_format($add_stocks->total_amount)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.purchase')</td>
                                        <td style="text-align: right">{{@num_format($add_stocks->total_count)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.paid')</td>
                                        <td style="text-align: right">{{@num_format($add_stocks->total_paid)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.tax')</td>
                                        <td style="text-align: right">{{@num_format($add_stocks->total_taxes)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 px-1 mb-1">
                    <div class="card mt-1 mb-0 h-100">
                        <div class="card-body py-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="font-size: 1.2 rem; color: var(--primary-color);">
                                            <h5
                                                class="mb-0 @if (app()->isLocale('ar')) text-right @else text-left @endif ">
                                                @lang('lang.sale')</h5>
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>@lang('lang.amount')</td>
                                        <td style="text-align: right">{{@num_format($sales->total_amount)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.sale')</td>
                                        <td style="text-align: right">{{@num_format($sales->total_count)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.paid')</td>
                                        <td style="text-align: right">{{@num_format($sales->total_paid)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.tax')</td>
                                        <td style="text-align: right">{{@num_format($sales->total_taxes)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 px-1 mb-1">
                    <div class="card mt-1 mb-0 h-100">
                        <div class="card-body py-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="font-size: 1.2 rem; color: var(--primary-color);">
                                            <h5
                                                class="mb-0 @if (app()->isLocale('ar')) text-right @else text-left @endif ">
                                                @lang('lang.sale_return')</h5>
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>@lang('lang.amount')</td>
                                        <td style="text-align: right">{{@num_format($sale_returns->total_amount)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.return')</td>
                                        <td style="text-align: right">{{@num_format($sale_returns->total_count)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.tax')</td>
                                        <td style="text-align: right">{{@num_format($sale_returns->total_taxes)}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 px-1 mb-1">
                    <div class="card mt-1 mb-0 h-100">
                        <div class="card-body py-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="font-size: 1.2 rem; color: var(--primary-color);">
                                            <h5
                                                class="mb-0 @if (app()->isLocale('ar')) text-right @else text-left @endif ">
                                                @lang('lang.purchase_return')</h5>
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>@lang('lang.amount')</td>
                                        <td style="text-align: right">
                                            {{@num_format($purchase_returns->total_amount)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.return')</td>
                                        <td style="text-align: right">
                                            {{@num_format($purchase_returns->total_count)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.tax')</td>
                                        <td style="text-align: right">
                                            {{@num_format($purchase_returns->total_taxes)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 px-1 mb-1">
                    <div class="card mt-1 mb-0 h-100">
                        <div class="card-body py-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="font-size: 1.2 rem; color: var(--primary-color);">
                                            <h5
                                                class="mb-0 @if (app()->isLocale('ar')) text-right @else text-left @endif ">
                                                @lang('lang.profit_loss')</h5>
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>@lang('lang.sale')</td>
                                        <td style="text-align: right">{{@num_format($sales->total_amount)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.purchase')</td>
                                        <td style="text-align: right">{{@num_format($add_stocks->total_amount)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.profit')</td>
                                        <td style="text-align: right">
                                            {{@num_format($sales->total_amount - $add_stocks->total_amount)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 px-1 mb-1">
                    <div class="card mt-1 mb-0 h-100">
                        <div class="card-body py-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="font-size: 1.2 rem; color: var(--primary-color);">
                                            <h5
                                                class="mb-0 @if (app()->isLocale('ar')) text-right @else text-left @endif ">
                                                @lang('lang.profit_loss')</h5>
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>@lang('lang.sale')</td>
                                        <td style="text-align: right">{{@num_format($sales->total_amount)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.purchase')</td>
                                        <td style="text-align: right">-{{@num_format($add_stocks->total_amount)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.sale_return')</td>
                                        <td style="text-align: right">-{{@num_format($sale_returns->total_amount)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.purchase_return')</td>
                                        <td style="text-align: right">
                                            {{@num_format($purchase_returns->total_amount)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.profit')</td>
                                        <td style="text-align: right">
                                            {{@num_format($sales->total_amount - $add_stocks->total_amount -
                                            $sale_returns->total_amount + $purchase_returns->total_amount)}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 px-1 mb-1">
                    <div class="card mt-1 mb-0 h-100">
                        <div class="card-body py-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="font-size: 1.2 rem; color: var(--primary-color);">
                                            <h5
                                                class="mb-0 @if (app()->isLocale('ar')) text-right @else text-left @endif ">
                                                @lang('lang.net_profit_net_loss')</h5>
                                        </th>

                                    </tr>
                                </thead>
                                @php
                                $net_profit_loss = ($sales->total_amount-$sales->total_taxes) -
                                ($add_stocks->total_amount - $add_stocks->total_taxes) -
                                ($sale_returns->total_amount - $sale_returns->total_taxes) +
                                ($purchase_returns->total_amount - $purchase_returns->total_taxes);
                                @endphp
                                <tbody>
                                    <tr>

                                        <td colspan="2" style="text-align: center">
                                            <b>{{@num_format($net_profit_loss)}}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center">
                                            (@lang('lang.sale') {{@num_format($sales->total_amount)}} -
                                            @lang('lang.tax'){{@num_format($sales->total_taxes)}}) -
                                            (@lang('lang.purchase') {{@num_format($add_stocks->total_amount) }} -
                                            {{@num_format($add_stocks->total_taxes)}}) -
                                            (@lang('lang.sale_return') {{@num_format($sale_returns->total_amount)}}
                                            -
                                            @lang('lang.tax') {{@num_format($sale_returns->total_taxes)}}) +
                                            (@lang('lang.purchase_return')
                                            {{@num_format($purchase_returns->total_amount)}}
                                            - @lang('lang.tax') {{@num_format($purchase_returns->total_taxes)}})
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 px-1 mb-1">
                    <div class="card mt-1 mb-0 h-100">
                        <div class="card-body py-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="font-size: 1.2 rem; color: var(--primary-color);">
                                            <h5
                                                class="mb-0 @if (app()->isLocale('ar')) text-right @else text-left @endif ">
                                                @lang('lang.payment_receied')</h5>
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>@lang('lang.amount')</td>
                                        <td style="text-align: right">
                                            {{@num_format($payment_received->total_amount)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.received')</td>
                                        <td style="text-align: right">
                                            {{@num_format($payment_received->total_count)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.cash')</td>
                                        <td style="text-align: right">{{@num_format($payment_received->total_cash)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.cheque')</td>
                                        <td style="text-align: right">
                                            {{@num_format($payment_received->total_cheque)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.bank_transfer')</td>
                                        <td style="text-align: right">
                                            {{@num_format($payment_received->total_bank_transfer)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.credit_card')</td>
                                        <td style="text-align: right">{{@num_format($payment_received->total_card)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.gift_card')</td>
                                        <td style="text-align: right">
                                            {{@num_format($payment_received->total_gift_card)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.paypal')</td>
                                        <td style="text-align: right">
                                            {{@num_format($payment_received->total_paypal)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.deposit')</td>
                                        <td style="text-align: right">
                                            {{@num_format($payment_received->total_deposit)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 px-1 mb-1">
                    <div class="card mt-1 mb-0 h-100">
                        <div class="card-body py-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="font-size: 1.2 rem; color: var(--primary-color);">
                                            <h5
                                                class="mb-0 @if (app()->isLocale('ar')) text-right @else text-left @endif ">
                                                @lang('lang.payment_sent')</h5>
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>@lang('lang.amount')</td>
                                        <td style="text-align: right">{{@num_format($payment_sent->total_amount)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.sent')</td>
                                        <td style="text-align: right">{{@num_format($payment_sent->total_count)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.cash')</td>
                                        <td style="text-align: right">{{@num_format($payment_sent->total_cash)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.cheque')</td>
                                        <td style="text-align: right">{{@num_format($payment_sent->total_cheque)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.bank_transfer')</td>
                                        <td style="text-align: right">
                                            {{@num_format($payment_sent->total_bank_transfer)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.credit_card')</td>
                                        <td style="text-align: right">{{@num_format($payment_sent->total_card)}}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 px-1 mb-1">
                    <div class="card mt-1 mb-0 h-100">
                        <div class="card-body py-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="font-size: 1.2 rem; color: var(--primary-color);">
                                            <h5
                                                class="mb-0 @if (app()->isLocale('ar')) text-right @else text-left @endif ">
                                                @lang('lang.expense')</h5>
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>@lang('lang.amount')</td>
                                        <td style="text-align: right">{{@num_format($expenses->total_amount)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.expense')</td>
                                        <td style="text-align: right">{{@num_format($expenses->total_count)}}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 px-1 mb-1">
                    <div class="card mt-1 mb-0 h-100">
                        <div class="card-body py-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="font-size: 1.2 rem; color: var(--primary-color);">
                                            <h5
                                                class="mb-0 @if (app()->isLocale('ar')) text-right @else text-left @endif ">
                                                @lang('lang.payroll')</h5>
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>@lang('lang.amount')</td>
                                        <td style="text-align: right">{{@num_format($wages->total_amount)}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.payroll')</td>
                                        <td style="text-align: right">{{@num_format($wages->total_count)}}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>

</section>
@endsection

@section('javascript')
<script>
    $(".daterangepicker-field").daterangepicker({
	  callback: function(startDate, endDate, period){
	    var start_date = startDate.format('YYYY-MM-DD');
	    var end_date = endDate.format('YYYY-MM-DD');
	    var title = start_date + ' To ' + end_date;
	    $(this).val(title);
	    $('input[name="start_date"]').val(start_date);
	    $('input[name="end_date"]').val(end_date);
	  }
	});
</script>

@endsection
