<?php
$role = $_SESSION['user']['role_name'];

switch ($role) {
    case 'manager':
        include 'manager/statistics.php';
        break;
    case 'admin':
        include 'admin/statistics.php';
        break;
    case 'empolyee':
        include 'empolyee/statistics.php';
        break;
    default:
        include '404.php';
        break;
}
