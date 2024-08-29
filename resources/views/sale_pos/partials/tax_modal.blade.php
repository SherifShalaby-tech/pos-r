<!-- order_tax modal -->
<div id="tax_modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <x-modal-header>

                <h5 class="modal-title">@lang('lang.tax')</h5>

            </x-modal-header>

            <div class="modal-body">
                <div class="form-group">
                    <select class="form-control" name="tax_id" id="tax_id">
                        <option value="">No Tax</option>
                        @foreach ($taxes as $tax)
                        <option data-rate="{{$tax->rate}}" @if(!empty($transaction) && $transaction->tax_id == $tax->id)
                            selected @endif value="{{$tax->id}}">{{$tax->name}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="tax_id_hidden" id="tax_id_hidden" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" name="tax_btn" id="tax_btn" class="btn btn-primary col-12"
                        data-dismiss="modal">@lang('lang.submit')</button>
                </div>
            </div>
        </div>
    </div>
</div>
