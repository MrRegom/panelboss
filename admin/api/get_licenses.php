<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Services\AuthService;
use App\Config\Database;

AuthService::check();

$db = Database::getConnection();
$sql = "SELECT l.id, l.license_key, 
               COALESCE(c.name, l.business_name, 'N/A') as company_name, 
               l.plan, l.status, l.expires_at,
               l.rut, l.email, l.address, l.phone, l.business_name
        FROM licenses l 
        LEFT JOIN companies c ON l.company_id = c.id
        ORDER BY l.created_at DESC";

$licenses = $db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode(['data' => $licenses]);
