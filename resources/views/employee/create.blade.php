@extends('layouts.app')
@section('title', __('lang.employee'))

@section('content')
<section class="forms py-2">

    <div class="container-fluid px-2">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>

                    <h4>@lang('lang.add_new_employee')</h4>

                </x-page-title>



                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-group" id="new_employee_form"
                            action="{{ action('EmployeeController@store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card mb-1">

                                <div class="card-body pb-0">
                                    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <div class="col-sm-4">
                                            <label
                                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                for="fname">@lang('lang.name'):*</label>
                                            <input type="text" class="form-control" name="name" id="name" required
                                                placeholder="Name">
                                        </div>
                                        <div class="col-sm-4">
                                            <label
                                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                for="store_id">@lang('lang.store')</label>
                                            {!! Form::select('store_id[]', $stores, !empty($stores) &&
                                            count($stores) > 0 ?
                                            array_key_first($stores) : false, ['class' => 'form-control
                                            selectpicker',
                                            'multiple', 'data-live-search' => 'true', 'id' => 'store_id']) !!}
                                        </div>
                                        <div class="col-sm-4">
                                            <label
                                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                for="email">@lang('lang.email'):*
                                                <small>(@lang('lang.it_will_be_used_for_login'))</small></label>
                                            <input type="email" class="form-control" name="email" id="email" required
                                                placeholder="Email">
                                        </div>

                                        <div class="col-sm-4">
                                            <label
                                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                for="password">@lang('lang.password'):*</label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                required placeholder="Create New Password">
                                        </div>
                                        <div class="col-sm-4">
                                            <label
                                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                for="pass">@lang('lang.confirm_password'):*</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" required placeholder="Conform Password">
                                        </div>


                                        <div class="col-sm-4">
                                            <label
                                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                for="date_of_start_working">@lang('lang.date_of_start_working')</label>
                                            <input type="date_of_start_working" class="form-control"
                                                name="date_of_start_working" id="date_of_start_working"
                                                placeholder="@lang('lang.date_of_start_working')">
                                        </div>
                                        <div class="col-sm-4">
                                            <label
                                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                for="date_of_birth">@lang('lang.date_of_birth')</label>
                                            <input type="date_of_birth" class="form-control" name="date_of_birth"
                                                id="date_of_birth" placeholder="@lang('lang.date_of_birth')">
                                        </div>


                                        <div class="col-sm-4">
                                            <label
                                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                for="job_type">@lang('lang.job_type')</label>
                                            {!! Form::select('job_type_id', $jobs, null, ['class' => 'form-control
                                            selectpicker', 'placeholder' => __('lang.select_job_type'),
                                            'data-live-search'
                                            => 'true']) !!}
                                        </div>
                                        <div class="col-sm-4">
                                            <label
                                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                for="mobile">@lang('lang.mobile'):*</label>
                                            <input type="mobile" class="form-control" name="mobile" id="mobile" required
                                                placeholder="@lang('lang.mobile')">
                                        </div>



                                        <div class="col-sm-4">
                                            <label
                                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                for="upload_files">@lang('lang.upload_files')</label>
                                            {!! Form::file('upload_files[]', ['class' => 'form-control',
                                            'multiple']) !!}
                                        </div>
                                        <div class="col-md-4">
                                            <label
                                                class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                for="photo">@lang('lang.profile_photo')</label>
                                            <input type="file" name="photo" id="photo" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        @foreach ($leave_types as $leave_type)
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="i-checks">
                                                    <input id="number_of_leaves{{ $leave_type->id }}"
                                                        name="number_of_leaves[{{ $leave_type->id }}][enabled]"
                                                        type="checkbox" value="1" class="form-control-custom">
                                                    <label
                                                        class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                        for="number_of_leaves{{ $leave_type->id }}"><strong>{{
                                                            $leave_type->name }}</strong></label>
                                                    <input type="number" class="form-control"
                                                        name="number_of_leaves[{{ $leave_type->id }}][number_of_days]"
                                                        id="number_of_leaves" placeholder="{{ $leave_type->name }}"
                                                        readonly value="{{ $leave_type->number_of_days_per_year }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="row">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn mx-3 mb-1 btn-primary" data-toggle="modal"
                                            data-target="#salary_details">
                                            @lang('lang.salary_details')
                                        </button>
                                        @include('employee.partial.salary_details')
                                    </div>
                                </div>
                            </div>

                            <x-collapse collapse-id="working_day_per_week" button-class="d-flex mx-4
                             btn-primary" group-class="mb-1" body-class="py-1">

                                <x-slot name="button">
                                    {{-- @lang('lang.filter') --}}

                                    @lang('lang.select_working_day_per_week')
                                </x-slot>
                                <div class="col-md-12">

                                    <div class="row">
                                        <div class="col-md-12">

                                            <table class="w-100">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th class="text-center">@lang('lang.check_in')</th>
                                                        <th class="text-center"> @lang('lang.check_out')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($week_days as $key => $week_day)
                                                    <tr class="py-2
                                                    " style="border: 1px solid #eee;border-radius: 5px">
                                                        <td class="p-2 my-2">
                                                            <div class="form-group mb-0">
                                                                <div class="i-checks toggle-pill-color">
                                                                    <input id="working_day_per_week{{ $key }}"
                                                                        name="working_day_per_week[{{ $key }}]"
                                                                        type="checkbox" value="1"
                                                                        class="form-control-custom">
                                                                    <label
                                                                        class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                                                                        for="working_day_per_week{{ $key }}"></label>
                                                                    <span>
                                                                        <strong>{{
                                                                            $week_day }}</strong>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            {!! Form::text('check_in[' . $key . ']', null, [
                                                            'class' => 'form-control input-md check_in w-75 m-auto
                                                            time_picker',
                                                            ]) !!}

                                                        </td>
                                                        <td>
                                                            {!! Form::text('check_out[' . $key . ']', null, [
                                                            'class' => 'form-control input-md check_out w-75 m-auto
                                                            time_picker',
                                                            ]) !!}

                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </x-collapse>



                            <x-collapse collapse-id="user_rights" button-class="d-flex mx-4 btn-primary"
                                group-class="mb-1" body-class="py-1">
                                <x-slot name="button">
                                    {{-- @lang('lang.filter') --}}
                                    @lang('lang.user_rights')
                                </x-slot>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                    </div>
                                    <div class="col-md-12">
                                        @include('employee.partial.permission')
                                    </div>
                                </div>

                            </x-collapse>


                            <div class="row ">
                                <div class="col-sm-12 mx-4">
                                    <input type="submit" id="submit-btn" class="btn btn-primary"
                                        value="@lang('lang.save')" name="submit">
                                    <input type="submit" id="send-btn" class="btn btn-primary"
                                        value="@lang('lang.send_credentials')" name="submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

