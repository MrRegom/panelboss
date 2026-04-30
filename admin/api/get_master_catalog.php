<?php
/**
 * admin/api/get_master_catalog.php — Endpoint para DataTables (Server-side)
 */

// Descubrimiento robusto de la raíz del proyecto
$baseDir = __DIR__;
while ($baseDir !== dirname($baseDir) && !file_exists($baseDir . '/vendor/autoload.php')) {
    $baseDir = dirname($baseDir);
}
define('PROJECT_ROOT', $baseDir);

require_once PROJECT_ROOT . '/vendor/autoload.php';

use App\Services\AuthService;
use App\Repositories\MasterProductRepository;
use App\Config\Database;

AuthService::check();

header('Content-Type: application/json');

try {
    $repo = new MasterProductRepository();
    $db = Database::getConnection();
    
    // Parámetros de DataTables
    $limit  = isset($_GET['length']) ? (int)$_GET['length'] : 50;
    $offset = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $search = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';
    $draw   = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;

    // Obtener productos paginados
    $products = $repo->list($limit, $offset, $search);
    
    // Conteos para el footer de DataTables
    $totalCount = $db->query("SELECT COUNT(*) FROM master_products")->fetchColumn();
    $filteredCount = $totalCount;
    
    if ($search) {
        $stmt = $db->prepare("
            SELECT COUNT(*) 
            FROM master_products p
            LEFT JOIN product_categories c ON p.category_id = c.id
            WHERE p.name ILIKE :search 
               OR p.barcode LIKE :search 
               OR p.brand ILIKE :search
        ");
        $searchParam = "%$search%";
        $stmt->execute(['search' => $searchParam]);
        $filteredCount = $stmt->fetchColumn();
    }

    echo json_encode([
        'draw' => $draw,
        'recordsTotal' => (int)$totalCount,
        'recordsFiltered' => (int)$filteredCount,
        'data' => $products
    ]);

} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
