<script type="text/javascript">

$(document).ready(function(){
    
               
    $(function(){ // check feedback every 5 seconds
        setInterval(function(){ 
            $.ajax({
                type: "POST",
                data: "",
                url: 'check_feedback.php',
                success: function(msg){
                    if (msg == "fast"){
                       $('#feedback_display').html("Professor, you are talking too fast");
                         $(function() {
                           $( "#fast" ).dialog();
                        });
                    }
                    else if (msg == "slow"){
                       $('#feedback_display').html("Professor, you are talking too slow");
                        $(function() {
                            $( "#slow" ).dialog();
                        });
                    }
                    else{
                       $('#feedback_display').html("");
                    }


                }
            });
        }, 5000);
    })
    
    	$('a.view-feedback').hover(function() { // display detailed feedback when hovering
		
                //Getting the variable's value from a link 
		var feedbackBox = $(this).attr('href');

		//Fade in the Popup
		$(feedbackBox).fadeIn(300);
		
		//Set the center alignment padding + border see css style
		var popMargTop = ($(feedbackBox).height() + 24) / 2; 
		var popMargLeft = ($(feedbackBox).width() + 24) / 2; 
		
		$(feedbackBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
                
                        $.ajax({
            //cache: false;
            type: "POST",
            url:'display_feedback.php',
            data: "",
            success: function(msg){
                $('#feedback_view').html(msg);
            }
        })
		
		return false;
	});
	
	// When clicking on the button close or the mask layer the popup closed
	$('a.close, #mask').live('click', function() { 
	  $('#mask , .popup').fadeOut(300 , function() {
		$('#mask').remove();  
	}); 
	return false;
	});       
})
</script>
<!DOCTYPE html>
<html>
    <head>
	<link rel="stylesheet" type="text/css" href="profile_s.css" />
	<link rel="stylesheet" type="text/css" href="index.css" />

	<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet" media="screen" type="text/css">

	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="bootstrap\js\bootstrap.min.js"></script>
    </head>
    <body>
	
	<div id="fast" class="alert alert-block" style="display: none;" title="Please slow down">
  <p>Professor, you are talking too fast!</p>
  <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>

<div id="slow" class="alert alert-block" style="display: none;" title="Please speed up">
  <p>Professor, you are talking too slow!</p>
  <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>

<div id="alert">
    <h2>ALERTS</h2>
    <a href="#feedback-box" class="view-feedback">View Detailed Feedback</a>
    <div id="feedback-box" class="alert alert-block">
        <a href="#" class="close"><img src="close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
        <h3>Student Responses</h3>
        <div id="feedback_view"></div>
    </div>
    <div id="feedback_display" class="alert alert-block"></div>
</div>

    </body>


</html>
