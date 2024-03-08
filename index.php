<?php

// sets default timezone for all time functions used in the project
date_default_timezone_set('Europe/London');

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'classes/Config.php';
require 'classes/Database.php';
require 'classes/Router.php';
require 'classes/Helpers.php';

$CFG = new Config();

$db = new Database();

$router = new Router();

require_once 'routes.php';

$router->handleRequest($_SERVER['REQUEST_METHOD']);
