<?php

// sets default timezone for all time functions used in the project
date_default_timezone_set('Europe/London');

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'Config.php';
require 'Database.php';
require 'helpers.php';

$CFG = new Config();

$db = new Database();
$posts = $db->query("SELECT * FROM forum_posts")->fetchAll(PDO::FETCH_ASSOC);

// require 'router.php';

dd($posts);
