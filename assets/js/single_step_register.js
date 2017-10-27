$.validator.addMethod("validUsername", function () {
        var isSuccess = false;
        $.ajax({url: "register/validate_username",
            data: {username: $("#username").val()},
            async: false,
            success:
                    function (msg) {
                        isSuccess = msg === "yes" ? true : false
                    }
        });
        return isSuccess;
    }, "Sorry, Username Not Available");

    $.validator.addMethod("validSponsor", function () {
        var isSuccess = false;
        $.ajax({url: "register/validate_sponsor",
            data: {username: $("#sponser_name").val()},
            async: false,
            success:
                    function (msg) {
                        isSuccess = msg === "yes" ? true : false
                    }
        });
        return isSuccess;
    }, "Sorry, Invalid Sponsorname");

    $.validator.addMethod("valiEmail", function () {
        var isSuccess = false;
        $.ajax({url: "register/valid_email",
            data: {email: $("#email").val()},
            async: false,
            success:
                    function (msg) {
                        isSuccess = msg === "yes" ? true : false
                    }
        });
        return isSuccess;
    }, "Sorry, Email Not Available");

    var valSingleStep = function () {        
        var form = $('#single_step_form');
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
                }else if(element.attr("name") == "password"){
                    error.insertAfter(element);
                } else if(element.attr("type") == "text" || element.attr("type") == "email" || element.attr("type") == "password") {
                    error.insertAfter($(element).closest('.input-group'));
                    // for other inputs, just perform default behavior
                }else if(element.attr("name") == "password"){
                    error.insertAfter(element);
                }else {
                    error.insertAfter(element);
                    // for other inputs, just perform default behavior
                }
            },
            ignore: "",
            rules: {
                sponser_name: {
                    validSponsor: true,
                    required: true
                },
                username: {
                    validUsername: true,
                    minlength: 4,
                    required: true,
                },
                email: {
                    valiEmail: true,
                    required: true,
                    email: true
                },
                password: {
                    minlength: 6,
                    required: true
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                first_name: {
                    required: true,
                    minlength: 2,
                }, agree: {
                    required: true
                },register_leg:{
                    required: true
                },country:{
                    required: true
                },payment_method:{
                    required: true
                },privacy_policy:{
                    required: true
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

                form.submit();

            }
        });
    };