@extends('layouts.app')
@section('title', __('lang.expense_beneficiary'))

@section('content')
<section class="forms py-2">


    <div class="container-fluid px-2">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>


                    <h4>@lang('lang.add_expense_beneficiary')</h4>

                </x-page-title>


                <div class="card">

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::open(['url' => action('ExpenseBeneficiaryController@store'), 'method' =>
                                'post'])
                                !!}

                                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label
                                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                for="expense_category_id">@lang('lang.expense_category')</label>
                                            {!! Form::select('expense_category_id', $expense_categories, null,
                                            ['class' =>
                                            'form-control', 'required', 'placeholder' => __('lang.please_select')])
                                            !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label
                                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                for="name">@lang('lang.beneficiary_name')</label>
                                            <input type="text" class="form-control" name="name" id="name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <input type="submit" class="btn btn-primary" value="@lang('lang.save')"
                                            name="submit">
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')
<script>

</script>
@endsection
