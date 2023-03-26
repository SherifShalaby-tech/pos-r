@extends('layouts.app')
@section('title', __('lang.raw_materials'))

@section('content')

    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>@lang('lang.add_new_production')</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic"><small>@lang('lang.required_fields_info')</small></p>
                            {!! Form::open(['url' =>action('ManufacturingController@store'), 'id' =>'product-edit-form', 'method'=>'POST', 'class' => '', 'enctype' => 'multipart/form-data']) !!}
                            <div class="row">
                                <div class="col-md-3">
                                    {!! Form::label('store_id', __('lang.store'), []) !!}
                                    <div class="input-group my-group">
                                        {!! Form::select('store_id', $stores, false,
                                            ['class' => 'select_store_id selectpicker form-control',
                                             'data-live-search' => 'true',
                                              'style' => 'width: 80%', 'id' => 'store_id']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('manufacturer_id', __('lang.manufacturers'), []) !!}
                                    <div class="input-group my-group">
                                        {!! Form::select('manufacturer_id', $manufacturers, false,
                                            ['class' => 'select_manufacturer_id selectpicker form-control',
                                             'data-live-search' => 'true',
                                              'style' => 'width: 80%', 'id' => 'manufacturer_id']) !!}

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    {!! Form::label('product_ids', __('lang.recipe'), []) !!}
                                    <div class="input-group my-group">
                                        <select required name="product_ids[]" id="product_ids" multiple
                                                class='select_product_ids selectpicker select2 form-control'
                                                data-live-search='true' style='width: 30%;'
                                                placeholder="{{__('lang.please_select')}}">
                                            @foreach($products as $item)
                                                @if($item->current_stock > 0)
                                                    <option stock="{{ $item->current_stock }}" name="{{$item->name}}"
                                                            id="product_{{$item->id}}" value="{{$item->id}}">
                                                        {{ $item->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-4 d-none">
                                    <div class="i-checks">
                                        <input id="price_based_on_raw_material" name="price_based_on_raw_material"
                                               type="checkbox"
                                               @if (!empty($recipe) && $recipe->price_based_on_raw_material == 1) checked
                                               @endif  value="1" class="form-control-custom">
                                        <label
                                            for="price_based_on_raw_material"><strong>@lang('lang.price_based_on_raw_material')</strong></label>
                                    </div>
                                </div>

                            </div>


                            <input type="hidden" name="active" value="1">
                            <div class="row">
                                <div class="col-md-4 mt-5">
                                    <div class="form-group">
                                        <input type="button" value="{{trans('lang.manufacturing')}}" id="submit-btn"
                                               class="btn btn-primary">
                                        <a href="{{ route("manufacturing-s.index") }}"
                                           class="btn btn-dark">{{trans('lang.back')}}</a>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}

                            @include('layouts.partials.translation_inputs', [
                              'attribute' => 'name',
                              'translations' => [],
                              'type' => 'manufacturings',
                          ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

{{--    <div class="modal" tabindex="-1" role="dialog">--}}
{{--        <div class="modal-dialog" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title">Modal title</h5>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <table id="product-modal">--}}
{{--                        <thead>--}}
{{--                        <th>name</th>--}}
{{--                        <th>stock</th>--}}
{{--                        <th>quentity</th>--}}
{{--                        <th>unit</th>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}

{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Add</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="modal fade" id="ProductsModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="product-modal" class="table table-striped table-bordered">
                        <thead>
                            <th>@lang('lang.name')</th>
                            <th>@lang('lang.stock')</th>
                            <th>@lang('lang.quantity')</th>
                            <th>@lang('lang.unit')</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="addQuantity" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        let data = [];
        let Quantities = [];
        $(document).ready(function () {
            calculate_price_base_on_raw_material();
            gert_unit_base_for_select_material_id();

            $("#submit-btn").on("click", function (e) {
                e.preventDefault();
                if ($("#product-edit-form").valid()) {
                    $.ajax({
                        type: "POST",
                        url: $("#product-edit-form").attr("action"),
                        data: {
                            "store_id" :$("#store_id").val(),
                            "manufacturer_id" :$("#manufacturer_id").val(),
                            "product_quentity" :Quantities,
                        },
                        success: function (response) {
                            if (response.success) {
                                swal("Success", response.msg, "success")
                            }
                            if (!response.success) {
                                swal("Error", response.msg, "error");
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

            $(document).on("change", "#product_ids", function (e) {

                if(data.length < $(this).val().length){
                    let product_current;
                    $(this).val().forEach(e=>{
                        if (data.filter(function(g) { return g.id == e; }).length == 0) {
                            product_current =e;
                        }
                    })
                    // select added new value
                    $("#product-modal tbody").empty()
                    $("#product-modal tbody").append(`
                <tr>
                        <td>
                            ${data.length == 0 ? $('#product_'+$(this).val()[0]).attr('name'): $('#product_'+product_current).attr('name')}
                        </td>
                        <td>
                              ${data.length == 0 ? $('#product_'+$(this).val()[0]).attr('stock'): $('#product_'+product_current).attr('stock')}
                        </td>
                        <td>
                            <input class="form-control" type="number" id="product_quantity">
                            <input type="hidden" id="product_stock" value=" ${data.length == 0 ? $('#product_'+$(this).val()[0]).attr('stock'): $('#product_'+product_current).attr('stock')}">
                            <input type="hidden" id="product_id" value=" ${data.length == 0 ? $('#product_'+$(this).val()[0]).val(): $('#product_'+product_current).val()}">
                        </td>
                        <td>
                            GM
                        </td>
                    </tr>
                `)
                    $("#ProductsModal").modal("show")
                }else{
                    // select  remove old  value

                    console.log("$(this).val()",$(this).val())
                    if($(this).val().length == 0){
                        Quantities =[];
                    }else{
                        Quantities.forEach(a=>{
                            if ($(this).val().filter(function(g) { return g == a.product_id; }).length == 0) {
                                const index = Quantities.indexOf(a);
                                if (index > -1) {
                                    Quantities.splice(index, 1);
                                }
                            }
                        })
                    }

                    console.log(Quantities)

                }

                data = [];
                product_ids = $(this).val();
                product_ids.forEach(e => {
                    data.push({
                        "id": e,
                        "name": $('#product_' + e).attr('name'),
                        "stock": $('#product_' + e).attr('stock')
                    })
                });

            });
            $(document).on("click", "#addQuantity", function (e) {
                let userQuantity= Number($("#product_quantity").val());
                let product_stock= Number($("#product_stock").val());
                let product_id= Number($("#product_id").val());
                if(userQuantity == null || userQuantity==''){
                    swal("Error", "Please Fill Quantity Input", "error");
                }else if(userQuantity > product_stock){
                    swal("Error", "Sorry Out Of Stock", "error");
                }else{
                    Quantities.push({
                        "product_id" :product_id,
                        "quantity" :userQuantity,
                    })
                    // console.log(Quantities)
                    swal("Success", 'Quantity Added Successfully', "success");
                    $("#ProductsModal").modal("hide")
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
            $(document).on("change", "#quantity_product", function () {
                var new_quantity_product = __read_number($(this));
                $("#consumption_table > tbody > tr").each(function () {
                    let raw_material_quantity = __read_number(
                        $(this).find(".raw_material_quantity")
                    );
                    let q_raw_material_price = parseFloat($(this).find(".raw_material_quantity").attr('amount_used_per_unit')).toFixed(3);
                    let new_raw_material_quantity = parseFloat((new_quantity_product * q_raw_material_price) / 100).toFixed(2);
                    __write_number($(this).find(".raw_material_quantity"), new_raw_material_quantity);

                    let raw_material_price = __read_number(
                        $(this).find(".raw_material_price")
                    );
                    let raw_material_total = raw_material_price * new_raw_material_quantity;

                    $(this)
                        .find(".cost_label")
                        .text(__currency_trans_from_en(raw_material_total, false));
                    $(this)
                        .find(".cost_input")
                        .val(__currency_trans_from_en(raw_material_total, false));
                });
                var purchase_price_per_unit = __read_number($('#purchase_price_per_unit'));
                var other_cost = __read_number($('#other_cost'));
                __write_number($("#purchase_price"), purchase_price_per_unit * new_quantity_product);
                __write_number($("#sell_price"), purchase_price_per_unit * new_quantity_product);


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
                    data: {row_id: row_id},
                    success: function (result) {
                        $("#consumption_table > tbody").prepend(result);
                        $(".selectpicker").selectpicker("refresh");
                        $(".raw_material_unit_id").selectpicker("refresh");
                        calculate_price_base_on_raw_material();

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
            return new Blob([ab], {type: "image/jpeg"});
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
                    $(this)
                        .find(".cost_input")
                        .val(__currency_trans_from_en(raw_material_total, false));
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
                url: "/product/get-raw-material-details/" + raw_material_id + '?type=units',
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
        function get_unit(units, row_id) {
            $v = document.getElementById('select_unit_id_' + row_id).value;

            $.each(units, function (key, value) {
                if ($v == key) {
                    $('#number_vs_base_unit_' + row_id).val(value);
                    if (value == 1) {
                        $('#number_vs_base_unit_' + row_id).attr("disabled", true);
                    } else {
                        $('#number_vs_base_unit_' + row_id).attr("disabled", false);
                    }

                    // console.log(value);
                }
            });
        }
    </script>

@endsection
