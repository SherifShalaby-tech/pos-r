<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('PaymentMethodController@store'), 'method' => 'post' ]) !!}



        <div class="modal-header">

            <h4 class="modal-title">@lang( 'lang.add_payment_method' )</h4>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>


        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <div class="col-md-12 px-4">
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

            <div class="col-md-12 d-flex justify-content-center align-items-center">

                <div class="i-checks">
                    <input id="is_active" name="is_active" type="checkbox" checked class="form-control-custom">
                    <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif" for="is_active">
                        <strong>@lang( 'lang.is_active' )</strong></label>

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