<?php

function Connection(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "legomarket";

    global $conn;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>