@extends('layouts.app')
@section('title', __('lang.raw_materials'))

@section('content')
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>@lang('lang.edit_recipe')</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>@lang('lang.required_fields_info')</small></p>
                        {!! Form::open(['url' =>route('recipe.update', $recipe->id), 'id' =>
                        'product-edit-form', 'method'
                        =>
                        'PUT', 'class' => '', 'enctype' => 'multipart/form-data']) !!}
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('material_id', __('lang.raw_material'), []) !!}
                                <div class="input-group my-group">
                                    {!! Form::select('material_id', $raw_materials,  !empty($recipe) ? $recipe->material_id: false, ['class' => 'select_material_id selectpicker form-control', 'data-live-search' => 'true', 'style' => 'width: 80%', 'placeholder' => __('lang.please_select'), 'id' => 'material_id']) !!}
                                    <span class="input-group-btn">
                                        @can('raw_material_module.raw_material.create_and_edit')
                                            <button class="btn-modal btn btn-default bg-white btn-flat"
                                                    data-href="{{ action('RawMaterialController@create') }}?quick_add=1" data-container=".view_modal"><i
                                                    class="fa fa-plus-circle text-primary fa-lg"></i></button>
                                        @endcan
                                    </span>
                                </div>
                            </div>



                            <div class="col-md-4 row">
                                <div class="col-7">
                                    <div class="form-group">
                                        {!! Form::label('quantity_product', __('lang.quantity'), []) !!}
                                        {!! Form::number('quantity_product',!empty($recipe) ?
                                    number_format($recipe->quantity_product,5,'.','') :
                                    null,
                                        ['class' => 'form-control', 'placeholder' =>
                                        __('lang.quantity_product')]) !!}
                                    </div>
                                </div>
                                <div class="col-5">
                                    <label for="" class="unit_label" id="label_unit_id_material" style="text-align: center; margin-top: 40%;"> </label>
                                    <input type="text" class="hide" id="unit_id_material" value="" name="unit_id_material" >
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="i-checks">
                                    <input id="automatic_consumption" name="automatic_consumption" type="checkbox" value="1"
                                           @if (!empty($recipe) && $recipe->automatic_consumption == 1) checked @endif     class="form-control-custom">
                                    <label for="automatic_consumption"><strong>@lang('lang.automatic_consumption')</strong></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="i-checks">
                                    <input id="price_based_on_raw_material" name="price_based_on_raw_material" type="checkbox"
                                           @if (!empty($recipe) && $recipe->price_based_on_raw_material == 1) checked @endif  value="1" class="form-control-custom">
                                    <label for="price_based_on_raw_material"><strong>@lang('lang.price_based_on_raw_material')</strong></label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered" id="consumption_table">
                                    <thead>
                                    <tr>
                                        <th style="width: 30%;">@lang('lang.raw_materials')</th>
                                        <th style="width: 30%;">@lang('lang.used_amount')</th>
                                        <th style="width: 30%;">@lang('lang.unit')</th>
                                        <th style="width: 30%;">@lang('lang.cost')</th>
                                        <th style="width: 10%;"><button class="btn btn-xs btn-success add_raw_material_row"
                                                                        type="button"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($recipe->consumption_products as $consumption_product)
                                        @include('product.partial.raw_material_row', ['row_id' => $loop->index,
                                        'consumption_product' => $consumption_product])
                                    @endforeach

                                    </tbody>
                                </table>
                                <input type="hidden" name="raw_material_row_index" id="raw_material_row_index" value="{{$recipe->consumption_products->count()}}">
                            </div>
                            @can('product_module.purchase_price.create_and_edit')
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('other_cost', __('lang.other_cost'), []) !!}
                                        {!! Form::text('other_cost', !empty($recipe) ? @num_format($recipe->other_cost) : null, ['class' => 'form-control', 'placeholder' => __('lang.other_cost')]) !!}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('purchase_price', __('lang.cost') . ' *', []) !!}
                                        {!! Form::text('purchase_price',  !empty($recipe) ?  @num_format($recipe->$recipe) : null, ['class' => 'form-control', 'placeholder' => session('system_mode') == 'pos' || session('system_mode') == 'garments' || session('system_mode') == 'supermarket' ? __('lang.purchase_price') : __('lang.cost'), 'required']) !!}
                                    </div>
                                </div>
                            @endcan
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('name', __('lang.name') . ' * (max 25 characters)', []) !!}
                                    <div class="input-group my-group">
                                        {!! Form::text('name', !empty($recipe) ? $recipe->name : null, ['class' => 'form-control', 'required', 'placeholder' => __('lang.name')]) !!}
                                        <span class="input-group-btn">
                                            <button class="btn btn-default bg-white btn-flat translation_btn" type="button"
                                                    data-type="product"><i class="dripicons-web text-primary fa-lg"></i></button>
                                        </span>
                                    </div>
                                </div>
                                @include('layouts.partials.translation_inputs', [
                                    'attribute' => 'name',
                                    'translations' => [],
                                    'type' => 'product',
                                ])
                            </div>
                            <input type="hidden" name="is_raw_material" id="is_raw_material" value="1">
                            <input type="hidden" name="row_id" id="row_id"
                                value="{{$recipe->consumption_products->count()}}">
                        </div>


                        <input type="hidden" name="active" value="1">
                        <div class="row">
                            <div class="col-md-4 mt-5">
                                <div class="form-group">
                                    <input type="button" value="{{trans('lang.submit')}}" id="submit-btn"
                                        class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')


    <script>

        $(document).ready(function () {
            calculate_price_base_on_raw_material();
            gert_unit_base_for_select_material_id();
            $("#submit-btn").on("click", function (e) {
                e.preventDefault();
                if ($("#product-edit-form").valid()) {

                        $.ajax({
                            type: "POST",
                            url: $("#product-edit-form").attr("action"),
                            data: $("#product-edit-form").serialize(),
                            success: function (response) {
                                if (response.success) {
                                    swal("Success", response.msg, "success");
                                    setTimeout(() => {
                                        window.close();
                                    }, 1000);
                                }
                            },
                            error: function (response) {
                                if (!response.success) {
                                    swal("Error", response.msg, "error");
                                }
                            },
                        });

                }
            });
            /*$("#submit-btn").on("click", function (e) {
                e.preventDefault();
                document.getElementById("loader").style.display = "block";
                document.getElementById("content").style.display = "none";
                $.ajax({
                    type: "get",
                    url: $("form#product-form").attr("action"),
                    data: $("#product-form").serialize(),
                    success: function (response) {
                        //myFunction();
                        if (response.success) {
                            swal("Success", response.msg, "success");

                        } else {
                            console.log( response.msg);
                            swal("Error", response.msg, "error");
                        }
                    },
                    error: function (response) {
                        myFunction();
                        if (!response.success) {
                            console.log( response.msg);
                            swal("Error", response.msg, "error");
                        }
                    },
                });
            });*/

            $(document).on("change", "#purchase_price", function () {
                $(".default_purchase_price").val($(this).val());
            });
            $(document).on("change", "select.select_material_id", function () {
                gert_unit_base_for_select_material_id();
            });
            $(document).on("change", "select.raw_material_id", function () {
                let tr = $(this).closest("tr");
                let raw_material_id = $(this).val();

                $.ajax({
                    method: "get",
                    url: "/product/get-raw-material-details/" + raw_material_id,
                    data: {},
                    success: function (result) {
                        tr.find(".raw_material_price").val(
                            result.raw_material.purchase_price
                        );
                        tr.find(".raw_material_unit_id").val(
                            result.raw_material.multiple_units[0]
                        );
                        tr.find(".raw_material_unit_id").selectpicker("refresh");
                        tr.find(".unit_label").text(
                            tr.find("select.raw_material_unit_id option:selected").text()
                        );
                    },
                });
            });
            $(document).on("click", ".add_raw_material_row", function () {
                let row_id = parseInt($("#raw_material_row_index").val());
                $("#raw_material_row_index").val(row_id + 1);

                $.ajax({
                    method: "get",
                    url: "/product/get-raw-material-row",
                    data: { row_id: row_id },
                    success: function (result) {
                        $("#consumption_table > tbody").prepend(result);
                        $(".selectpicker").selectpicker("refresh");
                        $(".raw_material_unit_id").selectpicker("refresh");
                    },
                });
            });
            $(document).on("change", ".raw_material_quantity, .raw_material_id, .raw_material_unit_id, #price_based_on_raw_material, #other_cost ", function () {
                    calculate_price_base_on_raw_material();
                }
            );
            //Prevent enter key function except texarea
            $("form").on("keyup keypress", function (e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13 && e.target.tagName != "TEXTAREA") {
                    e.preventDefault();
                    return false;
                }
            });

            tinymce.init({
                selector: "#product_details",
                height: 130,
                plugins: [
                    "advlist autolink lists link charmap print preview anchor textcolor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime table contextmenu paste code wordcount",
                ],
                toolbar:
                    "insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat",
                branding: false,
            });
        });

        $(document).on("click", ".remove_row", function () {
            row_id = $(this).closest("tr").data("row_id");
            $(this).closest("tr").remove();
            $(".variant_store_checkbox_" + row_id).remove();
            $(".variant_store_prices_" + row_id).remove();
        });

        $(document).on("click", ".add_row", function () {
            var row_id = parseInt($("#row_id").val());

            $.ajax({
                method: "get",
                url: "/product/get-variation-row?row_id=" + row_id,
                data: {
                    name: $("#name").val(),
                    purchase_price: $("#purchase_price").val(),
                    sell_price: $("#sell_price").val(),
                },
                contentType: "html",
                success: function (result) {
                    $("#variation_table tbody").prepend(result);
                    $(".row_" + row_id)
                        .find(".selectpicker")
                        .selectpicker("refresh");
                    $(".variant_store_prices_" + row_id).slideUp();

                    $("#row_id").val(row_id + 1);
                },
            });
        });



        // transform cropper dataURI output to a Blob which Dropzone accepts
        function dataURItoBlob(dataURI) {
            var byteString = atob(dataURI.split(",")[1]);
            var ab = new ArrayBuffer(byteString.length);
            var ia = new Uint8Array(ab);
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            return new Blob([ab], { type: "image/jpeg" });
        }


        var multiple_units_array = [];
        $("#multiple_units").change(function () {
            multiple_units_array.push($(this).val());
        });
        $(document).on("submit", "form#quick_add_unit_form", function (e) {
            $("form#quick_add_unit_form").validate();
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                method: "post",
                url: $(this).attr("action"),
                dataType: "json",
                data: data,
                processData: false,
                contentType: false,
                success: function (result) {
                    if (result.success) {
                        swal("Success", result.msg, "success");
                        $(".view_modal").modal("hide");
                        var unit_id = result.unit_id;
                        multiple_units_array.push(unit_id);
                        $.ajax({
                            method: "get",
                            url: "/unit/get-dropdown",
                            data: {},
                            contactType: "html",
                            success: function (data_html) {
                                $("#multiple_units").empty().append(data_html);
                                $("#multiple_units").selectpicker("refresh");
                                $("#multiple_units").selectpicker(
                                    "val",
                                    multiple_units_array
                                );
                                $("select.unit_id").empty().append(data_html);
                                $("select.unit_id").selectpicker("refresh");
                                $("select#multiple_units").change();
                            },
                        });
                    } else {
                        swal("Error", result.msg, "error");
                    }
                },
            });
        });

        $(document).on("submit", "form#quick_add_size_form", function (e) {
            $("form#quick_add_size_form").validate();
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                method: "post",
                url: $(this).attr("action"),
                dataType: "json",
                data: data,
                processData: false,
                contentType: false,
                success: function (result) {
                    if (result.success) {
                        swal("Success", result.msg, "success");
                        $(".view_modal").modal("hide");
                        var size_id = result.size_id;
                        multiple_sizes_array.push(size_id);
                        $.ajax({
                            method: "get",
                            url: "/size/get-dropdown",
                            data: {},
                            contactType: "html",
                            success: function (data_html) {
                                $("#multiple_sizes").empty().append(data_html);
                                $("#multiple_sizes").selectpicker("refresh");
                                $("#multiple_sizes").selectpicker(
                                    "val",
                                    multiple_sizes_array
                                );
                            },
                        });
                    } else {
                        swal("Error", result.msg, "error");
                    }
                },
            });
        });

        $(document).on("change", "#sell_price", function () {
            let sell_price = __read_number($("#sell_price"));
            let default_purchase_price_percentage = __read_number(
                $("#default_purchase_price_percentage")
            );
            if (default_purchase_price_percentage > 0) {
                let purchase_price_percentage =
                    (sell_price * default_purchase_price_percentage) / 100;
                __write_number($("#purchase_price"), purchase_price_percentage);
            }
            $(".store_prices").val($(this).val());
            $(".default_sell_price").val($(this).val());
        });
        $(document).on("change", "#purchase_price", function () {
            let purchase_price = __read_number($("#purchase_price"));
            let default_profit_percentage = __read_number(
                $("#default_profit_percentage")
            );
            if (default_profit_percentage > 0) {
                let sell_price_percentage =
                    (purchase_price * default_profit_percentage) / 100;
                let sell_price = purchase_price + sell_price_percentage;
                __write_number($("#sell_price"), sell_price);
                $(".store_prices").val(sell_price);
            }
        });

        function calculate_price_base_on_raw_material() {
            if ($("#price_based_on_raw_material").prop("checked")) {
                $("#automatic_consumption").prop("checked", true);
                let total_raw_material_price = 0;
                $("#consumption_table > tbody > tr").each(function () {
                    let raw_material_price = __read_number(
                        $(this).find(".raw_material_price")
                    );
                    let raw_material_quantity = __read_number(
                        $(this).find(".raw_material_quantity")
                    );
                    let raw_material_total = raw_material_price * raw_material_quantity;
                    total_raw_material_price += raw_material_total;

                    $(this)
                        .find(".cost_label")
                        .text(__currency_trans_from_en(raw_material_total, false));
                });
                let other_cost = __read_number($("#other_cost"));
                total_raw_material_price += other_cost;
                __write_number($("#purchase_price"), total_raw_material_price);
            } else {
                __write_number($("#purchase_price"), 0);
            }
            $("#purchase_price").change();
        }

        function gert_unit_base_for_select_material_id() {
            let raw_material_id = $('select.select_material_id').val();

            $.ajax({
                method: "get",
                url: "/product/get-raw-material-details/" + raw_material_id+'?type=units',
                data: {},
                success: function (result) {
                    console.log(result.raw_material);
                    $("#unit_id_material").val(result.raw_material.id);
                    $("#label_unit_id_material").text(result.raw_material.name);
                },
            });
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

@endsection
