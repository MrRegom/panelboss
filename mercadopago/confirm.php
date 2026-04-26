<?php
// Recibimos los estados que configuramos en las Back URLs
$status = $_GET['status'] ?? 'failure';
$payment_id = $_GET['payment_id'] ?? null;
$external_reference = $_GET['external_reference'] ?? 'Desconocido';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado del Pago - CajaYa</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;800&display=swap" rel="stylesheet">
    <style>
        body { background: #07070a; color: #fff; font-family: 'Plus Jakarta Sans', sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .card { background: #0d0d14; padding: 50px; border-radius: 30px; border: 1px solid rgba(124, 58, 237, 0.2); text-align: center; max-width: 500px; box-shadow: 0 20px 50px rgba(0,0,0,0.5); }
        .status-icon { font-size: 80px; margin-bottom: 20px; }
        .success { color: #10b981; }
        .error { color: #ef4444; }
        .pending { color: #fbbf24; }
        h1 { margin-bottom: 10px; font-size: 2rem; }
        p { color: #94a3b8; margin-bottom: 30px; }
        .btn { background: #7c3aed; color: #fff; text-decoration: none; padding: 15px 30px; border-radius: 12px; font-weight: 800; display: inline-block; transition: 0.3s; }
        .btn:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(124, 58, 237, 0.4); }
    </style>
</head>
<body>

    <div class="card">
        <?php if ($status === 'success'): ?>
            <div class="status-icon success">✔</div>
            <h1>¡Gracias por tu compra!</h1>
            <p>Tu pago (ID: <?php echo $payment_id; ?>) ha sido procesado con éxito. Tu licencia para la orden <strong><?php echo $external_reference; ?></strong> ya está activa.</p>
            <a href="/panelboss/pagina/index.php" class="btn">Empezar a usar CajaYa</a>
        <?php elseif ($status === 'pending'): ?>
            <div class="status-icon pending">⏳</div>
            <h1>Pago Pendiente</h1>
            <p>Estamos esperando la confirmación de Mercado Pago. Te avisaremos por correo apenas se complete.</p>
            <a href="/panelboss/pagina/index.php" class="btn">Volver al sitio</a>
        <?php else: ?>
            <div class="status-icon error">✖</div>
            <h1>Pago Fallido</h1>
            <p>No pudimos procesar el pago. Por favor, intenta nuevamente o usa otro método.</p>
            <a href="/panelboss/pagina/index.php" class="btn">Reintentar ahora</a>
        <?php endif; ?>
    </div>

</body>
</html>
