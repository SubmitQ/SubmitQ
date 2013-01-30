<?php
session_start();
$con = mysql_connect("sql.mit.edu", "harlin", "freshman") or die("Cannot connect to database: ".mysql_error());
mysql_select_db("harlin+db1", $con) or die("Cannot select database: ".mysql_error());
$class_code= $_POST['class_code'];

if ($_POST){

    $type = $_POST['type'];
    $daID = $_POST['daID'];
    $dasID = $_POST['dasID'];
    $n = +substr($daID, 2);
    $p = +substr($dasID, 7);
    
    $num_row = mysql_num_rows(mysql_query("SELECT * FROM question$class_code"));
    $num_col= (mysql_result(mysql_query("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema= 'harlin+db1' AND table_name = 'question$class_code'", $con), 0) -6)/2;

    // update answer as null
    for($i= 0; $i < $num_row; $i++)
    {
	    $q_id= mysql_result(mysql_query("SELECT q_id FROM question$class_code ORDER BY answer0 DESC, upvotes DESC, written_at DESC", $con), $i);
	    if ($q_id == $n){

		for ($k= 1; $k<= $num_col; $k++){
			
			if($k== $p){
			mysql_query("UPDATE question$class_code SET answer$k = NULL WHERE q_id='$q_id'") or die ("answer not deleted: ".mysql_error());
			mysql_query("UPDATE question$class_code SET answerer$k= NULL WHERE q_id= '$q_id'") or die("answerer not deleted: ".mysql_error());
			
			$num_ans= mysql_result(mysql_query("SELECT num_answers FROM question$class_code WHERE q_id=$q_id", $con),0);
			$num_ans_min= $num_ans -1;
			mysql_query("UPDATE question$class_code SET num_answers = $num_ans_min WHERE q_id='$q_id'", $con) or die("number of answers not decreased: ".mysql_error());
			    }
		    }       
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

