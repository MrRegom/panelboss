<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Services/MercadoPagoService.php';

use App\Services\MercadoPagoService;

// PRECIO AJUSTADO A 100 PESOS (Mínimo recomendado para evitar bloqueos)
$price = 100;
$name = "Plan CajaYa (Validación Real 100 CLP)";
$orderId = "FINAL_TEST_" . time();

$mp = new MercadoPagoService();
$url = $mp->createPreference($name, $price, $orderId);

if ($url) {
    header("Location: " . $url);
    exit;
} else {
    echo "Error: No se pudo generar el link de pago.";
}
