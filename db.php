<?php

    require_once __DIR__ . '/vendor/autoload.php';
    
    use Dotenv\Dotenv;
    
    // Load variables from the .env file
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    
    // Retrieve database connection variables from the environment
    $dbHost = $_ENV['DB_HOST'];
    $dbUsername = $_ENV['DB_USERNAME'];
    $dbPassword = $_ENV['DB_PASSWORD'];
    $dbDatabase = $_ENV['DB_DATABASE'];
    
    try {
        // Create a new PDO instance using the environment variables
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbDatabase", $dbUsername, $dbPassword);
        // Set PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo '<p style="color: white;">DB Connection Failed</p>';
    }
    
?>