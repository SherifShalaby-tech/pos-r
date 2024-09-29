@extends('layouts.app')
@section('title', __('lang.add_transfer'))

@section('content')
<section class="forms py-2">
    <div class="container-fluid px-2">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>

                    <h4>@lang('lang.add_transfer')</h4>


                </x-page-title>


                {!! Form::open(['url' => action('TransferController@store'), 'method' => 'post', 'id' =>
                'add_transfer_form', 'enctype' => 'multipart/form-data' ]) !!}
                <input type="hidden" name="is_raw_material" id="is_raw_material" value="{{ $is_raw_material }}">

                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('sender_store_id', __('lang.sender_store'). '*', [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                                    ]) !!}
                                    {!! Form::select('sender_store_id', $stores,
                                    null, ['class' => 'selectpicker form-control', 'data-live-search'=>"true",
                                    'required',
                                    'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('receiver_store_id', __('lang.receiver_store'). '*', [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'

                                    ]) !!}
                                    {!! Form::select('receiver_store_id', $stores,
                                    null, ['class' => 'selectpicker form-control', 'data-live-search'=>"true",
                                    'required',
                                    'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
                                </div>
                            </div>



                        </div>
                    </div>
                </div>

                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-12">
                                <div class="search-box input-group">
                                    <button type="button" class="btn btn-secondary btn-lg" id="search_button"><i
                                            class="fa fa-search"></i></button>
                                    <input type="text" name="search_product" id="search_product"
                                        placeholder="@lang('lang.enter_product_name_to_print_labels')"
                                        class="form-control ui-autocomplete-input" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <divclass="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-2 ">
                                @include('quotation.partial.product_selection')
                            </div>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered table-striped table-condensed" id="product_table">
                            <thead>
                                <tr>
                                    <th style="width: 25%" class="col-sm-8">@lang( 'lang.products' )</th>
                                    <th style="width: 25%" class="col-sm-4">@lang( 'lang.sku' )</th>
                                    <th style="width: 25%" class="col-sm-4">@lang( 'lang.quantity' )</th>
                                    <th style="width: 12%" class="col-sm-4">@lang( 'lang.purchase_price' )</th>
                                    <th style="width: 12%" class="col-sm-4">@lang( 'lang.sub_total' )</th>
                                    <th style="width: 12%" class="col-sm-4">@lang( 'lang.action' )</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="col-md-12">
                            <div class="col-md-3 offset-md-8 text-right">
                                <h3> @lang('lang.total'): <span class="final_total_span"></span> </h3>
                                <input type="hidden" name="final_total" id="final_total" value="0">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-12">

                                <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                    for="body">
                                    <input type="file" name="files[]" id="files" class=" w-100 h-100"
                                        style="opacity: 0;position: absolute;top: 0;left: -18px;" multiple>
                                    <div class="w-100 h-100 mb-1 py-2 text-center"
                                        style="border: 2px dashed var(--primary-color);cursor: pointer;">
                                        {{__('lang.attachment')}}
                                    </div>
                                </label>

                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('notes', __('lang.notes'), [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 3]) !!}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="col-sm-12">
                            <button type="submit" name="submit" id="print" value="save"
                                class="btn btn-primary pull-right btn-flat submit">@lang( 'lang.save' )</button>
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
<script src="{{asset('js/transfer.js')}}"></script>
<script src="{{asset('js/product_selection.js')}}"></script>
<script type="text/javascript">
    $(document).on('click', '#add-selected-btn', function(){
        $('#select_products_modal').modal('hide');
        var varpluse = 0;
        $.each(product_selected, function(index, value){
            get_label_product_row(value.product_id, value.variation_id,varpluse);
            varpluse++;
        });
        product_selected = [];
        product_table.ajax.reload();
    })
</script>
@endsection
