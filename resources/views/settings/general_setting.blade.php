@extends('layouts.app')
@section('title', __('lang.general_settings'))
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Libre+Barcode+128&display=swap');

    .barcode-128 {
font-family: "Libre Barcode 128", serif;
font-weight: 400;
font-style: normal;
font-size: 50px

    }
    .preview-logo-container {
        /* display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px; */
        display: grid;
        grid-template-columns: repeat(auto-fill, 170px);
    }

    .preview-header-container {
        /* display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px; */
        display: grid;
        grid-template-columns: repeat(auto-fill, 170px);
    }

    .preview-footer-container {
        /* display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px; */
        display: grid;
        grid-template-columns: repeat(auto-fill, 170px);
    }

    .preview {
        position: relative;
        width: 150px;
        height: 150px;
        padding: 4px;
        box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        margin: 30px 0px;
        border: 1px solid #ddd;
    }

    .preview img {
        width: 100%;
        height: 100%;
        box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        border: 1px solid #ddd;
        object-fit: cover;

    }

    .delete-btn {
        position: absolute;
        top: 156px;
        right: 0px;
        /*border: 2px solid #ddd;*/
        border: none;
        cursor: pointer;
    }

    .delete-btn {
        background: transparent;
        color: rgba(235, 32, 38, 0.97);
    }

    .crop-btn {
        position: absolute;
        top: 156px;
        left: 0px;
        /*border: 2px solid #ddd;*/
        border: none;
        cursor: pointer;
        background: transparent;
        color: #007bff;
    }
</style>

