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

$prof_name= $_POST["professor"];
$class_num= $_POST["class_num"];

if($_POST)
{
	//get class code for the class
	$get_code= "SELECT class_code FROM all_classes WHERE last_name='$prof_name' AND class_number= '$class_num'";
	$class_code= mysql_result(mysql_query($get_code, $con), 0);

	//drop user from the roll_call table
	$drop_rc= "DELETE FROM roll_call$class_code WHERE email='$email' AND last_name= '$last_name' AND first_name= '$first_name'";
	mysql_query($drop_rc, $con) or die("wrong");
 
	//get the class off of user's info on all_users
	$num_col= mysql_result(mysql_query("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema= 'harlin+db1' AND table_name= 'all_users'", $con), 0)-8;

	for($n= 1; $n<= $num_col; $n++)
	{
		$find_code= "SELECT class$n FROM all_users WHERE email= '$email' AND last_name= '$last_name' AND first_name= '$first_name'";
		$code= mysql_result(mysql_query($find_code, $con), 0);

		if($code== $class_code)
		{
			$drop_c= "UPDATE all_users SET class$n= 'NULL' WHERE email= '$email' AND last_name= '$last_name' AND first_name= '$first_name'";
			mysql_query($drop_c, $con) or die("wrong");	
			
			//subtract one from num_class
			$num_class= mysql_result(mysql_query("SELECT num_class FROM all_users WHERE email= '$email' AND last_name= '$last_name' AND first_name= '$first_name'", $con), 0);
			$new_num_class= $num_class -1;
			mysql_query("UPDATE all_users SET num_class= '$new_num_class' WHERE email= '$email' AND last_name= '$last_name' AND first_name= '$first_name'", $con) or die("wrong");
		}

	}
	echo "You have successfully dropped <b>$class_num ($class)</b>.";
	echo "<a href= 'profile.php'>Return to profile</a>";
}
?>