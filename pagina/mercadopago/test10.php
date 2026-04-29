<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Services/MercadoPagoService.php';

use App\Services\MercadoPagoService;

if (file_exists(__DIR__ . '/../../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
}

$price = 10;
$name = "BYPASS CACHE 10 PESOS";

$mp = new MercadoPagoService();
$url = $mp->createPreference($name, $price, "BYPASS_" . time());

if ($url) {
    header("Location: " . $url);
} else {
    echo "Error: Revisa el Token en el .env de la raíz.";
}
