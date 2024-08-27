@extends('layouts.app')
@section('title', __('lang.printers'))
@section('content')

<section class="forms pt-2">

    <div class="container-fluid">

        <x-page-title>


            <h4 class="print-title">@lang('lang.printers')</h4>
            <x-slot name="buttons">

                <a style="color: white" href="{{route('printers.create')}}" class="btn btn-primary"><i
                        class="dripicons-plus"></i>
                    @lang('lang.add_new_printer')</a>
            </x-slot>
        </x-page-title>



    </div>
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>@lang('lang.name')</th>
                        <th>@lang('lang.status')</th>
                        <th>@lang('lang.is_cashier')</th>
                        <th>@lang('lang.createdBy')</th>
                        <th class="notexport">@lang('lang.action')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($printers as $printer)
                    <tr>
                        <td>
                            {{$printer->name}}
                        </td>
                        <td>
                            {{$printer->Active()}}
                        </td>
                        <td>
                            @if($printer->is_cashier == 1)
                            @lang('lang.available')
                            @else
                            @lang('lang.not_available')
                            @endif
                        </td>
                        <td>
                            {{auth()->user()->name}}
                        </td>
                        <td>
                            <a data-href="{{route('printers.edit', $printer->id)}}" data-container=".view_modal"
                                class="btn btn-primary btn-modal text-white edit_job"><i
                                    class="fa fa-pencil-square-o"></i></a>
                            <a data-href="{{route('printers.addToCashier', $printer->id)}}"
                                class="btn btn-info btn-modal text-white is_cashier"><i
                                    class="fa fa-cash-register"></i></a>
                            <a data-href="{{route('printers.destroy', $printer->id)}}"
                                data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
                                class="btn btn-danger text-white delete_item"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@stop
@section('javascript')
<script>
    $(document).on('click','.is_cashier',function () {
        location.reload();
    });
</script>


@stop
