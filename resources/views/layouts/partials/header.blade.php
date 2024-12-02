@php
$logo = App\Models\System::getProperty('logo');
$site_title = App\Models\System::getProperty('site_title');
$watsapp_numbers = App\Models\System::getProperty('watsapp_numbers');
@endphp

@php

$colors = [
// Slate
"#f8fafc", "#f1f5f9", "#e2e8f0", "#cbd5e1", "#94a3b8", "#64748b", "#475569", "#334155", "#1e293b", "#0f172a",
// Gray
"#f9fafb", "#f3f4f6", "#e5e7eb", "#d1d5db", "#9ca3af", "#6b7280", "#4b5563", "#374151", "#1f2937", "#111827",

// Stone
"#fafaf9", "#f5f5f4", "#e7e5e4", "#d6d3d1", "#a8a29e", "#78716c", "#57534e", "#44403c", "#292524", "#1c1917",
// Red
"#fef2f2", "#fee2e2", "#fecaca", "#fca5a5", "#f87171", "#ef4444", "#dc2626", "#b91c1c", "#991b1b", "#7f1d1d",
// Orange
"#fff7ed", "#ffedd5", "#fed7aa", "#fdba74", "#fb923c", "#f97316", "#ea580c", "#c2410c", "#9a3412", "#7c2d12",
// Amber
"#fffbeb", "#fef3c7", "#fde68a", "#fcd34d", "#fbbf24", "#f59e0b", "#d97706", "#b45309", "#92400e", "#78350f",
// Yellow
"#fefce8", "#fef9c3", "#fef08a", "#fde047", "#facc15", "#eab308", "#ca8a04", "#a16207", "#854d0e", "#713f12",
// Lime
"#f7fee7", "#ecfccb", "#d9f99d", "#bef264", "#a3e635", "#84cc16", "#65a30d", "#4d7c0f", "#3f6212", "#365314",
// Green
"#f0fdf4", "#dcfce7", "#bbf7d0", "#86efac", "#4ade80", "#22c55e", "#16a34a", "#15803d", "#166534", "#14532d",
// Emerald
"#ecfdf5", "#d1fae5", "#a7f3d0", "#6ee7b7", "#34d399", "#10b981", "#059669", "#047857", "#065f46", "#064e3b",
// Teal
"#f0fdfa", "#ccfbf1", "#99f6e4", "#5eead4", "#2dd4bf", "#14b8a6", "#0d9488", "#0f766e", "#115e59", "#134e4a",
// Cyan
"#ecfeff", "#cffafe", "#a5f3fc", "#67e8f9", "#22d3ee", "#06b6d4", "#0891b2", "#0e7490", "#155e75", "#164e63",
// Sky
"#f0f9ff", "#e0f2fe", "#bae6fd", "#7dd3fc", "#38bdf8", "#0ea5e9", "#0284c7", "#0369a1", "#075985", "#0c4a6e",
// Blue
"#eff6ff", "#dbeafe", "#bfdbfe", "#93c5fd", "#60a5fa", "#3b82f6", "#2563eb", "#1d4ed8", "#1e40af", "#1e3a8a",
// Indigo
"#eef2ff", "#e0e7ff", "#c7d2fe", "#a5b4fc", "#818cf8", "#6366f1", "#4f46e5", "#4338ca", "#3730a3", "#312e81",
// Violet
"#f5f3ff", "#ede9fe", "#ddd6fe", "#c4b5fd", "#a78bfa", "#8b5cf6", "#7c3aed", "#6d28d9", "#5b21b6", "#4c1d95",
// Purple
"#faf5ff", "#f3e8ff", "#e9d5ff", "#d8b4fe", "#c084fc", "#a855f7", "#9333ea", "#7e22ce", "#6b21a8", "#581c87",
// Fuchsia
"#fdf4ff", "#fae8ff", "#f5d0fe", "#f0abfc", "#e879f9", "#d946ef", "#c026d3", "#a21caf", "#86198f", "#701a75",
// Pink
"#fdf2f8", "#fce7f3", "#fbcfe8", "#f9a8d4", "#f472b6", "#ec4899", "#db2777", "#be185d", "#9d174d", "#831843",
// Rose
"#fff1f2", "#ffe4e6", "#fecdd3", "#fda4af", "#fb7185", "#f43f5e", "#e11d48", "#be123c", "#9f1239", "#881337"
];
@endphp

