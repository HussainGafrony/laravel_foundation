<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "manage_user";
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

        createTable($conn, 'id', 'name', 'email', 'age', 'password');
    } else {
        returnResponse("Error creating database: " . $conn->error);
    }
}


function createTable($conn, $id, $name, $email, $age, $password)
{

    $sql = "CREATE TABLE IF NOT EXISTS users (
        $id INT(11) AUTO_INCREMENT PRIMARY KEY,
        $name VARCHAR(255) NOT NULL,
        $email VARCHAR(255) UNIQUE NOT NULL ,
        $age INT(3) NOT NULL,
        $password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) !== TRUE) {
        returnResponse("Error creating table: " . $conn->error);
    }
}


function getUsers()
{
    global $conn;
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user = array(
                "id" => $row["id"],
                "name" => $row["name"],
                "email" => $row["email"],
                "age" => $row["age"]
            );
            $users[] = $user;
        }
    } else {
        $users = array();
    }
    $conn->close();
    return $users;
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
