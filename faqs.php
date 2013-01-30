<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="profile_s.css" />
    <link rel="stylesheet" type="text/css" href="index.css" />

    <link href="bootstrap\css\bootstrap.min.css" rel="stylesheet" media="screen" type="text/css">

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap\js\bootstrap.min.js"></script>
        <title>
            SubmitQ - About Us
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
                    <h2>Frequently Asked Questions</h2>
                    <ol type="I">
                        <li>
                            <h4>Who can see the questions/vocabs I post online?</h4>
                           <p>Everyone in your class. You can enter the class code when you register for a course, and
                           professors, TAs, and fellow students can help answer your questions. If you do not want to identify
                            yourself, you can post contents anonymously.</p>
                        </li>
                        <li>
                            <h4>How do I access the questions and the vocabs after class?</h4>
                            <p>The website archives any content recorded during class so that you can open them
                            up in a PDF file and use them for your studies in the future.</p>
                        </li>
                        <li>
                            <h4>How are Professor/Student/TA accounts different from each other?</h4>
                            <p>All three types of these accounts have accesss to the main features of our website; however,
                            professors and TAs can mark which questions or comments are important to the curriculum and can
                            also choose to delete irrelevant or inappropriate contents. Professors receive notifications from
                            the students in the class regarding the pace of their lecture.
                            </p>
                        </li>
                        <li>
                            <h4>Where does the professor get the class code?</h4>
                            <p>The professor gets the class code for each class by clicking "Add class"
                            on the profile page after the registration process is finished.</p>
                        </li>
                        
                    </ol>
                </div>
                <div class="span6 offset2">
                    <h4>What is up with the name of the website?</h4>
                    <p>On a certain freezing, windy, hungry day at MIT, we gathered around a round table in the dorm
                    lounge under the noble cause of saving our current education system by making the a real-time education
                    website. Well, we got stuck on some malicious code. We felt helpless and dejected, isolated and forever
                    cut off from the goodness of this world; the sacred oath we swore together as fellow knights of social
                    reform fell apart approximately within five minutes of coding.
                    So we ordered some Mongolian Beef and General Gao Chicken.
                    Wait a sec, we are the crusaders of this so-called education reform, and what symbol would be more befitting our
                    iron solid commitment than the legendary military icon General Gao? However, we discovered, to our dismay,
                    that "General Gao.com" was preoccupied with the tremendous task of solving the world hunger by delivering
                    chicken to those who ordered them. Of course, we shouldn't have expected
                    a five-star commander like General Gao to meddle with college underlings like us, but we wanted a solution
                    to our grim situation at hand.
                    We needed to someone to explain to us why. We demanded an answer to the most conceptual challenges at the
                    moment. We looked up at our screen and saw the name of the file that had been bugging us for hours.
                    Then, we knew exactly what was up and smiled at each other.
                    All we needed to do, all we would ever need to do was...to SubmitQ.</p>
                    <h4>Contact us if you have any questions</h4>
                    <p>
                        Harlin Lee: harlin@mit.edu <br>
                        Clare Liu: clareliu@mit.edu <br>
                        Jonathan Lim: dhlim@mit.edu <br>
                    </p>                    
                    
                </div>
                
            </div>
            
            <div id="push"></div>
<?php include("footer.php");?>
            
            
        </div><!--belongs to wrapper div-->
    </body>
</html>