<?php
session_start();

//connect to database
$con = mysql_connect("sql.mit.edu","harlin","freshman");
if (!$con)
{
	die('Could not connect:'.mysql_error());
}

//select database
mysql_select_db("harlin+db1",$con) or die("Cannot select the Database".mysql_error());


// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['Email']) || $_SESSION['UserType'] != "S") 
{
	header('Location: index.php');
}
?>

<!DOCTYPE HTML>
<head>
<title>SubmitQ - Enroll in a Class</title>
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

		$('#add_class_s').ajaxStop(function(){
			$(this).removeClass('loading disabled');
		})
		$('#add_class_s').click(function(){
			var class_code = jQuery.trim($('#class_code').val());
			var school = jQuery.trim($('#school').val());
			
			var dataString = 'first_name=' + first_name + '&last_name=' + last_name + '&email=' + email + '&class_code=' + class_code + '&school=' + school;
			
			if (class_code == ''){
				$('#success').hide();
				$('#error').hide().html("Class code must be filled out").fadeIn('slow');
			}
			else if (school == ''){
				$('#success').hide();				
				$('#error').hide().html("School must be filled out").fadeIn('slow');
			}
			else{
				$(this).addClass('loading disabled');
				$.ajax({
					type: "POST",
					url: "process_add_class_s.php",
					data: dataString,
					success: function(html){
						if (html == "wrong"){
							$('#success').hide();
							$('#error').hide().html("Wrong class code or school. Please try again.").fadeIn('slow');
						}
						else if (html =="already_reg"){
							$('#success').hide();				
							$('#error').hide().html("You are already registered for this class. <a href='profile.php'>Return to Profile</a>").fadeIn('slow');	
						}
						else{
							$('#error').hide();
							$('#success').hide().html(html).fadeIn('slow');
							$('#class_code').val('');
							$('#school').val('');
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

<div class="span6 offset3">
<h2>Enroll in a class</h2>
<p>You may enroll in a course if your professor has given you a class code. If you do not have a class code, please contact your professor or <a href="refer.php">refer</a> him or her to SubmitQ.</p>
<form method="POST">
<table>
	<tr><td>Class code: &nbsp;</td><td><input type="text" name="class_code" id="class_code"></td></tr>
	<tr><td>School: </td><td><input type="text" name="school" id="school"></td></tr>
	<tr><td></td><td><button type="submit" name="update" id="add_class_s" class="btn btn-primary pull-right">Enroll in class</button></td></tr>
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

