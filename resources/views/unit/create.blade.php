<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('UnitController@store'), 'method' => 'post', 'id' => $quick_add ?
        'quick_add_unit_form' : 'unit_add_form' ]) !!}
        <x-modal-header>

            <h4 class="modal-title">@lang( 'lang.add_unit' )</h4>

        </x-modal-header>


        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">


            <input type="hidden" name="is_raw_material_unit"
                value="@if(!empty($is_raw_material_unit)){{1}}@else{{0}}@endif">
            <input type="hidden" name="quick_add" value="{{$quick_add }}">


            <div class="col-md-4">

                <div class="form-group">
                    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('name', __( 'lang.name' ) ,[
                        'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                        ]) !!}
                        <span class="text-danger">*</span>
                    </div>
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __( 'lang.name' ),
                    'required'
                    ])
                    !!}
                </div>
            </div>



            @if(session('system_mode') != 'garments')
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('base_unit_multiplier', __( 'lang.times_of' ),[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    {!! Form::text('base_unit_multiplier', null, ['class' => 'form-control', 'placeholder' => __(
                    'lang.times_of' ) ])
                    !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('base_unit_id', __( 'lang.base_unit' ),[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    {!! Form::select('base_unit_id', $units, false, ['class' => 'form-control selectpicker',
                    'placeholder'
                    => __('lang.select_base_unit'), 'data-live-search' => 'true']) !!}
                </div>
            </div>
            @endif

            {{-- @if(!empty($is_raw_material_unit)) --}}
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('info', __( 'lang.info' ) ,[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __(
                    'lang.info'
                    ),
                    'rows' => 3 ])
                    !!}
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary   col-6  ">@lang( 'lang.save' )</button>
            <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang( 'lang.close' )</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
    $('.selectpicker').selectpicker('render');
</script>
