jQuery(document).ready(function() {

    var LOG_USER_TYPE = $('#LOG_USER_TYPE').val();
    LOG_USER_TYPE =(LOG_USER_TYPE == 'employee') ? 'admin' : LOG_USER_TYPE;

    $('.save_style').on('click', function() {

           // var espressoSetting ;
           
            if ($body.hasClass('layout-boxed')) {
              var esplayoutBoxed = 'layout-boxed';
            } else {
                var  esplayoutBoxed = null;
            };
            if ($body.hasClass('header-default')) {
                var  espheaderDefault = 'header-default';
            } else {
                var  espheaderDefault = 'header-fixed';
            };
            if ($body.hasClass('footer-fixed')) {
               var   espfooterDefault = 'footer-fixed';
            } else {
                var  espfooterDefault ='footer-default';
            };
           
            var person = {
                'layoutBoxed' : esplayoutBoxed,
                'headerDefault' : espheaderDefault,
                'footerDefault' : espfooterDefault,
                'skinClass' : $('#skin_color').attr('href')
            };

            var el = $('#style_selector_container');
            $.ajax({
                type: 'POST',
                url: LOG_USER_TYPE + '/home/changeThemeSettings',
                data: {result:JSON.stringify(person)},

                beforeSend: function() {

                    el.block({
                        overlayCSS: {
                            backgroundColor: '#000'
                        },
                        message: '<i class="fa fa-spinner fa-spin"></i>',
                        css: {
                            border: 'none',
                            color: '#fff',
                            background: 'none'
                        }
                    });
                },
                success: function(data) {
                    el.unblock();
                },
                error: function(xhr) { // if error occured
                    alert("Error occured.please try again");
                },
                complete: function() {
                    el.unblock();
                },
                dataType: 'json'
            });

        });

});

