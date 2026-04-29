<?php
/**
 * mercadopago/checkout.php — BLOQUEADO POR MANTENIMIENTO
 */
header("Location: /");
exit;

// El código anterior queda comentado por seguridad
/*
ini_set('display_errors', 1);
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Services/MercadoPagoService.php';
use App\Services\MercadoPagoService;
$price = 100;
$name = "Plan CajaYa (Validación Real 100 CLP)";
$orderId = "FINAL_TEST_" . time();
$mp = new MercadoPagoService();
$url = $mp->createPreference($name, $price, $orderId);
if ($url) {
    header("Location: " . $url);
    exit;
}
*/
