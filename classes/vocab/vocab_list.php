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
if($_SESSION["UserType"]=='T')
{$name= "$first_name $last_name (TA)";}
if($_SESSION["UserType"]=='S' || $_SESSION["UserType"]=='P')
{$name= "$first_name $last_name";}

?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="jquery.livequery.js"></script>
<script>
	var name = '<?php echo "$name"; ?>';
	var type = '<?php echo $_SESSION["UserType"]; ?>';
	var code= '<?php echo $code; ?>';

$(function(){

$('#preloader2').ajaxStart(function(){
	$(this).show();
})
$('#preloader2').ajaxStop(function(){
	$(this).hide();
})

$(document).ready(function() { // display questions when page loads
	var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code;
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/vocab/display_vocab.php",
		data: dataString,
		success: function(html){
			$("#show_vocab").html(html);
		}
	});
	return false;
});

$('.submit_word').livequery('ajaxStop', function(){
	$(this).removeClass('loading disabled');
})

$('.submit_word').livequery('click', function(){
	var $form = $(this).closest("form");
	var word = $form.find('.word').val();
        var wID = $(this).attr('id');
        var dataString = 'word=' + word + '&wID=' + wID + '&type=' + type + '&class_code=' + code;
	
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/vocab/update_word.php",
		data: dataString,
		success: function(html){
			$("#show_vocab").html(html);
		},
		error: function(html){
			alert("error");
		}
	});
    return false;
})

$('.submit_def').livequery('click', function(){
	
    var $form = $(this).closest("form");
    var def = $form.find('.def').val();
    var dID = $(this).attr('id');
    var dataString = 'def=' + def + '&dID=' +dID + '&name=' + name + '&type=' + type + '&class_code=' + code;
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/vocab/update_def.php",
		data: dataString,
		success: function(html){
			$("#show_vocab").html(html);
		}
	});
    return false;
})

$('.edit').livequery('click', function(){

    var eID = $(this).attr('id');
    var dataString = 'eID=' + eID + '&name=' + name +'&type=' + type + '&class_code=' + code;
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/vocab/update_edit.php",
		data: dataString,
		success: function(html){
			$("#show_vocab").html(html);
		},
                error: function(html) {
                    alert("error");
                }
	});
    return false;
})

$('#more').livequery('ajaxStop', function(){
	$(this).removeClass('loading disabled');
})

$('#more').livequery('click', function(){
    var dataString = '&name=' + name +'&type=' + type + '&class_code=' + code;
	$(this).addClass('loading disabled');
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/vocab/more_words.php",
		data: dataString,
		success: function(html){
			$("#show_vocab").html(html);
		},
                error: function(html) {
                    alert("error");
                }
	});
    return false;
})

$('.delete_word').livequery('click', function(){

    var deID = $(this).attr('id');
    var dataString = 'deID=' + deID + '&type=' + type + '&class_code=' + code;
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/vocab/delete_word.php",
		data: dataString,
		success: function(html){
			$("#show_vocab").html(html);
		},
                error: function(html) {
                    alert("error");
                }
	});
        //alert(dataString);
    return false;
})

$('#refresh_vocab').click(function(){
	var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code;
	$.ajax({
		type: "POST",
		url: "http://harlin.scripts.mit.edu/submitq/classes/vocab/display_vocab.php",
		data: dataString,
		success: function(html){
			$("#show_vocab").html(html);
		}
	});
	return false;
})

})

    $(function(){ // update page every 10 seconds
	var timer = null;
	
	$(function(){
		var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code; 
		timer = setInterval(function(){
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/vocab/display_vocab.php",
				data: dataString,
				success: function(html){
					$("#show_vocab").html(html);
				}
			});
		}, 10000);
	})
    
	$('.word').livequery('blur', function(){ 
		if (jQuery.trim($(this).val()) != ''){ // if textarea has text, stop timer
			clearInterval(timer);
			timer = null;
		}
		else {
			var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code; 
			timer = setInterval(function(){ // if textarea is blank, restart timer
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/vocab/display_vocab.php",
				data: dataString,
				success: function(html){
					$("#show_vocab").html(html);
				}
			});
		}, 10000);
		}
	})
	
	$('.word').livequery('focus', function(){ // if textarea has focus, stop timer
		clearInterval(timer);
		timer = null;
	})
	
	$('.def').livequery('blur', function(){ 
		if (jQuery.trim($(this).val()) != ''){ // if textarea has text, stop timer
			clearInterval(timer);
			timer = null;
		}
		else {
			var dataString = 'name=' + name + '&type=' + type + '&class_code=' + code; 
			timer = setInterval(function(){ // if textarea is blank, restart timer
			$.ajax({
				type: "POST",
				url: "http://harlin.scripts.mit.edu/submitq/classes/vocab/display_vocab.php",
				data: dataString,
				success: function(html){
					$("#show_vocab").html(html);
				}
			});
		}, 10000);
		}
	})
	
	$('.def').livequery('focus', function(){ // if textarea has focus, stop timer
		clearInterval(timer);
		timer = null;
	})


    })
</script>
<h2>Vocab List	<button id="refresh_page" title="Refresh vocab list" type= "submit" class="btn btn-mini btn-success pull-right"><i class="icon-white icon-refresh"></i></button><span id="preloader2"><img src="http://harlin.scripts.mit.edu/submitq/preloader.gif" title="Updating..."/></span></h2>

<div id="show_vocab">
</div>