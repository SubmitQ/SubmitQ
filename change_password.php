<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['Email'])) {
header('Location: index.php');
}

//connect to database
$con = mysql_connect("sql.mit.edu","harlin","freshman");
if (!$con)
{
	die('Could not connect:'.mysql_error());
}

//select database
mysql_select_db("harlin+db1",$con) or die("Cannot select the Database".mysql_error());
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Change Password</title>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="validate_password.js"></script>
	<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" type="text/css" href="profile_s.css">
	<link rel="stylesheet" type="text/css" href="index.css">

	<script src="bootstrap\js\bootstrap.min.js"></script>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			
		$('#change_password').ajaxStop(function(){
			$(this).removeClass('loading disabled');
		})
		
		$('#change_password').click(function(){
			var email = jQuery.trim($('#email').val());
			var current_pw = jQuery.trim($('#current_pw').val());
			var new_pw = jQuery.trim($('#new_pw').val());

			var dataString = 'email=' + email + '&current_pw=' + current_pw + '&new_pw=' + new_pw;

			if (email == ''){
				$('#success').hide();
				$('#error').hide().html('Email cannot be left blank').fadeIn('slow');
			}
			else if (current_pw == ''){
				$('#success').hide();
				$('#error').hide().html('Current password cannot be left blank').fadeIn('slow');
			}
			else{
				$(this).addClass('loading disabled');
				$.ajax({
					type: "POST",
					url: "process_change_password.php",
					data: dataString,
					success: function(html){
						if (html =="wrong"){
							$('#success').hide();
							$('#error').hide().html('Email and current password do not match. Please try again.').fadeIn('slow');
						}
						else{
							$('#error').hide();
							$('#success').hide().html(html).fadeIn('slow');
							$('#email').val('');
							$('#current_pw').val('');
							$('span').hide();
						}
					},
					error: function(html){
						alert("error");
					}
				
				})
				$(this).removeClass('loading disabled');
			}
			return false;
		})
	})
</script>	
</head>

<body>
<div id="wrapper">
		<div class = "row-fluid" id="header" class="span12">
		<div class="span12" id="headbar">
			<div class="row-fluid">
			<div class="span4 offset1"><h1><a class="head" href="index.php">SubmitQ</a></h1>
			</div>
			<div class="span4 offset3" id="profile">
				<div id="account_info">
				Welcome <?php echo $_SESSION['First_name'] . " " . $_SESSION['Last_name']; ?> | <a class="white" href="profile.php">My Profile</a> | <a class="white" href="logout.php">Logout</a>
				</div>
			</div>		
					
		</div>
		
			<!--<div class="span4 offset1" id="caption"><h2>Just Ask. That Simple.</h2></div>-->

		</div>
	</div>
	
<div class="container-fluid" id="container">
	
<div class="row-fluid">

<div class="span7 offset4">
	<h2>Change Password</h2>
<form method ="POST">
<table>
<tr><td>E-mail Address: </td><td><input type= "text" name = "email" id= "email"> </td></tr>
<tr><td>Current password: </td><td><input type= "password" name = "current_pw" id="current_pw"></td></tr>
<tr><td>New Password: <font size="1"><br />Must have at least 6 characters</font></td><td><input type = "password" name = "new_pw" id="new_pw"></td><td><span id="new_pw_status"></span></td></tr>
<tr><td>Confirm New Password: &nbsp;</td><td><input type = "password" name = "confirm_new_pw" id="confirm_new_pw"></td><td><span id="confirm_new_pw_status"></span></td></tr>
<tr><td></td><td><button type="submit" name="update" id="change_password" class="btn btn-primary pull-right" disabled>Change Password</button></td></tr>
</table>

</form>
<div id="message"></div>
<div id="error" class="alert alert-error" style="display: none;"></div>
<div id="success" class="alert alert-success" style="display: none;"></div>
</div>

</div>
</div>

     <div id="push"></div>
</div>
<?php include("footer.php");?>


</body>

</html>

