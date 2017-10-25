$(document).ready(function () {
    var field_type = $('#field_type').val();
    var data_types = $('#data_types').val();

    if (field_type == "radio") {
        $("#radio_extras").show();
    }

    if (field_type == "select_box") {
        $("#selectbox_extras").show();
    }

    if (data_types == "double" || data_types == "text") {
        $("#max_size_div").hide();
    }
});

$('#field_type').change(function () {
    $("#radio_extras").hide();
    $("#selectbox_extras").hide();
    var type = $(this).val();

    if (type == "radio") {
        $("#radio_extras").show();
    }

    if (type == "select_box") {
        $("#selectbox_extras").show();
    }
});

$('#data_types').change(function () {
    var type = $(this).val();
    $("#max_size_div").show();
    if (type == "double" || type == "text") {
        $("#max_size_div").hide();
    }
});


function edit_field(id)
{
    swal({
        title: "Are you sure?",
        text: "New change applicable only new registrations",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Edit it!",
        cancelButtonText: "No, Cancel pls!",
        closeOnConfirm: false,
        closeOnCancel: false
    },
    function (isConfirm) {
        if (isConfirm) {
            document.location.href = 'admin/configuration/set_register_fields/edit/' + id;
        } else {
            swal("Cancelled", "Your Field is safe :)", "error");
        }
    });

    e.preventDefault();
}

function activate_field(id)
{
    swal({
        title: "Are you sure?",
        text: "New change applicable only new registrations",
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
            document.location.href = 'admin/configuration/set_register_fields/activate/' + id;
        } else {
            swal("Cancelled", "Your Field is safe :)", "error");
        }
    });

    e.preventDefault();
}


function inactivate_field(id)
{
    swal({
        title: "Are you sure?",
        text: "New change applicable only new registrations",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Inactivate it!",
        cancelButtonText: "No, Cancel pls!",
        closeOnConfirm: false,
        closeOnCancel: false
    },
    function (isConfirm) {
        if (isConfirm) {
            document.location.href = 'admin/configuration/set_register_fields/inactivate/' + id;
        } else {
            swal("Cancelled", "Your Field is safe :)", "error");
        }
    });

    e.preventDefault();
}


function delete_field(id)
{
    swal({
        title: "Are you sure?",
        text: "New change applicable only new registrations",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Delete it!",
        cancelButtonText: "No, Cancel pls!",
        closeOnConfirm: false,
        closeOnCancel: false
    },
    function (isConfirm) {
        if (isConfirm) {
            document.location.href = 'admin/configuration/set_register_fields/delete/' + id;
        } else {
            swal("Cancelled", "Your Field is safe :)", "error");
        }
    });

    e.preventDefault();
}



var validate_add_field = function () {
        var form = $('#add_field_form');
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
                    error.insertAfter(element)// for other inputs, just perform default behavior
                }
            },
            ignore: ':hidden',
            rules: {
                field_name: {
                    required: true,
                    minlength: 3
                },
                required_status: {
                    required: true
                },
                register_step: {
                    required: true
                },
                order: {
                    required: true
                },
                unique_status: {
                    required: true
                },
                data_types: {
                    required: true
                },
                data_type_max_size: {
                    required: true
                },
                field_type: {
                    required: true
                },
            },
            messages: {
                field_name: "Please enter Field Name"
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
