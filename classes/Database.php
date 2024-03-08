<?php

class Database {
    public $connection;

    public function __construct(){
        global $CFG;
        
        $dsn = "mysql:host=$CFG->db_host;dbname=$CFG->db_name";

        $this->connection = new PDO($dsn, $CFG->db_user, $CFG->db_pass);
        
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query($query, $params = []){
        $statement = $this->connection->prepare($query);
        $statement->execute($params);

        return $statement;
    }
}