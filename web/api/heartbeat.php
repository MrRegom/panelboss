<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Services\LicenseService;
header('Content-Type: application/json');

$apiKey = $_SERVER['HTTP_X_API_KEY'] ?? '';
if ($apiKey !== 'abc123shared') {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid X-API-Key']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$service = new LicenseService(\App\Config\Database::getConnection());
$result = $service->heartbeat(
    $data['license_key'] ?? '',
    $data['machine_id'] ?? '',
    $data['version'] ?? '1.0.0',
    $data['stats'] ?? []
);

// Registrar log si fue exitoso
if ($result['code'] === 200) {
    $repo = new \App\Repositories\LicenseRepository(\App\Config\Database::getConnection());
    $license = $repo->findByLicenseKey($data['license_key'] ?? '');
    if ($license) {
        $repo->createHeartbeatLog($license['id'], $data['machine_id'] ?? '', $data['version'] ?? '1.0.0', $data['stats'] ?? []);
    }
}

http_response_code($result['code']);
unset($result['code']);
echo json_encode($result);
