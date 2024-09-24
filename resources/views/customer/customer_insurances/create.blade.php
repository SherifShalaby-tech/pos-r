@extends('layouts.app')
@section('title',trans('lang.add_new_deposit'))
@section('content')
<section class="forms py-2">
    <div class="container-fluid px-2">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>

                    <h4>@lang('lang.add_new_deposit')</h4>

                </x-page-title>


                <div class="card">

                    <div class="card-body">
                        <form action="{{route('customer-insurances.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="admin_id" value="{{auth()->user()->id}}">
                            <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif">{{trans('lang.product')}}</label>
                                        <select required="required" class="form-control" name="item_id">
                                            @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif">{{trans('lang.customer')}}</label>
                                        <select required="required" class="form-control" name="customer_id">
                                            @foreach($clients as $customer)
                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif">{{trans('lang.status')}}</label>
                                        <select required="required" class="form-control" name="status">
                                            <option value="Available">Available</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Late">Late</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif">{{trans('lang.insurance_amount')}}</label>
                                        <input required="required" type="number" name="insurance_amount"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif">{{trans('lang.return_date')}}</label>
                                        <input required="required" type="date" name="return_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mt-5">
                                    <div class="form-group">
                                        <input type="submit" value="{{ trans('lang.save') }}" id="submit-btn"
                                            class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
