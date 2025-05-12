<?php

/**
 * @author Robert Twelves
 * @created 23/02/2025
**/

use mysqli;

class Database {
    private static $connection = null;

    private function __construct() {} // Prevent instantiation

        public static function getConnection() {
        if (self::$connection === null) {
            $db_host = "sql206.iceiy.com"; // Your actual database host
            $db_user = "icei_38447729";
            $db_pass = "BusterBoy3924"; // Your actual database password
            $db_name = "icei_38447729_greenleaf"; // Your actual database name

            self::$connection = new mysqli($db_host, $db_user, $db_pass, $db_name);

            if (self::$connection->connect_error) {
                die("Database connection failed: " . self::$connection->connect_error);
            }
        }
        return self::$connection;
    }
}
?>

