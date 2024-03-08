<?php

require_once 'classes/Posts.php';

$pageJS = [];

$router->match('GET', '/', function (){
	echo 'Home page' . '<br />';
});

$router->match('GET', '/login', function (){
	require_once 'views/login.php';
});

$router->mount('/posts', function () use ($router) {
	$router->match('GET', '/', function (){
		$posts = (new Posts)->getAllPosts();

		require_once 'views/explore.php';
	});

	$router->match('GET', '/(\w+)', function ($hash){
		$post = (new Posts)->getOnePost($hash);

		require_once 'views/explore.php';
	});
});
