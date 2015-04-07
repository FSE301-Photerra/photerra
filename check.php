<?php
if ($_SESSION['loggedIn'] || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: /home.php");
    die();
}

include 'connect.php';

$username = $_POST['username'];
$password = $_POST['password'];
  
// Build and run the user lookup
$query = sprintf("SELECT member_id, fname, lname FROM Users WHERE username = '%s' AND password = '%s';",
                 mysql_real_escape_string($username),
                 mysql_real_escape_string($password));

$result = mysqli_query($link, $query) or die(mysqli_error($link));

// Handle the result of the lookup
if (count($result)) {
    $row = mysqli_fetch_array($result, MYSQL_ASSOC);

    // Update the session
    session_start();
	$_SESSION['loggedIn'] = 1; 
	$_SESSION['userId'] = $row['member_id'];
	$_SESSION['firstname'] = $row['fname'];
	$_SESSION['lastname'] = $row['lname'];

 	header("Location: /home.php");
    die();
} else {	
	header("Location: /login.php?remarks=failure");
    die();
}
