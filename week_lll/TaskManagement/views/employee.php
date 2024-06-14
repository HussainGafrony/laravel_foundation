<?php
$role = $_SESSION['user']['role_name'];

switch ($role) {
    case 'manager':
        include 'manager/employee.php';
        break;
    case 'admin':
        include 'admin/employee.php';
        break;
    default:
        include '404.php';
        break;
}
