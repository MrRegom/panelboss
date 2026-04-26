<?php
require_once 'src/Config/Database.php';

use App\Config;

header('Content-Type: text/plain');

echo "--- DIAGNÓSTICO DE CONEXIÓN CAJAYA ---\n\n";

try {
    echo "Intentando conectar a la base de datos...\n";
    $conn = App\Config\Database::getConnection();
    echo "¡ÉXITO! Conexión establecida correctamente.\n";
    
    // Probar una consulta simple
    $stmt = $conn->query("SELECT version()");
    $version = $stmt->fetchColumn();
    echo "Versión de PostgreSQL: " . $version . "\n";
    
    // Verificar si existe la tabla de licencias
    $stmt = $conn->query("SELECT count(*) FROM information_schema.tables WHERE table_name = 'licencias'");
    $exists = $stmt->fetchColumn();
    echo "Tabla 'licencias': " . ($exists ? "EXISTE" : "NO EXISTE") . "\n";

} catch (\Exception $e) {
    echo "ERROR DE CONEXIÓN:\n";
    echo $e->getMessage() . "\n";
    echo "\nSugerencia: Revisa si la contraseña en el archivo .env coincide con la de tu PostgreSQL local.\n";
}
