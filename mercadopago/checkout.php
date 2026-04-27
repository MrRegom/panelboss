<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Services/MercadoPagoService.php';

use App\Services\MercadoPagoService;

// Datos de la orden
$planName = "CajaYa - Plan Lifetime";
$price = 180000;
$orderId = "CJY-" . time();

$mp = new MercadoPagoService();
$paymentUrl = $mp->createPreference($planName, $price, $orderId);

if ($paymentUrl) {
    // Redirección inmediata al Checkout Pro de Mercado Pago
    header("Location: " . $paymentUrl);
    exit;
} else {
    echo "Error al generar el link de pago. Por favor contacta a soporte.";
}
