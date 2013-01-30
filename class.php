<!DOCTYPE HTML>
<head>
<title>Questions</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>

<body>
<link rel="stylesheet" type="text/css" href="submit_q.css">

<?php
SESSION_START();

//if the user is not logged in, redirect to the login page
if(!isset($_SESSION["UserType"]))
{
	header("location: index.php");
}

//Show their name
$first_name= $_SESSION['First_name'];
$last_name= $_SESSION['Last_name'];
$name= "$first_name $last_name";
echo "This is a secured page with session: <b>$name</b> </br></br>";

//is the user is registered in this class?
//check with the cookie...

//connect to and select database
$con= mysql_connect("sql.mit.edu", "harlin", "freshman") or die("Cannot connect to database: ".mysql_error());
mysql_select_db("harlin+db1", $con) or die("Cannot select database: ".mysql_error());

//get number of questions(rows) and number of answer columns
$num_row= mysql_num_rows(mysql_query("SELECT* FROM Questions"));
$num_col= (mysql_result(mysql_query("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema= 'harlin+db1' AND table_name = 'Questions'", $con), 0) -6)/2;

//show questions and answers in the order of Q1-A1-A2, Q2-A1-A2, Q3-A1-A2...
for($n= 0; $n< $num_row; $n++)
{
	//Show Q1, Q2, Q3 in descending order of # of upvotes
	//if Q have same # of upvotes, go by descending timestamp(newest goes to the top)  
	$show_q= mysql_result(mysql_query("SELECT Question FROM Questions ORDER BY Upvote DESC, written_at DESC"), $n);
	$qs= mysql_real_escape_string($show_q);

	//if the question has been deleted, show that statement in smaller font& italicized
	if($show_q == 'This question has been deleted by the moderators.')
	{
		echo "<form action= 'class.php' method= 'POST'><span class= 'deleted'><i>$show_q</i></span>";		
	}

	//if not, just show the original question and questioner
	else
	{
		echo "<form action= 'class.php' method= 'POST'><span class= 'questions'>$show_q</span>";
		$show_qr = mysql_result(mysql_query("SELECT Questioner FROM Questions WHERE Question ='$qs'", $con), 0);
		echo "&nbsp<span class= 'questioner'>by $show_qr</span>";
	}

	//if the user is logged in as a professor or a TA, or if the user is the questioner show the delete button next to the question
	if($_SESSION["UserType"] == "P" || $_SESSION["UserType"] == "T" || $show_qr == $name)
	{
		echo "&nbsp <input type='submit' name='delete$n' value='Delete'>";
	}
	
	echo "</form>";

	//show timestamp
	$time = mysql_result(mysql_query("SELECT written_at FROM Questions WHERE Question='$qs'", $con), 0);
	echo "<form action= 'class.php' method= 'POST'>$time";
		
	//show number of upvotes and the upvote button
	$upvote = mysql_result(mysql_query("SELECT Upvote FROM Questions WHERE Question='$qs'", $con), 0);
        echo "&nbsp * $upvote <input type='submit' name= 'upvote$n' value= 'Upvote!'></form>";
	
	//show all answers written for the question
	for($i= 1; $i<= $num_col; $i++)
	{
		$show_a= mysql_result(mysql_query("SELECT Answer$i FROM Questions WHERE Question ='$qs'"), 0);
		
		if($show_a != '')
		{
			//show the little level down arrow icon font in front of the answer
			$x= $i;
			while($x> 0)
			{
				echo "&nbsp";			
				$x = $x -1;
			}		
			echo "<i class='icon-level-down'></i>";
			echo "$show_a";

			//show answerer
			$show_ar= mysql_result(mysql_query("SELECT Answerer$i FROM Questions WHERE Question= '$qs'"), 0);
			echo "&nbsp <span class= 'answerer'>by $show_ar</span></br>";
		}
	}	

	//show the answer textbox after each unit of Q&A
	echo "<form action= 'class.php' method= 'POST'> <textarea  name= 'answer'></textarea> <input type= 'submit' name= 'answer$n' value= 'Post Answer'></form></br>";
}

