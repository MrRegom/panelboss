<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Repositories\LicenseRepository;

header('Content-Type: application/json');

$apiKey = $_SERVER['HTTP_X_API_KEY'] ?? '';
if ($apiKey !== 'abc123shared') {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid X-API-Key']);
    exit;
}

$key = $_GET['key'] ?? '';

$repo = new LicenseRepository();
$license = $repo->findByLicenseKey($key);

if (!$license) {
    http_response_code(404);
    echo json_encode(['error' => 'License not found']);
    exit;
}

echo json_encode([
    "license_key" => $license['license_key'],
    "status" => $license['status'],
    "plan" => $license['plan'],
    "expires_at" => $license['expires_at'],
    "activated_at" => $license['activated_at'],
    "last_heartbeat_at" => $license['last_heartbeat_at'],
    "machine_id_hash" => $license['machine_id'] ? substr($license['machine_id'], 0, 8) . "..." : null
]);
