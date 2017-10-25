function toggle_password0(target){
    var d = document;
    var tag = d.getElementById(target);
    var tag2 = d.getElementById("showhide0");
    
    if (tag2.innerHTML == 'Show'){
        tag.setAttribute('type', 'text');   
        tag2.innerHTML = 'Hide';

    } else {
        tag.setAttribute('type', 'password');   
        tag2.innerHTML = 'Show';
    }
}

function toggle_password1(target){
    var d = document;
    var tag = d.getElementById(target);
    var tag2 = d.getElementById("showhide1");
    
    if (tag2.innerHTML == 'Show'){
        tag.setAttribute('type', 'text');   
        tag2.innerHTML = 'Hide';

    } else {
        tag.setAttribute('type', 'password');   
        tag2.innerHTML = 'Show';
    }
}
function toggle_password2(target){
    var d = document;
    var tag = d.getElementById(target);
    var tag2 = d.getElementById("showhide2");
    
    if (tag2.innerHTML == 'Show'){
        tag.setAttribute('type', 'text');   
        tag2.innerHTML = 'Hide';

    } else {
        tag.setAttribute('type', 'password');   
        tag2.innerHTML = 'Show';
    }
}

function toggle_password3(target){
    var d = document;
    var tag = d.getElementById(target);
    var tag2 = d.getElementById("showhide3");
    
    if (tag2.innerHTML == 'Show'){
        tag.setAttribute('type', 'text');   
        tag2.innerHTML = 'Hide';

    } else {
        tag.setAttribute('type', 'password');   
        tag2.innerHTML = 'Show';
    }
}

