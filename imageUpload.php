<?php
require 'app.php';
require 'models/Photo.php';
require 'components/auth.php';

use \Models\Photo as photos;
use \Components\Auth as auth;

// Do so checks to make sure they should be on this page
auth\requirePost();
auth\requireLogin();

// TODO: do some validation on the input

// Populate the photo object with the data provided
$photo = new photos\Photo();
$photo->uid = $_SESSION['uid'];
$photo->lat = $_POST['lat'];
$photo->lat = $_POST['lat'];
$photo->title = $_POST['imageName'];
$photo->filename = substr(str_shuffle(MD5(microtime())), 0, 10);    // Generate random filename

// Attempt to upload the file
$uploadStatus = $photo->upload('fileToUpload');

if ($uploadStatus) {
    $redirect = '/?remarks=success';
} else {
    $redirect = '/?remarks=failure';
}

header("Location: " . $redirect);
