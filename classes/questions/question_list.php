<?php
SESSION_START();

//if the user is not logged in, redirect to the login page
if(!isset($_SESSION["UserType"]))
{
	header("location: index.php");
}
$_SESSION['Sort'] = 0;
//Show their name
//
$first_name= $_SESSION['First_name'];
$last_name= $_SESSION['Last_name'];
if($_SESSION["UserType"]=='T')
{$name= "$first_name $last_name (TA)";}
if($_SESSION["UserType"]=='S')
{$name= "$first_name $last_name";}
if( $_SESSION["UserType"]=='P')
{$name= "Professor $last_name";}
$code= $_GET["code"];
?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="http://harlin.scripts.mit.edu/submitq/classes/jquery.livequery.js"></script>
<script type="text/javascript">
	var name= '<?php echo "$name"; ?>';
	var type = '<?php echo $_SESSION["UserType"]; ?>';
	var code= '<?php echo $code; ?>';
	var sort= 0;

$(function() {
	
$('#preloader').ajaxStart(function(){
	$(this).show();
})
$('#preloader').ajaxStop(function(){
	$(this).hide();
})
	$('.answer').livequery('click', function(){
		$(this).addClass('loading disabled');
	})
	$('.answer').livequery('ajaxStop', function(){
		$(this).removeClass('loading disabled');
	})
	
	$('#question').livequery('ajaxStart', function(){
		$(this).addClass('loading disabled');
	})
	$('#question').livequery('ajaxStop', function(){
		$(this).removeClass('loading disabled');
	})
	
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
	/*$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/update_page.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		},
		error: function(html){
			alert("error");
		}
	});*/
	if(sort=='0'){
		$.ajax({
			type: "POST",
			url: "http://harlin.scripts.mit.edu/submitq/classes/questions/update_page.php",
			data: dataString,
			success: function(html){
				$("ol#update").html(html);
			}
		});}
	else if(sort=='1'){
		$.ajax({
			type: "POST",
			url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_by_time_desc.php",
			data: dataString,
			success: function(html){
				$("ol#update").html(html);
		}
		});}
			
	else if(sort=='2'){
		$.ajax({
			type: "POST",
			url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_by_time_asc.php",
			data: dataString,
			success: function(html){
				$("ol#update").html(html);
			}
		});}
	else if(sort=='3'){
		$.ajax({
			type: "POST",
			url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_num_ans_asc.php",
			data: dataString,
			success: function(html){
				$("ol#update").html(html);
			}
		});}
			
	else if(sort=='4'){
		$.ajax({
			type: "POST",
			url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_num_ans_des.php",
			data: dataString,
			success: function(html){
				$("ol#update").html(html);
			}
		});}
			
	else if(sort=='5'){
		$.ajax({
			type: "POST",
			url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_by_upvotes_asc.php",
			data: dataString,
			success: function(html){
				$("ol#update").html(html);
			}
		});}
	//return false;
});

$("#sort_by_upvotes_asc").click(function() {
	var name= '<?php echo "$name"; ?>';
	var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code;
	$(this).addClass('disabled');
	$('#sort_by_answers_des').removeClass('disabled');
	$('#sort_by_time_desc').removeClass('disabled');
	$('#sort_by_time_asc').removeClass('disabled');
	$('#sort_by_answers_asc').removeClass('disabled');
	$('#sort_by_upvotes_des').removeClass('disabled');
	sort = 0;
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

$("#sort_by_upvotes_des").click(function(){
	var name= '<?php echo "$name"; ?>';
	var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code;
	$(this).addClass('disabled');
	$('#sort_by_answers_des').removeClass('disabled');
	$('#sort_by_time_desc').removeClass('disabled');
	$('#sort_by_time_asc').removeClass('disabled');
	$('#sort_by_upvotes_asc').removeClass('disabled');
	$('#sort_by_answers_asc').removeClass('disabled');
	sort = 5;
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_by_upvotes_asc.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		},
		error: function(html){
			alert("error");
		}
	});
	
})

$("#sort_by_answers_asc").click(function() {
	var name= '<?php echo "$name"; ?>';
	var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code;
	$(this).addClass('disabled');
	$('#sort_by_answers_des').removeClass('disabled');
	$('#sort_by_time_desc').removeClass('disabled');
	$('#sort_by_time_asc').removeClass('disabled');
	$('#sort_by_upvotes_asc').removeClass('disabled');
	$('#sort_by_upvotes_des').removeClass('disabled');
	sort = 3;
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

	$(this).addClass('disabled');
	$('#sort_by_answers_asc').removeClass('disabled');
	$('#sort_by_time_desc').removeClass('disabled');
	$('#sort_by_time_asc').removeClass('disabled');
	$('#sort_by_upvotes_asc').removeClass('disabled');
	$('#sort_by_upvotes_des').removeClass('disabled');
	sort = 4;
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

$("#sort_by_time_desc").click(function() { // sort by number of answers descending
	var name= '<?php echo "$name"; ?>';
	var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code;
	$(this).addClass('disabled');
	$('#sort_by_answers_asc').removeClass('disabled');
	$('#sort_by_answers_des').removeClass('disabled');
	$('#sort_by_time_asc').removeClass('disabled');
	$('#sort_by_upvotes_asc').removeClass('disabled');
	$('#sort_by_upvotes_des').removeClass('disabled');
	sort = 1;
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_by_time_desc.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		},
		error: function(html){
			alert("error");
		}
	});
});

