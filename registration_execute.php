<?php
session_start();
include 'connect.php';

$fname=$_POST['fname'];
$lname=$_POST['lname'];
$email=$_POST['email'];
$username=$_POST['username'];
$password=$_POST['password'];
$member_id=substr(str_shuffle(MD5(microtime())), 0, 10);


mysqli_query($link,"INSERT INTO Users(member_id, username, password,fname, lname, email)VALUES('$member_id','$username', '$password','$fname', '$lname','$email')");
mysqli_close($link);
header("location: /login.php?remarks=success");
?>
