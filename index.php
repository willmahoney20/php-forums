<?php

// sets default timezone for all time functions used in the project
date_default_timezone_set('Europe/London');

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'classes/Config.php';
require 'classes/Database.php';
require 'classes/Router.php';
require 'helpers.php';

$CFG = new Config();

$db = new Database();
$posts = $db->query("SELECT * FROM forum_posts")->fetchAll(PDO::FETCH_ASSOC);

// require 'routes.php';

$router = new Router();

$router->run();

dd($CFG->base_dir);

// dd($posts);
