<link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
<!-- Bootstrap CSS-->
<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css')}}" type="text/css">

<link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css')}}"
    type="text/css">


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

{{--
<link rel="stylesheet" href="{{asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css')}}"
    type="text/css"> --}}
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
    @import url('https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&family=Oswald:wght@200..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

    @import url('https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Noto+Kufi+Arabic:wght@100..900&family=Oswald:wght@200..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

    @import url('https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Beiruti:wght@200..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap');
</style>
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
        color: #dc3545 !important;
    }

    .hide {
        display: none !important;
    }
</style>

<style>
    :root {
        --primary-color: rgb(96 165 250);
        --primary-color-hover: rgb(59 130 246);
    }

    /* HTML: <div class="loader"></div> */
    #loader {
        width: 20px;
        aspect-ratio: 1;
        border-radius: 50%;
        background: var(--primary-color);
        box-shadow: 0 0 0 0 rgb(219 234 254);
        animation: l2 1.5s infinite linear;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
    }

    #loader:before,
    #loader:after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        box-shadow: 0 0 0 0 rgb(219 234 254);
        animation: inherit;
        animation-delay: -0.5s;
    }

    #loader:after {
        animation-delay: -1s;
    }

    @keyframes l2 {
        100% {
            box-shadow: 0 0 0 40px #0000
        }
    }


    body {
        /* font-family: "Noto Kufi Arabic", sans-serif !important; */
        /* font-family: "Almarai", sans-serif !important; */
        /* font-family: "Rubik", sans-serif; */
        font-family: "Beiruti", sans-serif;
    }

    .dash-padding {
        padding: 1px;
    }


    .page-title-en {
        border-left: 2px solid var(--primary-color);
    }

    .page-title-ar {
        border-right: 2px solid var(--primary-color);
    }

    .label-ar {
        display: block;
        text-align: right
    }

    .label-en {
        display: block;
        text-align: right
    }

    .modal-header {
        background: linear-gradient(to right, var(--primary-color), var(--primary-color-hover));
        color: white
    }

    .modal-footer {
        border: none;
        padding: 0
    }

    .modal-footer .btn {
        margin: 0;
        padding: 10px;
        border-radius: 0;
        text-align: center
    }

    .modal-footer .btn-default {
        transition: 0.3s
    }

    .modal-footer .btn-default:hover {
        background: #ebebeb;
    }

    .modal-close-btn {
        width: 35px;
        height: 35px;
        font-weight: 600;
        font-size: 1.5rem;
        background-color: #fff;
    }

    .modal-close-btn:hover {
        background-color: #efefef;
    }

    .btn-modal {
        /* border-radius: 0 6px 6px 0px; */
        /* border: 2px solid var(--primary-color); */
    }

    ::-webkit-scrollbar-track {
        border: 3px solid white;

        background-color: #b2bec3;
    }

    ::-webkit-scrollbar {
        width: 8px;
        background-color: #dfe6e9;
    }

    ::-webkit-scrollbar:horizontal {
        height: 8px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: var(--primary-color);
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background-color: var(--primary-color-hover);
        border-radius: 3px;
    }

    .count-title {
        position: relative;
    }

    .count-title .name {
        font-size: 15px;
        background: white;
        border-radius: 4px;
        color: var(--primary-color);
    }

    .count-title .icon {
        position: absolute;
        bottom: 0;
        right: 5px;
        font-size: 50px;
        opacity: 0.5;
        display: flex;
        transition: 0.2s
    }

    .count-title:hover .icon {
        opacity: 0.8;
    }


    .btn-partial {
        border-radius: 0 6px 6px 0px;
        border: 2px solid var(--primary-color);

        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .swal-button--confirm,
    .swal2-confirm {
        background-color: var(--primary-color) !important;
    }

    .swal-button--confirm:hover {
        background-color: var(--primary-color-hover) !important;
    }

    .swal-button,
    .swal2-confirm {
        transition: 0.4s
    }

    .swal-button:focus,
    .swal2-confirm:focus {
        box-shadow: 0 0 0 0 #fff, 0 0 0 0px rgba(43, 114, 165, .29)
    }

    .gap-10 {
        gap: 10px;
    }

    .collapse_arrow {
        background: #fff;
        color: var(--primary-color);
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center
    }

    .product_collapse_shadow {
        box-shadow: -2px 2px 2px 0px #087e74 !important;
        min-width: 150px;
    }

    .top-controls,
    .bottom-controls {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        padding: 10px 0;
        border-radius: 5px;
        border: 1px solid rgba(0, 0, 0, .125);
        background-color: #ffffff;
        box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
    }

    .dataTables_length label {
        display: flex;
        align-items: center;
        margin: 0%;
        flex-direction: row-reverse;
        gap: 5px;
    }

    .dataTables_filter label {
        display: flex;
        align-items: center;
        margin: 0%;
        flex-direction: row-reverse;
        gap: 5px;
    }

    .table-responsive div {
        padding: 0 !important
    }

    .collapse-btn,
    .collapse-btn:active {
        background: linear-gradient(to right, var(--primary-color), var(--primary-color-hover)) !important;
    }

    .pagination {
        margin: 0 !important
    }

    /* toggle-pill-color */
    .toggle-pill-color input[type="checkbox"] {
        display: none;
    }

    .toggle-pill-color input[type="checkbox"]+label {
        display: block;
        position: relative;
        width: 3em;
        height: 1.6em;

        border-radius: 1em;
        background: #e84d4d;
        box-shadow: inset 0px 0px 5px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        -webkit-transition: background 0.1s ease-in-out;
        transition: background 0.1s ease-in-out;
    }

    .toggle-pill-color input[type="checkbox"]+label:before {
        content: "";
        display: block;
        width: 1.2em;
        height: 1.2em;
        border-radius: 1em;
        background: #fff;
        box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.2);
        position: absolute;
        left: 0.2em;
        top: 0.2em;
        -webkit-transition: all 0.2s ease-in-out;
        transition: all 0.2s ease-in-out;
    }

    .toggle-pill-color input[type="checkbox"]:checked+label {
        background: #47cf73;
    }

    .toggle-pill-color input[type="checkbox"]:checked+label:before {
        box-shadow: -2px 0px 5px rgba(0, 0, 0, 0.2);
        left: 1.6em;
    }

    /* toggle-pill-color end */




    /* toggle-pill-color-pos */
    .toggle-pill-color-pos input[type="checkbox"] {
        display: none;
    }

    .toggle-pill-color-pos input[type="checkbox"]+label {
        display: block;
        position: relative;
        width: 2em;
        height: 1.2em;

        border-radius: 1em;
        background: #e84d4d;
        box-shadow: inset 0px 0px 5px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        -webkit-transition: background 0.1s ease-in-out;
        transition: background 0.1s ease-in-out;
    }

    .toggle-pill-color-pos input[type="checkbox"]+label:before {
        content: "";
        display: block;
        width: 0.7em;
        height: 0.7em;
        border-radius: 1em;
        background: #fff;
        box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.2);
        position: absolute;
        left: 0.2em;
        top: 0.2em;
        -webkit-transition: all 0.2s ease-in-out;
        transition: all 0.2s ease-in-out;
    }

    .toggle-pill-color-pos input[type="checkbox"]:checked+label {
        background: #47cf73;
    }

    .toggle-pill-color-pos input[type="checkbox"]:checked+label:before {
        box-shadow: -2px 0px 5px rgba(0, 0, 0, 0.2);
        left: 1.1em;
    }

    .toggle-pos-label {
        font-size: 0.75rem;
        font-weight: 500
    }

    /* toggle-pill-color end */
    .mb-11px {
        margin-bottom: 11px;
    }

    .dataTables_empty {
        color: var(--primary-color)
    }

    .divider {
        height: 0.5px;
        background: rgba(0, 0, 0, 0.15);

    }

    tfoot {
        color: var(--primary-color)
    }

    .remove-rounded {
        border-radius: 50% !important;
        width: 35px;
        height: 35px;
    }

    .gap-20px {
        gap: 20px
    }

    hr {
        margin-bottom: 0.5rem !important;
        margin-top: 0.5rem !important;
    }

    section.pos-section {
        transition: 0.3s
    }

    .shrink_pos {
        margin-left: 230px;
    }

    .wrapper1,
    .wrapper2 {
        width: 100%;
        overflow-x: scroll;
        overflow-y: hidden;
    }

    .wrapper1 {
        height: 20px;
    }

    /* .wrapper2 {
        height: 200px;
    } */

    .div1 {
        width: 1900px;

    }

    .div2 {
        width: 1900px;

        overflow: auto;
    }
</style>