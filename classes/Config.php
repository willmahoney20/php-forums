<?php

class Config {
    public $env = 0; // 1 for production, 0 for development

	public $base_url = false;

	public $base_dir = false;

	public $db_host = false,
    $db_user = false,
    $db_pass = false,
    $db_name = false;

    public function __construct(){
        $this->setEnv();

		switch ($this->env) {
			case 1:
				$this->db_host = $_ENV['LIVE_DB_HOST'];
				$this->db_user = $_ENV['LIVE_DB_USERNAME'];
				$this->db_pass = $_ENV['LIVE_DB_PASSWORD'];
				$this->db_name = $_ENV['LIVE_DB_DATABASE'];

				$this->base_url = $_ENV['LIVE_BASE_URL'];
				$this->base_dir  = $_ENV['LIVE_BASE_DIR'];
				break;
			default:
				$this->db_host = $_ENV['DEV_DB_HOST'];
				$this->db_user = $_ENV['DEV_DB_USERNAME'];
				$this->db_pass = $_ENV['DEV_DB_PASSWORD'];
				$this->db_name = $_ENV['DEV_DB_DATABASE'];

				$this->base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
				$this->base_dir    = $_ENV['DEV_BASE_DIR'];
				break;
		}
    }

    public function setEnv(){
        if($_SERVER['HTTP_HOST'] === 'INSERT_PRODUCTION_URL'){
            $this->env = 1;
        } else {
            $this->env = 0;
        }
    }
}