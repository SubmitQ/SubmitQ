<!DOCTYPE HTML>
<html>
<head>
	<title>Student Registration</title>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="validate_student_registration.js"></script>
	<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" type="text/css" href="index.css">
	<script src="bootstrap\js\bootstrap.min.js"></script>
	
		<script type="text/javascript">	
		$(document).ready(function(){
		$('#register_student').click(function(){
			var first_name = jQuery.trim($('#first_name').val());
			var last_name = jQuery.trim($('#last_name').val());
			var email = jQuery.trim($('#email').val());
			var password = jQuery.trim($('#password').val());
			var id = jQuery.trim($('#id').val());
			var type = "S";
			
			var dataString = 'first_name=' + first_name + '&last_name=' + last_name + '&email=' + email + '&password=' + password + '&id=' + id + '&type=' + type;
			
			alert(dataString);
			//else{
				$.ajax({
					type: "POST",
					url: "process_registration.php",
					data: dataString,
					success: function(html){
						$('#message').html(html);
						$('#first_name').val('');
						$('#last_name').val('');
						$('#email').val('');
						$('#password').val('');
						$('#confirm_password').val('');						
						$('#id').val('');
					},
					error: function(html){
						alert("error");
					}
				
				})
			//}
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
			<div class="span4 offset1"><h1><a href="index.php">SubmitQ</a></h1>
				<h3>Just Ask. That Simple.</h3>
			</div>
			<div class="span3"></div>
			<div id="login" class="span4">
				<br /><br />
				<strong>Already have an account? &nbsp;</strong> <a href="index.php"><button type="button" class="btn">Login</button></a>
			</div>			
					
		</div>
		
			<!--<div class="span4 offset1" id="caption"><h2>Just Ask. That Simple.</h2></div>-->

		</div>
	</div>
	
<div class="container-fluid" id="container">
	
<div class="row-fluid">

<div class="span6">
	<h2>Register</h2>
<form method="POST">
<table>
	<tr>
		<td>First Name: </td><td><input type="text" id="first_name" name="first_name"><span id="first_name_status"></span></td>
	</tr>
	<tr>
		<td>Last Name: </td><td><input type="text" id="last_name" name="last_name"><span id="last_name_status"></span></td>
	</tr>
	<tr>
		<td>Email Address: </td><td><input type="text" id="email" name="email"><span id="email_status"></span></td>
	</tr>
	<tr>
		<td>Password: <font size="1"><br />Must have at least 6 characters</font></td><td><input type="password" id="password" name="password"><span id="password_status"></span></td>
	</tr>
	<tr>
		<td>Confirm Password: </td><td><input type="password" id="confirm_password" name="confirm_password"><span id="confirm_password_status"></span></td>
	</tr>
	<tr>
		<td>Student ID Number: </td><td><input type="text" id="id" name="id"><span id="student_id_status"></span></td>
	</tr>
	
</table>
<button type="submit" name="register_student" id="register_student" class="btn" disabled>Register</button>
<!--<p><input type="submit" name="register_student" id="register_student" value="Register" disabled/></p>-->
<div id="message"></div>
</form>
</div>

<div class="span6">
	<h2>What is SubmitQ?</h2>
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
</html>
