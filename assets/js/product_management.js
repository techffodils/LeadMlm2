function edit_prod(id)
{
    var title = "Are you sure?";
    var msg = "New change applicable only new registrations"
    swal({
        title: title,
        text: msg,
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
            document.location.href = 'admin/product/product_management/edit/' + id;
        } else {
            swal("Cancelled", "Your Product is safe :)", "error");
        }
    });

    e.preventDefault();
}

function activate_prod(id)
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
            document.location.href = 'admin/product/product_management/activate/' + id;
        } else {
            swal("Cancelled", "Your Product is safe :)", "error");
        }
    });

    e.preventDefault();
}

function inactivate_prod(id)
{
    var title = "Are you sure?";
    var msg = "New change applicable only new registrations"
    swal({
        title: title,
        text: msg,
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
            document.location.href = 'admin/product/product_management/inactivate/' + id;
        } else {
            swal("Cancelled", "Your Product is safe :)", "error");
        }
    });

    e.preventDefault();
}

function delete_prod(id)
{
    var title = "Are you sure?";
    var msg = "New change applicable only new registrations"
    swal({
        title: title,
        text: msg,
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
            document.location.href = 'admin/product/product_management/delete/' + id;
        } else {
            swal("Cancelled", "Your Product is safe :)", "error");
        }
    });

    e.preventDefault();
}





$('#more_upload').click(function (e) {
    $('#file_div').append('<div class="form-group"><label class="col-sm-3 control-label">Product Image</label><div class="fileupload fileupload-new col-sm-3" data-provides="fileupload"><div class="fileupload-new thumbnail"><img src="assets/images/products/our-products.png" alt=""></div><div class="fileupload-preview fileupload-exists thumbnail"></div><div class="user-edit-image-buttons"><span class="btn btn-azure btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture"></i> Change</span><input type="file" id="images" name="images[]"/></span><a href="#" class="btn fileupload-exists btn-red" data-dismiss="fileupload"><i class="fa fa-times"></i> Remove</a></div></div></div>');
});


function changeValue(input_field, value) {
    var field = '#product_delete_status_' + input_field;
    $(field).val(1);

    var field_div = '#file_div_' + input_field;
    $(field_div).hide();
}




var validate_product_management = function () {
    var form = $('#add_product_form');
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
            product_name: {
                required: true,
                minlength: 3
            },
            product_amount: {
                required: true
            },
            product_pv: {
                required: true
            },
            product_code: {
                required: true,
                minlength: 3
            },
            product_type: {
                required: true
            }
        },
        messages: {
            product_name: "Please enter Product Name"
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


                                        