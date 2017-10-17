function generate_backup()
{
    $.blockUI({
        message: '<i class="fa fa-spinner fa-spin"></i> Please Wait...'
    });

    $.ajax({
        url: 'admin/backup/db_backup',
        success: function (response) {
            $.unblockUI();
            var res = $.parseJSON(response);
            if (res.response == 'yes') {
                $('#sample-table-1 tr:first').after('<tr><td>' + res.download + '</td><td>' + res.done_by + '</td><td>' + res.date + '</td><td>' + res.file + '</td></tr>');
                swal("Success!", "Backup Generated Successfully", "success");
            } else {
                swal("Failed", "Backup Generation Failed", "error");
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

var valBackup = function () {
    var form2 = $('#add_field_form');
    var errorHandler2 = $('.errorHandler', form2);
    var successHandler2 = $('.successHandler', form2);
    form2.validate({
        errorElement: "span", // contain the error msg in a small tag
        errorClass: 'help-block',
        errorPlacement: function (error, element) { // render error placement for each input type
            if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                error.insertAfter($(element).closest('.form-group').children('div').children().last());
            } else if (element.hasClass("ckeditor")) {
                error.appendTo($(element).closest('.form-group'));
            } else {
                error.insertAfter(element)// for other inputs, just perform default behavior
            }
        },
        ignore: "",
        rules: {
            backup_deletion_period: {
                required: true,
                number: true
            }, backup_type: {
                required: true
            }
        },
        messages: {
            backup_deletion_period: "Please specify your Deletion Period",
            backup_type: "Please specify your Backup Type"
        },
        invalidHandler: function (event, validator) { //display error alert on form submit
            successHandler2.hide();
            errorHandler2.show();
        },
        highlight: function (element) {
            $(element).closest('.help-block').removeClass('valid');// display OK icon
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
            // add the Bootstrap error class to the control group
        },
        unhighlight: function (element) { // revert the change done by hightlight
            $(element).closest('.form-group').removeClass('has-error');
            // set error class to the control group
        },
        success: function (label, element) {
            label.addClass('help-block valid');
            // mark the current input as valid and display OK icon
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
        },
        submitHandler: function (form) {
            successHandler2.show();
            errorHandler2.hide();
            // submit form//$('#form2').submit();

            $.blockUI({
                message: '<i class="fa fa-spinner fa-spin"></i> Please Wait...'
            });
            var backup_deletion_period = $('#backup_deletion_period').val();
            var backup_type = $('#backup_type').val();

            $.ajax({
                url: "admin/backup/change_settings",
                data: {backup_deletion_period: backup_deletion_period, backup_type: backup_type},
                success: function (result) {
                    if (result == "yes") {
                        var msg = "Settings Changed";
                        var flag = "success";
                        var title = "Success";
                        show_notification(flag, title, msg);

                    } else {
                        var flag = "error";
                        var msg = "Updation Failed";
                        var title = "Failed";
                        show_notification(flag, title, msg);
                    }
                }
            });
        }
    });


    
};