@section('javascript')
<script>
    $('#date_of_start_working').datepicker({
            language: '{{ session('language') }}',
            todayHighlight: true,
        });
        $('#date_of_birth').datepicker({
            language: '{{ session('language') }}',
        });

        $('#fixed_wage').change(function() {
            console.log($(this).prop('checked'));
        })

        $('.checked_all').change(function() {
            tr = $(this).closest('tr');
            var checked_all = $(this).prop('checked');

            tr.find('.check_box').each(function(item) {
                if (checked_all === true) {
                    $(this).prop('checked', true)
                } else {
                    $(this).prop('checked', false)
                }
            })
        })
        $('.all_module_check_all').change(function() {
            var all_module_check_all = $(this).prop('checked');
            $('#permission_table > tbody > tr').each((i, tr) => {
                $(tr).find('.check_box').each(function(item) {
                    if (all_module_check_all === true) {
                        $(this).prop('checked', true)
                    } else {
                        $(this).prop('checked', false)
                    }
                })
                $(tr).find('.module_check_all').each(function(item) {
                    if (all_module_check_all === true) {
                        $(this).prop('checked', true)
                    } else {
                        $(this).prop('checked', false)
                    }
                })
                $(tr).find('.checked_all').each(function(item) {
                    if (all_module_check_all === true) {
                        $(this).prop('checked', true)
                    } else {
                        $(this).prop('checked', false)
                    }
                })

            })
        })
        $('.module_check_all').change(function() {
            let moudle_id = $(this).closest('tr').data('moudle');
            if ($(this).prop('checked')) {
                $('.sub_module_permission_' + moudle_id).find('.checked_all').prop('checked', true);
                $('.sub_module_permission_' + moudle_id).find('.check_box').prop('checked', true);
            } else {
                $('.sub_module_permission_' + moudle_id).find('.checked_all').prop('checked', false);
                $('.sub_module_permission_' + moudle_id).find('.check_box').prop('checked', false);
            }
        })
        $(document).on('change', '.view_check_all', function() {
            if ($(this).prop('checked')) {
                $('.check_box_view').prop('checked', true);
            } else {
                $('.check_box_view').prop('checked', false);
            }
        });
        $(document).on('change', '.create_check_all', function() {
            if ($(this).prop('checked')) {
                $('.check_box_create').prop('checked', true);
            } else {
                $('.check_box_create').prop('checked', false);
            }
        });
        $(document).on('change', '.delete_check_all', function() {
            if ($(this).prop('checked')) {
                $('.check_box_delete').prop('checked', true);
            } else {
                $('.check_box_delete').prop('checked', false);
            }
        });

        $(document).on('click', '#submit-btn, #send-btn', function(e) {
            jQuery('#new_employee_form').validate({
                rules: {
                    password: {
                        minlength: 6
                    },
                    password_confirmation: {
                        minlength: 6,
                        equalTo: "#password"
                    }
                }
            });
            if ($('#new_employee_form').valid()) {
                $('form#new_employee_form').submit();
            }
        });

        $(document).on('focusout', '.check_in', function() {
            $('.check_in').val($(this).val())
        })
        $(document).on('focusout', '.check_out', function() {
            $('.check_out').val($(this).val())
        })
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
@endsection
