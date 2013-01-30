<?php

    $mysql_host = "sql.mit.edu";
    $mysql_database = "harlin+db1";
    $mysql_user = "harlin";
    $mysql_password = "freshman";
        
    $code = $_POST['code'];
    
    $db1 = mysql_connect($mysql_host, $mysql_user, $mysql_password);
    mysql_select_db($mysql_database, $db1);
    
    $slow = mysql_result(mysql_query("SELECT slow FROM feedback WHERE class_code='$code'"),0);
    $fast = mysql_result(mysql_query("SELECT fast FROM feedback WHERE class_code='$code'"),0);
    
    if ($fast - $slow >= 5){
        echo "fast";
        mysql_query("UPDATE feedback SET fast=0 WHERE class_code = '$code'");
        mysql_query("UPDATE feedback SET slow=0 WHERE class_code = '$code'");
    }
    else if ($slow - $fast >= 5){
        echo "slow";
        mysql_query("UPDATE feedback SET fast=0 WHERE class_code = '$code'");
        mysql_query("UPDATE feedback SET slow=0 WHERE class_code = '$code'");
    }
    

?>