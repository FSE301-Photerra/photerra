<?php
include 'app.php';
include 'connect.php';

try {
    $member_id=$_GET['member_id'];

    // Run the query and get the user details
    $query="SELECT fname,lname,username FROM Users WHERE member_id='$member_id'";
    $result=mysqli_query($link, $query) or die(mysqli_error($link));

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

} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}
