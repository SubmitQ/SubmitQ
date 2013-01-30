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
header('Location: profile.php');
}

elseif (isset($_SESSION['Email']) && $_SESSION['UserType'] == "P") {
header('Location: profile.php');
}

elseif (isset($_SESSION['Email']) && $_SESSION['UserType'] == "T") {
header('Location: profile.php');
}

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Welcome to SubmitQ</title>
<!--C:\wamp\www\submitq\submitq\bootstrap\css-->
	<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="profile_s.css" />
    <link rel="stylesheet" type="text/css" href="index.css" />
    
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="jquery.livequery.js"></script>
<script src="bootstrap\js\bootstrap.min.js"></script>
<script type="text/javascript">
		
		$(document).ready(function(){
			

		$('#submit_login').ajaxStop(function(){
			$(this).removeClass('loading disabled');
		})
		
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
				$('#error_message').hide().html('Email cannot be left blank').fadeIn('slow');
			}
			else if (password == ''){
				$('#error_message').hide().html('Password cannot be left blank').fadeIn('slow');
			}
			else{
				$(this).addClass('loading disabled');
				$.ajax({
					type: "POST",
					url: "process_login.php",
					data: dataString,
					success: function(html){
						if (html == "wrong"){
							$('#error_message').hide().html('Email and password do not match. Please try again').fadeIn('slow');
						}
						else {
							$('body').html(html);
						}
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
	#info{overflow: hidden;}
a.head:hover{text-decoration: none; color:#0088cc; }
</style>
<div id="wrapper">
	<div class = "row-fluid" id="header">
		<div class="span12" id="headbar">
			<div class="row-fluid">
			<div class="span4 offset1"><h1><a class="head" href="index.php" style="color: #C8C8C8;">SubmitQ</a></h1>
				<h3>Just Ask. That Simple.</h3>
			</div>
			<div id="register" class="span4 offset3">
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
<div class="container-fluid" id="container">
	
	<div class="row-fluid">
	<div id= "info" class="span7 offset1">
		<img src="http://www.freeimageslive.co.uk/files/images006/question_key.jpg"/ style="clear:both">
	</div>
	<div  id= "right-col" class="span4">
				<div id="login">
			<h2>Login</h2></br>
	
			<form action="" method="POST">

				<table>
				<tr><td>Email: </td><td><input type="text" id="inputEmail" name = "email"></td></tr>
				<tr><td>Password: &nbsp </td><td> <input type="password" id="inputPassword" name = "password"></td></tr>
				<tr><td><input type="checkbox" name="setcookie" id="setcookie" value="setcookie"> &nbsp;Stay logged in</td>
				<td align="right"><button type="submit" name="submit" id="submit_login" class="btn btn-primary pull-right">Login</button></td></tr>
				</table>
				<p><a href="forgot_password.php">Forgot Password?</a></p>
			<br /><div id="error_message" class="alert alert-error" style="display:none;"></div>
		
			</form>
		</div>

	</div>
	</div>
</div>

<div id="push"></div>
</div>        
<?php include("footer.php");?>
</body>

</HTML>
