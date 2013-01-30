<?php

$mysql_host = "sql.mit.edu";
$mysql_database = "harlin+db1";
$mysql_user = "harlin";
$mysql_password = "freshman";
//connect to database
$con = mysql_connect($mysql_host,$mysql_user,$mysql_password);
if (!$con)
{
	die('Could not connect:'.mysql_error());
}

//retreive information if the form is submitted
if($_POST)
{
	//select database
	mysql_select_db($mysql_database,$con) or die(mysql_error());

	$email = $_POST["email"];
	$current_pw = md5($_POST["current_pw"]);
	$new_pw = md5($_POST["new_pw"]);
	
	//validate username and current password
	$validate = "SELECT COUNT(*) FROM all_users WHERE email='$email' and password_hash='$current_pw'";
	if(mysql_result((mysql_query($validate, $con)),0)==1)
	{
		//update the database
		$update = "UPDATE all_users SET password_hash ='$new_pw' WHERE email='$email' and password_hash= '$current_pw'";
		if(mysql_query($update, $con))
		{
			echo "Your password has been changed succesfully. <br /><br /><a href='profile.php'>Return to Profile</a>";
                        
		}
		else
		{
			echo "An error has occurred: ".mysql_error();
		}
	}
	else
	{
		echo "wrong";
	}	
}
?>