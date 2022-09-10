@extends('layouts.app')
@section('title', __('lang.productions'))

@section('content')
<div class="container-fluid">

    <div class="col-md-12  no-print">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                @can('raw_material_module.production.create_and_edit')
                <a style="color: white" href="{{route('recipeUesd.show.sendUesd',1)}}"
                     class="btn btn-info"><i class="dripicons-plus"></i>
                    @lang('lang.add_new_production')</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="store_table" class="table dataTable">
                        <thead>
                            <tr>
                                <th >@lang('lang.name')</th>
                                <th>@lang('lang.raw_material')</th>
                                <th>@lang('lang.unit')</th>
                                <th>@lang('lang.cost')</th>
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
                            @foreach($recipes as $recipe)
                            <tr>
                            {{--                                <td>{{$recipe->variation_name == 'Default' ? $recipe->material_name : $recipe->variation_name}}{{ '('.$recipe->name.')'}}</td>--}}
                                <td>{{$recipe->name}}</td>

                                <td>{{$recipe->variation_name == 'Default' ? $recipe->material_name : $recipe->variation_name }}</td>

                                <td>{{$recipe->unit_name}}</td>
                                <td>{{ number_format($recipe->purchase_price,3,'.','')}}</td>
                                <td>
                                  {{$recipe->quantity_product}}
                                </td>
                                <td>{{date('Y/m/d H:i',strtotime($recipe->created_at))}}</td>

                                <td>{{$recipe->created_by_name}}</td>
                                <td>{{$recipe->edited_by_name}}</td>
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

                                                    <a href="{{route('productions.edit', $recipe->id)}}" class="btn "><i
                                                            class="dripicons-document-edit"></i> @lang('lang.edit')</a>
                                                </li>
                                                <li class="divider"></li>
                                               <li>
                                                    <a data-href="{{route('productions.delete', $recipe->id)}}"
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
