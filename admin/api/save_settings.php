<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Services\AuthService;
use App\Repositories\SettingRepository;

header('Content-Type: application/json');
AuthService::check();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $repo = new SettingRepository();
    $downloadUrl = $_POST['download_url'] ?? '';
    $version = $_POST['current_version'] ?? '';

    if (!empty($downloadUrl)) {
        $repo->update('download_url', $downloadUrl);
    }
    
    if (!empty($version)) {
        $repo->update('current_version', $version);
    }

    echo json_encode(['success' => true, 'message' => 'Configuración actualizada correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
