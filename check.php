<?php

$validLogin=false;
include 'connect.php';

$username=$_POST['username'];
$password=$_POST['password'];

  
$query="SELECT * FROM Users";//select all the elements of the user table, * represents "ALL"
$result=mysqli_query($link, $query) or die(mysqli_error($link));

while($row = mysqli_fetch_array($result)) { 
  
  if($row[1]==$username)
  {
    
    if($row[2]==$password)
    {
      
      $validLogin=true;
      $member_id=$row[0];
      
    }
  }
 
} 


if($validLogin)
{
  session_start();
  $_SESSION['Logged_In']=1; 
  $_SESSION["Id"]=$member_id; 
  print_r($_SESSION);
  header("Location: /userProfile.php?member_id=".$member_id);
  exit;
}
else
{ 
  $_SESSION["Logged_In"]=false; 
  header("Location: /login.php?remarks=failure");
  exit; 
}

?>