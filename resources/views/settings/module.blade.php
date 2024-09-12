@extends('layouts.app')
@section('title', __('lang.modules'))

@section('content')

<section class="forms pt-2">

    <div class="container-fluid">
        <div class="col-md-12  no-print">
            <x-page-title>



                <h4>@lang('lang.modules')</h4>
                <x-slot name="buttons">

                </x-slot>
            </x-page-title>
            <div class="card mt-1 mb-0">
                <div class="card-body py-2 px-4">
                    {!! Form::open(['url' => action('SettingController@updateModuleSettings'), 'method' => 'post',
                    'enctype' =>
                    'multipart/form-data']) !!}
                    <div class="row justify-content-center" style="column-gap: 25px">
                        @foreach ($modules as $key => $name)
                        @if(session('system_mode') != 'restaurant' && session('system_mode') != 'garments' &&
                        session('system_mode') != 'pos')
                        @if($key == 'raw_material_module')
                        @continue
                        @endif
                        @endif
                        <div class="col-md-2 card mb-2 px-2 py-3">
                            <div
                                class=" toggle-pill-color d-flex justify-content-center align-items-center flex-column">
                                <input id="{{$loop->index}}" name="module_settings[{{$key}}]" type="checkbox" @if(
                                    !empty($module_settings[$key]) ) checked @endif value="1"
                                    class="form-control-custom">
                                <label for="{{$loop->index}}"></label>
                                <span class="text-center py-2 d-flex justify-content-center align-items-center">
                                    <strong>

                                        {{__('lang.'.$key)}}
                                    </strong>

                                </span>
                            </div>

                        </div>
                        @endforeach
                    </div>
                    <br>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                    </div>
                    {!! Form::close() !!}
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