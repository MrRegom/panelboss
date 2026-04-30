<?php
/**
 * import_catalog.php — Script de Importación Masiva para CajaYa Elite
 * Procesa el CSV y las imágenes convirtiéndolas a WebP.
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Config/Database.php';
require_once __DIR__ . '/src/Repositories/MasterProductRepository.php';
require_once __DIR__ . '/src/Services/CatalogService.php';

use App\Config\Database;
use App\Services\CatalogService;

// Aumentar tiempo de ejecución y memoria para proceso masivo
set_time_limit(0);
ini_set('memory_limit', '512M');

$csvPath = __DIR__ . '/imagenes_productos/Gran-Catalogo-CajaYA.csv';
$imgDir  = __DIR__ . '/imagenes_productos';

if (!file_exists($csvPath)) {
    die("Error: No se encuentra el archivo CSV en $csvPath\n");
}

$catalogService = new CatalogService();
$db = Database::getConnection();

echo "🚀 Iniciando importación del Catálogo Maestro...\n";

$handle = fopen($csvPath, "r");
$header = fgetcsv($handle, 0, ";"); // Leer cabecera

$count = 0;
$errors = 0;

while (($row = fgetcsv($handle, 0, ";")) !== FALSE) {
    try {
        // Mapeo de columnas basado en el análisis
        $categoriaNombre = trim($row[0]);
        $eanRaw          = trim($row[1]);
        $marca           = trim($row[2]);
        $productoNombre  = trim($row[3]);
        $precio          = trim($row[4]);
        $archivoImg      = trim($row[8]);

        // 1. Limpiar EAN: de "=""000001""" a "000001"
        $ean = preg_replace('/[^0-9]/', '', $eanRaw);
        if (empty($ean)) continue;

        // 2. Gestionar Categoría
        $stmtCat = $db->prepare("SELECT id FROM product_categories WHERE name = :name");
        $stmtCat->execute(['name' => $categoriaNombre]);
        $catId = $stmtCat->fetchColumn();

        if (!$catId && !empty($categoriaNombre)) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $categoriaNombre)));
            $insCat = $db->prepare("INSERT INTO product_categories (name, slug) VALUES (:name, :slug) RETURNING id");
            $insCat->execute(['name' => $categoriaNombre, 'slug' => $slug]);
            $catId = $insCat->fetchColumn();
        }

        // 3. Procesar Imagen si existe
        $finalImgPath = null;
        $localImgFile = $imgDir . '/' . $archivoImg;
        if (!empty($archivoImg) && file_exists($localImgFile)) {
            try {
                $finalImgPath = $catalogService->processProductImage($ean, $localImgFile);
            } catch (Exception $e) {
                echo "⚠️ Error procesando imagen para $ean: " . $e->getMessage() . "\n";
            }
        }

        // 4. Guardar en Base de Datos (MasterProductRepository::save se encarga del INSERT/UPDATE)
        // Buscamos si ya existe por barcode para decidir si es update o insert
        $stmtExist = $db->prepare("SELECT id FROM master_products WHERE barcode = :barcode");
        $stmtExist->execute(['barcode' => $ean]);
        $existingId = $stmtExist->fetchColumn();

        $productData = [
            'barcode'     => $ean,
            'name'        => $productoNombre,
            'brand'       => $marca,
            'category_id' => $catId ?: null,
            'image_path'  => $finalImgPath,
            'attributes'  => ['precio_sugerido' => $precio]
        ];

        if ($existingId) {
            $productData['id'] = $existingId;
        }

        $catalogService->createProduct($productData);
        
        $count++;
        if ($count % 100 == 0) echo "✅ Procesados $count productos...\n";

    } catch (Exception $e) {
        $errors++;
        echo "❌ Error en fila $count: " . $e->getMessage() . "\n";
    }
}

fclose($handle);

echo "\n✨ ¡IMPORTACIÓN FINALIZADA! ✨\n";
echo "📦 Productos procesados: $count\n";
echo "❌ Errores: $errors\n";
echo "📂 Imágenes optimizadas en: public/storage/products/webp/\n";
