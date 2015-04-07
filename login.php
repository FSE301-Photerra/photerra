<?php
include 'app.php';

try {
    // Handle the status parameters
    $error = false;
    $success = false;

    if(isset($_GET['remarks'])) {
        if($_GET['remarks'] == 'failure') {
            $error = true;
        } elseif($_GET['remarks'] == 'success') {
            $success = true;
        }
    }

    // render template
    echo $twig->render('login.twig', array(
        'success' => $success,
        'error' => $error,
    ));

} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}
