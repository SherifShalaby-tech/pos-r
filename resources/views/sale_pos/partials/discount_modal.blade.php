<!-- order_discount modal -->
<div id="discount_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <x-modal-header>


                <h5 class="modal-title">@lang('lang.random_discount')</h5>
            </x-modal-header>

            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('discount_type', __( 'lang.type' ) . ':*') !!}
                    {!! Form::select('discount_type', ['fixed' => 'Fixed', 'percentage' => 'Percentage'],
                    !empty($transaction) ? $transaction->discount_type : 'fixed',
                    ['class' =>
                    'form-control', 'data-live-search' => 'true']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('discount_value', __( 'lang.discount_value' ) . ':*') !!}
                    {!! Form::text('discount_value', !empty($transaction) ? @num_format($transaction->discount_value) :
                    null, ['class' => 'form-control', 'placeholder' => __(
                    'lang.discount_value' ),
                    'required' ])
                    !!}
                </div>
                <input type="hidden" name="discount_amount" id="discount_amount">
                <div class="modal-footer">
                    <button type="button" name="discount_btn" id="discount_btn" class="btn btn-primary col-12"
                        data-dismiss="modal">@lang('lang.submit')</button>
                </div>
            </div>
        </div>
    </div>
</div>
