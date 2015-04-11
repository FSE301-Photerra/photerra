<?php namespace Components\Auth;
/**
 * Requires that the request type be a post
 */
function requirePost() {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header("HTTP/1.1 405 Method Not Allowed");
        exit;
    }
}

/**
 * If this user is logged in then they should be redirected somewhere else
 * @param string redirect
 */
function requireNoLogin($redirect) {
    session_start();
    if ($_SESSION['loggedIn']) {
        header("Location: " . $redirect);
        exit;
    }
}

/**
 * Requires that the user be logged in to access the page
 */
function requireLogin() {
    session_start();
    if (!$_SESSION['loggedIn']) {
        header("HTTP/1.1 401 Unauthorized");
        exit;
    }
}
