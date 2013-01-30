<?php
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['Email'])) 
{
	header('Location: index.php');
}
?>


<!DOCTYPE HTML>
<head>
<title>SubmitQ - Drop a Class</title>
<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="index.css">
<link rel="stylesheet" type="text/css" href="profile_s.css">
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="bootstrap\js\bootstrap.min.js"></script>
	<script type="text/javascript">
		var first_name = '<?php echo $_SESSION['First_name']; ?>';
		var last_name = '<?php echo $_SESSION['Last_name']; ?>';
		var email = '<?php echo $_SESSION["Email"]; ?>';
		
		$(document).ready(function(){
		$('#drop').ajaxStop(function(){
			$(this).removeClass('loading disabled');
		})			
		$('#drop').click(function(){
			var professor = jQuery.trim($('#professor').val());
			var class_num = jQuery.trim($('#class_num').val());
			
			var dataString = 'first_name=' + first_name + '&last_name=' + last_name + '&email=' + email + '&professor=' + professor + '&class_num=' + class_num;
			if (professor == ''){
				$('#success').hide();	
				$('#error').hide().html('Professor name must be filled out').fadeIn('slow');
			}
			else if (class_num== ''){
				$('#success').hide();			
				$('#error').hide().html('Class number must be filled out').fadeIn('slow');
			}

			else {
				$(this).addClass('loading disabled');
				$.ajax({
					type: "POST",
					url: "process_drop_class.php",
					data: dataString,
					success: function(html){
						if (html == "wrong"){
							$('#success').hide();
							$('#error').hide().html('Cannot drop this class').fadeIn('slow');	
						}
						$('#error').hide();
						$('#success').hide().html(html).fadeIn('slow');
						$('#professor').val('');
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
</script>
</head>

<body>
<div id="wrapper">
		<div class = "row-fluid" id="header" class="span12">
		<div class="span12" id="headbar">
			<div class="row-fluid">
			<div class="span4 offset1"><h1><a class="head" href="index.php">SubmitQ</a></h1>
				<h3>Just Ask. That Simple.</h3>
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

<div class="span6 offset3">
<h2>Drop a Class</h2>
<p>Fill out the following form to drop a class</p>
<form method= "POST">
	<table>
		<tr><td>Professor's last name: &nbsp;</td><td><input type= 'text' name= 'professor' id='professor'></td></tr>
		<tr><td>Class number: </td><td><input type= 'text' name= 'class_num' id='class_num'></td></tr>
		<tr><td></td><td><button type="submit" name="drop" id="drop" class="btn btn-primary pull-right">Drop Class</button></td></tr>
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
