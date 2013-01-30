<?php
//connect to database
$con = mysql_connect("sql.mit.edu","harlin","freshman");
if (!$con)
{
	die('Could not connect:'.mysql_error());
}

//select database
mysql_select_db("harlin+db1",$con) or die("Cannot select the Database".mysql_error());

if($_POST)
{
	$first_name=$_POST["first_name"];
	$last_name=$_POST["last_name"];
	$email=$_POST["email"];

	$school=$_POST["school"];
	$class_code=$_POST["class_code"];
	
	//check class code and school with table "all_classes"
	$check= "SELECT COUNT(*) FROM all_classes WHERE class_code='$class_code' AND school ='$school'";

	if(mysql_result((mysql_query($check, $con)),0)==1)
	{
		//add user to the "roll_call" table
		$update= "INSERT INTO roll_call$class_code VALUES ('$first_name', '$last_name', 'Student', '$email')";
		mysql_query($update,$con) or die("already_reg");

		//check number of classes this person is taking(=k)
		$num_class= mysql_result(mysql_query("SELECT num_class FROM all_users WHERE email= '$email'", $con), 0);
		$num_class_plus= $num_class +1;

		//check if k+1th class column already exists
		$check_col= "SELECT * FROM information_schema.columns WHERE table_schema= 'harlin+db1' AND table_name= 'all_users' AND column_name= 'class$num_class_plus'";
		if(mysql_num_rows(mysql_query($check_col, $con))==0)
		{
			//add k+1th class column
			$add_class= "ALTER TABLE all_users ADD class$num_class_plus VARCHAR(10) AFTER class$num_class";
			mysql_query($add_class, $con) or die("Class column not added: ".mysql_error());
		}		

		//update the k+1th class column
		$insert_c= "UPDATE all_users SET class$num_class_plus= '$class_code' WHERE email= '$email'";
		mysql_query($insert_c, $con) or die ("Could not update the class column: ".mysql_error());

		//increase num_class by one
		mysql_query("UPDATE all_users SET num_class= '$num_class_plus' WHERE email= '$email'", $con) or die("num_class not increased: ".mysql_error());

		//inform student
		$class=mysql_result(mysql_query("SELECT class FROM all_classes WHERE class_code='$class_code' AND school='$school'"), 0);
		$class_num=mysql_result(mysql_query("SELECT class_number FROM all_classes WHERE class_code='$class_code' AND school='$school'"), 0); 
		$class_des= mysql_result(mysql_query("SELECT class_description FROM all_classes WHERE class_code='$class_code' AND school='$school'"), 0);

		echo "You are now registered for <strong>$class_num ($class)</strong> :</br>";
		echo "$class_des</br></br>";
		echo "<a href='profile.php'>Return to profile</a>";
	}
	else echo "wrong";

}
?>