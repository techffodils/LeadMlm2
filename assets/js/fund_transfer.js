$("#username_add").blur(function () {
    $.ajax({url: "admin/wallet/get_user_balance",
        data: {username: $("#username_add").val()},
        async: false,
        success: function (msg) {
            if (msg >= 0) {
                $("#user_balance_add_div").show();
                $("#user_balance_add").val(msg);
            } else {
                $("#user_balance_add_div").hide();
                $("#user_balance_add").val('0');
            }
        }
    });
});


$("#username_ded").blur(function () {
    $.ajax({url: "admin/wallet/get_user_balance",
        data: {username: $("#username_ded").val()},
        async: false,
        success: function (msg) {
            if (msg >= 0) {
                $("#user_balance_ded_div").show();
                $("#user_balance_ded").val(msg);
            } else {
                $("#user_balance_ded_div").hide();
                $("#user_balance_ded").val('0');
            }
        }
    });
});


$("#from_username").blur(function () {
    $.ajax({url: "admin/wallet/get_user_balance",
        data: {username: $("#from_username").val()},
        async: false,
        success: function (msg) {
            if (msg >= 0) {
                $("#from_user_balance_div").show();
                $("#from_user_balance").val(msg);
            } else {
                $("#from_user_balance_div").hide();
                $("#from_user_balance").val('0');
            }
        }
    });
});


$("#to_username").blur(function () {
    $.ajax({url: "admin/wallet/get_user_balance",
        data: {username: $("#to_username").val()},
        async: false,
        success: function (msg) {
            if (msg >= 0) {
                $("#to_user_balance_div").show();
                $("#to_user_balance").val(msg);
            } else {
                $("#to_user_balance_div").hide();
                $("#to_user_balance").val('0');
            }
        }
    });
});



$.validator.addMethod("validUsername1", function () {
    var isSuccess = false;
    $.ajax({url: "register/validate_sponsor",
        data: {username: $("#username_add").val()},
        async: false,
        success:
                function (msg) {
                    isSuccess = msg === "yes" ? true : false
                }
    });
    return isSuccess;
}, "Sorry, Invalid Username");

$.validator.addMethod("validUsername2", function () {
    var isSuccess = false;
    $.ajax({url: "register/validate_sponsor",
        data: {username: $("#username_ded").val()},
        async: false,
        success:
                function (msg) {
                    isSuccess = msg === "yes" ? true : false
                }
    });
    return isSuccess;
}, "Sorry, Invalid Username");

$.validator.addMethod("validUsername3", function () {
    var isSuccess = false;
    $.ajax({url: "register/validate_sponsor",
        data: {username: $("#from_username").val()},
        async: false,
        success:
                function (msg) {
                    isSuccess = msg === "yes" ? true : false
                }
    });
    return isSuccess;
}, "Sorry, Invalid Username");

$.validator.addMethod("validUsername4", function () {
    var isSuccess = false;
    $.ajax({url: "register/validate_sponsor",
        data: {username: $("#to_username").val()},
        async: false,
        success:
                function (msg) {
                    isSuccess = msg === "yes" ? true : false
                }
    });
    return isSuccess;
}, "Sorry, Invalid Username");

var validate_add_fund = function () {
    var form = $('#add_fund_form');
    var errorHandler2 = $('.errorHandler', form);
    var successHandler2 = $('.successHandler', form);
    form.validate({
        errorElement: "span", // contain the error msg in a small tag
        errorClass: 'help-block',
        errorPlacement: function (error, element) { // render error placement for each input type
            if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                error.insertAfter($(element).closest('.form-group').children('div').children().last());
            } else if (element.hasClass("ckeditor")) {
                error.appendTo($(element).closest('.form-group'));
            } else {
                error.insertAfter($(element).closest('.form-group').children('div').children().last());
            }
        },
        ignore: ':hidden',
        rules: {
            username_add: {
                validUsername1: true,
                required: true,
                minlength: 3
            },
            amount_add: {
                required: true,
                number: true,
                min: 1
            }
        },
        messages: {
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

            form.submit();

        }
    });
};

var validate_ded_fund = function () {
    var form = $('#ded_fund_form');
    var errorHandler2 = $('.errorHandler', form);
    var successHandler2 = $('.successHandler', form);
    form.validate({
        errorElement: "span", // contain the error msg in a small tag
        errorClass: 'help-block',
        errorPlacement: function (error, element) { // render error placement for each input type
            if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                error.insertAfter($(element).closest('.form-group').children('div').children().last());
            } else if (element.hasClass("ckeditor")) {
                error.appendTo($(element).closest('.form-group'));
            } else {
                error.insertAfter($(element).closest('.form-group').children('div').children().last());
            }
        },
        ignore: ':hidden',
        rules: {
            username_ded: {
                validUsername2: true,
                required: true,
                minlength: 3
            },
            amount_ded: {
                required: true,
                number: true,
                min: 1
            }
        },
        messages: {
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

            form.submit();

        }
    });
};

var validate_trans_fund = function () {
    var form = $('#transfer_fund_form');
    var errorHandler2 = $('.errorHandler', form);
    var successHandler2 = $('.successHandler', form);
    form.validate({
        errorElement: "span", // contain the error msg in a small tag
        errorClass: 'help-block',
        errorPlacement: function (error, element) { // render error placement for each input type
            if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                error.insertAfter($(element).closest('.form-group').children('div').children().last());
            } else if (element.hasClass("ckeditor")) {
                error.appendTo($(element).closest('.form-group'));
            } else {
                error.insertAfter($(element).closest('.form-group').children('div').children().last());
            }
        },
        ignore: ':hidden',
        rules: {
            from_username: {
                validUsername3: true,
                required: true,
                minlength: 3
            },
            to_username: {
                validUsername4: true,
                required: true,
                minlength: 3
            },
            amount_trans: {
                required: true,
                number: true,
                min: 1
            }
        },
        messages: {
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

            form.submit();

        }
    });
};


