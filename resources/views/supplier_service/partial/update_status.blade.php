<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('SupplierServiceController@postUpdateStatus', $transaction->id), 'method' =>
        'post', 'id' => 'update_status_form']) !!}

        <x-modal-header>

            <h4 class="modal-title">@lang( 'lang.update_status' )</h4>

        </x-modal-header>



        <div class="modal-body">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('status', __('lang.status') . ':*', []) !!}
                    {!! Form::select('status', ['canceld' => __('lang.cancel')], 'canceled', ['class' => 'selectpicker
                    form-control', 'data-live-search' => 'true', 'required', 'style' => 'width: 80%']) !!}
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-6" id="update-status">@lang( 'lang.update' )</button>
            <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang( 'lang.close' )</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    $('.selectpicker').selectpicker()
</script>
