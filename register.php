<?php
include 'app.php';

try {
    // render template
    echo $twig->render('register.twig', array(
    ));
} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}
