<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Services/WebpayService.php';

use App\Services\WebpayService;

// Webpay nos envía el token por POST o GET
$token = $_POST['token_ws'] ?? $_GET['token_ws'] ?? null;

if (!$token) {
    die("Acceso no autorizado. Token no encontrado.");
}

$webpay = new WebpayService();
$result = $webpay->commitTransaction($token);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado del Pago - CajaYa</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;800&display=swap" rel="stylesheet">
    <style>
        body { background: #07070a; color: #fff; font-family: 'Plus Jakarta Sans', sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .card { background: #0d0d14; padding: 50px; border-radius: 30px; border: 1px solid rgba(124, 58, 237, 0.2); text-align: center; max-width: 500px; box-shadow: 0 20px 50px rgba(0,0,0,0.5); }
        .status-icon { font-size: 80px; margin-bottom: 20px; }
        .success { color: #10b981; }
        .error { color: #ef4444; }
        h1 { margin-bottom: 10px; font-size: 2rem; }
        p { color: #94a3b8; margin-bottom: 30px; }
        .btn { background: #7c3aed; color: #fff; text-decoration: none; padding: 15px 30px; border-radius: 12px; font-weight: 800; display: inline-block; transition: 0.3s; }
        .btn:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(124, 58, 237, 0.4); }
    </style>
</head>
<body>

    <div class="card">
        <?php if ($result && $result->isApproved()): ?>
            <div class="status-icon success">✔</div>
            <h1>¡Pago Exitoso!</h1>
            <p>Bienvenido a la familia CajaYa. Tu Plan Lifetime ha sido activado. Hemos enviado los detalles a tu correo.</p>
            <!-- AQUÍ ES DONDE ACTUALIZARÍAS TU BASE DE DATOS -->
            <a href="/panelboss/pagina/index.php" class="btn">Ir al Dashboard</a>
        <?php else: ?>
            <div class="status-icon error">✖</div>
            <h1>Pago Rechazado</h1>
            <p>Lo sentimos, la transacción no pudo completarse. No se ha realizado ningún cargo en tu tarjeta.</p>
            <a href="/panelboss/pagina/index.php" class="btn">Reintentar Compra</a>
        <?php endif; ?>
    </div>

</body>
</html>
