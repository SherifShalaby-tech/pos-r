<div class="modal" id="product_extension" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <x-modal-header>

                <h5 class="modal-title">@lang('lang.product_extension')</h5>

            </x-modal-header>

            <div class="modal-body">
                <table>
                    <thead>
                        <tr>
                            <td>@lang('lang.product_extension')</td>
                            <td>@lang('lang.qty')</td>
                            <td>@lang('lang.sell_price')</td>
                        </tr>
                    </thead>
                    <tbody id="product_extension_tbody">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="save_btn_product_extension"
                    class="btn btn-primary col-6">@lang('lang.save')</button>
                <button type="button" class="btn btn-default col-6 close_btn_product_extension"
                    data-dismiss="modal">@lang('lang.cancel')</button>
            </div>
        </div>
    </div>
</div>