/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var MailValidation = function () {

    var runRegisterValidator = function () {
        var form3 = $('#email_settings');
        var errorHandler3 = $('.errorHandler', form3);
        form3.validate({
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
            rules: {
                smtp_port: {
                    minlength: 2,
                    required: true
                },
                email_engine: {
                    minlength: 2,
                    required: true
                },
                smtp_username: {
                    required: true
                },
                host_name: {
                    required: true
                },
                smtp_password: {
                    minlength: 6,
                    required: true
                }

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
                errorHandler3.hide();
                form3.submit();
            },
            invalidHandler: function (event, validator) {//display error alert on form submit
                errorHandler3.show();
            }
        });
    };

    return {
        //main function to initiate template pages
        init: function () {
            runRegisterValidator();

        }
    };
}();
