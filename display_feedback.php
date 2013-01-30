<?php

    $mysql_host = "sql.mit.edu";
    $mysql_database = "harlin+db1";
    $mysql_user = "harlin";
    $mysql_password = "freshman";
        
    $email = $_POST['email'];
    
    $db1 = mysql_connect($mysql_host, $mysql_user, $mysql_password);
    mysql_select_db($mysql_database, $db1);
    
    $code = 'SH87D';
    $slow = mysql_result(mysql_query("SELECT slow FROM feedback WHERE class_code='$code'"),0);
    $fast = mysql_result(mysql_query("SELECT fast FROM feedback WHERE class_code='$code'"),0);
    
    echo "<br />Too slow: " . $slow;
    echo "<br />Too fast: " . $fast;
    
    if ($fast - $slow > 5){
        echo "<br /><font color='red'>Professor, you are talking too fast!</font>";
    }
    else if ($slow - $fast > 5){
        echo "<br /><font color='blue'>Professor, you are talking too slow!</font>";
    }

?>