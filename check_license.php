<?php
require_once __DIR__ . '/src/Config/Database.php';
use App\Config\Database;

$key = 'CJYA-2026-0862-281E-EAA0';
try {
    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT * FROM licenses WHERE license_key = :k");
    $stmt->execute(['k' => $key]);
    $license = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "DETALLES DE LICENCIA:\n";
    print_r($license);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
