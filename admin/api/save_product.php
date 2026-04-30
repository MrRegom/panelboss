<?php
/**
 * admin/api/save_product.php — Manejo de Productos con Carga de Imágenes
 */

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

try {
    $db = Database::getConnection();
    
    $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
    $barcode = $_POST['barcode'] ?? '';
    $name = $_POST['name'] ?? '';
    $brand = $_POST['brand'] ?? '';
    $categoryId = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    
    $imagePath = null;

    // Manejo de Imagen
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = PROJECT_ROOT . '/public/storage/catalog/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = $barcode . '.' . $ext;
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = 'catalog/' . $fileName;
        }
    }

    if ($id) {
        // UPDATE
        $sql = "UPDATE master_products SET name = :name, brand = :brand, category_id = :cat_id";
        if ($imagePath) $sql .= ", image_path = :img";
        $sql .= " WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':brand', $brand);
        $stmt->bindValue(':cat_id', $categoryId, \PDO::PARAM_INT);
        if ($imagePath) $stmt->bindValue(':img', $imagePath);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        $message = "Producto actualizado correctamente";
    } else {
        // INSERT
        $sql = "INSERT INTO master_products (barcode, name, brand, category_id, image_path) 
                VALUES (:barcode, :name, :brand, :cat_id, :img)";
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':barcode', $barcode);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':brand', $brand);
        $stmt->bindValue(':cat_id', $categoryId, \PDO::PARAM_INT);
        $stmt->bindValue(':img', $imagePath);
        $stmt->execute();

        $message = "Producto creado correctamente";
    }

    echo json_encode(['success' => true, 'message' => $message]);

} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
