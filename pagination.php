<?php
?>
<!DOCTYPE html>
<html>
    <head>
<script type="text/javascript" src="js/jquery.js"></script>
    </head>
    <body>
<script type="text/javascript"> 
$(document).ready(function(){
    
    //how much items per page to show
    var show_per_page = 14; 
    //getting the amount of elements inside content div
    var number_of_items = $('#content tr').children().size();
    //calculate the number of pages we are going to have
    var number_of_pages = Math.ceil(number_of_items/show_per_page);
    
    alert(number_of_items);
    
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
    var number_of_items = $('#content tr').children().size();
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
 
 </body>
 </html>