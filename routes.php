<?php

require_once 'classes/Posts.php';

$pageJS = [];

$router->addRoute('GET', '/', function (){
	echo 'Home page' . '<br />';
});

$router->addRoute('GET', '/login', function (){
	require_once 'views/login.view.php';
});

$router->addRoute('GET', '/posts', function (){
	$posts = (new Posts)->getPosts();

	require_once 'views/index.view.php';
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
