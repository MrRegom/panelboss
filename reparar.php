<?php
/**
 * admin/reparar.php — Script de Reparación de Despliegue
 */
require_once __DIR__ . '/includes/bootstrap.php';
use App\Config\Database;
use App\Services\AuthService;

AuthService::check();

echo "<h3>🛠️ Iniciando Reparación de CajaYa...</h3>";

try {
    $db = Database::getConnection();

    // 1. Mover archivo de documentación si quedó anidado
    $nested = __DIR__ . '/admin/api_docs.php';
    $target = __DIR__ . '/api_docs.php';
    
    if (file_exists($nested)) {
        if (copy($nested, $target)) {
            echo "✅ Documentación movida a: /admin/api_docs.php<br>";
        }
    } else {
        echo "ℹ️ El archivo de documentación ya parece estar en su lugar o no se encontró anidado.<br>";
    }

    // 2. Insertar Licencia DEVELOPER-TEST
    // Buscamos la primera empresa disponible para asociarla
    $empresa = $db->query("SELECT id FROM companies LIMIT 1")->fetch();
    $empresaId = $empresa ? $empresa['id'] : 1;

    $sql = "INSERT INTO licenses (license_key, company_id, plan_id, status, created_at, expires_at) 
            VALUES ('DEVELOPER-TEST', :company_id, 1, 'active', datetime('now'), '2030-01-01 00:00:00') 
            ON CONFLICT(license_key) DO UPDATE SET status='active', company_id=:company_id";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([':company_id' => $empresaId]);
    
    echo "✅ Licencia 'DEVELOPER-TEST' activada y vinculada a Empresa ID: $empresaId<br>";

    echo "<br><b style='color:green'>🎉 Reparación completada con éxito.</b><br>";
    echo "<a href='api_docs.php'>Ir a la Documentación ahora</a>";

} catch (Exception $e) {
    echo "<b style='color:red'>❌ Error durante la reparación: " . $e->getMessage() . "</b>";
}
