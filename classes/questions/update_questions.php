<?php
session_start();
$con = mysql_connect("sql.mit.edu", "harlin", "freshman") or die("Cannot connect to database: ".mysql_error());
mysql_select_db("harlin+db1", $con) or die("Cannot select database: ".mysql_error());

$class_code= $_POST["class_code"];

// if POST QUESTION button has been clicked
if($_POST)
{
    $question=mysql_real_escape_string($_POST['question']);
    $asker = $_POST['name'];

    //get the question and asker into the database
    $insert_q= "INSERT INTO question$class_code(question, asker) VALUES ('$question','$asker')";
    mysql_query($insert_q, $con) or die("Couldn't update question and/or questioner: ".mysql_error());
   
}

?>

<?php 
if($_SESSION["Sort"]=='0'){
	include "update_page.php";} 
if($_SESSION["Sort"]=='1'){
	include "sort_by_time_desc.php";} 
if($_SESSION["Sort"]=='2'){
	include "sort_by_time_asc.php";} 
if($_SESSION["Sort"]=='3'){
	include "sort_num_ans_asc.php";}
if($_SESSION["Sort"]=='4'){
	include "sort_num_ans_des.php";}
if($_SESSION["Sort"]=='5'){
	include "sort_by_upvotes_asc.php";} 
?>
