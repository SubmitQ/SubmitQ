<!DOCTYPE HTML>
<head><style>
a:visited{
color: #0088cc;
}
a:link{
color: #0088cc;
}
</style></head>
</html>
<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['Email'])) {
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

if ($_SESSION['UserType']=='S')
{
include 'student_profile.php';
}

else if ($_SESSION['UserType']=='P'){
    include 'professor_profile.php';
}

else if ($_SESSION['UserType']=='T'){
    include 'ta_profile.php';
}

?>
