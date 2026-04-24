<?php

namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static $host = "localhost";
    private static $db_name = "lumarecl_panelboss";
    private static $username = "lumarecl_userboss";
    private static $password = "Userboss2026..";
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn !== null) {
            return self::$conn;
        }

        try {
            self::$conn = new PDO(
                "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8mb4",
                self::$username,
                self::$password
            );
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            error_log("Connection error: " . $exception->getMessage());
            die("Error de conexión a la base de datos.");
        }

        return self::$conn;
    }
}
