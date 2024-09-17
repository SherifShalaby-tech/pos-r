@extends('layouts.app')
@section('title', __('lang.sms'))

@section('content')
<section class="forms py-2">
    <div class="container-fluid px-2">

        <x-page-title>
            <h4>@lang('lang.sms')</h4>
        </x-page-title>


        <div class="card mt-1 mb-0">
            <div class="card-body py-2 px-4">
                <div class="col-md-12 toggle-pill-color">
                    <input id="select_all" name="select_all" type="checkbox" value="1" class="form-control-custom">
                    <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                        for="select_all">
                    </label>
                    <span>
                        <strong>@lang('lang.select_all')</strong>
                    </span>
                </div>


                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('employee_id', __('lang.employee'), [
                            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::select('employee_id[]', ['select_all' => __('lang.select_all')] +
                            $employees, !empty($employee_mobile_number) ?
                            [$employee_mobile_number] : false, ['class' => 'form-control selectpicker',
                            'multiple',
                            'data-live-search' =>'true' ,'id' => 'employee_id']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('customer_id', __('lang.customer'), ['class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::select('customer_id[]', ['select_all' => __('lang.select_all')] +
                            $customers, !empty($customer_mobile_number) ?
                            [$customer_mobile_number] : false, ['class' => 'form-control selectpicker',
                            'multiple',
                            'data-live-search' =>'true' ,'id' => 'customer_id']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('supplier_id', __('lang.supplier'), ['class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::select('supplier_id[]', ['select_all' => __('lang.select_all')] +
                            $suppliers, !empty($supplier_mobile_number) ?
                            [$supplier_mobile_number] : false, ['class' => 'form-control selectpicker',
                            'multiple',
                            'data-live-search' =>'true' ,'id' => 'supplier_id']) !!}
                        </div>
                    </div>
                </div>

                {!! Form::open(['url' => action('SmsController@store'), 'method' => 'post', 'id' => 'sms_form'
                ]) !!}

                <div class=" row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                for="to">{{__('lang.to')}}
                                <small>@lang('lang.separated_by_comma')</small></label>
                            <input type="text" class="form-control" id="to" name="to" required
                                value="@if(!empty($number_string)){{$number_string}}@endif">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                for="message">{{__('lang.message')}}</label>
                            <textarea name="message" id="message" cols="30" rows="6" required
                                class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                for="body">{{__('lang.notes')}}</label>
                            <textarea name="notes" id="notes" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 d-flex">
                        <button type="submit" name="submit" id="print" style="margin: 10px" value="save"
                            class="btn btn-primary pull-right btn-flat submit">@lang( 'lang.send' )</button>

                    </div>
                </div>


                {!! Form::close() !!}

            </div>

        </div>
    </div>
</section>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        $('#employee_id').change()
    })
    $('#employee_id').change(function(){
        let numbers = $(this).val()
        if(numbers.includes('select_all')){
            $('#employee_id').selectpicker('selectAll')
        }
        get_numbers()
    })
    $('#customer_id').change(function(){
        let numbers = $(this).val()
        if(numbers.includes('select_all')){
            $('#customer_id').selectpicker('selectAll')
        }
        get_numbers()
    })
    $('#supplier_id').change(function(){
        let numbers = $(this).val()
        if(numbers.includes('select_all')){
            $('#supplier_id').selectpicker('selectAll')
        }
        get_numbers()
    })



    $('#select_all').change(function(){
        if($(this).prop('checked')){
            $('#employee_id').selectpicker('selectAll')
            $('#customer_id').selectpicker('selectAll')
            $('#supplier_id').selectpicker('selectAll')
        }else{
            $('#employee_id').selectpicker('deselectAll')
            $('#customer_id').selectpicker('deselectAll')
            $('#supplier_id').selectpicker('deselectAll')
        }
        get_numbers()
    })

    function get_numbers(){
        let employee_numbers = $('#employee_id').val();
        let customer_numbers = $('#customer_id').val();
        let supplier_numbers = $('#supplier_id').val();
        let numbers = employee_numbers.concat(customer_numbers).concat(supplier_numbers);
        var list_numbers = numbers.filter(function(e) { return e !== 'select_all' })

        list_numbers =  list_numbers.filter(e =>  e);
        $('#to').val(list_numbers.join())
    }
</script>
@endsection
