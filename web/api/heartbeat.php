<?php
require_once __DIR__ . '/../../vendor/autoload.php';
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

$apiKey = $_ENV['API_SHARED_KEY'] ?? 'CJYA_SECURE_API_88b2c45f107d6e8';
$service = new LicenseService(Database::getConnection());
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SERVER['HTTP_X_API_KEY']) || $_SERVER['HTTP_X_API_KEY'] !== $apiKey) {
    http_response_code(401);
    exit(json_encode(['error' => 'Invalid X-API-Key']));
}

$result = $service->heartbeat(
    $data['license_key'] ?? '',
    $data['machine_id'] ?? '',
    $data['version'] ?? '1.0.0',
    $data['stats'] ?? []
);

http_response_code($result['code']);
unset($result['code']);
echo json_encode($result);
