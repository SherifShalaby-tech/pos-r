@php
$logo = App\Models\System::getProperty('logo');
$site_title = App\Models\System::getProperty('site_title');
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$site_title}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow" />
    <link rel="manifest" href="{{url('manifest.json')}}">
    <link rel="icon" type="image/png" href="{{asset('/uploads/'.$logo)}}" />
    <!-- Bootstrap CSS-->
    @include('layouts.partials.css')
    <link rel="stylesheet" href="{{asset('css/portal.css')}}" type="text/css">
    <style>
        .app-login .auth-background-holder {
            background: url('uploads/login7.jpg');
            background-repeat: no-repeat;
            background-size: cover
        }

        .auth-background-mask {
            background: #0006;
        }

        :root {
            --primary-color: #4f46e5;
            --primary-color-hover: #362ebd;
        }

        ..text-primary {
            color: var(--primary-color) !important
        }

        .btn-primary {
            --bs-btn-color: #fff;
            --bs-btn-bg: var(--primary-color);
            --bs-btn-border-color: var(--primary-color);
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: var(--primary-color-hover);
            --bs-btn-hover-border-color: var(--primary-color-hover);
            --bs-btn-focus-shadow-rgb: 18, 139, 83;
            --bs-btn-active-color: #000;
            --bs-btn-active-bg: var(--primary-color-hover);
            --bs-btn-active-border-color: var(--primary-color-hover);
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #000;
            --bs-btn-disabled-bg: var(--primary-color);
            --bs-btn-disabled-border-color: var(--primary-color);
        }
    </style>
</head>

<body>
    <input type="hidden" id="__language" value="{{session('language')}}">


    <div class="page login-page"> @yield('content') </div>


    <script type="text/javascript">
        base_path = "{{url('/')}}";
    </script>
    @include('layouts.partials.javascript-auth')
    @yield('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
                loadPrimaryColor();
                setTimeout(showPage, 150);
                });

                function showPage() {
                document.getElementById("loader").style.display = "none";
                document.getElementById("content").style.display = "block";
                }

                function changePrimaryColor(color , hoverColor) {

                document.documentElement.style.setProperty('--primary-color', color);
                document.documentElement.style.setProperty('--primary-color-hover', hoverColor);
                localStorage.setItem('rest-primaryColor', color);
                localStorage.setItem('rest-primaryColorHover', hoverColor);
                }

                function loadPrimaryColor() {
                const savedColor = localStorage.getItem('rest-primaryColor');
                const savedColorHover = localStorage.getItem('rest-primaryColorHover');
                if (savedColor) {
                document.documentElement.style.setProperty('--primary-color', savedColor);
                document.documentElement.style.setProperty('--primary-color-hover', savedColorHover);
                }
                }
    </script>
</body>

</html>