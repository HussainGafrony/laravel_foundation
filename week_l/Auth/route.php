<?php

$path = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];

// $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove the specific part from the path
// $path = str_replace("/laravel_foundation/week_l/Auth/", "", $path);

// echo $path;


$routes = [
    '/' => 'controllers/login.php',
    '/login' => 'controllers/login.php',
    '/register' => 'controllers/register.php',
];


function router($path, $routes)
{

    if (array_key_exists($path, $routes)) {
        echo $routes[$path];
        return $routes[$path];
    } else {
        http_response_code(404);
        require 'controllers/404.php';
    }
}

router($path, $routes);
