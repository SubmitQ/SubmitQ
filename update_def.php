<?php
$con= mysql_connect("sql.mit.edu", "harlin", "freshman") or die("Cannot connect to database: ".mysql_error());
mysql_select_db("harlin+db1", $con) or die("Cannot select database: ".mysql_error());
    if($_POST)
    {
	$def= $_POST["def"];
        $dID= $_POST["dID"];
        $d = +substr($dID, 1);
        echo $m;

	//insert vocab and Id into table vocab
	$insert_v= "INSERT INTO vocab(definition) VALUES ('$def')";
	mysql_query($insert_v, $con) or die("can't insert vocab: ".mysql_error());
		
    }
?>

<?php include 'display_vocab.php' ?>