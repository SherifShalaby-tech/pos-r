<div class="card mt-1 mb-0">
    <div class="card-body py-2 px-4">
        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <span class="text-danger">*</span>
                        {!! Form::label('customer_type_id', __('lang.customer_type') ) !!}
                    </div>
                    {!! Form::select('customer_type_id', $customer_types, false, [
                    'class' => 'selectpicker
                    form-control',
                    'data-live-search' => 'true',
                    'required',
                    'placeholder' => __('lang.please_select'),
                    ]) !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('name', __('lang.name') . ':') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('lang.name')]) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('photo', __('lang.photo') . ':') !!} <br>
                    {!! Form::file('image', ['class']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('mobile_number', __('lang.mobile_number') . ':*') !!}
                    {!! Form::text('mobile_number', null, ['class' => 'form-control', 'placeholder' =>
                    __('lang.mobile_number'),
                    'required']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('address', __('lang.address') . ':') !!}
                    {!! Form::textarea('address', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' =>
                    __('lang.address')]) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('email', __('lang.email') . ':') !!}
                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('lang.email')]) !!}
                </div>
            </div>
            @if (session('system_mode') == 'garments')
            @can('customer_module.customer_sizes.create_and_edit')
            <div class="col-md-12">
                <button type="button" class="add_size_btn btn btn-primary mb-5">@lang('lang.add_size')</button>
            </div>

            <div class="col-md-12 mb-5 add_size_div hide">
                <div class="form-group">
                    {!! Form::label('name', __('lang.name') . ':*') !!}
                    {!! Form::text('size_data[name]', null, ['class' => 'form-control', 'placeholder' =>
                    __('lang.name')]) !!}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <thead>
                                <tr class="">
                                    <th>@lang('lang.length_of_the_dress')</th>
                                    <th>@lang('lang.cm')</th>
                                    <th>@lang('lang.inches')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getAttributeListArray as $key => $value)
                                <tr>
                                    <td>
                                        <label for="">{{ $value }}</label>
                                    </td>
                                    <td>
                                        <input type="number" data-name="{{ $key }}" name="size_data[{{ $key }}][cm]"
                                            class="form-control cm_size" step="any" placeholder="@lang('lang.cm')">
                                    </td>
                                    <td>
                                        <input type="number" data-name="{{ $key }}" name="size_data[{{ $key }}][inches]"
                                            class="form-control inches_size" step="any"
                                            placeholder="@lang('lang.inches')">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        @include('customer_size.partial.body_graph')
                    </div>
                </div>
            </div>
            @endcan
            @endif
        </div>
    </div>
</div>


@if (empty($quick_add))
<x-collapse collapse-id="importantDates" button-class="d-flex btn-primary align-items-center gap-20px"
    group-class="my-1 d-flex flex-column align-items-end" body-class="py-1 gap-2">

    <x-slot name="button">
        <div class="collapse_arrow">
            <i class="fas fa-arrow-down"></i>
        </div>
        <h3 class="mb-0">@lang('lang.important_dates')</h3>
    </x-slot>

    <div class="col-md-12 row justify-content-center align-items-center mb-1 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
        style="gap:25px">
        <button type="button" class="add_date btn btn-primary "><i class="fa fa-plus"></i></button>
    </div>
    <div class="col-md-12">
        <div class="row">
            <table class="table table-bordered text-primary" id="important_date_table" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 25%;">@lang('lang.important_date')</th>
                        <th style="width: 25%;">@lang('lang.date')</th>
                        <th style="width: 25%;">@lang('lang.notify_before_days')</th>

                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <input type="hidden" name="important_date_index" id="important_date_index" value="0">
</x-collapse>
@endif

<input type="hidden" name="quick_add" value="{{ $quick_add }}">


<x-collapse collapse-id="refferal" button-class="d-flex btn-primary align-items-center gap-20px"
    group-class="my-1 d-flex flex-column align-items-end" body-class="py-1 gap-2">

    <x-slot name="button">
        <div class="collapse_arrow">
            <i class="fas fa-arrow-down"></i>
        </div>
        <h3 class="mb-0">@lang('lang.referral')</h3>
    </x-slot>

    <input type="hidden" name="ref_index" value="1" id="ref_index">
    <div class="col-md-12" id="referral_div">
        <div class="row justify-content-center align-items-center col-md-12">
            <button type="button" class="add_referrals btn btn-primary"><i class="fa fa-plus"></i></button>
        </div>
        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif referred_row">
            <input type="hidden" name="" class="ref_row_index" value="0">
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('referred_type', __('lang.referred_type'), [
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    {!! Form::select('ref[0][referred_type]', ['customer' => __('lang.customer'),
                    'supplier' =>
                    'Supplier',
                    'employee' => __('lang.employee')],null, ['class' => 'form-control selectpicker
                    referred_type',
                    'data-live-search' => 'true','placeholder'=>'please select']) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('referred_by', __('lang.referred_by'), [
                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                    ]) !!}
                    {!! Form::select('ref[0][referred_by][]', $customers, false, ['class' =>
                    'form-control
                    selectpicker
                    referred_by', 'data-live-search' => 'true', 'data-actions-box' => 'true',
                    'multiple']) !!}
                </div>
            </div>

            <div class="col-md-12 referred_details mb-1">
            </div>
        </div>
    </div>
</x-collapse>