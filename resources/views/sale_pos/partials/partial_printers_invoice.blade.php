<style>
    @media print {
        * {
            font-size: 12px;
            line-height: 20px;
            font-family: 'Times New Roman';
        }

        td,
        th {
            padding: 5px 0;
        }

        .hidden-print {
            display: none !important;
        }

        @page {
            margin: 0;
        }

        body {
            margin: 0.5cm;
            margin-bottom: 1.6cm;
        }

        .page {
            position: absolute;
            top: 0;
            right: 0;
        }

        #header_invoice_img {
            max-width: 80mm;
        }
    }

    #receipt_section * {
        font-size: 14px;
        line-height: 24px;
        font-family: 'Ubuntu', sans-serif;
        text-transform: capitalize;
        color: black !important;
    }

    #receipt_section .btn {
        padding: 7px 10px;
        text-decoration: none;
        border: none;
        display: block;
        text-align: center;
        margin: 7px;
        cursor: pointer;
    }

    #receipt_section .btn-info {
        background-color: #999;
        color: #FFF;
    }

    #receipt_section .btn-primary {
        background-color: #6449e7;
        color: #FFF;
        width: 100%;
    }

    #receipt_section td,
    #receipt_section th,
    #receipt_section tr,
    #receipt_section table {
        border-collapse: collapse;
    }

    #receipt_section tr {
        border-bottom: 1px dotted #ddd;
    }

    #receipt_section td,
    #receipt_section th {
        padding: 7px 0;
        width: 50%;
    }

    #receipt_section table {
        width: 100%;
    }

    #receipt_section tfoot tr th:first-child {
        text-align: left;
    }

    .centered {
        text-align: center;
        align-content: center;
    }

    small {
        font-size: 11px;
    }
    tr.tr-extension{
        font-size: 9px !important;
        line-height: 15px !important;
        color: black !important;
        border-bottom: none !important;

    }
    tr.tr-extension td{
        font-size: 9px !important;
    }
    tr.no-border{
        border-bottom: none !important;
    }
    tr.border-top{
        border-top: 1px dotted #ddd;
    }
</style>
@php
if (empty($invoice_lang)) {
    $invoice_lang = request()
        ->session()
        ->get('language');
}
$is_first_after_extra=0;

