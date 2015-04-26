<?php
$ROOT = __DIR__;
require $ROOT.'/app.php';
require $ROOT.'/models/User.php';
require_once $ROOT.'/models/Photo.php';
require_once $ROOT.'/models/Payment.php';
require $ROOT.'/components/auth.php';

use \Models\User as users;
use \Models\Photo as photos;
use \Models\Payment as payments;
use \Components\Auth as auth;

// Do some checks to make sure they should be on this page
auth\requirePost();

$currUser = users\getCurrentUser();
$count = payments\getPPCountByUser($currUser->id);

if ($assignments->count <= $count) {
    $photos = implode(",", $_POST['premiumphotos']);
    // save the assignments
    photos\setPremium($currUser->id, $photos);

    $location = '/userProfile.php';
} else {
    $location = '/setPremiumPhotos.php?error';
}

header('Location: '.$location);
