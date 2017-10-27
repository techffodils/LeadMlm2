var FormWizard = function () {
    "use strict";
    var wizardContent = $('#wizard');
    var wizardForm = $('#form');
    var numberOfSteps = $('.swMain > ul > li').length;
    var initWizard = function () {
        // function to initiate Wizard Form
        wizardContent.smartWizard({
            selected: 0,
            keyNavigation: false,
            onLeaveStep: leaveAStepCallback,
            onShowStep: onShowStep,
        });
        var numberOfSteps = 0;
        animateBar();
        initValidator();
    };
    var animateBar = function (val) {
        if ((typeof val == 'undefined') || val == "") {
            val = 1;
        }
        ;

        var valueNow = Math.floor(100 / numberOfSteps * val);
        $('.step-bar').css('width', valueNow + '%');
    };
    var validateCheckRadio = function (val) {
        $("input[type='radio'], input[type='checkbox']").on('ifChecked', function (event) {
            $(this).parent().closest(".has-error").removeClass("has-error").addClass("has-success").find(".help-block").remove().end().find('.symbol').addClass('ok');
        });
    };
    var initValidator = function () {
        $.validator.addMethod("cardExpiry", function () {
            //if all values are selected
            if ($("#card_expiry_mm").val() != "" && $("#card_expiry_yyyy").val() != "") {
                return true;
            } else {
                return false;
            }
        }, 'Please select a month and year');

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

        $.validator.setDefaults({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                    error.insertAfter($(element).closest('.form-group').children('div').children().last());
                } else if (element.attr("name") == "card_expiry_mm" || element.attr("name") == "card_expiry_yyyy") {
                    error.appendTo($(element).closest('.form-group').children('div'));
                } else if(element.attr("name") == "password"){
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
            ignore: ':hidden',
            rules: {
                sponser_name: {
                    validSponsor:true,
                    required: true
                },register_leg:{
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
                },
                phone_number: {
                    required: true
                },
                gender: {
                    required: true
                },
                address: {
                    required: true
                },
                country: {
                    required: true
                },
                zip_code: {
                    digits: true,
                    maxlength: 7
                },
                card_number: {
                    minlength: 16,
                    maxlength: 16,
                },
                card_cvc: {
                    digits: true,
                    minlength: 3,
                    maxlength: 4
                },
                card_expiry_yyyy: "cardExpiry",
                payment: {
                    required: true,
                    minlength: 1
                },privacy_policy:{
                    required: true
                }
            },
            messages: {
                firstname: "Please specify your first name"
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
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
            }
        });
    };
    var displayConfirm = function () {
        $('.display-value', form).each(function () {
            var input = $('[name="' + $(this).attr("data-display") + '"]', form);
            if (input.attr("type") == "text" || input.attr("type") == "email" || input.is("textarea")) {
                $(this).html(input.val());
            } else if (input.is("select")) {
                $(this).html(input.find('option:selected').text());
            } else if (input.is(":radio") || input.is(":checkbox")) {

                $(this).html(input.filter(":checked").closest('label').text());
            } else if ($(this).attr("data-display") == 'card_expiry') {
                $(this).html($('[name="card_expiry_mm"]', form).val() + '/' + $('[name="card_expiry_yyyy"]', form).val());
            }
        });
    };
    var onShowStep = function (obj, context) {
        if (context.toStep == numberOfSteps) {
            $('.anchor').children("li:nth-child(" + context.toStep + ")").children("a").removeClass('wait');
            displayConfirm();
        }
        $(".next-step").unbind("click").click(function (e) {
            e.preventDefault();
            wizardContent.smartWizard("goForward");
        });
        $(".back-step").unbind("click").click(function (e) {
            e.preventDefault();
            wizardContent.smartWizard("goBackward");
        });
        $(".finish-step").unbind("click").click(function (e) {
            e.preventDefault();
            onFinish(obj, context);
        });
    };
    var leaveAStepCallback = function (obj, context) {
        return validateSteps(context.fromStep, context.toStep);
        // return false to stay on step and true to continue navigation
    };
    var onFinish = function (obj, context) {
        if (validateAllSteps()) {
            $('.anchor').children("li").last().children("a").removeClass('wait').removeClass('selected').addClass('done').children('.stepNumber').addClass('animated tada');
            wizardForm.submit();
        }
    };
    var validateSteps = function (stepnumber, nextstep) {
        var isStepValid = false;


        if (numberOfSteps >= nextstep && nextstep > stepnumber) {

            // cache the form element selector
            if (wizardForm.valid()) { // validate the form
                wizardForm.validate().focusInvalid();
                for (var i = stepnumber; i <= nextstep; i++) {
                    $('.anchor').children("li:nth-child(" + i + ")").not("li:nth-child(" + nextstep + ")").children("a").removeClass('wait').addClass('done').children('.stepNumber').addClass('animated tada');
                }
                //focus the invalid fields
                animateBar(nextstep);
                isStepValid = true;
                return true;
            }
            ;
        } else if (nextstep < stepnumber) {
            for (i = nextstep; i <= stepnumber; i++) {
                $('.anchor').children("li:nth-child(" + i + ")").children("a").addClass('wait').children('.stepNumber').removeClass('animated tada');
            }

            animateBar(nextstep);
            return true;
        }
    };
    var validateAllSteps = function () {
        var isStepValid = true;
        // all step validation logic
        return isStepValid;
    };
    return {
        init: function () {
            initWizard();
            validateCheckRadio();
        }
    };
}();