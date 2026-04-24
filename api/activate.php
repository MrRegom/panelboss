<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\LicenseService;

header('Content-Type: application/json');

// Validar API Key
$apiKey = $_SERVER['HTTP_X_API_KEY'] ?? '';
if ($apiKey !== 'abc123shared') {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid X-API-Key']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request body']);
    exit;
}

$service = new LicenseService();
$result = $service->activate(
    $data['license_key'] ?? '',
    $data['machine_id'] ?? '',
    $data['version'] ?? '1.0.0',
    [
        'business_name' => $data['business_name'] ?? null,
        'rut' => $data['rut'] ?? null,
        'email' => $data['email'] ?? null,
        'address' => $data['address'] ?? null,
        'phone' => $data['phone'] ?? null,
    ]
);

http_response_code($result['code']);
unset($result['code']);
echo json_encode($result);
