$(document).on("click", "#add_dining_room_btn", function () {
    var form = $("#dining_room_form");
    var data = form.serialize();
    $.ajax({
        url: "/dining-room",
        type: "POST",
        data: data,
        success: function (result) {
            if (result.success === true) {
                toastr.success(result.msg);
                $(".view_modal").modal("hide");
                get_dining_content();
            } else {
                toastr.error(result.msg);
            }
        },
    });
});

$(document).on("change", "#dining_room_name", function () {
    let name = $(this).val();

    $.ajax({
        method: "GET",
        url: "/dining-room/check-dining-room-name",
        data: { name },
        success: function (result) {
            if (result.success == false) {
                toastr.error(result.msg);
            }
        },
    });
});

function get_dining_content(dining_table_id = null) {
    // $('.tables').load(document.URL +  ' .tables');
    if (dining_table_id == null) {
        dining_table_id = $("#dining_table_id").val();
        
    }
    table_no = $("#table_no").val();
    room_no = $("#room_no").val();
    $.ajax({
        method: "GET",
        url: "/dining-room/get-dining-room-content",
        data: {
            dining_table_id: dining_table_id,
            table_no:table_no,
            room_no:room_no
        },
        success: function (result) {
            $("#dining_content").empty().append(result);
            var storedTableArray = sessionStorage.getItem("notificationContents");
            var storedTableArray = JSON.parse(storedTableArray);
            console.log(storedTableArray);
            if (!$.isEmptyObject(storedTableArray)){
                for (i = 0; i < storedTableArray.length; i++) {
                    $('.table'+storedTableArray[i].table_no).text(storedTableArray[i].table_count);
                    $('.table'+storedTableArray[i].table_no).show();
                    $('.table'+storedTableArray[i].table_no).removeClass('hide');
                }
            }
            var storedRoomArray = sessionStorage.getItem("notificationRoomContents");
            var storedRoomArray = JSON.parse(storedRoomArray);
            console.log(storedRoomArray);
            if (!$.isEmptyObject(storedRoomArray)){
                for (i = 0; i < storedRoomArray.length; i++) {
                    $('.room-badge'+storedRoomArray[i].room_no).text(storedRoomArray[i].room_count);
                    $('.room-badge'+storedRoomArray[i].room_no).show();
                    $('.room-badge'+storedRoomArray[i].room_no).removeClass('hide');
                }
            }
        },
    });
}
$(document).on("click", ".table-link", function (e) {
    e.preventDefault();
    var table_id=$(this).data('table_no');
    var room_id=$(this).data('room');
    var table_count=0;
    var storedTableArray = sessionStorage.getItem("notificationContents");
    var storedTableArray = JSON.parse(storedTableArray);
    if (!$.isEmptyObject(storedTableArray)){
        var data = $.grep(storedTableArray, function(e){ 
            table_count=e.table_count;
            return e.table_no != table_id; 
        });
        console.log(data)
        sessionStorage.setItem("notificationContents", (JSON.stringify(data)));
    }

    //
    var storedRoomArray = sessionStorage.getItem("notificationRoomContents");
    var storedRoomArray = JSON.parse(storedRoomArray);
    var deleteRoomId=false;
    if (!$.isEmptyObject(storedRoomArray)){
        storedRoomArray.forEach((element, index) => {
            if(element.room_no === room_id) {
                if(element.room_count>1){
                    element.room_count =element.room_count-table_count;
                }else{
                    deleteRoomId=true;
                }
              
                return;
            }
        });
        if(deleteRoomId){
            var storedRoomArray = $.grep(storedRoomArray, function(e){ 
                return e.room_no != room_id; 
            });
            console.log(storedRoomArray)
        }
        console.log(storedRoomArray)
        sessionStorage.setItem("notificationRoomContents", (JSON.stringify(storedRoomArray)));
    }
    get_dining_content();
    Object.assign(document.createElement("a"), {
        target: "_blank",
        href: "/pos/"+$(this).data('transaction_id')+"/edit"
        }).click();
});
$(document).on("click", "#add_dining_table_btn", function () {
    var form = $("#dining_table_form");
    var data = form.serialize();
    $.ajax({
        url: "/dining-table",
        type: "POST",
        data: data,
        success: function (result) {
            if (result.success === true) {
                toastr.success(result.msg);
                $(".view_modal").modal("hide");
                get_dining_content(result.dining_table_id);
            } else {
                toastr.error(result.msg);
            }
        },
    });
});

