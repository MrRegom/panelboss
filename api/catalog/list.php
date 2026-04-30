<?php
/**
 * public/api/catalog/list.php — API Pública para consumo desde la App
 */

// Descubrimiento de raíz
$baseDir = __DIR__;
while ($baseDir !== dirname($baseDir) && !file_exists($baseDir . '/vendor/autoload.php')) {
    $baseDir = dirname($baseDir);
}
define('PROJECT_ROOT', $baseDir);

require_once PROJECT_ROOT . '/vendor/autoload.php';

use App\Config\Database;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir consumo desde la App

try {
    $db = Database::getConnection();
    
    // 1. Validar Licencia
    $licenseKey = $_REQUEST['license_key'] ?? null;
    
    if (!$licenseKey) {
        throw new Exception("Falta el parámetro license_key");
    }

    $stmtLic = $db->prepare("SELECT id FROM licenses WHERE license_key = :key AND status = 'active' LIMIT 1");
    $stmtLic->execute(['key' => $licenseKey]);
    $license = $stmtLic->fetch();

    if (!$license) {
        http_response_code(403);
        throw new Exception("Licencia inválida o inactiva");
    }

    // 2. Obtener Catálogo
    $sql = "SELECT p.barcode, p.name, p.brand, p.image_path, c.name as category_name 
            FROM master_products p 
            LEFT JOIN product_categories c ON p.category_id = c.id 
            ORDER BY p.name ASC";
            
    $products = $db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

    // 3. Formatear URLs de imágenes
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $baseUrl = "$protocol://$host/api/catalog/image.php";

    foreach ($products as &$p) {
        if ($p['image_path']) {
            $p['image_url'] = "$baseUrl?barcode={$p['barcode']}&license_key=$licenseKey";
        } else {
            $p['image_url'] = null;
        }
        unset($p['image_path']); // Ocultar ruta interna
    }

    echo json_encode([
        'success' => true,
        'count' => count($products),
        'data' => $products
    ]);

} catch (\Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
