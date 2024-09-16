@extends('layouts.app')
@section('title', __('lang.recipe'))

@section('content')
<section class="forms py-2">

    <div class="container-fluid px-2">
        <div class="col-md-12 px-0 no-print">

            <x-page-title>


                <x-slot name="buttons">
                    @can('raw_material_module.recipe.create_and_edit')
                    <a style="color: white" href="{{action('RecipeController@create')}}" class="btn btn-primary"><i
                            class="dripicons-plus"></i>
                        @lang('lang.add_recipe')</a>
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
                                    <th>@lang('lang.raw_material')</th>
                                    <th>@lang('lang.unit')</th>
                                    <th>@lang('lang.cost')</th>
                                    <th>@lang('lang.active')</th>
                                    <th>@lang('lang.manufacturing_date')</th>
                                    <th>@lang('lang.created_by')</th>
                                    <th>@lang('lang.edited_by')</th>

                                    <th class="notexport">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recipes as $recipe)
                                <tr>
                                    {{-- <td>{{$recipe->variation_name == 'Default' ? $recipe->material_name :
                                        $recipe->variation_name}}{{ '('.$recipe->name.')'}}</td>--}}
                                    <td>{{$recipe->name}}</td>

                                    <td>{{$recipe->variation_name == 'Default' ? $recipe->material_name :
                                        $recipe->variation_name }}</td>

                                    <td>{{$recipe->unit_name}}</td>
                                    <td>{{ number_format($recipe->purchase_price,3,'.','')}}</td>
                                    <td>
                                        @if($recipe->active)
                                        {{__('lang.yes')}}
                                        @else
                                        {{ __('lang.no')}}
                                        @endif
                                    </td>
                                    <td>{{date('Y/m/d H:i',strtotime($recipe->created_at))}}</td>

                                    <td>{{$recipe->created_by_name}}</td>
                                    <td>{{$recipe->edited_by_name}}</td>

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
                                                @can('raw_material_module.recipe.create_and_edit')
                                                <li>

                                                    <a href="{{action('RecipeController@edit', $recipe->id)}}"
                                                        class="btn "><i class="dripicons-document-edit"></i>
                                                        @lang('lang.edit')</a>
                                                </li>
                                                <li class="divider"></li>

                                                @endcan
                                                @can('raw_material_module.production.create_and_edit')
                                                <li>

                                                    <a href="{{route('recipeUesd.show.sendUesd', $recipe->id)}}"
                                                        class="btn "><i class="dripicons-browser-upload"></i>
                                                        @lang('lang.used')</a>
                                                </li>

                                                <li class="divider"></li>
                                                @endcan
                                                @can('raw_material_module.recipe.delete')
                                                <li>
                                                    <a data-href="{{action('RecipeController@destroy', $recipe->id)}}"
                                                        data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
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
