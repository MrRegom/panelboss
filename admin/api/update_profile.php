<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Config\Database;
use App\Services\AuthService;

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no válida']);
    exit;
}

$userId = $_SESSION['user_id'];
$fullName = $_POST['full_name'] ?? '';
$email = $_POST['email'] ?? '';
$currentPass = $_POST['current_password'] ?? '';
$newPass = $_POST['new_password'] ?? '';

try {
    $db = Database::getConnection();

    // 1. Verificar contraseña actual
    $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($currentPass, $user['password'])) {
        echo json_encode(['success' => false, 'message' => 'La contraseña actual es incorrecta.']);
        exit;
    }

    // 2. Preparar actualización
    if (!empty($newPass)) {
        // Actualizar con nueva contraseña
        $hashed = password_hash($newPass, PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE users SET full_name = ?, email = ?, password = ? WHERE id = ?");
        $stmt->execute([$fullName, $email, $hashed, $userId]);
    } else {
        // Actualizar solo datos básicos
        $stmt = $db->prepare("UPDATE users SET full_name = ?, email = ? WHERE id = ?");
        $stmt->execute([$fullName, $email, $userId]);
    }

    // 3. Actualizar sesión
    $_SESSION['user_name'] = $fullName;

    echo json_encode(['success' => true, 'message' => 'Tu perfil ha sido actualizado con éxito.']);

} catch (\Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
}
