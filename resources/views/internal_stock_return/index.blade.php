@extends('layouts.app')
@section('title', __('lang.internal_stock_return'))

@section('content')

<section class="forms py-2">

    <div class="container-fluid px-2">
        <div class="col-md-12 px-0 no-print">

            <x-page-title>

                <h4 class="print-title">@lang('lang.return_requests_report')</h4>

                <x-slot name="buttons">
                    <x-collapse-button collapse-id="Filter" button-class="d-inline btn-secondary">
                        <div style="width: 20px">
                            <img class="w-100" src="{{ asset('front/white-filter.png') }}" alt="">
                        </div>
                    </x-collapse-button>
                </x-slot>
            </x-page-title>
            <x-collapse-body collapse-id="Filter">
                <div class="col-md-12">

                    <form action="">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('sender_store_id', __('lang.sender_store'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                                    ]) !!}
                                    {!! Form::select('sender_store_id', $stores,
                                    null, ['class' => 'selectpicker form-control', 'data-live-search'=>"true",
                                    'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('receiver_store_id', __('lang.receiver_store'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                                    ]) !!}
                                    {!! Form::select('receiver_store_id', $stores,
                                    null, ['class' => 'selectpicker form-control', 'data-live-search'=>"true",
                                    'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('start_date', __('lang.start_date'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                                    ]) !!}
                                    {!! Form::text('start_date', request()->start_date, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('start_time', __('lang.start_time'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                                    ]) !!}
                                    {!! Form::text('start_time', request()->start_time, ['class' => 'form-control
                                    time_picker sale_filter']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('end_date', __('lang.end_date'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                                    ]) !!}
                                    {!! Form::text('end_date', request()->end_date, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('end_time', __('lang.end_time'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                                    ]) !!}
                                    {!! Form::text('end_time', request()->end_time, ['class' => 'form-control
                                    time_picker
                                    sale_filter']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 d-flex justify-content-center align-items-end mb-11px">

                                <button type="submit" class="btn btn-primary w-100">@lang('lang.filter')</button>
                            </div>
                            <div class="col-md-3 d-flex justify-content-center align-items-end mb-11px">
                                <a href="{{action('InternalStockReturnController@index')}}"
                                    class="btn btn-danger w-100">@lang('lang.clear_filter')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </x-collapse-body>

        </div>

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
                                <th>@lang('lang.created_by')</th>
                                <th>@lang('lang.approved_at')</th>
                                <th>@lang('lang.received_at')</th>
                                <th>@lang('lang.sender_store')</th>
                                <th>@lang('lang.receiver_store')</th>
                                <th class="sum">@lang('lang.value_of_transaction')</th>
                                <th>@lang('lang.status')</th>
                                <th>@lang('lang.notes')</th>
                                {{-- <th>@lang('lang.files')</th> --}}
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transfers as $transfer)
                            <tr>
                                <td>{{@format_date($transfer->transaction_date)}}</td>
                                <td>{{$transfer->invoice_no}}</td>
                                <td>{{ucfirst($transfer->created_by_user->name ?? '')}}</td>
                                <td>@if(!empty($transfer->approved_at)) {{@format_date($transfer->approved_at)}} @endif
                                </td>
                                <td>@if(!empty($transfer->received_at)) {{@format_date($transfer->received_at)}} @endif
                                </td>
                                <td>{{ucfirst($transfer->sender_store->name ?? '')}}</td>
                                <td>{{ucfirst($transfer->receiver_store->name ?? '')}}</td>
                                <td>{{@num_format($transfer->final_total)}}</td>
                                <td>@if($transfer->status ==
                                    'received'){{__('lang.received')}}@else{{ucfirst($transfer->status)}}@endif</td>
                                <td>{{$transfer->notes}}</td>
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
                                            @if($transfer->is_internal_stock_transfer == 1 && $transfer->status !=
                                            'final')
                                            <li>
                                                <a data-href="{{action('InternalStockReturnController@getUpdateStatus', $transfer->id)}}"
                                                    data-container=".view_modal" class="btn btn-modal"><i
                                                        class="fa fa-arrow-up"></i>
                                                    @lang('lang.update_status')</a>
                                            </li>
                                            <li class="divider"></li>
                                            @endif
                                            @can('stock.internal_stock_return.view')
                                            <li>

                                                <a href="{{action('InternalStockReturnController@show', $transfer->id)}}"
                                                    class="btn"><i class="fa fa-eye"></i>
                                                    @lang('lang.view')</a>
                                            </li>
                                            <li class="divider"></li>
                                            @endcan
                                            @can('stock.internal_stock_return.view')
                                            <li>

                                                <a href="{{action('InternalStockReturnController@show', $transfer->id)}}?print=true"
                                                    class="btn"><i class="dripicons-print"></i>
                                                    @lang('lang.print')</a>
                                            </li>
                                            <li class="divider"></li>
                                            @endcan
                                            @can('stock.internal_stock_return.create_and_edit')
                                            <li>

                                                <a data-href="{{action('InternalStockReturnController@getUpdateStatus', $transfer->id)}}"
                                                    data-container=".view_modal" class="btn btn-modal"><i
                                                        class="fa fa-arrow-up"></i>
                                                    @lang('lang.edit')</a>
                                            </li>
                                            <li class="divider"></li>
                                            @endcan
                                            @can('stock.internal_stock_return.create_and_edit')
                                            @if($transfer->status == 'approved')
                                            <li>

                                                <a href="{{action('InternalStockReturnController@sendTheGoods', $transfer->id)}}"
                                                    class="btn"><i class="dripicons-document-edit"></i>
                                                    @lang('lang.send_the_goods')</a>
                                            </li>
                                            <li class="divider"></li>
                                            @endif
                                            @endcan

                                            @can('stock.internal_stock_return.delete')
                                            <li>
                                                <a data-href="{{action('InternalStockReturnController@destroy', $transfer->id)}}"
                                                    data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
                                                    class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                    @lang('lang.delete')</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th style="text-align: right">@lang('lang.total')</th>
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
<script src="{{asset('js/transfer.js')}}"></script>
<script>
    table
    .column( '0:visible' )
    .order( 'desc' )
    .draw();

    $(document).on('click', '#update-status', function(e){
        e.preventDefault();
        if($('#update_status_form').valid()){
            $('#update_status_form').submit();
        }
    })

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
@endsection