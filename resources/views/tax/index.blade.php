@extends('layouts.app')
@section('title', __('lang.tax'))

@section('content')

<section class="forms py-2">

    <div class="container-fluid px-2">


        <x-page-title>


            @if($_SERVER["QUERY_STRING"]=="type=product_tax")
            <h4 class="print-title">@lang('lang.product_taxes')</h4>
            @else
            <h4 class="print-title">@lang('lang.general_tax')</h4>
            @endif

            <x-slot name="buttons">
                @if(env('ISCREATTAX',true) || auth()->user()->email == env(
                'SYSTEM_SUPERADMIN','superadmin@sherifshalaby.tech'))
                <a style="color: white" data-href="{{ action('TaxController@create') }}?type={{ $type }}"
                    data-container=".view_modal" class="btn btn-modal btn-primary"><i class="dripicons-plus"></i>
                    @lang('lang.add')</a>
                @endif
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
                                <th>@lang('lang.rate_percentage')</th>
                                @if ($type == 'general_tax')
                                <th>@lang('lang.tax_method')</th>
                                <th>@lang('lang.status')</th>
                                <th>@lang('lang.status_for_stores')</th>
                                @endif
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($taxes as $tax)
                            <tr>
                                <td>{{ $tax->name }}</td>
                                <td>{{ $tax->rate }}</td>
                                @if ($type == 'general_tax')
                                <td>{{ ucfirst($tax->tax_method) }}</td>
                                <td>
                                    @if ($tax->status == 1)
                                    @lang('lang.enable')
                                    @else
                                    @lang('lang.disabled')
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($tax->store_ids))
                                    {{ implode(',', $tax->stores->pluck('name')->toArray()) }}
                                    @else
                                    @lang('lang.all_stores')
                                    @endif
                                </td>
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
                                            @can('product_module.tax.create_and_edit')
                                            <li>
                                                <a data-href="{{ action('TaxController@edit', $tax->id) }}"
                                                    class="btn-modal" data-container=".view_modal"><i
                                                        class="dripicons-document-edit btn"></i>@lang('lang.edit')</a>
                                            </li>
                                            <li class="divider"></li>
                                            @endcan
                                            @can('product_module.tax.delete')
                                            <li>
                                                <a data-href="{{ action('TaxController@destroy', $tax->id) }}"
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
                        <tfoot>
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
<script></script>
@endsection
