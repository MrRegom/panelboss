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

$id = $_POST['id'] ?? null;
$plan = $_POST['plan'] ?? null;
$status = $_POST['status'] ?? null;
$expires_at = !empty($_POST['expires_at']) ? $_POST['expires_at'] : null;

if (!$id) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Faltan ID.']);
    exit;
}

try {
    $sql = "UPDATE licenses SET id = id"; // Dummy start
    $params = ['id' => $id];

    if ($plan) {
        $sql .= ", plan = :plan";
        $params['plan'] = $plan;
    }
    if ($status) {
        $sql .= ", status = :status";
        $params['status'] = $status;
    }
    $sql .= ", expires_at = :expires_at";
    $params['expires_at'] = $expires_at;

    $sql .= " WHERE id = :id";

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} catch (\Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
