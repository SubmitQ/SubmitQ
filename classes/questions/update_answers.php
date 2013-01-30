<?php
session_start();
$con = mysql_connect("sql.mit.edu", "harlin", "freshman") or die("Cannot connect to database: ".mysql_error());
mysql_select_db("harlin+db1", $con) or die("Cannot select database: ".mysql_error());

$class_code= $_POST['class_code'];

if ($_POST){
    $ans = mysql_real_escape_string($_POST['ans']);
    $answerer = $_POST['name'];
    $currentID = $_POST['currentID'];
    $n = +substr($currentID, 1);
    
$num_row = mysql_num_rows(mysql_query("SELECT * FROM question$class_code"));
$num_col= (mysql_result(mysql_query("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema= 'harlin+db1' AND table_name = 'question$class_code'", $con), 0) -6)/2;

    // insert answer into database
    for($i= 0; $i < $num_row; $i++)
    {
$q_id= mysql_real_escape_string(mysql_result(mysql_query("SELECT q_id FROM question$class_code ORDER BY answer0 DESC, upvotes DESC, written_at DESC", $con), $i));
$qs= mysql_real_escape_string(mysql_result(mysql_query("SELECT question FROM question$class_code ORDER BY answer0 DESC, upvotes DESC, written_at DESC", $con), $i));
        
if ($q_id == $n){          
            
            //count how many times the question has already been answered(=k)
            $num_ans= mysql_result(mysql_query("SELECT num_answers FROM question$class_code WHERE q_id='$q_id'", $con),0);
            $num_ans_plus= $num_ans +1;
            
            $check_col= "SELECT * FROM information_schema.columns WHERE table_schema= 'harlin+db1' AND table_name = 'question$class_code' AND column_name = 'answer$num_ans_plus'";
            if(mysql_num_rows(mysql_query($check_col, $con))==0)
            {
                //add k+1th answer column
                $add_ans= "ALTER TABLE question$class_code ADD answer$num_ans_plus TEXT(1000) AFTER answerer$num_ans";
                mysql_query($add_ans, $con) or die("Answer column not added: ".mysql_error());
    
                //add k+1th answerer column
                $add_ansr= "ALTER TABLE question$class_code ADD answerer$num_ans_plus VARCHAR(100) AFTER answer$num_ans_plus";
                mysql_query($add_ansr, $con) or die("Answerer column not added: ".mysql_error());
                
            }
            $insert_a= "UPDATE question$class_code SET answer$num_ans_plus='$ans' WHERE q_id= '$q_id'"; 
            mysql_query($insert_a, $con) or die("Could not update the answer: ".mysql_error()); 
    
	    //update the answerer in k+1th answerer column
	   
            $insert_ar= "UPDATE question$class_code SET answerer$num_ans_plus='$answerer' WHERE q_id= '$q_id'";
            mysql_query($insert_ar, $con) or die("Could not update the answerer: ".mysql_error());
    
            //add one to num_ans
            mysql_query("UPDATE question$class_code SET num_answers= '$num_ans_plus' WHERE q_id= '$q_id'", $con);
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



