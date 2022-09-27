@forelse ($extensions as $extension)
    @if($extension->extension)
        <tr class="product_row">

            <td style="width: @if(session('system_mode')  != 'restaurant') 18%; @else 20%; @endif font-size: 13px;">
                <input type="checkbox" name="extensions_checkboxs[{{$loop->index}}]"  value="{{$extension->extension_id}}">
                <b>{{$extension->extension->name}}</b>

                @if($loop->index == 0)
                    <input type="hidden" name="extension_product_id" id="extension_product_id"
                           value="{{$product_id}}">
                    <input type="hidden" name="extension_variation_id" id="extension_variation_id"
                           value="{{$variation_id}}">
                    <input type="hidden" name="extension_edit_quantity" id="extension_edit_quantity"
                           value="{{$edit_quantity}}">
                    <input type="hidden" name="extension_weighing_scale_barcode"
                           id="extension_weighing_scale_barcode" value="{{$weighing_scale_barcode}}">

                    <input type="hidden" name="extension_row_count"
                           id="extension_row_count" value="{{$row_count}}">

                @endif

            </td>
            <td style="width: @if(session('system_mode')  != 'restaurant') 18% @else 20% @endif">
                <div class="input-group"><span class="input-group-btn">
                        <button type="button" class="btn btn-danger btn-xs minus">
                            <span class="dripicons-minus"></span>
                        </button>
                    </span>
                    <input type="number"
                           class="form-control quantity  qty numkey input-number minus extensions_quantity" min="0.01" step="any"
                        autocomplete="off" style="width: 50px;"
{{--                           onchange="change_value_extensions_price(this)"--}}
                        name="extensions_quantity[{{$extension->extension_id}}]"

                        required id-row="{{$extension->extension_id}}"
                        value="@if(!empty($edit_quantity)){{$edit_quantity}}@else{{1}}@endif">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-success btn-xs plus">
                            <span class="dripicons-plus"></span>
                        </button>
                    </span>
                </div>

            </td>
            <td style="width: @if(session('system_mode')  != 'restaurant') 16% @else 15% @endif">
                <input type="text" class="form-control sell_price"
                       id="extensions_sell_price_{{$extension->extension_id}}"
                    name="extensions_sell_price[{{$extension->extension_id}}]" required id-row="{{$extension->extension_id}}"
                    @if(!auth()->user()->can('product_module.sell_price.create_and_edit')) readonly @endif
                value="@if(isset($extension->sell_price)){{@num_format($extension->sell_price / $exchange_rate)}}@else{{0}}@endif">
            <input type="hidden" name="extensions_sell_price_per_one_{{$extension->extension_id}}" id="extensions_sell_price_per_one_{{$extension->extension_id}}" value="{{@num_format($extension->sell_price / $exchange_rate)}}" >
            </td>
        </tr>
    @endif
@empty

@endforelse
