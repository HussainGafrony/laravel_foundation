<?php
function route($page)
{
    switch ($page) {
        case 'statistics':
            include 'views/statistics.php';
            break;
        case 'manager':
            include 'views/manager.php';
            break;
        case 'employee':
            include 'views/employee.php';
            break;
        case 'task':
            include 'views/task.php';
            break;
        case 'comment':
            include 'views/comment.php';
            break;
        case 'profile':
            include 'views/profile.php';
            break;
        case 'login':
            include 'views/login.php';
            break;
        case 'notfound':
            include 'views/404.php';
            break;
        default:
            include 'views/404.php';
            break;
    }
}
