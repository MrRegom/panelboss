<?php

namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static $conn = null;

    /**
     * Obtiene la conexión a la base de datos cargando la configuración desde .env si existe.
     */
    public static function getConnection() {
        if (self::$conn === null) {
            // Ruta al archivo .env en la raíz del proyecto
            $envPath = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . '.env';
            
            // Cargar variables de entorno manualmente si el archivo existe
            if (file_exists($envPath)) {
                $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    if (strpos(trim($line), '#') === 0) continue;
                    $parts = explode('=', $line, 2);
                    if (count($parts) === 2) {
                        $_ENV[trim($parts[0])] = trim($parts[1], " \"'");
                    }
                }
            }

            // Configuración con valores por defecto para entorno Local (XAMPP)
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $port = $_ENV['DB_PORT'] ?? '5433';
            $db   = $_ENV['DB_NAME'] ?? 'cajaya';
            $user = $_ENV['DB_USER'] ?? 'postgres';
            $pass = $_ENV['DB_PASS'] ?? 'Rgomez2025..';
            $driver = $_ENV['DB_DRIVER'] ?? 'pgsql';

            try {
                $dsn = "$driver:host=$host;port=$port;dbname=$db";
                self::$conn = new PDO($dsn, $user, $pass);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                error_log("Error de conexión: " . $e->getMessage());
                die("Error crítico de infraestructura. Por favor, contacte al administrador.");
            }
        }
        return self::$conn;
    }
}
