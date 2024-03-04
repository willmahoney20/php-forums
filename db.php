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

    echo '<p style="color: white;">Hey ' . $dbDatabase . '</p>';
    
    try {
        // Create a new PDO instance using the environment variables
        $conn = new PDO("mysql:host=$dbHost;dbname=$dbDatabase", $dbUsername, $dbPassword);
        // Set PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo '<p style="color: white;">Connected Successfully</p>';
    } catch(PDOException $e) {
        echo '<p style="color: white;">Connection Failed</p>';
    }

?>