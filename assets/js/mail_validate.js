function staredMail()
{
    alert('sdsdssdsss');
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


