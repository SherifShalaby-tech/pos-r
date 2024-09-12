@extends('layouts.app')
@section('title', __('lang.store_stock_chart'))

@section('content')
<section class="forms pt-2">

    <div class="container-fluid">
        <div class="col-md-12  no-print">
            <x-page-title>


                <h4>@lang('lang.store_stock_chart')</h4>

                <x-slot name="buttons">

                </x-slot>
            </x-page-title>



            @if(session('user.is_superadmin'))
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
                                    {!! Form::text('start_time', request()->start_time, [
                                    'class' => 'form-control
                                    time_picker sale_filter',
                                    ]) !!}
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
                                    {!! Form::text('end_time', request()->end_time, [
                                    'class' => 'form-control time_picker
                                    sale_filter',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('store_id', __('lang.store'), ['class' => app()->isLocale('ar')
                                    ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('store_id', $stores, request()->store_id, ['class' =>
                                    'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                </div>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">

                                <button type="submit" class="btn btn-primary w-100">@lang('lang.filter')</button>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                                <a href="{{action('ReportController@getStoreStockChart')}}"
                                    class="btn btn-danger w-100">@lang('lang.clear_filter')</a>
                            </div>
                        </div>
                </div>
                </form>
            </x-collapse>
            @endif


            <div class="col-md-12 px-0 ">
                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row">
                            <div class="col-md-6">
                                <span>Total @lang('lang.items')</span>
                                <h2><strong>{{@num_format($total_item)}}</strong></h2>
                            </div>
                            <div class="col-md-6">
                                <span>Total @lang('lang.quantity')</span>
                                <h2><strong>{{@num_format($total_qty)}}</strong></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 px-0">
                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        @php
                        $color = '#733686';
                        $color_rgba = 'rgba(115, 54, 134, 0.8)';

                        @endphp
                        <div class="col-md-12">
                            <div class="pie-chart">
                                <canvas id="pieChart" data-color="{{$color}}" data-color_rgba="{{$color_rgba}}"
                                    data-price={{$total_price}} data-cost={{$total_cost}} width="5" height="5"
                                    data-label1="@lang('lang.stock_value_by_price')"
                                    data-label2="@lang('lang.stock_value_by_cost')"
                                    data-label3="@lang('lang.estimate_profit')">
                                </canvas>
                            </div>
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
