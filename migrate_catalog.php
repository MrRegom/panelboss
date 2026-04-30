<?php
/**
 * migrate_catalog.php — Script de Migración de Base de Datos para Producción
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Config/Database.php';

use App\Config\Database;

try {
    $db = Database::getConnection();
    
    echo "🏗️ Iniciando migración de tablas del Catálogo Maestro...\n";

    $sql = "
    CREATE TABLE IF NOT EXISTS product_categories (
        id SERIAL PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        slug VARCHAR(100) UNIQUE NOT NULL,
        parent_id INTEGER REFERENCES product_categories(id),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS master_products (
        id SERIAL PRIMARY KEY,
        barcode VARCHAR(20) UNIQUE NOT NULL,
        name VARCHAR(255) NOT NULL,
        brand VARCHAR(100),
        description TEXT,
        category_id INTEGER REFERENCES product_categories(id),
        image_path VARCHAR(255),
        is_active BOOLEAN DEFAULT TRUE,
        attributes JSONB,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE INDEX IF NOT EXISTS idx_products_barcode ON master_products(barcode);
    CREATE INDEX IF NOT EXISTS idx_products_name ON master_products(name);
    ";

    $db->exec($sql);
    
    echo "✅ ¡Tablas creadas/verificadas con éxito en el servidor!\n";
    echo "🚀 Ya puedes ejecutar import_catalog.php para llenar los datos.\n";

} catch (Exception $e) {
    die("❌ Error en la migración: " . $e->getMessage());
}
