<?php
require_once __DIR__ . '/src/Config/Database.php';
use App\Config\Database;

try {
    $db = Database::getConnection();
    
    $plans = [
        ['Plan Mensual', 'mensual', 20000],
        ['Plan Lifetime', 'lifetime', 180000],
        ['Plan Empresa', 'empresa', 35000]
    ];

    foreach ($plans as $p) {
        $stmt = $db->prepare("INSERT INTO subscription_plans (name, slug, price) 
                             VALUES (?, ?, ?) 
                             ON CONFLICT (slug) DO UPDATE SET price = EXCLUDED.price, name = EXCLUDED.name");
        $stmt->execute($p);
    }

    echo "Sincronización Exitosa: Los 3 planes están activos.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
