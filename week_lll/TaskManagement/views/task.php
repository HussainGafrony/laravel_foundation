<?php
$role = $_SESSION['user']['role_name'];

switch ($role) {
    case 'manager':
        include 'manager/task.php';
        break;
    case 'admin':
        include 'admin/task.php';
        break;
    case 'employee':
        include 'employee/task.php';
        break;
    default:
        include '404.php';
        break;
}
