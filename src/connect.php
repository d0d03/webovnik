<?php
$servername = "eu-cdbr-west-03.cleardb.net";
$username = "b773df711ef6f5";
$password = "e51efee0";
$dbname = "heroku_686be04e1aa8e02";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
