<?php
/**
 * api/auth/login.php — Generación de Tokens de acceso (JWT)
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

// Descubrimiento de raíz y Carga de dependencias
$baseDir = __DIR__;
while ($baseDir !== dirname($baseDir) && !file_exists($baseDir . '/vendor/autoload.php')) {
    $baseDir = dirname($baseDir);
}
define('PROJECT_ROOT', $baseDir);
require_once PROJECT_ROOT . '/vendor/autoload.php';

use App\Config\Database;
use App\Services\AuthService;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido. Use POST.']);
    exit;
}

// Obtenemos la licencia (X-Client-Id)
$licenseKey = $_SERVER['HTTP_X_CLIENT_ID'] ?? $_POST['license_key'] ?? null;

if (!$licenseKey) {
    http_response_code(400);
    echo json_encode(['error' => 'Se requiere X-Client-Id para autenticar.']);
    exit;
}

try {
    $db = Database::getConnection();
    
    // Validar licencia en Base de Datos
    $stmt = $db->prepare("SELECT id, license_key FROM licenses WHERE license_key = :key AND status = 'active' LIMIT 1");
    $stmt->execute(['key' => $licenseKey]);
    $license = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!$license) {
        http_response_code(403);
        echo json_encode(['error' => 'Licencia inválida o inactiva.']);
        exit;
    }

    // Generar el Token
    $tokenData = AuthService::generateToken($license['id'], $license['license_key']);

    echo json_encode([
        'success' => true,
        'message' => 'Autenticación exitosa',
        'data' => $tokenData
    ]);

} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor de autenticación']);
}
