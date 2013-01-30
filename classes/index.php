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
	

</head>
<body>
<script>
	.span4{background-color:red;}
</script>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span4">
		<!--Registration div and Login div-->
		
		
		</div>
		
		<div class="span8">
		<!--Explanation of the website-->
		</div>
		
	</div>
</div>


	<div class="row-fluid" id="background">
                <div class="row-fluid" id="header">
			<div class="span12" id="headbar">
				<div class="span4 offset4"><h1>SubmitQ</h1></div>
			</div>
			<div class="row-fluid">
				<div class="span4 offset3" id="caption"><h2>Just Ask. That Simple.</h2></div>
			</div>
		</div>		
	</div>
			
		
		
        
	

		<h3>Don't have an account yet?</h3>
		<h2>Register</h2>
		<a href="student_registration.php"><div class="suckers">Student Registration</div></a><br />
		<a href="professor_registration.php"><div class="suckers">Professor Registration</div></a><br />
		<a href="ta_registration.php"><div class="suckers">TA Registration</div></a><br />
		
	

	
	
	        <!--<div id="login">
		<h2>Login</h2></br>
	
		<form action="process_login.php" method ="POST">
			<p><label for="Email">Email</label> <input type= "text" name = "email" required> </p>
			<p><label for="Password">Password</label> <input type= "password" name = "password" required> </p>
			<div id="yoyo">
			<div id="yo1"><p class ="submit"><input type="submit" name= "submit" value= "Login"></p>
			<p><input type="checkbox" name="setcookie" value="setcookie">Remember Me</p></div>
			</form>
			<div id="yo2"><a href="forgot_password.php">Forgot Password?</a></div></div>
	</div>-->

<form action="process_login.php" class="form-horizontal" method="POST">
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
      <input type="text" id="inputEmail" placeholder="Email">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">Password</label>
    <div class="controls">
      <input type="password" id="inputPassword" placeholder="Password">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <label class="checkbox">
        <input type="checkbox"> Remember me
      </label>
      <button type="submit" class="btn">Sign in</button>
    </div>
  </div>
</form>


	

	
	<div id="footer">
		 Copyright@ Brocode Inc. 2013. All rights reserved.
	</div>
</body>

</HTML>
