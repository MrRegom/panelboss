<?php
require_once __DIR__ . '/../includes/bootstrap.php';
use App\Config\Database;
use App\Services\AuthService;

AuthService::check();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit(json_encode(['success' => false, 'message' => 'Método no permitido']));
}

$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? null;
$rut = $_POST['rut'] ?? null;
$email = $_POST['email'] ?? null;
$phone = $_POST['phone'] ?? null;

if (!$name) {
    exit(json_encode(['success' => false, 'message' => 'El nombre es obligatorio']));
}

try {
    $db = Database::getConnection();
    
    if ($id) {
        // UPDATE
        $stmt = $db->prepare("UPDATE companies SET name = :name, rut = :rut, email = :email, phone = :phone WHERE id = :id");
        $stmt->execute(['name' => $name, 'rut' => $rut, 'email' => $email, 'phone' => $phone, 'id' => $id]);
        $message = 'Empresa actualizada con éxito';
    } else {
        // INSERT
        $stmt = $db->prepare("INSERT INTO companies (name, rut, email, phone, created_at) VALUES (:name, :rut, :email, :phone, NOW())");
        $stmt->execute(['name' => $name, 'rut' => $rut, 'email' => $email, 'phone' => $phone]);
        $message = 'Empresa creada con éxito';
    }

    echo json_encode(['success' => true, 'message' => $message]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
