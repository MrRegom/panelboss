<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Config\Database;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit(json_encode(['success' => false, 'message' => 'Método no permitido']));
}

$plan = $_POST['plan'] ?? 'BASIC';
$expires_at = !empty($_POST['expires_at']) ? $_POST['expires_at'] : null;
$company_id = !empty($_POST['company_id']) ? $_POST['company_id'] : null;

try {
    $db = Database::getConnection();
    $repo = new \App\Repositories\LicenseRepository($db);
    
    // Generador de Key Profesional (LPOS-2026-XXXX-XXXX-XXXX)
    $key = 'LPOS-2026-' . strtoupper(bin2hex(random_bytes(2))) . '-' . strtoupper(bin2hex(random_bytes(2))) . '-' . strtoupper(bin2hex(random_bytes(2)));

    $repo->create($key, $plan, $expires_at, $company_id);

    echo json_encode([
        'success' => true, 
        'message' => 'Licencia creada',
        'key' => $key
    ]);

} catch (\Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
