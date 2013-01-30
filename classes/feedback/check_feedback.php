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
    
    echo "<span class='span10 offset1'><h4>Too slow:  <span class='text-error'><strong>$slow</strong></span>";
    echo "&nbsp &nbsp &nbsp Too fast:  <span class='text-error'><strong>$fast</strong></span></h4></span>";

?>