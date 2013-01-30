$(document).ready(function(){
    
    var valid1 = 0;
    var valid2 = 0;
    var valid3 = 0;
    var valid4 = 0;
    var valid5 = 0;
    var valid6 = 0;
    
    // validate first name
    $('#first_name').keyup(function(){
        valid1 = 0;
        $('#first_name_status').html('');
        var first_name = $('#first_name').val();
        if (first_name.length >= 1){
            $('#first_name_status').html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
            valid1 = 1;
        }
        checkFields(valid1, valid2, valid3, valid4, valid5, valid6);
    })
    
    // validate last name
    $('#last_name').keyup(function(){
        valid2 = 0;
        $('#last_name_status').html('');
        var last_name = $('#last_name').val();
        if (last_name.length >= 1){
            $('#last_name_status').html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
            valid2 = 1;
        }
        checkFields(valid1, valid2, valid3, valid4, valid5, valid6);
    })
    
    // validate email
    $('#email').keyup(function(){
        valid3 = 0;
        $('#email_status').html('');
        var email = $('#email').val();
        if (isValidEmailAddress(email)){
            $.ajax({
                type: "POST",
                url: "check_email.php",
                data: "email="+ email,
                success: function(msg){
                    $('#email_status').ajaxComplete(function(event, request, settings){
                        if (msg == 'OK'){
                            valid3 = 1;
                            $(this).html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                        }
                        else {
                            valid3 = 0;
                            $(this).html(msg);
                        }
                        checkFields(valid1, valid2, valid3, valid4, valid5, valid6);
                    })
                }
            })
        }
        else {
            $('#email_status').html('&nbsp;&nbsp;<font color="red">Invalid</font>');
        }

    })
    // validate password
    $('#password').keyup(function(){
        valid4 = 0;
        valid5 = 0;
        $('#password_status').html('');
        $('#confirm_password_status').html('');
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
        if (password.length >= 6){
           if (password != confirm_password) {
                $('#password_status').html('&nbsp;&nbsp;<font color="red"></font>');
                $('#confirm_password_status').html('');
            }
            else { // if passwords match
                $('#password_status').html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                $('#confirm_password_status').html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                valid4 = 1;
                valid5 = 1;
            }
        }
        else { // if password is too short
            $('#password_status').html('&nbsp;&nbsp;<font color="red">Too short</font>');
            $('#confirm_password_status').html('');
        }
        checkFields(valid1, valid2, valid3, valid4, valid5, valid6);
    })
    
    // validate confirm password
    $('#confirm_password').keyup(function(){
        valid4 = 0;
        valid5 = 0;
        $('#password_status').html('');
        $('#confirm_password_status').html('');
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
        if (confirm_password.length >= 6){
           if (password != confirm_password) {
                $('#confirm_password_status').html('&nbsp;&nbsp;<font color="red"></font>');
                $('#password_status').html('');
            }
            else {
                $('#password_status').html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                $('#confirm_password_status').html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                valid4 = 1;
                valid5 = 1;
            }
        }
        else {
            $('#confirm_password_status').html('&nbsp;&nbsp;<font color="red">Too short</font>');
            $('#password_status').html('');
        }
        checkFields(valid1, valid2, valid3, valid4, valid5, valid6);
    })
    
    // validate ID number
    $('#id').keyup(function(){
        valid6 = 0;
        var id = $('#id').val();
        if (isNumeric(id) && id.length == 9){
            $.ajax({
                type: "POST",
                url: "check_id.php",
                data: "id="+ id,
                success: function(msg){
                    $('#ta_id_status').ajaxComplete(function(event, request, settings){
                        if (msg == 'OK'){
                            valid6 = 1;
                            $(this).html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                        }
                        else {
                            valid6 = 0;
                            $(this).html(msg);
                        }
                        checkFields(valid1, valid2, valid3, valid4, valid5, valid6);
                    })
                }
            })
        }
        else {
            $('#ta_id_status').html('<font color="red">Invalid</font>');
        }
        checkFields(valid1, valid2, valid3, valid4, valid5, valid6);
    })
    
        // validate first name
    $('#first_name').change(function(){
        valid1 = 0;
        $('#first_name_status').html('');
        var first_name = $('#first_name').val();
        if (first_name.length >= 1){
            $('#first_name_status').html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
            valid1 = 1;
        }
        checkFields(valid1, valid2, valid3, valid4, valid5, valid6);
    })
    
    // validate last name
    $('#last_name').change(function(){
        valid2 = 0;
        $('#last_name_status').html('');
        var last_name = $('#last_name').val();
        if (last_name.length >= 1){
            $('#last_name_status').html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
            valid2 = 1;
        }
        checkFields(valid1, valid2, valid3, valid4, valid5, valid6);
    })
    
    // validate email
    $('#email').change(function(){
        valid3 = 0;
        $('#email_status').html('');
        var email = $('#email').val();
        if (isValidEmailAddress(email)){
            $.ajax({
                type: "POST",
                url: "check_email.php",
                data: "email="+ email,
                success: function(msg){
                    $('#email_status').ajaxComplete(function(event, request, settings){
                        if (msg == 'OK'){
                            valid3 = 1;
                            $(this).html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                        }
                        else {
                            valid3 = 0;
                            $(this).html(msg);
                        }
                        checkFields(valid1, valid2, valid3, valid4, valid5, valid6);
                    })
                }
            })
        }
        else {
            $('#email_status').html('&nbsp;&nbsp;<font color="red">Invalid</font>');
        }

    })
    // validate password
    $('#password').change(function(){
        valid4 = 0;
        valid5 = 0;
        $('#password_status').html('');
        $('#confirm_password_status').html('');
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
        if (password.length >= 6){
           if (password != confirm_password) {
                $('#password_status').html('&nbsp;&nbsp;<font color="red"></font>');
                $('#confirm_password_status').html('');
            }
            else { // if passwords match
                $('#password_status').html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                $('#confirm_password_status').html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                valid4 = 1;
                valid5 = 1;
            }
        }
        else { // if password is too short
            $('#password_status').html('&nbsp;&nbsp;<font color="red">Too short</font>');
            $('#confirm_password_status').html('');
        }
        checkFields(valid1, valid2, valid3, valid4, valid5, valid6);
    })
    
    // validate confirm password
    $('#confirm_password').change(function(){
        valid4 = 0;
        valid5 = 0;
        $('#password_status').html('');
        $('#confirm_password_status').html('');
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
        if (confirm_password.length >= 6){
           if (password != confirm_password) {
                $('#confirm_password_status').html('&nbsp;&nbsp;<font color="red"></font>');
                $('#password_status').html('');
            }
            else {
                $('#password_status').html('&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                $('#confirm_password_status').html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                valid4 = 1;
                valid5 = 1;
            }
        }
        else {
            $('#confirm_password_status').html('&nbsp;&nbsp;<font color="red">Too short</font>');
            $('#password_status').html('');
        }
        checkFields(valid1, valid2, valid3, valid4, valid5, valid6);
    })
    
    // validate ID number
    $('#id').change(function(){
        valid6 = 0;
        var id = $('#id').val();
        if (isNumeric(id) && id.length == 9){
            $.ajax({
                type: "POST",
                url: "check_id.php",
                data: "id="+ id,
                success: function(msg){
                    $('#ta_id_status').ajaxComplete(function(event, request, settings){
                        if (msg == 'OK'){
                            valid6 = 1;
                            $(this).html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                        }
                        else {
                            valid6 = 0;
                            $(this).html(msg);
                        }
                        checkFields(valid1, valid2, valid3, valid4, valid5, valid6);
                    })
                }
            })
        }
        else {
            $('#ta_id_status').html('&nbsp;&nbsp;<font color="red">Invalid</font>');
        }
        checkFields(valid1, valid2, valid3, valid4, valid5, valid6);
    })
})

// check if email is in correct format
function isValidEmailAddress(email){
    var re = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/; 
    if (re.test(email)){
        return true;
    }
    else {
        return false;
    }
}

function isNumeric(ID){
    var re = /^[0-9]+$/; 
    if (re.test(ID)){
        return true;
    }
    else {
        return false;
    }
}

function checkFields(valid1, valid2, valid3, valid4, valid5, valid6) {
    if (valid1 == 1 && valid2 == 1 && valid3 == 1 && valid4 == 1 && valid5 == 1 && valid6 == 1) {
        $("#register_ta").removeAttr('disabled'); //enable submit button
    }
    else {
        $("#register_ta").attr('disabled', 'disabled'); //disable submit button
    }
}