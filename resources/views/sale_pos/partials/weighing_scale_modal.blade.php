<div class="modal fade" tabindex="-1" role="dialog" id="weighing_scale_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <x-modal-header>

                <h5 class="modal-title">@lang('lang.weighing_scale')</h5>

            </x-modal-header>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('weighing_scale_barcode', __('lang.weighing_scale_barcode') . ':' ) !!}
                            {!! Form::text('weighing_scale_barcode', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary col-6"
                    id="weighing_scale_submit">@lang('lang.submit')</button>
                <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang('lang.close')</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
