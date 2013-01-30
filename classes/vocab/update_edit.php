<?php
$con= mysql_connect("sql.mit.edu", "harlin", "freshman") or die("Cannot connect to database: ".mysql_error());
mysql_select_db("harlin+db1", $con) or die("Cannot select database: ".mysql_error());
$class_code= $_POST["class_code"];

    if($_POST)
    {
	$name = $_POST["name"];
        $eID= $_POST["eID"];
        $e = +substr($eID, 1);

	//change editing status
	$change_e= "UPDATE vocab$class_code SET editing= '1' WHERE Id= $e";
	mysql_query($change_e, $con) or die("can't change editing status: ".mysql_error());
	
	$insert_e= "UPDATE vocab$class_code SET editor= '$name' WHERE Id= $e";
	mysql_query($insert_e, $con) or die("can't add editor name: ".mysql_error());
    }

?>

<?php include 'display_vocab.php' ?>