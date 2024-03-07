<?php

$pageJS     = [];

$router->set404(function (){
	global $CFG;

    http_response_code(404);
	header('HTTP/1.1 404 Not Found');
	require_once($CFG->base_dir . 'views/404.php');
});

// $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

// $routes = [
//     '/' => 'controllers/index.php'
// ];

// function routeToController($uri, $routes){
//     if(array_key_exists($uri, $routes)){
//         require $routes[$uri];
//     } else {
//         abort();
//     }
// }

// function abort($code = 404){
//     http_response_code($code);

//     require "views/{$code}.php";

//     die();
// }

// routeToController($uri, $routes);
