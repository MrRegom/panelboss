<?php
require_once __DIR__ . '/../../vendor/autoload.php';

// Cargar .env
if (file_exists(__DIR__ . '/../../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
}

$payment_id = $_GET['payment_id'] ?? null;
$status = $_GET['status'] ?? null;
$external_reference = $_GET['external_reference'] ?? null;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Pago Exitoso! - CajaYa</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #00d2ff;
            --secondary: #3a7bd5;
            --success: #00c853;
            --bg: #0f172a;
            --card: #1e293b;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
        }
        .container {
            background: var(--card);
            padding: 3rem;
            border-radius: 24px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            max-width: 450px;
            width: 90%;
            position: relative;
            animation: fadeIn 0.8s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .icon-box {
            width: 80px;
            height: 80px;
            background: rgba(0, 200, 83, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            border: 2px solid var(--success);
            color: var(--success);
            font-size: 2.5rem;
        }
        h1 { margin: 0 0 1rem; font-weight: 600; font-size: 2rem; }
        p { color: #94a3b8; line-height: 1.6; margin-bottom: 2rem; }
        .details {
            background: rgba(15, 23, 42, 0.5);
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            text-align: left;
        }
        .details div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        .details span { color: #64748b; }
        .details b { color: white; }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 10px 15px -3px rgba(0, 210, 255, 0.3);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 210, 255, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon-box">✓</div>
        <h1>¡Gracias por tu compra!</h1>
        <p>Tu pago ha sido procesado exitosamente. Tu licencia de CajaYa se activará en unos segundos.</p>
        
        <div class="details">
            <div><span>ID de Pago:</span> <b>#<?php echo htmlspecialchars($payment_id); ?></b></div>
            <div><span>Estado:</span> <b>Aprobado</b></div>
            <div><span>Referencia:</span> <b><?php echo htmlspecialchars($external_reference); ?></b></div>
        </div>

        <a href="https://cajaya.cl/dashboard" class="btn">Ir a mi Panel</a>
    </div>
</body>
</html>
