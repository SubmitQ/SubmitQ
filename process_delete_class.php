<?php
//connect to database
$con = mysql_connect("sql.mit.edu","harlin","freshman");
if (!$con)
{
	die('Could not connect:'.mysql_error());
}

//select database
mysql_select_db("harlin+db1", $con) or die("Cannot select the Database".mysql_error());

//get variables
$first_name= $_POST["first_name"];
$last_name= $_POST["last_name"];
$email= $_POST["email"];

$class_code= $_POST["class_code"];
$class_num= $_POST["class_num"];


if($_POST)
{
	$num_col= mysql_result(mysql_query("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema= 'harlin+db1' AND table_name= 'all_users'", $con), 0) -8;
	
	//subtract one from num_class
	$num_row= mysql_num_rows(mysql_query("SELECT email FROM roll_call$class_code", $con));
	for($k= 0; $k< $num_row; $k++)
	{
		$emails= mysql_result(mysql_query("SELECT email FROM roll_call$class_code", $con), $k);
		$num_class= mysql_result(mysql_query("SELECT num_class FROM all_users WHERE email= '$emails'", $con), 0);
		$num_class_minus= $num_class -1;
		mysql_query("UPDATE all_users SET num_class= $num_class_minus WHERE email= '$emails'", $con) or die("num_class not subtracted :".mysql_error());
	}

	//erase class from all_users
	for($n= 1; $n< $num_col; $n++)
	{
		$find= mysql_num_rows(mysql_query("SELECT * FROM all_users WHERE class$n= '$class_code'", $con));
		if($find!=0)
		{
			$erase= "UPDATE all_users SET class$n= NULL WHERE class$n= '$class_code'";
			mysql_query($erase, $con) or die("class not deleted from all_users :".mysql_error());			
		}
	}	
	
	//erase class from all_classes
	$delete_c= "DELETE FROM all_classes WHERE class_code='$class_code' AND class_number='$class_num'";
	mysql_query($delete_c, $con) or die("class not dropped from all_classes :".mysql_error());

	//delete the tables
	$drop_t= "DROP TABLE roll_call$class_code, question$class_code, vocab$class_code";
	mysql_query($drop_t, $con) or die("class tables not deleted :".mysql_error());

	$class= mysql_result(mysql_query("SELECT class FROM all_users WHERE class_code= '$class_code' AND class_number= '$class_num'", $con), 0);

	//success message!
	echo "You have successfully deleted $class_num $class!";
}


?>
