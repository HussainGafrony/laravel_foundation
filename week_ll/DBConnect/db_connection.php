<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_connect";
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function checkDB($conn, $dbname)
{
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) === TRUE) {
        // Use the database
        $conn->select_db($dbname);

        createTable($conn, 'id', 'name', 'email', 'password');
    } else {
        returnResponse("Error creating database: " . $conn->error);
    }
}


function createTable($conn, $id, $name, $email, $password)
{

    $sql = "CREATE TABLE IF NOT EXISTS users (
        $id INT(11) AUTO_INCREMENT PRIMARY KEY,
        $name VARCHAR(255) NOT NULL,
        $email VARCHAR(255) UNIQUE NOT NULL ,
        $password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) !== TRUE) {
        returnResponse("Error creating table: " . $conn->error);
    }
}


// insert data 
function insertData($name, $email, $password, $table)
{
    global $conn;
    global $dbname;
    $conn->select_db($dbname);
    $sql = "INSERT INTO $table (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) !== TRUE) {
        returnResponse("Error: " . $sql . "<br>" . $conn->error);
    }
}

function getUsers()
{
    global $conn;
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $output = '<pre>' . "id: " . $row["id"] . " - Name: " . $row["name"] . " -  Email :  " . $row["email"] . " " . '</pre>';
            echo $output;
        }
    } else {
        $output = "0 results";
    }
    $conn->close();
    return $output;
}

function returnResponse($msg)
{
    if (isset($msg) && $msg !== '') {
        header('Location: ./index.php?msg=' . $msg);
    } else {
        header('Location: ./index.php?msg=message empty');
    }
}



checkDB($conn, $dbname);
