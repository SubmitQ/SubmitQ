<?php
$con= mysql_connect("sql.mit.edu", "harlin", "freshman") or die("Cannot connect to database: ".mysql_error());
mysql_select_db("harlin+db1", $con) or die("Cannot select database: ".mysql_error());
$class_code= $_POST["class_code"];

    if($_POST)
    {
	$vocab= mysql_real_escape_string($_POST["word"]);
        $wID= $_POST["wID"];
        $m = +substr($wID, 1);

	//insert vocab and Id into table vocab
	$insert_v= "UPDATE vocab$class_code SET vocab= '$vocab' WHERE Id= $m";
	mysql_query($insert_v, $con) or die("can't insert vocab: ".mysql_error());
      //  echo "alert($vocab)";
		
    }
?>

<?php include 'display_vocab.php' ?>
