<div class="row">
    <div class="col-md-6">
        {!! Form::label('material_id', __('lang.raw_material'), []) !!}
        <div class="input-group my-group">
            {!! Form::select('material_id', $raw_materials,  false, ['class' => 'select_material_id selectpicker form-control', 'data-live-search' => 'true', 'style' => 'width: 80%', 'placeholder' => __('lang.please_select'), 'id' => 'material_id']) !!}
            <span class="input-group-btn">
                    @can('raw_material_module.raw_material.create_and_edit')
                    <button class="btn-modal btn btn-default bg-white btn-flat"
                            data-href="{{ action('RawMaterialController@create') }}?quick_add=1" data-container=".view_modal"><i
                            class="fa fa-plus-circle text-primary fa-lg"></i></button>
                @endcan
                </span>
        </div>
    </div>
    <div class="col-md-4 row">
        <div class="col-7">
            <div class="form-group">
                {!! Form::label('quantity_product', __('lang.quantity'), []) !!}
                {!! Form::number('quantity_product', 3,
                ['class' => 'form-control', 'placeholder' =>
                __('lang.quantity_product')]) !!}
            </div>
        </div>
        <div class="col-5">
            <label for="" class="unit_label" id="label_unit_id_material" style="text-align: center; margin-top: 40%;"> </label>
            <input type="text" class="hide" id="unit_id_material" value="" name="unit_id_material" >
        </div>

    </div>
    <div class="col-md-4">
        <div class="i-checks">
            <input id="automatic_consumption" name="automatic_consumption" type="checkbox" value="1"
                   class="form-control-custom">
            <label for="automatic_consumption"><strong>@lang('lang.automatic_consumption')</strong></label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="i-checks">
            <input id="price_based_on_raw_material" name="price_based_on_raw_material" type="checkbox"
                      value="1" class="form-control-custom">
            <label for="price_based_on_raw_material"><strong>@lang('lang.price_based_on_raw_material')</strong></label>
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
                <th style="width: 10%;"><button class="btn btn-xs btn-success add_raw_material_row"
                                                type="button"><i class="fa fa-plus"></i></button></th>
            </tr>
            </thead>
            <tbody>
            @include('product.partial.raw_material_row', ['row_id' => 0])
            </tbody>
        </table>
        <input type="hidden" name="raw_material_row_index" id="raw_material_row_index" value="1">
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('other_cost', __('lang.other_cost'), []) !!}
            {!! Form::text('other_cost', !empty($recent_product) ? @num_format($recent_product->other_cost) : null, ['class' => 'form-control', 'placeholder' => __('lang.other_cost')]) !!}
        </div>
    </div>
    @can('product_module.purchase_price.create_and_edit')
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('purchase_price', __('lang.cost') . ' *', []) !!}
                {!! Form::text('purchase_price', null, ['class' => 'form-control', 'placeholder' => session('system_mode') == 'pos' || session('system_mode') == 'garments' || session('system_mode') == 'supermarket' ? __('lang.purchase_price') : __('lang.cost'), 'required']) !!}
            </div>
        </div>
    @endcan
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('name', __('lang.name') . ' * (max 25 characters)', []) !!}
            <div class="input-group my-group">
                {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('lang.name')]) !!}
                <span class="input-group-btn">
                    <button class="btn btn-default bg-white btn-flat translation_btn" type="button"
                            data-type="product"><i class="dripicons-web text-primary fa-lg"></i></button>
                </span>
            </div>
        </div>
        @include('layouts.partials.translation_inputs', [
            'attribute' => 'name',
            'translations' => [],
            'type' => 'product',
        ])
    </div>

</div>
