<?php
if (isset($_POST['email'])){
    	$mysql_host = "sql.mit.edu";
	$mysql_database = "harlin+db1";
	$mysql_user = "harlin";
	$mysql_password = "freshman";
        
    $email = $_POST['email'];
    
    $db1 = mysql_connect($mysql_host, $mysql_user, $mysql_password);
    mysql_select_db($mysql_database, $db1);
    $validate ="SELECT COUNT(*) FROM all_users WHERE email='$email'";

    if(mysql_result((mysql_query($validate, $db1)),0)){
        echo '<font color="red">&nbsp;&nbsp;Taken</font>';
    }
    else {
        echo 'OK';
    }
}
?>