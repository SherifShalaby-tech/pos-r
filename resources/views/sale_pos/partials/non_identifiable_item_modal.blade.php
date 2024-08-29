<div class="modal fade" tabindex="-1" role="dialog" id="non_identifiable_item_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <x-modal-header>
                <h5 class="modal-title">@lang('lang.non_identifiable_item')</h5>


            </x-modal-header>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('nonid_name', __('lang.name') . ':' ) !!}
                            {!! Form::text('nonid_name', null, ['class' => 'form-control', 'id' =>
                            'nonid_name']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('nonid_purchase_price', __('lang.purchase_price') . ':' ) !!}
                            {!! Form::text('nonid_purchase_price', null, ['class' => 'form-control', 'id' =>
                            'nonid_purchase_price', 'required']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('nonid_sell_price', __('lang.sell_price') . ':' ) !!}
                            {!! Form::text('nonid_sell_price', null, ['class' => 'form-control', 'id' =>
                            'nonid_sell_price',
                            'required'])
                            !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('nonid_quantity', __('lang.quantity') . ':' ) !!}
                            {!! Form::text('nonid_quantity', null, ['class' => 'form-control', 'id' => 'nonid_quantity',
                            'required'])
                            !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary col-6"
                    id="non_identifiable_submit">@lang('lang.submit')</button>
                <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang('lang.close')</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
