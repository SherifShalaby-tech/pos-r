<header class="header pb-0">
    <nav class="navbar">
        <div class="container-fluid px-1">
            <div class="navbar-holder d-flex align-items-center justify-content-between">

                <div class="navbar-header">

                    <ul class="nav-menu list-unstyled flex-wrap d-flex flex-md-row align-items-md-center">

                        <li class="nav-item ml-1 ">
                            <a id="toggle-btn" href="#" class="menu-btn border-0 bg-primary"><img
                                    src="{{ asset('front/white-menu.png') }}" alt=""></a>
                        </li>

                        <li class="nav-item ml-1 ">
                            <a href="{{ action('SellController@create') }}" id="commercial_invoice_btn"
                                data-toggle="tooltip" data-title="@lang('lang.add_sale')" class="btn no-print"><img
                                    src="{{ asset('images/396 Commercial Invoice Icon.png') }}" alt=""
                                    style="height: 30px;">
                            </a>
                        </li>
                        <li class="nav-item ml-1 ">
                            <a target="_blank" href="https://api.whatsapp.com/send?phone={{$watsapp_numbers}}"
                                id="contact_us_btn" data-toggle="tooltip" data-title="@lang('lang.contact_us')"
                                style="background-image:  url('{{asset('images/watsapp.jpg')}}');background-size: 30px;width:35px !important"
                                class="btn no-print">
                            </a>
                            {{-- <a target="_blank" href="{{ action('ContactUsController@getUserContactUs') }}"
                                id="contact_us_btn" data-toggle="tooltip" data-title="@lang('lang.contact_us')"
                                style="background-image: url('{{ asset('images/handshake.jpg') }}');"
                                class="btn no-print">
                            </a> --}}
                        </li>
                        <li class="nav-item ml-1">
                            <button class="btn-danger btn btn-sm hide"
                                style="border-radius:8px;width: 35px;height: 35px;" id="power_off_btn"><i
                                    class="fa fa-power-off"></i></button>
                        </li>
                        <li class="nav-item ml-1 "><a id="btnFullscreen" title="Full Screen"><i
                                    class="dripicons-expand"></i></a></li>
                        @include('layouts.partials.notification_list')
                        @php
                        $config_languages = config('constants.langs');
                        $languages = [];
                        foreach ($config_languages as $key => $value) {
                        $languages[$key] = $value['full_name'];
                        }
                        @endphp
                        <li class="nav-item ml-1 ">
                            <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="nav-link p-0 dropdown-item"><i class="dripicons-web"></i>
                                <span>{{ __('lang.language') }}</span> <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                @foreach ($languages as $key => $lang)
                                <li>
                                    <a href="{{ action('GeneralController@switchLanguage', $key) }}"
                                        class="btn btn-link">
                                        {{ $lang }}</a>
                                </li>
                                @endforeach

                            </ul>
                        </li>
                        <li class="nav-item ml-1 ">
                            <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="nav-link p-0 dropdown-item"><i class="dripicons-user"></i>
                                <span>{{ ucfirst(Auth::user()->name) }}</span> <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                @php
                                $employee = App\Models\Employee::where('user_id',
                                Auth::user()->id)->first();
                                @endphp
                                <li style="text-align: center">
                                    <img src="@if (!empty($employee->getFirstMediaUrl('employee_photo'))) {{ $employee->getFirstMediaUrl('employee_photo') }}@else{{ asset('images/default.jpg') }} @endif"
                                        style="width: 60px; border: 2px solid #fff; padding: 4px; border-radius: 50%;" />
                                </li>
                                <li>
                                    <a href="{{ action('UserController@getProfile') }}"><i class="dripicons-user"></i>
                                        @lang('lang.profile')</a>
                                </li>
                                @can('settings.general_settings.view')
                                <li>
                                    <a href="{{ action('SettingController@getGeneralSetting') }}"><i
                                            class="dripicons-gear"></i> @lang('lang.settings')</a>
                                </li>
                                @endcan
                                <li>
                                    <a href="{{ url('my-transactions/' . date('Y') . '/' . date('m')) }}"><i
                                            class="dripicons-swap"></i>
                                        @lang('lang.my_transactions')</a>
                                </li>
                                @if (Auth::user()->role_id != 5)
                                <li>
                                    <a href="{{ url('my-holidays/' . date('Y') . '/' . date('m')) }}"><i
                                            class="dripicons-vibrate"></i>
                                        @lang('lang.my_holidays')</a>
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
