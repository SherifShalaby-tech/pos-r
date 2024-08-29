@extends('layouts.app')
@section('title', __('lang.best_seller_report'))

@section('content')
<section class="forms pt-2">

    <div class="container-fluid">
        <div class="col-md-12  no-print">

            <x-page-title>

                <h4>@lang('lang.best_seller_report')</h4>

                <x-slot name="buttons">

                </x-slot>
            </x-page-title>



            <div class="card">

                @if(session('user.is_superadmin'))
                <form action="">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('start_date', __('lang.start_date'), []) !!}
                                    {!! Form::text('start_date', request()->start_date, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('start_time', __('lang.start_time'), []) !!}
                                    {!! Form::text('start_time', request()->start_time, [
                                    'class' => 'form-control
                                    time_picker sale_filter',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('end_date', __('lang.end_date'), []) !!}
                                    {!! Form::text('end_date', request()->end_date, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('end_time', __('lang.end_time'), []) !!}
                                    {!! Form::text('end_time', request()->end_time, [
                                    'class' => 'form-control time_picker
                                    sale_filter',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('store_id', __('lang.store'), []) !!}
                                    {!! Form::select('store_id', $stores, request()->store_id, ['class' =>
                                    'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                </div>
                            </div>


                            <div class="col-md-3">
                                <br>
                                <button type="submit" class="btn btn-success mt-2">@lang('lang.filter')</button>
                                <a href="{{action('ReportController@getBestSellerReport')}}"
                                    class="btn btn-danger mt-2 ml-2">@lang('lang.clear_filter')</a>
                            </div>
                        </div>
                    </div>
                </form>
                @endif
                <div class="card-body">
                    <div class="col-md-12">
                        @php
                        $color = '#733686';
                        $color_rgba = 'rgba(115, 54, 134, 0.8)';

                        @endphp
                        <canvas id="bestSeller" data-color="{{$color}}" data-color_rgba="{{$color_rgba}}"
                            data-product="{{json_encode($product)}}"
                            data-sold_qty="{{json_encode($sold_qty)}}"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')

@endsection
