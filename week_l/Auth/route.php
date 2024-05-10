<?php
function route($page)
{
    switch ($page) {
        case 'login':
            include './views/login.php';
            break;
        case 'register':
            include './views/register.php';
            break;
        default:
            include './views/notFound.php';
            break;
    }
}
