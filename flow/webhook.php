<?php
/**
 * flow/webhook.php — IPN (Instant Payment Notification)
 *
 * Flow llama a este endpoint vía POST cuando un pago cambia de estado.
 * Este script debe:
 *  1. Recibir el token del POST
 *  2. Consultar el estado real a la API de Flow (nunca confiar solo del POST)
 *  3. Si aprobado: crear licencia + enviar email al cliente
 *  4. Responder HTTP 200 (si no, Flow reintentará)
 *
 * Arquitectura: Controller delegado a Services (SRP)
 */

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Services\FlowService;
use App\Services\LicenseService;
use App\Services\EmailService;
use App\Core\Database;

// Responder 200 de inmediato para que Flow no reintente por timeout
http_response_code(200);
echo 'OK';

// Usar output buffering para que el echo no interfiera con la lógica
ob_start();

try {
    // ------------------------------------------------------------------
    // 1. Obtener token del POST de Flow
    // ------------------------------------------------------------------
    $token = $_POST['token'] ?? '';

    if (empty($token)) {
        error_log('[Flow IPN] Token vacío — petición ignorada.');
        exit;
    }

    // ------------------------------------------------------------------
    // 2. Consultar estado REAL a la API de Flow (verificación activa)
    // ------------------------------------------------------------------
    $flow    = new FlowService();
    $payment = $flow->getPaymentStatus($token);

    if (!$payment) {
        error_log('[Flow IPN] No se pudo obtener estado del pago para token: ' . $token);
        exit;
    }

    $statusCode     = (int)($payment['status'] ?? 0);
    $status         = $flow->mapStatus($statusCode);
    $commerceOrder  = $payment['commerceOrder'] ?? '';   // ej: CJY-LIFETIME-1714500000
    $amount         = (int)($payment['amount']  ?? 0);
    $email          = $payment['payer']         ?? '';   // email del comprador

    error_log("[Flow IPN] Orden: $commerceOrder | Estado: $status | Email: $email");

    // Solo procesar si el pago fue exitoso
    if ($status !== 'success') {
        error_log("[Flow IPN] Pago no aprobado ($status) — sin acción.");
        exit;
    }

    // ------------------------------------------------------------------
    // 3. Evitar procesamiento duplicado — verificar si ya existe en BD
    // ------------------------------------------------------------------
    $db  = Database::getConnection();
    $stmt = $db->prepare(
        'SELECT id FROM pagos WHERE flow_token = :token LIMIT 1'
    );
    $stmt->execute([':token' => $token]);

    if ($stmt->fetch()) {
        error_log("[Flow IPN] Pago ya procesado para token: $token");
        exit;
    }

    // ------------------------------------------------------------------
    // 4. Determinar el plan según la referencia de la orden
    // ------------------------------------------------------------------
    $plan = 'lifetime'; // Default
    if (str_contains($commerceOrder, 'MENSUAL'))  $plan = 'mensual';
    if (str_contains($commerceOrder, 'ANUAL'))    $plan = 'anual';
    if (str_contains($commerceOrder, 'EMPRESA'))  $plan = 'empresa';
    if (str_contains($commerceOrder, 'LIFETIME')) $plan = 'lifetime';

    // Calcular fecha de expiración según plan
    $expiresAt = match ($plan) {
        'mensual'  => date('Y-m-d H:i:s', strtotime('+1 month')),
        'anual'    => date('Y-m-d H:i:s', strtotime('+1 year')),
        'empresa'  => date('Y-m-d H:i:s', strtotime('+1 month')),
        'lifetime' => null,  // Sin expiración
        default    => date('Y-m-d H:i:s', strtotime('+1 month')),
    };

    // ------------------------------------------------------------------
    // 5. Generar clave de licencia única
    // ------------------------------------------------------------------
    $licenseKey = strtoupper(implode('-', [
        substr(bin2hex(random_bytes(3)), 0, 6),
        substr(bin2hex(random_bytes(3)), 0, 6),
        substr(bin2hex(random_bytes(3)), 0, 6),
        substr(bin2hex(random_bytes(3)), 0, 6),
    ]));

    // ------------------------------------------------------------------
    // 6. Guardar pago en tabla `pagos`
    // ------------------------------------------------------------------
    $stmtPago = $db->prepare('
        INSERT INTO pagos
            (commerce_order, flow_token, email, plan, amount, status, license_key, expires_at, created_at)
        VALUES
            (:order, :token, :email, :plan, :amount, :status, :license_key, :expires_at, NOW())
    ');
    $stmtPago->execute([
        ':order'       => $commerceOrder,
        ':token'       => $token,
        ':email'       => $email,
        ':plan'        => $plan,
        ':amount'      => $amount,
        ':status'      => 'paid',
        ':license_key' => $licenseKey,
        ':expires_at'  => $expiresAt,
    ]);

    // ------------------------------------------------------------------
    // 7. Crear licencia en tabla `licenses` (para el sistema de activación)
    // ------------------------------------------------------------------
    $stmtLic = $db->prepare('
        INSERT INTO licenses
            (license_key, plan, status, expires_at, created_at)
        VALUES
            (:license_key, :plan, :status, :expires_at, NOW())
    ');
    $stmtLic->execute([
        ':license_key' => $licenseKey,
        ':plan'        => $plan,
        ':status'      => 'pending',   // Se activa al primer uso en el POS
        ':expires_at'  => $expiresAt,
    ]);

    error_log("[Flow IPN] ✅ Licencia creada: $licenseKey para $email (plan: $plan)");

    // ------------------------------------------------------------------
    // 8. Enviar email con la licencia al cliente
    // ------------------------------------------------------------------
    $nombreCliente = explode('@', $email)[0];  // Nombre provisional del email
    $emailEnviado  = EmailService::sendLicenseKey($email, ucfirst($nombreCliente), $licenseKey);

    if ($emailEnviado) {
        error_log("[Flow IPN] 📧 Email enviado a: $email");
    } else {
        error_log("[Flow IPN] ⚠️ Error al enviar email a: $email (licencia: $licenseKey)");
    }

} catch (\Throwable $e) {
    error_log('[Flow IPN] Excepción no controlada: ' . $e->getMessage());
}

ob_end_clean();
