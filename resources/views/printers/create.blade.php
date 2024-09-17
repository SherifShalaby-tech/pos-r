@extends('layouts.app')
@section('title', __('lang.printers'))
@section('content')
<section class="forms py-2">
    <div class="container-fluid px-2">

        <x-page-title>

            <h4>@lang('lang.add_new_printer')</h4>


        </x-page-title>


        <div class="card mt-1 mb-0">
            <div class="card-body py-2 px-4">
                <form action="{{route('printers.store')}}" method="POST">
                    @csrf
                    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {!! Form::label('name', __('lang.name') , [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    <span class="text-danger">*</span>
                                </div>
                                <div class="input-group my-group">
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required',
                                    'placeholder' => __('lang.name')]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                    for="products">{{trans('lang.products')}}</label>
                                <div class="input-group my-group">
                                    <select id="products" data-live-search="true" class="selectpicker form-control"
                                        name="products[]" multiple>
                                        @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                    for="stores">{{trans('lang.stores')}}</label>
                                <div class="input-group my-group">
                                    <select id="store_id" class="selectpicker form-control" name="store_id" required>
                                        <option value="">please select</option>
                                        @foreach($stores as $store)
                                        <option value="{{$store->id}}">{{$store->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                    for="is_active">{{trans('lang.status')}}</label>
                                <div class="input-group my-group">
                                    <select id="is_active" class="selectpicker form-control" name="is_active">
                                        <option value="1">{{trans('lang.active')}}</option>
                                        <option value="0">{{trans('lang.not_active')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <div class="d-flex align-items-center flex-column toggle-pill-color">
                                <input id="is_cashier" name="is_cashier" type="checkbox" value="1"
                                    class="form-control-custom">
                                <label for="is_cashier">

                                </label>
                                <span>
                                    <strong>
                                        @lang('lang.is_cashier')
                                    </strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-12 d-flex">
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
