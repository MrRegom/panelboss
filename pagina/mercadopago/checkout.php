<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Services/MercadoPagoService.php';

use App\Services\MercadoPagoService;

// Forzar carga de .env desde la raíz de public
if (file_exists(__DIR__ . '/../../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
}

// PRECIO BLOQUEADO A 10 PESOS PARA PRUEBA DE PRODUCCIÓN
$price = 10;
$name = "Plan CajaYa (Prueba Real 10 CLP)";
$orderId = "FINAL_TEST_" . time();

$mp = new MercadoPagoService();
$url = $mp->createPreference($name, $price, $orderId);

if ($url) {
    header("Location: " . $url);
} else {
    echo "Error al generar el link de pago.";
}
