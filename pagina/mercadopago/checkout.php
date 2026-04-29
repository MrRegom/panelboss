<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Services/MercadoPagoService.php';

use App\Services\MercadoPagoService;

// PRECIO BLOQUEADO A 10 PESOS
$price = 10;
$name = "Plan CajaYa (Prueba Real 10 CLP)";
$orderId = "FINAL_TEST_" . time();

// El servicio se encarga de buscar el TOKEN en el .env automáticamente
$mp = new MercadoPagoService();
$url = $mp->createPreference($name, $price, $orderId);

if ($url) {
    header("Location: " . $url);
    exit;
} else {
    echo "Error: No se pudo generar el link de pago. Verifica que el archivo .env tenga el MP_ACCESS_TOKEN correcto.";
}
