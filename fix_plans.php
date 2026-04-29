<?php
/**
 * fix_plans.php — Sincronización Forzada de Planes
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Config/Database.php';

use App\Config\Database;

try {
    $db = Database::getConnection();
    
    // 1. Limpiar tabla para evitar duplicados o slugs erróneos
    $db->exec("DELETE FROM subscription_plans WHERE slug IN ('mensual', 'lifetime', 'empresa')");
    
    // 2. Insertar los 3 planes con datos exactos
    $stmt = $db->prepare("INSERT INTO subscription_plans (name, slug, price, duration_days, description) VALUES (?, ?, ?, ?, ?)");
    
    // Plan Mensual
    $stmt->execute(['Plan Mensual', 'mensual', 20000, 30, 'Acceso mensual completo']);
    
    // Plan Lifetime
    $stmt->execute(['Plan Lifetime', 'lifetime', 180000, 9999, 'Acceso de por vida']);
    
    // Plan Empresa
    $stmt->execute(['Plan Empresa', 'empresa', 35000, 30, 'Gestión multi-caja y soporte avanzado']);
    
    echo "¡ÉXITO! Los 3 planes han sido recreados correctamente en la base de datos.\n";
    echo "Slugs activos: mensual, lifetime, empresa.\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
