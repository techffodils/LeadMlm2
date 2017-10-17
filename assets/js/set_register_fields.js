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
