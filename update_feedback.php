<?php
 //connect to database

    $mysql_host = "sql.mit.edu";
    $mysql_database = "harlin+db1";
    $mysql_user = "harlin";
    $mysql_password = "freshman";
	
    $con = mysql_connect($mysql_host,$mysql_user,$mysql_password);
    if (!$con)
    {
	    die('Could not connect:'.mysql_error());
    }
    mysql_select_db($mysql_database, $con) or die(mysql_error());

  if ($_POST){
    $choice = $_POST['choice'];
    $code = $_POST['code'];

        $slow = mysql_result(mysql_query("SELECT slow FROM feedback WHERE class_code='$code'"),0);
        $fast = mysql_result(mysql_query("SELECT fast FROM feedback WHERE class_code='$code'"),0);

	
	if ($choice == "fast")
        {
            mysql_query("UPDATE feedback SET fast=$fast + 1 WHERE class_code = '$code'");
        }
        else if ($choice == "slow"){
            mysql_query("UPDATE feedback SET slow=$slow + 1 WHERE class_code = '$code'");
        }
	
	echo "Your feedback has been received";
  }
    /*$slow_status = 'unchecked';
    $fast_status = 'unchecked';
//session_start(); // Shows we are using sessions 
//connect to database

	$mysql_host = "sql.mit.edu";
	$mysql_database = "harlin+db1";
	$mysql_user = "harlin";
	$mysql_password = "freshman";
	
$con = mysql_connect($mysql_host,$mysql_user,$mysql_password);
if (!$con)
{
	die('Could not connect:'.mysql_error());
}

//retreive information if the form is submitted
if(isset($_POST["alert_professor"]))
{
        $code = 'SH87D';
	//select database
	mysql_select_db($mysql_database, $con) or die(mysql_error());
        $slow = mysql_result(mysql_query("SELECT slow FROM feedback WHERE class_code='$code'"),0);
        $fast = mysql_result(mysql_query("SELECT fast FROM feedback WHERE class_code='$code'"),0);
        $selected_radio = $_POST["feedback"];
        if ($selected_radio == "fast")
        {
            mysql_query("UPDATE feedback SET fast=$fast + 1 WHERE class_code = '$code'");
        }
        else if ($selected_radio == "slow"){
            mysql_query("UPDATE feedback SET slow=$slow + 1 WHERE class_code = '$code'");
        }

        echo "Your feedback has been received";
}	*/
?>