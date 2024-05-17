<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_role";
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

        createTable($conn, 'id', 'email', 'role', 'password');
    } else {
        returnResponse("Error creating database: " . $conn->error);
    }
}


function createTable($conn, $id, $email, $role, $password)
{

    $sql = "CREATE TABLE IF NOT EXISTS users (
        $id INT(11) AUTO_INCREMENT PRIMARY KEY,
        $email VARCHAR(255) UNIQUE NOT NULL ,
        $role VARCHAR(25) NOT NULL,
        $password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) !== TRUE) {
        returnResponse("Error creating table: " . $conn->error);
    }
}

function Login()
{
    global $conn;

    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($email) && !empty($password)) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header('Location: ./index.php');
        } else {
            header('Location: ./index.php?msg=Invalid username or password');
        }
    } else {
        header('Location: ./index.php?msg=Invalid input.');
    }
    $conn->close();
}

function logout()
{
    session_unset();
    session_destroy();
    header("Location: ./index.php");
}
checkDB($conn, $dbname);
