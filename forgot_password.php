<!DOCTYPE HTML>
<head>
<title>Forgot Password</title>
	<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" type="text/css" href="index.css">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="bootstrap\js\bootstrap.min.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
		$('#reset_password').ajaxStop(function(){
			$(this).removeClass('loading disabled');
		})
		
		$('#reset_password').click(function(){
			var email = jQuery.trim($('#email').val());
			var id = jQuery.trim($('#id').val());

			var dataString = 'email=' + email + '&id=' + id;
			if (email == ''){
				$('#success').hide();
				$('#error').hide().html('Email cannot be left blank').fadeIn('slow');
			}
			else if (id == ''){
				$('#success').hide();
				$('#error').hide().html('ID number cannot be left blank').fadeIn('slow');
			}
			else{
				$(this).addClass('loading disabled');
				$.ajax({
					type: "POST",
					url: "process_forgot_password.php",
					data: dataString,
					success: function(html){
						if (html =="wrong"){
							$('#success').hide();
							$('#error').hide().html('Email and ID number do not match').fadeIn('slow');
						}
						else{
							$('#error').hide();
							$('#success').hide().html(html).fadeIn('slow');
							$('#email').val('');
							$('#id').val('');
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
	<div class = "row-fluid" id="header" class="span12" style="padding-top:10px; padding-bottom:10px;">
		<div class="span12" id="headbar">
			<div class="row-fluid">
			<div class="span4 offset1"><h1><a class="head" href="index.php">SubmitQ</a></h1>
				<!--<h3>Just Ask. That Simple.</h3>-->
			</div>
			<div class="span3"></div>
			<div id="login" class="span4">
				<br />
				<strong>Already have an account? &nbsp;</strong> <a href="index.php"><button type="button" class="btn">Login</button></a>
			</div>			
					
		</div>
		</div>
	</div>
	
<div class="container-fluid" id="container">
	
<div class="row-fluid">

<div class="span6 offset3">
	<h2>Forgot Password</h2>
	<p>Fill out this form to reset your password. A new password will be emailed to you and then you will be able to change your password on your profile page.</p>
	<form method ="POST">
	<table>
	<tr><td>E-mail Address: &nbsp;</td><td><input type= "text" id="email" name = "email"></td></tr>
	<tr><td>ID Number: </td><td><input type= "text" name = "id" id="id"></td></tr>
	<tr><td></td><td><button type="submit" name="submit" id="reset_password" class="btn btn-primary pull-right">Reset Password</button></td></tr>
	</table>
	</form>
	
	<div id="error" class="alert alert-error" style="display:none;"></div>
	<div id="success" class="alert alert-success" style="display:none;"></div>
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
