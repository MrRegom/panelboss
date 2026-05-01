<?php
require_once dirname(__DIR__) . '/src/Config/Database.php';
use App\Config\Database;

try {
    $db = Database::getConnection();
    
    // 1. Identificar planes a mantener
    $keepSlugs = ['mensual', 'lifetime', 'empresa'];
    $placeholders = implode(',', array_fill(0, count($keepSlugs), '?'));
    
    // 2. Eliminar los que no están en la lista
    $stmt = $db->prepare("DELETE FROM subscription_plans WHERE slug NOT IN ($placeholders)");
    $stmt->execute($keepSlugs);
    
    $deleted = $stmt->rowCount();
    echo "SANEAMIENTO COMPLETADO: Se eliminaron $deleted planes fantasma de la base de datos. Solo quedan los 3 oficiales.";

} catch (\Exception $e) {
    echo "ERROR DE SANEAMIENTO: " . $e->getMessage();
}
