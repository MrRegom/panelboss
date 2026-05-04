<?php
header('Content-Type: application/json');

// Descubrimiento robusto de la raíz del proyecto
$baseDir = __DIR__;
while ($baseDir !== dirname($baseDir) && !file_exists($baseDir . '/vendor/autoload.php')) {
    $baseDir = dirname($baseDir);
}
define('PROJECT_ROOT', $baseDir);

require_once PROJECT_ROOT . '/vendor/autoload.php';

use App\Services\LicenseService;
use App\Config\Database;

try {
    $db = Database::getConnection();
    
    // Obtenemos la última licencia para testear
    $stmt = $db->query("SELECT license_key, machine_id, plan FROM licenses ORDER BY id DESC LIMIT 1");
    $license = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$license) {
        echo json_encode(['error' => 'No hay licencias en la DB']);
        exit;
    }

    $service = new LicenseService($db);
    // Ejecutamos la lógica real de activación (simulada)
    $res = $service->activate($license['license_key'], $license['machine_id'], '1.0.0', []);

    echo json_encode([
        'INFO' => 'Diagnóstico de Respuesta API CajaYa',
        'FECHA' => date('c'),
        'URL_ACTUAL' => $_SERVER['REQUEST_URI'],
        'RESPONSE_REAL' => $res
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
