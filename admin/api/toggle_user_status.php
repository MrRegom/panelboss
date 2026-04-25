<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Config\Database;

header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$current_status = $_POST['status'] ?? 'active';

if (!$id) exit(json_encode(['success' => false]));

try {
    $db = Database::getConnection();
    $new_status = ($current_status === 'active') ? 'inactive' : 'active';
    
    $stmt = $db->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $id]);

    echo json_encode(['success' => true, 'new_status' => $new_status]);
} catch (\Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
