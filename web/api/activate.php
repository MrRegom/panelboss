<?php
// Descubrimiento robusto de la raíz del proyecto
$baseDir = __DIR__;
while ($baseDir !== dirname($baseDir) && !file_exists($baseDir . '/vendor/autoload.php')) {
    $baseDir = dirname($baseDir);
}
define('PROJECT_ROOT', $baseDir);

require_once PROJECT_ROOT . '/vendor/autoload.php';
use App\Services\LicenseService;
use App\Config\Database;
header('Content-Type: application/json');

// Carga de variables de entorno simple
$envPath = __DIR__ . '/../../.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $_ENV[trim($parts[0])] = trim($parts[1], " \"'");
        }
    }
}

$apiKey = $_ENV['API_SHARED_KEY'] ?? 'CJYA_SECURE_API_88b2c45f107d6e';
$db = Database::getConnection();
$service = new LicenseService($db);
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SERVER['HTTP_X_CLIENT_ID']) || $_SERVER['HTTP_X_CLIENT_ID'] !== $apiKey) {
    http_response_code(401);
    exit(json_encode(['status' => 'error', 'message' => 'Unauthorized: X-Client-Id invalid']));
}

$licenseKey = $data['license_key'] ?? '';

// --- PARCHE DE EMERGENCIA: AUTO-SINCRONIZACIÓN ---
// Si no existe en la tabla licenses, buscamos en leads
$stmtCheck = $db->prepare("SELECT id FROM licenses WHERE license_key = ?");
$stmtCheck->execute([$licenseKey]);
if (!$stmtCheck->fetch()) {
    $stmtLead = $db->prepare("SELECT email FROM leads WHERE demo_license_key = ?");
    $stmtLead->execute([$licenseKey]);
    if ($stmtLead->fetch()) {
        // Existe en leads pero no en licenses. Creamos la licencia demo de 30 días.
        $expiresAt = date('Y-m-d', strtotime('+30 days'));
        $stmtInsert = $db->prepare("INSERT INTO licenses (license_key, plan, expires_at, status, created_at) VALUES (?, 'demo', ?, 'pending', NOW())");
        $stmtInsert->execute([$licenseKey, $expiresAt]);
    }
}
// -------------------------------------------------

$businessData = [
    'business_name' => $data['business_name'] ?? '',
    'rut' => $data['rut'] ?? '',
    'email' => $data['email'] ?? '',
    'address' => $data['address'] ?? '',
    'phone' => $data['phone'] ?? ''
];

$result = $service->activate(
    $licenseKey,
    $data['machine_id'] ?? '',
    $data['version'] ?? '1.0.0',
    $businessData
);

http_response_code($result['code']);
unset($result['code']);
echo json_encode($result);
