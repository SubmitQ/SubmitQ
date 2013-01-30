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
	$id = $_POST["id"];
	
	//validate phone number
	$validate = "SELECT COUNT(*) FROM all_users WHERE email='$email' and id='$id'";
	if (mysql_result((mysql_query($validate, $con)),0)==1)
	{
		//give a new password
	function generate_random_string($name_length=10) 
	{
            $alpha_numeric= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            return substr(str_shuffle($alpha_numeric), 0, $name_length);
	}
		$new_pw = generate_random_string(10);
		$new_pw_copy = md5($new_pw);
		$first_name = mysql_result(mysql_query("SELECT first_name FROM all_users WHERE email='$email'", $con), 0);
		$last_name = mysql_result(mysql_query("SELECT last_name FROM all_users WHERE email='$email'", $con), 0);
		$name = $first_name . " " . $last_name;
		//update the database
		$update = "UPDATE all_users SET password_hash = '$new_pw_copy' WHERE email='$email' and id= '$id'";
		if(mysql_query($update, $con))
		{
			$to = $email;
			$subject = "Your SubmitQ password has been reset";
			//$message = "Dear $name, \n\nYou have requested for your password to be reset. Your new password is $new_pw\nAfter you login with your new password, you may change your password from your profile.";
			$message = "
<html>
<head>
</head>
<body>
Dear $name,
<br /><br />You have requested for your password to be reset. <br /><br />Your new password is $new_pw
<br /><br />After you <a href='http://harlin.scripts.mit.edu/submitq'>login</a> with your new password, you may change your password from your profile page.
<br /><br />Thank you,
<br />The SubmitQ Team
</body>
</html>
";
			$from = "SubmitQ";
			// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From:" . $from;
			mail($to,$subject,$message,$headers);
			echo "An email has been sent to $email with your new password. <br /><br /><a href='index.php'>Login</a>";
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