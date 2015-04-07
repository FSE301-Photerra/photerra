<?php
include 'vendor/Autoloader.php';

require_once 'vendor/twig/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

try {
  // specify where to look for templates
  $loader = new Twig_Loader_Filesystem('templates');
  
  // initialize Twig environment
  $twig = new Twig_Environment($loader);
  
} catch (Exception $e) {
  die ('ERROR: ' . $e->getMessage());
}
