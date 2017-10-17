    function changeLanguageStatus(lang_id, element)
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
            url: "admin/configuration/change_language_status",
            data: {lang_id: lang_id, status: status},
            success: function (result) {
                if (result == "yes") {
                    if (status == "active") {
                        var msg = "Language Activated";
                        var flag = "success";
                        var title = "Success";
                        show_notification(flag, title, msg);
                    } else {
                        var flag = "error";
                        var msg = "Language Inactivated";
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


    function changeCurrencyStatus(currency_id, element)
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
            url: "admin/configuration/change_currency_status",
            data: {currency_id: currency_id, status: status},
            success: function (result) {
                if (result == "yes") {
                    if (status == "active") {
                        var msg = "Currency Activated";
                        var flag = "success";
                        var title = "Success";
                        show_notification(flag, title, msg);
                    } else {
                        var flag = "error";
                        var msg = "Currency Inactivated";
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