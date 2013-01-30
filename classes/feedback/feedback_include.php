<?php
SESSION_START();

//if the user is not logged in, redirect to the login page
if(!isset($_SESSION["UserType"]))
{
	header("location: index.php");
}

$code= $_GET["code"];
//Show their name
$first_name= $_SESSION['First_name'];
$last_name= $_SESSION['Last_name'];
$name= "$first_name $last_name";

if ($_SESSION["UserType"] == "P"){
	include 'alert.php';
}
else {
	include 'feedback.php';
}
?>