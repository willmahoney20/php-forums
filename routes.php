<?php

require_once 'classes/Posts.php';

$pageJS = [];

$router->get('/', function (){
	echo 'Home page' . '<br />';
});

$router->get('/login', function (){
	require_once 'views/login.php';
});

$router->mount('/posts', function () use ($router) {
	$router->get('/', function (){
		$posts = (new Posts)->getAllPosts();

		require_once 'views/posts.php';
	});

	$router->get('/(\w+)', function ($hash){
		$post = (new Posts)->getOnePost($hash);

		require_once 'views/post.php';
	});
});
