<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include './route.php';
include './layout/header.php';

$page = isset($_GET['p']) ? $_GET['p'] : 'home';
route($page);

include './layout/footer.php';