@endphp
<div style="max-width:200px;margin:0 auto; padding: 0px 15px; color: black !important;">

    <div id="receipt-data">
        {{-- <div class="centered">
            @include('layouts.partials.print_header')

            <p>{{ $transaction->store->name }}
                {{ $transaction->store->location }}</p>
            @if($transaction->status=="draft")
                <p
                    data-href="#"
                    class="btn btn-modal" style="position: absolute; top: 1px;">{{ __('lang.draft', [], $invoice_lang)}}
                    </p>
            @endif
            <p>{{ $transaction->store->phone_number }} </p>

        </div> --}}
        <div style="width: 70%; float:left;">
            <p>@lang('lang.date', [], $invoice_lang): {{ $transaction->transaction_date }}<br>
                @lang('lang.reference', [], $invoice_lang): {{ $transaction->invoice_no }}<br>
                {{-- @if (!empty($transaction->customer) && $transaction->customer->is_default == 0)
                    {{ $transaction->customer->name }} <br>
                    {{ $transaction->customer->address }} <br>
                    {{ $transaction->customer->mobile_number }} <br>
                @endif --}}
                @if (!empty($transaction->sale_note))
                    @lang('lang.sale_note', [], $invoice_lang): {{ $transaction->sale_note }} <br>
                @endif
            </p>
            @if (session('system_mode') == 'restaurant')
                @if (!empty($transaction->dining_room))
                    @lang('lang.dining_room'):
                    {{ $transaction->dining_room->name }} <br>
                @endif
                @if (!empty($transaction->dining_table))
                    @lang('lang.dining_table'):
                    {{ $transaction->dining_table->name }} <br>
                @endif
            @endif
            {{-- @if (!empty($transaction->deliveryman))
                <p>{{ $transaction->deliveryman->employee_name }}</p>
            @endif --}}
            {{-- @if (!empty($transaction->delivery_address))
                @lang('lang.delivery_address'):
                {{ $transaction->delivery_address }} <br>
            @endif --}}
        </div>
        @if (session('system_mode') == 'restaurant')
            <div style="width: 20%; float:right; text-align:center;">
                <p
                    style="width: 30px; height:30px; border: 4px solid #111; border-radius: 50%; padding: 20px; font-size: 23px; font-weight: bold;">
                    {{ $transaction->ticket_number }}</p>
            </div>
        @endif
        <div class="table_div" style=" padding: 0 7px; width:100%; height:100%;">
            <table style="margin: 0 auto; text-align: center !important">
                <thead>
                    <tr>
                        <th style="width: 30%; padding: 0 50px !important;">@lang('lang.item', [], $invoice_lang) </th>
                        {{-- @if (empty($print_gift_invoice))
                            <th style="width: 20%; text-align:center !important;"> @lang('lang.price', [], $invoice_lang)
                            </th>
                        @endif --}}
                        <th style="width: 20%; text-algin: center;">@lang('lang.qty', [], $invoice_lang) </th>
                        {{-- @if (empty($print_gift_invoice))
                            <th style="width: 30%; text-algin: center;">@lang('lang.amount', [], $invoice_lang) </th>
                        @endif --}}
                    </tr>
                </thead>
                <tbody>

                    @foreach ($transactionSellLines as $line)
                        <tr  class=" @if($line->sell_line_extensions->count() > 0 )no-border @endif {{$is_first_after_extra == 1 ?'border-top':''}}">
                            @php
                                $is_first_after_extra=0;
                            @endphp
                            <td style="width: 30%; text-algin: right !important;">
                                @if (!empty($line->variation))
                                    @if ($line->variation->name != 'Default')
                                        {{ $line->variation->name }}
                                    @else
                                        {{ $line->product->translated_name($line->product->id, $invoice_lang) }}
                                    @endif
                                @endif

                            </td>
                            {{-- @if (empty($print_gift_invoice))
                                <td style="text-align:center !important;vertical-align:bottom; width: 20%;">
                                    {{ @num_format($line->sell_price) }}</td>
                            @endif --}}
                            <td style="text-align:center;vertical-align:bottom; width: 20%;">
                                {{ preg_match('/\.\d*[1-9]+/', (string)$line->quantity) ? $line->quantity : @num_format($line->quantity) }}</td>
                            {{-- @if (empty($print_gift_invoice))
                                <td style="text-align:center;vertical-align:bottom; width: 30%;">
                                    @if ($line->product_discount_type != 'surplus')
                                        {{ @num_format($line->sub_total + $line->product_discount_amount) }}
                                    @else
                                        {{ @num_format($line->sub_total) }}
                                    @endif
                                </td>
                            @endif --}}
                        </tr>
                        @if($line->sell_line_extensions)
                            @foreach( $line->sell_line_extensions as $k => $line_extension)

                                @php
                                    $qur_index = ($k + 1) % 3;
                                    $name=$line_extension->extension->name;
                                    $translations = !empty($line_extension->extension->translations['name']) ? $line_extension->extension->translations['name'] : [];
                                    if (!empty($translations)) {
                                        if (!empty($translations[$invoice_lang])) {
                                            $name= $translations[$invoice_lang];
                                        }
                                    }
                                    $is_first_after_extra=1;
                                @endphp
                                @if($qur_index == 1 || $k = 0 )
                                    <tr class="tr-extension">
                                @endif
                                <td>{{(int)$line_extension->quantity.' -'.$name}}</td>
                                @if( $qur_index == 0 )
                                    </tr>
                                @elseif($loop->last )
                                    @if($loop->last && $qur_index == 1 )
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @else
                                            <td></td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
                {{-- @if (empty($print_gift_invoice))
                    <tfoot>
                        <tr>
                            <th style="font-size: 16px;" colspan="3">@lang('lang.total', [], $invoice_lang)</th>
                            <th style="font-size: 16px; text-align:right;">
                                {{ @num_format($transaction->grand_total + $transaction->transaction_sell_lines->where('product_discount_type', '!=', 'surplus')->sum('product_discount_amount')) }}
                                {{ $transaction->received_currency->symbol }}
                            </th>
                        </tr>
                        @if ($transaction->transaction_sell_lines->where('product_discount_type', '!=', 'surplus')->sum('product_discount_amount') > 0)
                            <tr>
                                <th style="font-size: 16px;" colspan="3">@lang('lang.discount', [], $invoice_lang)</th>
                                <th style="font-size: 16px; text-align:right;">
                                    {{ @num_format($transaction->transaction_sell_lines->where('product_discount_type', '!=', 'surplus')->sum('product_discount_amount')) }}
                                    {{ $transaction->received_currency->symbol }}
                                </th>
                            </tr>
                        @endif
                        @if ($transaction->total_item_tax != 0)
                            <tr>
                                <th style="font-size: 16px;" colspan="3">@lang('lang.tax', [], $invoice_lang)</th>
                                <th style="font-size: 16px; text-align:right;">
                                    {{ @num_format($transaction->total_item_tax) }}
                                    {{ $transaction->received_currency->symbol }}
                                </th>
                            </tr>
                        @endif
                        @if ($transaction->total_tax != 0)
                            <tr>
                                <th style="font-size: 16px;" colspan="3">{{ $transaction->tax->name ?? '' }}</th>
                                <th style="font-size: 16px; text-align:right;">
                                    {{ @num_format($transaction->total_tax) }}
                                    {{ $transaction->received_currency->symbol }}</th>
                            </tr>
                        @endif
                        @if ($transaction->service_fee_value > 0)
                            <tr>
                                <th style="font-size: 16px;" colspan="3">@lang('lang.service')</th>
                                <th style="font-size: 16px; text-align:right;">
                                    {{ @num_format($transaction->service_fee_value) }}
                                    {{ $transaction->received_currency->symbol }}</th>
                            </tr>
                        @endif
                        @if ($transaction->discount_amount != 0)
                            <tr>
                                <th style="font-size: 16px;" colspan="3">@lang('lang.order_discount', [], $invoice_lang)
                                </th>
                                <th style="font-size: 16px; text-align:right;">
                                    {{ @num_format($transaction->discount_amount) }}
                                    {{ $transaction->received_currency->symbol }}
                                </th>
                            </tr>
                        @endif
                        @if ($transaction->total_sp_discount != 0)
                            <tr>
                                <th style="font-size: 16px;" colspan="3">@lang('lang.sales_promotion', [], $invoice_lang)</th>
                                <th style="font-size: 16px; text-align:right;">
                                    {{ @num_format($transaction->total_sp_discount) }}
                                    {{ $transaction->received_currency->symbol }}
                                </th>
                            </tr>
                        @endif
                        @if ($transaction->transaction_sell_lines->sum('coupon_discount'))
                            <tr>
                                <th style="font-size: 16px;" colspan="3">@lang('lang.coupon_discount', [], $invoice_lang)</th>
                                <th style="font-size: 16px; text-align:right;">
                                    {{ @num_format($transaction->transaction_sell_lines->sum('coupon_discount')) }}
                                </th>
                            </tr>
                        @endif
                        @if (!empty($transaction->delivery_cost) && $transaction->delivery_cost != 0)
                            <tr>
                                <th style="font-size: 16px;" colspan="3">@lang('lang.delivery_cost', [], $invoice_lang)
                                    @if (!empty($transaction->deliveryman->employee_name))
                                        ({{ $transaction->deliveryman->employee_name }})
                                    @endif
                                </th>
                                <th style="font-size: 16px; text-align:right;">
                                    {{ @num_format($transaction->delivery_cost) }}
                                    {{ $transaction->received_currency->symbol }}
                                </th>
                            </tr>
                        @endif
                        @if (!empty($transaction->rp_redeemed_value))
                            <tr>
                                <th style="font-size: 16px;" colspan="3">@lang('lang.redeemed_point_value', [], $invoice_lang)
                                </th>
                                <th style="font-size: 16px; text-align:right;">
                                    {{ @num_format($transaction->rp_redeemed_value) }}
                                </th>
                            </tr>
                        @endif
                        <tr>
                            <th style="font-size: 16px;" colspan="3">@lang('lang.grand_total', [], $invoice_lang)</th>
                            <th style="font-size: 16px; text-align:right;">
                                @if ($transaction->delivery_cost_given_to_deliveryman)
                                    {{ @num_format($transaction->final_total + $transaction->delivery_cost) }}
                                @else
                                    {{ @num_format($transaction->final_total) }}
                                @endif
                                {{ $transaction->received_currency->symbol }}
                            </th>
                        </tr>
                        <tr>

                        </tr>
                    </tfoot>
                @endif --}}
            </table>
        </div>
        {{-- <div style="">
            <table style="margin: 0 auto; ">
                <tbody>
                    @if (empty($print_gift_invoice))
                        @if (!$transaction->delivery_cost_given_to_deliveryman)
                            @foreach ($transaction->transaction_payments as $payment_data)
                                @if ($payment_data->method != 'deposit')
                                    <tr style="background-color:#ddd;">
                                        <td style="font-size: 16px; padding: 7px;">
                                            @if (!empty($payment_data->method))
                                                {{ __('lang.' . $payment_data->method, [], $invoice_lang) }}
                                            @endif
                                        </td>
                                        <td style="font-size: 16px; padding: 10px; text-align: right;" colspan="2">
                                            {{ @num_format($payment_data->amount + $payment_data->change_amount) }}
                                            {{ $transaction->received_currency->symbol }}</td>
                                    </tr>
                                @endif
                                @if (!empty($payment_data->change_amount) && $payment_data->change_amount > 0 && $payment_data->method != 'deposit')
                                    <tr>
                                        <td style="font-size: 16px; padding: 7px;width:30%">@lang('lang.change', [], $invoice_lang)</td>
                                        <td colspan="2"
                                            style="font-size: 16px; padding: 7px;width:40%; text-align: right;">
                                            {{ @num_format($payment_data->change_amount) }}
                                            {{ $transaction->received_currency->symbol }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                        @if (!empty($transaction->add_to_deposit) && $transaction->add_to_deposit > 0)
                            <tr>
                                <td style="font-size: 16px; padding: 7px;width:30%">@lang('lang.deposit', [], $invoice_lang)
                                </td>
                                <td colspan="2" style="font-size: 16px; padding: 7px;width:40%; text-align: right;">
                                    {{ @num_format($transaction->add_to_deposit) }}</td>
                            </tr>
                        @endif
                        @if (!empty($transaction->used_deposit_balance) && $transaction->used_deposit_balance > 0)
                            <tr>
                                <td style="font-size: 16px; padding: 7px;width:30%">@lang('lang.used_deposit_balance', [], $invoice_lang)</td>
                                <td colspan="2" style="font-size: 16px; padding: 7px;width:40%; text-align: right;">
                                    {{ @num_format($transaction->used_deposit_balance) }}</td>
                            </tr>
                        @endif
                        @if ($transaction->is_quotation != 1)
                            @if ($transaction->payment_status != 'paid' && $transaction->final_total - $transaction->transaction_payments->sum('amount') > 0)
                                <tr>
                                    <td style="font-size: 16px; padding: 5px;width:30%">@lang('lang.due_sale_list', [], $invoice_lang)</td>
                                    <td colspan="2" style="font-size: 16px; padding: 5px;width:40%; text-align: right;">
                                        {{ @num_format($transaction->final_total - $transaction->transaction_payments->sum('amount')) }}
                                        {{ $transaction->received_currency->symbol }}
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endif <!-- end of print gift invoice -->
                    <tr>
                        <td class="centered" colspan="3">
                            @if (session('system_mode') == 'restaurant')
                                @lang('lang.enjoy_your_meal_please_come_again', [], $invoice_lang)
                            @else
                                @lang('lang.thank_you_and_come_again', [], $invoice_lang)
                            @endif
                        </td>
                    </tr>
                    @if (!empty($transaction->terms_and_conditions))
                        <tr>
                            <td>{!! $transaction->terms_and_conditions->description !!}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="centered" colspan="3">
                            <img style="margin-top:10px;"
                                src="data:image/png;base64,{{ DNS1D::getBarcodePNG($transaction->invoice_no, 'C128') }}"
                                width="300" alt="barcode" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @include('layouts.partials.print_footer')
        <div style="width: 100%; text-align: center;">
            <p><span class="">Proudly Developed at <a style="text-decoration: none;" target="_blank"
                        href="http://sherifshalaby.tech">sherifshalaby.tech</a></span></p>
        </div> --}}
    </div>
</div>
