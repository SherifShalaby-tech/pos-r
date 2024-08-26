@php
$logo = App\Models\System::getProperty('logo');
$site_title = App\Models\System::getProperty('site_title');
$watsapp_numbers = App\Models\System::getProperty('watsapp_numbers');
@endphp
<header class="header no-print">
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
                <a id="toggle-btn" href="#" class="menu-btn"><i class="fa fa-bars" style="margin-top: 10px !important;">
                    </i></a>
                <span class="brand-big">@if($logo)<img src="{{asset('/uploads/'.$logo)}}"
                        width="50">&nbsp;&nbsp;@endif<a href="{{url('/')}}">
                        <h1 class="d-inline">{{$site_title}}</h1>
                    </a></span>

                <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                    <li class="nav-item">
                        <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"
                            class="nav-link dropdown-item d-flex justify-content-center align-items-center">
                            <span style="width: 25px;height: 25px;background-color: var(--primary-color)"
                                class="rounded-circle">
                            </span>
                        </a>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                            <li class="d-flex" style="gap: 5px">
                                <button class="border-0 d-flex justify-content-center align-items-center"
                                    onclick="changePrimaryColor('#2563eb' , '#1d4ed8')">
                                    <span style="width: 25px;height: 25px;background-color: #2563eb"
                                        class="rounded-circle">
                                    </span>
                                </button>
                                <button class="border-0 d-flex justify-content-center align-items-center"
                                    onclick="changePrimaryColor('#16a34a' , '#15803d')">
                                    <span style="width: 25px;height: 25px;background-color: #16a34a"
                                        class="rounded-circle">
                                    </span>
                                </button>
                                <button class="border-0 d-flex justify-content-center align-items-center"
                                    onclick="changePrimaryColor('#ea580c','#c2410c')">
                                    <span style="width: 25px;height: 25px;background-color: #ea580c"
                                        class="rounded-circle">
                                    </span>
                                </button>
                                <button class="border-0 d-flex justify-content-center align-items-center"
                                    onclick="changePrimaryColor('#ec4899' , '#be185d')">
                                    <span style="width: 25px;height: 25px;background-color: #ec4899"
                                        class="rounded-circle">
                                    </span>
                                </button>

                                <button class="border-0 d-flex justify-content-center align-items-center"
                                    onclick="changePrimaryColor('#dc2626','#b91c1c')">
                                    <span style="width: 25px;height: 25px;background-color: #dc2626"
                                        class="rounded-circle">
                                    </span>
                                </button>

                                <button class="border-0 d-flex justify-content-center align-items-center"
                                    onclick="changePrimaryColor('#0284c7','#0369a1')">
                                    <span style="width: 25px;height: 25px;background-color: #0284c7"
                                        class="rounded-circle">
                                    </span>
                                </button>
                                <button class="border-0 d-flex justify-content-center align-items-center"
                                    onclick="changePrimaryColor('#475569','#334155')">
                                    <span style="width: 25px;height: 25px;background-color: #475569"
                                        class="rounded-circle">
                                    </span>
                                </button>
                                <button class="border-0 d-flex justify-content-center align-items-center"
                                    onclick="changePrimaryColor('#14b8a6','#0d9488')">
                                    <span style="width: 25px;height: 25px;background-color: #14b8a6"
                                        class="rounded-circle">
                                    </span>
                                </button>
                                <button class="border-0 d-flex justify-content-center align-items-center"
                                    onclick="changePrimaryColor('#eab308','#c8b400')">
                                    <span style="width: 25px;height: 25px;background-color: #eab308"
                                        class="rounded-circle">
                                    </span>
                                </button>
                                <button class="border-0 d-flex justify-content-center align-items-center"
                                    onclick="changePrimaryColor('#4f46e5','#3730a3')">
                                    <span style="width: 25px;height: 25px;background-color: #4f46e5"
                                        class="rounded-circle">
                                    </span>
                                </button>
                            </li>


                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{action('SellController@create')}}" id="commercial_invoice_btn" data-toggle="tooltip"
                            data-title="@lang('lang.add_sale')" class="btn no-print"><img
                                src="{{asset('images/396 Commercial Invoice Icon.png')}}" alt=""
                                style="height: 40px; width: 35px;">
                        </a>
                    </li>
                    <li class="nav-item">
                        {{-- <a target="_blank" href="{{action('ContactUsController@getUserContactUs')}}"
                            id="contact_us_btn" data-toggle="tooltip" data-title="@lang('lang.contact_us')"
                            style="background-image: url('{{asset('images/handshake.jpg')}}');" class="btn no-print">
                        </a> --}}
                        <a target="_blank" href="https://api.whatsapp.com/send?phone={{$watsapp_numbers}}"
                            id="contact_us_btn" data-toggle="tooltip" data-title="@lang('lang.contact_us')"
                            style="background-image: url('{{asset('images/watsapp.jpg')}}');background-size: 40px;"
                            class="btn no-print">
                        </a>
                    </li>
                    <li class="nav-item"><button class="btn-danger btn-sm hide" id="power_off_btn" data-toggle="tooltip"
                            data-title="@lang('lang.shut_down')"><i class="fa fa-power-off"></i></button></li>
                    @can('sale.pos.create_and_edit')
                    <li class="nav-item"><a class="dropdown-item btn-pos btn-sm"
                            href="{{action('SellPosController@create')}}"><i class="dripicons-shopping-bag"></i><span>
                                @lang('lang.pos')</span></a></li>
                    @endcan
                    <li class="nav-item"><a id="btnFullscreen"><i class="dripicons-expand"></i></a></li>
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
                            aria-expanded="false" class="nav-link dropdown-item"><i class="dripicons-web"></i>
                            <span>{{__('lang.language')}}</span> <i class="fa fa-angle-down"></i></a>
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
                            aria-expanded="false" class="nav-link dropdown-item"><i class="dripicons-user"></i>
                            <span>{{ucfirst(Auth::user()->name)}}</span> <i class="fa fa-angle-down"></i>
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
