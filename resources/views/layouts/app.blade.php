<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.partials.css')
    @yield('styles')
    @livewireStyles
</head>

<body onload="myFunction()">
    <div id="loader"></div>
    @if (request()->segment(1) != 'pos')
        @include('layouts.partials.header')
    @endif
    <div class="@if (request()->segment(1) != 'pos') page @else pos-page @endif">
        @include('layouts.partials.sidebar')
        <div style="display:none" id="content" class="animate-bottom">
            @foreach ($errors->all() as $message)
                <div class="alert alert-danger alert-dismissible text-center">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>{{ $message }}
                </div>
            @endforeach
            <input type="hidden" id="__language" value="{{ session('language') }}">
            <input type="hidden" id="__decimal" value=".">
            <input type="hidden" id="__currency_precision" value="2">
            <input type="hidden" id="__currency_symbol" value="$">
            <input type="hidden" id="__currency_thousand_separator" value=",">
            <input type="hidden" id="__currency_symbol_placement" value="before">
            <input type="hidden" id="__precision" value="3">
            <input type="hidden" id="__quantity_precision" value="3">
            <input type="hidden" id="system_mode" value="{{ env('SYSTEM_MODE') }}">
            @yield('content')
        </div>

        @include('layouts.partials.footer')


        <div class="modal view_modal no-print" role="dialog" aria-hidden="true"></div>
        <div class="modal" id="cropper_modal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.crop_image_before_upload')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <img src="" id="sample_image" />
                                </div>
                                <div class="col-md-4">
                                    <div class="preview_div"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="crop" class="btn btn-primary">@lang('lang.crop')</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        @php
            $cash_register = App\Models\CashRegister::where('user_id', Auth::user()->id)
                ->where('status', 'open')
                ->first();
        @endphp
        <input type="hidden" name="is_register_close" id="is_register_close"
            value="@if (!empty($cash_register)) {{ 0 }}@else{{ 1 }} @endif">
        <input type="hidden" name="cash_register_id" id="cash_register_id"
            value="@if (!empty($cash_register)) {{ $cash_register->id }} @endif">
        <div id="closing_cash_modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
            class="modal text-left">
        </div>

        <!-- This will be printed -->
        <section class="invoice print_closing_cash print-only" id="print_closing_cash"> </section>
    </div>

    <script type="text/javascript">
        base_path = "{{ url('/') }}";
        current_url = "{{ url()->current() }}";
    </script>

    @include('layouts.partials.currencies_obj')
    @include('layouts.partials.javascript')

    @yield('javascript')
    @stack('javascripts')
    @livewireScripts
</body>

</html>
