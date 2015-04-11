<?php namespace Models\User;
// Include the database if needed
require_once __DIR__ . '/../db.php';
require 'Photo.php';
require 'Payment.php';

use \Models\Photo as photos;
use \Models\Payment as payments;

class User {
    public $id;
    public $username;
    public $password;
    public $firstname;
    public $lastname;
    public $email;
    public $createdOn;
    public $updatedOn;

    private $photos;
    private $payments;

    /**
     * Is this user the one that is currently logged into the system?
     * @return bool
     */
    function isCurrentUser() {
        session_start();
        return $this->id == $_SESSION['uid'];
    }

    /**
     * If this user has no payment history, then they haven't passed the
     * free 10 photo upload limit allotted to new users
     * OR
     * If they do have payment history then check to see if they are under
     * their 5 photo upload limit
     * @return bool
     */
    function canUploadPhoto() {
        $canUpload = FALSE;
        $photoCount = photos\getCountByUser($this->id);
        $paymentCount = payments\getCountByUser($this->id);
        $maxLimit = 10 + ($paymentCount * 5);

        if ($photoCount < $maxLimit) {
            $canUpload = TRUE;
        }

        return $canUpload;
    }

    /**
     * Gets the photos that were uploaded by this user
     * @return mixed
     */
    function getPhotos() {
        $this->photos = array();
        $result = photos\getByUser($this->id);

        // Add the photos from this user
        if ($result->num_rows) {
            while($row = mysqli_fetch_assoc($result)) {
                $tmp_photo = new photos\Photo();
                $tmp_photo->id = $row['id'];
                $tmp_photo->uid = $row['uid'];
                $tmp_photo->lat = $row['lat'];
                $tmp_photo->lng = $row['lng'];
                $tmp_photo->title = $row['title'];
                $tmp_photo->filename = $row['filename'];

                array_push($this->photos, $tmp_photo);
            }
        }

        return $this->photos;
    }

    /**
     * Gets the payments for this user
     * @return mixed
     */
    function getPayments() {
        $this->payments = array();
        $result = payments\getByUser($this->id);

        // Add the payments from this user
        if ($result->num_rows) {
            while($row = mysqli_fetch_assoc($result)) {
                $tmp_payment = new payments\Payment();
                $tmp_payment->id = $row['id'];
                $tmp_payment->uid = $row['uid'];
                $tmp_payment->typeId = $row['typeid'];
                $tmp_payment->typeDesc = $row['desc'];
                $tmp_payment->createdOn = $row['createdOn'];

                array_push($this->payments, $tmp_payment);
            }
        }

        return $this->payments;
    }

    /**
     * Saves or creates a user in the database
     */
    function save() {
        // If this is a user with an id update otherwise insert
        if (isset($this->id)) {
            $query = sprintf("UPDATE Users
                              SET username = '%s',
                                  firstname = '%s',
                                  lastname = '%s',
                                  email = '%s'
                              WHERE id = %u",
                              $this->username, $this->firstname, $this->lastname, $this->email, $this->id);
        } else {
            // The nulls are a trick to insert the default timestamp into both columns
            $query = sprintf("INSERT INTO Users (username, password, fname, lname, email, createdOn, updatedOn)
                              VALUES ('%s', '%s', '%s', '%s', '%s', NULL, NULL)",
                              $this->username, $this->password, $this->firstname, $this->lastname, $this->email);

        }

        $conn = \DB\getConnection();
        $result = $conn->query($query);

        // If this is a newly created user, then update the id with the
        // newly created one
        if (!isset($this->id)) {
            $this->id = $result->insert_id;
        }
    }
}

/**
 * Attepts to look up a user from the database and returns the query result
 * @param int id
 * @return mixed
 */
function getById($id) {

    // Run the query and get the user details
    $query = sprintf("SELECT * FROM Users WHERE id=%u",
                     $id);

    $conn = \DB\getConnection();
    $result = $conn->query($query);

    return $result;
}

/**
 * Attempts to log the user in with the provided credentials
 * @param string username
 * @param string password
 * @return bool
 */
function loginUser($username, $password) {
    // Run the query and get the user details
    $query = sprintf("SELECT * FROM Users WHERE username='%s' AND password='%s'",
                     $username,
                     $password);

    $conn = \DB\getConnection();
    $result = $conn->query($query);

    if ($result->num_rows) {
        $row = $result->fetch_array(MYSQL_ASSOC);

        // Update the session
        session_start();
        $_SESSION['loggedIn'] = 1; 
        $_SESSION['uid'] = $row['id'];

        $valid = TRUE;
    } else {
        $valid = FALSE;
    }

    return $valid;
}
