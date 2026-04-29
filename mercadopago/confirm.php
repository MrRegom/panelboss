<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Config\Database;

$status = $_GET['status'] ?? 'failure';
$payment_id = $_GET['payment_id'] ?? null;
$external_reference = $_GET['external_reference'] ?? 'Desconocido';

$licenseKey = null;
if ($status === 'success' && $payment_id) {
    try {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT license_key FROM pagos WHERE mp_payment_id = :mp_id LIMIT 1");
        $stmt->execute([':mp_id' => (string)$payment_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $licenseKey = $row['license_key'];
        }
    } catch (Exception $e) {
        // Ignorar error de base de datos en la vista
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estado del Pago - CajaYa</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { background: #07070a; color: #fff; font-family: 'Inter', sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; padding: 20px; }
        .card { background: #0d0d14; padding: 50px 30px; border-radius: 30px; border: 1px solid rgba(0, 113, 227, 0.2); text-align: center; max-width: 500px; width: 100%; box-shadow: 0 20px 50px rgba(0,0,0,0.5); }
        .status-icon { font-size: 64px; margin-bottom: 20px; }
        .success { color: #10b981; }
        .error { color: #ef4444; }
        .pending { color: #fbbf24; }
        h1 { margin-bottom: 15px; font-size: 1.8rem; font-weight: 800; }
        p { color: #94a3b8; margin-bottom: 30px; line-height: 1.6; }
        .license-box { background: rgba(0, 113, 227, 0.1); border: 1px dashed #0071e3; border-radius: 15px; padding: 20px; margin-bottom: 30px; }
        .license-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #0071e3; font-weight: 600; margin-bottom: 5px; }
        .license-key { font-family: monospace; font-size: 20px; color: #fff; font-weight: 800; }
        .btn { background: #0071e3; color: #fff; text-decoration: none; padding: 16px 32px; border-radius: 980px; font-weight: 600; display: inline-block; transition: 0.3s; }
        .btn:hover { background: #0077ed; transform: scale(1.02); }
    </style>
</head>
<body>

    <div class="card">
        <?php if ($status === 'success'): ?>
            <div class="status-icon success">✔</div>
            <h1>¡Gracias por tu compra!</h1>
            <p>Tu pago ha sido procesado con éxito. Hemos enviado los detalles a tu correo electrónico.</p>
            
            <?php if ($licenseKey): ?>
                <div class="license-box">
                    <div class="license-label">Tu Clave de Activación</div>
                    <div class="license-key"><?php echo $licenseKey; ?></div>
                </div>
            <?php else: ?>
                <p style="font-size: 14px; margin-top: -15px;">🔑 Estamos generando tu licencia, la recibirás por email en unos segundos.</p>
            <?php endif; ?>

            <a href="/" class="btn">Volver al inicio</a>
        <?php elseif ($status === 'pending'): ?>
            <div class="status-icon pending">⏳</div>
            <h1>Pago Pendiente</h1>
            <p>Estamos esperando la confirmación de Mercado Pago. Te avisaremos por correo apenas se complete.</p>
            <a href="/" class="btn">Volver al sitio</a>
        <?php else: ?>
            <div class="status-icon error">✖</div>
            <h1>Pago Fallido</h1>
            <p>No pudimos procesar el pago. Por favor, intenta nuevamente o usa otro método.</p>
            <a href="/#planes" class="btn">Reintentar ahora</a>
        <?php endif; ?>
    </div>

</body>
</html>
