<?php
/**
 * create_prospectos_table.php — Inicialización de tabla de prospectos (V47)
 */
$host = 'localhost';
$port = '5433';
$dbname = 'cajaya';
$user = 'postgres';
$pass = 'Rgomez2025..';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    $sql = "CREATE TABLE IF NOT EXISTS public.prospectos (
        id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
        nombre VARCHAR(255),
        email VARCHAR(255) UNIQUE,
        whatsapp VARCHAR(50),
        fecha TIMESTAMP DEFAULT now(),
        status VARCHAR(50) DEFAULT 'nuevo'
    );";
    
    $pdo->exec($sql);
    echo "¡TABLA PROSPECTOS CREADA ÉLITE! 🚀";
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
