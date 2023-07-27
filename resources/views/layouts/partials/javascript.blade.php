@php
$moment_time_format = App\Models\System::getProperty('time_format') == '12' ? 'hh:mm A' : 'HH:mm';
@endphp
<script>
    var moment_time_format = "{{$moment_time_format}}";
</script>
<script type="text/javascript" src="{{asset('js/lang/'.session('language').'.js') }}"></script>
{{-- <script type="text/javascript" src="{{asset('vendor/jquery/jquery.min.js') }}"></script> --}}
<script
  src="https://code.jquery.com/jquery-3.7.0.min.js"
  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
  crossorigin="anonymous"></script>
  
<script type="text/javascript" src="{{asset('vendor/jquery/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/jquery/jquery.timepicker.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/popper.js/umd/popper.min.js') }}">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script type="text/javascript" src="{{asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/daterange/js/moment.min.js') }}"></script>

<script type="text/javascript" src="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/bootstrap-datepicker/locales/bootstrap-datepicker.'.session('language').'.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>

<script type="text/javascript" src="{{asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/bootstrap/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/keyboard/js/jquery.keyboard.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/keyboard/js/jquery.keyboard.extension-autocomplete.js') }}">
</script>
<script type="text/javascript" src="{{asset('js/grasp_mobile_progress_circle-1.0.0.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/jquery.cookie/jquery.cookie.js') }}">
</script>
<script type="text/javascript" src="{{asset('vendor/chart.js/Chart.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript"
    src="{{asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script type="text/javascript" src="{{asset('js/charts-custom.js') }}"></script>
<script type="text/javascript" src="{{asset('js/front.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/daterange/js/knockout-3.4.2.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/daterange/js/daterangepicker.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{asset('js/dropzone.js') }}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-treeview.js') }}"></script>

<!-- table sorter js-->
<script type="text/javascript" src="{{asset('vendor/datatable/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/datatable/vfs_fonts.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/datatable/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/datatable/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/datatable/buttons.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/datatable/buttons.colVis.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/datatable/buttons.html5.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/datatable/buttons.print.min.js') }}"></script>

<script type="text/javascript" src="{{asset('vendor/datatable/sum().js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/datatable/dataTables.checkboxes.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/datatable/date-eu.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/accounting.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor/toastr/toastr.min.js')}}"></script>

<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js">
</script>
<script type="text/javascript" src="{{asset('vendor/cropperjs/cropper.min.js') }}"></script>
<script type="text/javascript" src="{{asset('js/printThis.js') }}"></script>
<script type="text/javascript" src="{{asset('js/common.js') }}"></script>
<script type="text/javascript" src="{{asset('js/currency_exchange.js') }}"></script>
<script type="text/javascript" src="{{asset('js/customer.js') }}"></script>
<script type="text/javascript" src="{{asset('js/cropper.js') }}"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(jqXHR, settings) {
            if (settings.url.indexOf('http') === -1) {
                settings.url = base_path + settings.url;
            }
        },
    });
