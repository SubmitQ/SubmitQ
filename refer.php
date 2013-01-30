<?php 
session_start();
?>
<!DOCTYPE HTML>
<head>
<title>SubmitQ - Refer a Professor</title>
	<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="profile_s.css" />
    <link rel="stylesheet" type="text/css" href="index.css" />

	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="bootstrap\js\bootstrap.min.js"></script>
	
	<script type="text/javascript">
		var first_name = '<?php echo $_SESSION['First_name']; ?>';
		var last_name = '<?php echo $_SESSION['Last_name']; ?>';
		var email = '<?php echo $_SESSION["Email"]; ?>';
		
		$(document).ready(function(){
		$('#refer_prof').ajaxStop(function(){
			$(this).removeClass('loading disabled');
		})
		$('#refer_prof').click(function(){
			var name = jQuery.trim($('#name').val());
			var prof_name = jQuery.trim($('#prof_name').val());
			var prof_email = jQuery.trim($('#prof_email').val());
			var school = jQuery.trim($('#school').val());
			var class_name = jQuery.trim($('#class_name').val());
			var class_num = jQuery.trim($('#class_num').val());
			
			var dataString = 'name=' + name + '&prof_name=' + prof_name + '&prof_email=' + prof_email + '&school=' + school + '&class_name=' + class_name + '&class_num=' + class_num;
			
			if (!isValidEmailAddress(prof_email)){
				$('#success').hide();
				$('#error').hide().html('Invalid email address').fadeIn('slow');
			}
			else if (name == ''){
				$('#error').hide().html('Your name must be filled out').fadeIn('slow');
			}
			else if (prof_name == ''){
				$('#error').hide().html("Your professor\'s name must be filled out").fadeIn('slow');
			}
			else if (prof_email== ''){
				$('#error').hide().html("Your professor\'s email must be filled out").fadeIn('slow');
			}
			else if (school == ''){
				$('#error').hide().html('School must be filled out').fadeIn('slow');
			}
			else if (class_name== ''){
				$('#error').hide().html('Class name must be filled out').fadeIn('slow');
			}
			else if (class_num== ''){
				$('#error').hide().html('Class number must be filled out').fadeIn('slow');
			}
			else{
				$(this).addClass('loading disabled');
				$.ajax({
					type: "POST",
					url: "process_refer_professor.php",
					data: dataString,
					success: function(html){
						$('#error').hide();
						$('#success').hide().html(html).fadeIn('slow');
						$('#name').val('');
						$('#prof_name').val('');
						$('#prof_email').val('');
						$('#school').val('');
						$('#class_name').val('');
						$('#class_num').val('');
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
		
	function isValidEmailAddress(email){
		var re = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/; 
		if (re.test(email)){
			return true;
		}
		else {
		return false;
		}
	}
</script>	
</head>

<body>
<div id="wrapper">
	<?php
if(!isset($_SESSION["Email"]))
{include('not_loggedin.php');}

else
{include('loggedin.php');}
?>
	
<div class="container-fluid" id="container">
	
<div class="row-fluid">

<div class="span6 offset3">
	<h2>Refer a Professor</h2>
	Do you wish one of your classes could be available on SubmitQ? Just fill out this simple form to let your professor know that you want him or her to register your class on SubmitQ! </p>
	<form method ="POST">
	<table>
	<tr><td>Your name: </td><td><input type= "text" id="name" name = "name"></td></tr>
	<tr><td>Your professor's name: </td><td><input type= "text" name = "prof_name" id="prof_name"></td></tr>
	<tr><td>Your professor's email: &nbsp;</td><td><input type= "text" id="prof_email" name = "prof_email"></td></tr>
	<tr><td>School name: </td><td><input type= "text" name = "school" id="school"></td></tr>
	<tr><td>Class name: </td><td><input type= "text" name = "class_name" id="class_name"></td></tr>
	<tr><td>Class number: </td><td><input type= "text" name = "class_num" id="class_num"></td></tr>
	<tr><td></td><td><button type="submit" name="refer_prof" id="refer_prof" class="btn btn-primary pull-right">Refer Professor</button></td></tr>
	</table>
	</form>
	
	<div id="error" class="alert alert-error" style="display:none;"></div>
	<div id="success" class="alert alert-success" style="display:none;"></div>
</div>

</div>
</div>

     <div id="push"></div>
</div>
	<?php include "footer.php" ?>
</body>

</HTML>