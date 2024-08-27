@extends('layouts.app')
@section('title', __('lang.add_expense_category'))

@section('content')
<section class="forms pt-2">


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">


                <x-page-title>

                    <h4>@lang('lang.add_expense_category')</h4>

                    <x-slot name="buttons">

                    </x-slot>
                </x-page-title>


                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::open(['url' => action('ExpenseCategoryController@store'), 'method' =>
                                'post']) !!}

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">@lang('lang.name')</label>
                                            <input type="text" class="form-control" name="name" id="name">
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
