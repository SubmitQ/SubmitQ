<?php
SESSION_START();

//if the user is not logged in, redirect to the login page
if(!isset($_SESSION["UserType"]))
{
	header("location: index.php");
}

$code= $_GET["code"];
//Show their name
$first_name= $_SESSION['First_name'];
$last_name= $_SESSION['Last_name'];
$name= "$first_name $last_name";
?>

<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>

<script type="text/javascript">
var code= '<?php echo $code; ?>';

$(document).ready(function(){
    var dataString = 'code=' + code;
    //alert(dataString);
    $.ajax({
            type: "POST",
            url: "http://harlin.scripts.mit.edu/submitq/classes/feedback/check_feedback.php",
            data: dataString,
            success: function(html){
                $('#feedback_display').html(html);
            },
            error: function(html){
                alert("error");
            }
    });
    return false;
})

$(function(){
setInterval(function() { // display questions when page loads
	var dataString = 'code=' + code;
        //alert(dataString);
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/feedback/check_feedback.php",
		data: dataString,
		success: function(html){
		    $('#feedback_display').html(html);
		},
                error: function(html){
                    alert("error");
                }
	});
	return false;
}, 5000);

setInterval(function() { // display questions when page loads
	var dataString = 'code=' + code;
        //alert(dataString);
            $.ajax({
                type: "POST",
                url: 'http://harlin.scripts.mit.edu/submitq/classes/feedback/check_feedback2.php',
                data: dataString,
                success: function(html){
                    if (html == "fast"){
                        /*$(function() {
                           $("#fast").dialog();
		    });*/
			  //  <div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Professor, you are talking too fast!</strong></div>;
                        alert("Professor, you are talking too fast!");
                    }
                    else if (html == "slow"){
                        /*$(function() {
                            $("#slow").dialog();
                        });*/
                        alert("Professor, you are talking too slow!");
                    }
                }
            })
	return false;
}, 5000);
})             

</script>

<div id="alert">
    <h2>Class Feedback</h2>
    <div id="feedback_display"></div>
</div>
