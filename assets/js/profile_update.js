function setCover(id) {
    $.ajax({url: "admin/profile/reset_user_file",
        data: {id: id},
        async: false,
        success: function (msg) {
            window.location = window.location.href;
            //location.reload();
        }
    });
}

function setDefCover(id) {
    $.ajax({url: "admin/profile/set_def_cover",
        data: {id: id},
        async: false,
        success: function (msg) {
            window.location = window.location.href;
            //location.reload();
        }
    });
}

function setDefualtDp(id) {
    $.ajax({url: "admin/profile/set_def_dp",
        data: {id: id},
        async: false,
        success: function (msg) {
            window.location = window.location.href;
            //location.reload();
        }
    });
}


var ValidateUserProfile = function () {
    var validate_user_profile = function () {
        var form = $('#profile_update_form');
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
                    error.appendTo($(element).closest('.form-group'));
                }
            },
            ignore: ':hidden',
            rules: {
                first_name: {
                    required: true
                },
                phone_number: {
                    required: true,
                    number: true,
                    min: 1
                },
                dob: {
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

    return {
        init: function () {
            validate_user_profile();
        }
    };
}();

