<?php namespace Models\Photo;
$ROOT = __DIR__ . '/..';
require_once $ROOT.'/db.php';
require_once $ROOT.'/components/utilities.php';
use \Components\Utilities as utils;

/**
 * The main photo model
 */
class Photo {
    public $id;         // Unique id
    public $uid;         // Uploading users id
    public $lat;         // Location information
    public $lng;
    public $title;    
    public $filename;    // File location
    public $isPremium;
    public $createdOn;

    /**
     * Upload the image file to the server and returns the status of the operation.
     * And if everything is ok then save the details to the database
     * @param string $photoField name of form field
     * @returns bool
     */
    function upload($photoField) {
        // Attempt to upload the file
        $status = utils\uploadImageFile($this, $photoField);

        // If everything is ok then save the photo details
        if ($status) {
            $this->save();
        }

        return $status;
    }

    /**
     * Saves or creates a photo in the database
     */
    function save() {
        // If this is a photo with an id update otherwise insert
        if (isset($this->id)) {
            $query = sprintf("UPDATE Photos
                              SET lat = '%s',
                                  lng = '%s',
                                  title = '%s',
                                  filename = '%s',
                                  isPremium = %d
                              WHERE uid = %u",
                              $this->lat, $this->lng, $this->title, $this->filename, $this->isPremium, $this->uid);
        } else {
            $query = sprintf("INSERT INTO Photos (uid, lat, lng, title, filename)
                              VALUES (%u, '%s', '%s', '%s', '%s')",
                              $this->uid, $this->lat, $this->lng, $this->title, $this->filename);
        }

        $conn = \DB\getConnection();
        $result = $conn->query($query);

        // If this is a newly created photo, then update the id with the
        // newly created one
        if (!isset($this->id)) {
            $this->id = $result->insert_id;
        }
    }
}

/**
 * A point is the data format that is sent to the main page to plot the points
 */
class Point {
    public $name;
    public $uid;
    public $imagePath;
    public $currUser = FALSE;
    public $location = array();

    function __construct($name, $uid, $currUser, $location, $imagePath) {
        $this->name = $name;
        $this->uid = $uid;
        $this->currUser = $currUser;
        $this->location = $location;
        $this->imagePath = $imagePath;
    }
}

/**
 * Attepts to look up a picture by id
 * @param int $id
 * @return mixed
 */
function getById($id) {
    // Run the query and get the photo details
    $query = sprintf("SELECT * FROM Photos WHERE id=%u",
                     $id);

    $conn = \DB\getConnection();
    $result = $conn->query($query);

    return $result;
}

/**
 * Look up all the pictures for a given user
 * @param int $uid
 * @return mixed
 */
function getByUser($uid) {
    // Run the query and get the user details
    $query = sprintf("SELECT * FROM Photos WHERE uid=%u",
                     $uid);

    $conn = \DB\getConnection();
    $result = $conn->query($query);

    return $result;
}

/**
 * Gets a count of the number of photos uploaded by this user
 * @param int $uid
 * @return int
 */
function getCountByUser($uid) {
    $count = 0;

    // Run the query and get the user details
    $query = sprintf("SELECT COUNT(*) AS PhotoCount FROM Photos WHERE uid=%u",
                     $uid);

    $conn = \DB\getConnection();
    $result = $conn->query($query);
    $row = mysqli_fetch_assoc($result);
    $count = $row['PhotoCount'];

    return $count;
}

/**
 * Gets all the photos in the system
 * @return mixed
 */
function getAll() {
    // Run the query and get the user details
    $query = sprintf("SELECT * FROM Photos");

    $conn = \DB\getConnection();
    $result = $conn->query($query);

    return $result;
}