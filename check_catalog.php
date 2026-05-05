<?php
require_once __DIR__ . '/src/Config/Database.php';
use App\Config\Database;

try {
    $db = Database::getConnection();
    $count = $db->query("SELECT count(*) FROM master_products")->fetchColumn();
    echo "Total productos maestros: " . $count . "\n";
    
    if ($count > 0) {
        $sample = $db->query("SELECT barcode, name FROM master_products LIMIT 3")->fetchAll();
        print_r($sample);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
