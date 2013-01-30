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
if (!isset($_SESSION['Email']) || $_SESSION['UserType'] != "P") 
{
	header('Location: index.php');
}
?>

<!DOCTYPE HTML>
<head>
<title>SubmitQ - Create a Class</title>
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
			
		$('#add_class_p').ajaxStop(function(){
			$(this).removeClass('loading disabled');
		})
		
		$('#add_class_p').click(function(){
			var school = jQuery.trim($('#school').val());
			var class_name = jQuery.trim($('#class_name').val());
			var class_num = jQuery.trim($('#class_num').val());
			var lecture_len = jQuery.trim($('#lecture_len').val());
			var class_des = jQuery.trim($('#class_des').val());
			
			var dataString = 'school=' + school + '&class_name=' + class_name + '&class_num=' + class_num + '&lecture_len=' + lecture_len + '&class_des=' + class_des + '&first_name=' + first_name + '&last_name=' + last_name + '&email=' + email;
			
			if (school == ''){
				$('#success').hide();
				$('#error').hide().html('School must be filled out').fadeIn('slow');
			}
			else if (class_name == ''){
				$('#success').hide();
				$('#error').hide().html('Class name must be filled out').fadeIn('slow');
			}
			else if (class_num== ''){
				$('#success').hide();
				$('#error').hide().html('Class number must be filled out').fadeIn('slow');
			}
			else if (lecture_len== ''){
				$('#success').hide();
				$('#error').hide().html('Lecture length must be filled out').fadeIn('slow');
			}
			else if (class_des== ''){
				$('#success').hide();
				$('#error').hide().html('Class description must be filled out').fadeIn('slow');
			}
			else{
				$(this).addClass('loading disabled');
				$.ajax({
					type: "POST",
					url: "process_add_class_p.php",
					data: dataString,
					success: function(html){
						$('#error').hide();
						$('#create_class').hide();
						$('#success').hide().html(html).fadeIn('slow');
						$('#school').val('');
						$('#class_name').val('');
						$('#class_num').val('');
						$('#lecture_len').val('');
						$('#class_des').val('');
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
<div id="create_class">
<h2>Create A Class</h2>
<p>Fill out the form below to create a new class on SubmitQ. After submitting this form, you will receive a class code, which you must give to your students and TAs so they will be able to enroll in your class. You will receive an email with your class code and class details for your convenience</p>
<form method="POST">
<table>
<tr><td>School: </td><td><input type="text" name="school" id="school"></td></tr>
<tr><td>Class Name: </td><td><input type="text" name="class_name" id="class_name"></td></tr>
<tr><td>Class Number: </td><td><input type="text" name="class_num" id="class_num"></td></tr>
<tr><td>Length of Lecture(hr): &nbsp;</td><td><input type= "text" name="lecture_len" id="lecture_len"></td></tr>
<tr><td valign="top">Class Description:</td><td><textarea name="class_des" id="class_des" cols="20" rows="5"> </textarea></td></tr>
<tr><td></td><td><button type="submit" name="update" id="add_class_p" class="btn btn-primary pull-right">Create class</button></td></tr>
</table>

</form>
</div>
<div id="error" class="alert alert-error" style="display:none;"></div>
</div>

<div class="row-fluid">
<div class="span8 offset2">
	<div id="success" class="alert alert-success" style="display:none; position:relative; top: 100px; "></div>
</div>
</div>

</div>
</div>

     <div id="push"></div>
</div>
	<?php include "footer.php" ?>


</body>
</html>

