/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$(document).ready(function () {
    const bodyTag = $("body");
    const frontend_validation = $(".frontend-validation");
    const dataTable = $(".dataTable");
    const dropify = $(".dropify");


    if (frontend_validation.length) {
        frontend_validation.parsley();
    }

    if (dataTable.length) {
        dataTable.DataTable();
    }

    if (dropify.length) {

        $('.dropify').dropify();

    }

    let modalProperties = {
        actionUrl: "",
        actionType: "Show",
        methodType: "POST",
        title: "Create New",
        buttonLabel: "Save",
        size: 'md',
        deleteTextMessage: "Are You Sure?|This action can not be undone. Do you want to continue?"
    };


    let modal = $("#productiveModal");

    function renderModal() {
        $(modal).find(".modal-title").html(modalProperties.title);
        $(modal).find("#btn-modal-save").html(modalProperties.buttonLabel);
        $(modal).find(".modal-body").html("Loading..");

        $(modal).find(".modal-dialog").removeClass('modal-sm modal-md modal-lg').addClass('modal-' + modalProperties.size);

        if (modalProperties.actionType == "Show") {
            $(modal).find("#btn-modal-save").hide();
        } else {
            $(modal).find("#btn-modal-save").show();
        }
    }

    function arrayToJson(form) {
        let data = $(form).serializeArray();
        let indexed_array = {};
        $.map(data, function (n, i) {
            indexed_array[n["name"]] = n["value"];
        });
        return indexed_array;
    }

    function toastrs(title, message, status) {
        toastr[status](message, title);
    }


    function loadModal() {

        $.blockUI({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });

        renderModal();

        axios
            .get(modalProperties.actionUrl)
            .then(function (response) {
                if (response.status === 200) {
                    $(modal).find(".modal-body").html(response.data);
                    $(modal).modal();
                    $.unblockUI();
                    common_bind("#productiveModal");
                    common_bind_select("#productiveModal");
                }
            })
            .catch(function (error) {
                console.log(error);
                $.unblockUI();
            })
            .then(function () {
                //console.log(modalProperties.actionUrl);
            });

    }

    $(document).on('click', '#btn-open-modal-to-create', function (ev) {
        ev.preventDefault();

        modalProperties.title = $(this).data('title');
        modalProperties.size = $(this).data("modal_size");

        modalProperties.actionType = "Create";
        modalProperties.buttonLabel = "Create";

        modalProperties.actionUrl = $(this).data("url");
        modalProperties.methodType = $(this).data('method');

        loadModal();

    });


    bodyTag.on("click", ".btn-datatable-row-action", function (ev) {
        ev.preventDefault();

        modalProperties.actionUrl = $(this).data("url");
        modalProperties.title = $(this).data("title");
        modalProperties.size = $(this).data("modal_size");

        let type = $(this).data("type");
        common_bind("#productiveModal");
        common_bind_select("#productiveModal");

        switch (type) {
            case 'details':
                modalProperties.methodType = "GET";
                modalProperties.actionType = "Show";
                loadModal();
                break;
            case 'edit':
                modalProperties.buttonLabel = "Update";
                modalProperties.methodType = "PATCH";
                modalProperties.actionType = "Edit";
                loadModal();
                break;
            case 'delete':
                modalProperties.buttonLabel = "Delete";
                modalProperties.methodType = "DELETE";
                modalProperties.deleteTextMessage = $(this).data("message")

                swal({
                    title: "Are you sure?",
                    text: modalProperties.deleteTextMessage,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {

                        $.blockUI({
                            css: {
                                border: 'none',
                                padding: '15px',
                                backgroundColor: '#000',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                opacity: .5,
                                color: '#fff'
                            }
                        });

                        axios({
                            method: modalProperties.methodType,
                            url: modalProperties.actionUrl,
                            config: {
                                headers: {
                                    "Content-Type": "multipart/form-data",
                                },
                            },
                        })
                            .then(function (response) {
                                $.unblockUI();
                                $.modalCallBackOnAnyChange();
                                iziToast.success({
                                    title: "Success",
                                    message: response.data.message,
                                    position: "topRight",
                                });
                            })
                            .catch(function (error) {
                                $.unblockUI();
                                console.log(error);
                            })
                            .then(function () {
                                $.unblockUI();
                            });
                    }
                });
                break;
        }
    });

    function resetFormErrors() {
        $('.form-control').removeClass('is-invalid');
        $('.form-group').find('.invalid-feedback').hide();
    }

    bodyTag.on("click", "#btn-modal-save", function (ev) {
        ev.preventDefault();

        $(modal).find("#name").removeClass("is-invalid");
        $(modal).find("#name_mesage").removeClass();

        $(modal).find("#name_message").html("");

        $(modal).find("#btn-modal-save").html("Processing..").attr("disabled", true);

        let actionUrl = $(modal).find("form").attr("action");
        modalProperties.methodType = $(modal).find("form").attr("method");

        let modalFromData = arrayToJson($(modal).find("form"));

        if (modalProperties.actionType == "Edit") {
            modalFromData.status = $(modal).find("#status").val();
        }

        $(modal).find(".modal-body").block({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });

        axios({
            method: modalProperties.methodType,
            url: actionUrl,
            data: modalFromData,
            config: {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            },
        }).then(function (response) {
            $(modal).find("#btn-modal-save").html("Processing..").attr("disabled", false);
            $(modal).find(".modal-body").unblock();
            $.modalCallBackOnAnyChange();
            iziToast.success({
                title: "Success",
                message: response.data.message,
                position: "topRight",
            });
            $(modal).modal("hide");
        }).catch(function (error) {
            if (error.response) {
                $(modal).find("#btn-modal-save").html("Processing..").attr("disabled", false);
                $(modal).find(".modal-body").unblock();
                resetFormErrors();
                let errors = error.response.data.errors;
                $.each(errors, function (key, value) {
                    $(modal).find("#" + key).addClass("is-invalid");
                    $(modal).find("#" + key + "_message")
                        .html(value[0]);
                    $(modal).find("#" + key + "_message").show().addClass("invalid-feedback");
                });
            }
        }).then(function () {
            $(modal).find("#btn-modal-save").html("Processing..").attr("disabled", false);
            $(modal).find(".modal-body").unblock();
            $(modal).find("#btn-modal-save").html(modalProperties.buttonLabel);
        });
    });

    function common_bind(selector = "body") {
        let $datepicker = $(selector + ' .datepicker');

        // if ($(".datepicker").length) {
        $datepicker.daterangepicker({
            singleDatePicker: true,
            format: 'yyyy-mm-dd',
            locale: date_picker_locale,
            todayHighlight: true,
        });
        // }

        if ($(".datetimepicker").length) {
            $('.datetimepicker').daterangepicker({
                locale: {format: 'YYYY-MM-DD H:mm'},
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: true,
            });
        }

        // Daterangepicker
        if (jQuery().daterangepickeer) {
            if ($(".datepicker").length) {
                $('.datepicker').daterangepicker({
                    locale: {format: 'YYYY-MM-DD'},
                    singleDatePicker: true,
                });
            }
            if ($(".datetimepicker").length) {
                $('.datetimepicker').daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD H:mm'
                    },
                    singleDatePicker: true,
                    timePicker: true,
                    timePicker24Hour: true,
                });
            }
            if ($(".daterange").length) {
                $('.daterange').daterangepicker({
                    locale: {format: 'YYYY-MM-DD'},
                    drops: 'down',
                    opens: 'right'
                });
            }

        }

        // Timepicker
        if (jQuery().timepicker && $(".timepicker").length) {
            $(".timepicker").timepicker({
                icons: {
                    up: 'fas fa-chevron-up',
                    down: 'fas fa-chevron-down'
                },
                showMeridian: false
            });
        }

        if ($(".jscolor").length) {
            jscolor.installByClassName("jscolor");
        }

        if ($(".summernote").length) {
            $(".summernote").summernote({
                dialogsInBody: true,
                minHeight: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['paragraph']],
                    ['insert', ['link']],
                    ['view', ['undo', 'redo', 'fullscreen', 'help']],
                ]
            });
        }

        if ($(".summernote-simple").length) {
            $(".summernote-simple").summernote({
                dialogsInBody: true,
                minHeight: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['paragraph']]
                ]
            });
        }

        if (jQuery().select2) {
            $(".select2").select2();
        }

    }

    function common_bind_select(selector = "body") {
        if (jQuery().selectric) {
            $(".selectric").selectric({
                disableOnMobile: false,
                nativeOnMobile: false
            });
        }
    }

    // Block and Unblock UI
    function blockUI() {
        $(selector).block({
            message: '<i class="icon-spinner2 spinner"></i>',
            overlayCSS: {backgroundColor: '#fff', opacity: 0.8, cursor: 'wait', 'box-shadow': '0 0 0 1px #ddd'},
            css: {border: 0, padding: 0, backgroundColor: 'none'}
        });
    }

    function unblockUI(selector) {
        $(selector).unblock();
    }


    if (jQuery().summernote) {

        $(".summernote").summernote({
            dialogsInBody: true,
            minHeight: 150,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['paragraph']],
                ['insert', ['link']],
                ['view', ['undo', 'redo', 'fullscreen', 'help']],
            ]
        });

    }


});

(function($){
    $.fn.chartJSNoDataRender=function(){
        Chart.plugins.register({
            afterDraw: function(chart) {
                if (chart.data.datasets[0].data.every(item => item === 0)) {
                    let ctx = chart.chart.ctx;
                    let width = chart.chart.width;
                    let height = chart.chart.height;

                    chart.clear();
                    ctx.save();
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fontWeight = "bold"
                    ctx.font = "26px normal 'Helvetica Nueue'";
                    ctx.fillText('No data to display', width / 2, height / 2);
                    ctx.restore();
                }
            }
        });
    }
})(jQuery);

