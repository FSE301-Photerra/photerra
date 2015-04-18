<?php
$ROOT = __DIR__;
require $ROOT.'/app.php';
require $ROOT.'/components/auth.php';

use \Components\Auth as auth;

// Do some checks to make sure they should be on this page
auth\requireLogin();

// render template
echo $twig->render('cancelPayment.twig', array());

