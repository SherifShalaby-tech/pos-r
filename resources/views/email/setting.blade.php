@extends('layouts.app')
@section('title', __('lang.settings'))

@section('content')
<section class="forms py-2">
    <div class="container-fluid px-2">

        <x-page-title>
            <h4>@lang('lang.settings')</h4>
        </x-page-title>





        {!! Form::open(['url' => action('EmailController@saveSetting'), 'method' => 'post', 'id' =>
        'sms_form'
        ]) !!}
        <div class="card mt-1 mb-0">
            <div class="card-body py-2 px-4">
                <div class=" row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                for="sender_email">{{__('lang.email')}}</label>
                            <input type="text" class="form-control" id="sender_email" name="sender_email" required
                                value="@if(!empty($settings['sender_email'])){{$settings['sender_email']}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 d-flex px-0">
                    <button type="submit" name="submit" id="print" value="save"
                        class="btn btn-primary pull-right btn-flat submit">@lang( 'lang.save' )</button>
                </div>
            </div>
        </div>


        {!! Form::close() !!}


    </div>
</section>
@endsection

@section('javascript')
<script type="text/javascript">

</script>
@endsection