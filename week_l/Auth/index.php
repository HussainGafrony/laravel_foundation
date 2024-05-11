<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'route.php';


// if (isset($_SESSION['email'])) {
//     header("Location: ./views/home.php");
// }
