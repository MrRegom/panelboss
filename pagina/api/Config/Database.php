<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static $connection = null;

    public static function getConnection(): PDO {
        if (self::$connection === null) {
            $host = '127.0.0.1';
            $port = '5433';
            $db   = 'cajaya';
            $user = 'postgres';
            $pass = 'Rgomez2025..';
            
            $dsn = "pgsql:host=$host;port=$port;dbname=$db";
            try {
                self::$connection = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                // Por seguridad, en producción no se imprime el error completo
                die(json_encode(['success' => false, 'message' => 'Error crítico de conexión a la base de datos PostgreSQL.']));
            }
        }
        return self::$connection;
    }
}
