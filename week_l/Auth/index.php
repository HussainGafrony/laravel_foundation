<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './route.php';

if (isset($_SESSION['email'])) {
    header("Location: ./views/home.php");
}
include './layout/header.php';
$page = isset($_GET['p']) ? $_GET['p'] : 'login';
route($page);
include './layout/footer.php';

// echo "<pre>";
// print_r($_SERVER);
// echo "</pre>";
