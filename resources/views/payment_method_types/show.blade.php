<div class="modal-dialog" role="document" style="max-width: 50%">
    <div class="modal-content">
        {!! Form::open(['url' => action('PaymentMethodTypeController@updateTypes', $payment_method->id), 'method' =>
        'put']) !!}

        <x-modal-header>
            <h4 class="modal-title">{{ $payment_method->name }}</h4>
        </x-modal-header>

        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div id="type-fields-container" class="col-md-12">
                @foreach ($payment_method->paymentMethodTypes as $type)
                <div class="type-input-group row mb-3" data-type-id="{{ $type->id }}">
                    <div class="col-md-8 px-4">
                        <div class="form-group">
                            <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('name', __( 'lang.name' ), ['class' => app()->isLocale('ar') ? 'mb-1
                                label-ar' :
                                'mb-1 label-en']) !!}
                                <span class="text-danger">*</span>
                            </div>
                            {!! Form::text("types[{$type->id}][name]", $type->name, ['class' => 'form-control',
                            'placeholder' => __(
                            'lang.name' ), 'required']) !!}
                        </div>
                    </div>

                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                        <div
                            class="i-checks toggle-pill-color d-flex justify-content-center align-items-center flex-column">
                            <!-- Hidden input for unchecked state -->
                            <input type="hidden" name="types[{{ $type->id }}][is_active]" value="0">
                            <!-- Checkbox for active state -->
                            <input id="is_active_{{ $type->id }}" name="types[{{ $type->id }}][is_active]"
                                type="checkbox" value="1" @if ($type->is_active) checked @endif
                            class="form-control-custom">
                            <label for="is_active_{{ $type->id }}"></label>
                            <span><strong>@lang( 'lang.is_active' )</strong></span>
                        </div>
                    </div>

                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-danger remove-type-field"><i
                                class="fa fa-trash"></i></button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-6">@lang( 'lang.save' )</button>
            <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang( 'lang.close' )</button>
        </div>

        {!! Form::close() !!}
    </div>
</div>

<script>
    // Attach remove button functionality
    function attachRemoveHandlers() {
        document.querySelectorAll('.remove-type-field').forEach(function (button) {
            button.addEventListener('click', function () {
                const group = button.closest('.type-input-group');
                group.remove();
            });
        });
    }

    // Attach handlers for the initial elements
    attachRemoveHandlers();
</script>
