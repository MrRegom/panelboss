<?php
/**
 * mercadopago/webhook.php — IPN / Webhook de Mercado Pago
 * 
 * Recibe notificaciones asíncronas de pagos.
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Cargar .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Services\MercadoPagoService;
use App\Services\LicenseService;
use App\Services\EmailService;
use App\Config\Database;

// Responder 200 OK de inmediato
http_response_code(200);
echo "OK";

// Obtener el cuerpo de la notificación
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data || !isset($data['type'])) {
    exit;
}

// Solo procesamos notificaciones de tipo 'payment'
if ($data['type'] !== 'payment') {
    exit;
}

$paymentId = $data['data']['id'] ?? null;
if (!$paymentId) {
    exit;
}

try {
    $mp = new MercadoPagoService();
    $payment = $mp->getPayment($paymentId);

    if (!$payment || $payment->status !== 'approved') {
        error_log("[MP Webhook] Pago $paymentId no está aprobado. Status: " . ($payment->status ?? 'unknown'));
        exit;
    }

    $commerceOrder = $payment->external_reference; // CJY-PLAN-TIME
    $email = $payment->payer->email;
    $amount = $payment->transaction_details->total_paid_amount;

    // Determinar el plan
    $plan = 'lifetime';
    if (strpos($commerceOrder, 'MENSUAL') !== false) $plan = 'mensual';
    elseif (strpos($commerceOrder, 'ANUAL') !== false) $plan = 'anual';
    elseif (strpos($commerceOrder, 'EMPRESA') !== false) $plan = 'empresa';

    // Evitar duplicados
    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT id FROM pagos WHERE mp_payment_id = :mp_id");
    $stmt->execute([':mp_id' => $paymentId]);
    if ($stmt->fetch()) {
        error_log("[MP Webhook] Pago $paymentId ya procesado anteriormente.");
        exit;
    }

    // Calcular expiración
    $expiresAt = null;
    if ($plan === 'mensual') $expiresAt = date('Y-m-d H:i:s', strtotime('+1 month'));
    elseif ($plan === 'anual') $expiresAt = date('Y-m-d H:i:s', strtotime('+1 year'));
    elseif ($plan === 'empresa') $expiresAt = date('Y-m-d H:i:s', strtotime('+1 month'));

    // Generar Licencia
    $licenseKey = strtoupper(implode('-', [
        substr(bin2hex(random_bytes(3)), 0, 6),
        substr(bin2hex(random_bytes(3)), 0, 6),
        substr(bin2hex(random_bytes(3)), 0, 6),
        substr(bin2hex(random_bytes(3)), 0, 6),
    ]));

    // Guardar en BD
    $stmtPago = $db->prepare("
        INSERT INTO pagos (commerce_order, mp_payment_id, email, plan, amount, status, gateway, license_key, expires_at)
        VALUES (:order, :mp_id, :email, :plan, :amount, 'paid', 'mercadopago', :license_key, :expires_at)
    ");
    $stmtPago->execute([
        ':order' => $commerceOrder,
        ':mp_id' => (string)$paymentId,
        ':email' => $email,
        ':plan' => $plan,
        ':amount' => (int)$amount,
        ':license_key' => $licenseKey,
        ':expires_at' => $expiresAt
    ]);

    // Crear la licencia en la tabla de licencias
    $stmtLic = $db->prepare("
        INSERT INTO licenses (license_key, plan, status, expires_at)
        VALUES (:license_key, :plan, 'pending', :expires_at)
    ");
    $stmtLic->execute([
        ':license_key' => $licenseKey,
        ':plan' => $plan,
        ':expires_at' => $expiresAt
    ]);

    // Enviar Email
    $nombreCliente = explode('@', $email)[0];
    EmailService::sendLicenseKey($email, ucfirst($nombreCliente), $licenseKey);

    error_log("[MP Webhook] ✅ Pago $paymentId procesado con éxito. Licencia $licenseKey enviada a $email.");

} catch (\Exception $e) {
    error_log("[MP Webhook] Error crítico: " . $e->getMessage());
}
