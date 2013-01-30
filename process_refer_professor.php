<?php
//retreive information if the form is submitted
if($_POST)
{
	//select database
	$name = $_POST['name'];
	$prof_name = $_POST['prof_name'];
	$prof_email = $_POST['prof_email'];
	$school = $_POST['school'];
	$class_name = $_POST['class_name'];
	$class_num = $_POST['class_num'];
	
			$to = $prof_email;
			$subject = "$name has invited you to create a class on SubmitQ";
			$message = "
<html>
<head>
</head>
<body>
Dear $prof_name,
<br /><br />$name has invited you to register $class_num ($class_name) at $school on <a href='http://harlin.scripts.mit.edu/submitq'>SubmitQ</a>
<br /><br />SubmitQ seeks to facilitate interactions between students and faculty in class by encouraging students to ask questions to the faculty, comment on on their colleague's questions, and collaborate with each other in notetaking.
<br /><br />If you would like to create an account or learn more about our site, please click <a href='http://harlin.scripts.mit.edu/submitq'>here</a> to learn more about what SubmitQ has to offer.
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
			echo "Thank you for your referral. We have sent an email to $prof_email requesting him or her to join SubmitQ. <br /><br /><a href='index.php'>Return to homepage</a>";

        

}


?>