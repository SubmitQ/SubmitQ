<?php
if (isset($_POST['id'])){
    $id = $_POST['id'];
    
    	$mysql_host = "sql.mit.edu";
	$mysql_database = "harlin+db1";
	$mysql_user = "harlin";
	$mysql_password = "freshman";
        
    $db1 = mysql_connect($mysql_host, $mysql_user, $mysql_password);
    mysql_select_db($mysql_database, $db1);
    $validate ="SELECT COUNT(*) FROM all_users WHERE id='$id'";

    if(mysql_result((mysql_query($validate, $db1)),0)){
        echo '&nbsp;&nbsp;<font color="red">Taken</font>';
    }
    else {
        echo 'OK';
    }
}
?>