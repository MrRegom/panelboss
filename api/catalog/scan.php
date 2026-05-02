<?php
/**
 * api/catalog/scan.php — Endpoint para escaneo de productos desde App externa
 */
header('Content-Type: application/json');

// Descubrimiento robusto de la raíz del proyecto
$baseDir = __DIR__;
while ($baseDir !== dirname($baseDir) && !file_exists($baseDir . '/vendor/autoload.php')) {
    $baseDir = dirname($baseDir);
}
define('PROJECT_ROOT', $baseDir);

require_once PROJECT_ROOT . '/vendor/autoload.php';

use App\Config\Database;
use App\Repositories\MasterProductRepository;

$barcode    = $_REQUEST['barcode'] ?? null;
$licenseKey = $_SERVER['HTTP_X_CLIENT_ID'] ?? $_REQUEST['license_key'] ?? null;

if (!$barcode || !$licenseKey) {
    echo json_encode(['status' => 'error', 'message' => 'Faltan parámetros obligatorios (barcode o X-Client-Id header)']);
    exit;
}

try {
    $db = Database::getConnection();

    // 1. Validar Licencia
    $stmtLic = $db->prepare("SELECT id, status FROM licenses WHERE license_key = :key LIMIT 1");
    $stmtLic->execute(['key' => $licenseKey]);
    $license = $stmtLic->fetch(PDO::FETCH_ASSOC);

    if (!$license || $license['status'] !== 'active') {
        http_response_code(403);
        echo json_encode(['status' => 'error', 'message' => 'Licencia inválida o inactiva']);
        exit;
    }

    // 2. Buscar Producto
    $repo = new MasterProductRepository();
    $product = $repo->findByBarcode($barcode);

    if (!$product) {
        echo json_encode(['status' => 'not_found', 'message' => 'Producto no encontrado en el catálogo maestro']);
        exit;
    }

    // Generamos una URL segura para la imagen de forma dinámica
    $imageUrl = null;
    if ($product['image_path']) {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $scriptPath = str_replace('scan.php', 'image.php', $_SERVER['SCRIPT_NAME']);
        $imageUrl = "$protocol://" . $_SERVER['HTTP_HOST'] . "$scriptPath?barcode=" . $barcode;
    }

    echo json_encode([
        'status' => 'success',
        'data' => [
            'barcode' => $product['barcode'],
            'name'    => $product['name'],
            'brand'   => $product['brand'],
            'category'=> $product['category_name'],
            'image'   => $imageUrl
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Error interno del servidor']);
}
