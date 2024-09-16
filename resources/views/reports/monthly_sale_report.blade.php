@extends('layouts.app')
@section('title', __('lang.monthly_sale_and_purchase_report'))
@section('styles')
<style>
    .months td {
        border-bottom: 2px solid rgb(241, 89, 89);
    }

    .sale-row td {
        border-top: 2px solid rgb(241, 89, 89);
        border-bottom: 2px solid rgb(241, 89, 89);
    }

    .sale-row td:first-child {
        border-left: 2px solid rgb(241, 89, 89);
    }

    .sale-row td:last-child {
        border-right: 2px solid rgb(241, 89, 89);
    }

    .purchase-row td {
        border-top: 2px solid rgb(84, 235, 177);
        border-bottom: 2px solid rgb(84, 235, 177);
    }

    .purchase-row td:first-child {
        border-left: 2px solid rgb(84, 235, 177);
    }

    .purchase-row td:last-child {
        border-right: 2px solid rgb(84, 235, 177);
    }
</style>
@endsection
@section('content')
<section class="forms py-2">

    <div class="container-fluid px-2">
        <div class="col-md-12 px-0 no-print">

            <x-page-title>

                <h4>@lang('lang.monthly_sale_and_purchase_report')</h4>

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
                                <a href="{{action('ReportController@getMonthlySaleReport')}}"
                                    class="btn btn-danger w-100">@lang('lang.clear_filter')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </x-collapse>
            @endif



            <div class="card mt-1 mb-0">
                <div class="card-body py-2 px-4">
                    <div class="table-responsive">

                        <table class="table table-bordered"
                            style="border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
                            <thead>
                                @php
                                $next_year = $year + 1;
                                $pre_year = $year - 1;
                                @endphp
                                <tr>
                                    <th></th>
                                    <th><a href="{{url('report/get-monthly-sale-report?year='.$pre_year)}}"><i
                                                class="fa fa-arrow-left"></i> {{trans('lang.previous')}}</a></th>
                                    <th colspan="10" class="text-center">{{$year}}</th>
                                    <th><a href="{{url('report/get-monthly-sale-report?year='.$next_year)}}">{{trans('lang.next')}}
                                            <i class="fa fa-arrow-right"></i></a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
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
                                <tr class="sale-row">
                                    <td>
                                        <h5>@lang('lang.sales')</h5>
                                    </td>
                                    @foreach($total_discount_sell as $key => $discount)
                                    <td>
                                        @if($discount > 0)
                                        <strong>{{trans("lang.product_discount")}}</strong><br>
                                        <span>{{@num_format($discount)}}</span><br><br>
                                        @endif
                                        @if($total_tax_sell[$key] > 0)
                                        <strong>{{trans("lang.product_tax")}}</strong><br>
                                        <span>{{isset($total_tax_sell)?@num_format($total_tax_sell[$key]):0}}</span><br><br>
                                        @endif
                                        @if($shipping_cost_sell[$key] > 0)
                                        <strong>{{trans("lang.delivery_cost")}}</strong><br>
                                        <span>{{@num_format($shipping_cost_sell[$key])}}</span><br><br>
                                        @endif
                                        @if($total_sell[$key] > 0)
                                        <strong>{{trans("lang.grand_total")}}</strong><br>
                                        <span>{{@num_format($total_sell[$key])}}</span><br>
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>

                                <tr class="purchase-row">
                                    <td>
                                        <h5>@lang('lang.purchases')</h5>
                                    </td>
                                    @foreach($total_discount_addstock as $key => $discount)
                                    <td>
                                        @if($discount > 0)
                                        <strong>{{trans("lang.product_discount")}}</strong><br>
                                        <span>{{@num_format($discount)}}</span><br><br>
                                        @endif
                                        @if($total_tax_addstock[$key] > 0)
                                        <strong>{{trans("lang.product_tax")}}</strong><br>
                                        <span>{{@num_format($total_tax_addstock[$key])}}</span><br><br>
                                        @endif
                                        @if($shipping_cost_addstock[$key] > 0)
                                        <strong>{{trans("lang.delivery_cost")}}</strong><br>
                                        <span>{{@num_format($shipping_cost_addstock[$key])}}</span><br><br>
                                        @endif
                                        @if($total_addstock[$key] > 0)
                                        <strong>{{trans("lang.grand_total")}}</strong><br>
                                        <span>{{@num_format($total_addstock[$key])}}</span><br>
                                        {{-- <span>{{@num_format($total_p[$key])}}</span><br> --}}
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td></td>
                                    @foreach($total_net_profit as $key => $net_profit)
                                    <td>
                                        <strong>{{trans("lang.wins")}}</strong><br>
                                        <strong>{{@num_format($net_profit)}}</strong>
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
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
