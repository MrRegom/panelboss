<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Config\Database;

header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$email = $_POST['email'] ?? '';
$full_name = $_POST['full_name'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? 'admin';

try {
    $db = Database::getConnection();

    if ($id) {
        // ACTUALIZACIÓN
        if (!empty($password)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET email = ?, full_name = ?, password = ?, role = ? WHERE id = ?");
            $stmt->execute([$email, $full_name, $hashed, $role, $id]);
        } else {
            $stmt = $db->prepare("UPDATE users SET email = ?, full_name = ?, role = ? WHERE id = ?");
            $stmt->execute([$email, $full_name, $role, $id]);
        }
        $msg = "Usuario actualizado correctamente";
    } else {
        // CREACIÓN
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (email, full_name, password, role, status) VALUES (?, ?, ?, ?, 'active')");
        $stmt->execute([$email, $full_name, $hashed, $role]);
        $msg = "Usuario creado correctamente";
    }

    echo json_encode(['success' => true, 'message' => $msg]);

} catch (\Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
