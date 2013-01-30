<?php

//connect to and select database
$con= mysql_connect("sql.mit.edu", "harlin", "freshman") or die("Cannot connect to database: ".mysql_error());
mysql_select_db("harlin+db1", $con) or die("Cannot select database: ".mysql_error());

$type = $_POST["type"];
$name = $_POST["name"];
$class_code= $_POST["class_code"];
$date= date('M d, Y');

//get class name and number
$get_c= "SELECT class FROM all_classes WHERE class_code= '$class_code'";
$class= mysql_result(mysql_query($get_c, $con), 0);

$get_cn= "SELECT class_number FROM all_classes WHERE class_code= '$class_code'";
$class_n= mysql_result(mysql_query($get_cn, $con), 0);

include_once('../tcpdf/config/lang/eng.php');
include_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Brocode');
$pdf->SetTitle("$class_code vocab");
$pdf->SetSubject('vocab');
$pdf->SetKeywords("TCPDF, PDF, $class_code");

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// set font
$pdf->SetFont('times', '', '11');

// add a page
$pdf->AddPage();

$html= "<h3> $class_n $class Vocab list</h3>
	<h4>$date</h4>
	<dl>";

$pdf->writeHTML($html, true, false, false, false, 'C');
//--------------------------------------------------


$num_rows= mysql_num_rows(mysql_query("SELECT * FROM vocab$class_code", $con));
if($num_rows==0)
{
	//create 15 blank rows
	for($whatever=0; $whatever<15; $whatever++)
	{
		mysql_query("INSERT INTO vocab$class_code (editing) VALUES (0)", $con) or die("blank rows not added: ".mysql_error());
	}
}

for($m= 1; $m<= $num_rows ; $m++)
{
	//check what's already in the vocab column
	$check_v= "SELECT vocab FROM vocab$class_code WHERE Id= '$m'";
	$voca= mysql_result(mysql_query($check_v, $con), 0);

	//check what's already in the definition column
	$check_d= "SELECT definition FROM vocab$class_code WHERE Id= '$m'";
	$def= mysql_result(mysql_query($check_d, $con), 0);

	//check if something's in the editing stage
	$check_e= "SELECT editing FROM vocab$class_code WHERE Id= '$m'";
	$editing= mysql_result(mysql_query($check_e, $con), 0);

        //check the editor name
	$check_er= "SELECT editor FROM vocab$class_code WHERE Id= '$m'";
	$editor= mysql_result(mysql_query($check_er, $con), 0);

	echo "<form method= 'POST'>";

	if ($voca== NULL && $def== NULL)
	{
		//no vocab- show vocab textbox
		echo "$m)&nbsp&nbsp<input type= 'text' class= 'word' name= 'vocab$m'><button type='submit' title= 'Post vocab' class='submit_word btn btn-link btn-mini' id='w$m' name= 'word$m'><i class='icon-ok-sign'></i></button>";
	}
	else if ($voca!= NULL && $def== NULL)
	{
		//yes vocab but no definition- show vocab data and definition textbox
		echo "$m)&nbsp&nbsp<strong>$voca</strong> : <textarea rows='1' cols='40' class= 'def' name='definition$m'></textarea><button type='submit' title='Post definition' class='submit_def btn btn-link btn-mini' id='d$m' name= 'def$m'><i class='icon-ok-sign'></i></button><button title='Delete word' type='submit' class='delete_word btn btn-link btn-mini' id='de$m' name= 'delete$m'><i class='icon-remove'></i></button>";
	}
	else if ($voca != NULL && $editing== '1' && $editor== $name)
	{
		//yes vocab & things in editing stage
		echo "$m)&nbsp&nbsp<strong>$voca</strong> : <textarea rows='1' cols='40' class= 'def' name='definition$m'>$def</textarea><button type='submit' title= 'Post definition' class='submit_def btn btn-link btn-mini' id='d$m' name= 'def$m'><i class='icon-ok-sign'></i></button>";
	}
        else if ($voca != NULL && $editing== '1' && $editor != $name)
	{
		//yes vocab & things in editing stage
		echo "$m)&nbsp&nbsp<strong>$voca</strong> : Currently being edited";
	}
	else 
	{
		//yes vocab and yes definition- show vocab and definition data
		echo "$m)&nbsp&nbsp<strong>$voca</strong> : $def&nbsp<button type='submit' title= 'Edit definition'class='edit btn btn-link btn-mini' id='e$m' name= 'edit$m'><i class='icon-pencil'></i></button><button type='submit' class='delete_word btn btn-link btn-mini'  title='Delete word' id='de$m' name= 'delete$m'><i class='icon-remove'></i></button><br/><small><em>Last edited by </em>$editor</small>";

		//add to pdf
		$html= "<dt><h4>$m) $voca </h4></dt>
			<dd>$def</dd>";
		$pdf-> writeHTML($html, true, false, false, false, '');
	}
	echo "</form>";
}
echo "<form method= 'POST'><button type= 'submit' class= 'btn pull-right btn-success' id='more'>Add more words!</button></form>";

$when= date('ymd');
$html= '</dl>';
$pdf-> writeHTML($html, true, false, false, false, '');

$pdf-> Output("../$class_code/$when v.pdf", 'F');

?>
