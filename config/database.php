<?php
class Database {
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct(){
        // get environmental variables for database credentials
        $this->username = getenv('USERNAME');
        $this->password = getenv('PASSWORD');
        $this->db_name = getenv('DBNAME');
        $this->host = getenv('HOST');
        $this->port = getenv('PORT');
    }

    public function connect(){
        // check if connection is already established and return existing connection
        if($this->conn){
            return $this->conn;
        }
        else{
            // establish new connection with PDO
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";
            try{
                $this->conn = new PDO($dsn, $this->username, $this->password);
                // set error mode to exception to throw errors if they occur
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->conn;
            }
            catch(PDOException $e){
                // handle connection error and display message
                echo 'Connection Error: ' . $e->getMessage();
            } 
        }
    }
}