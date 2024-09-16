@extends('layouts.app')

@section('title', __('lang.expense_beneficiary'))

@section('content')
<section class="forms py-2">


    <div class="container-fluid px-2">

        <x-page-title>

            <h4 class="print-title">@lang('lang.add_expense_beneficiary')</h4>

            <x-slot name="buttons">

                <a class="btn btn-primary " href="{{action('ExpenseBeneficiaryController@create')}}">
                    <i class="fa fa-plus"></i> @lang( 'lang.add_expense_beneficiary' )</a>
            </x-slot>
        </x-page-title>



        <div
            class="top-controls py-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">

        </div>
        <div class="card mt-1 mb-0">
            <div class="card-body py-2 px-4">
                <div class="table-responsive">
                    <table class="table dataTable">
                        <thead>
                            <tr>
                                <th>@lang('lang.sr_no')</th>
                                <th>@lang('lang.name')</th>
                                <th>@lang('lang.expense_category')</th>
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($expense_beneficiaries as $expense_beneficiary)
                            <tr>
                                <td>{{$loop->index +1}}</td>
                                <td>
                                    {{$expense_beneficiary->name}}
                                </td>
                                <td>
                                    {{$expense_beneficiary->expense_category->name ?? ''}}
                                </td>
                                <td>
                                    @can('expense.expense_beneficiaries.create_and_edit')
                                    <a data-href="{{action('ExpenseBeneficiaryController@edit', $expense_beneficiary->id)}}"
                                        data-container=".view_modal"
                                        class="btn btn-danger btn-modal text-white edit_job"><i
                                            class="fa fa-pencil-square-o"></i></a>
                                    @endcan
                                    @can('expense.expense_beneficiaries.delete')
                                    <a data-href="{{action('ExpenseBeneficiaryController@destroy', $expense_beneficiary->id)}}"
                                        data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
                                        class="btn btn-danger text-white delete_item"><i class="fa fa-trash"></i></a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div
            class="bottom-controls mt-1 p-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">
            <!-- Pagination and other controls can go here -->
        </div>
    </div>

</section>
@endsection

@section('javascript')
<script>

</script>
@endsection
