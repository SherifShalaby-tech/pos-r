<div class="col-md-12 main_settings">
    <div class="row">
        <div class="col-md-2">

            {!! Form::label('store_id', __('lang.store') . '*', [
            'class' => app()->isLocale('ar') ? 'mb-0 label-ar' : 'mb-0 label-en'
            ]) !!}
            {!! Form::select('store_id', $stores, $store_pos->store_id, ['class' =>
            'selectpicker form-control', 'data-live-search' => 'true', 'required',
            'style' => 'width: 80%', 'placeholder' => __('lang.please_select')]) !!}

        </div>
        <div class="col-md-2">
            {!! Form::label('store_pos_id', __('lang.pos') . '*', [
            'class' => app()->isLocale('ar') ? 'mb-0 label-ar' : 'mb-0 label-en'
            ]) !!}
            {!! Form::select('store_pos_id', $store_poses, $store_pos->id, ['class' =>
            'selectpicker form-control', 'data-live-search' => 'true', 'required',
            'style' => 'width: 80%', 'placeholder' => __('lang.please_select')]) !!}

        </div>
        <div class="col-md-2">

            <input type="hidden" name="setting_invoice_lang" id="setting_invoice_lang"
                value="{{ !empty(App\Models\System::getProperty('invoice_lang')) ? App\Models\System::getProperty('invoice_lang') : 'en' }}">
            {!! Form::label('invoice_lang', __('lang.invoice_lang') , [
            'class' => app()->isLocale('ar') ? 'mb-0 label-ar' : 'mb-0 label-en'
            ]) !!}
            {!! Form::select('invoice_lang', $languages + ['ar_and_en' => 'Arabic and
            English'], !empty(App\Models\System::getProperty('invoice_lang')) ?
            App\Models\System::getProperty('invoice_lang') : 'en', ['class' =>
            'form-control selectpicker', 'data-live-search' => 'true']) !!}

        </div>
        <div class="col-md-2">

            <input type="hidden" name="exchange_rate" id="exchange_rate" value="1">
            <input type="hidden" name="default_currency_id" id="default_currency_id"
                value="{{ !empty(App\Models\System::getProperty('currency')) ? App\Models\System::getProperty('currency') : '' }}">
            {!! Form::label('received_currency_id', __('lang.received_currency') ,
            ['class' => app()->isLocale('ar') ? 'mb-0 label-ar' : 'mb-0 label-en']) !!}
            {!! Form::select('received_currency_id', $exchange_rate_currencies,
            !empty(App\Models\System::getProperty('currency')) ?
            App\Models\System::getProperty('currency') : null, ['class' => 'form-control
            selectpicker', 'data-live-search' => 'true']) !!}

        </div>

        <div class="col-md-1 px-0">

            {!! Form::label('', "tax" ,
            ['class' => app()->isLocale('ar') ? 'mb-0 label-ar' : 'mb-0 label-en']) !!}
            <select class="form-control" name="tax_id" id="tax_id">
                @if(env('ISNoTax',true))
                <option value="">No Tax</option>
                @endif
                @foreach ($taxes as $tax)
                <option data-rate="{{ $tax['rate'] }}" @if ((!empty($transaction) && $transaction->tax_id ==
                    $tax['id'] ) ||
                    App\Models\System::getProperty('def_pos_tax_id') == $tax['id'] )
                    selected @endif
                    value="{{ $tax['id'] }}">{{ $tax['name'] }}</option>
                @endforeach
            </select>
            <input type="hidden" name="tax_id_hidden" id="tax_id_hidden" value="">
            <input type="hidden" name="tax_method" id="tax_method" value="">
            <input type="hidden" name="tax_rate" id="tax_rate" value="0">
            <input type="hidden" name="tax_type" id="tax_type" value="">

        </div>

        <div class="col-md-3 d-flex justify-content-between align-items-end">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#delivery-cost-modal"><i
                    class="fas fa-motorcycle"></i>
            </button>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deposit_modal"
                data-toggle="tooltip" title="@lang('lang.insurance_amount')">
                <i class="fas fa-money-bill"></i>
            </button>

            <button type="button" class="btn btn-danger" id="print_and_draft"><i class="dripicons-print"></i></button>


        </div>

        <input type="hidden" id="print_and_draft_hidden" name="print_and_draft_hidden" value="">

    </div>
</div>