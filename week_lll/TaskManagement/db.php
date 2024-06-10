<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";
global $conn;
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // returnResponse("Database connection established successfully");
}
