function generate_backup()
    {
        $.blockUI({
            message: '<i class="fa fa-spinner fa-spin"></i> Please Wait...'
        });
                
        $.ajax({
            url: 'admin/backup/db_backup',
            success: function (response) {
                $.unblockUI();
                var res = $.parseJSON(response);
                if (res.response == 'yes') {
                    $('#sample-table-1 tr:first').after('<tr><td>' + res.download + '</td><td>' + res.done_by + '</td><td>' + res.date + '</td><td>' + res.file + '</td></tr>');
                    swal("Success!", "Backup Generated Successfully", "success");
                } else {
                    swal("Failed", "Backup Generation Failed", "error");
                }
            }
        });
    }