@forelse ($products as $product)
<tr class="product_row">
    @if(!empty($is_direct_sale))
    <td class="row_number"></td>
    @endif
    <td style="width: @if(session('system_mode')  != 'restaurant') 18%; @else 20%; @endif font-size: 13px;">
        @php
         $Variation=\App\Models\Variation::where('id',$product->variation_id)->first();
            if($Variation){
                $stockLines=\App\Models\AddStockLine::where('variation_id',$Variation->id)->whereColumn('quantity',">",'quantity_sold')->first();
                $default_sell_price=$stockLines?$stockLines->sell_price : $Variation->default_sell_price;
                $default_purchase_price=$stockLines?$stockLines->purchase_price : $Variation->default_purchase_price;

            }

        @endphp
        @if($product->variation_name != "Default")
            <b>{{$product->variation_name}}</b> {{$product->sub_sku}}
        @else
            <b>{{$product->product_name}}</b>
        @endif
        <p class="m-0">
            @php
                $ex='id'.$product->variation_id;
            @endphp
            @foreach($extensions as $extension)
                {{'('.$extension['extensions_quantity'].'-'.$extension['name']. ') '}}
                @php
                    $ex.='q'.$extension['extensions_quantity'].'e'.$extension['extensions_id'];
                @endphp
            @endforeach
            <input type="hidden" id="{{$ex}}" name="old_ex" value="1">
        </p>



        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][is_service]" class="is_service"
            value="{{$product->is_service}}">
        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][product_id]" class="product_id"
            value="{{$product->product_id}}">
        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][variation_id]" class="variation_id"
            value="{{$product->variation_id}}">
        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][price_hidden]" class="price_hidden"
            value="@if(isset($default_sell_price)){{@num_format(($default_sell_price+$sum_extensions_sell_prices) / $exchange_rate)}}@else{{0}}@endif">
        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][purchase_price]" class="purchase_price"
            value="@if(isset($default_purchase_price)){{@num_format($default_purchase_price / $exchange_rate)}}@else{{0}}@endif">
        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][tax_id]" class="tax_id"
            value="{{$product->tax_id}}">
        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][tax_method]" class="tax_method"
            value="{{$product->tax_method}}">
        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][tax_rate]" class="tax_rate"
            value="{{@num_format($product->tax_rate)}}">
        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][item_tax]" class="item_tax"
            value="0">
        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][coupon_discount]"
            class="coupon_discount_value" value="0"> <!-- value is percentage or fixed value from coupon data -->
        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][coupon_discount_type]"
            class="coupon_discount_type" value=""> <!-- value is percentage or fixed value from coupon data -->
        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][coupon_discount_amount]"
            class="coupon_discount_amount" value="0">
        <!-- after calculation actual discounted amount for row product row -->
        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][promotion_purchase_condition]"
            class="promotion_purchase_condition"
            value="@if(!empty($sale_promotion_details)){{$sale_promotion_details->purchase_condition}}@else{{0}}@endif">
        <input type="hidden"
            name="transaction_sell_line[{{$loop->index + $index}}][promotion_purchase_condition_amount]"
            class="promotion_purchase_condition_amount"
            value="@if(!empty($sale_promotion_details)){{$sale_promotion_details->purchase_condition_amount}}@else{{0}}@endif">
        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][promotion_discount]"
            class="promotion_discount_value"
            value="@if(!empty($sale_promotion_details)){{$sale_promotion_details->discount_value}}@else{{0}}@endif">
        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][promotion_discount_type]"
            class="promotion_discount_type"
            value="@if(!empty($sale_promotion_details)){{$sale_promotion_details->discount_type}}@else{{0}}@endif">
        <input type="hidden" name="transaction_sell_line[{{$loop->index + $index}}][promotion_discount_amount]"
            class="promotion_discount_amount" value="0">
           @php $loop_index= $loop->index + $index@endphp
        @isset($extensions_ids)
            @foreach($extensions_ids as $extensions_id_for_row)

                    <input type="hidden"
                           name="transaction_sell_line[{{$loop_index}}][extensions_ids][]"
                           value="{{$extensions_id_for_row}}">
            @endforeach
        @endisset
        @isset($extensions_quantity)
            @foreach($extensions_quantity as $extensions_quantity_for_row)
                <input type="hidden" name="transaction_sell_line[{{$loop_index}}][extensions_quantity][]"
                        value="{{$extensions_quantity_for_row}}">
            @endforeach
        @endisset
        @isset($extensions_sell_prices)
            @foreach($extensions_sell_prices as $extensions_sell_price_for_row)
                <input type="hidden" name="transaction_sell_line[{{$loop_index}}][extensions_sell_prices][]"
                       value="{{$extensions_sell_price_for_row}}">
            @endforeach
        @endisset

    </td>
    <td style="width: @if(session('system_mode')  != 'restaurant') 18% @else 20% @endif">
        <div class="input-group"><span class="input-group-btn">
                <button type="button" class="btn btn-danger btn-xs minus">
                    <span class="dripicons-minus"></span>
                </button>
            </span>
            <input type="number" class="form-control quantity  qty numkey input-number" min="0.01" step="any"
                autocomplete="off" style="width: 50px;"
                @if(!$product->is_service)max="{{$product->qty_available}}"@endif
            name="transaction_sell_line[{{$loop->index + $index}}][quantity]"
            required
            value="@if(!empty($edit_quantity)){{$edit_quantity}}@else
            @if(isset($product->quantity)){{$product->quantity}}@else{{1}}@endif @endif">
            <span class="input-group-btn">
                <button type="button" class="btn btn-success btn-xs plus">
                    <span class="dripicons-plus"></span>
                </button>
            </span>
        </div>

    </td>
    <td style="width: @if(session('system_mode')  != 'restaurant') 16% @else 15% @endif">
        <input type="text" class="form-control sell_price"
            name="transaction_sell_line[{{$loop->index + $index}}][sell_price]" required
            @if(!auth()->user()->can('product_module.sell_price.create_and_edit')) readonly @elseif(env('IS_SUB_BRANCH',false)) readonly @endif
        value="@if(isset($default_sell_price)){{@num_format(($default_sell_price+$sum_extensions_sell_prices) / $exchange_rate)}}@else{{0}}@endif">
    </td>
    <td style="width: @if(session('system_mode')  != 'restaurant') 13% @else 15% @endif">
        <input type="hidden" class="form-control product_discount_type"
            name="transaction_sell_line[{{$loop->index + $index}}][product_discount_type]"
            value="@if(!empty($product_discount_details->discount_type)){{$product_discount_details->discount_type}}@else{{0}}@endif">
        <input type="hidden" class="form-control product_discount_value"
            name="transaction_sell_line[{{$loop->index + $index}}][product_discount_value]"
            value="@if(!empty($product_discount_details->discount)){{@num_format($product_discount_details->discount)}}@else{{0}}@endif">
        <div class="input-group">
            <button type="button" class="btn btn-lg" id="search_button"><span class="plus_sign_text"></span></button>
            <input type="text" class="form-control product_discount_amount"
                name="transaction_sell_line[{{$loop->index + $index}}][product_discount_amount]" readonly
                value="@if(!empty($product_discount_details->discount)){{@num_format($product_discount_details->discount)}}@else{{0}}@endif">
        </div>
    </td>
    <td style="width: @if(session('system_mode')  != 'restaurant') 10% @else 15% @endif">
        <span class="sub_total_span" style="font-weight: bold;"></span>
        <input type="hidden" class="form-control sub_total"
            name="transaction_sell_line[{{$loop->index + $index}}][sub_total]" value="">
    </td>
    @if(session('system_mode') != 'restaurant')
    <td style="width: @if(session('system_mode')  != 'restaurant') 10% @else 15% @endif">
        @if($product->is_service) {{'-'}} @else
        @if(isset($product->qty_available)){{@num_format($product->qty_available)}}@else{{0}}@endif @endif
    </td>
    @endif
    <td style="width: @if(session('system_mode')  != 'restaurant') 10%; @else 15%; @endif padding: 0px;">
        @if(!empty($dining_table_id))
            @if(auth()->user()->can('superadmin') || auth()->user()->is_admin == 1)
            <button type="button" class="btn btn-danger btn-xs remove_row" style="margin-top: 15px;"><i class="fa fa-times"></i></button>
            @endif
        @else
        <button type="button" class="btn btn-danger btn-xs remove_row" style="margin-top: 15px;"><i class="fa fa-times"></i></button>
        @endif
        @if(session('system_mode') != 'restaurant')
        <button type="button" class="btn btn-danger btn-xs quick_add_purchase_order"  style="margin-top: 15px;"
            title="@lang('lang.add_draft_purchase_order')"
            data-href="{{action('PurchaseOrderController@quickAddDraft')}}?variation_id={{$product->variation_id}}&product_id={{$product->product_id}}"><i
                class="fa fa-plus"></i> @lang('lang.po')</button>
        @endif
    </td>
</tr>
@empty

@endforelse
