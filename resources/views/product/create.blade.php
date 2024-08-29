@extends('layouts.app')
@section('title', __('lang.product'))
@section('content')
<style>
    .preview-class-container {
        /* display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px; */
        display: grid;
        grid-template-columns: repeat(auto-fill, 170px);
    }

    .preview {
        position: relative;
        width: 150px;
        height: 150px;
        padding: 4px;
        box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        margin: 30px 0px;
        border: 1px solid #ddd;
    }

    .preview img {
        width: 100%;
        height: 100%;
        box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        border: 1px solid #ddd;
        object-fit: cover;

    }

    .delete-btn {
        position: absolute;
        top: 156px;
        right: 0px;
        /*border: 2px solid #ddd;*/
        border: none;
        cursor: pointer;
    }

    .delete-btn {
        background: transparent;
        color: rgba(235, 32, 38, 0.97);
    }

    .crop-btn {
        position: absolute;
        top: 156px;
        left: 0px;
        /*border: 2px solid #ddd;*/
        border: none;
        cursor: pointer;
        background: transparent;
        color: #007bff;
    }
</style>
<section class="forms pt-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>

                    <h4>@lang('lang.add_new_product')</h4>

                    <x-slot name="buttons">

                    </x-slot>
                </x-page-title>


                <div class="card">

                    <div class="card-body">
                        <p class="italic"><small>@lang('lang.required_fields_info')</small></p>
                        {!! Form::open(['url' => action('ProductController@store'), 'id' => 'product-form', 'method' =>
                        'POST', 'class' => '', 'enctype' => 'multipart/form-data']) !!}
                        @include('product.partial.create_product_form')
                        <div class="row">
                            <div class="col-md-4 mt-5">
                                <div class="form-group">
                                    <input type="button" value="{{ trans('lang.save') }}" id="submit-btn"
                                        class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                        <div id="cropped_images"></div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="product_cropper_modal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <x-modal-header>

                <h5 class="modal-title">@lang('lang.crop_image_before_upload')</h5>

            </x-modal-header>

            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img src="" id="product_sample_image" />
                        </div>
                        <div class="col-md-4">
                            <div class="product_preview_div"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="product_crop" class="btn btn-primary col-6">@lang('lang.crop')</button>
                <button type="button" class="btn btn-default col-6" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <x-modal-header>
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            </x-modal-header>

            <div class="modal-body">
                <div id="croppie-modal" style="display:none">
                    <div id="croppie-container"></div>
                    <button data-dismiss="modal" id="croppie-cancel-btn" type="button" class="btn btn-secondary"><i
                            class="fas fa-times"></i></button>
                    <button id="croppie-submit-btn" type="button" class="btn btn-primary"><i
                            class="fas fa-crop"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')

<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
{{-- <script src="{{ asset('js/sweetalert2.min.js') }}"></script> --}}

