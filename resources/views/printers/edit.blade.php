{{-- <style src="{{ asset('css/bootstrap-select.min.css') }}"></style> --}}
<!-- Modal -->
<div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <x-modal-header>

            <h5 class="modal-title" id="edit">@lang('lang.edit')</h5>

        </x-modal-header>

        {!! Form::open(['url' => route('printers.update','test'), 'method' => 'POST']) !!}
        @method('put')
        @csrf
        <input type="hidden" name="id" value="{{$printer->id}}">
        <div class="modal-body">
            <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                            for="name">@lang('lang.name')</label>
                        <input type="text" class="form-control" value="{{$printer->name}}" name="name" id="name"
                            required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                            for="products">{{trans('lang.products')}}</label>
                        <div class="input-group my-group">
                            <select id="products" data-live-search="true" class="selectpicker form-control"
                                name="products[]" multiple>
                                @foreach($products as $product)
                                @php
                                $selected = $products_printers->contains('product_id', $product->id) ? 'selected' : '';
                                @endphp
                                <option value="{{$product->id}}" {{$selected}}>{{$product->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                            for="stores">{{trans('lang.stores')}}</label>
                        <div class="input-group my-group">
                            <select id="store_id" class="selectpicker form-control" name="store_id" required>
                                <option value="">please select</option>
                                @foreach($stores as $store)
                                @php
                                $selected_s = ($printer->store_id && $store->id == $printer->store_id) ? 'selected' :
                                '';
                                @endphp
                                <option value="{{$store->id}}" {{$selected_s}}>{{$store->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                            for="is_active">{{trans('lang.status')}}</label>
                        <div class="input-group my-group">
                            <select id="is_active" class="form-control" name="is_active">
                                <option {{$printer->is_active == true ? 'selected' : ''}}
                                    value="1">{{trans('lang.active')}}</option>
                                <option {{$printer->is_active == false ? 'selected' : ''}}
                                    value="0">{{trans('lang.not_active')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-6">@lang('lang.save')</button>
            <button type="button" class="btn btn-default col-6" data-dismiss="modal">Close</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.selectpicker').selectpicker();
        }, 100); // Delay in milliseconds (adjust as needed)
    });
</script>
