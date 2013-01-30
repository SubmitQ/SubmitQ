<?php
$con= mysql_connect("sql.mit.edu", "harlin", "freshman") or die("Cannot connect to database: ".mysql_error());
mysql_select_db("harlin+db1", $con) or die("Cannot select database: ".mysql_error());
$class_code= $_POST["class_code"];
   
    if($_POST)
    {
	//create 5 blank rows
	for($w=0; $w<5; $w++)
	{
		mysql_query("INSERT INTO vocab$class_code (editing) VALUES (0)", $con) or die("blank rows not added: ".mysql_error());
	}
    }
?>

<?php include 'display_vocab.php' ?>
