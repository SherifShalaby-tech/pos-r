@extends('layouts.app')
@section('title', __('lang.coupon'))

@section('content')

<section class="forms py-2">

    <div class="container-fluid px-2">

        <x-page-title>

            <h4 class="print-title">@lang('lang.coupons')</h4>

            <x-slot name="buttons">
                @can('coupons_and_gift_cards.coupon.create_and_edit')
                <a style="color: white" href="{{action('CouponController@create')}}" class="btn btn-primary"><i
                        class="dripicons-plus"></i>
                    @lang('lang.generate_coupon')</a>
                @endcan
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
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('type', __( 'lang.type' ) . '*',[
                                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                ]) !!}
                                {!! Form::select('type', ['fixed' => 'Fixed', 'percentage' => 'Percentage'],
                                request()->type,
                                ['class' =>
                                'form-control', 'data-live-search' => 'true', 'placeholder' => __('lang.all')]) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('created_by', __('lang.created_by'), ['class' => app()->isLocale('ar') ?
                                'mb-1 label-ar' : 'mb-1 label-en'
                                ]) !!}
                                {!! Form::select('created_by', $users, request()->created_by, ['class' =>
                                'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('start_date', __('lang.start_date'), ['class' => app()->isLocale('ar') ?
                                'mb-1 label-ar' : 'mb-1 label-en'
                                ]) !!}
                                {!! Form::text('start_date', request()->start_date, ['class' => 'form-control']) !!}
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
                                {!! Form::label('status', __('lang.status'), ['class' => app()->isLocale('ar') ? 'mb-1
                                label-ar' : 'mb-1 label-en'
                                ]) !!}
                                {!! Form::select('status', [0 => 'Not Used', '1' => 'Used'], request()->status, ['class'
                                =>
                                'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                            </div>
                        </div>
                        <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">

                            <button type="submit" class="btn btn-primary w-100">@lang('lang.filter')</button>
                        </div>
                        <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                            <a href="{{action('CouponController@index')}}"
                                class="btn btn-danger w-100 ">@lang('lang.clear_filter')</a>
                        </div>

                    </div>
                </form>
            </div>
        </x-collapse-body>

        <div
            class="top-controls py-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">

        </div>
        <div class="card mt-1 mb-0">
            <div class="card-body py-2 px-4">
                <div class="table-responsive">
                    <table id="coupon_table" class="table dataTable">
                        <thead>
                            <tr>
                                <th>@lang('lang.coupon_code')</th>
                                <th>@lang('lang.type')</th>
                                <th class="sum">@lang('lang.amount')</th>
                                <th>@lang('lang.customer_type')</th>
                                <th>@lang('lang.date_and_time')</th>
                                <th>@lang('lang.expiry_date')</th>
                                <th>@lang('lang.created_by')</th>
                                <th>@lang('lang.affected_by_products')</th>
                                <th>@lang('lang.status')</th>

                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coupons as $coupon)
                            <tr>
                                <td>{{$coupon->coupon_code}}</td>
                                <td>{{ucfirst($coupon->type)}}</td>
                                <td>{{@num_format($coupon->amount)}}</td>
                                <td>{{implode(', ', $coupon->customer_types->pluck('name')->toArray())}}</td>
                                <td>{{@format_datetime($coupon->created_at)}}</td>
                                <td>@if(!empty($coupon->expiry_date)){{@format_date($coupon->expiry_date)}}@endif
                                </td>
                                <td>{{ucfirst($coupon->created_by_user->name ?? '')}}</td>
                                <td>
                                    @if(!$coupon->all_products)
                                    @foreach ($coupon->products as $item)
                                    {{$item->name}},
                                    @endforeach
                                    @else
                                    @lang('lang.all_products')
                                    @endif
                                </td>
                                <td>
                                    @if($coupon->used)
                                    @php
                                    $transaction = App\Models\Transaction::where('type', 'sell')->where('coupon_id',
                                    $coupon->id)->first();
                                    @endphp
                                    @if(!empty($transaction))
                                    <a data-href="{{action('SellController@show', $transaction->id)}}"
                                        data-container=".view_modal" class="btn btn-modal">
                                        @lang('lang.used') </a>
                                    @else
                                    @lang('lang.used')
                                    @endif
                                    @else
                                    @lang('lang.not_used')
                                    @endif
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
                                            @can('coupons_and_gift_cards.coupon.create_and_edit')
                                            <li>

                                                <a href="{{action('CouponController@edit', $coupon->id)}}"
                                                    class="btn"><i class="dripicons-document-edit"></i>
                                                    @lang('lang.edit')</a>
                                            </li>
                                            <li class="divider"></li>
                                            @endcan
                                            @can('coupons_and_gift_cards.coupon.delete')
                                            <li>
                                                <a data-href="{{action('CouponController@destroy', $coupon->id)}}"
                                                    data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
                                                    class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                    @lang('lang.delete')</a>
                                            </li>
                                            @endcan
                                            <li>
                                                <a data-href="{{action('CouponController@toggleActive', $coupon->id)}}"
                                                    class="btn text-red toggle-active"><i class="fa fa-refresh"></i>
                                                    @if($coupon->active) @lang('lang.suspend') @else
                                                    @lang('lang.reactivate')
                                                    @endif</a>
                                            </li>

                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
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
@endsection

@section('javascript')
<script>
    $(document).on('click', 'a.toggle-active', function(e) {
		e.preventDefault();

        $.ajax({
            method: 'get',
            url: $(this).data('href'),
            data: {  },
            success: function(result) {
                if (result.success == true) {
                    swal(
                    'Success',
                    result.msg,
                    'success'
                    );
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }
            },
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
@endsection