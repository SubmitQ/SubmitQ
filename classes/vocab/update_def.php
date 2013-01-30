<?php
$con= mysql_connect("sql.mit.edu", "harlin", "freshman") or die("Cannot connect to database: ".mysql_error());
mysql_select_db("harlin+db1", $con) or die("Cannot select database: ".mysql_error());
$class_code= $_POST["class_code"];
   
 if($_POST)
    {
	$def= mysql_real_escape_string($_POST["def"]);
	$name = $_POST["name"];
        $dID= $_POST["dID"];
        $d = +substr($dID, 1);
	
	//insert definition into table vocab
	$insert_d= "UPDATE vocab$class_code SET definition= '$def' WHERE Id= $d";
	mysql_query($insert_d, $con) or die("can't insert definition: ".mysql_error());

	//insert editor name into table vocab
	$insert_e= "UPDATE vocab$class_code SET editor= '$name' WHERE Id= $d";
	mysql_query($insert_e, $con) or die("can't add editor name: ".mysql_error());

	//change editing status back to 0
	$return_e= "UPDATE vocab$class_code SET editing= '0' WHERE Id= $d";
	mysql_query($return_e, $con) or die ("can't change editing status back: ".mysql_error());
		
    }
?>

<?php include 'display_vocab.php' ?>