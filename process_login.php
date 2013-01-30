<?php
session_start(); // Shows we are using sessions 
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
if($_POST)
{
	//select database
	mysql_select_db($mysql_database,$con) or die(mysql_error());

	$email = $_POST["email"];
	$original_password = $_POST["password"];
	$password = md5($original_password);
	$check = $_POST['setcookie'];
	
	//validate the password
	$validate = "SELECT COUNT(*) FROM all_users WHERE email='$email' and password_hash='$password'";
	if (mysql_result((mysql_query($validate, $con)),0)) {
					
		$first_name = mysql_result(mysql_query("SELECT first_name FROM all_users WHERE email='$email'"),0);
		$last_name = mysql_result(mysql_query("SELECT last_name FROM all_users WHERE email='$email'"),0);
		$type = mysql_result(mysql_query("SELECT type FROM all_users WHERE email='$email'"),0);
		if($check == 1) { 
			// Check to see if the 'setcookie' box was ticked to remember the user 
			setcookie("User[email]", $email, time() + 3600*24*14); // Sets the cookie username 
			setcookie("User[password]", $password, time() + 3600*24*14); // Sets the cookie password 
		}
		else if ($check == 0) { 
			// Check to see if the 'setcookie' box was ticked to remember the user 
			setcookie("User[email]", $email, time() - 3600*24*14); // Sets the cookie username 
			setcookie("User[password]", $password, time() - 3600*24*14); // Sets the cookie password 
		} 
		$_SESSION['First_name'] = $first_name;
		$_SESSION['Last_name'] = $last_name;
		$_SESSION['Email'] = $email;
		$_SESSION['UserType'] = $type;
		if ($type=='S')
		{
			echo '<script>location.href="profile.php";</script>' ;
		}
		elseif ($type=='P')
		{
			echo '<script>location.href="profile.php";</script>' ;
		}
		elseif ($type=='T')
		{
			echo '<script>location.href="profile.php";</script>' ;		
		}
	}

	else
	{
		echo "wrong";
	}
	
}
?>