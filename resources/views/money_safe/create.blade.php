<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('MoneySafeController@store'), 'method' => 'post', 'id' =>
        'money_safe_add_form'],[
        'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

        ]) !!}
        <x-modal-header>

            <h4 class="modal-title">@lang( 'lang.add_money_safe' )</h4>

        </x-modal-header>

        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="form-group col-md-6 px-5">
                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('store_id', __('lang.store') ,[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                    ]) !!}
                    <span class="text-danger">*</span>
                </div>
                {!! Form::select('store_id', $stores, !empty($stores->toArray()) && count($stores->toArray()) > 0 ?
                array_key_first($stores->toArray()) : false, ['class' => 'form-control selectpicker', 'data-live-search'
                => 'true', 'required', 'placeholder' => __('lang.please_select')],[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                ]) !!}
            </div>
            <div class="form-group col-md-6 px-5">
                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('name', __('lang.safe_name')
                    ,[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                    ]) !!}
                    <span class="text-danger">*</span>
                </div>
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('lang.name'),
                'required'])
                !!}
            </div>
            <div class="form-group col-md-6 px-5">
                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('currency_id', __('lang.currency')
                    ,[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                    ]) !!}
                    <span class="text-danger">*</span>
                </div>
                {!! Form::select('currency_id', $currencies, false, ['class' => 'form-control selectpicker',
                'data-live-search' => 'true', 'required'],[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                ]) !!}
            </div>
            <div class="form-group col-md-6 px-5">
                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('type', __('lang.type_of_safe') ,[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                    ]) !!}
                    <span class="text-danger">*</span>
                </div>
                {!! Form::select('type', ['cash' => __('lang.cash'), 'bank' => __('lang.bank')], false, ['class' =>
                'form-control selectpicker', 'data-live-search' => 'true', 'required', 'placeholder' =>
                __('lang.please_select')],[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                ]) !!}
            </div>
            <div class="form-group bank_fields">
                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('bank_name', __('lang.bank_name') ,[
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                    ]) !!}
                    <span class="text-danger">*</span>
                </div>
                {!! Form::text('bank_name', null, ['class' => 'form-control bank_required', 'placeholder' =>
                __('lang.bank_name'), 'required'],[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                ]) !!}
            </div>
            <div class="form-group bank_fields">
                {!! Form::label('IBAN', __('lang.IBAN'),[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                ]) !!}
                {!! Form::text('IBAN', null, ['class' => 'form-control', 'placeholder' => __('lang.IBAN')],[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                ]) !!}
            </div>
            <div class="form-group bank_fields">
                {!! Form::label('bank_address', __('lang.bank_address'),[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                ]) !!}
                {!! Form::text('bank_address', null, ['class' => 'form-control', 'placeholder' =>
                __('lang.bank_address')],[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                ]) !!}
            </div>
            {{-- <div class="form-group bank_fields">
                {!! Form::label('credit_card_currency_id', __('lang.credit_card_default_currency') . ':*',[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                ]) !!}
                {!! Form::select('credit_card_currency_id', $currencies, false, ['class' => 'form-control
                selectpicker
                bank_required', 'data-live-search' => 'true', 'placeholder' => __('lang.please_select')],[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                ]) !!}
            </div>
            <div class="form-group bank_fields">
                {!! Form::label('bank_transfer_currency_id', __('lang.bank_transfer_default_currency') . ':*',[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                ]) !!}
                {!! Form::select('bank_transfer_currency_id', $currencies, false, ['class' => 'form-control
                selectpicker
                bank_required', 'data-live-search' => 'true', 'placeholder' => __('lang.please_select')],[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                ]) !!}
            </div> --}}
            <div class="form-group cash_fields">
                {!! Form::label('add_money_users', __('lang.add_money_users'),[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                ]) !!}
                {!! Form::select('add_money_users[]', $employees, false, ['class' => 'form-control selectpicker',
                'data-live-search' => 'true', 'data-actions-box' => 'true', 'multiple'],[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                ]) !!}
            </div>
            <div class="form-group cash_fields">
                {!! Form::label('take_money_users', __('lang.take_money_users'),[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                ]) !!}
                {!! Form::select('take_money_users[]', $employees, false, ['class' => 'form-control selectpicker',
                'data-live-search' => 'true', 'data-actions-box' => 'true', 'multiple'],[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                ]) !!}
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
    $('.selectpicker').selectpicker();
    $('.bank_fields').hide();
    $('.cash_fields').hide();
    $(document).on('change', '#type', function() {
        let type = $(this).val();
        if (type == 'cash') {
            $('.bank_fields').hide();
            $('.cash_fields').show();
            $('.bank_required').attr('required', false);
        }
        if (type == 'bank') {
            $('.bank_fields').show();
            $('.cash_fields').hide();
            $('.bank_required').attr('required', true);
        }
    })
</script>
