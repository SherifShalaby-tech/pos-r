@extends('layouts.app')
@section('title', __('lang.daily_sale_report'))

@section('content')
<section class="forms pt-2">

    <div class="container-fluid">
        <div class="col-md-12 px-0 no-print">
            <x-page-title>
                <h4>@lang('lang.daily_sale_report')</h4>
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
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('method', __('lang.payment_type'), ['class' =>
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('method', $payment_types, request()->method,
                                    ['class' =>
                                    'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('created_by', __('lang.cashier'), ['class' =>
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('created_by', $cashiers, false, ['class' =>
                                    'form-control selectpicker', 'id' =>
                                    'created_by', 'data-live-search' => 'true', 'placeholder' =>
                                    __('lang.all')]) !!}
                                </div>
                            </div>

                            <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                                <button type="submit" class="btn btn-primary w-100">@lang('lang.filter')</button>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                                <a href="{{action('ReportController@getDailySaleReport')}}"
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
                                <tr>
                                    <th><a
                                            href="{{url('report/get-daily-sale-report?year='.$prev_year.'&month='.$prev_month)}}"><i
                                                class="fa fa-arrow-left"></i> {{trans('lang.previous')}}</a></th>
                                    <th colspan="5" class="text-center">
                                        {{date("F", strtotime($year.'-'.$month.'-01')).' ' .$year}}</th>
                                    <th><a
                                            href="{{url('report/get-daily-sale-report?year='.$next_year.'&month='.$next_month)}}">{{trans('lang.next')}}
                                            <i class="fa fa-arrow-right"></i></a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>@lang('lang.sunday')</strong></td>
                                    <td><strong>@lang('lang.monday')</strong></td>
                                    <td><strong>@lang('lang.tuesday')</strong></td>
                                    <td><strong>@lang('lang.wednesday')</strong></td>
                                    <td><strong>@lang('lang.thursday')</strong></td>
                                    <td><strong>@lang('lang.friday')</strong></td>
                                    <td><strong>@lang('lang.saturday')</strong></td>
                                </tr>
                                @php
                                $i = 1;
                                $flag = 0;
                                @endphp
                                @while ($i <= $number_of_day) <tr>
                                    @for($j=1 ; $j<=7 ; $j++) @if($i> $number_of_day)
                                        @php
                                        break;
                                        @endphp
                                        @endif
                                        @if($flag)
                                        @if($year.'-'.$month.'-'.$i == date('Y').'-'.date('m').'-'.(int)date('d'))
                                        <td>
                                            <p style="color:red"><strong>{{$i}}</strong></p>
                                            @else
                                        <td>
                                            <p><strong>{{$i}}</strong></p>
                                            @endif

                                            @if(!empty($total_surplus[$i]))
                                            <strong>@lang("lang.total_surplus")</strong><br><span>{{@num_format($total_surplus[$i])}}</span><br><br>
                                            @endif

                                            @if(!empty($total_discount[$i]))
                                            <strong>@lang("lang.product_discount")</strong><br><span>{{@num_format($total_discount[$i])}}</span><br><br>
                                            @endif

                                            @if(!empty($total_tax[$i]))
                                            <strong>@lang("lang.product_tax")</strong><br><span>{{@num_format($total_tax[$i])}}</span><br><br>
                                            @endif

                                            @if(!empty($order_tax[$i]))
                                            <strong>@lang("lang.order_tax")</strong><br><span>{{@num_format($order_tax[$i])}}</span><br><br>
                                            @endif

                                            @if(!empty($shipping_cost[$i]))
                                            <strong>@lang("lang.delivery_cost")</strong><br><span>{{@num_format($shipping_cost[$i])}}</span><br><br>
                                            @endif

                                            @if(!empty($grand_total[$i]))
                                            <strong>@lang("lang.grand_total")</strong><br><span>{{@num_format($grand_total[$i])}}</span><br><br>
                                            @endif

                                        </td>
                                        @php
                                        $i++;
                                        @endphp
                                        @elseif($j == $start_day)
                                        @if($year.'-'.$month.'-'.$i == date('Y').'-'.date('m').'-'.(int)date('d'))
                                        <td>
                                            <p style="color:red"><strong>'.$i.'</strong></p>
                                            @else
                                        <td>
                                            <p><strong>{{$i}}</strong></p>
                                            @endif

                                            @if(!empty($total_discount[$i]))
                                            <strong>@lang("lang.product_discount")</strong><br><span>{{@num_format($total_discount[$i])}}</span><br><br>
                                            @endif

                                            @if(!empty($total_tax[$i]))
                                            <strong>@lang("lang.product_tax")</strong><br><span>{{@num_format($total_tax[$i])}}</span><br><br>
                                            @endif

                                            @if(!empty($order_tax[$i]))
                                            <strong>@lang("lang.order_tax")</strong><br><span>{{@num_format($order_tax[$i])}}</span><br><br>
                                            @endif

                                            @if(!empty($shipping_cost[$i]))
                                            <strong>@lang("lang.delivery_cost")</strong><br><span>{{@num_format($shipping_cost[$i])}}</span><br><br>
                                            @endif

                                            @if(!empty($grand_total[$i]))
                                            <strong>@lang("lang.grand_total")</strong><br><span>{{@num_format($grand_total[$i])}}</span><br><br>
                                            @endif

                                        </td>
                                        @php
                                        $flag = 1;
                                        $i++;
                                        continue;
                                        @endphp

                                        @else
                                        <td></td>
                                        @endif

                                        @endfor

                                        </tr>
                                        @endwhile

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
