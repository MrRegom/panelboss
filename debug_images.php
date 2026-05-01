<?php
require_once __DIR__ . '/admin/includes/bootstrap.php';
use App\Config\Database;

try {
    $db = Database::getConnection();
    $rows = $db->query("SELECT barcode, name, image_path FROM master_products LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
    echo "--- DATA DEBUG ---\n";
    foreach ($rows as $row) {
        echo "Barcode: [{$row['barcode']}] | Name: [{$row['name']}] | Path: [{$row['image_path']}]\n";
    }
    
    echo "\n--- FILE CHECK ---\n";
    $testBarcode = $rows[0]['barcode'] ?? '';
    $testFile = "imagenes_productos/{$testBarcode}.jpg";
    echo "Checking for file: $testFile\n";
    if (file_exists($testFile)) {
        echo "RESULT: File exists!\n";
    } else {
        echo "RESULT: File NOT found.\n";
    }

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
