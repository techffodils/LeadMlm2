$.validator.addMethod("validUsername", function () {
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
    
    $.validator.addMethod("validTranPassword", function () {
        var isSuccess = false;
        $.ajax({url: "user/wallet/validate_tran_password",
            data: {transaction_password: $("#transaction_password").val()},
            async: false,
            success:
                    function (msg) {
                        isSuccess = msg === "yes" ? true : false
                    }
        });
        return isSuccess;
    }, "Sorry, Invalid Transaction Password");

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
                to_username: {
                    validUsername: true,
                    required: true,
                    minlength: 3
                },
                amount_trans: {
                    required: true,
                    number: true,
                    min: 1
                },
                transaction_password: {
                    required: true,
                    validTranPassword:true
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