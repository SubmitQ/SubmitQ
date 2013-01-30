<?php
session_start();
$con = mysql_connect("sql.mit.edu", "harlin", "freshman") or die("Cannot connect to database: ".mysql_error());
mysql_select_db("harlin+db1", $con) or die("Cannot select database: ".mysql_error());
$class_code= $_POST['class_code'];

if ($_POST){
    $name= $_POST['name'];
    $type = $_POST['type'];
    $usID = $_POST['usID'];
    $n = +substr($usID, 2);
    
    $num_row = mysql_num_rows(mysql_query("SELECT * FROM question$class_code"));
    $num_col= (mysql_result(mysql_query("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema= 'harlin+db1' AND table_name = 'question$class_code'", $con), 0) -6)/2;

    // update answer0 as '1'
    for($i= 0; $i < $num_row; $i++)
    {
$q_id= mysql_result(mysql_query("SELECT q_id FROM question$class_code ORDER BY answer0 DESC, upvotes DESC, written_at DESC", $con), $i);
	    if ($q_id == $n){
		
		mysql_query("UPDATE question$class_code SET answer0 = '0' WHERE q_id='$q_id'") or die ("answer0 not updated, question not unstarred: ".mysql_error());
		mysql_query("UPDATE question$class_code SET answerer0= NULL WHERE q_id= '$q_id'") or die("answerer0 not updated, TA not deleted: ".mysql_error());
			    }
		    }       
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
