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
<title>18.701 Algebra 1</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>

<body>
Welcome to 18.701 Algebra 1 at MIT</br>
<?php include "account_bar_s.php" ?>
<?php include "question_list.php" ?>
<?php include "feedback.php" ?>
<?php include "vocab.php" ?>
</body>
</html>

