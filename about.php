<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
    <link href="bootstrap\css\bootstrap.min.css" rel="stylesheet" media="screen" type="text/css">
    <link rel="stylesheet" type="text/css" href="profile_s.css" />
    <link rel="stylesheet" type="text/css" href="index.css" />



    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap\js\bootstrap.min.js"></script>
        <title>
            About Us
        </title>
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
                <div class="span6 offset1">
                    <h2>About Our Website</h2>
                    <h4>Purpose</h4>
                    <p>&nbsp&nbspSubmitQ seeks to facilitate interactions between
                    students and faculty in class by encouraging students to ask questions to
                    the faculty,
                    comment on on their colleague's questions, and collaborate with each
                    other in notetaking. </p>
                    <h4>Main Features</h4>
                    <ol type="A">
                        <li>
                            <p><span>Question/Comment: </span>Students can log in to
                            their classes during lecture and post questions about something
                            they do not understand. In addition, students can vote for the question
                            that they find are important, helping the lecturer partition his or her class time
                            according to the needs of the entire class. Anyone in the class can answer
                            the questions: this feature allows the class to be more responsive to the
                            needs of individual students.</p>
                        </li>
                        <li>
                            <p><span>Feedback to the Lecturer: </span>Students can indicate to the professor
                            whether the lecture is too slow or too fast for their understanding of the
                            material. The professor receives that feedback from the students and can
                            adjust the pace of the lecture accordingly.</p>
                        </li>
                        <li>
                            <p><span>Collaborative Notetaking: </span>Everyone in the class can participate
                            in the collaborative notetaking by writing down important vocabulary and
                            definitions relevant to the material. Along with the other features of the
                            website, this function allows the faculty to indicate to the students
                            which concepts to focus on learning.</p>
                        </li>
                    </ol>
                    
                </div>
                <div class="span6 offset2">
                    <h2>How to Use the Website</h2>
                    <ol type="1">
                        <li>
                            <h4>Register from the home page as a Professor, TA, or a Student</h4>
                        </li>
                        <br>
                        <li>
                            <h4>Add a class to your account with the class code given by your professor</h4>
                        </li>
                        <br>

                        <li>
                            <h4>Click on your class to enter your class to use the amazing features listed here.</h4>
                        </li>
                        <br>
                        <li>
                            <h4>Go to your class! Ask and answer questions! Take notes! Tell your professor what's up.</h4>
                        </li>
                        
                    </ol>
                </div>
                
            </div>
            
            <div id="push"></div>
<?php include("footer.php");?>
            
            
        </div><!--belongs to wrapper div-->
    </body>
</html>
