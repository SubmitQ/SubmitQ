$(document).ready(function(){
    var valid1 = 0;
    var valid2 = 0;
    // validate current password
    $('#new_pw').keyup(function(){
        valid1 = 0;
        valid2 = 0;
        $('#new_pw_status').html('');
        $('#confirm_new_pw_status').html('');
        var new_pw = $('#new_pw').val();
        var confirm_new_pw = $('#confirm_new_pw').val();
        if (new_pw.length >= 6){
           if (new_pw != confirm_new_pw) {
                $('#new_pw_status').html('&nbsp;&nbsp;<font color="red">Passwords do not match</font>');
                $('#confirm_new_pw_status').html('');
            }
            else { // if passwords match
                $('#new_pw_status').html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                $('#confirm_new_pw_status').html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                valid1 = 1;
                valid2 = 1;
            }
        }
        else { // if password is too short
            $('#new_pw_status').html('&nbsp;&nbsp;<font color="red">Too short</font>');
            $('#confirm_new_pw_status').html('');
        }
        checkFields(valid1, valid2);
    })
    
    // validate confirm password
    $('#confirm_new_pw').keyup(function(){
        valid1 = 0;
        valid2 = 0;
        $('#new_pw_status').html('');
        $('#confirm_new_pw_status').html('');
        var new_pw = $('#new_pw').val();
        var confirm_new_pw = $('#confirm_new_pw').val();
        if (new_pw.length >= 6){
           if (new_pw != confirm_new_pw) {
                $('#confirm_new_pw_status').html('&nbsp;&nbsp;<font color="red">Passwords do not match</font>');
                $('#new_pw_status').html('');
            }
            else { // if passwords match
                $('#new_pw_status').html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                $('#confirm_new_pw_status').html('&nbsp;&nbsp;<img src="http://harlin.scripts.mit.edu/submitq/images/check.png" align="absmiddle">');
                valid1 = 1;
                valid2 = 1;
            }
        }
        else { // if password is too short
            $('#confirm_new_pw_status').html('&nbsp;&nbsp;<font color="red">Too short</font>');
            $('#new_pw_status').html('');
        }
        checkFields(valid1, valid2);
    })
    
    function checkFields(valid1, valid2) {
    if (valid1 == 1 && valid2 == 1) {
        $("#change_password").removeAttr('disabled'); //enable submit button
    }
    else {
        $("#change_password").attr('disabled', 'disabled'); //disable submit button
    }
}
})