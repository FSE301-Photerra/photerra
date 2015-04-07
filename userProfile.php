<?php
include 'app.php';
include 'connect.php';

try {
    $id = $_GET['id'];

    // Run the query and get the user details
    $query = sprintf("SELECT fname,lname,username FROM Users WHERE member_id='%s'",
                     $id);
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if (mysql_num_rows($result)) {
        // parse the query results
        while($row = mysqli_fetch_assoc($result)) {
            $fname=$row["fname"];
            $lname=$row["lname"];
            $username=$row["username"];
        }

        // render template
        echo $twig->render('profile.twig', array(
            'firstname' => $fname,
            'lastname' => $lname,
            'username' => $username,
        ));
    } else {
        header("HTTP/1.1 404 Not Found");
        echo $twig->render('404.twig', array(
        ));
    }

} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}
