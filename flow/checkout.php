<?php
/**
 * flow/checkout.php
 * Punto de entrada del proceso de pago con Flow.
 *
 * Recibe: ?plan=mensual|lifetime|empresa
 * Crea la preferencia de pago en Flow y redirige al cliente.
 *
 * Arquitectura: View → Service (sin lógica de negocio en este archivo)
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno desde .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Services\FlowService;

// -----------------------------------------------------------------------
// 1. Definir planes disponibles
// -----------------------------------------------------------------------
$planes = [
    'mensual'  => ['nombre' => 'CajaYa - Plan Mensual',  'precio' => 20000],
    'anual'    => ['nombre' => 'CajaYa - Plan Anual',    'precio' => 180000],
    'lifetime' => ['nombre' => 'CajaYa - Plan Lifetime', 'precio' => 180000],
    'empresa'  => ['nombre' => 'CajaYa - Plan Empresa',  'precio' => 35000],
];

// -----------------------------------------------------------------------
// 2. Obtener el plan desde la query string (default: lifetime)
// -----------------------------------------------------------------------
$planKey = $_GET['plan'] ?? 'lifetime';

if (!array_key_exists($planKey, $planes)) {
    http_response_code(400);
    exit('Plan no válido.');
}

$plan     = $planes[$planKey];
$orderId  = 'CJY-' . strtoupper($planKey) . '-' . time();

// -----------------------------------------------------------------------
// 3. Crear la orden en Flow y redirigir
// -----------------------------------------------------------------------
$flow = new FlowService();

$urlBase         = 'https://' . $_SERVER['HTTP_HOST'];
$urlConfirmation = $urlBase . '/flow/webhook.php';  // IPN asíncrono
$urlReturn       = $urlBase . '/flow/result.php';   // Retorno del cliente

$result = $flow->createPaymentOrder(
    orderId:         $orderId,
    subject:         $plan['nombre'],
    amount:          $plan['precio'],
    email:           $_GET['email'] ?? '',           // Opcional: pasar email desde la landing
    urlConfirmation: $urlConfirmation,
    urlReturn:       $urlReturn
);

if ($result) {
    // Redirigir al checkout de Flow
    header('Location: ' . $result['url']);
    exit;
}

// Si Flow falla, mostrar error amigable
http_response_code(502);
echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">
<title>Error de pago - CajaYa</title>
<style>body{font-family:system-ui,sans-serif;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;background:#f5f5f7}
.box{text-align:center;max-width:400px;padding:40px}h1{font-size:1.5rem}p{color:#555}a{color:#0071E3}</style>
</head><body><div class="box">
<div style="font-size:48px">⚠️</div>
<h1>No pudimos generar el link de pago</h1>
<p>Ocurrió un error temporal con el procesador de pagos. Por favor intenta en unos minutos.</p>
<a href="/">← Volver al inicio</a>
</div></body></html>';
