<?php
$ROOT = __DIR__;
require $ROOT.'/app.php';
require $ROOT.'/models/User.php';
require_once $ROOT.'/models/Payment.php';
require $ROOT.'/components/auth.php';

use \Models\User as users;
use \Models\Payment as payments;
use \Components\Auth as auth;

// Do some checks to make sure they should be on this page
auth\requireLogin();

$currUser = users\getCurrentUser();

// Attempt to look up the user
$count = payments\getPPCountByUser($currUser->id);

if ($count > 0) {
    // render template
    echo $twig->render('setPremium.twig', array(
        'user' => $currUser,
        'photos' => $currUser->getPhotos(),
        'payments' => $currUser->getPayments(),
        'ppcount' => $count,
    ));
} else {
    header('Location: /makePayment.php');
    exit;
}
