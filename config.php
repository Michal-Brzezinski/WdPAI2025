<?php
// config.php

class db_params
{
    public static $USERNAME;
    public static $PASSWORD;
    public static $PORT;
    public static $HOST;
    public static $DATABASE;

    public static function load()
    {
        self::$USERNAME = getenv('DB_USER');
        self::$PASSWORD = getenv('DB_PASS');
        self::$PORT = getenv('DB_PORT');
        self::$HOST = getenv('DB_HOST');
        self::$DATABASE = getenv('DB_NAME');
    }
}
