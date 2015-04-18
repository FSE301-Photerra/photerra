<?php
$ROOT = __DIR__;
require $ROOT.'/app.php';
require $ROOT.'/models/User.php';
require $ROOT.'/components/auth.php';

use \Models\User as users;
use \Components\Auth as auth;

// Do some checks to make sure they should be on this page
auth\requireLogin();

$currUser = users\getCurrentUser();

// render template
echo $twig->render('makePayment.twig', array(
    'user' => $currUser,
    'hitLimit' => isset($_GET['limit']),
));
