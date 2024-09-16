@extends('layouts.app')
@section('title', __('lang.product'))
@section("styles")
<style>
    .preview-edit-product-container {
        /* display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px; */
        display: grid;
        grid-template-columns: repeat(auto-fill, 170px);
    }

    .preview {
        position: relative;
        width: 150px;
        height: 150px;
        padding: 4px;
        box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        margin: 30px 0px;
        border: 1px solid #ddd;
    }

    .preview img {
        width: 100%;
        height: 100%;
        box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        border: 1px solid #ddd;
        object-fit: cover;

    }

    .delete-btn {
        position: absolute;
        top: 156px;
        right: 0px;
        /*border: 2px solid #ddd;*/
        border: none;
        cursor: pointer;
    }

    .delete-btn {
        background: transparent;
        color: rgba(235, 32, 38, 0.97);
    }

    .crop-btn {
        position: absolute;
        top: 156px;
        left: 0px;
        /*border: 2px solid #ddd;*/
        border: none;
        cursor: pointer;
        background: transparent;
        color: #007bff;
    }
</style>
<style>
    .variants {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .variants>div {
        margin-right: 5px;
    }

    .variants>div:last-of-type {
        margin-right: 0;
    }

    .file {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .file>input[type='file'] {
        display: none
    }

    .file>label {
        font-size: 1rem;
        font-weight: 300;
        cursor: pointer;
        outline: 0;
        user-select: none;
        border-color: rgb(216, 216, 216) rgb(209, 209, 209) rgb(186, 186, 186);
        border-style: solid;
        border-radius: 4px;
        border-width: 1px;
        background-color: hsl(0, 0%, 100%);
        color: hsl(0, 0%, 29%);
        padding-left: 16px;
        padding-right: 16px;
        padding-top: 16px;
        padding-bottom: 16px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .file>label:hover {
        border-color: hsl(0, 0%, 21%);
    }

    .file>label:active {
        background-color: hsl(0, 0%, 96%);
    }

    .file>label>i {
        padding-right: 5px;
    }

    .file--upload>label {
        color: hsl(204, 86%, 53%);
        border-color: hsl(204, 86%, 53%);
    }

    .file--upload>label:hover {
        border-color: hsl(204, 86%, 53%);
        background-color: hsl(204, 86%, 96%);
    }

    .file--upload>label:active {
        background-color: hsl(204, 86%, 91%);
    }

    .file--uploading>label {
        color: hsl(48, 100%, 67%);
        border-color: hsl(48, 100%, 67%);
    }

    .file--uploading>label>i {
        animation: pulse 5s infinite;
    }

    .file--uploading>label:hover {
        border-color: hsl(48, 100%, 67%);
        background-color: hsl(48, 100%, 96%);
    }

    .file--uploading>label:active {
        background-color: hsl(48, 100%, 91%);
    }

    .file--success>label {
        color: hsl(141, 71%, 48%);
        border-color: hsl(141, 71%, 48%);
    }

    .file--success>label:hover {
        border-color: hsl(141, 71%, 48%);
        background-color: hsl(141, 71%, 96%);
    }

    .file--success>label:active {
        background-color: hsl(141, 71%, 91%);
    }

    .file--danger>label {
        color: hsl(348, 100%, 61%);
        border-color: hsl(348, 100%, 61%);
    }

    .file--danger>label:hover {
        border-color: hsl(348, 100%, 61%);
        background-color: hsl(348, 100%, 96%);
    }

    .file--danger>label:active {
        background-color: hsl(348, 100%, 91%);
    }

    .file--disabled {
        cursor: not-allowed;
    }

    .file--disabled>label {
        border-color: #e6e7ef;
        color: #e6e7ef;
        pointer-events: none;
    }

    @keyframes pulse {
        0% {
            color: hsl(48, 100%, 67%);
        }

        50% {
            color: hsl(48, 100%, 38%);
        }

        100% {
            color: hsl(48, 100%, 67%);
        }
    }
</style>
@endsection
@section('content')
<section class="forms py-2">
    <div class="container-fluid px-2">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>
                    <h4>@lang('lang.edit_product')</h4>


                    <x-slot name="buttons">

                    </x-slot>
                </x-page-title>


                <div class="card">

                    <div class="card-body">
                        <p class="italic"><small>@lang('lang.required_fields_info')</small></p>
                        {!! Form::open(['url' => action('ProductController@update', $product->id), 'id' =>
                        'product-edit-form', 'method' => 'PUT', 'class' => '', 'enctype' => 'multipart/form-data']) !!}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="i-checks">
                                    <input id="is_service" name="is_service" type="checkbox" @if
                                        (!empty($product->is_service)) checked @endif value="@if($product->is_service)1
                                    @else 0 @endif"
                                    class="form-control-custom">
                                    <label for="is_service"><strong>
                                            @if (session('system_mode') == 'restaurant')
                                            @lang('lang.or_add_new_product')
                                            @else
                                            @lang('lang.add_new_service')
                                            @endif
                                        </strong></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="i-checks">
                                    <input id="active" name="active" type="checkbox" @if (!empty($product->active))
                                    checked @endif value="1"
                                    class="form-control-custom">
                                    <label for="active"><strong>
                                            @lang('lang.active')
                                        </strong></label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="i-checks">
                                    <input id="have_weight" name="have_weight" type="checkbox" @if
                                        (!empty($product->have_weight)) checked @endif value="1"
                                    class="form-control-custom">
                                    <label for="have_weight"><strong>
                                            @lang('lang.have_weight')
                                        </strong></label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group supplier_div @if (empty($product->is_service)) hide @endif">
                                    {!! Form::label('supplier_id', __('lang.supplier'), []) !!}
                                    <div class="input-group my-group">
                                        {!! Form::select('supplier_id', $suppliers, !empty($product->supplier) ?
                                        $product->supplier->id : false, ['class' => 'selectpicker form-control',
                                        'data-live-search' => 'true', 'style' => 'width: 80%', 'placeholder' =>
                                        __('lang.please_select')]) !!}
                                        <span class="input-group-btn">
                                            @can('supplier_module.supplier.create_and_edit')
                                            <button type="button" class="btn-modal btn btn-default bg-white btn-flat"
                                                data-href="{{ action('SupplierController@create') }}?quick_add=1"
                                                data-container=".view_modal"><i
                                                    class="fa fa-plus-circle text-primary fa-lg"></i></button>
                                            @endcan
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                @if (session('system_mode') == 'restaurant')
                                {!! Form::label('product_class_id', __('lang.category') . ' *', []) !!}
                                @else
                                {!! Form::label('product_class_id', __('lang.class') . ' *', []) !!}
                                @endif
                                <div class="input-group my-group">
                                    {!! Form::select('product_class_id', $product_classes, $product->product_class_id,
                                    ['class' => 'selectpicker form-control', 'data-live-search' => 'true', 'style' =>
                                    'width: 80%', 'placeholder' => __('lang.please_select'), 'required']) !!}
                                    <span class="input-group-btn">
                                        @can('product_module.product_class.create_and_edit')
                                        <button type="button" class="btn-modal btn btn-default bg-white btn-flat"
                                            data-href="{{ action('ProductClassController@create') }}?quick_add=1"
                                            data-container=".view_modal"><i
                                                class="fa fa-plus-circle text-primary fa-lg"></i></button>
                                        @endcan
                                    </span>
                                </div>
                                <div class="error-msg text-red"></div>
                            </div>
                            @if (session('system_mode') == 'pos' || session('system_mode') == 'garments' ||
                            session('system_mode') == 'supermarket')
                            <div class="col-md-4">
                                {!! Form::label('category_id', __('lang.category') . ' *', []) !!}
                                <div class="input-group my-group">
                                    {!! Form::select('category_id', $categories, $product->category_id, ['class' =>
                                    'selectpicker form-control', 'data-live-search' => 'true', 'style' => 'width: 80%',
                                    'placeholder' => __('lang.please_select'), 'required']) !!}
                                    <span class="input-group-btn">
                                        @can('product_module.category.create_and_edit')
                                        <button type="button" class="btn-modal btn btn-default bg-white btn-flat"
                                            data-href="{{ action('CategoryController@create') }}?quick_add=1&type=category"
                                            data-container=".view_modal"><i
                                                class="fa fa-plus-circle text-primary fa-lg"></i></button>
                                        @endcan
                                    </span>
                                </div>
                                <div class="error-msg text-red"></div>
                            </div>
                            <div class="col-md-4">
                                {!! Form::label('sub_category_id', __('lang.sub_category') . ' *', []) !!}
                                <div class="input-group my-group">
                                    {!! Form::select('sub_category_id', $sub_categories, $product->sub_category_id,
                                    ['class' => 'selectpicker form-control', 'data-live-search' => 'true', 'style' =>
                                    'width: 80%', 'placeholder' => __('lang.please_select')]) !!}
                                    <span class="input-group-btn">
                                        @can('product_module.sub_category.create_and_edit')
                                        <button type="button" class="btn-modal btn btn-default bg-white btn-flat"
                                            data-href="{{ action('CategoryController@create') }}?quick_add=1"
                                            data-container=".view_modal"><i
                                                class="fa fa-plus-circle text-primary fa-lg"></i></button>
                                        @endcan
                                    </span>
                                </div>
                                <div class="error-msg text-red"></div>
                            </div>
                            <div class="col-md-4">
                                {!! Form::label('brand_id', __('lang.brand') . ' *', []) !!}
                                <div class="input-group my-group">
                                    {!! Form::select('brand_id', $brands, $product->brand_id, ['class' => 'selectpicker
                                    form-control', 'data-live-search' => 'true', 'style' => 'width: 80%', 'placeholder'
                                    => __('lang.please_select'), 'required']) !!}
                                    <span class="input-group-btn">
                                        @can('product_module.brand.create_and_edit')
                                        <button type="button" class="btn-modal btn btn-default bg-white btn-flat"
                                            data-href="{{ action('BrandController@create') }}?quick_add=1"
                                            data-container=".view_modal"><i
                                                class="fa fa-plus-circle text-primary fa-lg"></i></button>
                                        @endcan
                                    </span>
                                </div>
                                <div class="error-msg text-red"></div>
                            </div>
                            @endif
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('name', __('lang.name') . ' *', []) !!}
                                    <div class="input-group my-group">
                                        {!! Form::text('name', $product->name, ['class' => 'form-control', 'required',
                                        'placeholder' => __('lang.name')]) !!}
                                        <span class="input-group-btn">
                                            <button type="button"
                                                class="btn btn-default bg-white btn-flat translation_btn" type="button"
                                                data-type="product"><i
                                                    class="dripicons-web text-primary fa-lg"></i></button>
                                        </span>
                                    </div>
                                </div>
                                @include('layouts.partials.translation_inputs', [
                                'attribute' => 'name',
                                'translations' => $product->translations,
                                'type' => 'product',
                                ])
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('sku', __('lang.sku') . ' *', []) !!}
                                    {!! Form::text('sku', $product->sku, ['class' => 'form-control', 'required',
                                    'placeholder' => __('lang.sku')]) !!}
                                </div>
                            </div>
                            @if (session('system_mode') == 'pos' || session('system_mode') == 'garments' ||
                            session('system_mode') == 'supermarket')
                            <div class="col-md-4">
                                {!! Form::label('multiple_units', __('lang.unit'), []) !!}
                                <div class="input-group my-group">
                                    {!! Form::select('multiple_units[]', $units, $product->multiple_units, ['class' =>
                                    'selectpicker form-control', 'data-live-search' => 'true', 'disabled' =>
                                    $product->type == 'variable' ? true : false, 'style' => 'width: 80%', 'multiple',
                                    'id' => 'multiple_units']) !!}
                                    <span class="input-group-btn">
                                        @can('product_module.unit.create_and_edit')
                                        <button type="button" class="btn-modal btn btn-default bg-white btn-flat"
                                            data-href="{{ action('UnitController@create') }}?quick_add=1"
                                            data-container=".view_modal"><i
                                                class="fa fa-plus-circle text-primary fa-lg"></i></button>
                                        @endcan
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                {!! Form::label('multiple_colors', __('lang.color'), []) !!}
                                <div class="input-group my-group">
                                    {!! Form::select('multiple_colors[]', $colors, $product->multiple_colors, ['class'
                                    => 'selectpicker form-control', 'data-live-search' => 'true', 'disabled' => false,
                                    'style' => 'width: 80%', 'multiple', 'id' => 'multiple_colors']) !!}
                                    <span class="input-group-btn">
                                        @can('product_module.color.create_and_edit')
                                        <button type="button" class="btn-modal btn btn-default bg-white btn-flat"
                                            data-href="{{ action('ColorController@create') }}?quick_add=1"
                                            data-container=".view_modal"><i
                                                class="fa fa-plus-circle text-primary fa-lg"></i></button>
                                        @endcan
                                    </span>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-4">
                                {!! Form::label('multiple_sizes', __('lang.size'), []) !!}
                                <div class="input-group my-group">
                                    {!! Form::select('multiple_sizes[]', $sizes, $product->multiple_sizes, ['class' =>
                                    'selectpicker form-control', 'data-live-search' => 'true', 'disabled' =>
                                    $product->type == 'variable' ? true : false, 'style' => 'width: 80%', 'multiple',
                                    'id' => 'multiple_sizes']) !!}
                                    <span class="input-group-btn">
                                        @can('product_module.size.create_and_edit')
                                        <button type="button" class="btn-modal btn btn-default bg-white btn-flat"
                                            data-href="{{ action('SizeController@create') }}?quick_add=1"
                                            data-container=".view_modal"><i
                                                class="fa fa-plus-circle text-primary fa-lg"></i></button>
                                        @endcan
                                    </span>
                                </div>
                            </div>
                            @if (session('system_mode') == 'pos' || session('system_mode') == 'garments' ||
                            session('system_mode') == 'supermarket')
                            <div class="col-md-4">
                                {!! Form::label('multiple_grades', __('lang.grade'), []) !!}
                                <div class="input-group my-group">
                                    {!! Form::select('multiple_grades[]', $grades, $product->multiple_grades, ['class'
                                    => 'selectpicker form-control', 'data-live-search' => 'true', 'disabled' =>
                                    $product->type == 'variable' ? true : false, 'style' => 'width: 80%', 'multiple',
                                    'id' => 'multiple_grades']) !!}
                                    <span class="input-group-btn">
                                        @can('product_module.grade.create_and_edit')
                                        <button type="button" class="btn-modal btn btn-default bg-white btn-flat"
                                            data-href="{{ action('GradeController@create') }}?quick_add=1"
                                            data-container=".view_modal"><i
                                                class="fa fa-plus-circle text-primary fa-lg"></i></button>
                                        @endcan
                                    </span>
                                </div>
                            </div>
                            @endif

                            <div class="col-md-12 " style="margin-top: 10px;">
                                <div class="container mt-3">
                                    <div class="row mx-0" style="border: 1px solid #ddd;padding: 30px 0px;">
                                        <div class="col-12">
                                            <div class="mt-3">
                                                <div class="row">
                                                    <div class="col-10 offset-1">
                                                        <div class="variants">
                                                            <div class='file file-upload w-100'>
                                                                <label for='file-product-edit-product' class="w-100">
                                                                    <i class="fas fa-cloud-upload-alt"></i>Upload
                                                                </label>
                                                                <!-- <input  id="file-input" multiple type='file' /> -->
                                                                <input type="file" id="file-product-edit-product">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-10 offset-1">
                                            <div class="preview-edit-product-container">
                                                @if(!empty($product->getFirstMediaUrl('product')))
                                                <div id="preview{{ $product->id }}" class="preview">
                                                    <img src="{{  $product->getFirstMediaUrl('product')  }}"
                                                        id="img{{  $product->id }}" alt="">
                                                    <div class="action_div"></div>
                                                    <button type="button" class="delete-btn"><i style="font-size: 20px;"
                                                            data-href="{{ action('ProductController@deleteProductImage', $product->id) }}"
                                                            id="deleteBtn{{ $product->id }}" class="fas fa-trash"></i>
                                                    </button>

                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    @if (session('system_mode') == 'restaurant')
                                    {!! Form::label('recipe', __('lang.recipe'), []) !!}
                                    @else
                                    <label>@lang('lang.product_details')</label>
                                    @endif
                                    <button type="button" class="translation_textarea_btn btn btn-sm"><i
                                            class="dripicons-web text-primary fa-lg"></i></button>
                                    <textarea name="product_details" id="product_details" class="form-control"
                                        rows="3">{{ $product->product_details }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    @include('layouts.partials.translation_textarea', [
                                    'attribute' => 'product_details',
                                    'translations' => $product->translations,
                                    ])
                                </div>
                            </div>
                            @if (session('system_mode') == 'restaurant' || session('system_mode') == 'garments' ||
                            session('system_mode') == 'pos')
                            <div class="col-md-4">
                                <div class="i-checks">
                                    <input id="automatic_consumption" name="automatic_consumption" type="checkbox" @if
                                        (!empty($product) && $product->automatic_consumption == 1) checked @endif
                                    value="1"
                                    class="form-control-custom">
                                    <label
                                        for="automatic_consumption"><strong>@lang('lang.automatic_consumption')</strong></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="i-checks">
                                    <input id="price_based_on_raw_material" name="price_based_on_raw_material"
                                        type="checkbox" @if ($product->price_based_on_raw_material == 1) checked @endif
                                    value="1"
                                    class="form-control-custom">
                                    <label
                                        for="price_based_on_raw_material"><strong>@lang('lang.price_based_on_raw_material')</strong></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="i-checks">
                                    <input id="buy_from_supplier" name="buy_from_supplier" type="checkbox" @if
                                        ($product->buy_from_supplier == 1) checked @endif value="1"
                                    class="form-control-custom">
                                    <label
                                        for="buy_from_supplier"><strong>@lang('lang.buy_from_supplier')</strong></label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered" id="consumption_table">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%;">@lang('lang.raw_materials')</th>
                                            <th style="width: 30%;">@lang('lang.used_amount')</th>
                                            <th style="width: 30%;">@lang('lang.unit')</th>
                                            <th style="width: 30%;">@lang('lang.cost')</th>
                                            <th style="width: 10%;"><button
                                                    class="btn btn-xs btn-success add_raw_material_row" type="button"><i
                                                        class="fa fa-plus"></i></button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $first_variation = $product->variations->first();
                                        $consumption_products = App\Models\ConsumptionProduct::where('variation_id',
                                        $first_variation->id)->get();
                                        @endphp
                                        @foreach ($consumption_products as $consumption_product)
                                        @include('product.partial.raw_material_row', [
                                        'row_id' => $loop->index,
                                        'consumption_product' => $consumption_product,
                                        ])
                                        @endforeach
                                    </tbody>
                                </table>
                                <input type="hidden" name="raw_material_row_index" id="raw_material_row_index"
                                    value="@if (!empty($consumption_products) && $consumption_products->count() > 0) {{ $consumption_products->count() }}@else{{ 0 }} @endif">
                            </div>
                            <div class="col-md-12"><strong>@lang('lang.product_extension')</strong></div>
                            <div class="col-md-12">

                                <table class="table table-bordered" id="extensions_table">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%;">@lang('lang.product_extension')</th>
                                            <th style="width: 30%;">@lang('lang.used_amount')</th>

                                            <th style="width: 10%;"><button
                                                    class="btn btn-xs btn-success add_extension_row" type="button"><i
                                                        class="fa fa-plus"></i></button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $first_variation = $product->variations->first();
                                        $extension_products = App\Models\ProductExtension::
                                        where('variation_id', $first_variation->id)->get();
                                        @endphp
                                        @foreach ($extension_products as $extension_product)
                                        @include('product.partial.extension_row', [
                                        'row_id' => $loop->index,
                                        'extension_product' => $extension_product,
                                        ])
                                        @endforeach

                                    </tbody>
                                </table>
                                <input type="hidden" name="extension_row_index" id="extension_row_index" value="1">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input depends_on" type="radio" name="depends_on"
                                            id="selling_price_depends" value="1">
                                        <label class="form-check-label" for="selling_price_depends">سعر البيع يعتمد على
                                            سعر الشراء</label>
                                        <div class="form-group selling_price_depends_div hide">
                                            <label>سعر البيع يزيد عن سعر الشراء بــمبلغ</label>
                                            <select class="form-control mb-2" name="selling_price_depends_type">
                                                <option value="rate">نسبة</option>
                                                <option value="amount">مبلغ</option>
                                            </select>
                                            <input type="number" class="form-control" name="selling_price_depends"
                                                value="{{$product->selling_price_depends}}">

                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input depends_on" type="radio" name="depends_on"
                                            id="purchase_price_depends" value="2">
                                        <label class="form-check-label" for="purchase_price_depends">سعر الشراء يعتمد
                                            على سعر البيع</label>
                                        <div class="form-group purchase_price_depends_div hide">
                                            <label>سعر الشراء يقل عن سعر البيع بــمبلغ</label>
                                            <select class="form-control mb-2" name="purchase_price_depends_type">
                                                <option value="rate">نسبة</option>
                                                <option value="amount">مبلغ</option>
                                            </select>
                                            <input type="number" class="form-control" name="purchase_price_depends"
                                                value="{{$product->purchase_price_depends}}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endif
                            @if (session('system_mode') == 'pos' || session('system_mode') == 'garments' ||
                            session('system_mode') == 'supermarket')
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('barcode_type', __('lang.barcode_type') . ' *', []) !!}
                                    {!! Form::select('barcode_type', ['C128' => 'Code 128', 'C39' => 'Code 39', 'UPCA'
                                    => 'UPC-A', 'UPCE' => 'UPC-E', 'EAN8' => 'EAN-8', 'EAN13' => 'EAN-13'],
                                    $product->barcode_type, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('alert_quantity', __('lang.alert_quantity') . ' *', []) !!}
                                    {!! Form::text('alert_quantity', $product->alert_quantity, ['class' =>
                                    'form-control', 'placeholder' => __('lang.alert_quantity')]) !!}
                                </div>
                            </div>
                            @endif
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('other_cost', __('lang.other_cost'), []) !!}
                                    {!! Form::text('other_cost', @num_format($product->other_cost), ['class' =>
                                    'form-control', 'placeholder' => __('lang.other_cost')]) !!}
                                </div>
                            </div>
                            @can('product_module.purchase_price.create_and_edit')
                            <div class="col-md-4 supplier_div @if (empty($product->is_service)) hide @endif">
                                <div class="form-group">
                                    {!! Form::label('purchase_price', session('system_mode') == 'pos' ||
                                    session('system_mode') == 'garments' || session('system_mode') == 'supermarket' ?
                                    __('lang.purchase_price') : __('lang.cost') . ' *', []) !!}
                                    {!! Form::text('purchase_price', @num_format($product->purchase_price), ['class' =>
                                    'form-control', 'placeholder' => session('system_mode') == 'pos' ||
                                    session('system_mode') == 'garments' || session('system_mode') == 'supermarket' ?
                                    __('lang.purchase_price') : __('lang.cost'), 'required']) !!}
                                </div>
                            </div>
                            @endcan
                            <div class="col-md-4 supplier_div @if (empty($product->is_service)) hide @endif">
                                <div class="form-group">
                                    {!! Form::label('sell_price', __('lang.sell_price') . ' *', []) !!}
                                    {!! Form::text('sell_price', @num_format($product->sell_price), ['class' =>
                                    'form-control', 'placeholder' => __('lang.sell_price'), 'required']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                {!! Form::label('tax_id', __('lang.tax'), []) !!}
                                <div class="input-group my-group">
                                    {!! Form::select('tax_id', $taxes, $product->tax_id, ['class' => 'selectpicker
                                    form-control', 'data-live-search' => 'true', 'style' => 'width: 80%', 'placeholder'
                                    => __('lang.please_select')]) !!}
                                    <span class="input-group-btn">
                                        @can('product_module.tax.create')
                                        <button type="button" class="btn-modal btn btn-default bg-white btn-flat"
                                            data-href="{{ action('TaxController@create') }}?quick_add=1"
                                            data-container=".view_modal"><i
                                                class="fa fa-plus-circle text-primary fa-lg"></i></button>
                                        @endcan
                                    </span>
                                </div>
                                <div class="error-msg text-red"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('tax_method', __('lang.tax_method'), []) !!}
                                    {!! Form::select('tax_method', ['inclusive' => __('lang.inclusive'), 'exclusive' =>
                                    __('lang.exclusive')], $product->tax_method, ['class' => 'selectpicker
                                    form-control', 'data-live-search' => 'true', 'style' => 'width: 80%', 'placeholder'
                                    => __('lang.please_select')]) !!}
                                </div>
                            </div>
                            <br>
                            <div class="clearfix"></div>

                            <div class="col-md-12">
                                <table class="table table-bordered" id="consumption_table_discount">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%;">@lang('lang.discount_type')</th>
                                            <th style="width: 15%;">@lang('lang.discount')</th>
                                            <th style="width: 7%;">@lang('lang.discount_category')</th>
                                            <th style="width: 5%;"></th>
                                            <th style="width: 20%;">@lang('lang.discount_start_date')</th>
                                            <th style="width: 20%;">@lang('lang.discount_end_date')</th>
                                            <th style="width: 20%;">@lang('lang.customer_type') <i
                                                    class="dripicons-question" data-toggle="tooltip"
                                                    title="@lang('lang.discount_customer_info')"></i></th>
                                            <th style="width: 5%;"><button
                                                    class="btn btn-xs btn-success add_discount_row" type="button"><i
                                                        class="fa fa-plus"></i></button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $discounts =
                                        \App\Models\ProductDiscount::where('product_id',$product->id)->get();
                                        $index_old=0;
                                        @endphp

                                        @if($product->discount)
                                        @php
                                        $index_old=1;
                                        @endphp
                                        @include('product.partial.raw_discount', [
                                        'row_id' => 0,
                                        'discount_product'=>$product,
                                        ])
                                        @endif
                                        @foreach($discounts as $discount)
                                        @include('product.partial.raw_discount', [
                                        'row_id' => $loop->index + $index_old,
                                        'discount'=>$discount,
                                        ])
                                        @endforeach
                                    </tbody>
                                </table>
                                <input type="hidden" name="raw_discount_index" id="raw_discount_index"
                                    value="{{count($discounts)}}">
                            </div>
                            <div class="panel-group" id="accordion" style="margin-bottom: 20px">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                                href="#collapseTwo">
                                                @lang('lang.printers')
                                            </a>
                                        </h4>
                                    </div>

                                    <div id="collapseTwo"
                                        class="panel-collapse collapse @if(count($printers_p)> 0) show @endif">

                                        <div class="panel-body">
                                            <select class="form-select" id="selectStore">
                                                <option selected>Select Store</option>
                                                @foreach ($employee_stores as $store)
                                                @php
                                                $isSelected = false;
                                                foreach ($printers_p as $p) {
                                                $printer_store = \App\Models\Printer::find($p->printer_id);
                                                if($printer_store){
                                                if ($printer_store->store_id == $store->id) {
                                                $isSelected = true;
                                                break;
                                                }
                                                }

                                                }
                                                @endphp
                                                <option value="{{$store->id}}" @if ($isSelected) selected @endif>
                                                    {{$store->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="col-md-12 i-checks" style="margin-left: 40px"
                                                id="printersContainer">
                                                {{-- @foreach ($printers as $printerId => $printerName) --}}
                                                {{-- @php
                                                $isChecked = false;
                                                @endphp

                                                @foreach ($printers_p as $print_p)
                                                @if ($print_p->printer_id == $printerId)
                                                @php
                                                $isChecked = true;
                                                @endphp
                                                @endif
                                                @endforeach

                                                <input class="form-control ml-3" type="checkbox" name="printers[]"
                                                    value="{{ $printerId }}" @if ($isChecked) checked @endif>
                                                <label for="printer{{ $printerId }}">{{ $printerName }}</label> --}}
                                                {{-- @endforeach --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="i-checks">
                                    <input id="show_to_customer" name="show_to_customer" type="checkbox" @if
                                        ($product->show_to_customer) checked @endif value="1"
                                    class="form-control-custom">
                                    <label
                                        for="show_to_customer"><strong>@lang('lang.show_to_customer')</strong></label>
                                </div>
                            </div>

                            <div class="col-md-12 show_to_customer_type_div">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('show_to_customer_types', __('lang.show_to_customer_types'), [])
                                        !!}
                                        <i class="dripicons-question" data-toggle="tooltip"
                                            title="@lang('lang.show_to_customer_types_info')"></i>
                                        {!! Form::select('show_to_customer_types[]', $customer_types,
                                        $product->show_to_customer_types, ['class' => 'selectpicker form-control',
                                        'data-live-search' => 'true', 'style' => 'width: 80%', 'multiple']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px">
                                <div class="i-checks">
                                    <input id="different_prices_for_stores" name="different_prices_for_stores" @if
                                        ($product->different_prices_for_stores) checked @endif type="checkbox" value="1"
                                    class="form-control-custom">
                                    <label
                                        for="different_prices_for_stores"><strong>@lang('lang.different_prices_for_stores')</strong></label>
                                </div>
                            </div>

                            <div class="col-md-12 different_prices_for_stores_div">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                @lang('lang.store')
                                            </th>
                                            <th>
                                                @lang('lang.price')
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product->product_stores as $product_store)
                                        @if (!empty($product_store->store))
                                        <tr>
                                            <td>{{ $product_store->store->name }}</td>
                                            <td><input type="text" class="form-control store_prices"
                                                    style="width: 200px;"
                                                    name="product_stores[{{ $product_store->store_id }}][price]"
                                                    value="{{ $product_store->price }}"></td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                            <div class="col-md-12" style="margin-top: 10px">
                                <div class="i-checks">
                                    <input id="this_product_have_variant" name="this_product_have_variant"
                                        type="checkbox" @if ($product->type == 'variable') checked @endif value="1"
                                    class="form-control-custom">
                                    <label
                                        for="this_product_have_variant"><strong>@lang('lang.this_product_have_variant')</strong></label>
                                </div>
                            </div>

                            <div class="col-md-12 this_product_have_variant_div">
                                <table class="table" id="variation_table">
                                    <thead>
                                        <tr>
                                            <th>@lang('lang.name')</th>
                                            <th>@lang('lang.sku')</th>
                                            <th>@lang('lang.color')</th>
                                            <th>@lang('lang.size')</th>
                                            <th>@lang('lang.grade')</th>
                                            <th>@lang('lang.unit')</th>
                                            <th>@lang('lang.number_vs_base_unit')</th>
                                            {{-- @if($product->is_service) hide @endif --}}
                                            <th
                                                class="purchase_price_th @if(isset($product->is_service) && $product->is_service == 0) hide @endif">
                                                @lang('lang.purchase_price')</th>
                                            <th
                                                class="sell_price_th @if(isset($product->is_service) && $product->is_service == 0) hide @endif">
                                                @lang('lang.sell_price')</th>
                                            <th><button type="button" class="btn btn-success btn-xs add_row mt-2"><i
                                                        class="dripicons-plus"></i></button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product->variations as $item)
                                        @include('product.partial.edit_variation_row', [
                                        'row_id' => $loop->index,
                                        'item' => $item,
                                        'is_service' => $product->is_service,
                                        ])
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" name="row_id" id="row_id" value="{{ $product->variations->count() }}">
                        </div>
                        <div id="cropped_edit_product_images"></div>
                        <div class="row">
                            <div class="col-md-4 mt-5">
                                <div class="form-group">
                                    <input type="button" id="submit-btn" value="{{ trans('lang.save') }}"
                                        class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <x-modal-header>

                <h5 class="modal-title" id="editProductModalLabel">Modal title</h5>

            </x-modal-header>

            <div class="modal-body">
                <div id="croppie-edit-product-modal" style="display:none">
                    <div id="croppie-edit-product-container"></div>
                    <button data-dismiss="modal" id="croppie-edit-product-cancel-btn" type="button"
                        class="btn btn-secondary"><i class="fas fa-times"></i></button>
                    <button id="croppie-edit-product-submit-btn" type="button" class="btn btn-primary"><i
                            class="fas fa-crop"></i></button>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/product_edit.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
            $('#different_prices_for_stores').change();
            $('#this_product_have_variant').change();
            getEditProductImages()
        })
        $(document).ready(function() {
            var storeOption =$('#selectStore').val();
            $.ajax({
                    url: '/get-printers',
                    type: 'GET',
                    data: { printer_store_id: storeOption },
                    success: function(response) {
                        // Handle the AJAX response
                        console.log('AJAX request successful');
                        console.log(response);
                        // Update the printers list in the container element
                        var printersContainer = $('#printersContainer');
                        printersContainer.empty(); // Clear previous printers

                        $.each(response, function(index, printer) {
                            var checkbox = $('<input>')
                                .attr('type', 'checkbox')
                                .attr('name', 'printers[]')
                                .val(printer.id);
                                // .prop('checked', isChecked);

                            var label = $('<label>')
                                .addClass('m-auto')
                                .attr('for', 'printer' + printer.id)
                                .text(printer.name);

                            var div = $('<div>').addClass('row').append(checkbox, label);
                            printersContainer.append(div);
                            // Check if the printer ID exists in $printers_p
                            if ($.inArray(printer.id, {!! json_encode($printers_p->pluck('printer_id')->toArray()) !!}) !== -1) {
                                checkbox.prop('checked', true);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors
                        console.log('AJAX request failed');
                        console.log(xhr.responseText);
                    }
                });         // Event listener for select change
            $('#selectStore').on('change', function() {
                // Get the selected option value
                var selectedOption = $(this).val();
                // var printers_p = {{$printers_p}};
                // Send AJAX request
                $.ajax({
                    url: '/get-printers',
                    type: 'GET',
                    data: { printer_store_id: selectedOption },
                    success: function(response) {
                        // Handle the AJAX response
                        console.log('AJAX request successful');
                        console.log(response);
                        // Update the printers list in the container element
                        var printersContainer = $('#printersContainer');
                        printersContainer.empty(); // Clear previous printers

                        $.each(response, function(index, printer) {
                            var checkbox = $('<input>')
                                .attr('type', 'checkbox')
                                .attr('name', 'printers[]')
                                .val(printer.id)
                                .prop('checked', isChecked);

                            var label = $('<label>')
                                .addClass('m-auto')
                                .attr('for', 'printer' + printer.id)
                                .text(printer.name);

                            var div = $('<div>').addClass('row').append(checkbox, label);
                            printersContainer.append(div);
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors
                        console.log('AJAX request failed');
                        console.log(xhr.responseText);
                    }
                });
            });
        });
</script>
<script>
    $("#submit-btn").on("click", function (e) {
            // getEditProductImages()
            e.preventDefault();
            setTimeout(() => {
                if ($("#product-edit-form").valid()) {
                    tinyMCE.triggerSave();
                    $.ajax({
                        type: "POST",
                        url: $("#product-edit-form").attr("action"),
                        data: $("#product-edit-form").serialize(),
                        success: function (response) {
                            if (response.success) {
                                swal("Success", response.msg, "success");
                                setTimeout(() => {
                                    window.close();
                                }, 1000);
                            }
                        },
                        error: function (response) {
                            if (!response.success) {
                                swal("Error", response.msg, "error");
                            }
                        },
                    });
                }
            });
        });
        @if($product)
        {{--document.getElementById("cropBtn{{ $product->id }}").addEventListener('click', () => {--}}
        {{--    setTimeout(() => {--}}
        {{--        launchEditProductCropTool(document.getElementById("img{{ $product->id }}"));--}}
        {{--    }, 500);--}}
        {{--});--}}
        document.getElementById("deleteBtn{{ $product->id }}").addEventListener('click', () => {
            Swal.fire({
                title: '{{ __("Are you sure?") }}',
                text: "{{ __("You will not be able to delete!") }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        '{{ __("Your Image has been deleted.") }}',
                        'success'
                    )
                    $("#preview{{ $product->id }}").remove();
                    $("input[name='cropImages[]']").remove();
                }
            });
        });

        @endif
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script>
    var fileEditProductInput = document.querySelector('#file-product-edit-product');
        var previewEditProductContainer = document.querySelector('.preview-edit-product-container');
        var croppieEditProductModal = document.querySelector('#croppie-edit-product-modal');
        var croppieEditProductContainer = document.querySelector('#croppie-edit-product-container');
        var croppieEditProductCancelBtn = document.querySelector('#croppie-edit-product-cancel-btn');
        var croppieEditProductSubmitBtn = document.querySelector('#croppie-edit-product-submit-btn');

        // let currentFiles = [];
        fileEditProductInput.addEventListener('change', () => {
            // let files = fileEditProductInput.files;
            previewEditProductContainer.innerHTML = '';
            let files = Array.from(fileEditProductInput.files)
            // files.concat(currentFiles)
            // currentFiles.push(...files)
            // currentFiles && (files = currentFiles)
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.addEventListener('load', () => {
                        const preview = document.createElement('div');
                        preview.classList.add('preview');
                        const img = document.createElement('img');
                        img.src = reader.result;
                        preview.appendChild(img);
                        const container = document.createElement('div');
                        const deleteBtn = document.createElement('span');
                        deleteBtn.classList.add('delete-btn');
                        deleteBtn.innerHTML = '<i style="font-size: 20px;" class="fas fa-trash"></i>';
                        deleteBtn.addEventListener('click', () => {
                            swal({
                                title: "Delete",
                                text: "Are you sure you want to delete this image ?",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                                buttons: ["Cancel", "Delete"],
                            }).then((addPO) => {
                                if (addPO) {
                                    files.splice(file, 1)
                                    preview.remove();
                                }
                            });
                        });

                        preview.appendChild(deleteBtn);
                        const cropBtn = document.createElement('span');
                        cropBtn.setAttribute("data-toggle", "modal")
                        cropBtn.setAttribute("data-target", "#editProductModal")
                        cropBtn.classList.add('crop-btn');
                        cropBtn.innerHTML = '<i style="font-size: 20px;" class="fas fa-crop"></i>';
                        cropBtn.addEventListener('click', () => {
                            setTimeout(() => {
                                launchEditProductCropTool(img);
                            }, 500);
                        });
                        preview.appendChild(cropBtn);
                        previewEditProductContainer.appendChild(preview);
                    });
                    reader.readAsDataURL(file);
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("site.Oops...") }}',
                        text: '{{ __("site.Sorry , You Should Upload Valid Image") }}',
                    })
                }
            }

            getEditProductImages()
        });
        function launchEditProductCropTool(img) {
            getEditProductImages();
            // Set up Croppie options
            const croppieOptions = {
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'square' // or 'square'
                },
                boundary: {
                    width: 300,
                    height: 300,
                },
                enableOrientation: true
            };

            // Create a new Croppie instance with the selected image and options
            const croppie = new Croppie(croppieEditProductContainer, croppieOptions);
            croppie.bind({
                url: img.src,
                orientation: 1,
            });

            // Show the Croppie modal
            croppieEditProductModal.style.display = 'block';

            // When the user clicks the "Cancel" button, hide the modal
            croppieEditProductCancelBtn.addEventListener('click', () => {
                croppieEditProductModal.style.display = 'none';
                $('#editProductModal').modal('hide');
                croppie.destroy();
            });

            // When the user clicks the "Crop" button, get the cropped image and replace the original image in the preview
            croppieEditProductSubmitBtn.addEventListener('click', () => {
                croppie.result({
                    type: 'canvas',
                    size: {
                        width: 800,
                        height: 600
                    },
                    quality: 1 // Set quality to 1 for maximum quality
                }).then((croppedImg) => {
                    img.src = croppedImg;
                    croppieEditProductModal.style.display = 'none';
                    $('#editProductModal').modal('hide');
                    croppie.destroy();
                    getEditProductImages()
                });
            });
        }
        function getEditProductImages() {
            setTimeout(() => {
                const container = document.querySelectorAll('.preview-edit-product-container');
                let images = [];
                $("#cropped_edit_product_images").empty();
                for (let i = 0; i < container[0].children.length; i++) {
                    var newInput = $("<input>").attr("type", "hidden").attr("name", "cropImages[]").val(container[0].children[i].children[0].src);
                    $("#cropped_edit_product_images").append(newInput);
                    images.push(container[0].children[i].children[0].src)
                }
                console.log(images)
                return images
            }, 300);
        }


</script>
@endsection
