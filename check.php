<?php
// If the user is logged in or the request is invalid then send them elsewhere
if ($_SESSION['loggedIn'] || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: /home.php");
    exit;
}

include 'connect.php';

$username = $_POST['username'];
$password = $_POST['password'];
  
// Build and run the user lookup
$query = sprintf("SELECT member_id, fname, lname FROM Users WHERE username = '%s' AND password = '%s';",
                 mysql_real_escape_string($username),
                 mysql_real_escape_string($password));

$result = mysqli_query($link, $query)
            or die(mysqli_error($link));

// Handle the result of the lookup
if ($result->num_rows) {
    $row = mysqli_fetch_array($result, MYSQL_ASSOC);

    // Update the session
    session_start();
	$_SESSION['loggedIn'] = 1; 
	$_SESSION['mid'] = $row['member_id'];

 	header("Location: /home.php");
    exit;
} else {	
	header("Location: /login.php?remarks=failure");
    exit;
}
