<?php
$status = $_GET['status'] ?? 'pending';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Pendiente - CajaYa</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --warning: #ffb300;
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
            background: rgba(255, 179, 0, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            border: 2px solid var(--warning);
            color: var(--warning);
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
        <div class="icon-box">!</div>
        <h1>Pago en proceso</h1>
        <p>Tu pago está siendo verificado. Te avisaremos por correo una vez que tu licencia esté activa.</p>
        <a href="https://cajaya.cl/dashboard" class="btn">Volver al Panel</a>
    </div>
</body>
</html>
