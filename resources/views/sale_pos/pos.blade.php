@extends('layouts.app')
@section('title', __('lang.pos'))
@section('styles')
<style>
    .btn-group-custom .btn {
        font-size: 13px !important;
        min-width: 13% !important;
        margin: 2px 5px;
        text-align: center !important;
        overflow: initial;
        width: auto !important;
    }

    .checkboxes input[type=checkbox] {
        width: 140%;
        height: 140%;
        accent-color: var(--primary-color);
    }

    /* Styling for the Offcanvas */
    .offcanvas {
        position: fixed;
        top: 0;
        right: -100%;
        width: 300px;
        height: 100%;
        background-color: #f8f9fa;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
        transition: right 0.3s ease;
        z-index: 1050;
        padding: 20px;
        overflow-y: auto;
    }

    .offcanvas.open {
        right: 0;
    }

    /* Backdrop */
    .offcanvas-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1040;
        display: none;
    }

    .offcanvas-backdrop.show {
        display: block;
    }

    /* Toggle and Close Buttons */
    .offcanvas-toggle {
        padding: 10px 20px;
        cursor: pointer;
        background-color: var(--primary-color);
        color: white;
        border: none;
        font-size: 16px;
    }

    .offcanvas-close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        cursor: pointer;
        background: none;
        border: none;
        color: black;

    }

    body.offcanvas-open {
        overflow: hidden;
    }
</style>

