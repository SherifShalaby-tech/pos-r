<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('SizeController@update', $size->id), 'method' => 'put', 'id' => 'size_add_form'
        ]) !!}
        <x-modal-header>

            <h4 class="modal-title">@lang( 'lang.edit' )</h4>

        </x-modal-header>


        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="col-md-6 px-4">
                <div class="form-group">
                    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('name', __( 'lang.name' ) ,[
                        'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                        ]) !!}
                        <span class="text-danger">*</span>
                    </div>
                    {!! Form::text('name', $size->name, ['class' => 'form-control', 'placeholder' => __( 'lang.name' ),
                    'required' ])
                    !!}
                </div>
            </div>
            <div class="col-md-6 px-4">
                <div class="form-group">
                    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('size_code', __( 'lang.size_code' ) ,[
                        'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                        ]) !!}
                        <span class="text-danger">*</span>
                    </div>
                    {!! Form::text('size_code', $size->size_code, ['class' => 'form-control', 'placeholder' => __(
                    'lang.size_code' )])
                    !!}
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-6 ">@lang( 'lang.save' )</button>
            <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang( 'lang.close' )</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
