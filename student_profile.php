<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['Email']) || $_SESSION['UserType'] != "S") {
header('Location: index.php');
}

//connect to database
$con = mysql_connect("sql.mit.edu","harlin","freshman");
if (!$con)
{
	die('Could not connect:'.mysql_error());
}

//select database
mysql_select_db("harlin+db1",$con) or die("Cannot select the Database".mysql_error());
?>

<!DOCTYPE HTML>
<html>
<head>
<title>My Profile</title>

<link rel="stylesheet" type="text/css" href="profile_s.css" />
<link rel="stylesheet" type="text/css" href="index.css" />
<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="quickPagination/css/styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="http://www.jquery4u.com/demos/jquery-quick-pagination/js/jquery.quick.pagination.min.js"></script>
<script src="bootstrap\js\bootstrap.min.js"></script>

<script type="text/javascript"> 
$(document).ready(function(){
$("ul.pdf").quickPagination({pagerLocation:"top",pageSize:"14"});
});
</script>
</head>

<body>
<div id="wrapper">
	<div class = "row-fluid" id="header" class="span12">
		<div class="span12" id="headbar">
			<div class="row-fluid">
			<div class="span4 offset1"><h1><a class="head" href="index.php">SubmitQ</a></h1>
			</div>
			<div class="span4 offset3" id="profile">
				<div id="account_info">
				Welcome <?php echo $_SESSION['First_name'] . " " . $_SESSION['Last_name']; ?> | <a class="white" href="student_profile.php">My Profile</a> | <a class="white" href="logout.php">Logout</a>
				</div>
			</div>
			</div>
		</div>	
	</div>
	<div class="container-fluid" id="container">
		<div class="span5 offset1">
			<div class="row-fluid">
			<!--<h2><?php echo $_SESSION['First_name'] . " " . $_SESSION['Last_name']; ?>'s Profile</h2>-->
			<h3>My Classes:</h3>
			<?php 
			$first_name= $_SESSION['First_name'];
			$last_name= $_SESSION['Last_name'];
			$email= $_SESSION['Email'];

			//get number of classes columns in all_users
			$num_col= mysql_result(mysql_query("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema= 'harlin+db1' AND table_name= 'all_users'", $con), 0)-8;
			$count=0;

			//show all classes user is taking
			for($n=1; $n<= $num_col; $n++)
			{
				$class_code= mysql_result(mysql_query("SELECT class$n FROM all_users WHERE email='$email'", $con), 0);
				if ($class_code != NULL)
				{
					$class= mysql_result(mysql_query("SELECT class FROM all_classes WHERE class_code='$class_code'", $con), 0);
					$class_number= mysql_result(mysql_query("SELECT class_number FROM all_classes WHERE class_code= '$class_code'", $con), 0);
					echo "<a href='classes/$class_code.php?code=$class_code'>$class_number $class</a>";
					echo "<br/>";	
					$count= $count+1;
				}
			}
			
			if($count==0)
			{
				echo "</br>You are currently not enrolled in any class. <a href='add_class_s.php'>Add Classes</a>!!</br></br>";
			}	
			?>
			</div>
			<div class="row-fluid">
				<div>
					<h3>Account Management</h3>
					<a href='add_class_s.php'>Add Class</a>
					<br/><a href='drop_class.php'>Drop a class</a>
					<br/><a href="change_password.php">Change Password</a>
				</div>
			</div>			
			
			
		</div>
		
		<div class="span4 offset5" id="lists">
			<div class="row-fluid">
			<div >
			<h3>Questions and Vocab</h3>
			<input type='hidden' id='current_page' />
			<input type='hidden' id='show_per_page' />
			<div class="row-fluid" id="content">
			
			<?php
			echo "<ul class='pdf'>";
			//get all classes user is taking
			for($n=1; $n<= $num_col; $n++)
			{
				$class_code= mysql_result(mysql_query("SELECT class$n FROM all_users WHERE email='$email'", $con), 0);
				   if ($class_code != NULL)
					{
						$class= mysql_result(mysql_query("SELECT class FROM all_classes WHERE class_code='$class_code'", $con), 0);
						$class_number= mysql_result(mysql_query("SELECT class_number FROM all_classes WHERE class_code= '$class_code'", $con), 0);

						echo "<li>$class_number $class :</li></br>";

						//get the list of all files inside class folder 
						$list= scandir("classes/$class_code");
						$list_num= count($list)-2;
						//echo "<input type='hidden' id='current_page' />";
						//echo "<input type='hidden' id='show_per_page' />";
						//echo '<div id="content">';
						for($k= 2; $k<= $list_num +1; $k++)
						{
							$date= substr(chunk_split(substr("$list[$k]", 0, 6), 2, "/"), 0, 8);

							if(substr("$list[$k]", -5, 1)=='q')
							{
								//echo "<br>";
								echo "<li><a href='classes/$class_code/$list[$k]' target='_blank'>20$date &nbsp Questions</a></li>";
							
							}
							else
							{
								//echo "<br>";
								echo "<li><a href='classes/$class_code/$list[$k]' target='_blank'>20$date &nbsp Vocab</a></li>";
								echo "</br>";	
							}
						}
						
					}
			}
			echo '</ul>';	
			?>
			
			</div>
			
			</div>


