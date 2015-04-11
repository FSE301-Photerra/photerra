<?php
session_start();
// If the user is logged in or the request is invalid then send them elsewhere
if ($_SESSION['loggedIn'] || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: /home.php");
    exit;
}

require 'db.php';
require 'models/User.php';
use \Models\User as user;

$username = $_POST['username'];
$password = $_POST['password'];
  
// Attempt to log in the user with the provided credentials
$result = user\loginUser($username, $password);

// Handle the result of the login
if ($result) {
    $redirectLocation = "/home.php";

} else {	
	$redirectLocation = "/login.php?remarks=failure";
}

header("Location: " . $redirectLocation);
