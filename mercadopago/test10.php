<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Services/MercadoPagoService.php';

use App\Services\MercadoPagoService;

// Forzar carga de .env
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

// PRECIO BLOQUEADO A 10 PESOS
$price = 10;
$name = "PRUEBA DE FUEGO 10 PESOS";

$mp = new MercadoPagoService();
$url = $mp->createPreference($name, $price, "FORCE_10_" . time());

if ($url) {
    header("Location: " . $url);
} else {
    echo "Error: No se pudo generar el link. Revisa el Token.";
}
