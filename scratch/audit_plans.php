<?php
require_once dirname(__DIR__) . '/src/Config/Database.php';
use App\Config\Database;

try {
    $db = Database::getConnection();
    $stmt = $db->query("SELECT id, name, slug, price FROM subscription_plans");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "ESTADO ACTUAL DE LA TABLA 'subscription_plans':\n";
    echo "--------------------------------------------------\n";
    foreach ($rows as $r) {
        echo "ID: {$r['id']} | NAME: {$r['name']} | SLUG: {$r['slug']} | PRICE: {$r['price']}\n";
    }
    echo "--------------------------------------------------\n";

} catch (\Exception $e) {
    echo "ERROR DE AUDITORÍA: " . $e->getMessage();
}
