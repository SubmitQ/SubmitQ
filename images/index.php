<?php

// Inialize session
session_start();

if (isset($_COOKIE['User'])){
	
	$mysql_host = "sql.mit.edu";
	$mysql_database = "harlin+db1";
	$mysql_user = "harlin";
	$mysql_password = "freshman";

	$email = $_COOKIE['User']['email'];
	$password = $_COOKIE['User']['password'];
	$db1 = mysql_connect($mysql_host, $mysql_user, $mysql_password);
	mysql_select_db($mysql_database,$db1);

	$validate = "SELECT COUNT(*) FROM all_users WHERE email='$email' and password_hash='$password'";
	if (mysql_result((mysql_query($validate, $db1)),0)) {
					
		$first_name = mysql_result(mysql_query("SELECT first_name FROM all_users WHERE email='$email'"),0);
		$last_name = mysql_result(mysql_query("SELECT last_name FROM all_users WHERE email='$email'"),0);
		$type = mysql_result(mysql_query("SELECT type FROM all_users WHERE email='$email'"),0);
		$_SESSION['Email'] = $email;
		$_SESSION['UserType'] = $type;
		$_SESSION['First_name'] = $first_name;
		$_SESSION['Last_name'] = $last_name;
	}
}

// Check, if user is already login, then jump to secured page
if (isset($_SESSION['Email']) && $_SESSION['UserType'] == "S") {
header('Location: student_profile.php');
}

elseif (isset($_SESSION['Email']) && $_SESSION['UserType'] == "P") {
header('Location: professor_profile.php');
}

elseif (isset($_SESSION['Email']) && $_SESSION['UserType'] == "T") {
header('Location: ta_profile.php');
}

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Welcome to SubmitQ</title>
<!--C:\wamp\www\submitq\submitq\bootstrap\css-->
<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="index.css">
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="bootstrap\js\bootstrap.min.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
		$('#submit_login').click(function(){
			var email = jQuery.trim($('#inputEmail').val());
			var password = jQuery.trim($('#inputPassword').val());
			if ($("#setcookie").prop('checked')){
				var setcookie = 1;
			}
			else {
				var setcookie = 0;
			}
			var dataString = 'email=' + email + '&password=' + password + '&setcookie=' + setcookie;
			if (email == ''){
				$('#error_message').html('<font color="red">Email cannot be left blank</font>');
			}
			else if (password == ''){
				$('#error_message').html('<font color="red">Password cannot be left blank</font>');
			}
			else{
				$.ajax({
					type: "POST",
					url: "process_login.php",
					data: dataString,
					success: function(html){
						$('#error_message').html(html);
					}
				
				})
			}
			return false;
		})
	})
</script>	

</head>
<body>
<style>
	
</style>
<div id="wrapper">
	<div class = "row-fluid" id="header" class="span12">
		<div class="span12" id="headbar">
			<div class="row-fluid">
			<div class="span4 offset1" id="SubmitQ"><h1>SubmitQ</h1>
				<h3>Just Ask. That Simple.</h3>
			</div>
			<div class="span3"></div>
			<div id="register" class="span4">
				<h3>Don't have an account?</h3>
				<strong>I am a...</strong>
				<span class="btn-group">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					Select One...
					<span class="caret"></span>
					</a>
					 <ul class="dropdown-menu">

					<li><a href="student_registration.php"><div class="suckers">Student</div></a></li>
					<li><a href="professor_registration.php"><div class="suckers">Professor</div></a></li>
					<li><a href="ta_registration.php"><div class="suckers">TA</div></a></li>
					</ul>
				</span>	
			</div>			
					
		</div>
		
			<!--<div class="span4 offset1" id="caption"><h2>Just Ask. That Simple.</h2></div>-->

		</div>
	</div>
<div class="container-fluid">

	
	<div class="row-fluid" style="height: 20px"></div>
	
	<div class="row-fluid">
	<div id= "info" class="span8">
		
	</div>
	<div  id= "right-col" class="span4">
				<div id="login">
			<h2>Login</h2></br>
	
			<form action="" method="POST">

				<table>
				<tr><td>Email: </td><td><input type="text" id="inputEmail" name = "email"></td><td></td></tr>
				<tr><td>Password: </td><td> <input type="password" id="inputPassword" name = "password"><td></td></tr>
				<tr><td colspan="2"><input type="checkbox" name="setcookie" id="setcookie" value="setcookie"> &nbsp;Stay logged in</td>
				<td align="right"><button type="submit" name="submit" id="submit_login" class="btn">Sign in</button></td></tr>
				<tr><td><a href="forgot_password.php">Forgot Password?</a></td></tr>
				</table>

			<br/><div id="error_message"></div>
		
			</form>
		</div>

	</div>
	</div>
</div>

      <div id="push"></div>
</div>        
	<div class="row-fluid">
		<div id="footer" class="span12 offset1">
			<a href="about.php">About Us</a> | <a href="faqs.php">Frequently Asked Questions</a> | <a href="credits.php">Credits</a>
			<br />Copyright@ Brocode Inc. 2013. All rights reserved.
		</div>
	</div>
</body>

</HTML>
