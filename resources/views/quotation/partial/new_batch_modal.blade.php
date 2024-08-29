<div class="modal fade" id="addNewBatch" tabindex="-1" role="dialog" aria-labelledby="addNewBatch" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <x-modal-header>


            </x-modal-header>

            <div class="modal-body">
                <table class="table table-striped" id="product_batch_table">
                    <thead>
                        <tr>
                            <th style="width: 7%" class="col-sm-8">@lang( 'lang.image' )</th>
                            <th style="width: 10%" class="col-sm-8">@lang( 'lang.products' )</th>
                            <th style="width: 20%" class="col-sm-4">@lang( 'lang.sku' )</th>
                            <th style="width: 20%" class="col-sm-4">@lang( 'lang.quantity' )</th>
                            <th style="width: 20%" class="col-sm-4">@lang( 'lang.purchase_price' )</th>
                            <th style="width: 20%" class="col-sm-4">@lang( 'lang.selling_price' )</th>
                            <th style="width: 10%" class="col-sm-4">@lang( 'lang.sub_total' )</th>
                            <th style="width: 10%" class="col-sm-4">@lang( 'lang.new_stock' )</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default col-6" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary col-6 addProductBatchBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>
