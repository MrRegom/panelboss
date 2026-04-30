<?php
/**
 * admin/api/get_master_catalog.php — Endpoint para DataTables con Filtro de Categoría
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
    
    // Filtro extra: Categoría
    $categoryId = !empty($_GET['category_id']) ? (int)$_GET['category_id'] : null;

    // Construcción de la consulta con filtros
    $where = "WHERE 1=1";
    $params = [];

    if ($search) {
        $where .= " AND (p.name ILIKE :search OR p.barcode LIKE :search OR p.brand ILIKE :search)";
        $params['search'] = "%$search%";
    }

    if ($categoryId) {
        $where .= " AND p.category_id = :cat_id";
        $params['cat_id'] = $categoryId;
    }

    // SQL Principal
    $sql = "SELECT p.*, c.name as category_name 
            FROM master_products p 
            LEFT JOIN product_categories c ON p.category_id = c.id 
            $where 
            ORDER BY p.name ASC 
            LIMIT :limit OFFSET :offset";

    $stmt = $db->prepare($sql);
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    // Conteos
    $totalCount = $db->query("SELECT COUNT(*) FROM master_products")->fetchColumn();
    
    $sqlCount = "SELECT COUNT(*) FROM master_products p $where";
    $stmtCount = $db->prepare($sqlCount);
    foreach ($params as $key => $val) {
        $stmtCount->bindValue($key, $val);
    }
    $stmtCount->execute();
    $filteredCount = $stmtCount->fetchColumn();

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