<script>
    const fileInput = document.querySelector('#file-input');
        const previewContainer = document.querySelector('.preview-container');
        const croppieModal = document.querySelector('#croppie-modal');
        const croppieContainer = document.querySelector('#croppie-container');
        const croppieCancelBtn = document.querySelector('#croppie-cancel-btn');
        const croppieSubmitBtn = document.querySelector('#croppie-submit-btn');

        // let currentFiles = [];
        fileInput.addEventListener('change', () => {
            // let files = fileInput.files;
            previewContainer.innerHTML = '';
            let files = Array.from(fileInput.files)
            // files.concat(currentFiles)
            // currentFiles.push(...files)
            // currentFiles && (files = currentFiles)
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                let fileType = file.type.slice(file.type.indexOf('/') + 1);
                let FileAccept = ["jpg","JPG","jpeg","JPEG","png","PNG","BMP","bmp"];
                if (FileAccept.includes(fileType))  {
                    const reader = new FileReader();
                    reader.addEventListener('load', (e) => {
                        // e.preventDefault();
                        const preview = document.createElement('div');
                        preview.classList.add('preview');
                        const img = document.createElement('img');
                        const actions = document.createElement('div');
                        actions.classList.add('action_div');
                        img.src = reader.result;
                        preview.appendChild(img);
                        preview.appendChild(actions);

                        const container = document.createElement('div');
                        const deleteBtn = document.createElement('span');
                        deleteBtn.classList.add('delete-btn');
                        deleteBtn.innerHTML = '<i style="font-size: 20px;" class="fas fa-trash"></i>';
                        deleteBtn.addEventListener('click', (e) => {
                            swal({
                            title: '{{ __("Are you sure?") }}',
                            text: "{{ __("You will not be able to delete!") }}",
                            icon: 'warning',
                            buttons: true,
                            dangerMode: true,
                            buttons: ["Cancel", "Yes, delete it!"],
                            }).then((result) => {
                                console.log(result);
                                if (result) {
                                    swal(
                                        'Deleted!',
                                        '{{ __("site.Your Image has been deleted.") }}',
                                        'success'
                                    )
                                    files.splice(file, 1)
                                    preview.remove();
                                    getImages()
                                }
                            });
                        });

                        preview.appendChild(deleteBtn);
                        const cropBtn = document.createElement('span');
                        cropBtn.setAttribute("data-toggle", "modal")
                        cropBtn.setAttribute("data-target", "#exampleModal")
                        cropBtn.classList.add('crop-btn');
                        cropBtn.innerHTML = '<i style="font-size: 20px;" class="fas fa-crop"></i>';
                        cropBtn.addEventListener('click', (e) => {
                            // e.preventDefault();
                            setTimeout(() => {
                                launchCropTool(img);
                            }, 500);
                        });
                        preview.appendChild(cropBtn);
                        previewContainer.appendChild(preview);
                    });
                    reader.readAsDataURL(file);
                }else{
                    swal({
                        icon: 'error',
                        title: '{{ __("site.Oops...") }}',
                        text: '{{ __("site.Sorry , You Should Upload Valid Image") }}',
                    })
                }
            }

            getImages()
        });
        function launchCropTool(img) {
            // Set up Croppie options
            const croppieOptions = {
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'square' // or 'square'
                },
                boundary: {
                    width: 300,
                    height: 300,
                },
                enableOrientation: true
            };

            // Create a new Croppie instance with the selected image and options
            const croppie = new Croppie(croppieContainer, croppieOptions);
            croppie.bind({
                url: img.src,
                orientation: 1,
            });

            // Show the Croppie modal
            croppieModal.style.display = 'block';

            // When the user clicks the "Cancel" button, hide the modal
            croppieCancelBtn.addEventListener('click', (e) => {
                e.preventDefault();
                croppieModal.style.display = 'none';
                $('#exampleModal').modal('hide');
                croppie.destroy();
            });

            // When the user clicks the "Crop" button, get the cropped image and replace the original image in the preview
            croppieSubmitBtn.addEventListener('click', (e) => {
                // e.preventDefault();
                croppie.result('base64').then((croppedImg) => {
                    img.src = croppedImg;
                    croppieModal.style.display = 'none';
                    $('#exampleModal').modal('hide');
                    croppie.destroy();
                    getImages()
                });
            });
        }

        function getImages() {
            console.log("tees");
            setTimeout(() => {
                const container = document.querySelectorAll('.preview-container');
                let images = [];
                $("#cropped_images").empty();
                for (let i = 0; i < container[0].children.length; i++) {
                    images.push(container[0].children[i].children[0].src)
                    var newInput = $("<input>").attr("type", "hidden").attr("name", "cropImages[]").val(container[0].children[i].children[0].src);
                    $("#cropped_images").append(newInput);
                }
                console.log(images);
                return images
            }, 300);
        }

</script>

<script>
    function get_unit(units,row_id) {
            $v=document.getElementById('select_unit_id_'+row_id).value;

            $.each(units, function(key, value) {
                if($v == key){
                    $('#number_vs_base_unit_'+row_id).val(value);
                    if(value == 1){
                        $('#number_vs_base_unit_'+row_id).attr("disabled", true);
                    }else{
                        $('#number_vs_base_unit_'+row_id).attr("disabled", false);
                    }

                    // console.log(value);
                }
            });
        }
</script>
<script src="{{ asset('js/product.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
            $('#discount_customer_types').selectpicker('selectAll');
            $('#category_id').change();

            if($('#is_service').prop('checked')){
                $('.supplier_div').removeClass('hide');
            }else{
                $('.supplier_div').addClass('hide');
            }
        });
        $('.v_unit').on('change', function() {
            alert( this.value );
        });

        $(document).ready(function() {
        // Event listener for select change
        $('#selectStore').on('change', function() {
            // Get the selected option value
            var selectedOption = $(this).val();

            // Send AJAX request
            $.ajax({
            url: '/get-printers',
            type: 'GET',
            data: { printer_store_id: selectedOption },
            success: function(response) {
                // Handle the AJAX response
                console.log('AJAX request successful');
                console.log(response);
                // Update the printers list in the container element
                var printersContainer = $('#printersContainer');
                printersContainer.empty(); // Clear previous printers

                $.each(response, function(index, printer) {
                    var checkbox = $('<input>')
                    .attr('type', 'checkbox')
                    .attr('name', 'printers[]')
                    .val(printer.id);

                    var label = $('<label>')
                    .addClass('m-auto')
                    .attr('for', 'printer' + printer.id)
                    .text(printer.name);

                    var div = $('<div>').addClass('row').append(checkbox, label);
                    printersContainer.append(div);
                });
            },
            error: function(xhr, status, error) {
                // Handle AJAX errors
                console.log('AJAX request failed');
                console.log(xhr.responseText);
            }
            });
        });
    });
</script>
@endsection
