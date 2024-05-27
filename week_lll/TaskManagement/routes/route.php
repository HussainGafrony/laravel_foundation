<?php
function route($page)
{
    switch ($page) {
        case 'team':
            include 'views/team.php';
            break;
        case 'profile':
            include 'views/profile.php';
            break;
        case 'service':
            include './service.php';
            break;

        case 'notfound':
            include 'views/404.php';
            break;
        default:
            include 'views/404.php';
            break;
    }
}
