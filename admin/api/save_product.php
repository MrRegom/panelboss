<?php
/**
 * admin/api/save_product.php — Guardar/Actualizar producto en el catálogo maestro
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

AuthService::check();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit(json_encode(['success' => false, 'message' => 'Método no permitido']));
}

try {
    $repo = new MasterProductRepository();
    
    $data = [
        'name'        => $_POST['name'] ?? '',
        'barcode'     => $_POST['barcode'] ?? '',
        'brand'       => $_POST['brand'] ?? '',
        'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
        'description' => $_POST['description'] ?? '',
        'image_path'  => $_POST['image_path'] ?? null, // Podríamos mejorar esto con upload de archivos luego
        'is_active'   => isset($_POST['is_active']) ? (bool)$_POST['is_active'] : true
    ];

    if (!empty($_POST['id'])) {
        $data['id'] = (int)$_POST['id'];
    }

    if (empty($data['name']) || empty($data['barcode'])) {
        exit(json_encode(['success' => false, 'message' => 'Nombre y Código de Barras son obligatorios']));
    }

    $success = $repo->save($data);

    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Producto guardado correctamente' : 'Error al guardar el producto'
    ]);

} catch (\Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
