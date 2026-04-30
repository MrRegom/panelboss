<?php
/**
 * admin/api/delete_product.php — Eliminar producto del catálogo maestro
 */

// Descubrimiento robusto de la raíz del proyecto
$baseDir = __DIR__;
while ($baseDir !== dirname($baseDir) && !file_exists($baseDir . '/vendor/autoload.php')) {
    $baseDir = dirname($baseDir);
}
define('PROJECT_ROOT', $baseDir);

require_once PROJECT_ROOT . '/vendor/autoload.php';

use App\Services\AuthService;
use App\Config\Database;

AuthService::check();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit(json_encode(['success' => false, 'message' => 'Método no permitido']));
}

$id = $_POST['id'] ?? null;

if (!$id) {
    exit(json_encode(['success' => false, 'message' => 'ID de producto faltante']));
}

try {
    $db = Database::getConnection();
    $stmt = $db->prepare("DELETE FROM master_products WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true, 'message' => 'Producto eliminado correctamente']);

} catch (\Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
