<?php

require_once 'classes/Posts.php';
require_once 'classes/Comments.php';

$pageJS = [];

$router->match('GET', '/', function (){
	echo 'Home page' . '<br />';
});

$router->match('GET', '/login', function (){
	require_once 'views/login.php';
});

$router->mount('/posts', function () use ($router) {
	$router->match('GET|POST', '/', function (){
		global $router, $CFG, $pageJS;

		if($router->getRequestMethod() === 'POST' && isset($_POST['submit'])){
			(new Posts)->createPost();
		} elseif($router->getRequestMethod() === 'POST' && isset($_POST['delete'])){
			(new Posts)->deletePost();
		}

		$posts = (new Posts)->getAllPosts();

		$pageJS[] = $CFG->base_url . 'js/post.js';

		require_once 'views/posts.php';
	});

	$router->match('GET|POST', '/edit/(\w+)', function ($hash){
		global $router, $CFG, $pageJS;

		if($router->getRequestMethod() === 'POST' && isset($_POST['submit'])){
			(new Posts)->editPost();
		}

		$post = (new Posts)->getOnePostContent($hash);

		// set the content of the post as the initial value
		$content = '';
		if($post) $content = $post['content'];

		$pageJS[] = $CFG->base_url . 'js/post.js';

		require_once 'views/post-edit.php';
	});

	$router->match('GET|POST', '/(\w+)', function ($hash){
		global $router, $CFG, $pageJS;

		if($router->getRequestMethod() === 'POST' && isset($_POST['delete'])){
			(new Posts)->deletePost();
		}

		$output = (new Posts)->getOnePost($hash);
		$post = $output->post;
		$comments = $output->comments;

		$pageJS[] = $CFG->base_url . 'js/comments.js';

		require_once 'views/post.php';
	});
});