$("#sort_by_time_asc").click(function() { // sort by number of answers descending
	var name= '<?php echo "$name"; ?>';
	var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code;
	$(this).addClass('disabled');
	$('#sort_by_answers_asc').removeClass('disabled');
	$('#sort_by_time_desc').removeClass('disabled');
	$('#sort_by_answers_des').removeClass('disabled');
	$('#sort_by_upvotes_asc').removeClass('disabled');
	$('#sort_by_upvotes_des').removeClass('disabled');
	sort = 2;
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_by_time_asc.php",
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
		$('#validate').hide().html("<font color='#153E7E'><strong>Question cannot be blank</strong></font>").fadeIn('slow');
	}
	else
	{
		$('#validate').html("<br />");
		$.ajax({
			type: "POST",
			url: "http://harlin.scripts.mit.edu/submitq/classes/questions/update_questions.php",
			data: dataString,
			success: function(html){
	
			$("ol#update").html(html);
			$('#questiontext').val('');
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
    
    $(function(){ // update page every 20 seconds
	var timer = null;
	$(function(){
		var name= '<?php echo "$name"; ?>';
		var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code; 
		timer = setInterval(function(){
			if(sort=='0'){
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/questions/update_page.php",
				data: dataString,
				success: function(html){
					$("ol#update").html(html);
				}
			});}
			else if(sort=='1'){
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_by_time_desc.php",
				data: dataString,
				success: function(html){
					$("ol#update").html(html);
				}
			});}
			
			else if(sort=='2'){
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_by_time_asc.php",
				data: dataString,
				success: function(html){
					$("ol#update").html(html);
				}
			});}
			else if(sort=='3'){
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_num_ans_asc.php",
				data: dataString,
				success: function(html){
					$("ol#update").html(html);
				}
			});}
			
			else if(sort=='4'){
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_num_ans_des.php",
				data: dataString,
				success: function(html){
					$("ol#update").html(html);
				}
			});}
			
			else if(sort=='5'){
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_by_upvotes_asc.php",
				data: dataString,
				success: function(html){
					$("ol#update").html(html);
				}
			});}
		}, 10000);
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
			if(sort=='0'){
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/questions/update_page.php",
				data: dataString,
				success: function(html){
					$("ol#update").html(html);
				}
			});}
			else if(sort=='1'){
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_by_time_desc.php",
				data: dataString,
				success: function(html){
					$("ol#update").html(html);
				}
			});}
			
			else if(sort=='2'){
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_by_time_asc.php",
				data: dataString,
				success: function(html){
					$("ol#update").html(html);
				}
			});}
			else if(sort=='3'){
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_num_ans_asc.php",
				data: dataString,
				success: function(html){
					$("ol#update").html(html);
				}
			});}
			
			else if(sort=='4'){
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_num_ans_des.php",
				data: dataString,
				success: function(html){
					$("ol#update").html(html);
				}
			});}
			
			else if(sort=='5'){
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/questions/sort_by_upvotes_asc.php",
				data: dataString,
				success: function(html){
					$("ol#update").html(html);
				}
			});}
		}, 10000);
		}
	})
	
	$('.ans').live('focus', function(){ // if textarea has focus, stop timer
		clearInterval(timer);
		timer = null;
	})

    })
</script>

<div id="questions">
			<div id="options" style='color: #153e7e;'>
		<strong><font size="3">Sort By:</font></strong> upvotes  <button class="btn btn-mini btn-inverse" title="Most upvotes" type="submit" id="sort_by_upvotes_asc"><i class="icon-white icon-arrow-up"></i></button>  <button class="btn btn-primary btn-mini" title="Least upvotes" type="submit" id="sort_by_upvotes_des"><i class="icon-white icon-arrow-down"></i></button> | 
time asked <button class="btn btn-mini btn-inverse" title="Newest question" type="submit" id="sort_by_time_desc"><i class="icon-white icon-arrow-up"></i></button>  <button class="btn btn-primary btn-mini" title="Oldest question" type="submit" id="sort_by_time_asc"><i class="icon-white icon-arrow-down"></i></button> |
		number of answers  <button id="sort_by_answers_des" title="Greatest number of answers" type="submit" class="btn btn-mini btn-inverse"><i class="icon-white icon-arrow-up"></i></button>  <button id="sort_by_answers_asc" title="Least number of answers" type="submit" class="btn btn-mini btn-primary"><i class= "icon-white icon-arrow-down"></i></button> 
		&nbsp;&nbsp;&nbsp;<span id="preloader"><img src="http://harlin.scripts.mit.edu/submitq/preloader.gif" title="Updating..."/></span>
		<button id="refresh_page" title="Refresh questions" type= "submit" class="btn btn-mini btn-success pull-right"><i class="icon-white icon-refresh"></i></button>
	</div>
	<div id="question" style="border-bottom: 1px dashed #778899; padding-bottom:5px; padding-top: 20px;">
	<br />
	<form name="questions" method = "POST">
	<b><font size="4">Ask A Question: </font></b>
	<textarea rows="3" cols= "100" name = "question" id="questiontext"></textarea>
	<input type= "checkbox" name= "anonymous" value= "Anonymous" class="pull-left"> &nbsp; Ask Anonymously<button type= "submit" class= "btn btn-primary submit_q pull-right" id="question">POST QUESTION</button>
	<div id="validate" style="padding-top: 10px;"><br /></div>
	</form>
</div>
<br />
	<ol id="update" style="list-style-type:none;">
		<li class="qs">
		</li>
	</ol>
</div>
