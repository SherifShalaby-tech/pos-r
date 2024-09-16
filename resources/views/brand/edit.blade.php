<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
<style>
    .preview-category-container {
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
<style>
    .variants {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .variants>div {
        margin-right: 5px;
    }

    .variants>div:last-of-type {
        margin-right: 0;
    }

    .file {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .file>input[type='file'] {
        display: none
    }

    .file>label {
        font-size: 1rem;
        font-weight: 300;
        cursor: pointer;
        outline: 0;
        user-select: none;
        border-color: rgb(216, 216, 216) rgb(209, 209, 209) rgb(186, 186, 186);
        border-style: solid;
        border-radius: 4px;
        border-width: 1px;
        background-color: hsl(0, 0%, 100%);
        color: hsl(0, 0%, 29%);
        padding-left: 16px;
        padding-right: 16px;
        padding-top: 16px;
        padding-bottom: 16px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .file>label:hover {
        border-color: hsl(0, 0%, 21%);
    }

    .file>label:active {
        background-color: hsl(0, 0%, 96%);
    }

    .file>label>i {
        padding-right: 5px;
    }

    .file--upload>label {
        color: var(--primary-color);
        border: 2px dashed var(--primary-color);
    }

    .file--upload>label:hover {
        border-color: var(--primary-color-hover);
        border: 2px dashed var(--primary-color-hover);
    }

    .file--upload>label:active {
        background-color: hsl(0, 0%, 89%);
    }

    .file--uploading>label {
        color: hsl(48, 100%, 67%);
        border-color: hsl(48, 100%, 67%);
    }

    .file--uploading>label>i {
        animation: pulse 5s infinite;
    }

    .file--uploading>label:hover {
        border-color: hsl(48, 100%, 67%);
        background-color: hsl(48, 100%, 96%);
    }

    .file--uploading>label:active {
        background-color: hsl(48, 100%, 91%);
    }

    .file--success>label {
        color: hsl(141, 71%, 48%);
        border-color: hsl(141, 71%, 48%);
    }

    .file--success>label:hover {
        border-color: hsl(141, 71%, 48%);
        background-color: hsl(141, 71%, 96%);
    }

    .file--success>label:active {
        background-color: hsl(141, 71%, 91%);
    }

    .file--danger>label {
        color: hsl(348, 100%, 61%);
        border-color: hsl(348, 100%, 61%);
    }

    .file--danger>label:hover {
        border-color: hsl(348, 100%, 61%);
        background-color: hsl(348, 100%, 96%);
    }

    .file--danger>label:active {
        background-color: hsl(348, 100%, 91%);
    }

    .file--disabled {
        cursor: not-allowed;
    }

    .file--disabled>label {
        border-color: #e6e7ef;
        color: #e6e7ef;
        pointer-events: none;
    }


    @keyframes pulse {
        0% {
            color: hsl(48, 100%, 67%);
        }

        50% {
            color: hsl(48, 100%, 38%);
        }

        100% {
            color: hsl(48, 100%, 67%);
        }
    }
</style>
<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('BrandController@update', $brand->id), 'method' => 'put', 'id' =>
        'brand_edit_form', 'files' => true ]) !!}

        <x-modal-header>
            <h4 class="modal-title">@lang( 'lang.edit' )</h4>
        </x-modal-header>



        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('name', __( 'lang.name' ) ,[
                        'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                        ]) !!}
                        <span class="text-danger">*</span>
                    </div>
                    {!! Form::text('name', $brand->name, ['class' => 'form-control', 'placeholder' => __( 'lang.name' ),
                    'required' ])
                    !!}
                </div>
            </div>

            <div class="col-md-12">

                <div class="form-group">
                    <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                        for="projectinput2"> {{ __('categories.image') }}</label>

                    <div class="row">
                        <div class="col-12">
                            <div class="variants">
                                <div class='file file--upload w-100'>
                                    <label for='file-input-edit-brand' class="w-100">
                                        <i class="fas fa-cloud-upload-alt"></i>Upload
                                    </label>
                                    <input type="file" id="file-input-edit-brand">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center">
                            <div class="preview-edit-brand-container d-flex justify-content-center">
                                @if($brand)
                                <div id="preview{{ $brand->id }}" class="preview">
                                    @if (!empty($brand->getFirstMediaUrl('brand')))
                                    <img src="{{ $brand->getFirstMediaUrl('brand') }}" id="img{{  $brand->id }}" alt="">
                                    @else
                                    <img src="{{ asset('/uploads/'.session('logo')) }}" alt=""
                                        id="img{{  $brand->id }}">
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                {{-- @include('layouts.partials.image_crop', ['image_url' => $brand->getFirstMediaUrl('brand') ??
                null])--}}
            </div>
        </div>
        <div id="cropped_edit_brand_images"></div>
        <div class="modal-footer">
            <button id="submit-edit-brand-btn" class="btn btn-primary  col-6  ">@lang( 'lang.update' )</button>
            <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang( 'lang.close' )</button>
        </div>

        {!! Form::close() !!}
        <div class="modal fade" id="editBrandModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <x-modal-header>

                        <h5 class="modal-title" id="editBrandModalLabel">Modal title</h5>

                    </x-modal-header>

                    <div class="modal-body">
                        <div id="croppie-modal-brand-edit" style="display:none">
                            <div id="croppie-container-brand-edit"></div>
                            <button data-dismiss="modal" id="croppie-cancel-btn-brand-edit" type="button"
                                class="btn btn-secondary"><i class="fas fa-times"></i></button>
                            <button id="croppie-submit-btn-brand-edit" type="button" class="btn btn-primary"><i
                                    class="fas fa-crop"></i></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


<script>
    $('#brand_category_id').selectpicker('render')
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script>
    $("#submit-edit-brand-btn").on("click",function (e){
        e.preventDefault();
        getEditBrandImages();
        setTimeout(()=>{
            $("#brand_edit_form").submit();
        },500)
    });

    const fileEditBrandInput = document.querySelector('#file-input-edit-brand');
    const previewEditBrandContainer = document.querySelector('.preview-edit-brand-container');
    const croppieEditBrandModal = document.querySelector('#croppie-modal-brand-edit');
    const croppieEditBrandContainer = document.querySelector('#croppie-container-brand-edit');
    const croppieEditBrandCancelBtn = document.querySelector('#croppie-cancel-btn-brand-edit');
    const croppieEditBrandSubmitBtn = document.querySelector('#croppie-submit-btn-brand-edit');
    // let currentFiles = [];
    fileEditBrandInput.addEventListener('change', () => {
        previewEditBrandContainer.innerHTML = '';
        let files = Array.from(fileEditBrandInput.files)
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            let fileType = file.type.slice(file.type.indexOf('/') + 1);
            let FileAccept = ["jpg","JPG","jpeg","JPEG","png","PNG","BMP","bmp"];
            // if (file.type.match('image.*')) {
            if (FileAccept.includes(fileType)) {
                const reader = new FileReader();
                reader.addEventListener('load', () => {
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
                    deleteBtn.addEventListener('click', () => {
                        Swal.fire({
                            title: '{{ __("site.Are you sure?") }}',
                            text: "{{ __("site.You won't be able to delete!") }}",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire(
                                    'Deleted!',
                                    '{{ __("site.Your Image has been deleted.") }}',
                                    'success'
                                )
                                files.splice(file, 1)
                                preview.remove();
                                getEditBrandImages()
                            }
                        });
                    });
                    preview.appendChild(deleteBtn);
                    const cropBtn = document.createElement('span');
                    cropBtn.setAttribute("data-toggle", "modal")
                    cropBtn.setAttribute("data-target", "#editBrandModal")
                    cropBtn.classList.add('crop-btn');
                    cropBtn.innerHTML = '<i style="font-size: 20px;" class="fas fa-crop"></i>';
                    cropBtn.addEventListener('click', () => {
                        setTimeout(() => {
                            launchEditBrandCropTool(img);
                        }, 500);
                    });
                    preview.appendChild(cropBtn);
                    previewEditBrandContainer.appendChild(preview);
                });
                reader.readAsDataURL(file);
            }else{
                Swal.fire({
                    icon: 'error',
                    title: '{{ __("site.Oops...") }}',
                    text: '{{ __("site.Sorry , You Should Upload Valid Image") }}',
                })
            }
        }

        getEditBrandImages()
    });
    function launchEditBrandCropTool(img) {
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
        const croppie = new Croppie(croppieEditBrandContainer, croppieOptions);
        croppie.bind({
            url: img.src,
            orientation: 1,
        });

        // Show the Croppie modal
        croppieEditBrandModal.style.display = 'block';

        // When the user clicks the "Cancel" button, hide the modal
        croppieEditBrandCancelBtn.addEventListener('click', () => {
            croppieEditBrandModal.style.display = 'none';
            $('#editBrandModal').modal('hide');
            croppie.destroy();
        });

        // When the user clicks the "Crop" button, get the cropped image and replace the original image in the preview
        croppieEditBrandSubmitBtn.addEventListener('click', () => {
            croppie.result('base64').then((croppedImg) => {
                img.src = croppedImg;
                croppieEditBrandModal.style.display = 'none';
                $('#editBrandModal').modal('hide');
                croppie.destroy();
                getEditBrandImages()
            });
        });
    }
    function getEditBrandImages() {
        setTimeout(() => {
            const container = document.querySelectorAll('.preview-edit-brand-container');
            let images = [];
            $("#cropped_edit_brand_images").empty();
            for (let i = 0; i < container[0].children.length; i++) {
                images.push(container[0].children[i].children[0].src)
                var newInput = $("<input>").attr("type", "hidden").attr("name", "cropImages[]").val(container[0].children[i].children[0].src);
                $("#cropped_edit_brand_images").append(newInput);
            }
            return images
        }, 300);
    }

</script>
