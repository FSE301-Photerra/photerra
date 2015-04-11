<?php

class Point {
    public $name = "";
    public $uid = "";
    public $currUser = "";
    public $location = array();
    public $imagePath = "";

    function __construct($name, $uid, $currUser, $location, $imagePath) {
        $this->name = $name;
        $this->uid = $uid;
        $this->currUser = $currUser;
        $this->location = $location;
        $this->imagePath = $imagePath;
    }
}

// Hard coded tmp values
$points = array(
    new Point('A super cool spot', '5df6ae72b9', false, array(32.7150,-117.1625), 'assets/images/sandiego7.jpg'),
);

// to show that the loading of points on the map is asynchronous
sleep(2);

header('Content-Type: application/json');
echo json_encode($points);
