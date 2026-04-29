<?php
/**
 * flow/result.php
 * Página de retorno post-pago donde Flow redirige al cliente.
 *
 * Flow pasa el token via GET. Se consulta el estado real a la API.
 * Muestra pantalla de éxito, pendiente o error según el resultado.
 */

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Services\FlowService;

// Obtener token desde la URL de retorno
$token   = $_GET['token'] ?? '';
$payment = null;
$status  = 'unknown';

if ($token) {
    $flow    = new FlowService();
    $payment = $flow->getPaymentStatus($token);
    if ($payment) {
        $status = $flow->mapStatus((int)($payment['status'] ?? 0));
    }
}

// Obtener licencia generada (si ya fue procesada por el webhook)
$licenseKey = null;
if ($status === 'success' && $token) {
    try {
        require_once __DIR__ . '/../src/Core/Database.php';
        $db   = App\Core\Database::getConnection();
        $stmt = $db->prepare('SELECT license_key FROM pagos WHERE flow_token = :token LIMIT 1');
        $stmt->execute([':token' => $token]);
        $row  = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row) $licenseKey = $row['license_key'];
    } catch (\Throwable $e) {
        // No romper la página si la BD falla
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estado del Pago — CajaYa</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #F5F5F7;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: #fff;
            border-radius: 24px;
            padding: 50px 40px;
            text-align: center;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
        }
        .icon { font-size: 64px; margin-bottom: 20px; }
        h1 { font-size: 1.8rem; font-weight: 800; color: #1D1D1F; margin-bottom: 12px; }
        .sub { color: #86868B; font-size: 1rem; line-height: 1.6; margin-bottom: 30px; }
        /* Caja de licencia */
        .license-box {
            background: #F5F5F7;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 30px;
            border: 1px dashed #C7C7CC;
        }
        .license-label { font-size: 11px; font-weight: 700; color: #86868B; text-transform: uppercase; letter-spacing: 1.5px; }
        .license-key {
            font-family: 'Courier New', monospace;
            font-size: 22px;
            font-weight: 800;
            color: #0071E3;
            margin-top: 8px;
            letter-spacing: 2px;
        }
        .btn {
            display: inline-block;
            background: #0071E3;
            color: #fff;
            padding: 14px 32px;
            border-radius: 980px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 6px;
        }
        .btn:hover { background: #0077ED; transform: scale(1.03); }
        .btn-outline {
            background: transparent;
            color: #0071E3;
            border: 1px solid #0071E3;
        }
        .btn-outline:hover { background: rgba(0,113,227,0.06); }
        /* Colores de estado */
        .ok   { color: #28C840; }
        .warn { color: #FF9F0A; }
        .err  { color: #FF3B30; }
    </style>
</head>
<body>
<div class="card">

    <?php if ($status === 'success'): ?>
        <div class="icon ok">✅</div>
        <h1>¡Gracias por tu compra!</h1>
        <p class="sub">Tu pago fue procesado correctamente. Recibirás un email con tu licencia en los próximos minutos.</p>

        <?php if ($licenseKey): ?>
        <div class="license-box">
            <div class="license-label">Tu Clave de Activación</div>
            <div class="license-key"><?= htmlspecialchars($licenseKey) ?></div>
        </div>
        <?php else: ?>
        <p class="sub" style="font-size:0.9rem">🔑 Tu licencia está siendo generada. Revisa tu email en unos segundos.</p>
        <?php endif; ?>

        <a href="/" class="btn">Ir al inicio</a>

    <?php elseif ($status === 'pending'): ?>
        <div class="icon warn">⏳</div>
        <h1>Pago en proceso</h1>
        <p class="sub">Tu pago está siendo verificado. Recibirás un email con tu licencia una vez confirmado.</p>
        <a href="/" class="btn btn-outline">Volver al inicio</a>

    <?php elseif ($status === 'cancelled'): ?>
        <div class="icon warn">🚫</div>
        <h1>Pago cancelado</h1>
        <p class="sub">Cancelaste el proceso de pago. No se realizó ningún cargo.</p>
        <a href="/#planes" class="btn">Ver planes</a>

    <?php else: ?>
        <div class="icon err">❌</div>
        <h1>Pago no procesado</h1>
        <p class="sub">No pudimos completar el pago. Puedes intentarlo nuevamente o usar otro método de pago.</p>
        <a href="/#planes" class="btn">Reintentar</a>
        <a href="mailto:soporte@cajaya.cl" class="btn btn-outline">Contactar soporte</a>
    <?php endif; ?>

</div>
</body>
</html>
