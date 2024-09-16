<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('TaxController@update', $tax->id), 'method' => 'put', 'id' => 'tax_add_form'])
        !!}
        <x-modal-header>
            <h4 class="modal-title">@lang('lang.edit')</h4>
        </x-modal-header>


        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="form-group col-md-6 px-5">
                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('name', __('lang.name') . '*') !!}
                    <span class="text-danger">*</span>
                </div>
                {!! Form::text('name', $tax->name, ['class' => 'form-control', 'placeholder' => __('lang.name'),
                'required']) !!}
            </div>
            <div class="form-group col-md-6 px-5">
                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('rate', __('lang.rate_percentage') . '*') !!}
                    <span class="text-danger">*</span>
                </div>
                {!! Form::text('rate', $tax->rate, ['class' => 'form-control', 'placeholder' => __('lang.rate'),
                'required']) !!}
            </div>
            <input type="hidden" name="type" value="{{ $tax->type }}">
            @if ($tax->type == 'general_tax')
            <div class="form-group col-md-6 px-5">
                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('tax_method', __('lang.tax_method') . '*') !!}
                    <span class="text-danger">*</span>
                </div>
                {!! Form::select('tax_method', ['inclusive' => __('lang.inclusive'), 'exclusive' =>
                __('lang.exclusive')], $tax->tax_method, ['class' => 'selectpicker form-control',
                'data-live-search' =>
                'true', 'placeholder' => __('lang.please_select')]) !!}
            </div>

            <div class="form-group col-md-6 px-5">
                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('store_ids', __('lang.stores') ) !!} <i class="dripicons-question"
                        data-toggle="tooltip" title="@lang('lang.tax_status_info')"></i>
                </div>
                {!! Form::select('store_ids[]', $stores, $tax->store_ids ?? [], ['class' => 'selectpicker
                form-control',
                'data-live-search' => 'true', 'data-actions-box' => 'true', 'multiple']) !!}
            </div>
            <div class="col-md-3 px-5">
                <div class="i-checks toggle-pill-color">
                    <input id="status" name="status" type="checkbox" value="1" @if ($tax->status) checked
                    @endif
                    class="form-control-custom">
                    <label for="status">

                    </label>
                    <span>
                        <strong>
                            @lang('lang.active')
                        </strong>
                    </span>
                </div>
            </div>
            @endif
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-6">@lang('lang.update')</button>
            <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang('lang.close')</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    $('.selectpicker').selectpicker('refresh');
</script>
