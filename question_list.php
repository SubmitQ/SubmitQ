<?php
SESSION_START();

//if the user is not logged in, redirect to the login page
if(!isset($_SESSION["UserType"]))
{
	header("location: index.php");
}

//Show their name
$first_name= $_SESSION['First_name'];
$last_name= $_SESSION['Last_name'];
if($_SESSION["UserType"]=='T')
{$name= "$first_name $last_name (TA)";}
if($_SESSION["UserType"]=='S' || $_SESSION["UserType"]=='P')
{$name= "$first_name $last_name";}

$code= $_GET["code"];

?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="http://harlin.scripts.mit.edu/submitq/classes/jquery.livequery.js"></script>
<script type="text/javascript">
	var name= '<?php echo "$name"; ?>';
	var type = '<?php echo $_SESSION["UserType"]; ?>';
	var code= '<?php echo $code; ?>';

$(function() {
	$('#preloader')
	.ajaxStart(function(){
		$(this).show();
	}).ajaxStop(function(){
		$(this).hide();
	});
	
	$(document).ready(function() { // display questions when page loads
	var name= '<?php echo "$name"; ?>';
	var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code; 
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/update_page.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		}
	});
	return false;
	});


$("#refresh_page").click(function() {
	var name= '<?php echo "$name"; ?>';
	var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code; 
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/update_page.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		},
		error: function(html){
			alert("error");
		}
	});
	//return false;
});

$("#sort_by_upvotes").click(function() {
	var name= '<?php echo "$name"; ?>';
	var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code; 
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/update_page.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		},
		error: function(html){
			alert("error");
		}
	});
});

$("#sort_by_answers_asc").click(function() {
	var name= '<?php echo "$name"; ?>';
	var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code; 
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_num_ans_asc.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		},
		error: function(html){
			alert("error");
		}
	});
});

$("#sort_by_answers_des").click(function() { // sort by number of answers descending
	var name= '<?php echo "$name"; ?>';
	var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code; 	
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_num_ans_des.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		},
		error: function(html){
			alert("error");
		}
	});
});

$("#sort_by_time").click(function() { // sort by number of answers descending
	var name= '<?php echo "$name"; ?>';
	var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code; 
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_by_time.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		},
		error: function(html){
			alert("error");
		}
	});
});

// Check if anonymous box was clicked
jQuery(':checkbox').click(function()
{
    if (jQuery(this).is(':checked'))
    {
        name = "Anonymous";
    }
    else
    {
       name= '<?php echo "$name"; ?>';
    }

});

$(".submit_q").click(function() {
	var question = jQuery.trim($('#questiontext').val());
	var dataString = 'question='+ question +'&name=' + name + '&type=' + type + '&class_code=' + code; 
	
	if(question == '')
	{
		$('#validate').html("Question cannot be blank");
	}
	else
	{
		$('#validate').html("");
		$.ajax({
			type: "POST",
			url: "http://harlin.scripts.mit.edu/submitq/classes/questions/update_questions.php",
			data: dataString,
			success: function(html){
	
			$("ol#update").html(html);
			$('#question').val('');
			}
		});
	}
	return false;
});

// check if upvote button was clicked
$('.upvote') 
	.livequery('click', function(event) { 
	var name= '<?php echo "$name"; ?>';
	var uID = $(this).attr('id');
	var dataString = 'uID=' + uID + '&name=' + name + '&type=' + type + '&class_code=' + code; 
	//var dataString = 'uID='+uID;
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/update_upvotes.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		}
	});
	return false;
    });
    
    $('.delete') 
    .livequery('click', function(event) { 
	var name= '<?php echo "$name"; ?>';    
        var dID = $(this).attr('id');
	var dataString = 'dID=' + dID + '&name=' + name + '&type=' + type + '&class_code=' + code; 
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/delete_question.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		}
	});
	return false;
    });
    
    $('.delete_ans') 
    .livequery('click', function(event) { 
 	var name= '<?php echo "$name"; ?>';
	    var daID = $(this).attr('id');
	    var dasID= $(this).attr('name');
	    var dataString = 'daID=' + daID + '&dasID=' + dasID + '&type=' + type + '&class_code=' + code; 
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/delete_answer.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		}
	});
	return false;
    });

    $('.star_q') 
    .livequery('click', function(event) { 
 	var name= '<?php echo "$name"; ?>';
	    var sID = $(this).attr('id');
	    var dataString = 'name=' + name + '&sID=' + sID + '&type=' + type + '&class_code=' + code; 
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/star_question.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		}
	});
	return false;
    });
   
    $('.unstar_q') 
    .livequery('click', function(event) { 
 	var name= '<?php echo "$name"; ?>';
	    var usID = $(this).attr('id');
	    var dataString = 'name=' + name + '&usID=' + usID + '&type=' + type + '&class_code=' + code; 
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/unstar_question.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		}
	});
	return false;
    });
    
//    $('.show_ans').livequery('click', function(event){
//	$(".answerss").show();
//   }

    // Check if POST ANSWER was clicked
$('.answer') 
    .livequery('click', function(event) { 
	var name= '<?php echo "$name"; ?>';
	var $form = $(this).closest("form");
	var ans = $form.find('.ans').val();
	var code= '<?php echo $code; ?>';
	var currentID = $(this).attr('id');

	var dataString = 'ans='+ ans +'&name=' + name + '&currentID=' + currentID + '$type=' + type + '&class_code=' + code;

	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/update_answers.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		}
	});
	return false;
    });
});


    
    $(function(){ // update page every 10 seconds
	var timer = null;
	$(function(){
		var name= '<?php echo "$name"; ?>';
		var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code; 
		timer = setInterval(function(){
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/questions/update_page.php",
				data: dataString,
				success: function(html){
					$("ol#update").html(html);
				}
			});
		}, 30000);
	})
    
	$('.ans').live('blur', function(){ 
		if (jQuery.trim($(this).val()) != ''){ // if textarea has text, stop timer
			clearInterval(timer);
			timer = null;
		}
		else {
			var name= '<?php echo "$name"; ?>';
			var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code; 
			timer = setInterval(function(){ // if textarea is blank, restart timer
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/questions/update_page.php",
				data: dataString,
				success: function(html){
					$("ol#update").html(html);
				}
			});
		}, 30000);
		}
	})
	
	$('.ans').live('focus', function(){ // if textarea has focus, stop timer
		clearInterval(timer);
		timer = null;
	})

    })
</script>
<div id="questions">
	<div id="options">
		<!--<a id="refresh_page">Refresh Page</a> |--> 
		<a id="sort_by_upvotes">Sort by upvotes</a> | 
		<a id="sort_by_answers_asc">Sort by number of answers (asc)</a> | 
		<a id="sort_by_answers_des">Sort by number of answers (desc)</a> |
		<a id="sort_by_time">Sort by time asked</a>
	</div>
	
	<ol id="update" style="list-style-type:none;">
		<li class="qs">
		</li>
	</ol>
	
	<form name="questions" method = "POST">
	<b>Questions:</b>
	<input type= "checkbox" name= "anonymous" value= "Anonymous"> Ask Anonymously</br>
	<textarea rows="5" cols= "100" name = "question" id="questiontext"> </textarea>
	<img src="http://harlin.scripts.mit.edu/submitq/preloader.gif" width="25px" height="25px"/></div><button type= "submit" class= "btn btn-primary submit_q pull-right">POST QUESTION</button>
	<div id="validate"></div> <div id="preloader"><img src="http://harlin.scripts.mit.edu/submitq/preloader.gif" width="25px" height="25px"/></div>
	<br /><br />
	</form>
</div>
