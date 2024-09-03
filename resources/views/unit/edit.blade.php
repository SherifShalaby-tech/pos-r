<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('UnitController@update', $unit->id), 'method' => 'put', 'id' => 'unit_add_form'
        ]) !!}
        <x-modal-header>

            <h4 class="modal-title">@lang( 'lang.edit' )</h4>

        </x-modal-header>

        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('name', __( 'lang.name' ),[
                        'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                        ]) !!}
                        <span class="text-danger">*</span>
                    </div>
                    {!! Form::text('name', $unit->name, ['class' => 'form-control', 'placeholder' => __( 'lang.name' ),
                    'required' ])
                    !!}
                </div>
            </div>
            {{-- @if(!empty($unit->is_raw_material_unit)) --}}
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('info', __( 'lang.info' ),[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    {!! Form::textarea('description', $unit->description, ['class' => 'form-control', 'placeholder' =>
                    __(
                    'lang.info' ),
                    'rows' => 3 ])
                    !!}
                </div>
            </div>
            @if(session('system_mode') != 'garments')
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('base_unit_multiplier', __( 'lang.times_of' ),[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    {!! Form::text('base_unit_multiplier', @num_format($unit->base_unit_multiplier), ['class' =>
                    'form-control',
                    'placeholder' => __(
                    'lang.times_of' ) ])
                    !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('base_unit_id', __( 'lang.base_unit' ),[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    {!! Form::select('base_unit_id', $units, $unit->base_unit_id, ['class' => 'form-control
                    selectpicker',
                    'placeholder'
                    => __('lang.select_base_unit'), 'data-live-search' => 'true']) !!}
                </div>
            </div>
            @endif

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary col-6">@lang( 'lang.save' )</button>
                <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang( 'lang.close' )</button>
            </div>

            {!! Form::close() !!}

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    <script>
        $('.selectpicker').selectpicker('render');
    </script>
