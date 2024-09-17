@extends('layouts.app')
@section('title', __('lang.sms'))

@section('content')
<section class="forms py-2">
    <div class="container-fluid px-2">
        <div class="row">
            <div class="col-md-12">
                <x-page-title>

                    <h4>@lang('lang.sms')</h4>

                </x-page-title>

                <div class="card">

                    <div class="col-md-12">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('employee_id', __('lang.employee'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('employee_id[]', $employees, explode(',', $sms->mobile_numbers),
                                    ['class' => 'form-control selectpicker', 'multiple', 'id' => 'employee_id'
                                    ,'placeholder' => __('lang.please_select')]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['url' => action('SmsController@update', $sms->id), 'method' => 'put', 'id' =>
                    'sms_form'
                    ]) !!}

                    <div class=" row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                    for="to">{{__('lang.to')}}:
                                    <small>@lang('lang.separated_by_comma')</small></label>
                                <input type="text" class="form-control" id="to" name="to" required
                                    value="@if(!empty($sms->mobile_numbers)){{$sms->mobile_numbers}}@endif">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                    for="message">{{__('lang.message')}}:</label>
                                <textarea name="message" id="message" cols="30" rows="6" required
                                    class="form-control">{{$sms->message}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                    for="body">{{__('lang.notes')}}:</label> <br>
                                <textarea name="notes" id="notes" cols="30" rows="3"
                                    class="form-control">{{$sms->notes}}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" name="submit" id="print" style="margin: 10px" value="save"
                                class="btn btn-primary pull-right btn-flat submit">@lang( 'lang.send' )</button>

                        </div>
                    </div>


                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')
<script type="text/javascript">
    $('#employee_id').change(function(){
        let numbers= $(this).val();
        numbers =  numbers.filter(e =>  e);
        $('#to').val(numbers.join())

    })
</script>
@endsection
