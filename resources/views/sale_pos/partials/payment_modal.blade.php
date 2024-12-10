<!-- payment modal -->
<div id="add-payment" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog" style="max-width: 90%!important">
        <div class="modal-content">
            <x-modal-header>

                <h5 id="exampleModalLabel" class="modal-title">@lang('lang.finalize_sale')</h5>

            </x-modal-header>

            <div class="modal-body py-1">

                <div class="row">

                    <div class="col-md-12 customer_name_div hide">
                        <label for="" style="font-weight: bold">@lang('lang.customer'): <span
                                class="customer_name"></span></label>
                    </div>

                    <div class="col-md-10">
                        <div class="row">
                            {{-- <input type="text" value="" class="isPayComplete" /> --}}
                            <div id="payment_rows" class="payment_rows col-md-12">
                                <div class="payment_row row pl-3  pr-3">
                                    <div class="col-md-2 mt-1">
                                        <label>@lang('lang.received_amount'): *</label>
                                        <input type="text" name="payments[0][amount]"
                                            class="form-control numkey received_amount" required id="amount" step="any">
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2 mt-1">
                                        <label>@lang('lang.paying_amount'): *</label>
                                        <input type="text" name="payments[0][paying_amount]"
                                            class="form-control paying_amount numkey" id="paying_amount" step="any">
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4 mt-1 text-red d-flex justify-content-center align-items-end"
                                        style="gap: 25px">
                                        <div>

                                            <label class="discount_lable">@lang('lang.discount'):</label>
                                            <span class="payment_modal_discount_text" style="font-weight: bold"></span>
                                        </div>
                                        <div>

                                            <label class="surplus_lable">@lang('lang.surplus'):</label>
                                            <span class="payment_modal_surplus_text" style="font-weight: bold"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-1">
                                        <label class="change_text">@lang('lang.change'): </label>
                                        <spand class="change" class="ml-2">0.00</spand>
                                        <input type="hidden" name="payments[0][change_amount]" class="change_amount"
                                            id="change_amount">
                                        <input type="hidden" name="payments[0][pending_amount]" class="pending_amount">
                                        <input type="hidden" name="payments[0][pending_amount]" class="pending_amount">
                                        <div class="col-md-6">
                                            <button type="button"
                                                class="ml-1 btn btn-danger add_to_customer_balance hide">@lang('lang.add_to_customer_balance')</button>
                                            <input type="hidden" name="add_to_customer_balance"
                                                id="add_to_customer_balance" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-1">
                                        <label>@lang('lang.payment_method'): *</label>
                                        {!! Form::select('payments[0][method]', $payment_types, null, ['class' =>
                                        'form-control method payment_way', 'required']) !!}
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-4 mt-1 d-flex align-items-end">
                                        @php
                                        $show_the_window_printing_prompt =
                                        App\Models\System::getProperty('show_the_window_printing_prompt');
                                        @endphp

                                        <div class="col-md-6">
                                            <div class="i-checks toggle-pill-color d-flex flex-column justify-content-end align-items-center"
                                                style="gap: 10px">
                                                <input @if (!empty($show_the_window_printing_prompt) &&
                                                    $show_the_window_printing_prompt=='1' ) checked @endif
                                                    id="print_the_transaction" name="print_the_transaction"
                                                    type="checkbox" checked class="form-control-custom">
                                                <label for="print_the_transaction">
                                                </label>
                                                <span>
                                                    <strong>@lang('lang.print_the_transaction')</strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2 p-0 btn-add-payment">
                                            <button type="button" id="add_payment_row"
                                                class="btn btn-primary btn-block">
                                                @lang('lang.add_payment_row')</button>
                                        </div>

                                    </div>
                                    <div class="form-group mb-0 col-md-12 hide card_field">
                                        <div class="row">
                                            <div class="col-md-4 mb-0">
                                                <label>@lang('lang.card_number') *</label>
                                                <input type="text" name="payments[0][card_number]" class="form-control">
                                            </div>
                                            {{-- <div class="col-md-3">
                                                <label>@lang('lang.card_security')</label>
                                                <input type="text" name="payments[0][card_security]"
                                                    class="form-control">
                                            </div> --}}
                                            <div class="col-md-2 mb-0">
                                                <label>@lang('lang.month')</label>
                                                <input type="text" name="payments[0][card_month]" class="form-control">
                                            </div>
                                            <div class="col-md-2 mb-0">
                                                <label>@lang('lang.year')</label>
                                                <input type="text" name="payments[0][card_year]" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12 bank_field hide">
                                        <label>@lang('lang.bank_name')</label>
                                        <input type="text" name="payments[0][bank_name]" class="form-control">
                                    </div>
                                    <div class="form-group col-md-12 card_bank_field hide">
                                        <label>@lang('lang.ref_number') </label>
                                        <input type="text" name="payments[0][ref_number]" class="form-control">
                                    </div>
                                    <div class="form-group col-md-12 cheque_field hide">
                                        <label>@lang('lang.cheque_number')</label>
                                        <input type="text" name="payments[0][cheque_number]" class="form-control">
                                    </div>
                                </div>
                                <hr>
                            </div>

                            <div class="col-md-6 deposit-fields hide">
                                <h6 class="bg-success" style="color: #fff; padding: 10px 15px;">
                                    @lang('lang.current_balance'): <span class="current_deposit_balance"></span> <br>
                                    <span class="hide balance_error_msg"
                                        style="color: red; font-size: 12px">@lang('lang.customer_not_have_sufficient_balance')</span>
                                </h6>
                                <input type="hidden" name="current_deposit_balance" id="current_deposit_balance"
                                    value="0">
                            </div>
                            <div class="col-md-12 deposit-fields hide">
                                <div class="row">
                                    <div class="col-md-2">
                                        <button type="button"
                                            class="ml-1 btn btn-success use_it_deposit_balance">@lang('lang.use_it')</button>
                                        <input type="hidden" name="used_deposit_balance" id="used_deposit_balance"
                                            value="0">
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="bg-success" style="color: #fff; padding: 10px 15px;">
                                            @lang('lang.remaining_balance'): <span
                                                class="remaining_balance_text"></span> </h6>
                                        <input type="hidden" name="remaining_deposit_balance"
                                            id="remaining_deposit_balance" value="0">
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button"
                                            class="ml-1 btn btn-danger add_to_deposit">@lang('lang.add_to_deposit')</button>
                                        <input type="hidden" name="add_to_deposit" id="add_to_deposit" value="0">
                                    </div>


                                    <div class="col-md-12 mb-2 ">
                                        <button type="button" id="add_payment_row" class="btn btn-primary btn-block">
                                            @lang('lang.add_payment_row')</button>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group col-md-12 gift_card_field hide">
                                <div class="col-md-12">
                                    <label>@lang('lang.gift_card_number') *</label>
                                    <input type="text" name="gift_card_number" id="gift_card_number"
                                        class="form-control" placeholder="@lang('lang.enter_gift_card_number')">
                                    <span class="gift_card_error" style="color: red;"></span>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label><b>@lang('lang.current_balance'):</b> </label><br>
                                        <span class="gift_card_current_balance"></span>
                                        <input type="hidden" name="gift_card_current_balance"
                                            id="gift_card_current_balance">
                                    </div>
                                    <div class="col-md-4">
                                        <label>@lang('lang.enter_amount_to_be_used') </label>
                                        <input type="text" name="amount_to_be_used" id="amount_to_be_used"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label>@lang('lang.remaining_balance') </label>
                                        <input type="text" name="remaining_balance" id="remaining_balance"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label><b>@lang('lang.final_total'):</b> </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="gift_card_final_total" id="gift_card_final_total"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label>@lang('lang.sale_note')</label>
                                <textarea rows="3" class="form-control" name="sale_note"
                                    id="sale_note">{{ !empty($transaction) ? $transaction->sale_note : '' }}</textarea>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>@lang('lang.staff_note')</label>
                                <textarea rows="3" class="form-control"
                                    name="staff_note">{{ !empty($transaction) ? $transaction->staff_note : '' }}</textarea>
                            </div>
                            <div class="form-group col-md-3">
                                <label>@lang('lang.payment_note')</label>
                                <textarea id="payment_note" rows="3" class="form-control"
                                    name="payment_note"></textarea>
                            </div>
                            <div class="col-md-3 payment_fields">
                                <input type="hidden" name="uploaded_file_names" id="uploaded_file_names" value="">
                                <div class="form-group">
                                    {!! Form::label('upload_documents', __('lang.upload_documents') . ':', []) !!} <br>
                                    <input type="file" name="upload_documents[]" id="upload_documents" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex justify-content-start align-items-end flex-column">
                        <h4><strong>@lang('lang.quick_cash')</strong></h4>
                        <div class="col-md-8 qc" data-initial="1">
                            <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="10"
                                type="button">10</button>
                            <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="20"
                                type="button">20</button>
                            <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="50"
                                type="button">50</button>
                            <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="100"
                                type="button">100</button>
                            <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="500"
                                type="button">500</button>
                            <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="1000"
                                type="button">1000</button>
                            <button class="btn btn-block btn-danger qc-btn sound-btn" data-amount="0"
                                type="button">@lang('lang.clear')</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <button id="submit-btn" type="button" class="btn btn-primary col-12">@lang('lang.submit')</button>

            </div>
        </div>
    </div>
</div>
