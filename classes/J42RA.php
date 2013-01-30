<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['Email'])) 
{
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

//get class_code from url
$class_code= $_GET["code"];

//if professor logs in input idate into all_classes table
if ($_SESSION['UserType']=='P')
{
	//day of the year
	$idate= idate("z"); 

	$get_d= "SELECT date FROM all_classes WHERE class_code='$class_code'";
	$date= mysql_result(mysql_query($get_d, $con), 0);

	//if idate now > date in table, at least a day has passed, so clean the tables
	if ($idate > $date)
	{	
		$empty_q= "TRUNCATE TABLE question$class_code";
		mysql_query($empty_q, $con) or die("can't empty question table: ".mysql_error());
		$empty_v= "TRUNCATE TABLE vocab$class_code";
		mysql_query($empty_v, $con) or die("can't empty vocab table: ".mysql_error());
	}

	//update date as the current idate
	$update_d= "UPDATE all_classes SET date= $idate WHERE class_code='$class_code'";
	mysql_query($update_d, $con) or die("can't update idate: ".mysql_error());
}

//check if user is in the roll_call table
{
	$first_name= $_SESSION['First_name'];
	$last_name= $_SESSION['Last_name'];
	$email= $_SESSION['Email'];

	$check_c= mysql_result(mysql_query("SELECT COUNT(*) FROM roll_call$class_code WHERE email= '$email'", $con) ,0);
	if($check_c != 1)
	{
	//	header("location: ../student_profile.php");
	}		
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
<title>4.01 KPOP 101</title>
<link rel="stylesheet" type= "text/css" href="../bootstrap/css/bootstrap.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="change.css" >
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>

<body>
<div class= "container-fluid page">
	<div class='span12'>
	<?php include "account_bar_s.php" ?>
	<span class='welcome'>Welcome to 4.01 KPOP 101 at MIT</span>
	
<div class='row-fluid'>
	<div class= "span8 well">
		<?php include "questions/question_list.php" ?></div>
	<div class= "span4 well well-small pull-right">
		<?php include "feedback/feedback_include.php" ?></div>
	<div class= "span4 well well-small pull-right">
		<?php include "vocab/vocab_list.php" ?>	</div>
</div>
</div>
</div>
<div class="row-fluid fill">

	</div>

</body>
</html>

