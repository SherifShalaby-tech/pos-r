<tr>
    <td>

        @if(!empty(!empty($extension_product)))
        <input type="hidden" name="extension_details[{{$row_id}}][id]" value="{{$extension_product->id}}">
        @endif
        <div class="input-group my-group">
            {!! Form::select('extension_details['.$row_id.'][extension_id]', $extensions,
            !empty($extension_product) ? $extension_product->extension_id : false,
            ['class' => 'selectpicker
            form-control
            extension_id', 'data-live-search'=>"true", 'placeholder' => __('lang.please_select')]) !!}
            <span class="input-group-btn">
                @can('product_module.extension.create_and_edit')
                <button class="btn-modal btn-partial btn-primary btn btn-flat "
                    data-href="{{ action('ExtensionController@create') }}?quick_add=1&type=product_tax"
                    data-container=".view_modal"><i class="fa fa-plus-circle text-white fa-lg"></i></button>
                @endcan
            </span>
        </div>
    </td>
    <td>
        {!! Form::text('extension_details['.$row_id.'][sell_price]', !empty($extension_product) ?
        @num_format($extension_product->sell_price) : 0,
        ['class' => 'form-control sell_price raw_extension_price']) !!}
    </td>

    <td>
        <button type="button" class="btn btn-danger remove_row remove_raw_material_btn" style="border-radius: 50%!important;width: 35px;
    height: 35px;">
            <i class="fa fa-times"></i>
        </button>
    </td>
</tr>
