<?php
session_start();
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($email) && !empty($password)) {
        $user_data = checkLogin($email, $password);
        if (!$user_data) {
            returnResponse('invalide email or password');
            return;
        }
        if ($user_data['status'] !== 'active') {
            checkUserStatus($user_data);
            return;
        }
        $_SESSION['user'] = $user_data;
        header('Location: index.php');
    } else {
        returnResponse('Invalid input.');
    }
}
