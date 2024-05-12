<?php
$routes = [
    '/laravel_foundation/week_l/Auth/' => 'register.php',
    '/laravel_foundation/week_l/Auth/login' => 'login.php',
    '/laravel_foundation/week_l/Auth/register' => 'register.php',
];
// $url = "/laravel_foundation/week_l/Auth/";
$url = $_SERVER['REQUEST_URI'];

function router($url, $routes)
{
    if (array_key_exists($url, $routes)) {
        $action =  $routes[$url];
        require 'controllers/' . $action;
    } else {
        http_response_code(404);
        require 'controllers/404.php';
    }
}


router($url, $routes);
