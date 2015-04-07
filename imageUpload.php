<?php

include 'connect.php';
echo "start";
$imageTitle=$_POST['imageName'];
echo "end";
$fileName=substr(str_shuffle(MD5(microtime())), 0, 10);
$target_dir = "pictures/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]) ;
$uploadOk = 1;

$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    $target_file = $target_dir . $fileName ;
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
$Lat=50.00;
$Lng=40.00;
session_start();
if($_SESSION['Logged_In']==1)
{
  $mem_id=$_SESSION["Id"];
}
else
{
  header("Location: /?remarks=failure");
  exit;
}
          
$query="INSERT INTO Photos (Lat,Lng,Title,Picture,User) VALUES ('$Lat','$Lng','$imageTitle','$fileName','$mem_id');";//select all the elements of the user table, * represents "ALL"
mysqli_query($link, $query) or die(mysqli_error($link));


header("Location: /");
?><?php

include 'connect.php';
echo "start";
$imageTitle=$_POST['imageName'];
echo "end";
$fileName=substr(str_shuffle(MD5(microtime())), 0, 10);
$target_dir = "pictures/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]) ;
$uploadOk = 1;

$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    $target_file = $target_dir . $fileName ;
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
$Lat=50.00;
$Lng=40.00;
session_start();
if($_SESSION['Logged_In']==1)
{
  $mem_id=$_SESSION["Id"];
}
else
{
  header("Location: /?remarks=failure");
  exit;
}
          
$query="INSERT INTO Photos (Lat,Lng,Title,Picture,User) VALUES ('$Lat','$Lng','$imageTitle','$fileName','$mem_id');";//select all the elements of the user table, * represents "ALL"
mysqli_query($link, $query) or die(mysqli_error($link));


header("Location: /");
?>