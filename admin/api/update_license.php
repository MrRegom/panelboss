<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Services\AuthService;
use App\Config\Database;

AuthService::check();

$db = Database::getConnection();

$id = $_POST['id'] ?? null;
$expiry = $_POST['expires_at'] ?? null;

if (!$id || !$expiry) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios.']);
    exit;
}

try {
    $stmt = $db->prepare("UPDATE licenses SET expires_at = :expiry WHERE id = :id");
    $stmt->execute(['expiry' => $expiry, 'id' => $id]);
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} catch (\Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
