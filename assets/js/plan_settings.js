function changePaymentStatus(payment_code, element)
    {
        $.blockUI({
            message: '<i class="fa fa-spinner fa-spin"></i> Please Wait...'
        });
        if (element.checked) {
            var status = "active";
        } else {
            var status = "inactive";
        }
        $.ajax({
            url: "admin/configuration/change_payment_status",
            data: {payment_code: payment_code, status: status},
            success: function (result) {
                if (result == "yes") {
                    if (status == "active") {
                        var msg = payment_code + " Activated";
                        var flag = "success";
                        var title = "Success";
                        show_notification(flag, title, msg);
                    } else {
                        var flag = "error";
                        var msg = payment_code + " Inactivated";
                        var title = "Success";
                        show_notification(flag, title, msg);
                    }

                } else {
                    var flag = "error";
                    var msg = "Updation Failed";
                    var title = "Failed";
                    show_notification(flag, title, msg);
                }
            }
        });
    }


    function changeFieldConfigStatus(element)
    {
        $.blockUI({
            message: '<i class="fa fa-spinner fa-spin"></i> Please Wait...'
        });
        if (element.checked) {
            var status = "active";
        } else {
            var status = "inactive";
        }
        $.ajax({
            url: "admin/configuration/change_reg_field_status",
            data: {status: status},
            success: function (result) {
                if (result == "yes") {
                    if (status == "active") {
                        var msg = "Configured Registration Enabled";
                        var flag = "success";
                        var title = "Success";
                        show_notification(flag, title, msg);
                    } else {
                        var msg = "Configured Registration Disabled";
                        var flag = "error";
                        var title = "Success";
                        show_notification(flag, title, msg);
                    
                    }
                    
                } else {
                    var flag = "error";
                    var msg = "Updation Failed";
                    var title = "Failed";
                    show_notification(flag, title, msg);
                }
            }
        });
    }


    function changeRegisterForm(element)
    {
        $.blockUI({
            message: '<i class="fa fa-spinner fa-spin"></i> Please Wait...'
        });
        if (element.checked) {
            var status = "single";
        } else {
            var status = "multiple";
        }
        $.ajax({
            url: "admin/configuration/change_register_form_type",
            data: {status: status},
            success: function (result) {
                if (result == "yes") {
                    if (status == "single") {
                        var msg = "Single Step Registration Enabled";
                    } else {
                        var msg = "Multiple Step Registration Enabled";
                    }
                    var flag = "success";
                    var title = "Success";
                    show_notification(flag, title, msg);
                } else {
                    var flag = "error";
                    var msg = "Updation To Failed";
                    var title = "Failed";
                    show_notification(flag, title, msg);
                }
            }
        });
    }



    function show_notification(status, title, msg) {
        $.unblockUI();
        var i = -1;
        var toastCount = 0;
        var $toastlast;
        var toastIndex = toastCount++;
        toastr.options = {
            closeButton: $('#closeButton').prop('checked'),
            debug: $('#debugInfo').prop('checked'),
            positionClass: $('#positionGroup input:radio:checked').val() || 'toast-top-right',
            onclick: null
        };

        $("#toastrOptions").text("Command: toastr["
                + status
                + "](\""
                + msg
                + (title ? "\", \"" + title : '')
                + "\")\n\ntoastr.options = "
                + JSON.stringify(toastr.options, null, 2)
                );

        var $toast = toastr[status](msg, title); // Wire up an event handler to a button in the toast, if it exists

    }
