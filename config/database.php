<?php
    class Database{

        // specify your own database credentials
        private $host = "localhost";
        private $db_name = "agendabbdd_db";
        private $username = "root";
        private $password = "";
        public $conn;

        // get the database connection
        public function getConnection(){

            try{
               //$this->conn = null;
               $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
               //$this->conn = new PDO("pgsql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            }catch(PDOException $exception){
                echo "Connection error: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }
?>