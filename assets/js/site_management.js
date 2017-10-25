/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var SiteManagement = function () {

    var runRegisterValidator = function () {
        var form3 = $('#update_siteinfo_form');
        var errorHandler3 = $('.errorHandler', form3);
        form3.validate({
            errorElement: "span", // contain the error msg in a small tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if (element.attr("type") == "radio" || element.attr("type") == "checkbox") {// for chosen elements, need to insert the error after the chosen container
                    error.insertAfter($(element).closest('.input-group').children('div').children().last());
                } else if (element.hasClass("ckeditor")) {
                    error.insertAfter($(element).closest('.input-group'));
                } else {
                    error.insertAfter($(element).closest('.input-group'));// for other inputs, just perform default behavior
                }
            },
            rules: {
                company_name: {
                    required: true,
                },
                company_address: {
                    minlength: 2,
                    required: true
                },
                company_email: {
                    minlength: 2,
                    required: true
                },
                company_phone: {
                    minlength: 2,
                    required: true
                },
                company_logo: {
                    required: true
                },
                company_fav_icon: {
                    required: true
                },

            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');// display OK icon
                $(element).closest('.input-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.input-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                $(element).closest('.input-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
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