@endsection
@section('content')
@php
$watsapp_numbers = App\Models\System::getProperty('watsapp_numbers');
@endphp
<section class="forms pos-section no-print">
    <div class="container-fluid px-0">

        <div class="d-flex">
            <audio id="mysoundclip1" preload="auto">
                <source src="{{ asset('audio/beep-timber.mp3') }}">
                </source>
            </audio>
            <audio id="mysoundclip2" preload="auto">
                <source src="{{ asset('audio/beep-07.mp3') }}">
                </source>
            </audio>
            <audio id="mysoundclip3" preload="auto">
                <source src="{{ asset('audio/beep-long.mp3') }}">
                </source>
            </audio>


            {!! Form::open(['url' => action('SellPosController@store'), 'method' => 'post', 'files' => true, 'class'
            => 'pos-form d-flex', 'id' => 'add_pos_form']) !!}
            <div class="px-1  col-md-10 ">
                <div class="card m-0">

                    <input type="hidden" name="default_customer_id" id="default_customer_id"
                        value="@if (!empty($walk_in_customer)) {{ $walk_in_customer->id }} @endif">
                    <input type="hidden" name="row_count" id="row_count" value="0">
                    <input type="hidden" name="customer_size_id_hidden" id="customer_size_id_hidden" value="">
                    {{-- <input type="hidden" name="enable_the_table_reservation" id="enable_the_table_reservation"
                        value="{{ App\Models\System::getProperty('enable_the_table_reservation') }}"> --}}
                    <div class="d-flex flex-wrap">

                        @include('sale_pos.includes._main-settings')


                        <div class="col-md-12 main_settings">
                            <div class="d-flex justify-content-between align-items-end">

                                <div class="d-flex col-md-8 align-items-end px-0 table_room_hide" style="gap: 10px">

                                    <div class="col-md-3 px-0">
                                        {!! Form::label('customer_id', __('lang.customer'), [
                                        'class' => app()->isLocale('ar') ? 'mb-0 label-ar' : 'mb-0 label-en'
                                        ]) !!}
                                        <div class="input-group my-group">
                                            {!! Form::select('customer_id', $customers, !empty($walk_in_customer) ?
                                            $walk_in_customer->id : null, ['class' => 'selectpicker form-control',
                                            'data-live-search' => 'true', 'style' => 'width: 80%', 'id' =>
                                            'customer_id', 'required']) !!}
                                            <span class="input-group-btn">
                                                @can('customer_module.customer.create_and_edit')
                                                <a class="btn-modal btn-primary btn btn-partial"
                                                    data-href="{{ action('CustomerController@create') }}?quick_add=1"
                                                    data-container=".view_modal"><i
                                                        class="fa fa-plus-circle text-white fa-lg"></i></a>
                                                @endcan
                                            </span>
                                        </div>
                                    </div>

                                    <div class=" d-flex justify-content-between align-items-center" style="gap: 10px">

                                        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
                                            style="padding: 5px;min-width: 100px;">
                                            <label class="text-center text-primary w-100 px-3 bg-white rounded"
                                                style="font-weight:600" for="
                                                customer_type_name">@lang('lang.customer_type')</label>
                                            <span style="font-size: 12px !important;font-weight: 600 !important;"
                                                class="customer_type_name"></span>
                                        </div>

                                        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
                                            style="padding: 5px;min-width: 100px;">
                                            <label class="text-center text-primary w-100 px-3 bg-white rounded"
                                                style="font-weight:600"
                                                for="customer_balance">@lang('lang.balance')</label>
                                            <span style="font-size: 12px !important;font-weight: 600 !important;"
                                                class="customer_balance">{{ @num_format(0) }}</span>
                                        </div>

                                        <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
                                            style="padding: 5px;min-width: 100px;">
                                            <label class="text-center text-primary w-100 px-3 bg-white rounded"
                                                style="font-weight:600" for="points">@lang('lang.points')</label>

                                            <span style="font-size: 12px !important;font-weight: 600 !important;"
                                                class="points"><span class="customer_points_span">{{ @num_format(0)
                                                    }}</span></span>
                                            <span class="staff_note small"></span>
                                        </div>
                                    </div>

                                    <div class="px-0">
                                        @if (session('system_mode') == 'pos' || session('system_mode') == 'restaurant')
                                        <button type="button" class="btn btn-danger mb-1 mt-1 mb-xl-1 w-100"
                                            data-toggle="modal"
                                            data-target="#non_identifiable_item_modal">@lang('lang.non_identifiable_item')</button>
                                        @endif

                                        <button type="button" class="btn btn-primary w-100" data-toggle="modal"
                                            data-target="#contact_details_modal">@lang('lang.details')</button>
                                    </div>
                                </div>

                                @include('sale_pos.includes._search-product')



                                <div class="row table_room_show hide col-md-8">
                                    <div class="col-md-3 d-flex justify-content-center align-items-center">
                                        <div class="w-100"
                                            style="padding: 5px 5px; background:#0082ce; color: #fff; font-size: 20px; font-weight: bold; text-align: center; border-radius: 5px;">
                                            <span class="room_name"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3 d-flex flex-column">
                                        <input type="hidden" id="room_id" name="dining_room_id" />
                                        <label for=""
                                            style="font-size: 20px !important; font-weight: bold; text-align: center; margin-top: 3px;">@lang('lang.table'):
                                            <span class="table_name"></span></label>
                                        <div class="form-check tables_status">
                                            {{-- @if($status_array)
                                            @foreach($status_array as $status)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input table_status" type="radio" name="order"
                                                    id="{{$status->order}}" value="{{$status->order}}" checked>
                                                <label class="form-check-label"
                                                    for="{{$status->order}}">{{$status->order}}</label>
                                            </div>
                                            @endforeach
                                            @endif --}}

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group my-group">
                                            {!! Form::select('service_fee_id', $service_fees, null, ['class' =>
                                            'form-control', 'placeholder' => __('lang.select_service'), 'id' =>
                                            'service_fee_id']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group my-group">
                                            {!! Form::select('merge_table_id', $tables, null, ['class' =>
                                            'form-control', 'placeholder' => __('lang.select_merge_table'), 'id' =>
                                            'table_merge_id']) !!}
                                        </div>
                                    </div>
                                    <input type="hidden" name="service_fee_id_hidden" id="service_fee_id_hidden"
                                        value="">
                                    <input type="hidden" name="service_fee_rate" id="service_fee_rate" value="0">
                                    <input type="hidden" name="service_fee_value" id="service_fee_value" value="0">
                                </div>
                            </div>




                            @include('sale_pos.includes._product-table')


                            @include('sale_pos.includes._hidden-inputs')


                            @include('sale_pos.includes._totals')



                            <div class="col-md-12 table_room_show hide"
                                style="border-top: 2px solid #e4e6fc; margin-top: 10px;">
                                <div class="row">

                                    <div class="col-md-12 row justify-content-center align-items-center">
                                        <div class="row col-md-3 justify-content-center align-items-center">
                                            <b>@lang('lang.total'): <span class="subtotal">0.00</span></b>
                                        </div>
                                        <div class="row col-md-3 justify-content-center align-items-center">
                                            <b>@lang('lang.discount'): <span class="discount_span">0.00</span></b>
                                        </div>
                                        <div class="row col-md-3 justify-content-center align-items-center">
                                            <b>@lang('lang.service'): <span class="service_value_span">0.00</span></b>
                                        </div>
                                        <div class="row col-md-3 justify-content-center align-items-center">
                                            <b>@lang('lang.grand_total'): <span class="final_total_span">0.00</span></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-md-12">
                                        <div class="row justify-content-center">
                                            <button type="button" name="action" value="print" id="dining_table_print"
                                                class="btn py-2 col-md-2 mr-2 btn-primary text-white">@lang('lang.print')</button>
                                            <button type="button" name="action" value="save" id="dining_table_save"
                                                class="btn py-2 col-md-2 mr-2 text-white btn-primary">@lang('lang.save')</button>
                                            <button data-method="cash" type="button"
                                                class="btn py-2 col-md-2 mr-2 btn-primary payment-btn text-white"
                                                data-toggle="modal" data-target="#add-payment" data-backdrop="static"
                                                data-keyboard="false" id="cash-btn">@lang('lang.pay_and_close')</button>
                                            @if(auth()->user()->can('sp_module.sales_promotion.view')
                                            || auth()->user()->can('sp_module.sales_promotion.create_and_edit')
                                            || auth()->user()->can('sp_module.sales_promotion.delete'))
                                            <button type="button"
                                                class="btn py-2 col-md-2 mr-2 btn-md btn-primary payment-btn text-white"
                                                data-toggle="modal"
                                                data-target="#discount_modal">@lang('lang.random_discount')</button>
                                            @endif

                                            <button type="button" class="btn py-2 col-md-2 btn-danger text-white"
                                                id="cancel-btn" onclick="return confirmCancel()">
                                                @lang('lang.cancel')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="payment-amount table_room_hide">
                        <h2 class="bg-primary text-white">{{ __('lang.grand_total') }} <span
                                class="final_total_span">0.00</span></h2>
                    </div>
                    @php
                    $default_invoice_toc = App\Models\System::getProperty('invoice_terms_and_conditions');
                    if (!empty($default_invoice_toc)) {
                    $toc_hidden = $default_invoice_toc;
                    } else {
                    $toc_hidden = array_key_first($tac);
                    }
                    @endphp
                    <input type="hidden" name="terms_and_condition_hidden" id="terms_and_condition_hidden"
                        value="{{ $toc_hidden }}">



                    @include('sale_pos.includes._terms')



                </div>
            </div>



            <div class="card m-0 px-1  col-md-2 ">
                <!-- navbar-->

                @include('sale_pos.includes._header')

                @include('sale_pos.includes._payment-options')


                <div id="offcanvas" class="offcanvas">
                    <button id="offcanvas-close" type="button" class="offcanvas-close">×</button>
                    <h2>Products</h2>

                    @include('sale_pos.partials.right_side')
                </div>





            </div>






            @include('sale_pos.partials.payment_modal')
            @include('sale_pos.partials.deposit_modal')
            @include('sale_pos.partials.discount_modal')

            {{-- @include('sale_pos.partials.tax_modal') --}}
            @include('sale_pos.partials.delivery_cost_modal')
            @include('sale_pos.partials.coupon_modal')
            @include('sale_pos.partials.contact_details_modal')
            @include('sale_pos.partials.weighing_scale_modal')
            @include('sale_pos.partials.non_identifiable_item_modal')
            @include('sale_pos.partials.customer_sizes_modal')
            @include('sale_pos.partials.sale_note')

            {!! Form::close() !!}


            <!-- product list -->


            <!-- recent transaction modal -->
            @include('sale_pos.includes._recent-transaction')

            <!-- draft transaction modal -->
            @include('sale_pos.includes._draft-transaction')

            <!-- onlineOrder transaction modal -->
            @include('sale_pos.includes._online-order-transaction')



            <div id="dining_model" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                class="modal text-left">
                @include('sale_pos.partials.dining_modal')
            </div>

            <div id="dining_table_action_modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                class="modal fade text-left">

            </div>
        </div>
    </div>

</section>

@include('sale_pos.includes._product-extension')

<!-- This will be printed -->
<section class="invoice print_section print-only" id="receipt_section"> </section>
@endsection

@section('javascript')
<script src="{{ asset('js/onscan.min.js') }}"></script>
<script src="{{ asset('js/pos.js') }}"></script>
<script src="{{ asset('js/dining_table.js') }}"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    // $('.room-badge3').text("hihh")
        $('.close_btn_product_extension').click(function () {
            $('#product_extension').removeClass('view_modal no-print show');
            $('#product_extension').hide();
        });
        $(document).ready(function() {
            $('.online-order-badge').hide();
            $('.table-badge').hide();
            $('.selected-table-badge').hide();
            $('.room-count-badge').hide();

        })
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        var obj = new Object();
        var objRoom = new Object();
        var notificationContents = [];
        var notificationRoomContents = [];
        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });
        var channel = pusher.subscribe('order-channel');
        var transaction_id =0;
        channel.bind('new-order', function(data) {
            if(data.table_no && data.table_no!=="not exist"){
                var notificationContents = sessionStorage.getItem('notificationContents');
                var notificationRoomContents = sessionStorage.getItem('notificationRoomContents');
                obj.table_no = data.table_no;
                obj.table_count = 1;
                objRoom.room_no = data.room_no;
                objRoom.room_count =1;
                var isTableExist=0;
                var isRoomExist=0;
                if (!notificationContents) { // check if an item is already registered
                    notificationContents = []; // if not, we initiate an empty array
                } else {
                    notificationContents = JSON.parse(notificationContents); // else parse whatever is in
                    notificationContents.forEach((element, index) => {
                        if(element.table_no === data.table_no) {
                            element.table_count =element.table_count+1;
                            isTableExist=1;
                            return;
                        }
                    });
                }
                if (!notificationRoomContents) { // check if an item is already registered
                    notificationRoomContents = []; // if not, we initiate an empty array
                } else {
                    notificationRoomContents = JSON.parse(notificationRoomContents); // else parse whatever is in
                    notificationRoomContents.forEach((element, index) => {
                        if( element.room_no === data.room_no) {
                            element.room_count =element.room_count+1;
                            isRoomExist=1;
                            return;
                        }
                    });
                }
                if(!isTableExist){
                    notificationContents.push(obj);
                }
                if(!isRoomExist){
                    notificationRoomContents.push(objRoom);
                }
                sessionStorage.setItem("notificationContents", (JSON.stringify(notificationContents)));
                sessionStorage.setItem("notificationRoomContents", (JSON.stringify(notificationRoomContents)));
                let table_count = parseInt($('.table-badge').text()) + 1;
                $('.table-badge').text(table_count);
                $('.table-badge').show();
                $.ajax({
                    type: "post",
                    url: "/pos/add-new-orders-to-transaction-sellline",
                    data: {
                        order_id:data.order_id
                    },
                    success: function (response) {
                        // alert(response);
                        if(response.result==1){
                             get_dining_content();
                             transaction_id=response.transaction_id;

                        }
                    }
                });
            }
            if (data && data.table_no=="not exist") {
                // alert(data)
                let badge_count = parseInt($('.online-order-badge').text()) + 1;
                $.ajax({
                    type: "post",
                    url: "/pos/add-new-online-orders-to-transaction-sellline",
                    data: {
                        order_id:data.order_id
                    },
                    success: function (response) {
                        // alert(response);
                        if(response.result==1){
                             transaction_id=response.transaction_id;
                             $('.online-order-badge').text(badge_count);
                $('.online-order-badge').show();
                $.ajax({
                    method: 'get',
                    url: '/pos/get-transaction-details/' + transaction_id,
                    data: {},
                    success: function(result) {
                        console.log(result);
                        toastr.success(LANG.new_order_placed_invoice_no + ' ' + result.invoice_no);
                        let notification_number = parseInt($('.notification-number').text());
                        console.log(notification_number, 'notification-number');
                        if (!isNaN(notification_number)) {
                            notification_number = parseInt(notification_number) + 1;
                        } else {
                            notification_number = 1;
                        }
                        $('.notification-list').empty().append(
                            `<i class="dripicons-bell"></i><span class="badge badge-danger notification-number">${notification_number}</span>`
                        );
                        $('.notifications').prepend(
                            `<li>
                                <a class="pending notification_item"
                                    data-mark-read-action=""
                                    data-href="{{ url('/') }}/pos/${transaction_id}/edit?status=final">
                                    <p style="margin:0px"><i class="dripicons-bell"></i> ${LANG.new_order_placed_invoice_no} #
                                        ${result.invoice_no}</p>
                                    <span class="text-muted">
                                        @lang('lang.total'): ${__currency_trans_from_en(result.final_total, false)}
                                    </span>
                                </a>

                            </li>`
                        );
                        $('.no_new_notification_div').addClass('hide');

                    },
                });
                        }
                    }
                });

            }
        });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const offcanvasToggle = document.getElementById('offcanvas-toggle');
    const offcanvasClose = document.getElementById('offcanvas-close');
    const offcanvas = document.getElementById('offcanvas');
    const backdrop = document.getElementById('offcanvas-backdrop');

    offcanvasToggle.addEventListener('click', function() {
    offcanvas.classList.add('open');
    // backdrop.classList.add('show');
    document.body.classList.add('offcanvas-open');
    });

    offcanvasClose.addEventListener('click', function() {
    offcanvas.classList.remove('open');
    // backdrop.classList.remove('show');
    document.body.classList.remove('offcanvas-open');
    });

    backdrop.addEventListener('click', function() {
    offcanvas.classList.remove('open');
    // backdrop.classList.remove('show');
    document.body.classList.remove('offcanvas-open');
    });
    });
</script>
@endsection