@extends('layouts.app')
@section('title', __('lang.monthly_purchase_report'))

@section('content')
<section class="forms pt-2">

    <div class="container-fluid">
        <div class="col-md-12 px-0 no-print">

            <x-page-title>
                <h4>@lang('lang.monthly_purchase_report')</h4>
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
                                    {!! Form::label('start_date', __('lang.start_date'), [ 'class' =>
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('start_date', request()->start_date, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('start_time', __('lang.start_time'), [ 'class' =>
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
                                    {!! Form::label('end_date', __('lang.end_date'), [ 'class' => app()->isLocale('ar')
                                    ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('end_date', request()->end_date, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('end_time', __('lang.end_time'), [ 'class' => app()->isLocale('ar')
                                    ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('end_time', request()->end_time, [
                                    'class' => 'form-control time_picker
                                    sale_filter',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('store_id', __('lang.store'), [ 'class' => app()->isLocale('ar') ?
                                    'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('store_id', $stores, request()->store_id, ['class' =>
                                    'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                </div>
                            </div>


                            <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                                <button type="submit" class="btn btn-primary w-100">@lang('lang.filter')</button>
                            </div>

                            <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                                <a href="{{action('ReportController@getMonthlyPurchaseReport')}}"
                                    class="btn btn-danger w-100">@lang('lang.clear_filter')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </x-collapse>
            @endif


            <div class="card mt-1 mb-0">
                <div class="card-body py-2 px-4">
                    <div class="tabel-responsive">


                        <table class="table table-bordered"
                            style="border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
                            <thead>
                                @php
                                $next_year = $year + 1;
                                $pre_year = $year - 1;
                                @endphp
                                <tr>
                                    <th><a href="{{url('report/get-monthly-purchase-report?year='.$pre_year)}}"><i
                                                class="fa fa-arrow-left"></i> {{trans('lang.previous')}}</a></th>
                                    <th colspan="10" class="text-center">{{$year}}</th>
                                    <th><a href="{{url('report/get-monthly-purchase-report?year='.$next_year)}}">{{trans('lang.next')}}
                                            <i class="fa fa-arrow-right"></i></a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>@lang('lang.January')</strong></td>
                                    <td><strong>@lang('lang.February')</strong></td>
                                    <td><strong>@lang('lang.March')</strong></td>
                                    <td><strong>@lang('lang.April')</strong></td>
                                    <td><strong>@lang('lang.May')</strong></td>
                                    <td><strong>@lang('lang.June')</strong></td>
                                    <td><strong>@lang('lang.July')</strong></td>
                                    <td><strong>@lang('lang.August')</strong></td>
                                    <td><strong>@lang('lang.September')</strong></td>
                                    <td><strong>@lang('lang.October')</strong></td>
                                    <td><strong>@lang('lang.November')</strong></td>
                                    <td><strong>@lang('lang.December')</strong></td>
                                </tr>
                                <tr>
                                    @foreach($total_discount as $key => $discount)
                                    <td>
                                        @if($discount > 0)
                                        <strong>{{trans("lang.product_discount")}}</strong><br>
                                        <span>{{@num_format($discount)}}</span><br><br>
                                        @endif
                                        @if($total_tax[$key] > 0)
                                        <strong>{{trans("lang.product_tax")}}</strong><br>
                                        <span>{{@num_format($total_tax[$key])}}</span><br><br>
                                        @endif
                                        @if($shipping_cost[$key] > 0)
                                        <strong>{{trans("lang.delivery_cost")}}</strong><br>
                                        <span>{{@num_format($shipping_cost[$key])}}</span><br><br>
                                        @endif
                                        @if($total[$key] > 0)
                                        <strong>{{trans("lang.grand_total")}}</strong><br>
                                        <span>{{@num_format($total[$key])}}</span><br>
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>
@endsection

@section('javascript')

@endsection