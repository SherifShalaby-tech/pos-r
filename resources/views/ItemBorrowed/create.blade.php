@extends('layouts.app')
@section('title',trans('lang.add_new_product'))
@section('content')
<section class="forms py-2">
    <div class="container-fluid px-2">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>

                    <h4>@lang('lang.add_new_product')</h4>


                </x-page-title>



                <form action="{{route('item-borrowed.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="admin_id" value="{{auth()->user()->id}}">
                    <div class="card mt-1 mb-0">
                        <div class="card-body py-2 px-4">
                            <div
                                class="row justify-content-start @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif">{{trans('lang.product_name')}}</label>
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                </div>
                                {{-- <div class="col-md-4">--}}
                                    {{-- <div class="form-group">--}}
                                        {{-- <label
                                            class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif">{{trans('lang.customer')}}</label>--}}
                                        {{-- <select required="required" class="form-control" name="customer_id">--}}
                                            {{-- @foreach($clients as $customer)--}}
                                            {{-- <option value="{{$customer->id}}">{{$customer->name}}</option>--}}
                                            {{-- @endforeach--}}
                                            {{-- </select>--}}
                                        {{-- </div>--}}
                                    {{-- </div>--}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif">{{trans('lang.insurance_amount')}}</label>
                                        <input required="required" type="number" name="deposit_amount"
                                            class="form-control">
                                    </div>
                                </div>
                                {{-- <div class="col-md-4">--}}
                                    {{-- <div class="form-group">--}}
                                        {{-- <label>{{trans('lang.return_date')}}</label>--}}
                                        {{-- <input required="required" type="date" name="return_date"
                                            class="form-control">--}}
                                        {{-- </div>--}}
                                    {{-- </div>--}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
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

</section>

@stop
