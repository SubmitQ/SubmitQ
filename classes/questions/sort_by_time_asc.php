<?php
session_start();
$con = mysql_connect("sql.mit.edu", "harlin", "freshman") or die("Cannot connect to database: ".mysql_error());
mysql_select_db("harlin+db1", $con) or die("Cannot select database: ".mysql_error());

$_SESSION["Sort"]= '2';
$class_code= $_POST['class_code'];

$name = $_POST['name'];
$type = $_POST['type'];

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
$pdf->SetTitle("$class_code question");
$pdf->SetSubject('question');
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
$html= "<h3> $class_n $class Questions list</h3>
	<h4>$date</h4>
	<dl>";
$pdf->writeHTML($html, true, false, false, false, 'C');

$num_row = mysql_num_rows(mysql_query("SELECT * FROM question$class_code"));
$num_col= (mysql_result(mysql_query("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema= 'harlin+db1' AND table_name = 'question$class_code'", $con), 0) -6)/2;

for($n= 0; $n< $num_row; $n++)
{
//oldest question goes to top 
    $q_id= mysql_result(mysql_query("SELECT q_id FROM question$class_code ORDER BY written_at ASC", $con), $n);
    $qs = mysql_result(mysql_query("SELECT question FROM question$class_code WHERE q_id = '$q_id'", $con), 0);
    $ask = mysql_result(mysql_query("SELECT asker FROM question$class_code WHERE q_id ='$q_id'", $con), 0);
    $time = mysql_result(mysql_query("SELECT written_at FROM question$class_code WHERE q_id='$q_id'", $con), 0);
    $upvote = mysql_result(mysql_query("SELECT upvotes FROM question$class_code WHERE q_id='$q_id'", $con), 0);
    
    echo "<li class='qs' id='q$q_id'>";
    echo "<form method='POST'>";   

    //show the yellow star if answer0 is '1'
    $starred= mysql_result(mysql_query("SELECT answer0 FROM question$class_code WHERE q_id='$q_id'", $con), 0);
    $starer= substr(mysql_result(mysql_query("SELECT answerer0 FROM question$class_code WHERE q_id='$q_id'", $con), 0), 0, -4);
    
    if($starred=='1') 
   {   
	   echo "<img src= 'http://harlin.scripts.mit.edu/submitq/classes/questions/yellow-star-md.png' alt='star' height='35px' width='35px' title= 'Starred by $starer'>";
   }

    //show upvote number, upvote icon and question
    echo "&nbsp $upvote<button title='Upvote this question' type='submit' class='upvote btn btn-mini btn-link' id='u$q_id' name= 'upvote$q_id'><i class='icon-thumbs-up'></i></button><blockquote class='questions'>$qs";

    //if user is professor or TA, show icon for starring question

    if($type=="P" || $type=="T")
    {    
	if($starred== 0)
    	{
        	echo "<button title='Star this question!' type='submit' class='pull-right star_q btn btn-mini btn-link' id='s$q_id' name='star$q_id'><i class='icon-star'></i></button>";	
	}
        if($starred== 1)
	{
		echo "<button title='Un-star this question' type='submit' class='pull-right unstar_q btn btn-mini btn-link' id='us$q_id' name='unstar$q_id'><i class='icon-star-empty'></i></button>";	
	}
    }

    	//if the user is logged in as a professor or a TA, or if the user is the questioner show the delete button next to the question
	if($type == "P" || $type == "T" || $ask == $name)
	{
		echo "<button title='Delete question' type='submit' class='pull-right delete btn btn-mini btn-link' id='d$q_id' name= 'delete$q_id'><i class='icon-remove'></i></button>";
	} 
	
	//show questioner and time the question was posted
	echo "<span class='questioner'><small> $ask</small></span></blockquote>Posted at: $time</form>";
    echo '</li>';

	$num= $n+1;

    //put question into pdf
    $html= "<dd></dd><dt>$num. $qs</dt>";
    $pdf->writeHTML($html, true, false, false, false, '');

//	echo "<div class= 'answerss'>";
	
    	//show all answers written for the question
	for($i= 1; $i<= $num_col; $i++)
	{
		$show_a= mysql_result(mysql_query("SELECT answer$i FROM question$class_code WHERE q_id ='$q_id'"), 0);
		
		if($show_a != '')
		{
			//show the little arrow icon in front of the answer
			$x= $i;
			while($x> 0)
			{
				echo "&nbsp";			
				$x = $x -1;
			}		
			echo "<i class='icon-arrow-right'></i>&nbsp&nbsp$show_a";
			//show answerer
			$show_ar= mysql_result(mysql_query("SELECT answerer$i FROM question$class_code WHERE q_id= '$q_id'"), 0);
			echo "&nbsp <span class= 'answerer'>by <em>$show_ar</em></span>";

			//if user is answerer, show delete button for answer
			if($name==$show_ar || $type== "P" || $type== "T")
			{
				echo"<button title='Delete' type='submit' class='delete_ans btn btn-mini btn-link' id='da$q_id' name= 'deletea$i'><i class='icon-remove'></i></button>";
			}
			echo "</br>";

			//add answer to pdf					
			$html= "<dd>> $show_a</dd>";

			$pdf->writeHTML($html, true, false, false, false, '');
		}
	}	

	//show the answer textbox after each unit of Q&A
	echo "<div class= 'answertext input-append'><form method= 'POST'> <input type='text' name= 'answer' class='span6 ans'><button type= 'submit' name= 'answer$q_id' class='btn btn-info answer' id= 'a$q_id'>Answer</button></form></div></br>";
}


$when= date('ymd');
$html= '</dl>';
$pdf-> writeHTML($html, true, false, false, false, '');

$pdf-> Output("../$class_code/$when q.pdf", 'F');

?>

