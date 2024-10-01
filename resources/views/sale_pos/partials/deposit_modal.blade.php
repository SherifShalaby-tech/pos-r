<div class="modal fade" role="dialog" id="deposit_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <x-modal-header>
                <h5 class="modal-title">@lang('lang.insurance_amount')</h5>


            </x-modal-header>

            <div class="modal-body">
                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div class="col-md-4 px-3">
                        <div class="form-group">
                            <label
                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif">{{trans('lang.product')}}</label>
                            <input type="text" name="ItemBorrowed[name]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 px-3">
                        <div class="form-group">
                            <label
                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif">{{trans('lang.customer')}}</label>
                            <select class="form-control" name="ItemBorrowed[customer_id]">
                                @foreach($clients as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 px-3">
                        <div class="form-group">
                            <label
                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif">{{trans('lang.status')}}</label>
                            <select class="form-control" name="ItemBorrowed[status]">
                                <option value="Available">Available</option>
                                <option value="Pending">Pending</option>
                                <option value="Late">Late</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 px-3">
                        <div class="form-group">
                            <label
                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif">{{trans('lang.insurance_amount')}}</label>
                            <input type="number" name="ItemBorrowed[insurance_amount]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 px-3">
                        <div class="form-group">
                            <label
                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif">{{trans('lang.return_date')}}</label>
                            <input type="date" name="ItemBorrowed[return_date]" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary col-6" data-dismiss="modal"
                    id="deposit_submit">@lang('lang.submit')</button>
                <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang('lang.close')</button>
            </div>
        </div>

    </div>

</div><!-- /.modal-content -->