<style>
    .variants {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .variants>div {
        margin-right: 5px;
    }

    .variants>div:last-of-type {
        margin-right: 0;
    }

    .file {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .file>input[type='file'] {
        display: none
    }

    .file>label {
        font-size: 1rem;
        font-weight: 300;
        cursor: pointer;
        outline: 0;
        user-select: none;
        border-color: rgb(216, 216, 216) rgb(209, 209, 209) rgb(186, 186, 186);
        border-style: solid;
        border-radius: 4px;
        border-width: 1px;
        background-color: hsl(0, 0%, 100%);
        color: hsl(0, 0%, 29%);
        padding-left: 16px;
        padding-right: 16px;
        padding-top: 16px;
        padding-bottom: 16px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .file>label:hover {
        border-color: hsl(0, 0%, 21%);
    }

    .file>label:active {
        background-color: hsl(0, 0%, 96%);
    }

    .file>label>i {
        padding-right: 5px;
    }

    .file--upload>label {
        color: hsl(204, 86%, 53%);
        border-color: hsl(204, 86%, 53%);
    }

    .file--upload>label:hover {
        border-color: hsl(204, 86%, 53%);
        background-color: hsl(204, 86%, 96%);
    }

    .file--upload>label:active {
        background-color: hsl(204, 86%, 91%);
    }

    .file--uploading>label {
        color: hsl(48, 100%, 67%);
        border-color: hsl(48, 100%, 67%);
    }

    .file--uploading>label>i {
        animation: pulse 5s infinite;
    }

    .file--uploading>label:hover {
        border-color: hsl(48, 100%, 67%);
        background-color: hsl(48, 100%, 96%);
    }

    .file--uploading>label:active {
        background-color: hsl(48, 100%, 91%);
    }

    .file--success>label {
        color: hsl(141, 71%, 48%);
        border-color: hsl(141, 71%, 48%);
    }

    .file--success>label:hover {
        border-color: hsl(141, 71%, 48%);
        background-color: hsl(141, 71%, 96%);
    }

    .file--success>label:active {
        background-color: hsl(141, 71%, 91%);
    }

    .file--danger>label {
        color: hsl(348, 100%, 61%);
        border-color: hsl(348, 100%, 61%);
    }

    .file--danger>label:hover {
        border-color: hsl(348, 100%, 61%);
        background-color: hsl(348, 100%, 96%);
    }

    .file--danger>label:active {
        background-color: hsl(348, 100%, 91%);
    }

    .file--disabled {
        cursor: not-allowed;
    }

    .file--disabled>label {
        border-color: #e6e7ef;
        color: #e6e7ef;
        pointer-events: none;
    }


    @keyframes pulse {
        0% {
            color: hsl(48, 100%, 67%);
        }

        50% {
            color: hsl(48, 100%, 38%);
        }

        100% {
            color: hsl(48, 100%, 67%);
        }
    }
</style>
@endsection
@section('content')

<section class="forms py-2">

    <div class="container-fluid px-2">
        <div class="col-md-12 px-0 no-print">

            <x-page-title>

                <h4>@lang('lang.general_settings')</h4>
            </x-page-title>


            <div class="card mb-0">
                <div class="card-body">
                    {!! Form::open(['url' => action('SettingController@updateGeneralSetting'), 'method' =>
                    'post','id'=>'setting_form', 'enctype' => 'multipart/form-data']) !!}
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            {!! Form::label('site_title', __('lang.site_title'), ['class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::text('site_title', !empty($settings['site_title']) ? $settings['site_title'] :
                            null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-3 hide">
                            {!! Form::label('developed_by', __('lang.developed_by'), ['class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::text('developed_by', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-3 ">
                            {!! Form::label('ticketـnumberـstart', __('lang.ticketـnumberـstart'), ['class' =>
                            app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            {!! Form::number('ticketـnumberـstart', !empty($settings['ticketـnumberـstart']) ?
                            $settings['ticketـnumberـstart']
                            : 1, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('ticketـtimeـstart', __('lang.ticketـtimeـstart'), ['class' =>
                                app()->isLocale('ar') ?
                                'mb-1 label-ar' : 'mb-1 label-en']) !!}
                                {!! Form::text('ticketـtimeـstart', !empty($settings['ticketـtimeـstart']) ?
                                $settings['ticketـtimeـstart'] :
                                null, ['class' => 'form-control time_picker sale_filter']) !!}
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            {!! Form::label('timezone', __('lang.timezone'), ['class' => app()->isLocale('ar') ? 'mb-1
                            label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::select('timezone', $timezone_list, !empty($settings['timezone']) ?
                            $settings['timezone'] : null, ['class' => 'form-control selectpicker', 'data-live-search' =>
                            'true']) !!}
                        </div>
                        <div class="col-md-3 mb-2">
                            {!! Form::label('language', __('lang.language'), ['class' => app()->isLocale('ar') ? 'mb-1
                            label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::select('language', $languages, !empty($settings['language']) ?
                            $settings['language'] : null, ['class' => 'form-control selectpicker', 'data-live-search' =>
                            'true']) !!}
                        </div>
                        <div class="col-md-3 mb-2">
                            {!! Form::label('currency', __('lang.currency'), ['class' => app()->isLocale('ar') ? 'mb-1
                            label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::select('currency', $currencies, !empty($settings['currency']) ?
                            $settings['currency'] : null, ['class' => 'form-control selectpicker', 'data-live-search' =>
                            'true']) !!}
                        </div>
                        <div class="col-md-3 mb-2">
                            {!! Form::label('invoice_lang', __('lang.invoice_lang'), ['class' => app()->isLocale('ar') ?
                            'mb-1 label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::select('invoice_lang', $languages + ['ar_and_en' => 'Arabic and English'],
                            !empty($settings['invoice_lang']) ? $settings['invoice_lang'] : null, ['class' =>
                            'form-control selectpicker', 'data-live-search' => 'true']) !!}
                        </div>
                        <div class="col-md-3 mb-2">
                            {!! Form::label('invoice_terms_and_conditions', __('lang.tac_to_be_printed'), ['class' =>
                            app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::select('invoice_terms_and_conditions', $terms_and_conditions,
                            !empty($settings['invoice_terms_and_conditions']) ?
                            $settings['invoice_terms_and_conditions'] : null, ['class' => 'form-control selectpicker',
                            'data-live-search' => 'true', 'placeholder' => __('lang.please_select')]) !!}
                        </div>
                        @if (session('system_mode') != 'restaurant')
                        <div class="col-md-3 mb-2">
                            <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                style="gap: 10px">
                                {!! Form::label('default_purchase_price_percentage',
                                __('lang.default_purchase_price_percentage'), ['class' => app()->isLocale('ar') ? 'mb-1
                                label-ar' : 'mb-1 label-en'
                                ]) !!} <i class="dripicons-question" data-toggle="tooltip"
                                    title="@lang('lang.default_purchase_price_percentage_info')"></i>
                            </div>
                            {!! Form::number('default_purchase_price_percentage',
                            !empty($settings['default_purchase_price_percentage']) ?
                            $settings['default_purchase_price_percentage'] : null, ['class' => 'form-control']) !!}
                        </div>
                        @else
                        <div class="col-md-3 mb-2">
                            {!! Form::label('default_profit_percentage', __('lang.default_profit_percentage'), ['class'
                            => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                            ]) !!}
                            <small>@lang('lang.without_%_symbol')</small>
                            {!! Form::number('default_profit_percentage', !empty($settings['default_profit_percentage'])
                            ? $settings['default_profit_percentage'] : null, ['class' => 'form-control']) !!}
                        </div>
                        @endif
                        <div class="col-md-3 mb-2">
                            {!! Form::label('Watsapp Numbers', __('lang.watsapp_numbers'),[
                            'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::text('watsapp_numbers', !empty($settings['watsapp_numbers']) ?
                            $settings['watsapp_numbers'] : null, ['class' => 'form-control',Auth::user()->is_superadmin
                            == 1?'':'disabled']) !!}
                        </div>
                        <div class="col-md-3 mb-2">
                            {!! Form::label('font_size_at_invoice', __('lang.font_size_at_invoice'), ['class' =>
                            app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::select('font_size_at_invoice', $fonts, !empty($settings['font_size_at_invoice']) ?
                            $settings['font_size_at_invoice'] : null, ['class' => 'form-control selectpicker',
                            'data-live-search' => 'true']) !!}
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="i-checks">
                                <input id="show_the_window_printing_prompt" name="show_the_window_printing_prompt"
                                    type="checkbox" @if (!empty($settings['show_the_window_printing_prompt']) &&
                                    $settings['show_the_window_printing_prompt']=='1' ) checked @endif value="1"
                                    class="form-control-custom">
                                <label for="show_the_window_printing_prompt"><strong>
                                        @lang('lang.show_the_window_printing_prompt')
                                    </strong></label>
                            </div>
                        </div>
                        @if (session('system_mode') == 'restaurant')
                        <div class="col-md-3 mb-2">
                            <div class="i-checks">
                                <input id="enable_the_table_reservation" name="enable_the_table_reservation"
                                    type="checkbox" @if (!empty($settings['enable_the_table_reservation']) &&
                                    $settings['enable_the_table_reservation']=='1' ) checked @endif value="1"
                                    class="form-control-custom">
                                <label for="enable_the_table_reservation"><strong>
                                        @lang('lang.enable_the_table_reservation')
                                    </strong></label>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-3 mb-2">
                            {!! Form::label('numbers_length_after_dot', __('lang.numbers_length_after_dot'), ['class' =>
                            app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                            ]) !!}
                            {!! Form::select('numbers_length_after_dot', ['1' => '0.0', '2' => '0.00', '3' =>
                            '0.000','4' => '0.0000', '5' => '0.00000', '6' => '0.000000', '7' => '0.0000000'],
                            !empty($settings['numbers_length_after_dot']) ? $settings['numbers_length_after_dot'] :
                            null, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) !!}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                    for="projectinput2"> {{ __('lang.letter_header') }}</label>

                                <div class="variants">
                                    <div class='file file--upload w-100'>
                                        <label for='file-input-header' class="w-100 mb-0">
                                            <i class="fas fa-cloud-upload-alt"></i>Upload
                                        </label>
                                        <!-- <input  id="file-input" multiple type='file' /> -->
                                        <input type="file" id="file-input-header">
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-center align-items-center">
                                    <div class="preview-header-container">
                                        @if (!empty($settings['letter_header']))
                                        <div class="preview">
                                            <img src="{{ asset('uploads/'. $settings['letter_header']) }}"
                                                id="img_header_footer" alt="">
                                            <button class="btn btn-xs btn-danger delete-btn remove_image"
                                                data-type="letter_header"><i style="font-size: 25px;"
                                                    class="fa fa-trash"></i></button>

                                        </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="projectinput2"
                                    class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"> {{
                                    __('lang.letter_footer') }}</label>


                                <div class="variants">
                                    <div class='file file--upload w-100'>
                                        <label for='file-input-footer' class="w-100 mb-0">
                                            <i class="fas fa-cloud-upload-alt"></i>Upload
                                        </label>
                                        <input type="file" id="file-input-footer">
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-center align-items-center">
                                    <div class="preview-footer-container">
                                        @if (!empty($settings['letter_footer']))
                                        <div class="preview">
                                            <img src="{{ asset('uploads/'. $settings['letter_footer']) }}"
                                                id="img_letter_footer" alt="">
                                            <button class="btn btn-xs btn-danger delete-btn remove_image"
                                                data-type="letter_footer"><i style="font-size: 25px;"
                                                    class="fa fa-trash"></i></button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="projectinput2"
                                    class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"> {{
                                    __('lang.logo') }}</label>

                                <div class="variants">
                                    <div class='file file--upload w-100'>
                                        <label for='file-input-logo' class="w-100 mb-0">
                                            <i class="fas fa-cloud-upload-alt"></i>Upload
                                        </label>
                                        <!-- <input  id="file-input" multiple type='file' /> -->
                                        <input type="file" id="file-input-logo">
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-center align-items-center">
                                    <div class="preview-logo-container">
                                        @if (!empty($settings['logo']))
                                        <div class="preview">
                                            <img src="{{ asset('uploads/'. $settings['logo']) }}" id="img_logo_footer"
                                                alt="">
                                            <button class="btn btn-xs btn-danger delete-btn remove_image"
                                                data-type="logo"><i style="font-size: 25px;"
                                                    class="fa fa-trash"></i></button>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('help_page_content', __('lang.help_page_content'), ['class' =>
                                app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                ]) !!}
                                {!! Form::textarea('help_page_content', !empty($settings['help_page_content']) ?
                                $settings['help_page_content'] : null, ['class' => 'form-control', 'id' =>
                                'help_page_content']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row px-2 flex-column justify-content-center align-items-end">
                        <div class="d-flex mb-2 align-items-end">
                            <div>

                                {!! Form::label('Enter password', __('lang.Enter_password'), ['class' =>
                        app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                        ]) !!}
                            <input type="password" class="form-control" id="textInput" oninput="updateText()" placeholder="Type something...">
                        </div>
                        <div>
                            <button class="d-inline btn btn-primary px-0 py-1" type="button" onclick="toggleInputType()">
                                <i class="fa fa-eye btn"></i>
                            </button>
                        </div>
                        </div>
                        <div id="userCard" class="col-md-2 mb-2 border d-flex justify-content-center align-items-center flex flex-column ">
                                <div class="">

                                <img src="{{asset('images/default.jpg')}}"
                                style="width: 60px; border: 2px solid #fff; padding: 4px; border-radius: 50%;" />
                                {{ $user->name }}
                            </div>
                            <div>
                            <p id="outputText" style="font-size: 60px;color:black" class="barcode-128 mb-0"></p>
                            </div>
                        </div>
                        <div class="">
                        <button class="btn btn-primary" type="button" onclick="printDiv('userCard')">Print</button>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button id="submit-btn" class="btn btn-primary">@lang('lang.save')</button>
                    </div>
                    <div id="cropped_logo_images"></div>
                    <div id="cropped_header_images"></div>
                    <div id="cropped_footer_images"></div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="logoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <x-modal-header>

                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>

            </x-modal-header>

            <div class="modal-body">
                <div id="croppie-logo-modal" style="display:none">
                    <div id="croppie-logo-container"></div>
                    <button data-dismiss="modal" id="croppie-logo-cancel-btn" type="button" class="btn btn-secondary"><i
                            class="fas fa-times"></i></button>
                    <button id="croppie-logo-submit-btn" type="button" class="btn btn-primary"><i
                            class="fas fa-crop"></i></button>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="headerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <x-modal-header>

                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>

            </x-modal-header>

            <div class="modal-body">
                <div id="croppie-header-modal" style="display:none">
                    <div id="croppie-header-container"></div>
                    <button data-dismiss="modal" id="croppie-header-cancel-btn" type="button"
                        class="btn btn-secondary"><i class="fas fa-times"></i></button>
                    <button id="croppie-header-submit-btn" type="button" class="btn btn-primary"><i
                            class="fas fa-crop"></i></button>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="footerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <x-modal-header>
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>


            </x-modal-header>

            <div class="modal-body">
                <div id="croppie-footer-modal" style="display:none">
                    <div id="croppie-footer-container"></div>
                    <button data-dismiss="modal" id="croppie-footer-cancel-btn" type="button"
                        class="btn btn-secondary"><i class="fas fa-times"></i></button>
                    <button id="croppie-footer-submit-btn" type="button" class="btn btn-primary"><i
                            class="fas fa-crop"></i></button>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    function printDiv(divId) {
        let content = document.getElementById(divId).innerHTML;
        let originalContent = document.body.innerHTML;

        document.body.innerHTML = content; // Replace page content with div content
        window.print(); // Open print dialog
        document.body.innerHTML = originalContent; // Restore original content
        location.reload(); // Reload page to prevent issues
    }
</script>
<script>
    function updateText() {
        document.getElementById('outputText').innerText = document.getElementById('textInput').value;
    }
function toggleInputType() {

    let inputField = document.getElementById('textInput');
    inputField.type = inputField.type === 'password' ? 'text' : 'password';
    }
</script>
<script>
    $('.selectpicker').selectpicker();
        $(document).ready(function() {
            tinymce.init({
                selector: "#help_page_content",
                height: 130,
                plugins: [
                    "advlist autolink lists link charmap print preview anchor textcolor image",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime table contextmenu paste code wordcount",
                ],
                toolbar: "insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat",
                branding: false,
            });
        });
        $(document).on('click', '.remove_image', function(e) {
            e.preventDefault();
            var type = $(this).data('type');
            console.log(type)
            Swal.fire({
                title: '{{ __("site.Are you sure?") }}',
                text: "{{ __("site.You won't be able to delete!") }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/settings/remove-image/" + type,
                        type: "POST",
                        success: function(response) {
                            if (response.success) {
                                if (type == "letter_header"){
                                    const previewHeaderContainer = document.querySelector('.preview-header-container');
                                    previewHeaderContainer.innerHTML = '';
                                }else if(type == "letter_footer"){
                                    const previewFooterContainer = document.querySelector('.preview-footer-container');
                                    previewFooterContainer.innerHTML = '';
                                }else if(type == "logo"){
                                    const previewLogoContainer = document.querySelector('.preview-logo-container');
                                    previewLogoContainer.innerHTML = '';
                                }
                                Swal.fire(
                                    'Deleted!',
                                    '{{ __("site.Your Image has been deleted.") }}',
                                    'success'
                                );

                            }
                        }
                    });
                }
            });

        });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script>
    $("#submit-btn").on("click",function (e){
            e.preventDefault();
            setTimeout(()=>{
                getHeaderImages();
                getFooterImages();
                getLogoImages();
                $("#setting_form").submit();
            },1000)
        });
</script>
<script>
    const fileHeaderInput = document.querySelector('#file-input-header');
        const previewHeaderContainer = document.querySelector('.preview-header-container');
        const croppieHeaderModal = document.querySelector('#croppie-header-modal');
        const croppieHeaderContainer = document.querySelector('#croppie-header-container');
        const croppieHeaderCancelBtn = document.querySelector('#croppie-header-cancel-btn');
        const croppieHeaderSubmitBtn = document.querySelector('#croppie-header-submit-btn');
        // let currentFiles = [];
        fileHeaderInput.addEventListener('change', () => {
            previewHeaderContainer.innerHTML = '';
            let files = Array.from(fileHeaderInput.files)
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                let fileType = file.type.slice(file.type.indexOf('/') + 1);
                let FileAccept = ["jpg","JPG","jpeg","JPEG","png","PNG","BMP","bmp"];
                // if (file.type.match('image.*')) {
                if (FileAccept.includes(fileType)) {
                    const reader = new FileReader();
                    reader.addEventListener('load', () => {
                        const preview = document.createElement('div');
                        preview.classList.add('preview');
                        const img = document.createElement('img');
                        const actions = document.createElement('div');
                        actions.classList.add('action_div');
                        img.src = reader.result;
                        preview.appendChild(img);
                        preview.appendChild(actions);
                        const container = document.createElement('div');
                        const deleteBtn = document.createElement('span');
                        deleteBtn.classList.add('delete-btn');
                        deleteBtn.innerHTML = '<i style="font-size: 20px;" class="fas fa-trash"></i>';
                        deleteBtn.addEventListener('click', () => {
                            Swal.fire({
                                title: '{{ __("site.Are you sure?") }}',
                                text: "{{ __("site.You won't be able to delete!") }}",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire(
                                        'Deleted!',
                                        '{{ __("site.Your Image has been deleted.") }}',
                                        'success'
                                    )
                                    files.splice(file, 1)
                                    preview.remove();
                                    getHeaderImages()
                                }
                            });
                        });
                        preview.appendChild(deleteBtn);
                        const cropBtn = document.createElement('span');
                        cropBtn.setAttribute("data-toggle", "modal")
                        cropBtn.setAttribute("data-target", "#headerModal")
                        cropBtn.classList.add('crop-btn');
                        cropBtn.innerHTML = '<i style="font-size: 20px;" class="fas fa-crop"></i>';
                        cropBtn.addEventListener('click', () => {
                            setTimeout(() => {
                                launchHeaderCropTool(img);
                            }, 500);
                        });
                        preview.appendChild(cropBtn);
                        previewHeaderContainer.appendChild(preview);
                    });
                    reader.readAsDataURL(file);
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("site.Oops...") }}',
                        text: '{{ __("site.Sorry , You Should Upload Valid Image") }}',
                    })
                }
            }

            getHeaderImages()
        });
        function launchHeaderCropTool(img) {
            // Set up Croppie options
            const croppieOptions = {
                viewport: {
                    width: 240,
                    height: 120,
                    type: 'square' // or 'square'
                },
                boundary: {
                    width: 350,
                    height: 350,
                },
                enableOrientation: true
            };

            // Create a new Croppie instance with the selected image and options
            const croppie = new Croppie(croppieHeaderContainer, croppieOptions);
            croppie.bind({
                url: img.src,
                orientation: 1,
            });

            // Show the Croppie modal
            croppieHeaderModal.style.display = 'block';

            // When the user clicks the "Cancel" button, hide the modal
            croppieHeaderCancelBtn.addEventListener('click', () => {
                croppieHeaderModal.style.display = 'none';
                $('#headerModal').modal('hide');
                croppie.destroy();
            });

            // When the user clicks the "Crop" button, get the cropped image and replace the original image in the preview
            croppieHeaderSubmitBtn.addEventListener('click', () => {
                croppie.result('base64').then((croppedImg) => {
                    img.src = croppedImg;
                    croppieHeaderModal.style.display = 'none';
                    $('#headerModal').modal('hide');
                    croppie.destroy();
                    getHeaderImages()
                });
            });
        }
        function getHeaderImages() {
            setTimeout(() => {
                const container = document.querySelectorAll('.preview-header-container');
                let images = [];
                $("#cropped_header_images").empty();
                for (let i = 0; i < container[0].children.length; i++) {
                    images.push(container[0].children[i].children[0].src)
                    var newInput = $("<input>").attr("type", "hidden").attr("name", "letter_header").val(container[0].children[i].children[0].src);
                    $("#cropped_header_images").append(newInput);
                }
                return images
            }, 300);
        }

</script>
<script>
    const fileFooterInput = document.querySelector('#file-input-footer');
        const previewFooterContainer = document.querySelector('.preview-footer-container');
        const croppieFooterModal = document.querySelector('#croppie-footer-modal');
        const croppieFooterContainer = document.querySelector('#croppie-footer-container');
        const croppieFooterCancelBtn = document.querySelector('#croppie-footer-cancel-btn');
        const croppieFooterSubmitBtn = document.querySelector('#croppie-footer-submit-btn');
        // let currentFiles = [];
        fileFooterInput.addEventListener('change', () => {
            previewFooterContainer.innerHTML = '';
            let files = Array.from(fileFooterInput.files)
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                let fileType = file.type.slice(file.type.indexOf('/') + 1);
                let FileAccept = ["jpg","JPG","jpeg","JPEG","png","PNG","BMP","bmp"];
                // if (file.type.match('image.*')) {
                if (FileAccept.includes(fileType)) {
                    const reader = new FileReader();
                    reader.addEventListener('load', () => {
                        const preview = document.createElement('div');
                        preview.classList.add('preview');
                        const img = document.createElement('img');
                        const actions = document.createElement('div');
                        actions.classList.add('action_div');
                        img.src = reader.result;
                        preview.appendChild(img);
                        preview.appendChild(actions);
                        const container = document.createElement('div');
                        const deleteBtn = document.createElement('span');
                        deleteBtn.classList.add('delete-btn');
                        deleteBtn.innerHTML = '<i style="font-size: 20px;" class="fas fa-trash"></i>';
                        deleteBtn.addEventListener('click', () => {
                            Swal.fire({
                                title: '{{ __("site.Are you sure?") }}',
                                text: "{{ __("site.You won't be able to delete!") }}",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire(
                                        'Deleted!',
                                        '{{ __("site.Your Image has been deleted.") }}',
                                        'success'
                                    )
                                    files.splice(file, 1)
                                    preview.remove();
                                    getFooterImages()
                                }
                            });
                        });
                        preview.appendChild(deleteBtn);
                        const cropBtn = document.createElement('span');
                        cropBtn.setAttribute("data-toggle", "modal")
                        cropBtn.setAttribute("data-target", "#footerModal")
                        cropBtn.classList.add('crop-btn');
                        cropBtn.innerHTML = '<i style="font-size: 20px;" class="fas fa-crop"></i>';
                        cropBtn.addEventListener('click', () => {
                            setTimeout(() => {
                                launchCropTool(img);
                            }, 500);
                        });
                        preview.appendChild(cropBtn);
                        previewFooterContainer.appendChild(preview);
                    });
                    reader.readAsDataURL(file);
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("site.Oops...") }}',
                        text: '{{ __("site.Sorry , You Should Upload Valid Image") }}',
                    })
                }
            }

            getFooterImages()
        });
        function launchCropTool(img) {
            // Set up Croppie options
            const croppieOptions = {
                viewport: {
                    width: 240,
                    height: 120,
                    type: 'square' // or 'square'
                },
                boundary: {
                    width: 350,
                    height: 350,
                },
                enableOrientation: true
            };

            // Create a new Croppie instance with the selected image and options
            const croppie = new Croppie(croppieFooterContainer, croppieOptions);
            croppie.bind({
                url: img.src,
                orientation: 1,
            });

            // Show the Croppie modal
            croppieFooterModal.style.display = 'block';

            // When the user clicks the "Cancel" button, hide the modal
            croppieFooterCancelBtn.addEventListener('click', () => {
                croppieFooterModal.style.display = 'none';
                $('#footerModal').modal('hide');
                croppie.destroy();
            });

            // When the user clicks the "Crop" button, get the cropped image and replace the original image in the preview
            croppieFooterSubmitBtn.addEventListener('click', () => {
                croppie.result('base64').then((croppedImg) => {
                    img.src = croppedImg;
                    croppieFooterModal.style.display = 'none';
                    $('#footerModal').modal('hide');
                    croppie.destroy();
                    getFooterImages()
                });
            });
        }
        function getFooterImages() {
            setTimeout(() => {
                const container = document.querySelectorAll('.preview-footer-container');
                let images = [];
                $("#cropped_footer_images").empty();
                for (let i = 0; i < container[0].children.length; i++) {
                    images.push(container[0].children[i].children[0].src)
                    var newInput = $("<input>").attr("type", "hidden").attr("name", "letter_footer").val(container[0].children[i].children[0].src);
                    $("#cropped_footer_images").append(newInput);
                }
                return images
            }, 300);
        }

</script>
<script>
    const fileLogoInput = document.querySelector('#file-input-logo');
        const previewLogoContainer = document.querySelector('.preview-logo-container');
        const croppieLogoModal = document.querySelector('#croppie-logo-modal');
        const croppieLogoContainer = document.querySelector('#croppie-logo-container');
        const croppieLogoCancelBtn = document.querySelector('#croppie-logo-cancel-btn');
        const croppieLogoSubmitBtn = document.querySelector('#croppie-logo-submit-btn');
        // let currentFiles = [];
        fileLogoInput.addEventListener('change', () => {
            previewLogoContainer.innerHTML = '';
            let files = Array.from(fileLogoInput.files)
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                let fileType = file.type.slice(file.type.indexOf('/') + 1);
                let FileAccept = ["jpg","JPG","jpeg","JPEG","png","PNG","BMP","bmp"];
                // if (file.type.match('image.*')) {
                if (FileAccept.includes(fileType)) {
                    const reader = new FileReader();
                    reader.addEventListener('load', () => {
                        const preview = document.createElement('div');
                        preview.classList.add('preview');
                        const img = document.createElement('img');
                        const actions = document.createElement('div');
                        actions.classList.add('action_div');
                        img.src = reader.result;
                        preview.appendChild(img);
                        preview.appendChild(actions);
                        const container = document.createElement('div');
                        const deleteBtn = document.createElement('span');
                        deleteBtn.classList.add('delete-btn');
                        deleteBtn.innerHTML = '<i style="font-size: 20px;" class="fas fa-trash"></i>';
                        deleteBtn.addEventListener('click', () => {
                            Swal.fire({
                                title: '{{ __("site.Are you sure?") }}',
                                text: "{{ __("site.You won't be able to delete!") }}",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire(
                                        'Deleted!',
                                        '{{ __("site.Your Image has been deleted.") }}',
                                        'success'
                                    )
                                    files.splice(file, 1)
                                    preview.remove();
                                    getLogoImages()
                                }
                            });
                        });
                        preview.appendChild(deleteBtn);
                        const cropBtn = document.createElement('span');
                        cropBtn.setAttribute("data-toggle", "modal")
                        cropBtn.setAttribute("data-target", "#logoModal")
                        cropBtn.classList.add('crop-btn');
                        cropBtn.innerHTML = '<i style="font-size: 20px;" class="fas fa-crop"></i>';
                        cropBtn.addEventListener('click', () => {
                            setTimeout(() => {
                                launchLogoCropTool(img);
                            }, 500);
                        });
                        preview.appendChild(cropBtn);
                        previewLogoContainer.appendChild(preview);
                    });
                    reader.readAsDataURL(file);
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("site.Oops...") }}',
                        text: '{{ __("site.Sorry , You Should Upload Valid Image") }}',
                    })
                }
            }

            getLogoImages()
        });
        function launchLogoCropTool(img) {
            // Set up Croppie options
            const croppieOptions = {
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'square' // or 'square'
                },
                boundary: {
                    width: 300,
                    height: 300,
                },
                enableOrientation: true
            };

            // Create a new Croppie instance with the selected image and options
            const croppie = new Croppie(croppieLogoContainer, croppieOptions);
            croppie.bind({
                url: img.src,
                orientation: 1,
            });

            // Show the Croppie modal
            croppieLogoModal.style.display = 'block';

            // When the user clicks the "Cancel" button, hide the modal
            croppieLogoCancelBtn.addEventListener('click', () => {
                croppieLogoModal.style.display = 'none';
                $('#logoModal').modal('hide');
                croppie.destroy();
            });

            // When the user clicks the "Crop" button, get the cropped image and replace the original image in the preview
            croppieLogoSubmitBtn.addEventListener('click', () => {
                croppie.result('base64').then((croppedImg) => {
                    img.src = croppedImg;
                    croppieLogoModal.style.display = 'none';
                    $('#logoModal').modal('hide');
                    croppie.destroy();
                    getLogoImages()
                });
            });
        }
        function getLogoImages() {
            setTimeout(() => {
                const container = document.querySelectorAll('.preview-logo-container');
                let images = [];
                $("#cropped_logo_images").empty();
                for (let i = 0; i < container[0].children.length; i++) {
                    images.push(container[0].children[i].children[0].src)
                    var newInput = $("<input>").attr("type", "hidden").attr("name", "logo").val(container[0].children[i].children[0].src);
                    $("#cropped_logo_images").append(newInput);
                }
                return images
            }, 300);
        }

</script>
@endsection
