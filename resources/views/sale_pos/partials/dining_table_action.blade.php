<!-- order_discount modal -->
<div role="document" class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ $dining_table->dining_tables->name }}</h5>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                    aria-hidden="true"><i class="dripicons-cross"></i></span></button>
        </div>
        <div class="modal-body">
            {{-- <div class="form-group">
                {!! Form::label('table_status', __('lang.status') . ':*') !!}
                {!! Form::select('table_status', $status_array, 'order', ['class' => 'form-control selectpicker', 'data-live-search' => 'true', 'placeholder' => __('lang.please_select')]) !!}
            </div> --}}
            {{-- <input type="hidden" value="reserve" name="status"/> --}}
            {{-- <div class="row cancel_div"><div class="col-md-4"><h2>{{__('lang.are_you_sure_u_want_to_delete_this_reservation')}}</h2>
            <br>
            </div></div> --}}
            <div class="row ">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('table_customer_name', __('lang.customer_name') . ':*') !!}
                        {!! Form::text('table_customer_name', !empty($status)&&$status=='edit'?$dining_table->customer_name:null, ['class' => 'form-control', 'placeholder' => __('lang.customer_name'), 'required']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('table_customer_mobile_number', __('lang.mobile_number') . ':*') !!}
                        {!! Form::text('table_customer_mobile_number', !empty($status)&&$status=='edit'?$dining_table->customer_mobile_number:null, ['class' => 'form-control', 'placeholder' => __('lang.mobile_number'), 'required']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('table_date_and_time', __('lang.date_and_time') . ':*') !!}
                        <input type="datetime-local" id="table_date_and_time" name="table_date_and_time"
                            value="{{!empty($status)&&$status=='edit'? (!empty($dining_table->date_and_time)?$dining_table->date_and_time:date('Y-m-d\TH:i')):date('Y-m-d\TH:i')}}"
                            class="form-control">
                    </div>
                </div>
            </div>
            <input type="hidden" name="discount_amount" id="discount_amount">
            <div class="modal-footer">
                <button type="button" name="discount_btn" id="table_action_btn"
                    class="btn btn-primary hide">@lang('lang.save')</button>

                    <button type="button" name="discount_btn" id="table_edit_btn"
                    class="btn btn-primary hide" data-table_id="{{$dining_table->dining_table_id}}" data-reserve_id="{{ $dining_table->id }}">@lang('lang.update')</button>

                <button type="button" name="discount_btn" id="table_reserve_btn"
                    class="btn btn-primary">@lang('lang.save')</button>
                <button type="button" name="cancel" class="btn btn-default"
                    data-dismiss="modal">@lang('lang.cancel')</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#table_status').change();
    $('#table_status').selectpicker('render');
</script>
