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
            // Búsqueda robusta del archivo .env (subiendo niveles hasta encontrarlo)
            $envPath = null;
            $searchDir = __DIR__;
            while ($searchDir !== dirname($searchDir)) {
                if (file_exists($searchDir . DIRECTORY_SEPARATOR . '.env')) {
                    $envPath = $searchDir . DIRECTORY_SEPARATOR . '.env';
                    break;
                }
                $searchDir = dirname($searchDir);
            }
            
            // Cargar variables de entorno manualmente si el archivo existe
            if ($envPath) {
                $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (empty($line) || strpos($line, '#') === 0) continue;
                    $parts = explode('=', $line, 2);
                    if (count($parts) === 2) {
                        $_ENV[trim($parts[0])] = trim($parts[1], " \"'");
                    }
                }
            }

            // Configuración con valores por defecto para entorno Local (XAMPP)
            // Configuración con soporte para múltiples nombres de variables (Local vs Servidor)
            $host   = $_ENV['DB_HOST']     ?? 'localhost';
            $port   = $_ENV['DB_PORT']     ?? '5433';
            $db     = $_ENV['DB_NAME']     ?? $_ENV['DB_DATABASE'] ?? 'cajaya';
            $user   = $_ENV['DB_USER']     ?? $_ENV['DB_USERNAME'] ?? 'postgres';
            $pass   = $_ENV['DB_PASS']     ?? $_ENV['DB_PASSWORD'] ?? 'Rgomez2025..';
            $driver = $_ENV['DB_DRIVER']   ?? 'pgsql';

            try {
                // Establecemos la zona horaria de PHP para Chile
                date_default_timezone_set('America/Santiago');

                $dsn = "$driver:host=$host;port=$port;dbname=$db";
                self::$conn = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_TIMEOUT => 5 // Timeout de 5 segundos
                ]);

                // Forzamos a la base de datos a usar la zona horaria de Chile en esta sesión
                try {
                    self::$conn->exec("SET TIME ZONE 'America/Santiago'");
                } catch (\Exception $tzError) {
                    // Si falla el comando de zona horaria, no matamos la app (Error 500)
                    // Simplemente registramos el error y seguimos
                    error_log("DB TIMEZONE WARNING: " . $tzError->getMessage());
                }

            } catch(PDOException $e) {
                error_log("DB CONNECTION ERROR: " . $e->getMessage());
                // No matamos el proceso con exit, lanzamos la excepcion para que la App decida
                throw $e;
            }
        }
        return self::$conn;
    }
}
