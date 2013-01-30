<div id="vocab">
<h2>Vocab Words</h2>
</div>

<?php
$first_name= $_SESSION['First_name'];
$last_name= $_SESSION['Last_name'];
$name= "$first_name $last_name";

$n= 16;

//when AJAX works this should work...
if(isset($_POST["more"]))
{
	$n= $n+5;
}

for($m= 1; $m< $n; $m++)
{
	//check what's already in the vocab column
	$check_v= "SELECT vocab FROM vocab WHERE Id= '$m'";
	$voca= mysql_result(mysql_query($check_v, $con), 0);

	//check what's already in the definition column
	$check_d= "SELECT definition FROM vocab WHERE Id= '$m'";
	$def= mysql_result(mysql_query($check_d, $con), 0);

	//check the editor name
	$check_er= "SELECT editor FROM vocab WHERE Id= '$m'";
	$editor= mysql_result(mysql_query($check_er, $con), 0);

	//check if something's in the editing stage
	$check_e= "SELECT editing FROM vocab WHERE Id= '$m'";
	$editing= mysql_result(mysql_query($check_e, $con), 0);

	if ($voca== NULL && $def== NULL)
	{
		//no vocab- show vocab textbox
		echo "<form action='".$_SERVER['PHP_SELF']."' method= 'POST'>$m)&nbsp&nbsp<input type= 'text' name= 'vocab$m'><input type= 'submit' name= 'word$m' value= 'Post vocab'>";
	}
	else if ($voca!= NULL && $def== NULL)
	{
		//yes vocab but no definition- show vocab data and definition textbox
		echo "<form action='".$_SERVER['PHP_SELF']."' method= 'POST'>$m)&nbsp&nbsp$voca : <textarea rows='1' cols='40' name='definition$m'></textarea><input type= 'submit' name= 'def$m' value= 'Post definition'>";
	}
	else if ($voca != NULL && $editing== '1')
	{
		//yes vocab & things in editing stage
		echo "<form action='".$_SERVER['PHP_SELF']."' method= 'POST'>$m)&nbsp&nbsp$voca : <textarea rows='1' cols='40' name='definition$m'>$def</textarea><input type= 'submit' name= 'def$m' value= 'Post definition'>";
	}
	else 
	{
		//yes vocab and yes definition- show vocab and definition data
		echo "<form action='".$_SERVER['PHP_SELF']."' method= 'POST'>$m)&nbsp&nbsp$voca : $def&nbsp<input type= 'submit' name= 'edit$m' value= 'Edit definition'>Last edited by $editor</br>";
	}
	
	if($_SESSION["UserType"]== 'T' || $_SESSION["UserType"]== 'P')
	{
		echo "<input type= 'submit' name= 'delete$m' value= 'Delete'>";
	}
	echo "</form>";

	if(isset($_POST["delete$m"]))
	{
		$delete_v= "DELETE FROM vocab WHERE Id= $m";
		mysql_query($delete_v, $con) or die("can't delete vocab: ".mysql_error());
		for($k=$m+1; $k< $n; $k++)
		{
			//decrease Id by 1 for all entries after $m
			$k_minus= $k-1;
			mysql_query("UPDATE vocab SET Id= $k_minus WHERE Id= $k", $con) or die("can't decrease Id: ".mysql_error());
		}
	}
	
	if(isset($_POST["edit$m"]))
	{
		//change editing status
		$change_e= "UPDATE vocab SET editing= '1' WHERE Id= $m";
		mysql_query($change_e, $con) or die("can't change editing status: ".mysql_error());
		
		//AJAX??
		header("location: ".$_SERVER['PHP_SELF']."");
	}

	if(isset($_POST["word$m"]))
	{
		$vocab= $_POST["vocab$m"];

		//insert vocab and Id into table vocab
		$insert_v= "INSERT INTO vocab(Id, vocab) VALUES ('$m', '$vocab')";
		mysql_query($insert_v, $con) or die("can't insert vocab: ".mysql_error());
		
		//use AJAX?
		header("location: ".$_SERVER['PHP_SELF']."");
	}

	if(isset($_POST["def$m"]))
	{
		$defi= $_POST["definition$m"];

		//insert definition into table vocab
		$insert_d= "UPDATE vocab SET definition= '$defi' WHERE Id= $m";
		mysql_query($insert_d, $con) or die("can't insert definition: ".mysql_error());

		//insert editor name into table vocab
		$insert_e= "UPDATE vocab SET editor= '$name' WHERE Id= $m";
		mysql_query($insert_e, $con) or die("can't add editor name: ".mysql_error());

		//change editing status back to 0
		$return_e= "UPDATE vocab SET editing= '0' WHERE Id= $m";
		mysql_query($return_e, $con) or die ("can't change editing status back: ".mysql_error());

		//use AJAX?
		header("location: ".$_SERVER['PHP_SELF']."");
	}
}
echo "<form action='".$_SERVER['PHP_SELF']."' method= 'POST'> </br> <input type= 'submit' value= 'Add more vocabs!' name= 'more'></form>"

?>


