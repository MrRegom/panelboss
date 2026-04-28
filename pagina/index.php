<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajaYa - El Punto de Venta más rápido de Chile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --apple-blue: #0071E3;
            --apple-gray: #1D1D1F;
            --apple-silver: #F5F5F7;
            --apple-muted: #86868B;
            --white: #FFFFFF;
            --border: rgba(0,0,0,0.1);
            --transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--white);
            color: var(--apple-gray);
            font-family: 'Inter', -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* --- BACKGROUND ANIMATION (MATH SYMBOLS) --- */
        .math-bg {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: -1; opacity: 0.15;
        }
        .symbol {
            position: absolute; color: var(--apple-blue); font-weight: 800;
            animation: float 20s linear infinite; font-size: 24px;
        }
        @keyframes float {
            0% { transform: translateY(110vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-10vh) rotate(360deg); opacity: 0; }
        }

        /* --- NAVIGATION --- */
        nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 1px solid var(--border);
            height: 52px; display: flex; align-items: center; justify-content: center;
            position: fixed; width: 100%; top: 0; z-index: 2000;
        }
        .nav-content { width: 1024px; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .logo-box { height: 30px; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-box img { height: 100%; }
        .logo-text { font-weight: 700; color: var(--apple-gray); font-size: 1.2rem; letter-spacing: -0.5px; }
        
        .nav-links a { color: var(--apple-gray); text-decoration: none; font-size: 12px; margin-left: 30px; opacity: 0.8; transition: 0.3s; }
        .nav-links a:hover { opacity: 1; color: var(--apple-blue); }

        /* --- HERO --- */
        .hero { padding: 150px 20px 60px; text-align: center; }
        .hero h1 { font-size: clamp(2.5rem, 8vw, 4.8rem); font-weight: 700; letter-spacing: -0.03em; line-height: 1.1; margin-bottom: 15px; }
        .hero h2 { font-size: clamp(1.2rem, 3vw, 2.2rem); color: var(--apple-blue); font-weight: 600; margin-bottom: 30px; }
        .hero p { font-size: 21px; color: var(--apple-muted); max-width: 800px; margin: 0 auto 40px; }

        .btn-apple {
            background: var(--apple-blue); color: white; padding: 12px 28px; border-radius: 980px;
            font-size: 17px; font-weight: 500; text-decoration: none; transition: var(--transition);
            display: inline-block;
        }
        .btn-apple:hover { transform: scale(1.05); background: #0077ED; box-shadow: 0 10px 20px rgba(0,113,227,0.2); }

        /* --- IMAC MOCKUP --- */
        .imac-mockup {
            max-width: 1000px; margin: 60px auto 0; padding: 0 20px;
            perspective: 2000px;
        }
        .imac-frame {
            background: #000; padding: 20px; border-radius: 30px 30px 5px 5px;
            box-shadow: 0 50px 100px rgba(0,0,0,0.1); transform: rotateX(5deg);
        }
        .imac-screen { background: #fff; border-radius: 10px; overflow: hidden; aspect-ratio: 16/9; }
        .imac-screen img { width: 100%; height: 100%; object-fit: cover; }

        /* --- FEATURES GRID --- */
        .section-title { font-size: 40px; font-weight: 700; text-align: center; margin-bottom: 60px; letter-spacing: -1px; }
        .features { padding: 100px 5%; background: var(--apple-silver); }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; max-width: 1100px; margin: 0 auto; }
        .card { background: #fff; padding: 40px; border-radius: 24px; transition: var(--transition); border: 1px solid transparent; }
        .card:hover { transform: translateY(-5px); border-color: var(--apple-blue); }
        .card h3 { font-size: 24px; margin-bottom: 15px; }
        .card p { color: var(--apple-muted); line-height: 1.6; }

        /* --- PRICING --- */
        .pricing { padding: 100px 5%; background: #fff; }
        .price-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; max-width: 1100px; margin: 0 auto; }
        .p-card { padding: 50px 30px; border-radius: 32px; border: 1px solid var(--border); text-align: center; transition: 0.3s; }
        .p-card.featured { border: 2px solid var(--apple-blue); position: relative; transform: scale(1.05); }
        .p-card.featured::top { content: 'Recomendado'; }
        .p-price { font-size: 48px; font-weight: 700; margin: 20px 0; }

        /* --- FAQ --- */
        .faq { padding: 100px 5%; background: var(--apple-silver); }
        .faq-box { max-width: 800px; margin: 0 auto; text-align: left; }
        .faq-item { background: #fff; margin-bottom: 15px; border-radius: 15px; padding: 25px; cursor: pointer; }
        .faq-item h4 { margin-bottom: 10px; color: var(--apple-blue); }

        @media (max-width: 768px) {
            .hero h1 { font-size: 3rem; }
            .p-card.featured { transform: scale(1); }
        }
    </style>
</head>
<body>

    <div class="math-bg" id="mathBg"></div>

    <nav>
        <div class="nav-content">
            <a href="/" class="logo-box">
                <img src="assets/img/logo.png" alt="Logo" onerror="this.style.display='none'">
                <span class="logo-text">CajaYa</span>
            </a>
            <div class="nav-links">
                <a href="#beneficios">Beneficios</a>
                <a href="#planes">Planes</a>
                <a href="#faq">Preguntas</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <h1>Tu negocio vende más.</h1>
        <h2>Tú trabajas menos.</h2>
        <p>El punto de venta certificado por el SII 2026 que funciona 100% offline. Potencia tu gestión con la elegancia de Apple y la robustez de CajaYa.</p>
        <a href="/mercadopago/checkout.php" class="btn-apple">Empezar Prueba Gratis</a>

        <div class="imac-mockup">
            <div class="imac-frame">
                <div class="imac-screen">
                    <!-- FOTO REAL DE LA APP -->
                    <img src="https://images.unsplash.com/photo-1556742044-3c52d6e88c62?auto=format&fit=crop&q=80&w=1200" alt="App Real CajaYa">
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="beneficios">
        <h2 class="section-title">¿Por qué CajaYa es superior?</h2>
        <div class="grid">
            <div class="card">
                <h3>Integración SII</h3>
                <p>Emisión automática de Boletas y Facturas electrónicas. Cumple con la normativa 2026 sin esfuerzo.</p>
            </div>
            <div class="card">
                <h3>100% Offline</h3>
                <p>¿Se cayó el internet? No importa. CajaYa sigue vendiendo y sincroniza todo cuando vuelve la conexión.</p>
            </div>
            <div class="card">
                <h3>Control Total</h3>
                <p>Gestión de inventario, reportes de ventas y cierre de caja en un solo clic desde tu celular o PC.</p>
            </div>
        </div>
    </section>

    <section class="pricing" id="planes">
        <h2 class="section-title">Planes para cada etapa</h2>
        <div class="price-grid">
            <div class="p-card">
                <h3>Plan Básico</h3>
                <div class="p-price">$20.000<span style="font-size: 16px; font-weight: 400;">/mes</span></div>
                <p>Ideal para negocios que comienzan.</p>
                <hr style="margin: 20px 0; opacity: 0.1;">
                <a href="/mercadopago/checkout.php" class="btn-apple" style="background: transparent; color: var(--apple-blue); border: 1px solid var(--apple-blue);">Suscribirse</a>
            </div>
            <div class="p-card featured">
                <h3>Plan Lifetime</h3>
                <div class="p-price">$180.000</div>
                <p>Único pago para siempre. Ahorras $360.000 el primer año.</p>
                <hr style="margin: 20px 0; opacity: 0.1;">
                <a href="/mercadopago/checkout.php" class="btn-apple">Comprar Ahora</a>
            </div>
            <div class="p-card">
                <h3>Plan Premium</h3>
                <div class="p-price">$35.000<span style="font-size: 16px; font-weight: 400;">/mes</span></div>
                <p>Soporte prioritario y multi-caja.</p>
                <hr style="margin: 20px 0; opacity: 0.1;">
                <a href="/mercadopago/checkout.php" class="btn-apple" style="background: transparent; color: var(--apple-blue); border: 1px solid var(--apple-blue);">Suscribirse</a>
            </div>
        </div>
    </section>

    <section class="faq" id="faq">
        <h2 class="section-title">Preguntas Frecuentes</h2>
        <div class="faq-box">
            <div class="faq-item">
                <h4>¿Cómo recibo mi licencia?</h4>
                <p>Tras el pago con Mercado Pago, recibirás un correo instantáneo con tus credenciales y el link de descarga.</p>
            </div>
            <div class="faq-item">
                <h4>¿Realmente funciona sin internet?</h4>
                <p>Sí. Nuestra arquitectura permite vender localmente y sincronizar con el SII automáticamente al detectar conexión.</p>
            </div>
            <div class="faq-item">
                <h4>¿Tienen soporte técnico?</h4>
                <p>Contamos con un equipo experto en Chile disponible vía WhatsApp para ayudarte en la instalación y uso diario.</p>
            </div>
        </div>
    </section>

    <script>
        const symbols = ['+', '-', '%', '$', '=', '×', '÷'];
        const container = document.getElementById('mathBg');
        for (let i = 0; i < 25; i++) {
            const span = document.createElement('span');
            span.className = 'symbol';
            span.innerText = symbols[Math.floor(Math.random() * symbols.length)];
            span.style.left = Math.random() * 100 + 'vw';
            span.style.animationDuration = (Math.random() * 10 + 10) + 's';
            span.style.animationDelay = (Math.random() * 20) + 's';
            span.style.fontSize = (Math.random() * 20 + 15) + 'px';
            container.appendChild(span);
        }
    </script>
</body>
</html>
