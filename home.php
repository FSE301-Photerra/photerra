<?php
include 'app.php';

try {
    // render template
    echo $twig->render('home.twig', array(
    ));
} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}
