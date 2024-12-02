@extends('layouts.app')
@section('title', __('lang.raw_materials'))

@section('content')
<section class="forms py-2">
    <div class="container-fluid px-2">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>

                    <h4>@lang('lang.add_new_recipe')</h4>
                </x-page-title>


                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <p class="italic mb-0 @if (app()->isLocale('ar')) text-right @else text-left @endif">
                            <small>@lang('lang.required_fields_info')</small>
                        </p>
                    </div>
                </div>

                {!! Form::open(['url' => action('RecipeController@store'), 'id' => 'product-form', 'method'
                =>
                'POST', 'class' => '', 'enctype' => 'multipart/form-data']) !!}


                @include('recipe.partial.create_form')


                <input type="hidden" name="active" value="1">
                <input type="hidden" name="is_used" value="0">

                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="form-group mx-1">
                                <input type="button" value="{{trans('lang.submit')}}" id="submit-btn"
                                    class="btn btn-primary">
                            </div>
                            @can('raw_material_module.production.create_and_edit')

                            <div class="form-group  mx-1">
                                <input type="button" value="{{trans('lang.use now')}}" id="submit-btn-use"
                                    class="btn btn-outline-warning">
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>


                {!! Form::close() !!}

            </div>
        </div>
    </div>
</section>

@endsection

@section('javascript')
<script>
    $(document).ready(function () {
            $(document).on("click", '#submit-btn-add-product', function(e) {
                e.preventDefault();
                var sku = $('#sku').val();
                if ($("#product-form-quick-add").valid()) {
                    tinyMCE.triggerSave();
                    $.ajax({
                        type: "POST",
                        url: $("form#product-form-quick-add").attr("action"),
                        data: $("#product-form-quick-add").serialize(),
                        success: function(response) {
                            if (response.success) {
                                swal("Success", response.msg, "success");;
                                $("#search_product").val(sku);
                                $('input#search_product').autocomplete("search");
                                $('.view_modal').modal('hide');
                            }
                        },
                        error: function(response) {
                            if (!response.success) {
                                swal("Error", response.msg, "error");
                            }
                        },
                    });
                }
            });
            $("#submit-btn").on("click", function (e) {
                e.preventDefault();
                document.getElementById("loader").style.display = "block";
                document.getElementById("content").style.display = "none";
                $.ajax({
                            type: "POST",
                            url: $("form#product-form").attr("action"),
                            data: $("#product-form").serialize(),
                            success: function (response) {
                                // myFunction();
                                showPage()
                                if (response.success) {
                                    swal("Success", response.msg, "success");
                                    $("#name").val("").change();
                                    $(".translations").val("").change();
                                } else {
                                    console.log( response.msg);
                                    swal("Error", response.msg, "error");
                                }
                            },
                            error: function (response) {
                                // myFunction();
                                showPage()
                                if (!response.success) {
                                    console.log( response.msg);
                                    swal("Error", response.msg, "error");
                                }
                            },
                        });
            });
            $("#submit-btn-use").on("click", function (e) {
                e.preventDefault();
                document.getElementById("loader").style.display = "block";
                document.getElementById("content").style.display = "none";
                $.ajax({
                    type: "POST",
                    url: $("form#product-form").attr("action"),
                    data: $("#product-form").serialize(),
                    success: function (response) {
                        // myFunction();
                        showPage()
                        if (response.success) {
                            swal("Success", response.msg, "success");
                            window.location.replace('/recipe_uesd/send/'+response.recipe_id);

                        } else {
                            console.log( response.msg);
                            swal("Error", response.msg, "error");
                        }
                    },
                    error: function (response) {
                        // myFunction();
showPage()
                        if (!response.success) {
                            console.log( response.msg);
                            swal("Error", response.msg, "error");
                        }
                    },
                });
            });

            $(document).on("change", "#purchase_price", function () {
                $(".default_purchase_price").val($(this).val());
            });
            $(document).on("change", "select.select_material_id", function () {
                let raw_material_id = $(this).val();

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
                console.log('dfeed');
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