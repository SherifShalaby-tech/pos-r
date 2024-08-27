@extends('layouts.app')
@section('title', __('lang.redemption_of_point_system'))
@section('content')
<section class="forms pt-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>

                    <h4>@lang('lang.edit_redemption_of_point_system')</h4>

                    <x-slot name="buttons">

                    </x-slot>
                </x-page-title>


                <div class="card">

                    <div class="card-body">
                        <p class="italic"><small>@lang('lang.required_fields_info')</small></p>
                        {!! Form::open(['url' => action('RedemptionOfPointController@update', $redemption_of_point->id),
                        'id'
                        => 'customer-type-form',
                        'method' =>
                        'PUT', 'class' => '', 'enctype' => 'multipart/form-data']) !!}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('store_ids', __( 'lang.store' ) . ':*') !!}
                                    {!! Form::select('store_ids[]', $stores, $redemption_of_point->store_ids, ['class'
                                    =>
                                    'selectpicker
                                    form-control', 'data-live-search' => "true", 'multiple', 'required',
                                    "data-actions-box"=>"true"]) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('earning_of_point_ids', __( 'lang.earning_of_points' ) . ':*') !!}
                                    {!! Form::select('earning_of_point_ids[]', $earning_of_points,
                                    $redemption_of_point->earning_of_point_ids, ['class' =>
                                    'selectpicker
                                    form-control', 'data-live-search' => "true", 'multiple', 'required',
                                    "data-actions-box"=>"true"]) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                @include('product_classification_tree.partials.product_selection_tree')
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('value_of_1000_points', __( 'lang.value_of_1000_points' ) .
                                    ':*') !!}
                                    {!! Form::text('value_of_1000_points', $redemption_of_point->value_of_1000_points,
                                    ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('start_date', __( 'lang.start_date' ) . ':') !!}
                                    {!! Form::text('start_date', $redemption_of_point->start_date, ['class' =>
                                    'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('end_date', __( 'lang.end_date' ) . ':') !!}
                                    {!! Form::text('end_date', $redemption_of_point->end_date, ['class' =>
                                    'form-control'])
                                    !!}
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="submit" value="{{trans('lang.submit')}}" id="submit-btn"
                                        class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <input type="hidden" name="is_edit_page" id="is_edit_page" value="1">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')
<script src="{{asset('js/product_selection_tree.js')}}"></script>
<script type="text/javascript">
</script>
@endsection
