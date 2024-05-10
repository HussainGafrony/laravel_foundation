<?php
session_start();
function proccessLogin()
{
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $validationResult = validateLogin($email, $password);
        if ($validationResult !== true) {
            redirectToLoginPage($validationResult);
            header("Location: ./index.php?p=login&msg=" . $validationResult);
        } else {
            $_SESSION["email"] = $email;
            redirectToHomePage();
        }
    } else {
        redirectToLoginPage("404NotFound");
    }
}

function proccessRegister()
{
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $file = $_FILES["img"];
        $uploadDir = './upload/';

        $validationResult = validateRegister($name, $email, $password, $file, $uploadDir);

        if ($validationResult !== true) {
            redirectToRegisterPage($validationResult);
        } else {
            $_SESSION["name"] = $name;
            $_SESSION["email"] = $email;
            redirectToHomePage();
        }
    } else {
        redirectToRegisterPage("404NotFound");
    }
}



function handleFileUpload($file, $uploadDir)
{
    // Check if the uploaded file is an image
    if (!exif_imagetype($file['tmp_name'])) {
        return "Uploaded file is not an image.";
    }

    // Generate path for the uploaded file
    $newFileName = uniqid() . "." . explode('/', $file['type'])[1];
    $uploadPath = $uploadDir . $newFileName;
    var_dump($newFileName);
    // Move uploaded file to destination directory
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        return "Failed to move uploaded file.";
    } else {
        $_SESSION["img"] = $uploadPath;
        return true;
    }
}
function validateRegister($name, $email, $password, $file, $uploadDir)
{
    if (!isset($name) || empty($name)) {
        return "Invalid or empty Name.";
    }

    if (!isset($email) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid or empty email.";
    }

    if (!isset($password) || empty($password) || strlen($password) < 8) {
        return "Password must be at least 8 characters.";
    }
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        return "Invalid or empty Image.";
    } else {
        return handleFileUpload($file, $uploadDir);
    }
}

function validateLogin($email, $password)
{
    $users = [
        [
            'email' => 'ahmad@gmail.com',
            'password' => '123'
        ],
        [
            'email' => 'waled@gmail.com',
            'password' => '123'
        ]
    ];



    if (!isset($email) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !isset($password) || empty($password)) {
        return "Invalid or empty email or Password";
    } else {
        if (array_search($email, array_column($users, 'email')) !== false) {
            $user = $users[array_search($email, array_column($users, 'email'))];
            if ($user['password'] == $password) {
                return true;
            } else {
                return "incorrect password";
            }
        } else {
            return "your email does not exit in our data";
        }
    }
}

function logout()
{
    session_unset();
    session_destroy();
    header("Location: ./index.php");
}
function redirectToLoginPage($message)
{
    header("Location: ./index.php?p=login&msg=$message");
    exit();
}

function redirectToRegisterPage($message)
{
    header("Location: ./index.php?p=register&msg=$message");
    exit();
}

function redirectToHomePage()
{
    header("Location: ./views/home.php");
    exit();
}
