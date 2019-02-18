<?php


class DBHelper {
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $port = 3306;
    private static $myDB = "cafe";
    private static $conn = null;

    static function connect() {
        try{
            self::$conn = new PDO("mysql:host=".self::$servername.
                "; dbname=".self::$myDB.
                "; port=".self::$port,
                self::$username,
                self::$password);
            // set the PDO error mode to exception
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->exec("SET NAMES 'utf8'");

        }catch(Exception $e){
            echo "Error: " . $e->getMessage();
            exit;
        }
        return self::$conn;
    }

    public static function disconnect() {
        self::$conn = null;
    }
}

?>