function toggle_password4(target){
    var d = document;
    var tag = d.getElementById(target);
    var tag2 = d.getElementById("showhide4");
    
    if (tag2.innerHTML == 'Show'){
        tag.setAttribute('type', 'text');   
        tag2.innerHTML = 'Hide';

    } else {
        tag.setAttribute('type', 'password');   
        tag2.innerHTML = 'Show';
    }
}
function toggle_password5(target){
    var d = document;
    var tag = d.getElementById(target);
    var tag2 = d.getElementById("showhide5");
    
    if (tag2.innerHTML == 'Show'){
        tag.setAttribute('type', 'text');   
        tag2.innerHTML = 'Hide';

    } else {
        tag.setAttribute('type', 'password');   
        tag2.innerHTML = 'Show';
    }
}
//================================================================//

    function changepassword() {
        
         var username = $('#pass_user_name').val();
         var pass_password = $('#pass_password').val();
         var pass_re_enter_password = $('#pass_re_enter_password').val();
         
       $.blockUI({
        message: '<i class="fa fa-spinner fa-spin"></i> Please Wait...'
    });

    $.ajax({
       
       
        url: "admin/member/update_password",
        data: {username: username, pass_password: pass_password,pass_re_enter_password:pass_re_enter_password},
        success: function (result) {
            if (result == "yes") {
                
                    var msg = "Sucessfully Changed Password";
                    var flag = "success";
                    var title = "Success";
                    show_notification(flag, title, msg);
                    
                    document.getElementById('pass_user_name').value="";
                    document.getElementById('pass_re_enter_password').value="";
                    document.getElementById('pass_password').value="";
                

            } else {
                var flag = "error";
                var msg = result;
                var title = "Failed";
                show_notification(flag, title, msg);
            }
        }
    });
        
    }
    function changeusername() {
        
         var uname_user_name = $('#uname_user_name').val();
         var uname_new_username = $('#uname_new_username').val();
         var uname_re_entry_username = $('#uname_re_entry_username').val();
         
       $.blockUI({
        message: '<i class="fa fa-spinner fa-spin"></i> Please Wait...'
    });

    $.ajax({
       
       
        url: "admin/member/update_username",
        data: {uname_user_name: uname_user_name, uname_new_username: uname_new_username,uname_re_entry_username:uname_re_entry_username},
        success: function (result) {
            if (result == "yes") {
                
                    var msg = "Sucessfully Changed User Name";
                    var flag = "success";
                    var title = "Success";
                    show_notification(flag, title, msg);
                    
                    document.getElementById('uname_user_name').value="";
                    document.getElementById('uname_new_username').value="";
                    document.getElementById('uname_re_entry_username').value="";
                

            } else {
                var flag = "error";
                var msg = result;
                var title = "Failed";
                show_notification(flag, title, msg);
            }
        }
    });
        
    }
    function changeact() {        
         var act_user_name = $('#act_user_name').val();         
       $.blockUI({
        message: '<i class="fa fa-spinner fa-spin"></i> Please Wait...'
    });

    $.ajax({      
       
        url: "admin/member/update_act",
        data: {act_user_name: act_user_name},
        success: function (result) {
            if (result == "yes") {                
                    var msg = "Sucessfully Changed User Status";
                    var flag = "success";
                    var title = "Success";
                    show_notification(flag, title, msg);                    
                    document.getElementById('act_user_name').value="";                

            } else {
                var flag = "error";
                var msg = result;
                var title = "Failed";
                show_notification(flag, title, msg);
            }
        }
    });
        
    }
    function changedct() {  
       
         var act_user_name = $('#act_user_name').val();         
       $.blockUI({
        message: '<i class="fa fa-spinner fa-spin"></i> Please Wait...'
    });

    $.ajax({      
       
        url: "admin/member/update_dct",
        data: {act_user_name: act_user_name},
        success: function (result) {
            if (result == "yes") {                
                    var msg = "Sucessfully Changed User Status";
                    var flag = "success";
                    var title = "Success";
                    show_notification(flag, title, msg);                    
                    document.getElementById('act_user_name').value="";                

            } else {
                var flag = "error";
                var msg = result;
                var title = "Failed";
                show_notification(flag, title, msg);
            }
        }
    });
        
    }
    
    
    function changetransation() {
        
         var tran_user_name = $('#tran_user_name').val();
         var tran_pass_password = $('#tran_pass_password').val();
         var tran_pass_re_enter_password = $('#tran_pass_re_enter_password').val();
         
       $.blockUI({
        message: '<i class="fa fa-spinner fa-spin"></i> Please Wait...'
    });

    $.ajax({
       
       
        url: "admin/member/update_transation",
        data: {tran_user_name: tran_user_name, tran_pass_password: tran_pass_password,tran_pass_re_enter_password:tran_pass_re_enter_password},
        success: function (result) {
            if (result == "yes") {
                
                    var msg = "Sucessfully Changed Transation Password";
                    var flag = "success";
                    var title = "Success";
                    show_notification(flag, title, msg);
                    
                    document.getElementById('tran_user_name').value="";
                    document.getElementById('tran_pass_password').value="";
                    document.getElementById('tran_pass_re_enter_password').value="";
                

            } else {
                var flag = "error";
                var msg = result;
                var title = "Failed";
                show_notification(flag, title, msg);
            }
        }
    });
        
    }
    
    //========================= user side ============================//
    
    function changetransationuser() {
        
         var tran_current_password = $('#tran_current_password').val();
         var tran_pass_password = $('#tran_pass_password').val();
         var tran_pass_re_enter_password = $('#tran_pass_re_enter_password').val();
         
       $.blockUI({
        message: '<i class="fa fa-spinner fa-spin"></i> Please Wait...'
    });

    $.ajax({
       
       
        url: "user/member/update_transation",
        data: {tran_current_password: tran_current_password, tran_pass_password: tran_pass_password,tran_pass_re_enter_password:tran_pass_re_enter_password},
        success: function (result) {
            if (result == "yes") {
                
                    var msg = "Sucessfully Changed Transation Password";
                    var flag = "success";
                    var title = "Success";
                    show_notification(flag, title, msg);
                    
                    document.getElementById('tran_current_password').value="";
                    document.getElementById('tran_pass_password').value="";
                    document.getElementById('tran_pass_re_enter_password').value="";
                

            } else {
                var flag = "error";
                var msg = result;
                var title = "Failed";
                show_notification(flag, title, msg);
            }
        }
    });
        
    }
    
     function changeusernameuser() {
        
         var uname_current_username = $('#uname_current_username').val();
         var uname_new_username = $('#uname_new_username').val();
         var uname_re_entry_username = $('#uname_re_entry_username').val();
         
       $.blockUI({
        message: '<i class="fa fa-spinner fa-spin"></i> Please Wait...'
    });

    $.ajax({
       
       
        url: "user/member/update_username",
        data: {uname_current_username: uname_current_username, uname_new_username: uname_new_username,uname_re_entry_username:uname_re_entry_username},
        success: function (result) {
            if (result == "yes") {
                
                    var msg = "Sucessfully Changed User Name";
                    var flag = "success";
                    var title = "Success";
                    show_notification(flag, title, msg);
                    
                    document.getElementById('uname_current_username').value="";
                    document.getElementById('uname_new_username').value="";
                    document.getElementById('uname_re_entry_username').value="";
                

            } else {
                var flag = "error";
                var msg = result;
                var title = "Failed";
                show_notification(flag, title, msg);
            }
        }
    });
        
    }
    
     function changepassworduser() {
        
         var pass_current_password = $('#pass_current_password').val();
         var pass_password = $('#pass_password').val();
         var pass_re_enter_password = $('#pass_re_enter_password').val();
         
       $.blockUI({
        message: '<i class="fa fa-spinner fa-spin"></i> Please Wait...'
    });

    $.ajax({
       
       
        url: "user/member/update_password",
        data: {pass_current_password: pass_current_password, pass_password: pass_password,pass_re_enter_password:pass_re_enter_password},
        success: function (result) {
            if (result == "yes") {
                
                    var msg = "Sucessfully Changed Password";
                    var flag = "success";
                    var title = "Success";
                    show_notification(flag, title, msg);
                    
                    document.getElementById('pass_current_password').value="";
                    document.getElementById('pass_re_enter_password').value="";
                    document.getElementById('pass_password').value="";
                

            } else {
                var flag = "error";
                var msg = result;
                var title = "Failed";
                show_notification(flag, title, msg);
            }
        }
    });
        
    }
    
    function show_notification(status, title, msg) {
    $.unblockUI();
    var i = -1;
    var toastCount = 0;
    var $toastlast;
    var toastIndex = toastCount++;
    toastr.options = {
        closeButton: $('#closeButton').prop('checked'),
        debug: $('#debugInfo').prop('checked'),
        positionClass: $('#positionGroup input:radio:checked').val() || 'toast-top-right',
        onclick: null
    };

    $("#toastrOptions").text("Command: toastr["
            + status
            + "](\""
            + msg
            + (title ? "\", \"" + title : '')
            + "\")\n\ntoastr.options = "
            + JSON.stringify(toastr.options, null, 2)
            );

    var $toast = toastr[status](msg, title); // Wire up an event handler to a button in the toast, if it exists

}
    








