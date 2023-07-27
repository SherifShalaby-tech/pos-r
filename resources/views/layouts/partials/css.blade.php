
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
{{-- <script src="https://fastly.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<title>@yield('title') - {{ config('app.name', 'POS') }}</title>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
<!-- Bootstrap CSS-->
<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css')}}" type="text/css">

<link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css')}}" type="text/css">

<link rel="stylesheet" href="{{asset('vendor/jquery-timepicker/jquery.timepicker.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/awesome-bootstrap-checkbox.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap-select.min.css')}}" type="text/css">
<!-- Font Awesome CSS-->
<link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" type="text/css">
<!-- Drip icon font-->
<link rel="stylesheet" href="{{asset('vendor/dripicons/webfont.css')}}" type="text/css">
<!-- Google fonts - Roboto -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,500,700">
<!-- jQuery Circle-->
<link rel="stylesheet" href="{{asset('css/grasp_mobile_progress_circle-1.0.0.min.css')}}" type="text/css">
<!-- Custom Scrollbar-->
<link rel="stylesheet" href="{{asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css')}}"
type="text/css">
<!-- virtual keybord stylesheet-->
<link rel="stylesheet" href="{{asset('vendor/keyboard/css/keyboard.css')}}" type="text/css">
<!-- date range stylesheet-->
<link rel="stylesheet" href="{{asset('vendor/daterange/css/daterangepicker.min.css')}}" type="text/css">
<!-- table sorter stylesheet-->
<link rel="stylesheet" href="{{asset('vendor/datatable/dataTables.bootstrap4.min.css')}}" type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap.min.css"
type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css"
type="text/css">
<link rel="stylesheet" href="{{asset('vendor/toastr/toastr.min.css')}}" id="theme-stylesheet" type="text/css">
<link rel="stylesheet" href="{{asset('css/style.default.css')}}" id="theme-stylesheet" type="text/css">
<link rel="stylesheet" href="{{asset('css/dropzone.css')}}">
<link rel="stylesheet" href="{{asset('vendor/cropperjs/cropper.min.css') }}">
<link rel="stylesheet" href="{{asset('css/bootstrap-treeview.css')}}">
<link rel="stylesheet" href="{{asset('css/style.css')}}">


<!-- Custom stylesheet - for your changes-->
<link rel="stylesheet" href="{{asset('css/custom-default.css') }}" type="text/css" id="custom-style">

<style>
    .my-group .form-control {
        width: 50% !important;
    }

    .bs-searchbox .form-control {
        width: 100% !important;
    }

    .error {
        color: red !important;
    }

    .text-red {
        color: maroon !important;
    }

    .hide {
        display: none !important;
    }
</style>
<style>
    .mCSB_draggerRail {
        width: 16px !important;
    }

    .mCSB_dragger_bar {
        width: 10px !important;
    }
    input.form-control.v_sub_sku,input.form-control.v_name {
        min-width: 150px;
    }

</style>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
<style>
    .preview-container {
        /* display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px; */
        display: grid;
        grid-template-columns: repeat(auto-fill, 170px);
    }
    .preview-edit-product-container {
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
