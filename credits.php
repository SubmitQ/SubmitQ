<?php

// Inialize session
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
	<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="profile_s.css" />
    <link rel="stylesheet" type="text/css" href="index.css" />


    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap\js\bootstrap.min.js"></script>
        <title>SubmitQ - Credits</title>
    </head>
    <body>
        <div id="wrapper">

<?php
if(!isset($_SESSION["Email"]))
{include('not_loggedin.php');}

else
{include('loggedin.php');}
?>

            <div class="container-fluid" id="container">
                <div class="span8 offset2">
                    <h2>Credits</h2>
                    <h4>
                        We want to thank the <a href="http://6.470.scripts.mit.edu/2013/" target="_blank">MIT 6.470 Web Programming Competition</a> staff and instructors for
                        teaching us and guiding us through this project.
                    </h4>
                    <h3>
                        Others who have helped us in the project:
                    </h3>
                    <h4><a href="http://twitter.github.com/bootstrap/" target="_blank">Twitter Bootstrap</a></h4>
		    <h4><a href="http://preloaders.net/" target="_blank">Preloaders.net</a></h4>
                    <h4>General Gao</h4>
                    <h4>Domino's Pizza</h4>
<h4>McCormick Annex</h4>
<h4>3W</h4>
<h4>Lang Lang</h4> 
                    
                </div>
                
            </div>
            
            <div id="push"></div>           
        </div><!--belongs to wrapper div-->
	<?php include "footer.php" ?>
    </body>
</html>