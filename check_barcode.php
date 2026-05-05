<?php
require_once __DIR__ . '/src/Config/Database.php';
use App\Config\Database;

$barcode = '7791130002431';
try {
    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT name, brand FROM master_products WHERE barcode = :b");
    $stmt->execute(['b' => $barcode]);
    $product = $stmt->fetch();
    
    if ($product) {
        echo "ENCONTRADO: " . $product['name'] . " - " . $product['brand'] . "\n";
    } else {
        echo "PRODUCTO NO EXISTE EN EL CATÁLOGO MAESTRO.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
