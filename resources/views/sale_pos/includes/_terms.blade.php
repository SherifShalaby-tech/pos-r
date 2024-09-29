<div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif table_room_hide">

    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('terms_and_condition_id', __('lang.terms_and_conditions'), [
            'class' => app()->isLocale('ar') ? 'mb-0 label-ar' : 'mb-0 label-en'
            ])
            !!}
            <select name="terms_and_condition_id" id="terms_and_condition_id" class="form-control selectpicker"
                data-live-search="true">
                <option value="">@lang('lang.please_select')</option>
                @foreach ($tac as $key => $item)
                <option value="{{ $key }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>
        <div class="tac_description_div"><span></span></div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('commissioned_employees', __('lang.commissioned_employees'), ['class' =>
            app()->isLocale('ar') ? 'mb-0 label-ar' : 'mb-0 label-en'])
            !!}
            {!! Form::select('commissioned_employees[]', $employees, false, ['class' =>
            'form-control selectpicker', 'data-live-search' => 'true', 'multiple', 'id' =>
            'commissioned_employees']) !!}
        </div>
    </div>
    <div class="col-md-2 d-flex justify-content-center align-items-center hide shared_commission_div">
        <div class="i-checks toggle-pill-color d-flex flex-column align-items-center">
            <input id="shared_commission" name="shared_commission" type="checkbox" value="1"
                class="form-control-custom">
            <label for="shared_commission"></label>
            <span>
                <strong>
                    @lang('lang.shared_commission')
                </strong>
            </span>
        </div>
    </div>

</div>
