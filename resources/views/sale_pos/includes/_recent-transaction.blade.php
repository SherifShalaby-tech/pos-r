<div id="recentTransaction" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal text-left">

    <div class="modal-dialog modal-xl" role="document" style="max-width: 65%;">
        <div class="modal-content">

            <x-modal-header>

                <h4 class="modal-title">@lang('lang.recent_transactions')</h4>

            </x-modal-header>

            <div class="modal-body">
                <div class="col-md-12 modal-filter">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('start_date', __('lang.start_date'), []) !!}
                                {!! Form::text('start_date', null, ['class' => 'form-control
                                filter_transactions', 'id' => 'rt_start_date']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('end_date', __('lang.end_date'), []) !!}
                                {!! Form::text('end_date', null, ['class' => 'form-control
                                filter_transactions', 'id' => 'rt_end_date']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('rt_customer_id', __('lang.customer'), []) !!}
                                {!! Form::select('rt_customer_id', $customers, false, ['class' =>
                                'form-control filter_transactions selectpicker', 'id' => 'rt_customer_id',
                                'data-live-search' => 'true', 'placeholder' => __('lang.all')]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('rt_method', __('lang.payment_type'), []) !!}
                                {!! Form::select('rt_method', $payment_types, request()->method, ['class' =>
                                'form-control filter_transactions', 'placeholder' => __('lang.all'),
                                'data-live-search' => 'true', 'id' => 'rt_method']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('rt_created_by', __('lang.cashier'), []) !!}
                                {!! Form::select('rt_created_by', $cashiers, false, ['class' =>
                                'form-control selectpicker filter_transactions', 'id' => 'rt_created_by',
                                'data-live-search' => 'true', 'placeholder' => __('lang.all')]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('rt_deliveryman_id', __('lang.deliveryman'), []) !!}
                                {!! Form::select('rt_deliveryman_id', $delivery_men, null, ['class' =>
                                'form-control sale_filter filter_transactions', 'placeholder' =>
                                __('lang.all'), 'data-live-search' => 'true', 'id' => 'rt_deliveryman_id'])
                                !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    @include('sale_pos.partials.recent_transactions')
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default col-12" data-dismiss="modal">@lang('lang.close')</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>