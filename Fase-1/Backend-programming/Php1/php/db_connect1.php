<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "project4"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

mysqli_set_charset($conn, "utf8");
?>