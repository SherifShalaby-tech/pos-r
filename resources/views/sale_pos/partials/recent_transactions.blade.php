<div class="table-responsive" style="position: relative;
    overflow: auto;
    max-height: 85vh;">
    <h3 class="print-title-hint" style="display:none;">recent_transactions</h3>
    <table id="recent_transaction_table" class="table">
        <thead style="position: sticky; top: 0; background: #555;
    color: white; z-index: 1;">
            <tr>
                <th>@lang('lang.date_and_time')</th>
                <th>@lang('lang.invoice_no')</th>
                <th class="currencies">@lang('lang.received_currency')</th>
                <th class="sum">@lang('lang.value')</th>
                <th>@lang('lang.customer_type')</th>
                <th>@lang('lang.customer_name')</th>
                <th>@lang('lang.phone')</th>
                <th>@lang('lang.status')</th>
                <th>@lang('lang.payment_status')</th>
                <th>@lang('lang.delivery_man')</th>
                <th>@lang('lang.cashier')</th>
                <th>@lang('lang.canceled_by')</th>
                <th class="notexport">@lang('lang.action')</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <th class="table_totals " style="text-align: right">@lang('lang.totals')</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
