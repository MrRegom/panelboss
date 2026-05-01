<?php
require_once __DIR__ . '/../includes/bootstrap.php';
use App\Config\Database;

try {
    $db = Database::getConnection();
    $leads = $db->query("SELECT * FROM leads ORDER BY created_at DESC")->fetchAll();
    
    header('Content-Type: application/json');
    echo json_encode(['data' => $leads]);
} catch (\Exception $e) {
    header('Content-Type: application/json', true, 500);
    echo json_encode(['error' => $e->getMessage()]);
}
