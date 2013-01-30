<?php

// Inialize session
session_start();
// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['Email']) || $_SESSION['UserType'] != "S") {
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
<title>Questions</title>
<link rel="stylesheet" type="text/css" href="../style.css" />
<link rel="stylesheet" type="text/css" href="../class_style.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="jquery.livequery.js"></script>
</head>

<body>
<?php include "../account_bar_s.php" ?>
<div id="container">
	<div id="col-left">
		<?php include "questions/question_list.php" ?>
	</div>
	<div id="col-right">
		<?php include "../feedback.php" ?>
		<?php include "../vocab_list.php" ?>
	</div>
</div>
</body>
</html>