<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="vertical-tab" role="tabpane">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    @foreach ($dining_rooms as $dining_room)
                        <li role="presentation"
                            class="@if ($loop->index == 0 && empty($active_tab_id)) active @elseif($dining_room->id == $active_tab_id) active @endif">
                            <a class="@if ($loop->index == 0 && empty($active_tab_id)) active show @elseif($dining_room->id == $active_tab_id) active @endif room{{$dining_room->id}}"
                                href="#dining_tab{{ $dining_room->id }}" aria-controls="home" role="tab"
                                data-toggle="tab"><span class="badge badge-danger room-count-badge room-badge{{$dining_room->id}} hide ">0</span>{{ $dining_room->name }}</a>
                        </li>

                    @endforeach

                    <li role="presentation"><a data-href="{{ action('DiningRoomController@create') }}"
                            style="background-color: orange; color: #fff; font-size:12px; padding: 18px 10px 16px; display:block "
                            data-container=".view_modal" class="btn btn-modal add_dining_room" aria-controls="messages"
                            role="tab">@lang('lang.add_dining_room')</a></li>
                </ul>
                <!-- Tab panes -->
                <div class=" tab-content tabs">
                    @foreach ($dining_rooms as $dining_room)
                        <div role="tabpane"
                            class="tab-pane fade @if ($loop->index == 0 && empty($active_tab_id)) in active show @elseif($dining_room->id == $active_tab_id) in active show @endif"
                            id="dining_tab{{ $dining_room->id }}">
                            <div class="row" style="line-height: 13px;">
                                @foreach ($dining_room->dining_tables as $dining_table)
                                    @if (!empty($dining_table->table_reservations))
                                        @foreach ($dining_table->table_reservations->unique('dining_table_id') as $reserve)
                                            {{-- @if ($reserve->dining_table_id == $dining_table->id) --}}
                                            @if ($reserve->status == 'available')
                                            <div class="col-md-2 text-center">
                                            <button type="button"
                                                        class="btn btn-sm text-danger remove-table float-left" style="border-radius: 70%;"
                                                        data-table_id="{{ $reserve->dining_table_id }}"><i
                                                            class="fa fa-times"></i></button>
                                                <div class="table_action"
                                                    data-table_id="{{ $reserve->dining_table_id }}">
                                                    <span class="badge badge-danger selected-table-badge table{{$reserve->dining_table_id}} hide">0</span>
                                                    <p style="padding: 0px; margin: 0px; color:red;">
                                                        {{ $dining_table->name }} </p>
                                                    <img src="{{ asset('images/green-table.jpg') }}" alt="table"
                                                        style="height: 70px; width: 80px;">
                                                </div>
                                            </div>
                                            @endif
                                            @if ($reserve->status == 'reserve')
                                                <div class="col-md-2 text-center">
                                                    <button type="button"
                                                        class="btn btn-sm text-danger remove-table float-left" style="border-radius: 70%;"
                                                        data-table_id="{{ $reserve->dining_table_id }}"><i
                                                            class="fa fa-times"></i></button>
                                                    <span class="badge badge-danger selected-table-badge table{{$reserve->dining_table_id}} hide">0</span>
                                                    @php
                                                    $reserveHasOrder = App\Models\TableReservation::where('dining_table_id', $reserve->dining_table_id)
                                                        ->where('status', 'order')
                                                        ->first();
                                                    @endphp
                                                    @if(!empty($reserveHasOrder->current_transaction_id))
                                                    <a href="{{ action('SellPosController@edit', $reserveHasOrder->current_transaction_id) }}"
                                                        target="_blank" rel="noopener noreferrer">
                                                    @endif
                                                    <div class="text-center">
                                                        <p style="padding: 0px; margin: 0px; color:red;">
                                                            {{ $dining_table->name }} </p>
                                                        <img src="{{ asset('images/black-table.jpg') }}" alt="table"
                                                            style="height: 70px; width: 80px;">
                                                        @if (!empty($reserve->customer_name))
                                                            <p style="padding: 0px; margin: 0px; color:black;">
                                                                {{ $reserve->customer_name }}
                                                            </p>
                                                        @endif
                                                        @if (!empty($reserve->customer_mobile_number))
                                                            <p style="padding: 0px; margin: 0px; color:black;">
                                                                {{ $reserve->customer_mobile_number }}
                                                            </p>
                                                        @endif
                                                        @if (!empty($reserve->date_and_time))
                                                            <p style="padding: 0px; margin: 0px; color:black;">
                                                                {{ @format_datetime($reserve->date_and_time) }}
                                                            </p>
                                                        @endif
                                                        <p style="padding: 0px; margin: 0px; color:black;">
                                                            <button type="button"
                                                            class="btn btn-sm text-danger table_action_reserve"
                                                            data-table_id="{{ $reserve->dining_table_id}}" style="border-radius: 70%;"
                                                                ><i
                                                                class="fa fa-plus"></i></button>
                                                            </p>
                                                    </div>
                                                    @if(!empty($reserveHasOrder->current_transaction_id))
                                                    </a>
                                                    @endif
                                                    @php
                                                        $reservations = App\Models\TableReservation::where('dining_table_id', $reserve->dining_table_id)
                                                            ->where('status', 'reserve')
                                                            ->get();
                                                    @endphp
                                                    @if (!empty($reservations->count() > 1))
                                                        <div class="dropdown reservations-dropdown">
                                                            <button class="btn btn-default dropdown-toggle btn-sm"
                                                                type="button"
                                                                data-toggle="dropdown">{{ __('lang.other_reservations') }}
                                                                <span class="caret"></span></button>
                                                            <ul class="dropdown-menu">
                                                                @foreach ($reservations as $table)
                                                                    <li
                                                                        class="d-flex align-items-center justify-content-between">
                                                                        <span style="cursor:pointer;" class="table_edit_reserve_btn" data-table_id="{{ $table->dining_table_id }}" data-reserve_id="{{ $table->id }}">*{{ $table->customer_name }}</span>

                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm cancel_reserve"
                                                                            data-index="{{ $table->dining_table_id }}"><i
                                                                                class="fa fa-times"></i></button>

                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @else
                                                    <div class="text-center">
                                                        <p data-table_id="{{ $reserve->dining_table_id }}" style="padding: 0px; margin: 0px; color:red;cursor:pointer;" class="table_cancel_reserve_btn">
                                                            {{__('lang.cancel_reservation')}}
                                                        </p>
                                                    </div>
                                                    @endif
                                                    
                                                </div>
                                            @endif
                                            @if ($reserve->status == 'order')
                                            <div class="col-md-2 text-center">
                                                <button type="button"
                                                        class="btn text-danger btn-sm remove-table float-left" style="border-radius: 70%;"
                                                        data-table_id="{{ $reserve->dining_table_id }}"><i
                                                            class="fa fa-times"></i></button>
                                                <div class="order_table"
                                                    data-table_id="{{ $reserve->id }}">
                                                    <span class="badge badge-danger selected-table-badge table{{$reserve->dining_table_id}} hide">0</span>
                                                    <a href="{{ action('SellPosController@edit', $reserve->current_transaction_id) }}"
                                                        target="_blank" rel="noopener noreferrer">
                                                        <p style="padding: 0px; margin: 0px; color:red;">
                                                            {{ $dining_table->name }} </p>
                                                        <img src="{{ asset('images/red-table.jpg') }}" alt="table"
                                                            style="height: 70px; width: 80px;">
                                                        <p style="padding: 0px; margin: 0px; color:red;">
                                                            @if (!empty($dining_table->transaction))
                                                                {{ @num_format($dining_table->transaction->final_total) }}
                                                            @endif
                                                        </p>
                                                    </a>
                                                </div>
                                            </div>
                                            @endif
                                            {{-- @endif --}}
                                        @endforeach
                                    @endif
                                @endforeach

                                <div class="col-md-2">
                                    <button class="btn btn-modal add_dining_table"
                                        style="background-color: orange; padding: 18px 10px 16px; color: #fff; margin-top: 15px;"
                                        data-href="{{ action('DiningTableController@create', ['room_id' => $dining_room->id]) }}"
                                        data-container=".view_modal">@lang('lang.add_new_table')</button>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>