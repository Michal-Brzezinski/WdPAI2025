<?php
require_once "config.php";

// singleton
class Database
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        db_params::load();
        $username = db_params::$USERNAME;
        $password = db_params::$PASSWORD;
        $host = db_params::$HOST;
        $port = db_params::$PORT;
        $database = db_params::$DATABASE;

        $dsn = "pgsql:host=$host;port=$port;dbname=$database";

        try {
            $this->conn = new PDO($dsn, $username, $password, ["sslmode" => "prefer"]);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function disconnect()
    {
        $this->conn = null;
        self::$instance = null;
    }
}
