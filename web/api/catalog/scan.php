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
use App\Services\AuthService;

// Leer el cuerpo de la petición (JSON)
$input = json_decode(file_get_contents('php://input'), true);

// --- SEGURIDAD v4.0 (Híbrida) ---
$token = AuthService::getBearerToken();
$licenseKey = null;

if ($token) {
    $tokenData = AuthService::validateToken($token);
    if (!$tokenData) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Token JWT inválido o expirado']);
        exit;
    }
    $licenseKey = $tokenData['license_key'];
} else {
    $licenseKey = $_SERVER['HTTP_X_CLIENT_ID'] ?? $input['license_key'] ?? $_REQUEST['license_key'] ?? null;
}

$barcode = $input['barcode'] ?? $_REQUEST['barcode'] ?? null;

if (!$barcode || !$licenseKey) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan parámetros (barcode y Authorization Header o X-Client-Id)']);
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
        echo json_encode(['success' => false, 'message' => 'Licencia inválida o inactiva']);
        exit;
    }
    // --- FIN SEGURIDAD ---

    // 2. Buscar Producto
    $repo = new MasterProductRepository();
    $product = $repo->getByBarcode($barcode);

    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado en el catálogo maestro']);
        exit;
    }

    // Generamos una URL segura para la imagen de forma dinámica
    $imageUrl = null;
    if ($product['image_path']) {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $scriptPath = str_replace('scan.php', 'image.php', $_SERVER['SCRIPT_NAME']);
        $imageUrl = "$protocol://" . $_SERVER['HTTP_HOST'] . "$scriptPath?barcode=" . $barcode . "&license_key=" . $licenseKey;
    }

    $response = [
        'success' => true,
        'master_catalog_enabled' => true,
        'MasterCatalogEnabled' => true,
        'is_master_catalog_active' => true,
        'IsMasterCatalogActive' => true,
        'IsMasterCatalogEnabled' => true,
        'data' => [
            'barcode' => $product['barcode'],
            'name'    => $product['name'],
            'brand'   => $product['brand'],
            'category'=> $product['category_name'],
            'image'   => $imageUrl,
            'master_catalog_enabled' => true,
            'MasterCatalogEnabled' => true,
            'IsMasterCatalogEnabled' => true,
            'IsMasterCatalogActive' => true
        ],
        'result' => [
            'success' => true,
            'MasterCatalogEnabled' => true,
            'IsMasterCatalogEnabled' => true,
            'IsMasterCatalogActive' => true
        ]
    ];
    
    // Objeto Result (Redundancia C#)
    $response['Result'] = $response['result'];
    
    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor']);
}
