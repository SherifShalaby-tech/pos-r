@extends('layouts.app')
@section('title', __('lang.productions'))

@section('content')
<div class="container-fluid">

    <div class="col-md-12  no-print">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                @can('raw_material_module.production.create_and_edit')
                <a style="color: white" href="{{action('ManufacturingController@create')}}"
                     class="btn btn-info"><i class="dripicons-plus"></i>
                    @lang('lang.add_new_production')</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="store_table" class="table dataTable">
                        <thead>
                            <tr>
                                <th >@lang('lang.store')</th>
                                <th>@lang('lang.manufacturer')</th>
                                <th>@lang('lang.raw_material')</th>
                                <th>@lang('lang.quantity')</th>
                                <th>@lang('lang.manufacturing_date')</th>
                                <th>@lang('lang.created_by')</th>
                                <th>@lang('lang.edited_by')</th>
                                @if (auth()->user()->can('superadmin') || auth()->user()->is_admin == 1)
                                    <th class="notexport">@lang('lang.action')</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($manufacturings as $manufacturing)
                            <tr>
                                <td>{{$manufacturing->store->name ??""}}</td>
                                <td>{{$manufacturing->manufacturer->name ??""}}</td>
                                <td>
                                    @foreach($manufacturing->materials as $material)
                                        {{$material->product->name ??""}}  <br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($manufacturing->materials as $material)
                                          {{$material->quantity ??""}}  GM<br>
                                    @endforeach
                                </td>
                                <td>{{date('Y/m/d H:i',strtotime($manufacturing->created_at))}}</td>
                                <td>{{$manufacturing->createdUser->name ??""}}</td>
                                <td>{{$manufacturing->editedUser->name ??""}}</td>
                                @if (auth()->user()->can('superadmin') || auth()->user()->is_admin == 1)
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
                                                <li>
                                                    <a href="{{action('ManufacturingController@edit', $manufacturing->id)}}" class="btn "><i
                                                            class="dripicons-retweet"></i> @lang('lang.manufacturing_status')</a>
                                                </li>
                                                <li>
{{--                                                    {{route('productions.edit', $manufacturing->id)}}--}}
                                                    <a href="#" class="btn "><i
                                                            class="dripicons-document-edit"></i> @lang('lang.edit')</a>
                                                </li>
                                                <li class="divider"></li>
                                               <li>
{{--                                                   {{route('productions.delete', $manufacturing->id)}}--}}
                                                    <a data-href="#"
                                                        data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
                                                        class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                        @lang('lang.delete')</a>
                                                </li>

                                            </ul>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')

@endsection
