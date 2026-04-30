<?php
/**
 * admin/tools/optimize_images.php
 * Script de optimización masiva de imágenes a formato WebP.
 */

// Descubrimiento de la raíz del proyecto
$baseDir = __DIR__;
while ($baseDir !== dirname($baseDir) && !file_exists($baseDir . '/vendor/autoload.php')) {
    $baseDir = dirname($baseDir);
}
define('PROJECT_ROOT', $baseDir);

require_once PROJECT_ROOT . '/vendor/autoload.php';
require_once PROJECT_ROOT . '/src/Config/Database.php';

use App\Config\Database;

if (php_sapi_name() !== 'cli') {
    die("Este script solo puede ejecutarse desde la terminal (CLI).\n");
}

echo "🚀 Iniciando Optimizador Masivo de Imágenes (CajaYa Enterprise)\n";
echo "-------------------------------------------------------------\n";

try {
    $db = Database::getConnection();
    
    // 1. Obtener productos que NO tengan imagen WebP
    $stmt = $db->prepare("SELECT id, barcode, image_path FROM master_products WHERE image_path IS NOT NULL AND image_path NOT LIKE '%.webp' AND image_path != ''");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "📊 Encontrados " . count($products) . " productos para optimizar.\n";

    $processed = 0;
    $errors = 0;

    foreach ($products as $product) {
        $oldPath = $product['image_path'];
        $barcode = $product['barcode'];
        
        // Determinar ruta física absoluta
        $absoluteOldPath = PROJECT_ROOT . DIRECTORY_SEPARATOR . $oldPath;
        if (!file_exists($absoluteOldPath)) {
            $absoluteOldPath = PROJECT_ROOT . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $oldPath;
        }

        if (!file_exists($absoluteOldPath)) {
            echo "❌ [{$barcode}] Archivo no encontrado: {$oldPath}\n";
            $errors++;
            continue;
        }

        // 2. Cargar imagen original
        $extension = strtolower(pathinfo($absoluteOldPath, PATHINFO_EXTENSION));
        $image = null;

        if ($extension === 'jpg' || $extension === 'jpeg') {
            $image = @imagecreatefromjpeg($absoluteOldPath);
        } elseif ($extension === 'png') {
            $image = @imagecreatefrompng($absoluteOldPath);
        }

        if (!$image) {
            echo "❌ [{$barcode}] Error al cargar imagen ({$extension}): {$oldPath}\n";
            $errors++;
            continue;
        }

        // 3. Crear nueva ruta WebP
        $newRelativePath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $oldPath);
        $absoluteNewPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $absoluteOldPath);

        // 4. Guardar como WebP (Calidad 80 para balance perfecto peso/calidad)
        if (imagewebp($image, $absoluteNewPath, 80)) {
            // 5. Actualizar Base de Datos
            $upd = $db->prepare("UPDATE master_products SET image_path = :new_path WHERE id = :id");
            $upd->execute(['new_path' => $newRelativePath, 'id' => $product['id']]);

            // 6. Eliminar archivo viejo
            unlink($absoluteOldPath);
            
            imagedestroy($image);
            $processed++;
            
            if ($processed % 10 === 0) {
                echo "✅ Procesados: {$processed} / " . count($products) . "\r";
            }
        } else {
            echo "❌ [{$barcode}] Falló la conversión a WebP.\n";
            $errors++;
        }
    }

    echo "\n-------------------------------------------------------------\n";
    echo "✨ Proceso Completado con Éxito.\n";
    echo "📁 Imágenes optimizadas: {$processed}\n";
    echo "⚠️ Errores encontrados: {$errors}\n";
    echo "-------------------------------------------------------------\n";

} catch (Exception $e) {
    echo "🛑 ERROR CRÍTICO: " . $e->getMessage() . "\n";
}