//get the question and questioner into the database
if(isset($_POST["submit_q"]))
{
	$qs= mysql_real_escape_string($_POST['qs']);

	//check if the questioner checked the anonymous box
	if(isset($_POST["anonymous"]))
	{
		$qsr= 'Anonymous';
	}
	else
	{
		$qsr= $name;
	}

	//add question and questioner to table 'questions'
    	$insert_q= "INSERT INTO Questions(Question, Questioner) VALUES ('$qs','$qsr')";
	mysql_query($insert_q, $con) or die("Couldn't update question and/or questioner: ".mysql_error());
	
        //this part of code will be improved when we figure out AJAX
	header("location: class.php");
}

//delete inappropriate questions
for($n= 0; $n< $num_row; $n++)
{
	if(isset($_POST["delete$n"]))
	{
		//get the original question
		$qs= mysql_real_escape_string(mysql_result(mysql_query("SELECT Question FROM Questions ORDER BY Upvote DESC, written_at DESC", $con), $n));
		
		//replace the question with 'this question has been deleted'
		$delete_q= "UPDATE Questions SET Question= 'This question has been deleted by the moderators.' WHERE Question='$qs'";
		mysql_query($delete_q, $con) or die("Question not deleted: ".mysql_error());

		//this section might be improved by using AJAX
		header("location: class.php");
	}
}

//get the upvote into the database
for($n=0; $n< $num_row; $n++)
{
    if(isset($_POST["upvote$n"]))
    {
	//get the original question to make our lives easier
	$qs= mysql_real_escape_string(mysql_result(mysql_query("SELECT Question FROM Questions ORDER BY Upvote DESC, written_at DESC", $con), $n));
	
	//get the number of upvote for the question
    	$upvote= mysql_result(mysql_query("SELECT Upvote FROM Questions WHERE Question='$qs'", $con), 0);    	
	$upvote_plus= $upvote +1;

	//increase the number of upvote for the question
	mysql_query("UPDATE Questions SET Upvote = '$upvote_plus' WHERE Question= '$qs'", $con) or die("Couldn't update upvote: ".mysql_error());

	//this part should be improved when we figure out AJAX
	header("location: class.php");
    }   
}

//put the answer into the database
for($n= 0; $n< $num_row; $n++)
{
	if(isset($_POST["answer$n"]))
	{
		$ans= mysql_real_escape_string($_POST["answer"]);

		//get the original question to make our lives easier
		$qs= mysql_real_escape_string(mysql_result(mysql_query("SELECT Question FROM Questions ORDER BY Upvote DESC, written_at DESC", $con), $n));

		//count how many times the question has already been answered(=k)
		$num_ans= mysql_result(mysql_query("SELECT Num_ans FROM Questions WHERE Question='$qs'", $con),0);
		$num_ans_plus= $num_ans +1;

		//check if k+1th answer column already exists
		$check_col= "SELECT * FROM information_schema.columns WHERE table_schema= 'harlin+db1' AND table_name = 'Questions' AND column_name = 'Answer$num_ans_plus'";
		if(mysql_num_rows(mysql_query($check_col, $con))==0)
		{
			//add k+1th answer column
			$add_ans= "ALTER TABLE Questions ADD Answer$num_ans_plus TEXT(1000) AFTER Answerer$num_ans";
			mysql_query($add_ans, $con) or die("Answer column not added: ".mysql_error());

			//add k+1th answerer column
			$add_ansr= "ALTER TABLE Questions ADD Answerer$num_ans_plus VARCHAR(100) AFTER Answer$num_ans_plus";
			mysql_query($add_ansr, $con) or die("Answerer column not added: ".mysql_error());
		}

		//update the answer in k+1th answer column
		$insert_a= "UPDATE Questions SET Answer$num_ans_plus='$ans' WHERE Question= '$qs'";
		mysql_query($insert_a, $con) or die("Could not update the answer: ".mysql_error()); 

		//update the answerer in k+1th answerer column
		$insert_ar= "UPDATE Questions SET Answerer$num_ans_plus='$first_name $last_name' WHERE Question= '$qs'";
		mysql_query($insert_ar, $con) or die("Could not update the answerer: ".mysql_error());

		//add one to num_ans
		mysql_query("UPDATE Questions SET Num_ans= '$num_ans_plus' WHERE Question= '$qs'", $con);

		//this section should be updated later with AJAX
		header("location: class.php");
	}
}

?>
<form action= "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
<b>Questions:</b>
<input type= "checkbox" name= "anonymous" value= "Anonymous"> Anonymous</br>
<textarea rows="7" cols="40" name = "qs"> </textarea>
<input type= "submit" name= "submit_q" value= "POST QUESTION">
</form>

</body>
</html>
