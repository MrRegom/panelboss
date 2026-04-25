<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Config\Database;

try {
    $db = Database::getConnection();
    echo "Iniciando Seeder...\n";

    // 1. Crear una empresa de prueba vinculada a un cliente
    // Primero creamos el usuario cliente
    $clientEmail = 'cliente@empresa.cl';
    $checkUser = $db->prepare("SELECT id FROM users WHERE email = ?");
    $checkUser->execute([$clientEmail]);
    $userId = $checkUser->fetchColumn();

    if (!$userId) {
        $db->prepare("INSERT INTO users (email, password, full_name, role) VALUES (?, ?, ?, ?)")
           ->execute([$clientEmail, password_hash('cliente123', PASSWORD_BCRYPT), 'Juan Pérez', 'client']);
        $userId = $db->lastInsertId();
    }

    // Crear la empresa
    $checkCompany = $db->prepare("SELECT id FROM companies WHERE rut = ?");
    $checkCompany->execute(['76.123.456-K']);
    $companyId = $checkCompany->fetchColumn();

    if (!$companyId) {
        $db->prepare("INSERT INTO companies (user_id, name, rut, address, phone) VALUES (?, ?, ?, ?, ?)")
           ->execute([$userId, 'Minimarket La Esquina', '76.123.456-K', 'Av. Siempre Viva 742', '+56 9 1234 5678']);
        $companyId = $db->lastInsertId();
    }

    // 2. Crear un par de licencias
    $licenses = [
        ['key' => 'LPOS-2026-TEST-0001', 'plan' => 'pro', 'status' => 'active', 'expires' => '2026-12-31'],
        ['key' => 'LPOS-2026-TEST-0002', 'plan' => 'basic', 'status' => 'pending', 'expires' => '2026-06-30'],
    ];

    foreach ($licenses as $l) {
        $checkLicense = $db->prepare("SELECT id FROM licenses WHERE license_key = ?");
        $checkLicense->execute([$l['key']]);
        if (!$checkLicense->fetchColumn()) {
            $db->prepare("INSERT INTO licenses (company_id, license_key, plan, status, expires_at) VALUES (?, ?, ?, ?, ?)")
               ->execute([$companyId, $l['key'], $l['plan'], $l['status'], $l['expires']]);
        }
    }

    echo "Seeder ejecutado con éxito. Datos de prueba cargados.\n";

} catch (\Exception $e) {
    echo "Error en el Seeder: " . $e->getMessage() . "\n";
}
