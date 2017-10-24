$.validator.addMethod("validUsername", function () {
        var isSuccess = false;
        $.ajax({url: "register/validate_sponsor",
            data: {username: $("#username").val()},
            async: false,
            success:
                    function (msg) {
                        isSuccess = msg === "yes" ? true : false
                    }
        });
        return isSuccess;
    }, "Sorry, Invalid Username");

    var validate_add_pin = function () {
        var form = $('#allocate_pin');
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
                username: {
                    validUsername: true,
                    required: true,
                    minlength: 3
                },
                pin_amount: {
                    required: true,
                    number: true,
                    min: 1
                },
                pin_count: {
                    required: true,
                    digits: true,
                    min: 1
                },
                expiry_date: {
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

    function cancel_request(id) {
        var are_you_sure = 'Are you sure?';
        var text = "There is no Undo";
        var confirm = "Yes, Delete it!";
        var cancel = "No, Cancel pls!";
        var canceled = "Cancelled";
        var cancel_msg = "Your Request is safe :)";
        swal({
            title: are_you_sure,
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: confirm,
            cancelButtonText: cancel,
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                document.location.href = 'admin/epin/epin_management/cancel/' + id;
            } else {
                swal(canceled, cancel_msg, "error");
            }
        });

        e.preventDefault();
    }

    function confirm_request(id) {
        var error_msg = 'This Field Is Required';
        var are_you_sure = 'Are you sure?';
        var text = "There is no Undo";
        var confirm = "Yes, Confirm it!";
        var cancel = "No, Cancel pls!";
        var canceled = "Cancelled";
        var cancel_msg = "Your Request is safe :)";
        var field = "#expiry_date_" + id;
        var error_span = "#expiry_error_" + id;
        if ($(field).val()) {
            $(error_span).html("");
            swal({
                title: are_you_sure,
                text: text,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: confirm,
                cancelButtonText: cancel,
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    document.location.href = 'admin/epin/epin_management/confirm/' + id + '/' + $(field).val();
                } else {
                    swal(canceled, cancel_msg, "error");
                }
            });

            e.preventDefault();
        } else {
            $(error_span).html(error_msg);
        }
    }