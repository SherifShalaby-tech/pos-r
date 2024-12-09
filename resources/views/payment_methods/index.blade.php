@extends('layouts.app')
@section('title', __('lang.payment_methods'))

@section('content')
<section class="forms py-2">

    <div class="container-fluid px-2">

        <div class="col-md-12 px-0 no-print">

            <x-page-title>
                <h4 class="print-title">@lang('lang.payment_methods')</h4>
                <x-slot name="buttons">
                    {{-- @can('product_module.color.create_and_edit') --}}
                    <a style="color: white" data-href="{{action('PaymentMethodController@create')}}"
                        data-container=".view_modal" class="btn btn-modal btn-primary"><i class="dripicons-plus"></i>
                        @lang('lang.add_payment_method')</a>
                    {{-- @endcan --}}
                </x-slot>
            </x-page-title>
            <div
                class="top-controls py-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">

            </div>
            <div class="card mt-1 mb-0">
                <div class="card-body py-2 px-4">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>@lang('lang.name')</th>
                                    <th>@lang('lang.is_active')</th>
                                    <th class="notexport">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paymentMethods as $paymentMethod)
                                <tr>
                                    <td>{{$paymentMethod->name}}</td>
                                    <td>
                                        <div
                                            class="i-checks toggle-pill-color d-flex justify-content-center align-items-center flex-column">
                                            <input @if ($paymentMethod->is_active === 1)
                                            checked
                                            @endif
                                            class="form-control-custom" id="is_active{{ $paymentMethod->id }}"
                                            data-id="{{ $paymentMethod->id }}"
                                            name="is_active{{ $paymentMethod->id }}" type="checkbox">
                                            <label
                                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                for="is_active{{ $paymentMethod->id }}"></label>
                                            <span>

                                            </span>
                                        </div>
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
                                                {{-- @can('product_module.color.create_and_edit') --}}
                                                <li>
                                                    <a data-href="{{action('PaymentMethodController@edit', $paymentMethod->id)}}"
                                                        data-container=".view_modal"
                                                        class="btn btn-modal @if ($paymentMethod->is_default) disabled  @endif"><i
                                                            class="dripicons-document-edit"></i> @lang('lang.edit')</a>
                                                </li>
                                                <li class="divider"></li>
                                                {{-- @endcan --}}
                                                <li>
                                                    <a data-href="{{action('PaymentMethodController@destroy', $paymentMethod->id)}}"
                                                        data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
                                                        class="btn text-red delete_item @if ($paymentMethod->is_default) disabled @endif"><i
                                                            class="fa fa-trash"></i>
                                                        @lang('lang.delete')</a>
                                                </li>
                                                <li class="divider"></li>

                                                <li>
                                                    <a data-href="{{action('PaymentMethodTypeController@addType', $paymentMethod->id)}}"
                                                        data-container=".view_modal"
                                                        class="btn btn-modal @if ($paymentMethod->is_default) disabled  @endif"><i
                                                            class="dripicons-document-edit"></i>
                                                        @lang('lang.add_types')</a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href="{{action('PaymentMethodTypeController@getTypes', $paymentMethod->id)}}"
                                                        data-container=".view_modal"
                                                        class="btn btn-modal @if ($paymentMethod->is_default) disabled  @endif"><i
                                                            class="dripicons-document-edit"></i>
                                                        @lang('lang.view_types')</a>
                                                </li>
                                                <li class="divider"></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div
                class="bottom-controls mt-1 p-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">
                <!-- Pagination and other controls can go here -->
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')
<script>
    $(document).ready(function () {
        // Attach change event to input elements
        $('.form-control-custom').on('change', function () {

            // Get the value of the data-id attribute
            const dataId = $(this).attr('data-id');

            // Check if the checkbox is checked
            const isChecked = $(this).is(':checked');

            let status;

            if(isChecked){
                status =1
            }else{
                status =0
            }

            $.ajax({
                method: 'get',
                url: `/payment-method-change-status/${dataId}/${status}`,

                success: function(result) {
                    if(result.success){
                        toastr.options = {
                        "timeOut": "1000", // Time before it disappears (in milliseconds)
                        "extendedTimeOut": "1000" // Time after hovering before it disappears (in milliseconds)
                        };
                        toastr.success("Updated successfully");
                    }
                },
            });


        });
    });
</script>
@endsection