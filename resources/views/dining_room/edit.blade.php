<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('DiningRoomController@update', $dining_room->id), 'method' => 'put', 'files' =>
        true]) !!}
        <x-modal-header>


            <h4 class="modal-title">@lang( 'lang.edit' )</h4>
        </x-modal-header>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', __('lang.name') . ':*') !!}
                {!! Form::text('name', $dining_room->name, ['class' => 'form-control', 'placeholder' => __('lang.name'),
                'required', 'id' => 'dining_room_name']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('store_id', __( 'lang.store' ). ':') !!}
                {!! Form::select('store_id', $stores, $dining_room->store_id, ['class' => 'form-control', 'placeholder'
                => __('lang.please_select'), 'data-live-search' => 'true']) !!}
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-6">@lang( 'lang.save' )</button>
            <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang( 'lang.close' )</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>

</script>
