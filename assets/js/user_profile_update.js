function setCover(id) {
        $.ajax({url: "user/profile/reset_user_file",
            data: {id: id},
            async: false,
            success: function (msg) {
                location.reload();
            }
        });
    }

    function setDefCover(id) {
        $.ajax({url: "user/profile/set_def_cover",
            data: {id: id},
            async: false,
            success: function (msg) {
                location.reload();
            }
        });
    }

    function setDefualtDp(id) {
        $.ajax({url: "user/profile/set_def_dp",
            data: {id: id},
            async: false,
            success: function (msg) {
                location.reload();
            }
        });
    }