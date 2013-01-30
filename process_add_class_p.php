<?php

$con = mysql_connect("sql.mit.edu","harlin","freshman");
if (!$con)
{
	die('Could not connect:'.mysql_error());
}

//select database
mysql_select_db("harlin+db1",$con) or die("Cannot select the Database".mysql_error());

if($_POST)
{
	//retrieve variables
	$first_name=$_POST["first_name"];
	$last_name=$_POST["last_name"];
	$email= $_POST["email"];

	$school=mysql_real_escape_string($_POST["school"]);
	$class=mysql_real_escape_string($_POST["class_name"]);
	$class_num=$_POST["class_num"];
	$class_des=mysql_real_escape_string($_POST["class_des"]);
	$lecture_len=$_POST["lecture_len"];

	//generate a random class code
	$str="ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	$class_code= substr(str_shuffle($str), 0, 5);

	//update all_classes data
	$update="INSERT INTO all_classes VALUES ('$first_name','$last_name','$school','$class','$class_num','$class_des','$lecture_len','$class_code',0)";
	mysql_query($update, $con) or die("Update failed: ".mysql_error());

	//create roll-call table for the class
	$create="CREATE TABLE roll_call$class_code(first_name varchar(100),last_name varchar(100), usertype varchar(40), email varchar(100), PRIMARY KEY(email))";
	mysql_query($create, $con) or die("roll-call table for $class failed:".mysql_error());

	//add the professor to the roll-call table
	$add= "INSERT INTO roll_call$class_code VALUES ('$first_name', '$last_name', 'Professor','$email')";
	mysql_query($add,$con) or die("could not update database: ".mysql_error());
	mysql_query("INSERT INTO feedback VALUES (0,0,'$class_code')", $con);

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

	//create folder for class
	mkdir("classes/$class_code");

	//create php file for the class
	$data["class_code"]= $class_code;
	$data["school"]= $school;
	$data["class"]= $class;
	$data["class_num"]= $class_num;
	
	$tpl_file= "template.php";
	$tpl_path= "/afs/athena.mit.edu/user/h/a/harlin/web_scripts/submitq/";
	$class_path= "/afs/athena.mit.edu/user/h/a/harlin/web_scripts/submitq/classes/";

	$placeholders= array("{class_code}", "{school}", "{class}", "{class_num}");
	$tpl= file_get_contents($tpl_path.$tpl_file);
	$new_class_file= str_replace($placeholders, $data, $tpl);
	$php_file_name= $data['class_code'].".php";

	$fp= fopen($class_path.$php_file_name, "w");
	fwrite($fp, $new_class_file);
	fclose($fp);

	//create a question table for the class 
	$create_q= "CREATE TABLE question$class_code (q_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, question TEXT, asker VARCHAR(100), answer0 VARCHAR(100), answerer0 VARCHAR(100), upvotes INT(11) DEFAULT 0, num_answers INT(11) DEFAULT 0, written_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
	mysql_query($create_q, $con) or die("can't create question table for class: ".mysql_error());

	//create a vocab table for the class
	$create_v= "CREATE TABLE vocab$class_code (Id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT, vocab VARCHAR(100), definition TEXT, editing INT(11), editor VARCHAR(250))";
	mysql_query($create_v, $con) or die("can't create vocab table for class: ".mysql_error());

        		$to = $email;
			$subject = "Your class details on SubmitQ";
			$message = "
<html>
<head>
</head>
<body>
Dear $first_name $last_name,
<br /><br />You have recently created a class on SubmitQ. Here are your class details:
<br /><br />School: $school
<br />Class Number: $class_num
<br />Class Name: $class
<br />Class Description: $class_des
<br />Lecture Time: $lecture_len hour(s)
<br /><br />
Please give the following details to your students and TAs to enable them to enroll in your class:
<br /><br /><strong>Class Code: $class_code</strong>
<br /><strong>School: $school</strong>
<br /><br />You will be able to access your class when you <a href='http://harlin.scripts.mit.edu/submitq'>login</a> and go to your profile page. We hope you will enjoy your experience with SubmitQ!
<br /><br />Thank you,
<br />The SubmitQ Team
</body>
</html>
";
			$from = "SubmitQ";
			// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From:" . $from;
			mail($to,$subject,$message,$headers);

	//inform professor
	echo "<font size='4'>The class code for your class <i>$class</i> at $school is: <strong>$class_code</strong> <br /><br /> Please give your students and TAs this class code so that they can register for your course. An email containing your class information and class code has been sent to $email.</font></br>";
	echo "</br>";
	echo "<a href='profile.php'><font size='4'>Return to profile</font></a>";
}
?>