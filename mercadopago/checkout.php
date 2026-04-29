<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar .env (buscando en la raíz o en public/)
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} elseif (file_exists(__DIR__ . '/../public/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../public/');
    $dotenv->load();
}

use App\Services\MercadoPagoService;

// Definición de planes y precios
$planes = [
    'mensual'  => ['nombre' => 'CajaYa - Plan Mensual',  'precio' => 20000],
    'anual'    => ['nombre' => 'CajaYa - Plan Anual',    'precio' => 180000],
    'lifetime' => ['nombre' => 'CajaYa - Plan Lifetime', 'precio' => 180000],
    'empresa'  => ['nombre' => 'CajaYa - Plan Empresa',  'precio' => 35000],
];

$planKey = $_GET['plan'] ?? 'lifetime';
if (!isset($planes[$planKey])) {
    die("Plan no válido.");
}

$planData = $planes[$planKey];
$planName = $planData['nombre'];
$price    = $planData['precio'];
$orderId  = "CJY-" . strtoupper($planKey) . "-" . time();

$mp = new MercadoPagoService();
$paymentUrl = $mp->createPreference($planName, $price, $orderId);

if ($paymentUrl) {
    header("Location: " . $paymentUrl);
    exit;
} else {
    echo "Error al generar el link de pago. Por favor contacta a soporte.";
}
