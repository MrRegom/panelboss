<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            try {
                // CONFIGURACIÓN FINAL EXITOSA (Puerto 5433)
                $host = '127.0.0.1';
                $port = '5433'; // EL PUERTO CORRECTO
                $db   = 'cajaya';
                $user = 'postgres';
                $pass = 'Rgomez2025..';
                
                $dsn = "pgsql:host=$host;port=$port;dbname=$db";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                throw new PDOException("Error de conexión a PostgreSQL: " . $e->getMessage(), (int)$e->getCode());
            }
        }

        return self::$instance;
    }
}
