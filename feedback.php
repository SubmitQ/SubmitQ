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

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
    
    var code= '<?php echo $code; ?>';
    
    $(function(){
        $('#alert_professor').click(function(){

            if ($("input[name='feedback']:checked").size()==0) { //Make sure an option is selected
                $('#feedback_response').html('You must select one of the options');
            }
            else{
                var choice = $('input:radio[name=feedback]:checked').val();
                var dataString = "choice=" + choice + "&code=" + code;
                $.ajax({
                    type: "POST",
                    url: "http://harlin.scripts.mit.edu/submitq/update_feedback.php",
                    data: dataString,
                    success: function(html){
                        $('#feedback_response').html(html);
                    }
                });
            }
            return false;
        })
    })
</script>

<div id="feedback">
<h2>Feedback</h2>
Pace of the lecture
<form method="POST">
    <input type="radio" name="feedback" value="fast">Too fast
    <input type="radio" name="feedback" value="slow">Too slow
    <input type="submit" name="alert_professor" id="alert_professor" value="Alert Professor">
</form>
<div id="feedback_response"></div>
</div>

<?php/*
    $slow_status = 'unchecked';
    $fast_status = 'unchecked';
//session_start(); // Shows we are using sessions 
//connect to database

	$mysql_host = "sql.mit.edu";
	$mysql_database = "harlin+db1";
	$mysql_user = "harlin";
	$mysql_password = "freshman";
	
$con = mysql_connect($mysql_host,$mysql_user,$mysql_password);
if (!$con)
{
	die('Could not connect:'.mysql_error());
}

//retreive information if the form is submitted
if(isset($_POST["alert_professor"]))
{
        $code = 'SH87D';
	//select database
	mysql_select_db($mysql_database, $con) or die(mysql_error());
        $slow = mysql_result(mysql_query("SELECT slow FROM feedback WHERE class_code='$code'"),0);
        $fast = mysql_result(mysql_query("SELECT fast FROM feedback WHERE class_code='$code'"),0);
        $selected_radio = $_POST["feedback"];
        if ($selected_radio == "fast")
        {
            mysql_query("UPDATE feedback SET fast=$fast + 1 WHERE class_code = '$code'");
        }
        else if ($selected_radio == "slow"){
            mysql_query("UPDATE feedback SET slow=$slow + 1 WHERE class_code = '$code'");
        }

        echo "Your feedback has been received";
}
*/	
?>