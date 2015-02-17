<?php
//Load DB Connections etc.
//echo "hello";

$validLogin=false;
 $host="localhost";   //this will always be local host
    $databaseusername="cpses_phiaiBwBhI";  //phpmyadmin username
    $databasepassword="FSE3012015"; //password
    $db_name="photerras_DB";    //this is our only database in phpmyadmin which contains the user and video tables

$link=mysqli_connect("$host", "$databaseusername", "$databasepassword","$db_name")or die("cannot connect to server"); //connects to the database or if fails say "cannot connect to server"

//$query="GRANT SELECT ON sizzrp_data.* TO 'root'@'localhost' IDENTIFIED BY 'goworp1'";
//mysqli_query($link, $query) or die(mysqli_error($link));

$username=$_POST['username'];
$password=$_POST['password'];
   
   $query="SELECT * FROM User";//select all the elements of the user table, * represents "ALL"
$result=mysqli_query($link, $query) or die(mysqli_error($link));
//echo "flag1";
while($row = mysqli_fetch_array($result)) { 
  //echo $row[0] . "<br>"; 
  if($row[1]==$username)
  {
  	//echo "right username";
  	if($row[2]==$password)
  	{
  		//echo "right password";
  		$validLogin=true;
  		$member_id=$row[0];
  		
  	}
  }
 
} 
if($validLogin)
{
	$_SESSION["ValidLogin"]=true; 
 	header("Location: /userProfile.php?member_id=".$member_id);
 	exit;
}
else
{	
	$_SESSION["ValidLogin"]=false; 
	header("Location: /login.php");
	exit; 
}
?>