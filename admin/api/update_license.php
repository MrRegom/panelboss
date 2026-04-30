<?php
// Descubrimiento robusto de la raíz del proyecto
$baseDir = __DIR__;
while ($baseDir !== dirname($baseDir) && !file_exists($baseDir . '/vendor/autoload.php')) {
    $baseDir = dirname($baseDir);
}
define('PROJECT_ROOT', $baseDir);

require_once PROJECT_ROOT . '/vendor/autoload.php';

use App\Services\AuthService;
use App\Config\Database;

AuthService::check();

$db = Database::getConnection();

$action = $_POST['action'] ?? 'update_expiry';
$id = $_POST['id'] ?? null;

if (!$id) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Faltan ID.']);
    exit;
}

try {
    if ($action === 'toggle_status') {
        $status = $_POST['status'] ?? 'active';
        $stmt = $db->prepare("UPDATE licenses SET status = :status WHERE id = :id");
        $stmt->execute(['status' => $status, 'id' => $id]);
    } elseif ($action === 'update_full') {
        $company_id = $_POST['company_id'] ?? null;
        $plan = $_POST['plan'] ?? 'BASIC';
        $expiry = !empty($_POST['expires_at']) ? $_POST['expires_at'] : null;
        
        $stmt = $db->prepare("UPDATE licenses SET company_id = :company_id, plan = :plan, expires_at = :expiry WHERE id = :id");
        $stmt->execute(['company_id' => $company_id, 'plan' => $plan, 'expiry' => $expiry, 'id' => $id]);
    } else {
        $expiry = $_POST['expires_at'] ?? null;
        $stmt = $db->prepare("UPDATE licenses SET expires_at = :expiry WHERE id = :id");
        $stmt->execute(['expiry' => $expiry, 'id' => $id]);
    }
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} catch (\Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
