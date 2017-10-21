function switchCurrency(code) {

    $.ajax({
                type: 'POST',
                url: 'admin/home/changeCurrencySettings',
                data: {'currency_code':code},

                beforeSend: function() {
                },
                success: function(data) {
                    location.reload();
                },
                error: function(xhr) { 
                    alert("Error occured.please try again");
                },
                complete: function() {
                },
                dataType: 'json'
    });

}

function switchLanguage(lang_code){


    $.ajax({
                type: 'POST',
                url: 'admin/home/changeLanguageSettings',
                data: {'lang_code':lang_code},

                beforeSend: function() {
                },
                success: function(data) {
                    
                    location.reload();
                     //$(location).attr('href', base_url+lang_code+'/admin/home');
                },
                error: function(xhr) { 
                    alert("Error occured.please try again");
                },
                complete: function() {
                },
                dataType: 'json'
    });


       
}

