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

var valBonusSettings = function () {
    var form2 = $('#bonus_form');
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
            pair_bonus: {
                required: true,
                number: true,
                min:0
            }, referal_bonus: {
                required: true,
                number: true,
                min:0
            }
        },
        messages: {
            pair_bonus: "Please enter Pair Bonus",
            referal_bonus: "Please enter Referal Bonus"
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
            var pair_bonus = $('#pair_bonus').val();
            var referal_bonus = $('#referal_bonus').val();

            $.ajax({
                url: "admin/configuration/change_bonus_settings",
                data: { pair_bonus: pair_bonus, referal_bonus: referal_bonus },
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


var valUsernameSettings = function () {
    var form2 = $('#username_form');
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
            username_type: {
                required: true
            }, username_size: {
                required: true,
                number: true,
                max:10
            },username_prefix:{
                maxlength:4
            }
        },
        messages: {
            username_type: "Please select a Username Type",
            username_size: "Please enter a Valid Size",
            username_prefix:"Maximum 4 characters"
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
            var username_type = $('#username_type').val();
            var username_size = $('#username_size').val();
            var username_prefix = $('#username_prefix').val();
    
            $.ajax({
                url: "admin/configuration/change_username_settings",
                data: { username_type: username_type, username_size: username_size,username_prefix:username_prefix },
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


var valLegSettings = function () {
    var form2 = $('#user_position_form');
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
            register_leg: {
                required: true
            }
        },
        messages: {
            register_leg: "Please select a Leg"
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
            var register_leg = $('#register_leg').val();
    
            $.ajax({
                url: "admin/configuration/change_leg_settings",
                data: { register_leg: register_leg },
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

var valMatrixSettings = function () {
    var form2 = $('#depth_width_form');
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
            matrix_depth: {
                required: true
            },matrix_width: {
                required: true
            }
        },
        messages: {
            matrix_depth: "Please enter Depth",
            matrix_width: "Please enter Width"
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
            var matrix_width = $('#matrix_width').val();
            var matrix_depth = $('#matrix_depth').val();
            $.ajax({
                url: "admin/configuration/change_matrix_settings",
                data: { matrix_width: matrix_width,matrix_depth:matrix_depth },
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
