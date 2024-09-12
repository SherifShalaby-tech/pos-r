@extends('layouts.app')
@section('title', __('lang.emails'))

@section('content')

<section class="forms pt-2">

    <div class="container-fluid">
        <div class="col-md-12 px-0 no-print">
            <x-page-title>

                <h4 class="print-title">@lang('lang.emails')</h4>

            </x-page-title>

            <div
                class="top-controls py-1 d-flex justify-content-center justify-content-lg-start align-items-center flex-wrap">

            </div>
            <div class="card mt-1 mb-0">
                <div class="card-body py-2 px-4">
                    <div class="table-responsive">
                        <table id="" class="table dataTable" style="width: auto">
                            <thead>
                                <tr>
                                    <th style="width: 10% !important;">@lang('lang.date_and_time')</th>
                                    <th style="width: 10% !important;">@lang('lang.created_by')</th>
                                    <th style="width: 40% !important;">@lang('lang.content')</th>
                                    <th style="width: 10% !important;">@lang('lang.receiver')</th>
                                    <th style="width: 10% !important;">@lang('lang.attachments')</th>
                                    <th style="width: 10% !important;">@lang('lang.notes')</th>
                                    <th style="width: 10% !important;" class="notexport">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($emails as $key)
                                <tr>
                                    <td>{{$key->created_at}}</td>
                                    <td>{{$key->sent_by}}</td>
                                    <td>{!!$key->body!!}</td>
                                    @php
                                    $emails_array = explode(',', $key->emails);
                                    $emails = implode(' ,', $emails_array);
                                    @endphp
                                    <td>{{$emails}}</td>
                                    <td>
                                        @foreach ($key->attachments as $item)
                                        <a target="_blank" href="{{asset($item)}}">{{str_replace('/emails/', '',
                                            $item)}}</a>
                                        <br>
                                        @endforeach
                                    </td>
                                    <td>{{$key->notes}}</td>
                                    <td>
                                        @can('email_module.email.create_and_edit')
                                        <a href="{{action('EmailController@edit', $key->id)}}"
                                            class="btn btn-danger text-white"><i class="fa fa-pencil-square-o"></i></a>
                                        @endcan
                                        @can('email_module.email.delete')
                                        <a data-href="{{action('EmailController@destroy', $key->id)}}"
                                            data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
                                            class="btn btn-danger text-white delete_item"><i
                                                class="fa fa-trash"></i></a>
                                        @endcan
                                        @can('email_module.resend.create_and_edit')
                                        <a href="{{action('EmailController@resend', $key->id)}}"
                                            class="btn btn-danger text-white"><i class="fa fa-paper-plane"></i></a>
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
    </div>
</section>
@endsection

@section('javascript')

@endsection