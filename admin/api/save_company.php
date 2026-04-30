<?php
require_once __DIR__ . '/../includes/bootstrap.php';
use App\Config\Database;
use App\Services\AuthService;

AuthService::check();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit(json_encode(['success' => false, 'message' => 'Método no permitido']));
}

$name = $_POST['name'] ?? null;
$rut = $_POST['rut'] ?? null;
$email = $_POST['email'] ?? null;

if (!$name) {
    exit(json_encode(['success' => false, 'message' => 'El nombre es obligatorio']));
}

try {
    $db = Database::getConnection();
    $stmt = $db->prepare("INSERT INTO companies (name, rut, email, created_at) VALUES (:name, :rut, :email, datetime('now'))");
    $stmt->execute(['name' => $name, 'rut' => $rut, 'email' => $email]);

    echo json_encode(['success' => true, 'message' => 'Empresa creada con éxito']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
