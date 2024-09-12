@extends('layouts.app')
@section('title', __('lang.profit_loss_report'))

@section('content')
<section class="forms pt-2">

    <div class="container-fluid">
        <div class="col-md-12 px-0 no-print">

            <x-page-title>

                <h4>@lang('lang.profit_loss_report')</h4>

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
                                    {!! Form::text('start_date', request()->start_date, ['class' => 'form-control'])
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('start_time', __('lang.start_time'), ['class' =>
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('start_time', request()->start_time, ['class' => 'form-control
                                    time_picker sale_filter']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('end_date', __('lang.end_date'), ['class' =>
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('end_date', request()->end_date, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('end_time', __('lang.end_time'), ['class' =>
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('end_time', request()->end_time, ['class' => 'form-control
                                    time_picker sale_filter']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('customer_type_id', __('lang.customer_type'), ['class' =>
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('customer_type_id', $customer_types,
                                    request()->customer_type_id,
                                    ['class' => 'form-control', 'placeholder' => __('lang.all'), 'data-live-search'
                                    =>
                                    'true']) !!}
                                </div>
                            </div>
                            @if (session('user.is_superadmin'))
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('store_id', __('lang.store'), ['class' => app()->isLocale('ar')
                                    ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('store_id', $stores, request()->store_id, ['class' =>
                                    'form-control', 'placeholder' => __('lang.all'), 'data-live-search' => 'true'])
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('pos_id', __('lang.pos'), ['class' => app()->isLocale('ar') ?
                                    'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('pos_id', $store_pos, request()->pos_id, ['class' =>
                                    'form-control', 'placeholder' => __('lang.all'), 'data-live-search' => 'true'])
                                    !!}
                                </div>
                            </div>
                            @endif
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('product_id', __('lang.product'), ['class' =>
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('product_id', $products, request()->product_id, ['class' =>
                                    'form-control', 'placeholder' => __('lang.all'), 'data-live-search' => 'true'])
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('employee_id', __('lang.employee'), ['class' =>
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('employee_id', $employees, request()->employee_id, ['class' =>
                                    'form-control', 'placeholder' => __('lang.all'), 'data-live-search' => 'true'])
                                    !!}
                                </div>
                            </div>
                            {{-- <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('profit_type', __('lang.profit'), ['class' =>
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('profit_type', ['purchase_price' => __('lang.purchase_price'),
                                    'final_cost' => __('lang.final_cost')], request()->profit_type, ['class' =>
                                    'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                </div>
                            </div> --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">@lang('lang.wages_type')</label>
                                    {!! Form::select('payment_type', $wages_payment_types, null, ['class' =>
                                    'form-control', 'placeholder' => __('lang.all')]) !!}
                                </div>
                            </div>


                            <div class="col-md-2 d-flex justify-content-center align-items-end">
                                <button type="submit" class="btn btn-primary w-100">@lang('lang.filter')</button>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center align-items-end">
                                <a href="{{ action('ReportController@getProfitLoss') }}"
                                    class="btn btn-danger w-100 ">@lang('lang.clear_filter')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </x-collapse>

            <div class="card mt-1 mb-0">
                <div class="card-body py-2 px-4">
                    <div class="col-md-12">
                        <h4 class="text-primary">@lang('lang.income')</h4>
                        <div class="table-responsive">
                            <table id="store_table" class="table">
                                <thead>
                                    <tr>
                                        <th>@lang('lang.income')</th>
                                        <th>@lang('lang.amount')</th>
                                        <th>@lang('lang.information')</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $sale)
                                    <tr>
                                        <td>{{ $sale['store_name'] }}</td>
                                        <th>
                                            @foreach ($sale['currency'] as $currency)
                                            <h6 class="currency_total_th currency_total_{{ $currency['currency_id'] }}"
                                                data-currency_id="{{ $currency['currency_id'] }}"
                                                data-is_default="{{ $currency['is_default'] }}"
                                                data-conversion_rate="{{ $currency['conversion_rate'] }}"
                                                data-base_conversion="{{ $currency['conversion_rate'] * $currency['total'] }}"
                                                data-orig_value="{{ $currency['total'] }}">
                                                <span class="symbol" style="padding-right: 10px;">
                                                    {{ $currency['symbol'] }}</span>
                                                <span class="total">{{ @num_format($currency['total']) }}</span>
                                            </h6>
                                            @endforeach
                                        </th>

                                        <td>
                                            <a href="{{ action('SellController@index') }}?store_id={{ $sale['store_id'] }}&start_date={{ request()->start_date }}&end_date={{ request()->end_date }}"
                                                class="btn btn-primary">@lang('lang.details')</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>@lang('lang.total_income')</th>
                                        <th>
                                            @foreach ($exchange_rate_currencies as $currency)
                                            <h6 class="currency_total_th currency_total_{{ $currency['currency_id'] }}"
                                                data-currency_id="{{ $currency['currency_id'] }}"
                                                data-is_default="{{ $currency['is_default'] }}"
                                                data-conversion_rate="{{ $currency['conversion_rate'] }}"
                                                data-base_conversion="{{ $currency['conversion_rate'] * $sales_totals[$currency['currency_id']] }}"
                                                data-orig_value="{{ $sales_totals[$currency['currency_id']] }}">
                                                <span class="symbol" style="padding-right: 10px;">
                                                    {{ $currency['symbol'] }}</span>
                                                <span class="total">{{
                                                    @num_format($sales_totals[$currency['currency_id']]) }}</span>
                                            </h6>
                                            @endforeach
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-1 mb-0">
                <div class="card-body py-2 px-4">
                    <div class="col-md-12">
                        <h4 class="text-primary">@lang('lang.expendatures')</h4>
                        <div class="table-responsive">
                            <table id="store_table" class="table">
                                <thead>
                                    <tr>
                                        <th>@lang('lang.expense')</th>
                                        <th>@lang('lang.amount')</th>
                                        <th>@lang('lang.information')</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expenses as $expense)
                                    <tr>
                                        <td>{{ $expense->expense_category_name }}</td>
                                        <th>
                                            @foreach ($exchange_rate_currencies as $currency)
                                            @php
                                            $expense_value = 0;
                                            if ($currency['is_default']) {
                                            $expense_value = $expense->total_amount;
                                            } else {
                                            $expense_value = 0;
                                            }
                                            @endphp
                                            <h6 class="currency_total_th currency_total_{{ $currency['currency_id'] }}"
                                                data-currency_id="{{ $currency['currency_id'] }}"
                                                data-is_default="{{ $currency['is_default'] }}"
                                                data-conversion_rate="{{ $currency['conversion_rate'] }}"
                                                data-base_conversion="{{ $currency['conversion_rate'] * $expense_value }}"
                                                data-orig_value="{{ $expense_value }}">
                                                <span class="symbol" style="padding-right: 10px;">
                                                    {{ $currency['symbol'] }}</span>
                                                <span class="total">{{ @num_format($expense_value) }}</span>
                                            </h6>
                                            @endforeach
                                        </th>
                                        <td>
                                            <a href="{{ action('ExpenseController@index') }}?expense_category_id={{ $expense->expense_category_id }}&start_date={{ request()->start_date }}&end_date={{ request()->end_date }}"
                                                class="btn btn-primary">@lang('lang.details')</a>
                                        </td>
                                    </tr>
                                    @endforeach

                                    <tr>
                                        <th>@lang('lang.all_purchases')</th>
                                        <th>
                                            @if (!empty($purchases))
                                            @foreach ($purchases as $purchase)
                                            @foreach ($purchase['currency'] as $currency)
                                            <h6 class="currency_total_th currency_total_{{ $currency['currency_id'] }}"
                                                data-currency_id="{{ $currency['currency_id'] }}"
                                                data-is_default="{{ $currency['is_default'] }}"
                                                data-conversion_rate="{{ $currency['conversion_rate'] }}"
                                                data-base_conversion="{{ $currency['conversion_rate'] * $currency['total'] }}"
                                                data-orig_value="{{ $currency['total'] }}">
                                                <span class="symbol" style="padding-right: 10px;">
                                                    {{ $currency['symbol'] }}</span>
                                                <span class="total">{{ @num_format($currency['total']) }}</span>
                                            </h6>
                                            @endforeach
                                            @endforeach
                                            @endif
                                        </th>
                                        <td>
                                            <a href="{{ action('AddStockController@index') }}?start_date={{ request()->start_date }}&end_date={{ request()->end_date }}"
                                                class="btn btn-primary">@lang('lang.details')</a>
                                        </td>
                                    </tr>
                                    @foreach ($wages as $wage)
                                    <tr>
                                        <td>{{ ucfirst($wages_payment_types[$wage->payment_type]) }}</td>
                                        <th>
                                            @foreach ($exchange_rate_currencies as $currency)
                                            @php
                                            $wage_value = 0;
                                            if ($currency['is_default']) {
                                            $wage_value = $wage->total_amount;
                                            } else {
                                            $wage_value = 0;
                                            }
                                            @endphp
                                            <h6 class="currency_total_th currency_total_{{ $currency['currency_id'] }}"
                                                data-currency_id="{{ $currency['currency_id'] }}"
                                                data-is_default="{{ $currency['is_default'] }}"
                                                data-conversion_rate="{{ $currency['conversion_rate'] }}"
                                                data-base_conversion="{{ $currency['conversion_rate'] * $wage_value }}"
                                                data-orig_value="{{ $wage_value }}">
                                                <span class="symbol" style="padding-right: 10px;">
                                                    {{ $currency['symbol'] }}</span>
                                                <span class="total">{{ @num_format($wage_value) }}</span>
                                            </h6>
                                            @endforeach
                                        </th>
                                        <td>
                                            <a href="{{ action('WagesAndCompensationController@index') }}?payment_type={{ $wage->payment_type }}&start_date={{ request()->start_date }}&end_date={{ request()->end_date }}"
                                                class="btn btn-primary">@lang('lang.details')</a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>@lang('lang.total_expenses')</th>
                                        <th>
                                            @php
                                            $total_exp = [];
                                            @endphp
                                            @foreach ($exchange_rate_currencies as $currency)
                                            @php
                                            $total_expenses = 0;
                                            if ($currency['is_default']) {
                                            $total_expenses = $expenses->sum('total_amount') +
                                            $wages->sum('total_amount') +
                                            $purchase_totals[$currency['currency_id']];
                                            } else {
                                            $total_expenses = $purchase_totals[$currency['currency_id']];
                                            }
                                            $total_exp[$currency['currency_id']] = $total_expenses;
                                            @endphp
                                            <h6 class="currency_total_th currency_total_{{ $currency['currency_id'] }}"
                                                data-currency_id="{{ $currency['currency_id'] }}"
                                                data-is_default="{{ $currency['is_default'] }}"
                                                data-conversion_rate="{{ $currency['conversion_rate'] }}"
                                                data-base_conversion="{{ $currency['conversion_rate'] * $total_expenses }}"
                                                data-orig_value="{{ $total_expenses }}">
                                                <span class="symbol" style="padding-right: 10px;">
                                                    {{ $currency['symbol'] }}</span>
                                                <span class="total">{{ @num_format($total_expenses) }}</span>
                                            </h6>
                                            @endforeach
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-1 mb-0">
                <div class="card-body py-2 px-4">
                    <div class="col-md-12">
                        <div class="table-respons">

                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>@lang('lang.profit_and_loss')</th>
                                        <th>
                                            @foreach ($exchange_rate_currencies as $currency)
                                            <h6 class="currency_total_th currency_total_{{ $currency['currency_id'] }}"
                                                data-currency_id="{{ $currency['currency_id'] }}"
                                                data-is_default="{{ $currency['is_default'] }}"
                                                data-conversion_rate="{{ $currency['conversion_rate'] }}"
                                                data-base_conversion="{{ $currency['conversion_rate'] * ($sales_totals[$currency['currency_id']] - $total_exp[$currency['currency_id']]) }}"
                                                data-orig_value="{{ $sales_totals[$currency['currency_id']] - $total_exp[$currency['currency_id']] }}">
                                                <span class="symbol" style="padding-right: 10px;">
                                                    {{ $currency['symbol'] }}</span>
                                                <span class="total">{{
                                                    @num_format($sales_totals[$currency['currency_id']] -
                                                    $total_exp[$currency['currency_id']]) }}</span>
                                            </h6>
                                            @endforeach
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
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

@endsection