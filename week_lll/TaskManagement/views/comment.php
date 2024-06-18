<?php
$role = $_SESSION['user']['role_name'];

switch ($role) {
    case 'manager':
        include 'manager/comment.php';
        break;
    case 'employee':
        include 'employee/comment.php';
        break;
    default:
        include '404.php';
        break;
}
