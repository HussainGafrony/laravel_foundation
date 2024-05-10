<?php
function route($page)
{
    switch ($page) {
        case 'home':
            include './home.php';
            break;
        case 'about':
            include './about.php';
            break;
        case 'service':
            include './service.php';
            break;
        case 'causes':
            include './causes.php';
            break;
        case 'events':
            include './events.php';
            break;
        case 'contact':
            include './contact.php';
            break;
        case 'blog':
            include './blog.php';
            break;
        case 'gallery':
            include './gallery.php';
            break;
        case 'volunteer':
            include './volunteer.php';
            break;
        case 'notfound':
            include './404.php';
            break;
        default:
            include './404.php';
            break;
    }
}
