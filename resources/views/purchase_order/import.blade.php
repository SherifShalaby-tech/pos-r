@extends('layouts.app')
@section('title', __('lang.purchase_order'))

@section('content')
<section class="forms py-2">
    <div class="container-fluid px-2">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>
                    <h4>@lang('lang.import_purchase_order')</h4>
                </x-page-title>


                {!! Form::open(['url' => action('PurchaseOrderController@saveImport'), 'method' => 'post', 'id' =>
                'import_purchase_order_form', 'files' => true]) !!}

                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('store_id', __('lang.store'). '*', [

                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                                    ]) !!}
                                    {!! Form::select('store_id', $stores,
                                    null, ['class' => 'selectpicker form-control', 'data-live-search'=>"true",
                                    'required',
                                    'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('supplier_id', __('lang.supplier'). '*', [

                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                                    ]) !!}
                                    {!! Form::select('supplier_id', $suppliers,
                                    null, ['class' => 'selectpicker form-control',
                                    'data-live-search'=>"true", 'required',
                                    'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('po_no', __('lang.po_no'). '*', [

                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                                    ]) !!}
                                    {!! Form::text('po_no', null, ['class' => 'form-control','required', 'readonly',
                                    'placeholder' => __('lang.po_no')]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-6">

                                <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                    for="body">
                                    <input type="file" name="file[]" id="file" class=" w-100 h-100"
                                        style="opacity: 0;position: absolute;top: 0;left: -18px;" multiple>
                                    <div class="w-100 h-100 mb-1 py-2 text-center"
                                        style="border: 2px dashed var(--primary-color);cursor: pointer;">
                                        {{__('lang.attachment')}}
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-block btn-primary"
                                    href="{{asset('sample_files/purchase_order_import.xlsx')}}"><i
                                        class="fa fa-download"></i>@lang('lang.download_sample_file')</a>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-12">

                                {!! Form::label('details', __('lang.details'), [
                                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                ]) !!}
                                {!! Form::textarea('details', null, ['class' => 'form-control', 'rows' => 3])
                                !!}

                            </div>
                        </div>
                    </div>
                </div>



                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-sm-12">
                                <button type="submit" name="submit" id="print" style="margin: 10px" value="print"
                                    class="btn btn-primary pull-right btn-flat submit">@lang( 'lang.print'
                                    )</button>
                                @can('purchase_order.send_to_supplier.create_and_edit')
                                <button type="button" id="send_to_supplier" style="margin: 10px" disabled
                                    class="btn btn-warning pull-right btn-flat submit" data-toggle="modal"
                                    data-target="#supplier_modal">@lang(
                                    'lang.send_to_supplier' )</button>
                                @endcan
                                @can('purchase_order.send_to_admin.create_and_edit')
                                <button type="submit" name="submit" id="send_to_admin" style="margin: 10px"
                                    value="sent_admin" class="btn btn-primary pull-right btn-flat submit">@lang(
                                    'lang.send_to_admin' )</button>
                                @endcan
                                <div class="modal fade supplier_modal" id="supplier_modal" role="dialog"
                                    aria-hidden="true">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>


</section>
@endsection

@section('javascript')
<script src="{{asset('js/purchase.js')}}"></script>
<script type="text/javascript">
    $('#store_id').change(function () {
        let store_id = $(this).val();

        $.ajax({
            method: 'get',
            url: '/purchase-order/get-po-number',
            data: { store_id },
            success: function(result) {
                $('#po_no').val(result);
            },
        });
    })

</script>
@endsection
