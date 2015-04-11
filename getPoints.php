<?php
$ROOT = __DIR__;
require_once $ROOT.'/app.php';
require_once $ROOT.'/models/User.php';
require_once $ROOT.'/models/Photo.php';
use \Models\User as users;
use \Models\Photo as photos;

$currUser = users\getCurrentUser();
$qPhotos = photos\getAll();

$points = array();

// Populate the result
while($row = mysqli_fetch_assoc($qPhotos)) {
    $tmp_point = new photos\Point();

    $tmp_point->name = $row['title'];
    $tmp_point->uid = $row['uid'];
    $tmp_point->currUser = $row['uid'] === $currUser->id;
    $tmp_point->location = array($row['lat'], $row['lng']);
    $tmp_point->imagePath = $ROOT.'/pictures/'.$row['filename'];

    array_push($points, $tmp_point);
}

header('Content-Type: application/json');
echo json_encode($points);
