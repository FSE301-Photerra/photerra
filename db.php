<?php namespace DB;

function getConnection() {
    $host = "localhost";              //this will always be local host
    $databaseusername = "root";       //phpmyadmin username
    $databasepassword = "";           //password
    $db_name = "photerras_DB";        //this is our only database in phpmyadmin which contains the user and video tables

    // Attempt to make the connection to the database
    $conn = new \mysqli($host, $databaseusername, $databasepassword, $db_name);

    if ($conn->connect_errno) {
        echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }

    return $conn;
}

function closeConnection($conn) {
    $conn->close();
} 
