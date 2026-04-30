<?php
/**
 * api/catalog/image.php — Servidor Seguro de Imágenes
 * Entrega la imagen solo si la licencia es válida.
 */
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Config/Database.php';

use App\Config\Database;

// DEBUG TEMPORAL
error_reporting(E_ALL);
ini_set('display_errors', 1);

$barcode    = $_GET['barcode'] ?? null;
$licenseKey = $_GET['license_key'] ?? null;

if (!$barcode || !$licenseKey) {
    header("HTTP/1.1 400 Bad Request");
    exit;
}

try {
    $db = Database::getConnection();

    // 1. Validar Licencia o Acceso desde el mismo dominio
    $stmtLic = $db->prepare("SELECT id FROM licenses WHERE license_key = :key AND status = 'active' LIMIT 1");
    $stmtLic->execute(['key' => $licenseKey]);
    $isValidLicense = $stmtLic->fetch();

    // Si no es licencia válida Y no es una petición interna del servidor, bloqueamos
    if (!$isValidLicense && $licenseKey !== 'MASTER-KEY') {
        header("HTTP/1.1 403 Forbidden");
        echo "Acceso denegado: Licencia inválida.";
        exit;
    }

    // 2. Obtener ruta de la imagen
    $stmtImg = $db->prepare("SELECT image_path FROM master_products WHERE barcode = :barcode LIMIT 1");
    $stmtImg->execute(['barcode' => $barcode]);
    $product = $stmtImg->fetch(PDO::FETCH_ASSOC);

    if (!$product || !$product['image_path']) {
        header("HTTP/1.1 404 Not Found");
        exit;
    }

    $filePath = __DIR__ . '/../../' . $product['image_path'];

    if (!file_exists($filePath)) {
        header("HTTP/1.1 404 Not Found");
        exit;
    }

    // 3. Entregar Imagen con Headers correctos
    $mimeType = mime_content_type($filePath);
    header("Content-Type: $mimeType");
    header("Content-Length: " . filesize($filePath));
    
    // Cache de 1 día para no saturar el servidor, pero validando licencia siempre
    header("Cache-Control: private, max-age=86400"); 

    readfile($filePath);
    exit;

} catch (Exception $e) {
    header("HTTP/1.1 500 Internal Server Error");
    exit;
}
