/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$.validator.addMethod("validUsername", function () {
    var isSuccess = false;
    $.ajax({url: "admin/employee/username_exits",
        data: {username: $("#user_name").val()},
        async: false,
        success:
                function (msg) {
                    isSuccess = msg === "yes" ? true : false
                }
    });
    return isSuccess;
}, "Sorry, Username Not Available");
var EnrollEmployee = function () {

    var runRegisterValidator = function () {
        var form3 = $('#employee_enroll');
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
                    error.insertAfter($(element).closest('.input-group')); // for other inputs, just perform default behavior
                }
            },
            rules: {
                user_name: {
                    validUsername: true,
                },
                firstname: {
                    minlength: 2,
                    required: true
                },
                address: {
                    minlength: 2,
                    required: true
                },
                country: {
                    minlength: 2,
                    required: true
                },
                gender: {
                    required: true
                },
                email: {
                    required: true
                },
                password: {
                    minlength: 6,
                    required: true
                },
                password_again: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                zipcode: {
                    required: true,
                    number: true
                },
                day: {
                    required: true,
                },
                month: {
                    required: true,
                },
                year: {
                    required: true,
                },
                phone: {
                    required: true
                }

            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid'); // display OK icon
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
function activate_employee(id)
{
    var title = "Are you sure?";
    var msg = "New change applicable only new registrations"
    swal({
        title: title,
        text: msg,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Activate it!",
        cancelButtonText: "No, Cancel pls!",
        closeOnConfirm: false,
        closeOnCancel: false
    },
            function (isConfirm) {
                if (isConfirm) {
                    document.location.href = 'admin/employee/activate_employee/' + id;
                } else {
                    swal("Cancelled", "Your Product is safe :)", "error");
                }
            });
    e.preventDefault();
}

$.validator.addMethod("validEmployeeUsername", function () {
    var isSuccess = false;
    $.ajax({url: "admin/employee/check_validate_employee",
        data: {username: $("#user_name").val()},
        async: false,
        success:
                function (msg) {
                    alert(msg);
                    isSuccess = msg === "yes" ? true : false
                }
    });
    return isSuccess;
}, "Sorry, Username Not Available");

var ValiadateEmployee = function () {

    var runValidation = function () {
        var form3 = $('#employee_enroll');
        var errorHandler3 = $('.errorHandler', form3);
        form3.validate({
            errorElement: "span", // contain the error msg in a small tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if (element.attr("type") == "radio" || element.attr("type") == "checkbox") {// for chosen elements, need to insert the error after the chosen container
                    error.insertAfter($(element).closest('.input-group').children('div').children().last());
                } else if (element.hasClass("ckeditor")) {
                    error.insertAfter($(element).closest('.form-group'));
                } else {
                    error.insertAfter($(element).closest('.form-group')); // for other inputs, just perform default behavior
                }
            },
            rules: {
                user_name: {
                    required: true,
                },

            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid'); // display OK icon
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
        init: function () {
            runValidation();
        }
    }
}();