</script>
<script type="text/javascript">
    @if (session('status'))
        swal(
            @if (session('status.success') == '1')
                "Success"
            @else
                "Error"
            @endif , "{{ session('status.msg') }}",
            @if (session('status.success') == '1')
                "success"
            @else
                "error"
            @endif );
    @endif
    $(document).ready(function() {
        let cash_register_id = $('#cash_register_id').val();

        if (cash_register_id) {
            $('#power_off_btn').removeClass('hide');
        }

        $(document).on('hidden.bs.modal', '#closing_cash_modal', function() {
            $('#print_closing_cash').html('');
        });
        $(document).on('click', '#print-closing-cash-btn', function() {
            let cash_register_id = parseInt($(this).data('cash_register_id'));
            console.log('/cash/print-closing-cash/' + cash_register_id, 'cash_register_id');
            $.ajax({
                method: 'GET',
                url: '/cash/print-closing-cash/' + cash_register_id,
                data: {},
                success: function(result) {
                    $('#print_closing_cash').html(result);
                    $('#print_closing_cash').printThis({
                        importCSS: true,
                        importStyle: true,
                        loadCSS: "",
                        header: "<h1>@lang('lang.closing_cash')</h1>",
                        footer: "",
                        base: true,
                        pageTitle: "Closing Cash",
                        removeInline: false,
                        printDelay: 333,
                        header: null,
                        formValues: true,
                        canvas: true,
                        base: null,
                        doctypeString: '<!DOCTYPE html>',
                        removeScripts: true,
                        copyTagClasses: true,
                        beforePrintEvent: null,
                        beforePrint: null,
                        afterPrint: null,
                        afterPrintEvent: null,
                        canvas: false,
                        noPrintSelector: ".no-print",
                        iframe: false,
                        append: null,
                        prepend: null,
                        noPrintClass: "no-print",
                        importNode: true,
                        pagebreak: {
                            avoid: "",
                            after: "",
                            before: "",
                            mode: "css",
                            pageBreak: "auto",
                            pageSelector: "",
                            styles: "",
                            selector: "",
                            validSelectors: [],
                            validTags: [],
                            width: "",
                            height: ""
                        },

                    });
                    // __print_receipt("print_closing_cash");
                },
            });
        })
    })

    jQuery.validator.setDefaults({
        errorPlacement: function(error, element) {
            if (element.parent().parent().hasClass('my-group')) {
                element.parent().parent().parent().find('.error-msg').html(error)
            } else {
                error.insertAfter(element);
            }
        }
    });
    $(document).on('click', '.btn-modal', function(e) {
        e.preventDefault();
        var container = $(this).data('container');
        $.ajax({
            url: $(this).data('href'),
            dataType: 'html',
            success: function(result) {
                $(container).html(result).modal('show');
            },
        });
    });
    @if (request()->segment(1) != 'pos')
        if ($(window).outerWidth() > 1199) {
            $('nav.side-navbar').removeClass('shrink');
        }
    @endif
    function myFunction() {
        setTimeout(showPage, 150);
    }

    function showPage() {
        document.getElementById("loader").style.display = "none";
        document.getElementById("content").style.display = "block";
    }

    $("div.alert").delay(3000).slideUp(750);

    $(document).on('click', '.delete_item', function(e) {
        e.preventDefault();
        swal({
            title: 'Are you sure?',
            text: "Are you sure You Wanna Delete it?",
            icon: 'warning',
        }).then(willDelete => {
            if (willDelete) {
                var check_password = $(this).data('check_password');
                var href = $(this).data('href');
                var data = $(this).serialize();

                swal({
                    title: 'Please Enter Your Password',
                    content: {
                        element: "input",
                        attributes: {
                            placeholder: "Type your password",
                            type: "password",
                            autocomplete: "off",
                            autofocus: true,
                        },
                    },
                    inputAttributes: {
                        autocapitalize: 'off',
                        autoComplete: 'off',
                    },
                    focusConfirm: true
                }).then((result) => {
                    if (result) {
                        $.ajax({
                            url: check_password,
                            method: 'POST',
                            data: {
                                value: result
                            },
                            dataType: 'json',
                            success: (data) => {

                                if (data.success == true) {
                                    swal(
                                        'Success',
                                        'Correct Password!',
                                        'success'
                                    );

                                    $.ajax({
                                        method: 'DELETE',
                                        url: href,
                                        dataType: 'json',
                                        data: data,
                                        success: function(result) {
                                            if (result.success ==
                                                true) {
                                                swal(
                                                    'Success',
                                                    result.msg,
                                                    'success'
                                                );
                                                setTimeout(() => {
                                                    location
                                                        .reload();
                                                }, 1500);
                                                location.reload();
                                            } else {
                                                swal(
                                                    'Error',
                                                    result.msg,
                                                    'error'
                                                );
                                            }
                                        },
                                    });

                                } else {
                                    swal(
                                        'Failed!',
                                        'Wrong Password!',
                                        'error'
                                    )

                                }
                            }
                        });
                    }
                });
            }
        });
    });


    $(".daterangepicker-field").daterangepicker({
        callback: function(startDate, endDate, period) {
            var start_date = startDate.format('YYYY-MM-DD');
            var end_date = endDate.format('YYYY-MM-DD');
            var title = start_date + ' To ' + end_date;
            $(this).val(title);
            $('input[name="start_date"]').val(start_date);
            $('input[name="end_date"]').val(end_date);
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
    $('.selectpicker').selectpicker({
        style: 'btn-link',
    });


    $(document).on('click', "#power_off_btn", function(e) {
        let cash_register_id = $('#cash_register_id').val();
        let is_register_close = parseInt($('#is_register_close').val());
        if (!is_register_close) {
            getClosingModal(cash_register_id);
            return 'Please enter the closing cash';
        } else {
            return;
        }
    });


    function getClosingModal(cash_register_id, type = 'close') {
        $.ajax({
            method: 'get',
            url: '/cash/add-closing-cash/' + cash_register_id,
            data: {
                type
            },
            contentType: 'html',
            success: function(result) {
                $('#closing_cash_modal').empty().append(result);
                $('#closing_cash_modal').modal('show');
            },
        });
    }
    $(document).on('click', '#closing-save-btn, #adjust-btn', function(e) {
        $('#is_register_close').val(1);
    })
    $(document).on('click', '#logout-btn', function(e) {
        let cash_register_id = $('#cash_register_id').val();

        let is_register_close = parseInt($('#is_register_close').val());
        if (!is_register_close) {
            getClosingModal(cash_register_id, 'logout');
            return 'Please enter the closing cash';
        } else {
            $('#logout-form').submit();
        }
    })
    $(document).on('click', '.close-btn-add-closing-cash', function(e) {
        e.preventDefault()
        $('form#logout-form').submit();
    })
    $(document).on('click', '.notification-list', function() {
        $.ajax({
            method: 'get',
            url: '/notification/notification-seen',
            data: {},
            success: function(result) {
                if (result) {
                    $('.notification-number').text(0);
                    $('.notification-number').addClass('hide')
                }
            },
        });
    })
    $(document).on('click', '.notification_item', function(e) {
        e.preventDefault();
        let mark_read_action = $(this).data('mark-read-action');
        let href = $(this).data('href');
        $.ajax({
            method: 'get',
            url: mark_read_action,
            data: {},
            success: function(result) {

            },
        });
        window.open(href, '_blank');
    })
    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
    $('input').attr('autocomplete', 'off');
</script>
