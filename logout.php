<?php

// Inialize session
session_start();

// Delete all session variables
session_destroy();

if(isset($_COOKIE['User'])) // If the cookie 'Joe2Torials is set, do the following; 
{ 
$time = time(); 
setcookie("User[email]", $time - 3600); 
setcookie("User[password]", $time - 3600); 
} 

// Jump to login page
header('Location: index.php');

?>
