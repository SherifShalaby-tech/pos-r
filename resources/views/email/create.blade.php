@extends('layouts.app')
@section('title', __('lang.email'))

@section('content')
<section class="forms py-2">
    <div class="container-fluid px-2">

        <x-page-title>

            <h4>@lang('lang.email')</h4>

        </x-page-title>


        <div class="card mt-1 mb-0">
            <div class="card-body py-2 px-4">

                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('employee_id', __('lang.employee'), [
                            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::select('employee_id[]', $employees, !empty($email) ? $email : false,
                            ['class' => 'form-control
                            selectpicker', 'multiple', 'data-live-search' =>'true',
                            "data-actions-box"=>"true", 'id' => 'employee_id']) !!}
                        </div>
                    </div>
                </div>


                {!! Form::open(['url' => action('EmailController@store'), 'method' => 'post', 'id' => 'email_form',
                'files' => true,
                ]) !!}

                <div class=" row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                for="to">{{__('lang.to')}}
                                <small>@lang('lang.separated_by_comma')</small></label>
                            <input type="text" class="form-control" id="to" name="to" required
                                value="@if(!empty($number_string)){{$number_string}}@endif">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                for="subject">{{__('lang.subject')}}</label>
                            <input type="text" class="form-control" id="name" name="subject" required=""
                                value="{{old('subject')}}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                for="body">{{__('lang.body')}}</label>
                            <textarea name="body" id="body" cols="30" rows="6" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 my-3">
                        <div class="form-group">
                            <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                for="body">
                                <input type="file" name="attachments[]" id="attachments" class=" w-100 h-100"
                                    style="opacity: 0;position: absolute;top: 0;left: -18px;" multiple>
                                <div class="w-100 h-100 mb-1 py-2 text-center"
                                    style="border: 2px dashed var(--primary-color);cursor: pointer;">
                                    {{__('lang.attachment')}}
                                </div>
                            </label>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                for="body">{{__('lang.notes')}}</label>
                            <textarea name="notes" id="notes" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 d-flex">
                    <button type="submit" name="submit" id="print" value="save"
                        class="btn btn-primary pull-right btn-flat submit">@lang( 'lang.send' )</button>
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
        let numbers= $(this).val();
        numbers =  numbers.filter(e =>  e);
        $('#to').val(numbers.join());

    });
    tinymce.init({
        selector: "#body",
        height: 130,
        plugins: [
            "advlist autolink lists link charmap print preview anchor textcolor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime table contextmenu paste code wordcount",
        ],
        toolbar:
            "insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat",
        branding: false,
    });
</script>
@endsection