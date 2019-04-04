<?php

require_once(ABSPATH . 'wp-config.php');
class DBHelper {
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "root";
    private static $port = 3306;
    private static $myDB = "cafe";
    private static $conn = null;

    static function connect() {
        try{
            self::$conn = new PDO("mysql:host=".DB_HOST.
                "; dbname=".DB_NAME.
                "; port=".self::$port,
                DB_USER,
                DB_PASSWORD);
            // set the PDO error mode to exception
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->exec("SET NAMES 'utf8'");

        }catch(Exception $e){
            exit;
        }
        return self::$conn;
    }

    public static function disconnect() {
        self::$conn = null;
    }
}

?>