$(document).on("change", "#dining_table_name", function () {
    let name = $(this).val();

    $.ajax({
        method: "GET",
        url: "/dining-table/check-dining-table-name",
        data: { name },
        success: function (result) {
            if (result.success == false) {
                toastr.error(result.msg);
            }
        },
    });
});

$(document).on("click", ".table_action", function () {
    let table_id = $(this).data("table_id");
    $("#dining_table_id").val(table_id);
    $.ajax({
        method: "GET",
        url: "/dining-table/get-dining-table-action/" + table_id,
        data: {},
        success: function (result) {
            $("#dining_table_action_modal").empty().append(result);
            // let enable_the_table_reservation = $('#enable_the_table_reservation').val();
            // if(enable_the_table_reservation == '1'){
                // $("#dining_table_action_modal").modal("show");
            // }else{
                // $('.tables_status').append(3333);
                $('#table_action_btn').click();
            // }
        },
    });
});

$(document).on("click", ".table_action_reserve", function () {
    let table_id = $(this).data("table_id");
    $("#dining_table_id").val(table_id);
    $.ajax({
        method: "GET",
        url: "/dining-table/get-dining-table-action/" + table_id,
        data: {},
        success: function (result) {
            $("#dining_table_action_modal").empty().append(result);
            // let enable_the_table_reservation = $('#enable_the_table_reservation').val();
            // if(enable_the_table_reservation == '1'){
                $("#dining_table_action_modal").modal("show");
            // }else{
                // $('.tables_status').append(3333);
                // $('#table_reserve_btn').click();
            // }
        },
    });
});
$(document).on("click", ".table_cancel_reserve_btn", function () {
    let table_id = $(this).data('table_id');
    $.ajax({
        method: "post",
        url: "/dining-table/update-dining-table-data/" + table_id,
        data: {
            status: "cancel_reservation",
        },
        success: function (result) {
            if (result.success == "1") {
                swal("Success", result.msg, "success");
                get_dining_content();
            }
        },
    });
});
$(document).on("click", ".table_edit_reserve_btn", function () {
    let table_id = $(this).data('table_id');
    let reserve_id = $(this).data('reserve_id');
    $("#dining_table_id").val(table_id);
    $.ajax({
        method: "GET",
        url: "/dining-table/get-dining-table-action/" + table_id,
        data:{type:'edit_reserve',reservation_id:reserve_id},
        success: function (result) {
            $("#dining_table_action_modal").empty().append(result);
            $("#dining_table_action_modal").modal("show");
            $("#table_edit_btn").removeClass("hide");
            $("#table_reserve_btn").addClass("hide");
        },
    });
});
$(document).on("click", "#table_edit_btn", function () {
let table_id = $(this).data('table_id');
let reserve_id = $(this).data('reserve_id');
if (
    !$("#table_customer_name").val() ||
    !$("#table_customer_mobile_number").val() ||
    !$("#table_date_and_time").val()
) {
    toastr.error("Please,Fill all fields.");
    return false;
}
else{
    var complete='';
    $.ajax({
        method: "get",
        url: "/dining-table/check_time_rserve_availability/"+ table_id,
        data: {
            date_and_time:$("#table_date_and_time").val(),
            old_value:true,
            reservation_id:reserve_id
        },
        dataType: "json",
        success: function (result) {
            if(result.msg=="ok"){
                console.log(result.msg)
                // toastr.error(result.msg);
                complete=true;
                if(complete){
                    $.ajax({
                        method: "post",
                        url: "/dining-table/update-dining-table-data/" + table_id,
                        data: {
                            customer_name: $("#table_customer_name").val(),
                            customer_mobile_number: $(
                                "#table_customer_mobile_number"
                            ).val(),
                            date_and_time: $("#table_date_and_time").val(),
                            status: 'edit-reserve',
                            reservation_id:reserve_id
                        },
                        success: function (result) {
                            if (result.success == "1") {
                                swal("Success", result.msg, "success");
                                $("#dining_table_action_modal").modal("hide");
                                get_dining_content();
                                // location.reload(true);
                            }
                        },
                    });
                }
                console.log(complete)
            }else{
                toastr.error(result.msg);
                complete=false;
                console.log("a",result)
                return false;
            }
            // get_dining_content();
            $("#table_edit_btn").addClass("hide");
            $("#table_reserve_btn").removeClass("hide");
        }

    });
// $.ajax({
//     method: "get",
//     url: "/dining-table/edit-reservation-table-data/" + table_id,
//     success: function (result) {
//         if(result){
//             $("#dining_table_action_modal").modal("show");
//             $("#table_edit_btn").addClass("hide");
//             $("#table_reserve_btn").removeClass("hide");
//         }        
//     },
// });
}
});
// $(document).on("click", ".remove-table", function () {
//     let table_id = $(this).data("table_id");
//     swal({
//         title: 'Are you sure?',
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Yes, delete it!'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             swal(
//                 'Deleted!',
//                 'Your table has been deleted.',
//                 'success'
//             )
//             $.ajax({
//                 type: "delete",
//                 url: "/dining-table/"+table_id,
//                 success: function (response) {
//                     get_dining_content();
//                 }
//             });
//         }
//     });
// });
$(document).on("click", "#table_reserve_btn", function () {
    let table_id = $("#dining_table_id").val();
        if (
            !$("#table_customer_name").val() ||
            !$("#table_customer_mobile_number").val() ||
            !$("#table_date_and_time").val()
        ) {
            toastr.error("Please,Fill all fields.");
            return false;
        }
        else{
            var complete='';
                $.ajax({
                    method: "get",
                    url: "/dining-table/check_time_rserve_availability/"+ table_id,
                    data: {
                        date_and_time:$("#table_date_and_time").val()
                    },
                    dataType: "json",
                    success: function (result) {
                        if(result.msg=="ok"){
                            // toastr.error(result.msg);
                            complete=true;
                            if(complete){
                                $.ajax({
                                    method: "post",
                                    url: "/dining-table/update-dining-table-data/" + table_id,
                                    data: {
                                        customer_name: $("#table_customer_name").val(),
                                        customer_mobile_number: $(
                                            "#table_customer_mobile_number"
                                        ).val(),
                                        date_and_time: $("#table_date_and_time").val(),
                                        status: 'reserve',
                                    },
                                    success: function (result) {
                                        if (result.success == "1") {
                                            get_dining_content();
                                            swal("Success", result.msg, "success");
                                            $("#dining_table_action_modal").modal("hide");
                                            reset_pos_form();
                                        }
                                    }, error: function (response) {
                                        swal("Error", response, "error");
                                
                                },
                                });
                            }
                            console.log(complete)
                        }else{
                            toastr.error(result.msg);
                            complete=false;
                            console.log("a",result)
                            return false;
                        }
                    }
                });
    }
});
// $(document).on("change", "#table_status", function () {
//     let table_status = $(this).val();
//     if (table_status == "reserve") {
//         $(".reserve_div").removeClass("hide");
//     } else {
//         $(".reserve_div").addClass("hide");
//     }
// });
$(document).on("click", "#table_action_btn", function () {
    let table_status = $("input[name='table_status']:checked").val();
    
    let table_id = $("#dining_table_id").val();
    if (table_status == "reserve" || table_status =="another_reservation") {
        // if (table_status == "reserve" || table_status =="another_reservation") {
            if (
                !$("#table_customer_name").val() ||
                !$("#table_customer_mobile_number").val() ||
                !$("#table_date_and_time").val()
            ) {
                toastr.error("Please,Fill all fields.");
                return false;
            }
            else{
                var complete='';
                    $.ajax({
                        method: "get",
                        url: "/dining-table/check_time_rserve_availability/"+ table_id,
                        data: {
                            date_and_time:$("#table_date_and_time").val()
                        },
                        dataType: "json",
                        success: function (result) {
                            if(result.msg=="ok"){
                                console.log(result.msg)
                                // toastr.error(result.msg);
                                complete=true;
                                if(complete){
                                    $.ajax({
                                        method: "post",
                                        url: "/dining-table/update-dining-table-data/" + table_id,
                                        data: {
                                            customer_name: $("#table_customer_name").val(),
                                            customer_mobile_number: $(
                                                "#table_customer_mobile_number"
                                            ).val(),
                                            date_and_time: $("#table_date_and_time").val(),
                                            status: table_status,
                                        },
                                        success: function (result) {
                                            if (result.success == "1") {
                                                swal("Success", result.msg, "success");
                                                $("#dining_table_action_modal").modal("hide");
                                                // get_dining_content();
                                                location.reload(true);
                                            }
                                        },
                                    });
                                }
                                console.log(complete)
                            }else{
                                toastr.error(result.msg);
                                complete=false;
                                console.log("a",result)
                                return false;
                            }
                        }
                    });
                
            // }
        }
    } 
        $("#dining_table_id").val(table_id);
        $(".reserve_div").addClass("hide");
        $(".table_room_hide").addClass("hide");
        $(".table_room_show").removeClass("hide");
        $(".transaction-list").css("height", "55vh");
        $.ajax({
            method: "get",
            url: "/dining-table/get-table-details/" + table_id,
            data: {status:table_status},
            success: function (result) {
                console.log(result.status_array)
                $("span.room_name").text(result.dining_room.name);
                $("#room_id").val(result.dining_room.id);
                $("span.table_name").text(result.dining_table.name);
                // $("#dining_table_action_modal").modal("hide");
                $("#dining_model").modal("hide");
                var statuscontent='';
                var status_array=result.status_array;
                var checked='';
             if(result.status_array){
                    for(var status in status_array){
                    checked=status=='order'?'checked':'';
                    statuscontent+="<div class='form-check form-check-inline "+status+"'><input class='form-check-input' type='radio' name='table_status' id='"+status_array[status]+"' "+checked+" value='"+status+"'><label class='form-check-label' for='"+status_array[status]+"'>"+status_array[status]+"</label></div>";
                    }
                    $('.tables_status').html(statuscontent);
             }
             $.ajax({
                method: 'get',
                url: '/dining-table/get-tables-for-merge/' + $('#room_id').val(),
                dataType: 'html',
                success: function(result) {
                    console.log(result);
                    $("#table_merge_id").empty().append(result);
                    $("#table_merge_id").selectpicker("refresh");
                },
            });
            }
        });
        
    // }
    // } else {
    //     $(".reserve_div").addClass("hide");
    //     $(".table_room_show").addClass("hide");
    //     $(".table_room_hide").removeClass("hide");
    //     $(".transaction-list").css("height", "45vh");
    // }
});
$(document).on("click",".dining-btn",function(){
    get_dining_content();
});
$(document).on("click",'.reserve input[name="table_status"]',function() {
    if($(this).is(':checked')) {
        $(".reserve_div").removeClass("hide");
        $('.cancel_div').addClass("hide");
        $("#dining_table_action_modal").modal("show"); 
    }
 });
 $(document).on("click",'.cancel_reservation input[name="table_status"]',function() {
    if($(this).is(':checked')) {
        $(".reserve_div").addClass("hide");
        $('.cancel_div').removeClass("hide");
        $("#dining_table_action_modal").modal("show"); 
    }
 });
 $(document).on("click",'.another_reservation input[name="table_status"]',function() {
    if($(this).is(':checked')) {
        $(".reserve_div").removeClass("hide");
        $('.cancel_div').addClass("hide");
        $("#dining_table_action_modal").modal("show"); 
    }
 });
$(document).on("click",'.cancel_reserve',function() {
    $id=$(this).data('index');
    $.ajax({
        method: "post",
        url: "/dining-table/update-dining-table-data/" + $id,
        data: {
            status:'cancel_reservation',
        },
        success: function (result) {
            if (result.success == "1") {
                swal("Success", result.msg, "success");
                get_dining_content();
            }
        },
    });
});
$(document).on("click", ".order_table", function () {
    $("#dining_model").modal("hide");
});
function reset_dinging_table_action_modal() {
    $("#table_customer_name").val("");
    $("#table_customer_mobile_number").val("");
    $("#table_date_and_time").val("");
    $("#table_status").val("");
    $("#table_status").selectpicker("refresh");
}
