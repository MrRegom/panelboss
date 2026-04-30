<?php
/**
 * update_leads_schema.php — Inyección de WhatsApp en tabla oficial (V49)
 */
$host = 'localhost';
$port = '5433';
$dbname = 'cajaya';
$user = 'postgres';
$pass = 'Rgomez2025..';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    // Añadir columna de WhatsApp si no existe
    $pdo->exec("ALTER TABLE public.leads ADD COLUMN IF NOT EXISTS whatsapp VARCHAR(50);");
    
    echo "¡TABLA LEADS ACTUALIZADA CON ÉXITO! 🚀";
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
