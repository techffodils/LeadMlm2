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