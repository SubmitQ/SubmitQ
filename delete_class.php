<?php
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['Email']) || $_SESSION['UserType'] != "P") 
{
	header('Location: index.php');
}
?>


<!DOCTYPE HTML>
<head>
<title>SubmitQ - Drop a Class</title>
<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="profile_s.css">
<link rel="stylesheet" type="text/css" href="index.css">

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="bootstrap\js\bootstrap.min.js"></script>
	<script type="text/javascript">
		var first_name = '<?php echo $_SESSION['First_name']; ?>';
		var last_name = '<?php echo $_SESSION['Last_name']; ?>';
		var email = '<?php echo $_SESSION["Email"]; ?>';
		
		$(document).ready(function(){
		$('#delete').ajaxStop(function(){
			$(this).removeClass('loading disabled');
		})			
		$('#delete').click(function(){
			var class_code = jQuery.trim($('#class_code').val());
			var class_num = jQuery.trim($('#class_num').val());
			
			var dataString = 'first_name=' + first_name + '&last_name=' + last_name + '&email=' + email + '&class_code=' + class_code + '&class_num=' + class_num;
			if (class_num == ''){
				$('#success').hide();	
				$('#error').hide().html('Class code must be filled out. Check your profile if you have forgotten the class code.').fadeIn('slow');
			}
			else if (class_code== ''){
				$('#success').hide();			
				$('#error').hide().html('Class number must be filled out').fadeIn('slow');
			}

			else {
				$(this).addClass('loading disabled');
				$.ajax({
					type: "POST",
					url: "process_delete_class.php",
					data: dataString,
					success: function(html){
						if (html == "wrong"){
							$('#success').hide();
							$('#error').hide().html('Unable to delete this class. Check your form details or make sure you are teaching this class.').fadeIn('slow');	
						}
						else{
							$('#error').hide();
							$('#success').hide().html(html).fadeIn('slow');
							$('#class_num').val('');
							$('#class_code').val('');
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
		
		</div>
	</div>
	
<div class="container-fluid" id="container">
	
<div class="row-fluid">

<div class="span6 offset5">
<h2>Delete a Class</h2>
<p>Fill out the following form to delete a class</p>
<form method= "POST">
	<table>
		<tr><td>Class number: &nbsp;</td><td><input type= 'text' name= 'class_num' id='class_num'></td></tr>
		<tr><td>Class code: </td><td><input type= 'text' name= 'class_code' id='class_code'></td></tr>
		<tr><td></td><td><button type="submit" name="delete" id="delete" class="btn btn-primary pull-right">Delete Class</button></td></tr>
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
</html>

