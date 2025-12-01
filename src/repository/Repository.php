<?php

require_once __DIR__ . '/../../Database.php';

class Repository
{
    protected $database;

    public function __construct()
    {
        // używam Singletona
        $this->database = Database::getInstance()->getConnection();
    }
}
