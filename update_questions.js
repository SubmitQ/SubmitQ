var name = '<?php echo $_SESSION['First_name'] . " " . $_SESSION['Last_name']; ?>';
var type = '<?php echo $_SESSION["UserType"]; ?>';

$(function() {
	
$(document).ready(function() { // display questions when page loads
	var dataString = 'name=' + name + '&type=' + type; 
	$.ajax({
		type: "POST",
		url: "update_page.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		}
	});
	return false;
});

$("#refresh_page").click(function() {
	var dataString = 'name=' + name + '&type=' + type; 
	$.ajax({
		type: "POST",
		url: "update_page.php",
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
	var dataString = 'name=' + name + '&type=' + type; 
	$.ajax({
		type: "POST",
		url: "update_page.php",
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
	var dataString = 'name=' + name + '&type=' + type; 
	$.ajax({
		type: "POST",
		url: "sort_num_ans_asc.php",
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
	var dataString = 'name=' + name + '&type=' + type; 	
	$.ajax({
		type: "POST",
		url: "sort_num_ans_des.php",
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
	var dataString = 'name=' + name + '&type=' + type; 
	$.ajax({
		type: "POST",
		url: "sort_by_time.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		},
		error: function(html){
			alert("error");
		}
	});
});


$(".submit_q").click(function() {
	var question = jQuery.trim($('#question').val());
	var dataString = 'question='+ question +'&name=' + name + '&type=' + type; 
	
	if(question == '')
	{
		$('#validate').html("Question cannot be blank");
	}
	else
	{
		$('#validate').html("");
		$.ajax({
			type: "POST",
			url: "update_questions.php",
			data: dataString,
			success: function(html){
	
			$("ol#update").html(html);
			}
		});
	}
	return false;
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
        name ='<?php echo $_SESSION['First_name'] . " " . $_SESSION['Last_name']; ?>';;
    }

});

// check if upvote button was clicked
$('.upvote') 
    .livequery('click', function(event) { 
	var uID = $(this).attr('id');
	var dataString = 'uID=' + uID + '&name=' + name + '&type=' + type; 
	//var dataString = 'uID='+uID;
	$.ajax({
		type: "POST",
		url: "update_upvotes.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		}
	});
	return false;
    });
    
    $('.delete') 
    .livequery('click', function(event) { 
	var dID = $(this).attr('id');
	var dataString = 'dID=' + dID + '&name=' + name + '&type=' + type; 
	$.ajax({
		type: "POST",
		url: "delete_question.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		}
	});
	return false;
    });


});

// Check if POST ANSWER was clicked
$('.answer') 
    .livequery('click', function(event) { 

	var $form = $(this).closest("form");
	var ans = $form.find('.ans').val();

	var name = '<?php echo $_SESSION['First_name'] . " " . $_SESSION['Last_name']; ?>';
	var currentID = $(this).attr('id');

	var dataString = 'ans='+ ans +'&name=' + name + '&currentID=' + currentID + '$type=' + type;

	$.ajax({
		type: "POST",
		url: "update_answers.php",
		data: dataString,
		success: function(html){
			$("ol#update").html(html);
		}
	});
	return false;
    });
    
    $(function(){ // update page every 10 seconds
	var timer = null;
	
	$(function(){
		var dataString = 'name=' + name + '&type=' + type; 
		timer = setInterval(function(){
			$.ajax({
				type: "POST",
				url: "update_page.php",
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
			var dataString = 'name=' + name + '&type=' + type; 	var dataString = 'name=' + name + '&type=' + type; 
			timer = setInterval(function(){ // if textarea is blank, restart timer
			$.ajax({
				type: "POST",
				url: "update_page.php",
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