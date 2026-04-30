<?php
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

$db = Database::getConnection();

$id = $_POST['id'] ?? null;

if (!$id) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Faltan ID.']);
    exit;
}

try {
    // CAPA DE SEGURIDAD SENIOR: Verificar estado antes de borrar
    $stmt = $db->prepare("SELECT status FROM licenses WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $license = $stmt->fetch();

    if ($license && $license['status'] === 'active') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'No puedes eliminar una licencia ACTIVA. Primero debes suspenderla.']);
        exit;
    }

    $stmt = $db->prepare("DELETE FROM licenses WHERE id = :id");
    $stmt->execute(['id' => $id]);
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} catch (\Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
