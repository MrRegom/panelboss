<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Services\AuthService;
use App\Config\Database;

AuthService::check();

$db = Database::getConnection();

$id = $_POST['id'] ?? null;

if (!$id) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Faltan ID.']);
    exit;
}

try {
    $stmt = $db->prepare("DELETE FROM licenses WHERE id = :id");
    $stmt->execute(['id' => $id]);
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} catch (\Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
