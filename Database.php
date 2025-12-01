<?php

require_once "config.php";

// TODO SINGLETON

class Database
{
    private $username;
    private $password;
    private $port;
    private $host;
    private $database;
    private $conn;

    public function __construct()
    {
        db_params::load();
        $this->username = db_params::$USERNAME;
        $this->password = db_params::$PASSWORD;
        $this->port = db_params::$PORT;
        $this->host = db_params::$HOST;
        $this->database = db_params::$DATABASE;
    }

    public function connect()
    {
        try {
            $this->conn = new PDO(
                "pgsql:host=$this->host;port=$this->port;dbname=$this->database",
                $this->username,
                $this->password,
                ["sslmode" => "prefer"]
            );

            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    /*PDO automatycznie zamyka połączenie z bazą danych, 
    gdy obiekt PDO zostaje zniszczony lub skasowany. 
    Jednakże, można jawnie "rozłączyć" połączenie poprzez 
    ustawienie zmienną obiektu PDO na null*/
    public function disconnect()
    {
        $this->conn = null;
    }
}
