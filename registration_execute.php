<?php
$ROOT = __DIR__;
require $ROOT.'/models/User.php';
use \Models\User as users;

$validInput = 1;
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// If the input is valid then create the account
if ($validInput) {
    $user = new users\User();
    $user->firstname = $fname;
    $user->lastname = $lname;
    $user->username = $username;
    $user->password = $password;
    $user->email = $email;

    // Save the new user
    $user->save();

    $redirect = '/login.php?remarks=success';

// If the input was invalid take them back to the register page
} else {
    $redirect = '/register.php?remarks=failure';
}

header("location: ".$redirect);
