<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajaYa - Próximamente</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0071E3;
            --dark: #1D1D1F;
            --bg: #F5F5F7;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background-color: var(--dark);
            color: white;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            text-align: center;
        }
        .container {
            max-width: 600px;
            padding: 20px;
            animation: fadeIn 1s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .logo {
            font-size: 3rem;
            font-weight: 800;
            letter-spacing: -2px;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #fff, #86868B);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        h1 {
            font-size: 1.5rem;
            font-weight: 400;
            color: #86868B;
            margin-bottom: 40px;
            line-height: 1.4;
        }
        .badge {
            display: inline-block;
            background: rgba(0, 113, 227, 0.1);
            color: var(--primary);
            padding: 8px 20px;
            border-radius: 980px;
            font-size: 0.9rem;
            font-weight: 600;
            border: 1px solid rgba(0, 113, 227, 0.3);
            margin-bottom: 20px;
        }
        .progress-bar {
            width: 200px;
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0 auto 40px;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }
        .progress-fill {
            position: absolute;
            top: 0; left: 0; height: 100%;
            width: 88%;
            background: var(--primary);
            box-shadow: 0 0 15px var(--primary);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.6; }
            100% { opacity: 1; }
        }
        .footer {
            position: absolute;
            bottom: 40px;
            font-size: 0.8rem;
            color: #424245;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="badge">Sincronizando con SII 2026</div>
        <div class="logo">CajaYa</div>
        <h1>Estamos preparando la plataforma de ventas más rápida de Chile.<br>Vuelve muy pronto.</h1>
        
        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>
        
        <p style="color: #0071E3; font-weight: 600;">88% Completado</p>
    </div>

    <div class="footer">
        CajaYa &copy; 2026 — Ingeniería Chilena de Alto Nivel
    </div>
</body>
</html>
