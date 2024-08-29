<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('TutorialCategoryController@store'), 'method' => 'post', 'id'
        =>'tutorial_add_form',
        'files' => true ]) !!}

        <x-modal-header>

            <h4 class="modal-title">@lang( 'lang.add_content' )</h4>

        </x-modal-header>


        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', __( 'lang.name' ) . ':*') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __( 'lang.name' ), 'required'
                ])
                !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', __( 'lang.description' )) !!}
                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __(
                'lang.description' )
                ])
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

<script>

</script>
