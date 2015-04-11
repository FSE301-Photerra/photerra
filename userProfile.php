<?php
require 'app.php';
require 'models/user.php';

use \Models\User as user;

$id = $_GET['id'];

// If an id was not provided check to see if the user is logged in
if (!isset($id)) {
    session_start();
    $id = $_SESSION['uid'];
}

// Attempt to look up the user
$result = user\getById($id);

// If this is a valid user then show the user's profile page, otherwise render a 404
if ($result->num_rows) {
    // parse the query results
    // TODO: populate user from query?
    while($row = mysqli_fetch_assoc($result)) {
        $user = new user\User();
        $user->id = $row["id"];
        $user->firstname = $row["firstname"];
        $user->lastname = $row["lastname"];
        $user->email = $row["email"];
    }

    // render template
    echo $twig->render('profile.twig', array(
        'user' => $user,
        'photos' => $user->getPhotos(),
        'payments' => $user->getPayments(),
    ));

} else {
    header("HTTP/1.1 404 Not Found");
    echo $twig->render('404.twig', array());
}
