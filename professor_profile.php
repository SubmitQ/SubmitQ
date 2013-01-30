<?php 
$first_name= $_SESSION['First_name'];
$last_name= $_SESSION['Last_name'];
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Professor Page</title>

<link rel="stylesheet" type="text/css" href="profile_s.css" />
<link rel="stylesheet" type="text/css" href="index.css" />

<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet" media="screen" type="text/css">

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="bootstrap\js\bootstrap.min.js"></script>

<!--<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>-->
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
		<div class="span4 offset1">
			<div class="row-fluid">
				<h4>Account Management</h4>
				<a href='add_class_p.php'>Add Class</a>
				<br/><a href='delete_class.php'>Delete a class</a>
				<br/><a href="change_password.php">Change Password</a>
			</div></br>
			<div class="row-fluid">
				<h4>Classes you are teaching:</h4>
				<!--List of Classes Yo-->
				<?php 
//get number of all classes
$count= mysql_query("SELECT COUNT(*) FROM all_classes WHERE first_name='$first_name' AND last_name='$last_name'");
$num_class= mysql_result($count,0);

if($num_class !=0)
{
	for($n=0; $n< $num_class; $n++)
	{
		//find classes they are teaching
		$classes=mysql_result(mysql_query("SELECT class FROM all_classes WHERE first_name='$first_name' and last_name='$last_name'",$con), $n);
		$class_code=mysql_result(mysql_query("SELECT class_code FROM all_classes WHERE first_name='$first_name' and last_name='$last_name'",$con), $n);
		$class_number= mysql_result(mysql_query("SELECT class_number FROM all_classes WHERE class_code= '$class_code'", $con), 0);
		//echo '<div class="span4">';
		//when they click on the link go to class website
		if($classes!=NULL && $class_code!=NULL)
		{
			
			echo "<h5 class='class_name'><a href='classes/$class_code.php?code=$class_code'>$class_number $classes</a></h5>";
			//echo "<h5 class='class_name'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$class_number $classes</h5>";
			//echo "<div class='table span4'>";
			//echo "<table broder='1'><tr><th>TA/Student</th><th>First name</th><th>Last name</th><th>Email</th></tr>";
			
			
		}
		
		
	}
}
else
{
echo "</br>You are not teaching any classes yet. </br><a href='add_class_p.php'>Add classes</a>!!</br>";
}
?>	
				<!--List of Classes Yo-->
				
			</div>
		</div>
		
		<!--<div class="span6 offset1">-->
		
		<div class="row-fluid">
			<h4>Attendance/Contacts</h4>
			<!--Classes-->
		
				<?php 
//get number of all classes
$count= mysql_query("SELECT COUNT(*) FROM all_classes WHERE first_name='$first_name' AND last_name='$last_name'");
$num_class= mysql_result($count,0);

if($num_class !=0)
{
	for($n=0; $n< $num_class; $n++)
	{
		//find classes they are teaching
		$classes=mysql_result(mysql_query("SELECT class FROM all_classes WHERE first_name='$first_name' and last_name='$last_name'",$con), $n);
		$class_code=mysql_result(mysql_query("SELECT class_code FROM all_classes WHERE first_name='$first_name' and last_name='$last_name'",$con), $n);
		$class_number= mysql_result(mysql_query("SELECT class_number FROM all_classes WHERE class_code= '$class_code'", $con), 0);
		
		echo '<div class="span4">';
		echo '<div class="row-fluid">';
		echo "<input type='hidden' id='current_page' />";
		echo "<input type='hidden' id='show_per_page' />";
		
		//echo '<div class="row-fluid">';
		//echo '<div class="row-fluid" id="yo">';
		if($classes!=NULL && $class_code!=NULL)
		{
			
			echo '<div class="span4">';
			echo "<h5 class='class_name'>$class_number $classes</h5>";
			//echo "<h5>$class_number $classes</h5>";
			echo "<div class='table span4'>";
			echo "<table id='content'><tr><th>TA/Student</th><th>First name</th><th>Last name</th><th>Email</th></tr>";
			
			//show roll call for your class
			$num_stu= mysql_num_rows(mysql_query("SELECT * FROM roll_call$class_code", $con))-1;
			$tas= mysql_query("SELECT first_name, last_name, email FROM roll_call$class_code WHERE usertype='TA'", $con);

			//show Ta first
			while($ta= mysql_fetch_array($tas))
			{
				echo "<tr><td>TA</td>";
				echo "<td>".$ta['first_name']."</td>";
				echo "<td>".$ta['last_name']."</td>";
				echo "<td>".$ta['email']."</td></tr>";
			}
			$stus= mysql_query("SELECT first_name, last_name, email FROM roll_call$class_code WHERE usertype='Student'", $con);

			//show students 
			while($stu= mysql_fetch_array($stus))
			{		
				echo "<tr><td>Student</td>";
				echo "<td>".$stu['first_name']."</td>";
				echo "<td>".$stu['last_name']."</td>";
			        echo "<td>".$stu['email']."</td></tr>";
			}
			//include 'pagination.php';
			echo "</table>";
			//echo "'herro'";
			//include 'pagination.php';
			echo "</div>";
			//include 'pagination.php';
			echo "</div></br>";
			//include 'pagination.php';
			
		}
		echo "</div>";
		echo "<div class='row-fluid'>";
		//include 'pagination.php';
		echo "</div>";
		
		
		//ton of php code goes here
		//when they click on the link go to class website
		
		
		//echo '</div>';
		//echo '</div>';
		//IN THE MIDDLE OF THE PHP CODE BRO

		
		//IN THE MIDDLE OF THE PHP CODE BRO JUST SAYING
		echo '</div>';
		
		
	}
}

?>	
			<!--Classes-->
		</div>
		<!--</div>-->

		
	</div>
</div>
<style>
	/*.class_name{text-align: center;}
	#container{height:440px;}
	#content{height:300px;}
	#push{height:200px;}*/
</style>
<?php include "footer.php"; ?>
</body>
</html>
