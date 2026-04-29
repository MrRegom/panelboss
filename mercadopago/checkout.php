<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Services/MercadoPagoService.php';

use App\Services\MercadoPagoService;

// Cargar .env manualmente si Dotenv falla
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} elseif (file_exists(__DIR__ . '/../public/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../public/');
    $dotenv->load();
}

// FORZAMOS PRECIO DE PRUEBA
$planName = "CajaYa - Plan Lifetime (Prueba)";
$price = 10; 
$orderId = "TEST_FORCE_" . time();

$mp = new MercadoPagoService();
$paymentUrl = $mp->createPreference($planName, $price, $orderId);

if ($paymentUrl) {
    header("Location: " . $paymentUrl);
    exit;
} else {
    echo "Error al generar el link de pago. Por favor contacta a soporte.";
}
