<?php

require_once 'classes/Authentication.php';
require_once 'classes/Users.php';
require_once 'classes/Posts.php';
require_once 'classes/Comments.php';

$authentication = new Authentication;

$pageJS = [];

$router->match('GET', '/', function (){
	header("Location: /posts");
});

$router->match('GET|POST', '/signup', function (){
	global $router, $CFG;

	Helpers::isLoggedIn($CFG->base_url);

	if($router->getRequestMethod() === 'POST' && isset($_POST['submit'])){
		(new Users)->createUser();
	}

	require_once 'views/signup.php';
});

$router->match('GET|POST', '/login', function (){
	global $router, $authentication, $CFG;

	Helpers::isLoggedIn($CFG->base_url);

	if($router->getRequestMethod() === 'POST' && isset($_POST['submit'])){
		$authentication->login();
	}

	require_once 'views/login.php';
});

$router->match('GET', '/logout', function () {
	Helpers::logout();
});

$router->mount('/posts', function () use ($router) {
	$router->match('GET|POST', '/', function (){
		global $router, $CFG, $pageJS;

		Helpers::isLoggedOut($CFG->base_url . 'login');

		if(isset($_GET['search'])) {
			$searchQuery = $_GET['search'];

			$posts = (new Posts)->searchPosts();
		} else {
			if($router->getRequestMethod() === 'POST' && isset($_POST['submit'])){
				(new Posts)->createPost();
			} elseif($router->getRequestMethod() === 'POST' && isset($_POST['delete'])){
				(new Posts)->deletePost();
			}
	
			$posts = (new Posts)->getAllPosts();
	
			$pageJS[] = $CFG->base_url . 'js/post.js';
		}

		require_once 'views/posts.php';
	});

	$router->match('GET|POST', '/edit/(\w+)', function ($hash){
		global $router, $CFG, $pageJS;

		Helpers::isLoggedOut($CFG->base_url . 'login');

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

		Helpers::isLoggedOut($CFG->base_url . 'login');

		if($router->getRequestMethod() === 'POST' && isset($_POST['delete'])){
			(new Posts)->deletePost();
		} elseif($router->getRequestMethod() === 'POST' && isset($_POST['submit'])){
			(new Comments)->createComment($hash);
		} elseif($router->getRequestMethod() === 'POST' && isset($_POST['deleteComment'])){
			(new Comments)->deleteComment();
		}

		$output = (new Posts)->getOnePost($hash);
		$post = $output->post;
		$comments = $output->comments;

		$content = '';

		$pageJS[] = $CFG->base_url . 'js/post.js';
		$pageJS[] = $CFG->base_url . 'js/comments.js';

		require_once 'views/post.php';
	});
});



$router->mount('/users', function () use ($router) {
	$router->match('GET', '/(\w+)', function ($hash){	
		global $CFG;

		Helpers::isLoggedOut($CFG->base_url . 'login');

		$user = (new Users)->getOneUser($hash);

		$posts = [];
		if($user) $posts = (new Posts)->getUserPosts($hash);
		
		require_once 'views/user.php';
	});
});