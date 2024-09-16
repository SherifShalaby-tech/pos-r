@extends('layouts.app')
@section('title', __('lang.delivery_zone'))

@section('content')
<section class="forms py-2">

    <div class="container-fluid px-2">

        <div class="col-md-12 px-0 no-print">
            <x-page-title>


                <h4 class="print-title">@lang('lang.delivery_zone')</h4>
                <x-slot name="buttons">

                    @can('settings.delivery_zone.create_and_edit')
                    <a style="color: white" data-href="{{ action('DeliveryZoneController@create') }}"
                        data-container=".view_modal" class="btn btn-modal btn-primary"><i class="dripicons-plus"></i>
                        @lang('lang.add_delivery_zone')</a>
                    @endcan
                </x-slot>
            </x-page-title>
            <div
                class="top-controls py-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">

            </div>
            <div class="card mt-1 mb-0">
                <div class="card-body py-2 px-4">
                    <div class="table-responsive">
                        <table id="store_table" class="table dataTable">
                            <thead>
                                <tr>
                                    <th>@lang('lang.name')</th>
                                    <th>@lang('lang.coverage_area')</th>
                                    <th>@lang('lang.deliveryman')</th>
                                    <th>@lang('lang.cost')</th>
                                    <th>@lang('lang.created_by')</th>
                                    <th>@lang('lang.edited_by')</th>
                                    <th class="notexport">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($delivery_zones as $delivery_zone)
                                <tr>
                                    <td>{{ $delivery_zone->name }}</td>
                                    <td>{{ $delivery_zone->coverage_area }}</td>
                                    <td>{{ $delivery_zone->deliveryman->employee_name ?? '' }}</td>
                                    <td>{{ @num_format($delivery_zone->cost) }}</td>
                                    <td>{{ $delivery_zone->created_by_user->name ?? '' }}</td>
                                    <td>{{ $delivery_zone->edited_by_user->name ?? '' }}</td>

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
                                                @can('settings.delivery_zone.create_and_edit')
                                                <li>

                                                    <a data-href="{{ action('DeliveryZoneController@edit', $delivery_zone->id) }}"
                                                        data-container=".view_modal" class="btn btn-modal"><i
                                                            class="dripicons-document-edit"></i> @lang('lang.edit')</a>
                                                </li>
                                                <li class="divider"></li>
                                                @endcan
                                                @can('settings.delivery_zone.delete')
                                                <li>
                                                    <a data-href="{{ action('DeliveryZoneController@destroy', $delivery_zone->id) }}"
                                                        data-check_password="{{ action('UserController@checkPassword', Auth::user()->id) }}"
                                                        class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                        @lang('lang.delete')</a>
                                                </li>
                                                @endcan
                                            </ul>
                                        </div>
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
    </div>

</section>
@endsection

@section('javascript')

@endsection
