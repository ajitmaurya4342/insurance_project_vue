<?php
include("header.php");
header("Content-Type: application/json; charset=utf-8");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "insurance_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


