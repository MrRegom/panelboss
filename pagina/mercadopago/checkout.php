<?php
/**
 * mercadopago/checkout.php — Checkout Inteligente
 * Lee el precio desde la base de datos según el plan seleccionado.
 */

ini_set('display_errors', 1);
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Config/Database.php';
require_once __DIR__ . '/../../src/Repositories/PlanRepository.php';
require_once __DIR__ . '/../../src/Services/MercadoPagoService.php';

use App\Repositories\PlanRepository;
use App\Services\MercadoPagoService;

// 1. Identificar el plan (por defecto 'lifetime' si no viene nada)
$planSlug = $_GET['plan'] ?? 'lifetime';

// 2. Buscar el precio en la Base de Datos
$planRepo = new PlanRepository();
$planData = $planRepo->getBySlug($planSlug);

if (!$planData) {
    die("Error: El plan seleccionado no existe en la base de datos.");
}

$price = (float)$planData['price'];
$name  = "CajaYa - " . $planData['name'];
$orderId = strtoupper($planSlug) . "_" . time();

// 3. Crear la preferencia en Mercado Pago
$mp = new MercadoPagoService();
$url = $mp->createPreference($name, $price, $orderId);

if ($url) {
    header("Location: " . $url);
    exit;
} else {
    echo "Error al conectar con Mercado Pago. Por favor intente más tarde.";
}
