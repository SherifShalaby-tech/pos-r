@extends('layouts.app')
@section('title', __('lang.leave_type'))

@section('content')


<section class="forms py-2">


    <div class="container-fluid px-2">


        <x-page-title>
            <h4 class="print-title">@lang('lang.leave_type')</h4>


            <x-slot name="buttons">
                <button type="button" class="btn btn-primary btn-modal"
                    data-href="{{action('LeaveTypeController@create')}}" data-container=".view_modal">
                    <i class="fa fa-plus"></i> @lang( 'lang.add_leave_type' )</button>
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
                                <th>@lang('lang.type_name')</th>
                                <th>@lang('lang.number_of_days_per_year')</th>
                                <th>@lang('lang.action')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($leave_types as $leave_type)
                            <tr>
                                <td>
                                    {{$leave_type->name}}
                                </td>
                                <td>
                                    {{$leave_type->number_of_days_per_year}}
                                </td>

                                <td>
                                    @can('hr_management.leave_types.create_and_edit')
                                    <a data-href="{{action('LeaveTypeController@edit', $leave_type->id)}}"
                                        data-container=".view_modal"
                                        class="btn btn-primary btn-modal text-white edit_leave_type"><i
                                            class="fa fa-pencil-square-o"></i></a>
                                    @endcan
                                    @can('hr_management.leave_types.delete')
                                    <a data-href="{{action('LeaveTypeController@destroy', $leave_type->id)}}"
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
