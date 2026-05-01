<?php
require_once __DIR__ . '/../includes/bootstrap.php';
use App\Config\Database;

try {
    $db = Database::getConnection();
    // Corregido: La tabla correcta es master_products
    $products = $db->query("SELECT * FROM master_products ORDER BY name ASC")->fetchAll();
    
    header('Content-Type: application/json');
    echo json_encode(['data' => $products]);
} catch (\Exception $e) {
    header('Content-Type: application/json', true, 500);
    echo json_encode(['error' => $e->getMessage()]);
}
