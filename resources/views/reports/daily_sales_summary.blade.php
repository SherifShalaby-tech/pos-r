@extends('layouts.app')
@section('title', __('lang.daily_sales_summary'))

@section('content')

<section class="forms py-2">

    <div class="container-fluid px-2">

        <div class="col-md-12 px-0 no-print">

            <x-page-title>
                <h4>@lang('lang.daily_sales_summary')</h4>
            </x-page-title>




            @if (session('user.is_superadmin') || auth()->user()->can('reports.sales_per_employee.view'))
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
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                    {!! Form::text('start_date', request()->start_date, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('start_time', __('lang.start_time'), ['class' =>
                                    app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                    {!! Form::text('start_time', request()->start_time, [
                                    'class' => 'form-control
                                    time_picker sale_filter',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('end_date', __('lang.end_date'), ['class' => app()->isLocale('ar') ?
                                    'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                    {!! Form::text('end_date', request()->end_date, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('end_time', __('lang.end_time'), ['class' => app()->isLocale('ar') ?
                                    'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                    {!! Form::text('end_time', request()->end_time, [
                                    'class' => 'form-control time_picker
                                    sale_filter',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('store_id', __('lang.store'), ['class' => app()->isLocale('ar') ?
                                    'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                    {!! Form::select('store_id[]', $stores, request()->store_id, ['class' =>
                                    'form-control
                                    selectpicker filter', 'multiple', 'id' => 'store_id', 'data-actions-box' => 'true',
                                    'placeholder' => __('lang.all'), 'data-live-search' => 'true']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('store_pos_id', __('lang.pos'), ['class' => app()->isLocale('ar') ?
                                    'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                    {!! Form::select('store_pos_id[]', $store_pos, request()->store_pos_id, ['class' =>
                                    'form-control selectpicker filter', 'multiple', 'id' => 'store_pos_id',
                                    'data-actions-box'
                                    => 'true', 'placeholder' => __('lang.all'), 'data-live-search' => 'true']) !!}
                                </div>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                                <button type="button"
                                    class="btn btn-danger w-100clear_filter">@lang('lang.clear_filter')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </x-collapse>
            @endif


            <div class="card mt-1 mb-0">
                <div class="card-body py-2 px-4">
                    <div class="col-md-12" id="table_div">

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')
<script>
    $(document).on('focusout', '#start_time', function() {
            getDailySaleReport();
        })
        $(document).on('click', '.clear_filter', function() {
            $('.selectpicker').val('');
            $('.selectpicker').selectpicker('refresh');
            $('.date').val("{{ date('Y-m-d') }}");
            $('.time_picker').val("");
            getDailySaleReport();
        })
        $(document).on('change', '.filter', function() {
            getDailySaleReport();
        })
        $(document).ready(function() {
            getDailySaleReport();
        })

        function getDailySaleReport() {
            $("#table_div").html(
                `<div class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i></div>`
            );

            $.ajax({
                method: 'get',
                url: '/report/daily-sales-summary',
                data: {
                    start_date: $('#start_date').val(),
                    store_id: $('#store_id').val(),
                    store_pos_id: $('#store_pos_id').val(),
                    start_time: $('#start_time').val(),
                },
                contentType: 'html',
                success: function(result) {
                    $('#table_div').html(result);
                },
            });
        }

        $(document).on("change", "#store_id", function() {

            if ($("#store_id").val()) {
                $.ajax({
                    method: "get",
                    url: "/report/get-pos-details-by-store",
                    data: {
                        store_ids: $("#store_id").val()
                    },
                    success: function(result) {
                        $("#store_pos_id").html(result);
                        $("#store_pos_id").selectpicker("refresh");
                        $("#store_pos_id").selectpicker("val", result.id);
                    },
                });
            }
        });

</script>

@endsection
