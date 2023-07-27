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
            accent-color: #7e2dff;
        }
    </style>
@endsection
@section('content')
    <section class="forms pos-section no-print">
        <div class="container-fluid">
            <div class="row">
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
                <!-- product list -->
                <livewire:mypos :payment_types="$payment_types" :delivery_men="$delivery_men" :exchange_rate_currencies="$exchange_rate_currencies" :customers="$customers" />

                <!-- recent transaction modal -->
                <div id="recentTransaction" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                    class="modal text-left">

                    <div class="modal-dialog modal-xl" role="document" style="max-width: 65%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('lang.recent_transactions')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12 modal-filter">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('start_date', __('lang.start_date'), []) !!}
                                                {!! Form::text('start_date', null, ['class' => 'form-control', 'id' => 'rt_start_date']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('end_date', __('lang.end_date'), []) !!}
                                                {!! Form::text('end_date', null, ['class' => 'form-control', 'id' => 'rt_end_date']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('rt_customer_id', __('lang.customer'), []) !!}
                                                {!! Form::select('rt_customer_id', $customers, false, ['class' => 'form-control selectpicker', 'id' => 'rt_customer_id', 'data-live-search' => 'true', 'placeholder' => __('lang.all')]) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('rt_method', __('lang.payment_type'), []) !!}
                                                {!! Form::select('rt_method', $payment_types, request()->method, ['class' => 'form-control', 'placeholder' => __('lang.all'), 'data-live-search' => 'true', 'id' => 'rt_method']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('rt_created_by', __('lang.cashier'), []) !!}
                                                {!! Form::select('rt_created_by', $cashiers, false, ['class' => 'form-control selectpicker', 'id' => 'rt_created_by', 'data-live-search' => 'true', 'placeholder' => __('lang.all')]) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('rt_deliveryman_id', __('lang.deliveryman'), []) !!}
                                                {!! Form::select('rt_deliveryman_id', $delivery_men, null, ['class' => 'form-control sale_filter', 'placeholder' => __('lang.all'), 'data-live-search' => 'true', 'id' => 'rt_deliveryman_id']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    @include('sale_pos.partials.recent_transactions')
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">@lang('lang.close')</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <!-- draft transaction modal -->
                {{-- <div id="draftTransaction" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                    class="modal text-left">

                    <div class="modal-dialog" role="document" style="width: 65%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('lang.draft_transactions')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12 modal-filter">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('draft_start_date', __('lang.start_date'), []) !!}
                                                {!! Form::text('start_date', null, ['class' => 'form-control', 'id' => 'draft_start_date']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('draft_end_date', __('lang.end_date'), []) !!}
                                                {!! Form::text('end_date', null, ['class' => 'form-control', 'id' => 'draft_end_date']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('draft_deliveryman_id', __('lang.deliveryman'), []) !!}
                                                {!! Form::select('draft_deliveryman_id', $delivery_men, null, ['class' => 'form-control sale_filter', 'placeholder' => __('lang.all'), 'data-live-search' => 'true', 'id' => 'draft_deliveryman_id']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    @include('sale_pos.partials.view_draft')
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">@lang('lang.close')</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div> --}}
                <!-- onlineOrder transaction modal -->
                {{-- <div id="onlineOrderTransaction" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                    class="modal text-left">

                    <div class="modal-dialog" role="document" style="width: 65%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('lang.online_order_transactions')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12 modal-filter">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('online_order_start_date', __('lang.start_date'), []) !!}
                                                {!! Form::text('start_date', null, ['class' => 'form-control', 'id' => 'online_order_start_date']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('online_order_end_date', __('lang.end_date'), []) !!}
                                                {!! Form::text('end_date', null, ['class' => 'form-control', 'id' => 'online_order_end_date']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    @include('sale_pos.partials.view_online_order')
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">@lang('lang.close')</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div> --}}
                {{-- <div id="dining_model" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                    class="modal text-left">
                    @include('sale_pos.partials.dining_modal')
                </div> --}}
                {{-- <div id="dining_table_action_modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                    class="modal fade text-left">
                </div> --}}
            </div>
        </div>
    </section>
@endsection

@section('javascript')

    <script src="{{ asset('js/onscan.min.js') }}"></script>
    {{-- <script src="{{ asset('js/pos.js') }}"></script> --}}
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
        channel.bind('new-order', function(data) {
            if(data.table_no){
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
                        if(response==1){
                             get_dining_content();
                        }
                    }
                });
            }
            if (data) {
                // alert(data)
                let badge_count = parseInt($('.online-order-badge').text()) + 1;

                $('.online-order-badge').text(badge_count);
                $('.online-order-badge').show();

                var transaction_id = data.transaction_id;
                $.ajax({
                    method: 'get',
                    url: '/pos/get-transaction-details/' + transaction_id,
                    data: {},
                    success: function(result) {
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
        });
    </script>
@endsection
