@extends('layouts.app')
@section('title', __('lang.consumption'))

@section('content')
<section class="forms py-2">
    <div class="container-fluid px-2">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>
                    <h4>@lang('lang.add_manual_consumption')</h4>
                </x-page-title>
                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">

                        <p class="italic mb-0 @if (app()->isLocale('ar')) text-right @else text-left @endif">
                            <small>@lang('lang.required_fields_info')</small>
                        </p>

                    </div>
                </div>
                {!! Form::open(['url' => action('ConsumptionController@store'), 'id' => 'consumption-form',
                'method'
                =>
                'POST', 'class' => '', 'enctype' => 'multipart/form-data']) !!}

                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div
                            class="row justify-content-start @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('store_id', __('lang.store'). ':*', [

                                    ]) !!}
                                    {!! Form::select('store_id', $stores,
                                    session('user.store_id'), ['class' => 'selectpicker form-control',
                                    'data-live-search'=>"true",
                                    'required',
                                    'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
                                </div>
                            </div>
                            <div
                                class="col-md-3 @if(!auth()->user()->can('raw_material_module.add_consumption_for_others.create_and_edit')) hide @endif">
                                <div class="form-group">
                                    {!! Form::label('created_by', __('lang.chef'). ':*', [
                                    'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                    ]) !!}
                                    {!! Form::select('created_by', $chefs,
                                    auth()->user()->id, ['class' => 'selectpicker form-control',
                                    'data-live-search'=>"true",
                                    'required',
                                    'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('date_and_time', __('lang.date_and_time'), [
                                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                ]) !!}
                                <input type="datetime-local" id="date_and_time" name="date_and_time"
                                    value="{{date('Y-m-d\TH:i')}}" class="form-control">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">

                        <table class="table table-bordered" id="consumption_table">
                            <thead>
                                <tr>
                                    <td style="width: 20%;">@lang('lang.raw_material')</td>
                                    <td style="width: 20%;">@lang('lang.products')</td>
                                    <td style="width: 20%;">@lang('lang.quantity')</td>
                                    <td style="width: 20%;">@lang('lang.unit')</td>
                                    {{-- <td style="width: 20%;"><button type="button"
                                            class="btn btn-xs btn-success add_row"><i class="fa fa-plus"></i></button>
                                    </td> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @include('consumption.partial.consumption_row', ['row_id' => 0])
                            </tbody>
                        </table>

                    </div>
                </div>

                <input type="hidden" name="active" value="1">
                <input type="hidden" name="row_id" id="row_id" value="1">


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="submit" value="{{trans('lang.submit')}}" id="submit-btn"
                                class="btn btn-primary">
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
<script src="{{asset('js/consumption.js')}}"></script>
<script src="{{asset('js/raw_material.js')}}"></script>
<script type="text/javascript">
    @if(!empty(request()->raw_material_id))
    $(document).ready(function () {
        $('select.raw_material_id').change();
    });
@endif
</script>
@endsection
