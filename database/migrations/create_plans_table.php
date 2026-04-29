<?php
/**
 * database/migrations/create_plans_table.php
 * Ejecuta este script una vez para crear la tabla de planes.
 */

require_once __DIR__ . '/../../src/Config/Database.php';
use App\Config\Database;

try {
    $db = Database::getConnection();
    
    // 1. Crear tabla
    $db->exec("CREATE TABLE IF NOT EXISTS subscription_plans (
        id SERIAL PRIMARY KEY,
        slug VARCHAR(50) UNIQUE NOT NULL,
        name VARCHAR(100) NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        currency VARCHAR(10) DEFAULT 'CLP',
        duration_days INTEGER, -- NULL para lifetime
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // 2. Insertar planes por defecto (si no existen)
    $plans = [
        ['slug' => 'mensual',  'name' => 'Plan Mensual',  'price' => 20000.00,  'duration' => 30],
        ['slug' => 'anual',    'name' => 'Plan Anual',    'price' => 180000.00, 'duration' => 365],
        ['slug' => 'lifetime', 'name' => 'Plan Lifetime', 'price' => 180000.00, 'duration' => null],
        ['slug' => 'test',     'name' => 'Plan de Prueba', 'price' => 100.00,    'duration' => 1]
    ];

    $stmt = $db->prepare("INSERT INTO subscription_plans (slug, name, price, duration_days) 
                          VALUES (:slug, :name, :price, :duration)
                          ON CONFLICT (slug) DO UPDATE SET price = EXCLUDED.price");

    foreach ($plans as $plan) {
        $stmt->execute($plan);
    }

    echo "✅ Tabla 'subscription_plans' creada e inicializada con éxito.\n";

} catch (Exception $e) {
    die("❌ Error en la migración: " . $e->getMessage() . "\n");
}
