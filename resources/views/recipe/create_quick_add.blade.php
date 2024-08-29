<div class="modal-dialog" role="document">
    <div class="modal-content">
        {!! Form::open(['url' => action('RecipeController@store'), 'id' => 'product-form', 'method'
        =>
        'POST', 'class' => '', 'enctype' => 'multipart/form-data']) !!}


        <x-modal-header>

            <h4 class="modal-title">@lang( 'lang.add_new_recipe' )</h4>

        </x-modal-header>
        <div class="modal-body">
            @include('recipe.partial.create_form')
            <input type="hidden" name="active" value="1">
            <div class="row">
                <div class="col-md-4 mt-5">
                    <div class="form-group">
                        <input type="button" value="{{trans('lang.submit')}}" id="submit-btn" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}


    </div>
</div>
<script>
    $(".selectpicker").selectpicker("refresh");
    $(".raw_material_unit_id").selectpicker("refresh");

</script>
