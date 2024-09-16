@extends('layouts.app')
@section('title', __('lang.employee'))

@section('content')

<section class="forms py-2">

    <div class="container-fluid px-2">

        <x-page-title>

            <h4 class="print-title">@lang('lang.employees')</h4>

            <x-slot name="buttons">
                <div>

                    @can('hr_management.employee.create_and_edit')
                    <a style="color: white" href="{{ action('EmployeeController@create') }}" class="btn btn-primary"><i
                            class="dripicons-plus"></i>
                        @lang('lang.add_new_employee')</a>
                    <a style="color: white" href="{{route('employee.trash')}}" class="btn btn-danger"><i
                            class="dripicons-trash"></i>
                        @lang('lang.trash_employee')</a>
                    @endcan
                </div>
            </x-slot>
        </x-page-title>


        <x-collapse collapse-id="Filter" button-class="d-flex btn-secondary" group-class="mb-1" body-class="py-1">

            <x-slot name="button">
                {{-- @lang('lang.filter') --}}
                <div style="width: 20px">
                    <img class="w-100" src="{{ asset('front/white-filter.png') }}" alt="">
                </div>
            </x-slot>
            <div class="col-md-12">
                <form action="">
                    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('start_date', __('lang.start_date'), ['class' => app()->isLocale('ar') ?
                                'mb-1 label-ar' : 'mb-1 label-en'
                                ]) !!}
                                {!! Form::text('start_date', request()->start_date, ['class' =>
                                'form-control filter']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('start_time', __('lang.start_time'), ['class' => app()->isLocale('ar') ?
                                'mb-1 label-ar' : 'mb-1 label-en'
                                ]) !!}
                                {!! Form::text('start_time', request()->start_time, ['class' =>
                                'form-control time_picker filter']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('end_date', __('lang.end_date'), ['class' => app()->isLocale('ar') ?
                                'mb-1 label-ar' : 'mb-1 label-en'
                                ]) !!}
                                {!! Form::text('end_date', request()->end_date, ['class' => 'form-control
                                filter']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('end_time', __('lang.end_time'), ['class' => app()->isLocale('ar') ?
                                'mb-1 label-ar' : 'mb-1 label-en'
                                ]) !!}
                                {!! Form::text('end_time', request()->end_time, ['class' => 'form-control
                                time_picker filter']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('payment_status', __('lang.payment_status'), ['class' =>
                                app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                                ]) !!}
                                {!! Form::select('payment_status', ['pending' => __('lang.pending'), 'paid'
                                => __('lang.paid')], request()->payment_status, ['class' => 'form-control
                                filter', 'placeholder' => __('lang.all'), 'data-live-search' => 'true']) !!}
                            </div>
                        </div>

                        <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                            <button class="btn btn-primary w-100" type="submit">@lang('lang.filter')</button>
                        </div>
                        <div class="col-md-2 d-flex justify-content-center align-items-end mb-11px">
                            <a href="{{ action('EmployeeController@index') }}"
                                class="btn btn-danger w-100">@lang('lang.clear_filter')</a>
                        </div>
                    </div>
                </form>
            </div>
        </x-collapse>

        <div
            class="top-controls py-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">

        </div>
        <div class="card mt-1 mb-0">
            <div class="card-body py-2 px-4">
                <div class="table-responsive">
                    <table class="table" id="employee_table">
                        <thead>
                            <tr>
                                <th>@lang('lang.profile_photo')</th>
                                <th>@lang('lang.employee_name')</th>
                                <th>@lang('lang.email')</th>
                                <th>@lang('lang.mobile')</th>
                                <th>@lang('lang.job_title')</th>
                                <th class="sum">@lang('lang.wage')</th>
                                <th>@lang('lang.annual_leave_balance')</th>
                                <th>@lang('lang.age')</th>
                                <th>@lang('lang.start_working_date')</th>
                                <th>@lang('lang.current_status')</th>
                                <th>@lang('lang.store')</th>
                                <th>@lang('lang.pos')</th>
                                <th>@lang('lang.commission')</th>
                                <th>@lang('lang.total_paid')</th>
                                <th>@lang('lang.pending')</th>
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- @foreach ($employees as $employee)
                            <tr>
                                <td><img src="@if (!empty($employee->getFirstMediaUrl('employee_photo'))) {{ $employee->getFirstMediaUrl('employee_photo') }}@else{{ asset('/uploads/' . session('logo')) }} @endif"
                                        alt="photo" width="50" height="50">
                                </td>
                                <td>
                                    {{ $employee->name }}
                                </td>
                                <td>
                                    {{ $employee->email }}
                                </td>
                                <td>
                                    {{ $employee->mobile }}
                                </td>
                                <td>
                                    {{ $employee->job_title }}
                                </td>
                                <td>
                                    {{ $employee->fixed_wage_value }}
                                </td>
                                <td>
                                    {{ App\Models\Employee::getBalanceLeave($employee->id) }}
                                </td>
                                <td>
                                    @if (!empty($employee->date_of_birth))
                                    {{
                                    \Carbon\Carbon::parse($employee->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y')
                                    }}
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($employee->date_of_start_working))
                                    {{ @format_date($employee->date_of_start_working) }}
                                    @endif
                                </td>
                                <td>
                                    @php
                                    $today_on_leave = App\Models\Leave::where('employee_id',
                                    $employee->id)
                                    ->whereDate('end_date', '>=', date('Y-m-d'))
                                    ->whereDate('start_date', '<=', date('Y-m-d')) ->where('status',
                                        'approved')
                                        ->first();
                                        @endphp
                                        @if (!empty($today_on_leave))
                                        <label for=""
                                            style="font-weight: bold; color: red">@lang('lang.on_leave')</label>
                                        @else
                                        @php
                                        $status_today = App\Models\Attendance::where('employee_id',
                                        $employee->id)
                                        ->whereDate('date', date('Y-m-d'))
                                        ->first();
                                        @endphp
                                        @if (!empty($status_today))
                                        @if ($status_today->status == 'late' ||
                                        $status_today->status == 'present')
                                        <label for=""
                                            style="font-weight: bold; color: green">@lang('lang.on_duty')</label>
                                        @endif
                                        @if ($status_today->status == 'on_leave')
                                        <label for=""
                                            style="font-weight: bold; color: red">@lang('lang.on_leave')</label>
                                        @endif
                                        @endif
                                        @endif
                                </td>
                                <td>{{ implode(', ', $employee->store->pluck('name')->toArray()) }}
                                </td>
                                <td>{{ $employee->store_pos }}</td>
                                @php
                                $logged_employee = App\Models\Employee::where('user_id',
                                Auth::id())->first();
                                @endphp
                                @if (auth()->user()->can('hr_management.employee_commission.view'))
                                <td>{{ @num_format($employee->total_commission) }}</td>
                                <td>{{ @num_format($employee->total_commission_paid) }}</td>
                                <td>{{ @num_format($employee->total_commission -
                                    $employee->total_commission_paid) }}
                                </td>
                                @elseif($employee->id == $logged_employee->id)
                                <td>{{ @num_format($employee->total_commission) }}</td>
                                <td>{{ @num_format($employee->total_commission_paid) }}</td>
                                <td>{{ @num_format($employee->total_commission -
                                    $employee->total_commission_paid) }}
                                </td>
                                @else
                                <td></td>
                                <td></td>
                                <td></td>
                                @endif

                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">@lang('lang.action')
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                            user="menu">
                                            @can('hr_management.employee.view')
                                            <li>
                                                <a href="{{ action('EmployeeController@show', $employee->id) }}"
                                                    class="btn"><i class="fa fa-eye"></i>
                                                    @lang('lang.view')</a>
                                            </li>
                                            <li class="divider"></li>
                                            @endcan
                                            @can('hr_management.employee.create_and_edit')
                                            <li>
                                                <a href="{{ action('EmployeeController@edit', $employee->id) }}"
                                                    class="btn edit_employee"><i class="fa fa-pencil-square-o"></i>
                                                    @lang('lang.edit')</a>
                                            </li>
                                            <li class="divider"></li>
                                            @endcan
                                            @can('hr_management.employee.delete')
                                            <li>
                                                <a data-href="{{ action('EmployeeController@destroy', $employee->id) }}"
                                                    data-check_password="{{ action('UserController@checkPassword', Auth::user()->id) }}"
                                                    class="btn delete_item text-red"><i class="fa fa-trash"></i>
                                                    @lang('lang.delete')</a>
                                            </li>
                                            @endcan
                                            @can('hr_management.suspend.create_and_edit')
                                            <li>
                                                <a data-href="{{ action('EmployeeController@toggleActive', $employee->id) }}"
                                                    class="btn toggle-active"><i class="fa fa-ban"></i>
                                                    @if ($employee->is_active)
                                                    @lang('lang.suspend')
                                                    @else
                                                    @lang('lang.reactivate')
                                                    @endif
                                                </a>
                                            </li>
                                            @endcan
                                            @can('hr_management.send_credentials.create_and_edit')
                                            <li>
                                                <a href="{{ action('EmployeeController@sendLoginDetails', $employee->id) }}"
                                                    class="btn"><i class="fa fa-paper-plane"></i>
                                                    @lang('lang.send_credentials')</a>
                                            </li>
                                            @endcan
                                            @can('sms_module.sms.create_and_edit')
                                            <li>
                                                <a href="{{ action('SmsController@create', ['employee_id' => $employee->id]) }}"
                                                    class="btn"><i class="fa fa-comments-o"></i>
                                                    @lang('lang.send_sms')</a>
                                            </li>
                                            @endcan
                                            @can('email_module.email.create_and_edit')
                                            <li>
                                                <a href="{{ action('EmailController@create', ['employee_id' => $employee->id]) }}"
                                                    class="btn"><i class="fa fa-envelope "></i>
                                                    @lang('lang.send_email')</a>
                                            </li>
                                            @endcan
                                            @can('hr_management.leaves.create_and_edit')
                                            <li>
                                                <a class="btn btn-modal"
                                                    data-href="{{ action('LeaveController@create', ['employee_id' => $employee->id]) }}"
                                                    data-container=".view_modal">
                                                    <i class="fa fa-sign-out"></i> @lang(
                                                    'lang.leave')
                                                </a>
                                            </li>
                                            @endcan
                                            @can('hr_management.forfeit_leaves.create_and_edit')
                                            <li>
                                                <a class="btn btn-modal"
                                                    data-href="{{ action('ForfeitLeaveController@create', ['employee_id' => $employee->id]) }}"
                                                    data-container=".view_modal">
                                                    <i class="fa fa-ban"></i> @lang(
                                                    'lang.forfeit_leave')
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            @endforeach --}}


                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$currency_symbol}}</td>
                                <td></td>
                                <th style="text-align: right">@lang('lang.total')</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
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
    $(document).on('click', 'a.toggle-active', function(e) {
            e.preventDefault();

            $.ajax({
                method: 'get',
                url: $(this).data('href'),
                data: {},
                success: function(result) {
                    if (result.success == true) {
                        swal(
                            'Success',
                            result.msg,
                            'success'
                        );
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        swal(
                            'Error',
                            result.msg,
                            'error'
                        );
                    }
                },
            });
        });

        $(document).ready(function() {
            employee_table = $("#employee_table").DataTable({
                lengthChange: true,
                paging: true,
                info: false,
                bAutoWidth: false,
                order: [],
                language: {
                    url: dt_lang_url,
                },
                lengthMenu: [
                    [10, 25, 50, 75, 100, 200, 500, -1],
                    [10, 25, 50, 75, 100, 200, 500, "All"],
                ],
                dom: "lBfrtip",
                stateSave: true,
                buttons: buttons,
                processing: true,
                serverSide: true,
                aaSorting: [
                    [0, "desc"]
                ],
                initComplete: function() {
                    $(this.api().table().container()).find('input').parent().wrap('<form>').parent()
                        .attr('autocomplete', 'off');
                },
                ajax: {
                    url: "/hrm/employee",
                    data: function(d) {
                        d.employee_id = $("#employee_id").val();
                        d.method = $("#method").val();
                        d.start_date = $("#start_date").val();
                        d.start_time = $("#start_time").val();
                        d.end_date = $("#end_date").val();
                        d.end_time = $("#end_time").val();
                        d.created_by = $("#created_by").val();
                        d.payment_status = $("#payment_status").val();
                    },
                },
                columnDefs: [{
                        targets: "date",
                        type: "date-eu",
                    },
                    {
                        targets: [7],
                        orderable: false,
                        searchable: false,
                    },
                ],
                columns: [{
                        data: "profile_photo",
                        name: "profile_photo"
                    },
                    {
                        data: "employee_name",
                        name: "employee_name"
                    },
                    {
                        data: "email",
                        name: "email"
                    },
                    {
                        data: "mobile",
                        name: "mobile"
                    },
                    {
                        data: "job_title",
                        name: "job_types.job_title"
                    },
                    {
                        data: "fixed_wage_value",
                        name: "employees.fixed_wage_value"
                    },
                    {
                        data: "annual_leave_balance",
                        name: "annual_leave_balance",
                        searchable: false
                    },
                    {
                        data: "age",
                        name: "age",

                    },
                    {
                        data: "date_of_start_working",
                        name: "date_of_start_working"
                    },
                    {
                        data: "current_status",
                        name: "current_status"
                    },
                    {
                        data: "store",
                        name: "store",
                    },
                    {
                        data: "store_pos",
                        name: "store_pos",
                    },
                    {
                        data: "commission",
                        name: "commission",
                    },
                    {
                        data: "total_paid",
                        name: "total_paid",
                    },
                    {
                        data: "due",
                        name: "due",
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                createdRow: function(row, data, dataIndex) {},
                "footerCallback": function (row, data, start, end, display) {
                var api = this.api(),
                        intVal = function (i) {
                            return typeof i === 'string' ?
                                i.replace(/[, Rs]|(\.\d{2})/g,"")* 1 :
                                typeof i === 'number' ?
                                i : 0;
                        },
                        total2 = api
                            .column(5)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                        totalRows = api.page.info().recordsDisplay;

                    $(api.column(5).footer()).html(
                            total2
                            );
                            $(api.column(0).footer()).html(
                                "{{__('lang.total_rows')}}: " + totalRows
                            );
                },
                fnDrawCallback: function(oSettings) {
                    var intVal = function(i) {
                        return typeof i === "string" ?
                            i.replace(/[\$,]/g, "") * 1 :
                            typeof i === "number" ?
                            i :
                            0;
                    };

                    this.api()
                        .columns(".sum", {
                            page: "current"
                        })
                        .every(function() {
                            var column = this;
                            if (column.data().count()) {
                                var sum = column.data().reduce(function(a, b) {
                                    a = intVal(a);
                                    if (isNaN(a)) {
                                        a = 0;
                                    }

                                    b = intVal(b);
                                    if (isNaN(b)) {
                                        b = 0;
                                    }

                                    return a + b;
                                });
                                $(column.footer()).html(
                                    __currency_trans_from_en(sum, false)
                                );
                            }
                        });
                },
                initComplete: function (settings, json) {
                // Move elements into the .top-controls div after DataTable initializes
                $('.top-controls').append($('.dataTables_length').addClass('d-flex col-lg-3 col-9 mb-3 mb-lg-0 justify-content-center'));
                $('.top-controls').append($('.dt-buttons').addClass('col-lg-6 col-12 mb-3 mb-lg-0 d-flex dt-gap justify-content-center'));
                $('.top-controls').append($('.dataTables_filter').addClass('col-lg-3 col-9'));


                $('.bottom-controls').append($('.dataTables_paginate').addClass('col-lg-2 col-9 p-0'));
                $('.bottom-controls').append($('.dataTables_info'));
                }
            });
            $(document).on('change', '.filter', function() {
                employee_table.ajax.reload();
            });
        })
</script>
@endsection
