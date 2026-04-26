<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Services/WebpayService.php';

use App\Services\WebpayService;

// Datos de prueba (Luego vendrán de tu base de datos o sesión)
$buyOrder = "ORD-" . time();
$sessionId = "SESS-" . session_id();
$amount = 180000; // El precio del Plan Lifetime
$returnUrl = "http://" . $_SERVER['HTTP_HOST'] . "/panelboss/webpay/confirm.php";

$webpay = new WebpayService();
$response = $webpay->createTransaction($buyOrder, $sessionId, $amount, $returnUrl);

if ($response && isset($response->url)) {
    // Redirigimos automáticamente al portal de Webpay
    $url = $response->url;
    $token = $response->token;
    
    echo "
    <form id='webpay-form' action='{$url}' method='POST'>
        <input type='hidden' name='token_ws' value='{$token}' />
    </form>
    <script>document.getElementById('webpay-form').submit();</script>
    ";
} else {
    echo "Error al iniciar la transacción. Por favor, intenta más tarde.";
}
