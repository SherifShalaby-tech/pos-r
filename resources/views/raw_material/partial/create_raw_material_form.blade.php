@php
$recent_product = App\Models\Product::where('is_raw_material', 1)->orderBy('created_at', 'desc')->first();
@endphp
<div class="card mb-1">
    <div class="card-body py-1 mb-1">
        <div class="col-12 mb-2">
            <p class="italic mb-0 @if (app()->isLocale('ar')) text-right @else text-left @endif">
                <small>@lang('lang.required_fields_info')</small>
            </p>
        </div>
        <div class="row justify-content-around @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="col-md-2 px-0">
                {!! Form::label('brand_id', __('lang.brand'), [
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                ]) !!}
                <div class="input-group my-group">
                    {!! Form::select('brand_id', $brands,
                    !empty($recent_product) ? $recent_product->brand_id : false, ['class' => 'selectpicker
                    form-control',
                    'data-live-search'=>"true",
                    'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
                    <span class="input-group-btn">
                        @can('product_module.brand.create_and_edit')
                        <button class="btn-modal btn btn-primary btn-partial  btn-flat"
                            data-href="{{action('BrandController@create')}}?quick_add=1" data-container=".view_modal"><i
                                class="fa fa-plus-circle text-white fa-lg"></i></button>
                        @endcan
                    </span>
                </div>
                <div class="error-msg text-red"></div>
            </div>
            <div class="col-md-2 px-0">
                <div class="form-group">
                    {!! Form::label('name', __('lang.name') . ' *', [
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    {!! Form::text('name', !empty($recent_product) ? $recent_product->name : null, ['class' =>
                    'form-control',
                    'required', 'placeholder'
                    => __('lang.name')]) !!}
                </div>
            </div>
            <div class="col-md-2 px-0">
                <div class="form-group supplier_div">
                    {!! Form::label('supplier_id', __('lang.supplier'), [
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    <div class="input-group my-group">
                        {!! Form::select('supplier_id', $suppliers, !empty($recent_product->supplier) ?
                        $recent_product->supplier->id : false, ['class' => 'selectpicker form-control',
                        'data-live-search' =>
                        'true', 'style' => 'width: 80%', 'placeholder' => __('lang.please_select')]) !!}
                        <span class="input-group-btn">
                            @can('supplier_module.supplier.create_and_edit')
                            <button type="button" class="btn-modal btn btn-primary btn-partial  btn-flat"
                                data-href="{{ action('SupplierController@create') }}?quick_add=1"
                                data-container=".view_modal"><i class="fa fa-plus-circle text-white fa-lg"></i></button>
                            @endcan
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-2 px-0">
                <div class="form-group">
                    {!! Form::label('sku', __('lang.sku') , [
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    {!! Form::text('sku', null, ['class' => 'form-control', 'placeholder'
                    => __('lang.sku')]) !!}
                </div>
            </div>

            <div class="col-md-2 px-0">
                {!! Form::label('multiple_units', __('lang.unit'), [
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                ]) !!}
                <div class="input-group my-group">
                    {!! Form::select('multiple_units[]', $units,
                    false, ['class' => 'selectpicker form-control',
                    'data-live-search'=>"true",
                    'style' =>'width: 80%' , 'placeholder' => __('lang.please_select'), 'id' => 'multiple_units']) !!}
                    <span class="input-group-btn">
                        @can('product_module.unit.create_and_edit')
                        <button class="btn-modal btn btn-primary btn-partial  btn-flat"
                            data-href="{{action('UnitController@create')}}?quick_add=1&is_raw_material_unit=1"
                            data-container=".view_modal"><i class="fa fa-plus-circle text-white fa-lg"></i></button>
                        @endcan
                    </span>
                </div>
            </div>
        </div>


        {{-- <div class="col-md-12 " style="margin-top: 10px;">
            <div class="dropzone" id="my-dropzone">
            </div>
        </div> --}}

        <div class="row justify-content-around @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <div class="col-md-4 hide">
                <div class="form-group">
                    {!! Form::label('barcode_type', __('lang.barcode_type'), [
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    {!! Form::select('barcode_type', ['C128' => 'Code 128' , 'C39' => 'Code 39', 'UPCA'
                    => 'UPC-A', 'UPCE' => 'UPC-E', 'EAN8' => 'EAN-8', 'EAN13' => 'EAN-13'], !empty($recent_product) ?
                    $recent_product->barcode_type : false,
                    ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('alert_quantity', __('lang.alert_quantity'), [
                            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::text('alert_quantity', !empty($recent_product) ?
                            @num_format($recent_product->alert_quantity)
                            : 3,
                            ['class' => 'form-control', 'placeholder' =>
                            __('lang.alert_quantity')]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="unit_label" style="margin-top: 37px;"></label>
                    </div>
                    <div class="col-md-6 hide">
                        <div class="form-group">
                            {!! Form::label('alert_quantity_unit_id', __('lang.unit'), [
                            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::select('alert_quantity_unit_id', $units,
                            !empty($recent_product) ? $recent_product->alert_quantity_unit_id : false, ['class' =>
                            'selectpicker
                            form-control',
                            'data-live-search'=>"true",
                            'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
                        </div>
                    </div>
                </div>
            </div>


            @can('product_module.purchase_price.create_and_edit')
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('purchase_price', __('lang.cost') . ' *', [
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    {!! Form::text('purchase_price', !empty($recent_product) ?
                    @num_format($recent_product->purchase_price) :
                    null, ['class' => 'form-control', 'placeholder' =>
                    session('system_mode') == 'pos' || session('system_mode') == 'garments' || session('system_mode') ==
                    'supermarket' ? __('lang.purchase_price') : __('lang.cost'), 'required']) !!}
                </div>
            </div>
            @endcan


            <div class="col-md-12 hide">
                <table class="table table-bordered" id="consumption_table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">@lang('lang.used_in')</th>
                            <th style="width: 30%;">@lang('lang.used_amount')</th>
                            <th style="width: 30%;">@lang('lang.unit')</th>
                            <th style="width: 10%;"><button class="btn btn-xs btn-success add_product_row"
                                    type="button"><i class="fa fa-plus"></i></button></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <input type="hidden" name="is_raw_material" id="is_raw_material" value="1">
            <input type="hidden" name="row_id" id="row_id" value="1">
        </div>
    </div>
</div>

<x-collapse collapse-id="productImage" button-class="d-flex mb-1 justify-content-between flex-row-reverse
    align-items-center gap-10 product_collapse_shadow" group-class="d-flex mb-2 align-items-end flex-column">
    <x-slot name="button">
        @lang('lang.product_details')
        <div class="collapse_arrow">
            <i class="fas fa-arrow-down"></i>
        </div>
    </x-slot>

    <div class="row justify-content-around @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        <div class="col-md-12">
            <div class="form-group">

                <textarea name="product_details" id="product_details" class="form-control"
                    rows="3">{{!empty($recent_product) ? $recent_product->product_details : ''}}</textarea>
            </div>
        </div>
    </div>
</x-collapse>
