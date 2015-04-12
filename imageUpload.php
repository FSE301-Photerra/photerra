<?php
$ROOT = __DIR__;
require_once $ROOT.'/app.php';
require_once $ROOT.'/models/User.php';
require_once $ROOT.'/models/Photo.php';
require_once $ROOT.'/components/auth.php';

use \Models\User as users;
use \Models\Photo as photos;
use \Components\Auth as auth;

// Do so checks to make sure they should be on this page
auth\requirePost();
auth\requireLogin();
$currUser = users\getCurrentUser();

// Make sure that this user can upload a photo
if ($currUser->canUploadPhoto()) {
    // TODO: do some validation on the input
    // Populate the photo object with the data provided
    $photo = new photos\Photo();
    $photo->uid = $_SESSION['uid'];
    $photo->lat = $_POST['lat'];
    $photo->lng = $_POST['lng'];
    $photo->title = $_POST['imageName'];

    // Attempt to upload the file
    $uploadStatus = $photo->upload('fileToUpload');

    if ($uploadStatus) {
        $redirect = '/?remarks=success';
    } else {
        $redirect = '/?remarks=failure';
    }

// If they can't then take them to the payment page
} else {
    $redirect = '/makePayment.php?limit';
}

header("Location: " . $redirect);
