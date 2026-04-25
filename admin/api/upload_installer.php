<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Services\AuthService;
use App\Repositories\SettingRepository;

header('Content-Type: application/json');
AuthService::check();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['installer'])) {
    $file = $_FILES['installer'];
    $version = $_POST['version'] ?? '1.0.0';
    
    // Validar extensión
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    if (strtolower($ext) !== 'exe') {
        echo json_encode(['success' => false, 'message' => 'Solo se permiten archivos .exe']);
        exit;
    }

    // Ruta de destino
    $uploadDir = __DIR__ . '/../../web/downloads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileName = 'CajaYa-Setup-' . $version . '.exe';
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $repo = new SettingRepository();
        $newUrl = 'https://cajaya.cl/downloads/' . $fileName;
        
        $repo->update('download_url', $newUrl);
        $repo->update('current_version', $version);

        echo json_encode([
            'success' => true, 
            'message' => 'Instalador subido y actualizado correctamente',
            'url' => $newUrl
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al mover el archivo. Revisa los permisos de la carpeta downloads.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No se recibió ningún archivo']);
}
