@extends('layouts.app')
@section('title', __('lang.jobs'))

@section('content')

<section class="forms pt-2">


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>

                    <h4 class="print-title">@lang('lang.jobs')</h4>

                    <x-slot name="buttons">

                        <button type="button" class="btn btn-primary btn-modal"
                            data-href="{{action('JobController@create')}}" data-container=".view_modal">
                            <i class="fa fa-plus"></i> @lang( 'lang.add_job' )</button>
                    </x-slot>
                </x-page-title>


                <div class="card">

                    <div class="card-body">
                        <div class="row">

                            <div class="col-sm-12">
                                <br>
                                <div class="table-responsive">
                                    <table class="table dataTable">
                                        <thead>
                                            <tr>
                                                <th>@lang('lang.job_title')</th>
                                                <th>@lang('lang.date_of_creation')</th>
                                                <th>@lang('lang.name_of_creator')</th>
                                                <th class="notexport">@lang('lang.action')</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($jobs as $job)
                                            <tr>
                                                <td>
                                                    {{$job->job_title}}
                                                </td>
                                                <td>
                                                    {{@format_date($job->date_of_creation)}}
                                                </td>
                                                <td>
                                                    {{$job->created_by}}
                                                </td>
                                                <td>

                                                    @if(!in_array($job->job_title, ['Cashier', 'Deliveryman', 'Chef']) )
                                                    @can('hr_management.jobs.create_and_edit')
                                                    <a data-href="{{action('JobController@edit', $job->id)}}"
                                                        data-container=".view_modal"
                                                        class="btn btn-primary btn-modal text-white edit_job"><i
                                                            class="fa fa-pencil-square-o"></i></a>
                                                    @endcan
                                                    @can('hr_management.jobs.delete')
                                                    <a data-href="{{action('JobController@destroy', $job->id)}}"
                                                        data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
                                                        class="btn btn-danger text-white delete_item"><i
                                                            class="fa fa-trash"></i></a>
                                                    @endcan
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