<header class="header no-print py-1"
    style="background: linear-gradient(to right, var(--primary-color), var(--primary-color-hover));">
    <nav class="navbar">
        <div class="container-fluid px-2">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
                <a id="toggle-btn" href="#" class="menu-btn border-0">
                    <img src="{{ asset('front/white-menu.png') }}" alt=""></a>
                <span class="brand-big">@if($logo)<img src="{{asset('/uploads/'.$logo)}}"
                        width="50">&nbsp;&nbsp;@endif<a href="{{url('/')}}">
                        <h1 class="d-inline text-white">{{$site_title}}</h1>
                    </a></span>

                <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                    <li class="nav-item">
                        <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"
                            class="nav-link dropdown-item bg-white d-flex justify-content-center align-items-center px-2"
                            style="border-radius: 8px;height: 35px;">
                            <span style="width: 25px;height: 25px;background-color: var(--primary-color)"
                                class="rounded-circle">
                            </span>
                        </a>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                            <li class="d-flex flex-wrap" style="gap: 5px">

                                <div class="container">
                                    @foreach($colors as $index => $color)
                                    @if($index % 10 == 0)
                                    <div class="d-flex">
                                        @endif
                                        <div class=" mb-1 ">
                                            <button
                                                class="border-0 bg-transparent d-flex justify-content-center align-items-center"
                                                onclick="changePrimaryColor('{{ $color }}' ,'{{$color }}' )">
                                                <span
                                                    style="width: 25px; height: 25px; background-color: {{ $color }};border:1px solid #aaa"
                                                    class="rounded-circle">
                                                </span>
                                            </button>
                                        </div>
                                        @if($index % 10 == 9 || $loop->last)
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </li>
                        </ul>
                    </li>



                    <li class="nav-item ">
                        <a href="{{action('SellController@create')}}" id="commercial_invoice_btn" data-toggle="tooltip"
                            data-title="@lang('lang.add_sale')"
                            class="btn no-print d-flex justify-content-center align-items-center bg-white px-2"
                            style="border-radius: 8px;height: 35px;">


                            <div style="width: 13px;height: 18px;" class="mb-1">
                                <img src="{{ asset('front/images/icons Png/hed/Icon awesome-file-invoice.png') }}"
                                    alt="@lang('lang.add_sale')" style="width: 100%;height: 100%;">
                            </div>

                            <span class="ml-2 text-bold">@lang('lang.invoice')</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        {{-- <a target="_blank" href="{{action('ContactUsController@getUserContactUs')}}"
                            id="contact_us_btn" data-toggle="tooltip" data-title="@lang('lang.contact_us')"
                            style="background-image: url('{{asset('images/handshake.jpg')}}');" class="btn no-print">
                        </a> --}}
                        <a target="_blank" href="https://api.whatsapp.com/send?phone={{$watsapp_numbers}}"
                            id="contact_us_btn" data-toggle="tooltip" data-title="@lang('lang.contact_us')"
                            class="btn bg-white no-print d-flex justify-content-center align-items-center"
                            style="border-radius:8px;width: 35px;height: 35px;">
                            <img style="width: 100%" src="{{ asset('images/watsapp.jpg') }}"
                                alt="@lang('lang.contact_us')">
                        </a>
                    </li>


                    <li class="nav-item">
                        <button style="border-radius:8px;width: 35px;height: 35px;"
                            class="btn hide bg-danger text-white no-print d-flex justify-content-center align-items-center"
                            id="power_off_btn" data-toggle="tooltip" data-title="@lang('lang.shut_down')"><i
                                class="fa fa-power-off"></i></button>
                    </li>




                    @can('sale.pos.create_and_edit')
                    <li class="nav-item">
                        <a class="d-flex justify-content-center align-items-center bg-white px-2 btn"
                            style="border-radius: 8px;height: 35px;" href="{{action('SellPosController@create')}}">
                            <div style="width: 26px;height: 26px;" class="mb-0">

                                <img src="{{ asset('front/images/cash-machine.png') }}" alt=""
                                    style="width: 100%;height: 100%;">
                            </div>
                            <span class="ml-2 text-bold">
                                @lang('lang.pos')</span>
                        </a>
                    </li>

                    @endcan


                    <li class="nav-item"><a id="btnFullscreen" style="border-radius:8px;width: 35px;height: 35px;"
                            class="btn bg-white no-print d-flex justify-content-center align-items-center"><i
                                class="dripicons-expand m-0"></i></a>
                    </li>


                    @include('layouts.partials.notification_list')
                    @php
                    $config_languages = config('constants.langs');
                    $languages = [];
                    foreach ($config_languages as $key => $value) {
                    $languages[$key] = $value['full_name'];
                    }
                    @endphp
                    <li class="nav-item">
                        <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"
                            class="d-flex justify-content-center align-items-center bg-white px-2 btn"
                            style="border-radius: 8px;height: 35px;">
                            <i class="dripicons-web m-0 text-black"></i>
                            {{-- <i class="dripicons-web"></i>
                            <span>{{__('lang.language')}}</span>
                            <i class="fa fa-angle-down"></i> --}}
                        </a>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                            @foreach ($languages as $key => $lang)
                            <li>
                                <a href="{{action('GeneralController@switchLanguage', $key) }}" class="btn btn-link">
                                    {{$lang}}</a>
                            </li>
                            @endforeach

                        </ul>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="dropdown-item" href="{{action('HomeController@getHelp')}}" target="_blank"><i
                                class="dripicons-information"></i> @lang('lang.help')</a>
                    </li> --}}
                    <li class="nav-item">
                        <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"
                            class="d-flex justify-content-center align-items-center bg-white px-2 btn"
                            style="border-radius: 8px;height: 35px;">
                            <div style="width: 15px;height: 18px;">
                                <img src="{{ asset('front/images/icons Png/hed/Icon awesome-user-alt.png') }}" alt=""
                                    style="width: 100%;height: 100%;">
                            </div>
                            {{-- <i class="dripicons-user"></i>
                            <span>{{ucfirst(Auth::user()->name)}}</span>
                            <i class="fa fa-angle-down"></i> --}}
                        </a>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                            @php
                            $employee = App\Models\Employee::where('user_id', Auth::user()->id)->first();
                            @endphp
                            <li style="text-align: center">
                                <img src="@if(!empty($employee->getFirstMediaUrl('employee_photo'))){{$employee->getFirstMediaUrl('employee_photo')}}@else{{asset('images/default.jpg')}}@endif"
                                    style="width: 60px; border: 2px solid #fff; padding: 4px; border-radius: 50%;" />
                            </li>
                            <li>
                                <a href="{{action('UserController@getProfile')}}"><i class="dripicons-user"></i>
                                    @lang('lang.profile')</a>
                            </li>
                            @can('settings.general_settings.view')
                            <li>
                                <a href="{{action('SettingController@getGeneralSetting')}}"><i
                                        class="dripicons-gear"></i> @lang('lang.settings')</a>
                            </li>
                            @endcan
                            <li>
                                <a href="{{url('my-transactions/'.date('Y').'/'.date('m'))}}"><i
                                        class="dripicons-swap"></i> @lang('lang.my_transactions')</a>
                            </li>
                            @if(Auth::user()->role_id != 5)
                            <li>
                                <a href="{{url('my-holidays/'.date('Y').'/'.date('m'))}}"><i
                                        class="dripicons-vibrate"></i> @lang('lang.my_holidays')</a>
                            </li>
                            @endif

                            <li>
                                <a href="#" id="logout-btn"><i class="dripicons-power"></i>
                                    @lang('lang.logout')
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>