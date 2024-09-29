<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('ManufacturerController@store'), 'method' => 'post', 'id' => $quick_add ?
        'quick_add_manufacturer_form' : 'manufacturer_add_form', 'files' => true]) !!}
        <x-modal-header>


            <h4 class="modal-title">@lang( 'lang.add_manufacturer' )</h4>
        </x-modal-header>

        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="form-group col-md-6">
                {!! Form::label('name', __('lang.name') . '*',[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                ]) !!}
                <div class="input-group my-group">
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('lang.name'),
                    'required']) !!}
                    <span class="input-group-btn">
                        <button class="btn  btn-primary btn-partial btn-flat translation_btn" type="button"
                            data-type="manufacturer"><i class="dripicons-web text-white fa-lg"></i></button>
                    </span>
                </div>
            </div>
            @include('layouts.partials.translation_inputs', [
            'attribute' => 'name',
            'translations' => [],
            'type' => 'manufacturer',
            ])
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-6">@lang( 'lang.save' )</button>
            <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang( 'lang.close' )</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    $('#cat_product_class_id').selectpicker('render');
    $('#parent_id').selectpicker('render');

    @if ($type == 'manufacturer')
        $('.view_modal').on('shown.bs.modal', function () {
        $("#cat_product_class_id").selectpicker("val", $('#product_class_id').val());
        })
    @endif

</script>
