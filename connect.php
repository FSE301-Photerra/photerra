<?php
$host="localhost";   //this will always be local host
$databaseusername="Main";  //phpmyadmin username
$databasepassword="billy123"; //password
$db_name="photerras_DB";    //this is our only database in phpmyadmin which contains the user and video tables
$link=mysqli_connect("$host", "$databaseusername", "$databasepassword","$db_name")or die("Cannot connect to server"); //connects to the database or if fails say "cannot connect to server"
?>