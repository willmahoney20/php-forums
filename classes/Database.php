<?php

class Database {
    public $connection;

    public $statement;

    public function __construct(){
        global $CFG;
        
        $dsn = "mysql:host=$CFG->db_host;dbname=$CFG->db_name";

        $this->connection = new PDO($dsn, $CFG->db_user, $CFG->db_pass);
        
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query($query, $params = []){
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);

        return $this;
    }

    public function findOne(){
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll(){
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
}