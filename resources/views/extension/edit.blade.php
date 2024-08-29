<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('ExtensionController@update', $extension->id), 'method' => 'put', 'id' =>
        'extension_add_form'
        ]) !!}
        <x-modal-header>


            <h4 class="modal-title">@lang( 'lang.edit' )</h4>
        </x-modal-header>


        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('product_id', __( 'lang.product_for_extension' ). ':') !!}
                        {!! Form::select('product_id', $products, $extension->product_id, ['class' => 'form-control
                        selectpicker', 'placeholder'
                        => __('lang.product_for_extension'), 'data-live-search' => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('used_amount', __('lang.used_amount') . ' *', []) !!}
                        {!! Form::text('quantity_use', @num_format($extension->quantity_use) , ['class' =>
                        'form-control', 'placeholder' => __('lang.sell_default_price'), false]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('sell_default_price', __('lang.sell_default_price') . ' *', []) !!}
                        {!! Form::text('sell_default_price', @num_format($extension->sell_default_price) , ['class' =>
                        'form-control', 'placeholder' => __('lang.sell_default_price'), 'required']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('name', __('lang.name') . ' * (max 25 characters)', []) !!}
                        <div class="input-group my-group">
                            {!! Form::text('name', $extension->name, ['class' => 'form-control', 'required',
                            'placeholder' => __('lang.name')]) !!}
                            <span class="input-group-btn">
                                <button class="btn btn-default bg-white btn-flat translation_btn" type="button"
                                    data-type="product"><i class="dripicons-web text-primary fa-lg"></i></button>
                            </span>
                        </div>
                    </div>
                    @include('layouts.partials.translation_inputs', [
                    'attribute' => 'name',
                    'translations' => $extension->translations,
                    'type' => 'product',
                    ])
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-6">@lang( 'lang.save' )</button>
            <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang( 'lang.close' )</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    $('.selectpicker').selectpicker('render');
</script>
