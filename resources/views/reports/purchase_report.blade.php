@extends('layouts.app')
@section('title', __('lang.purchase_report'))

@section('content')

<section class="forms pt-2">

    <div class="container-fluid">
        <div class="col-md-12  no-print">

            <x-page-title>


                <h4 class="print-title">@lang('lang.purchase_report')</h4>
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
                                    {!! Form::text('start_date', request()->start_date, ['class' => 'form-control']) !!}
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
                                    {!! Form::text('end_time', request()->end_time, ['class' => 'form-control
                                    time_picker
                                    sale_filter']) !!}
                                </div>
                            </div>
                            @if(session('user.is_superadmin'))
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('store_id', __('lang.store'), ['class' => app()->isLocale('ar') ?
                                    'mb-1 label-ar' : 'mb-1 label-en'
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
                                    ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('product_id', $products, request()->product_id, ['class' =>
                                    'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                </div>
                            </div>

                            <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">

                                <button type="submit" class="btn btn-primary w-100">@lang('lang.filter')</button>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                                <a href="{{action('ReportController@getPurchaseReport')}}"
                                    class="btn btn-danger w-100 ">@lang('lang.clear_filter')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </x-collapse>


            <div
                class="top-controls py-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">

            </div>
            <div class="card mt-1 mb-0">
                <div class="card-body py-2 px-4">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>@lang('lang.product_name')</th>
                                    <th class="sum">@lang('lang.purchased_amount')</th>
                                    <th class="sum">@lang('lang.purchased_qty')</th>
                                    <th class="sum">@lang('lang.in_stock')</th>
                                    <th class="notexport">@lang('lang.action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($products as $key => $value)
                                @if(!empty($transactions[$key]))
                                <tr>
                                    <td>{{$value}}</td>
                                    <td> {{@num_format($transactions[$key]->total_purchase)}}</td>
                                    <td> {{@num_format($transactions[$key]->total_qty)}}</td>
                                    <td> {{preg_match('/\.\d*[1-9]+/', (string)$transactions[$key]->in_stock) ?
                                        $transactions[$key]->in_stock : @num_format($transactions[$key]->in_stock)}}
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
                                                @can('product_module.product.view')
                                                <li>
                                                    <a data-href="{{action('ProductController@show', $transactions[$key]->id)}}"
                                                        data-container=".view_modal" class="btn btn-modal"><i
                                                            class="fa fa-eye"></i>
                                                        @lang('lang.view')</a>
                                                </li>
                                                <li class="divider"></li>
                                                @endcan
                                                @can('product_module.product.create_and_edit')
                                                <li>

                                                    <a href="{{action('ProductController@edit', $transactions[$key]->id)}}"
                                                        class="btn"><i class="dripicons-document-edit"></i>
                                                        @lang('lang.edit')</a>
                                                </li>
                                                <li class="divider"></li>
                                                @endcan
                                                @can('product_module.product.delete')
                                                <li>
                                                    <a data-href="{{action('ProductController@destroy', $transactions[$key]->id)}}"
                                                        data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
                                                        class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                        @lang('lang.delete')</a>
                                                </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="text-align: right">@lang('lang.total')</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div
                    class="bottom-controls mt-1 p-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">
                    <!-- Pagination and other controls can go here -->
                </div>
            </div>


        </div>
    </div>

</section>
@endsection

@section('javascript')

@endsection