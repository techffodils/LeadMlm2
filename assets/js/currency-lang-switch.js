function switchCurrency(code) {

    var LOG_USER_TYPE = $('#LOG_USER_TYPE').val();
    LOG_USER_TYPE =(LOG_USER_TYPE == 'employee') ? 'admin' : LOG_USER_TYPE;

    $.ajax({
                type: 'POST',
                url: LOG_USER_TYPE + '/base_controller/changeCurrencySettings',
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

   var LOG_USER_TYPE = $('#LOG_USER_TYPE').val();
    LOG_USER_TYPE =(LOG_USER_TYPE == 'employee') ? 'admin' : LOG_USER_TYPE;


    $.ajax({
                type: 'POST',
                url: LOG_USER_TYPE + '/base_controller/changeLanguageSettings',
                data: {'lang_code':lang_code},

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

