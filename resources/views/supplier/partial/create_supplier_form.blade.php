<div class="row row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">


    <div class="col-md-4 px-5">
        <div class="form-group">
            {!! Form::label('supplier_category_id', __('lang.category') ,[
            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
            ]) !!}
            <div class="input-group my-group">
                {!! Form::select('supplier_category_id', $supplier_categories, false, ['class' => 'selectpicker
                form-control', 'data-live-search' => 'true', 'style' => 'width: 80%', 'placeholder' =>
                __('lang.please_select'), 'id' => 'supplier_category_id']) !!}
                @if (!$quick_add)
                <span class="input-group-btn">
                    @can('product_module.product_class.create_and_edit')
                    <button class="btn-modal btn btn-default bg-white btn-flat"
                        data-href="{{ action('SupplierCategoryController@create') }}?quick_add=1"
                        data-container=".view_modal"><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
                    @endcan
                </span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4 px-5">
        <div class="form-group">
            <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                {!! Form::label('name', __('lang.representative_name')
                ,[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                ]) !!}
                <span class="text-danger">*</span>
            </div>
            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => __('lang.name'),
            'required']) !!}
        </div>
    </div>
    <div class="col-md-4 px-5">
        <div class="form-group">
            {!! Form::label('products', __('lang.products'),[
            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
            ]) !!}
            {!! Form::select('products[]', $products, old('products'), ['class' => 'selectpicker form-control',
            'data-live-search' => 'true', 'data-actions-box' => 'true', 'id' => 'products', 'multiple']) !!}
        </div>
    </div>
    <div class="col-md-4 px-5">
        <div class="form-group">
            {!! Form::label('photo', __('lang.photo'),[
            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
            ]) !!}
            {!! Form::file('image', ['class']) !!}
        </div>
    </div>
    <div class="col-md-4 px-5">
        <div class="form-group">
            {!! Form::label('company_name', __('lang.company_name') ,[
            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
            ]) !!}
            {!! Form::text('company_name', old('company_name'), ['class' => 'form-control', 'placeholder' =>
            __('lang.company_name')]) !!}
        </div>
    </div>
    <div class="col-md-4 px-5">
        <div class="form-group">
            {!! Form::label('vat_number', __('lang.vat_number') ,[
            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
            ]) !!}
            {!! Form::text('vat_number', old('vat_number'), ['class' => 'form-control', 'placeholder' =>
            __('lang.vat_number')]) !!}
        </div>
    </div>
    <div class="col-md-4 px-5">
        <div class="form-group">
            {!! Form::label('email', __('lang.email') ,[
            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
            ]) !!}
            {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => __('lang.email')]) !!}
        </div>
    </div>
    <div class="col-md-4 px-5">
        <div class="form-group">
            {!! Form::label('mobile_number', __('lang.mobile_number') ,[
            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
            ]) !!}
            {!! Form::text('mobile_number', old('mobile_number'), ['class' => 'form-control', 'placeholder' =>
            __('lang.mobile_number')]) !!}
        </div>
    </div>
    <div class="col-md-4 px-5">
        <div class="form-group">
            {!! Form::label('address', __('lang.address') ,[
            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
            ]) !!}
            {!! Form::text('address', old('address'), ['class' => 'form-control', 'placeholder' => __('lang.balance')])
            !!}
        </div>
    </div>
    <div class="col-md-4 px-5">
        <div class="form-group">
            {!! Form::label('city', __('lang.city') ,[
            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
            ]) !!}
            {!! Form::text('city', old('city'), ['class' => 'form-control', 'placeholder' => __('lang.balance')]) !!}
        </div>
    </div>
    <div class="col-md-4 px-5">
        <div class="form-group">
            {!! Form::label('state', __('lang.state') ,[
            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
            ]) !!}
            {!! Form::text('state', old('state'), ['class' => 'form-control', 'placeholder' => __('lang.balance')]) !!}
        </div>
    </div>
    <div class="col-md-4 px-5">
        <div class="form-group">
            {!! Form::label('postal_code', __('lang.postal_code') ,[
            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
            ]) !!}
            {!! Form::text('postal_code', old('postal_code'), ['class' => 'form-control', 'placeholder' =>
            __('lang.balance')]) !!}
        </div>
    </div>
    <div class="col-md-4 px-5">
        <div class="form-group">
            {!! Form::label('country ', __('lang.country') ,[
            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
            ]) !!}
            {!! Form::text('country', old('country'), ['class' => 'form-control', 'placeholder' => __('lang.country')])
            !!}
        </div>
    </div>
</div>
<input type="hidden" name="quick_add" value="{{ $quick_add }}">
