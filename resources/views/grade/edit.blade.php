<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('GradeController@update', $grade->id), 'method' => 'put', 'id'
        =>'grade_add_form' ]) !!}

        <x-modal-header>

            <h4 class="modal-title">@lang( 'lang.edit' )</h4>

        </x-modal-header>

        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="form-group col-md-6">
                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('name', __( 'lang.name' ) ) !!}
                    <span class="text-danger">*</span>
                </div>
                {!! Form::text('name', $grade->name, ['class' => 'form-control', 'placeholder' => __( 'lang.name' ),
                'required' ])
                !!}
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-6">@lang( 'lang.save' )</button>
            <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang( 'lang.close' )</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
