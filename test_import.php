<?php
/**
 * test_import.php — Mini test de 5 productos
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Config/Database.php';
require_once __DIR__ . '/src/Repositories/MasterProductRepository.php';
require_once __DIR__ . '/src/Services/CatalogService.php';

use App\Config\Database;
use App\Services\CatalogService;

$csvPath = __DIR__ . '/imagenes_productos/Gran-Catalogo-CajaYA.csv';
$imgDir  = __DIR__ . '/imagenes_productos';

$catalogService = new CatalogService();
$db = Database::getConnection();

echo "🧪 TEST DE IMPORTACIÓN (5 Productos)...\n";

$handle = fopen($csvPath, "r");
$header = fgetcsv($handle, 0, ";");

for ($i = 0; $i < 5; $i++) {
    $row = fgetcsv($handle, 0, ";");
    if (!$row) break;

    $categoriaNombre = trim($row[0]);
    $eanRaw          = trim($row[1]);
    $marca           = trim($row[2]);
    $productoNombre  = trim($row[3]);
    $archivoImg      = trim($row[8]);

    $ean = preg_replace('/[^0-9]/', '', $eanRaw);
    
    echo "Processing: $ean - $productoNombre...";

    $finalImgPath = null;
    $localImgFile = $imgDir . '/' . $archivoImg;
    if (!empty($archivoImg) && file_exists($localImgFile)) {
        $finalImgPath = $catalogService->processProductImage($ean, $localImgFile);
    }

    $productData = [
        'barcode'     => $ean,
        'name'        => $productoNombre,
        'brand'       => $marca,
        'image_path'  => $finalImgPath
    ];

    $catalogService->createProduct($productData);
    echo " ✅ OK\n";
}

fclose($handle);
echo "\n✨ Test finalizado con éxito.\n";
