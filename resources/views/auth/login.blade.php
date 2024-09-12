@extends('layouts.login')

@section('content')
@php
$logo = App\Models\System::getProperty('logo');
$site_title = App\Models\System::getProperty('site_title');
$config_languages = config('constants.langs');
$languages = [];
foreach ($config_languages as $key => $value) {
$languages[$key] = $value['full_name'];
}
$version_number = App\Models\System::getProperty('version_number');
$version_update_datatime = App\Models\System::getProperty('version_update_date');
@endphp
<div class="app app-login p-0" style="height: 100vh">
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center pt-5 px-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4"><a class="app-logo" href="">
                            @if($logo)<img src="{{asset('/uploads/'.$logo)}}" width="200">&nbsp;&nbsp;@endif</a></div>
                    @if(session()->has('delete_message'))
                    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
                            data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{
                        session()->get('delete_message') }}</div>
                    @endif
                    <h6 style="color: var(--primary-color) !important">@lang('lang.version'): {{$version_number}}</h6>
                    <h6 style="color: var(--primary-color) !important">@lang('lang.last_update'):
                        @if(!empty($version_update_datatime)){{\Carbon\Carbon::createFromTimestamp(strtotime($version_update_datatime))->format('d-M-Y
                        H:i a')}}@endif</h6>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" style="color: gray" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('lang.language')
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach ($languages as $key => $lang)
                            <a class="dropdown-item" href="{{action('GeneralController@switchLanguage', $key) }}">
                                {{$lang}}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="auth-form-container text-start">

                        <form class="auth-form login-form" method="POST" action="{{ route('login') }}" id="login-form">
                            @csrf
                            <div class="email mb-3">
                                <label class="sr-only" for="signin-email">Email</label>
                                <input id="email" type="email" name="email" required class="input-material" value=""
                                    placeholder="{{trans('lang.email')}}">
                            </div>
                            <!--//form-group-->
                            <div class="password mb-3">
                                <label class="sr-only" for="signin-password">Password</label>
                                <input id="password" type="password" name="password" required class="input-material"
                                    value="" placeholder="{{trans('lang.password')}}">
                                @if ($errors->has('email'))
                                <p style="color:red">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </p>

                                @endif
                                <div class="extra mt-3 row justify-content-between">
                                    <div class="col-6">
                                        <div class="form-check">
                                            <a
                                                href="{{action('ContactUsController@getContactUs')}}">@lang('lang.contact_us')</a>
                                        </div>
                                    </div>
                                    <!--//col-6-->
                                    <div class="col-6">
                                        <div class="forgot-password text-end">
                                            <a href="{{ route('password.request') }}"
                                                class="forgot-pass">{{trans('lang.forgot_passowrd')}}</a>
                                        </div>
                                    </div>
                                    <!--//col-6-->
                                </div>
                                <!--//extra-->
                            </div>
                            <!--//form-group-->
                            <div class="text-center">
                                <button type="submit"
                                    class="btn btn-primary w-100 theme-btn mx-auto">{{trans('lang.login')}}</button>
                            </div>
                            <footer class="">
                                <div class="container text-center py-3">
                                    <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
                                    <div class="copyrights text-center">
                                        <p>&copy; {{App\Models\System::getProperty('site_title')}} | <span
                                                class="">@lang('lang.developed_by')
                                                <a target="_blank"
                                                    href="http://sherifshalaby.tech">sherifshalaby.tech</a></span>
                                        </p>
                                        <p>
                                            <a href="mailto:info@sherifshalaby.tech">info@sherifshalaby.tech</a>
                                        </p>
                                    </div>
                                </div>
                            </footer>
                        </form>


                    </div>
                    <!--//auth-form-container-->

                </div>
                <!--//auth-body-->

                <!--//app-auth-footer-->
            </div>
            <!--//flex-column-->
        </div>
        <!--//auth-main-col-->
        <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
            <div class="auth-background-holder">
            </div>
            <div class="auth-background-mask"></div>

            <!--//auth-background-overlay-->
        </div>
        <!--//auth-background-col-->

    </div>
    <!--//row-->
</div>
@endsection