<!--			
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript"> 
$(document).ready(function(){
    
    //how much items per page to show
    var show_per_page = 14; 
    //getting the amount of elements inside content div
    var number_of_items = $('#content').children().size();
    //calculate the number of pages we are going to have
    var number_of_pages = Math.ceil(number_of_items/show_per_page);
    
    //alert(number_of_items);
    
    //set the value of our hidden input fields
    $('#current_page').val(0);
    $('#show_per_page').val(show_per_page);
    
    //now when we got all we need for the navigation let's make it '
    
    /* 
    what are we going to have in the navigation?
        - link to previous page
        - links to specific pages
        - link to next page
    */
    var navigation_html = '<div class="row-fluid"><div class="pagination"><ul>';
    navigation_html += '<li class="active">';
    navigation_html += '<a class="previous_link" href="javascript:previous();">Prev</a></li>';
    
    var current_link = 0;
    while(number_of_pages > current_link){
        navigation_html += '<li class="active">';
	navigation_html += '<a class="page_link" href="javascript:go_to_page(' + current_link +')" longdesc="' + current_link +'">'+ (current_link + 1) +'</a>';
        navigation_html += '</li>';
	current_link++;
    }
    navigation_html += '<li class="active">';
    navigation_html += '<a class="next_link" href="javascript:next();">Next</a>';
    navigation_html += '</li>';
    navigation_html += '</ul></div></div>';
    $('#page_navigation').html(navigation_html);
    
    //add active_page class to the first page link
    $('#page_navigation .page_link:first').addClass('active_page');
    
    //hide all the elements inside content div
    $('#content').children().css('display', 'none');
    
    //and show the first n (show_per_page) elements
    $('#content').children().slice(0, show_per_page).css('display', 'block');
    
});
 
function previous(){
    
    new_page = parseInt($('#current_page').val()) - 1;
    //if there is an item before the current active link run the function
    
    if(new_page==0){
        go_to_page(new_page);
    }
    
}
 
function next(){
    new_page = parseInt($('#current_page').val()) + 1;
    //if there is an item after the current active link run the function
    
    var show_per_page = 14; 
    var number_of_items = $('#content').children().size();
    var number_of_pages = Math.ceil(number_of_items/show_per_page);
    if(new_page < number_of_pages){
        go_to_page(new_page);
    }
    
}
function go_to_page(page_num){
    //get the number of items shown per page
    var show_per_page = parseInt($('#show_per_page').val());
    
    //get the element number where to start the slice from
    start_from = page_num * show_per_page;
    
    //get the element number where to end the slice
    end_on = start_from + show_per_page;
    
    //hide all children elements of content div, get specific items and show them
    $('#content').children().css('display', 'none').slice(start_from, end_on).css('display', 'block');
    
    /*get the page link that has longdesc attribute of the current page and add active_page class to it
    and remove that class from previously active page link*/
    $('.page_link[longdesc=' + page_num +']').addClass('active_page').siblings('.active_page').removeClass('active_page');
    
    //update the current page input field
    $('#current_page').val(page_num);
}
  
</script>
 <div id='page_navigation'></div>
			
			
		</div>-->
	</div>			
<div id="down"></div>
</div>

<div class="row-fluid">
		<div id="footer" class="span11 offset1">
			<a href="http://harlin.scripts.mit.edu/submitq/about.php">About Us</a> | <a href="http://harlin.scripts.mit.edu/submitq/faqs.php">Frequently Asked Questions</a> | <a href="http://harlin.scripts.mit.edu/submitq/credits.php">Credits</a> | <a href="http://harlin.scripts.mit.edu/submitq/refer.php">Refer a Professor</a>
			<br />Copyright@ Brocode Inc. 2013. All rights reserved.
		</div>
	</div>


</body>
<style>
	#container{height:440px;}
	#content{height:300px;}
	#push{height:200px;}
</style>

</html>
