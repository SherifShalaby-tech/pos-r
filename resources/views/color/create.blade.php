<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('ColorController@store'), 'method' => 'post', 'id' => $quick_add ?
        'quick_add_color_form' : 'color_add_form' ]) !!}

        <x-modal-header>

            <h4 class="modal-title">@lang( 'lang.add_color' )</h4>
        </x-modal-header>


        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <div class="col-md-6 px-4">
                <div class="form-group">
                    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('name', __( 'lang.name' ) . '*',[
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
            <input type="hidden" name="quick_add" value="{{$quick_add }}">
            <div class="col-md-6 px-4">
                <div class="form-group">
                    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('color_hex', __( 'lang.color_hex' ) . '*',[
                        'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                        ]) !!}
                        <span class="text-danger">*</span>
                    </div>
                    {!! Form::text('color_hex', null, ['class' => 'form-control', 'placeholder' => __( 'lang.color_hex'
                    )
                    ])
                    !!}
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-6">@lang( 'lang.save' )</button>
            <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang( 'lang.close' )</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
