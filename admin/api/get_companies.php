<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Config\Database;

header('Content-Type: application/json');

try {
    $db = Database::getConnection();
    $repo = new \App\Repositories\CompanyRepository($db);
    echo json_encode(['data' => $repo->findAll()]);
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
