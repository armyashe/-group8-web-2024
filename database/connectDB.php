<?php

function connect(){
    // Database credentials
    $servername = "localhost"; // Or your server name
    $username = "root"; // Your database username
    $password = ""; // Your database password
    $dbname = "showroom_db"; // Your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); // Display error message upon connection failure
    } 
    #echo "Connected successfully"; // Display message upon successful connection
    return $conn;
}

?>
