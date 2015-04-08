<?php
include 'vendor/autoload.php';
require_once 'vendor/twig/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

// Start up the twig environment
try {
    // specify where to look for templates
    $loader = new Twig_Loader_Filesystem('templates');

    // initialize Twig environment
    $twig = new Twig_Environment($loader);
  
} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}

session_start();

// If the session does not exist then initialize it
if (!isset($_SESSION['loggedIn'])) {
    $_SESSION['loggedIn'] = 0; 
    $_SESSION['userId'] = 0;
    $_SESSION['firstName'] = "";
    $_SESSION['lastName'] = "";
}

// Add the session to twig env
$twig->addGlobal('session', $_SESSION);
