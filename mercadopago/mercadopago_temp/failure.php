<?php
$status = $_GET['status'] ?? 'error';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Fallido - CajaYa</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --error: #ff5252;
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
        }
        .icon-box {
            width: 80px;
            height: 80px;
            background: rgba(255, 82, 82, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            border: 2px solid var(--error);
            color: var(--error);
            font-size: 2.5rem;
        }
        h1 { margin: 0 0 1rem; }
        p { color: #94a3b8; line-height: 1.6; margin-bottom: 2rem; }
        .btn {
            display: inline-block;
            background: #334155;
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn:hover { background: #475569; }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon-box">✕</div>
        <h1>El pago no se completó</h1>
        <p>Hubo un problema procesando tu transacción. No se ha realizado ningún cargo.</p>
        <a href="https://cajaya.cl/pricing" class="btn">Reintentar Pago</a>
    </div>
</body>
</html>
