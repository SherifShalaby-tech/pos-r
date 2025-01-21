<div class="modal-dialog" role="document" style="max-width: 50%;">
    <div class="modal-content">
        {!! Form::open(['url' => action('PaymentMethodTypeController@storeType'), 'method' => 'post' ]) !!}

        <div class="modal-header">

            <h4 class="modal-title">{{ $payment_method->name }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <input type="hidden" name="payment_method_id" value="{{ $payment_method->id }}">

            <div id="type-fields-container" class="col-md-12">
                <!-- First input group -->
                <div class="type-input-group row mb-3">
                    <div class="col-md-8 px-4">
                        <div class="mb-3">
                            <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('name[]', __( 'lang.name' ), ['class' => app()->isLocale('ar') ? 'mb-1
                                label-ar' : 'mb-1 label-en']) !!}
                                <span class="text-danger">*</span>
                            </div>
                            {!! Form::text('name[]', null, ['class' => 'form-control', 'placeholder' => __( 'lang.name'
                            ), 'required']) !!}
                        </div>
                    </div>
                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                        <div class="i-checks ">
                            <input id="is_active_0" name="is_active[]" type="checkbox" checked
                                class="form-control-custom">
                            <label for="is_active_0">
                                <strong>@lang( 'lang.is_active' )</strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-danger remove-type-field"><i
                                class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>

            <!-- Add more button -->
            <div class="col-md-12">
                <button type="button" class="btn btn-primary w-25 mx-auto d-block add-type-field"
                    style="font-weight: 700">
                    +
                </button>
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
    // Add a new input group
    document.querySelector('.add-type-field').addEventListener('click', function () {
        const container = document.getElementById('type-fields-container');
        const count = container.querySelectorAll('.type-input-group').length;

        const newGroup = `
            <div class="type-input-group row mb-3">
                <div class="col-md-8 px-4">
                    <div class="mb-3">
                        <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('name[]', __( 'lang.name' ), ['class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en']) !!}
                            <span class="text-danger">*</span>
                        </div>
                        {!! Form::text('name[]', null, ['class' => 'form-control', 'placeholder' => __( 'lang.name' ), 'required']) !!}
                    </div>
                </div>
                <div class="col-md-2 d-flex justify-content-center align-items-center">
                    <div class="i-checks toggle-pill-color d-flex justify-content-center align-items-center flex-column">
                        <input id="is_active_${count}" name="is_active[]" type="checkbox" checked class="form-control-custom">
                        <label for="is_active_${count}"></label>
                        <span><strong>@lang( 'lang.is_active' )</strong></span>
                    </div>
                </div>
                <div class="col-md-2 d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-danger remove-type-field"><i class="fa fa-trash"></i></button>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', newGroup);
        attachRemoveHandlers(); // Reattach remove handlers
    });

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