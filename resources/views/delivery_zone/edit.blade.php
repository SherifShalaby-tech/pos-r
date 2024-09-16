<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('DeliveryZoneController@update', $delivery_zone->id), 'method' => 'put', 'id' =>
        'delivery_zone_add_form']) !!}
        <x-modal-header>

            <h4 class="modal-title">@lang( 'lang.edit' )</h4>

        </x-modal-header>


        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="form-group col-md-6 px-5">
                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('name', __('lang.name') ,[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    <span class="text-danger">*</span>
                </div>
                {!! Form::text('name', $delivery_zone->name, ['class' => 'form-control', 'placeholder' =>
                __('lang.name'), 'required']) !!}
            </div>
            <div class="form-group col-md-6 px-5">

                {!! Form::label('coverage_area', __('lang.coverage_area'),[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                ]) !!}
                {!! Form::text('coverage_area', $delivery_zone->coverage_area, ['class' => 'form-control', 'placeholder'
                => __('lang.coverage_area')]) !!}
            </div>
            <div class="form-group col-md-6 px-5">
                {!! Form::label('deliveryman_id', __('lang.deliveryman'),[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                ]) !!}
                {!! Form::select('deliveryman_id', $deliverymen, $delivery_zone->deliveryman_id, ['class' =>
                'form-control selectpicker', 'data-live-search' => 'true', 'placeholder' => __('lang.please_select')])
                !!}
            </div>
            <div class="form-group col-md-6 px-5">
                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('cost', __('lang.cost') ,[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    <span class="text-danger">*</span>
                </div>
                {!! Form::text('cost', @num_format($delivery_zone->cost), ['class' => 'form-control', 'placeholder' =>
                __('lang.cost'), 'required']) !!}
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
    $('.selectpicker').selectpicker('refresh');
</script>
