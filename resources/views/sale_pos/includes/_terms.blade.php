<div class="row table_room_hide">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('terms_and_condition_id', __('lang.terms_and_conditions'), [])
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
                    {!! Form::label('commissioned_employees', __('lang.commissioned_employees'), [])
                    !!}
                    {!! Form::select('commissioned_employees[]', $employees, false, ['class' =>
                    'form-control selectpicker', 'data-live-search' => 'true', 'multiple', 'id' =>
                    'commissioned_employees']) !!}
                </div>
            </div>
            <div class="col-md-4 hide shared_commission_div">
                <div class="i-checks" style="margin-top: 37px;">
                    <input id="shared_commission" name="shared_commission" type="checkbox" value="1"
                        class="form-control-custom">
                    <label for="shared_commission"><strong>
                            @lang('lang.shared_commission')
                        </strong></label>
                </div>
            </div>
        </div>
    </div>
</div>