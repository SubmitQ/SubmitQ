<?php

// Inialize session
session_start();
// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['Email']) || $_SESSION['UserType'] != "P") {
header('Location: index.php');
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Professor Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
</head>

<body>
Welcome, Professor
<p>This is a secured page with session: <b><?php echo $_SESSION['First_name'] . " " . $_SESSION['Last_name']; ?></b>
<p><a href="logout.php">Logout</a></p>
<a href="account_management.php">Account Management</a><br />
    <a href="add_class.php">Add Class</a>
    <?php include "questions.php" ?>

    <?php include "alert.php" ?>
</div>
</body>

</html>
