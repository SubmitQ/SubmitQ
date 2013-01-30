<?php
$con= mysql_connect("sql.mit.edu", "harlin", "freshman") or die("Cannot connect to database: ".mysql_error());
mysql_select_db("harlin+db1", $con) or die("Cannot select database: ".mysql_error());
$class_code= $_POST["class_code"];
   

    if($_POST)
    {
	$deID= $_POST["deID"];
        $de = +substr($deID, 2);
	
	$delete_v= "DELETE FROM vocab$class_code WHERE Id= $de";
	mysql_query($delete_v, $con) or die("can't delete vocab: ".mysql_error());
	
	$result = mysql_query("SELECT * FROM vocab$class_code", $con);
	$n = mysql_num_rows($result);
	
	for($k=$de+1; $k< $n; $k++)
	{
	    //decrease Id by 1 for all entries after $m
	    $k_minus= $k-1;
	    mysql_query("UPDATE vocab$class_code SET Id= $k_minus WHERE Id= $k", $con) or die("can't decrease Id: ".mysql_error());
	}
    }

?>

<?php include 'display_vocab.php' ?>