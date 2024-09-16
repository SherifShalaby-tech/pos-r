<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('StorePosController@update', $store_pos->id), 'method' => 'put', 'id' =>
        'store_pos_edit_form' ]) !!}
        <x-modal-header>

            <h4 class="modal-title">@lang( 'lang.edit_pos_for_store' )</h4>
        </x-modal-header>


        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="form-group col-md-4">
                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                    {!! Form::label('store_id', __('lang.store'), ['class' => app()->isLocale('ar') ? 'mb-1
                    label-ar' :
                    'mb-1 label-en'
                    ]) !!}
                    <span class="text-danger">*</span>
                </div>
                {!! Form::select('store_id', $stores,
                $store_pos->store_id, ['class' => 'selectpicker form-control',
                'data-live-search'=>"true", 'required',
                'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
            </div>
            <div class="form-group col-md-4">
                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('name', __( 'lang.name' ),[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    <span class="text-danger">*</span>
                </div>
                {!! Form::text('name', $store_pos->name, ['class' => 'form-control', 'placeholder' => __( 'lang.name' ),
                'required'
                ])
                !!}
            </div>
            <div class="form-group col-md-4">
                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('user_id', __('lang.user'), ['class' => app()->isLocale('ar') ? 'mb-1 label-ar'
                    :
                    'mb-1 label-en'
                    ]) !!}
                    <span class="text-danger">*</span>
                </div>
                {!! Form::select('user_id', $users,
                $store_pos->user_id, ['class' => 'selectpicker form-control',
                'data-live-search'=>"true", 'required',
                'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
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
