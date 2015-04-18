<?php
$ROOT = __DIR__;
require $ROOT.'/app.php';
require $ROOT.'/components/auth.php';

use \Components\Auth as auth;

// Do some checks to make sure they should be on this page
auth\requireLogin();

if (isset($_GET['status'])) {

    $status = FALSE;
    if ($_GET['status'] === 'success') {
        $status = TRUE;
    }

    // render template
    echo $twig->render('finishPayment.twig', array(
        'status' => $status,
    ));
} else {
    header('Location: /home.php');
    exit;
}
