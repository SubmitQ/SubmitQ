<?php

	$mysql_host = "sql.mit.edu";
	$mysql_database = "harlin+db1";
	$mysql_user = "harlin";
	$mysql_password = "freshman";
//connect to database
$db1 = mysql_connect($mysql_host,$mysql_user,$mysql_password);
if (!$db1)
{
	die('Could not connect:'.mysql_error());
}

//retreive information if the form is submitted
if($_POST)
{
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$email = $_POST["email"];
	$password_hash = md5($_POST["password"]);
	$id = $_POST["id"];
	$type = $_POST["type"];

	//select database
	mysql_select_db($mysql_database, $db1);
	
	//verify if the username is unique
	$verify= "SELECT COUNT(*) FROM all_users WHERE email = '$email'";
	if (mysql_result(mysql_query($verify, $db1),0)==0)
		{
		//insert rows to table users
		$insert= "INSERT INTO all_users (first_name, last_name, email, password_hash, id, type)
			VALUES ('$first_name', '$last_name', '$email', '$password_hash', '$id', '$type')";	

		if (mysql_query($insert, $db1))
		{
			echo "<font size='4'><strong>Registration completed</strong></font>";
			echo "<font size='4'><br /><br />Welcome to SubmitQ, $first_name $last_name! You will be able to start adding classes, asking, and answering questions right after you login.";
			echo "<br /><br /><font size='4'><a href='index.php'>Login</a></font>";
		}

		else
		{
			die('Could not insert: '.mysql_error());
		}
		}
	else 
	{
		die("This email address is already in use. Try again.".mysql_error());
	}
}

?>