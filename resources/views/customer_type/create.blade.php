@extends('layouts.app')
@section('title', __('lang.customer_type'))
@section('content')
<section class="forms py-2">
    <div class="container-fluid px-2">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>
                    <h4>@lang('lang.add_customer_type')</h4>
                </x-page-title>


                <div class="card mt-1 mb-0">
                    <div
                        class="card-body py-2 px-4 row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <p class="italic mb-0"><small>@lang('lang.required_fields_info')</small></p>
                    </div>
                </div>
                {!! Form::open(['url' => action('CustomerTypeController@store'), 'id' => 'customer-type-form',
                'method' =>
                'POST', 'class' => '', 'enctype' => 'multipart/form-data']) !!}
                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('name', __( 'lang.name' ) . '*',[
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __(
                                    'lang.name' ), 'required' ])
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('store', __( 'lang.store' ) . '*',[
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('stores[]', $stores, false, ['class' => 'selectpicker
                                    form-control', 'data-live-search' => "true", 'multiple', 'required']) !!}
                                </div>
                            </div>
                        </div>


                        <input type="submit" value="{{trans('lang.submit')}}" id="submit-btn" class="btn btn-primary">
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

</section>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).on('click', '.remove_row', function (){
        $(this).closest('tr').remove();
    })

    $(document).on('click', '.add_row_point', function(){
        var row_id = parseInt($('#row_id_point').val()) + 1;
        $.ajax({
            method: 'get',
            url: '/customer-type/get-product-point-row?row_id='+row_id,
            data: {  },
            contentType: 'html',
            success: function(result) {
                $('#product_point_table tbody').append(result);
                $('.row_'+row_id).find('.product_id_'+row_id).selectpicker('refresh');
                $('#row_id_point').val(row_id);
            },
        });
    })

    $('#customer-type-form').submit(function(){
        $(this).validate();
        if($(this).valid()){
            $(this).submit();
        }
    })
</script>
@endsection
