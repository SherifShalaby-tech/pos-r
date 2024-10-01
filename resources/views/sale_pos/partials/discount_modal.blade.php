<!-- order_discount modal -->
<div id="discount_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <x-modal-header>


                <h5 class="modal-title">@lang('lang.random_discount')</h5>
            </x-modal-header>

            <div class="modal-body p-0 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="form-group col-md-6">
                    {!! Form::label('discount_type', __( 'lang.type' ) . '*',[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                    ]) !!}
                    {!! Form::select('discount_type', ['fixed' => 'Fixed', 'percentage' => 'Percentage'],
                    !empty($transaction) ? $transaction->discount_type : 'fixed',
                    ['class' =>
                    'form-control', 'data-live-search' => 'true']) !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('discount_value', __( 'lang.discount_value' ) . '*',[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                    ]) !!}
                    {!! Form::text('discount_value', !empty($transaction) ? @num_format($transaction->discount_value) :
                    null, ['class' => 'form-control', 'placeholder' => __(
                    'lang.discount_value' ),
                    'required' ])
                    !!}
                </div>
                <input type="hidden" name="discount_amount" id="discount_amount">
            </div>
            <div class="modal-footer">
                <button type="button" name="discount_btn" id="discount_btn" class="btn btn-primary col-12"
                    data-dismiss="modal">@lang('lang.submit')</button>
            </div>
        </div>
    </div>
</div>