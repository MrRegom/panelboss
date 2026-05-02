<?php
/**
 * admin/api/delete_company.php — Eliminar empresa
 */

require_once __DIR__ . '/../includes/bootstrap.php';
use App\Config\Database;
use App\Services\AuthService;

AuthService::check();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit(json_encode(['success' => false, 'message' => 'Método no permitido']));
}

$id = $_POST['id'] ?? null;

if (!$id) {
    exit(json_encode(['success' => false, 'message' => 'ID de empresa faltante']));
}

try {
    $db = Database::getConnection();
    
    // Verificar si tiene licencias asociadas
    $stmt = $db->prepare("SELECT COUNT(*) FROM licenses WHERE company_id = ?");
    $stmt->execute([$id]);
    if ($stmt->fetchColumn() > 0) {
        exit(json_encode(['success' => false, 'message' => 'No se puede eliminar la empresa porque tiene licencias asociadas.']));
    }

    $stmt = $db->prepare("DELETE FROM companies WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true, 'message' => 'Empresa eliminada correctamente']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
