<?php
require_once __DIR__ . '/admin/includes/bootstrap.php';
use App\Config\Database;

try {
    $db = Database::getConnection();
    $sql = "INSERT INTO licenses (license_key, status, created_at) 
            VALUES ('DEVELOPER-TEST', 'active', datetime('now')) 
            ON CONFLICT(license_key) DO UPDATE SET status='active'";
    $db->exec($sql);
    echo "Licencia DEVELOPER-TEST activada correctamente.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
