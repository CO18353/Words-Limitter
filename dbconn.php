<?php
    //Constants
    DEFINE('DBHOST','localhost');
    DEFINE('DBUSER', 'root');
    DEFINE('DBPW', '');
    DEFINE('DBNAME', 'clientdb');
    // Create connection
    $conn = new mysqli(DBHOST, DBUSER, DBPW, DBNAME);

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    exit();
    }
?>