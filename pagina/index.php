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
        .logo-text { display: none; }
        .logo-fallback { font-weight: 700; color: var(--apple-gray); font-size: 1.2rem; letter-spacing: -0.5px; }
        /* iOS Scroll Reveal */
        .reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.7s ease, transform 0.7s cubic-bezier(0.23,1,0.32,1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        /* Botón Gmail */
        .btn-gmail { display: inline-flex; align-items: center; gap: 10px; background: #fff; color: #1D1D1F; border: 1px solid rgba(0,0,0,0.15); padding: 12px 24px; border-radius: 980px; font-size: 17px; font-weight: 500; text-decoration: none; transition: var(--transition); box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-left: 12px; }
        .btn-gmail:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.12); transform: scale(1.03); }
        .btn-gmail svg { width: 20px; height: 20px; }
        /* Badge destacado */
        .badge-rec { background: var(--apple-blue); color: #fff; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 980px; text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-bottom: 16px; }
        /* Plan features list */
        .p-features { list-style: none; text-align: left; margin: 20px 0; }
        .p-features li { padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05); font-size: 14px; color: var(--apple-muted); }
        .p-features li::before { content: '✓ '; color: var(--apple-blue); font-weight: 700; }
        /* Testimonials */
        .testimonials { padding: 100px 5%; background: #fff; }
        .t-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; max-width: 1100px; margin: 0 auto; }
        .t-card { background: var(--apple-silver); padding: 30px; border-radius: 20px; }
        .t-card p { font-size: 16px; line-height: 1.6; margin-bottom: 20px; }
        .t-author { font-weight: 600; color: var(--apple-blue); font-size: 14px; }
        /* Footer */
        footer { background: #1D1D1F; color: #86868B; text-align: center; padding: 40px 20px; font-size: 13px; }
        footer a { color: var(--apple-blue); text-decoration: none; margin: 0 10px; }
        
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

        /* --- HERO CAROUSEL 2-COL --- */
        .hero-wrap { position: relative; overflow: hidden; }
        /* Track: grid que apila slides uno encima del otro */
        .c-track {
            display: grid;
            width: 100%;
        }
        .c-slide {
            grid-column: 1; grid-row: 1; /* todos en la misma celda */
            display: flex;
            align-items: center;
            min-height: 100vh;
            padding: 80px 6% 60px;
            box-sizing: border-box;
            gap: 48px;
            opacity: 0;
            visibility: hidden;
            transform: scale(1.03);
            transition: opacity 0.7s ease, transform 0.7s cubic-bezier(.23,1,.32,1), visibility 0s linear 0.7s;
            pointer-events: none;
        }
        .c-slide.active {
            opacity: 1;
            visibility: visible;
            transform: scale(1);
            pointer-events: auto;
            transition: opacity 0.7s ease, transform 0.7s cubic-bezier(.23,1,.32,1), visibility 0s linear 0s;
        }
        /* Columnas */
        .c-text { flex: 1; min-width: 0; }
        .c-visual {
            flex: 1; min-width: 0;
            display: flex; align-items: center; justify-content: center;
            position: relative;
        }
        .c-img {
            width: 100%; max-width: 560px; border-radius: 22px;
            box-shadow: 0 40px 80px rgba(0,0,0,0.13);
            animation: heroFloat 7s ease-in-out infinite;
            display: block;
        }
        @keyframes heroFloat {
            0%,100% { transform: translateY(0px); }
            50%      { transform: translateY(-14px); }
        }
        /* Badge del slide */
        .c-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(0,113,227,0.07); color: var(--apple-blue);
            font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;
            padding: 6px 14px; border-radius: 980px; border: 1px solid rgba(0,113,227,0.15);
            margin-bottom: 18px;
        }
        .c-h1 {
            font-size: clamp(2.2rem, 4.5vw, 4rem);
            font-weight: 800; letter-spacing: -0.03em; line-height: 1.08;
            color: #1D1D1F; margin-bottom: 18px;
        }
        .c-h1 span { color: var(--apple-blue); }
        .c-p {
            font-size: clamp(1rem, 1.6vw, 1.15rem);
            color: #515154; max-width: 440px; line-height: 1.65; margin-bottom: 30px;
        }
        .c-btns { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; margin-bottom: 18px; }
        .c-trust { display: flex; flex-wrap: wrap; gap: 14px; font-size: 12px; color: #86868B; }
        /* Controles */
        .c-dots { display:flex; gap:8px; justify-content:center; padding:20px 0 10px; }
        .c-dot { width:8px; height:8px; border-radius:50%; background:#D2D2D7; border:none; cursor:pointer; transition:all .3s; }
        .c-dot.on { background:var(--apple-blue); width:22px; border-radius:4px; }
        .c-arr {
            position:absolute; top:50%; transform:translateY(-50%);
            background:rgba(255,255,255,0.9); border:1px solid rgba(0,0,0,0.1);
            border-radius:50%; width:42px; height:42px; font-size:20px;
            display:flex; align-items:center; justify-content:center;
            cursor:pointer; z-index:5; transition:.2s;
            box-shadow:0 2px 10px rgba(0,0,0,0.08); backdrop-filter:blur(8px);
        }
        .c-arr:hover { box-shadow:0 6px 20px rgba(0,0,0,0.14); }
        .c-prev { left:16px; } .c-next { right:16px; }
        /* ---- FLOATING DATA BADGES ---- */
        .f-badge {
            position: absolute;
            background: #fff;
            border-radius: 16px;
            padding: 10px 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.10);
            font-size: 13px; font-weight: 600; color: #1D1D1F;
            display: flex; align-items: center; gap: 8px;
            white-space: nowrap;
            border: 1px solid rgba(0,0,0,0.06);
            pointer-events: none;
        }
        .f-badge .f-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; }
        .fb1 { top: 18%; right: -30px; animation: fb1anim 4s ease-in-out infinite; }
        .fb2 { top: 55%; right: -40px; animation: fb2anim 5s ease-in-out infinite 0.8s; }
        .fb3 { bottom: 18%; left: -20px; animation: fb3anim 4.5s ease-in-out infinite 0.4s; }
        @keyframes fb1anim { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        @keyframes fb2anim { 0%,100%{transform:translateY(0)} 50%{transform:translateY(8px)} }
        @keyframes fb3anim { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        /* Responsive */
        @media (max-width: 820px) {
            .c-slide { flex-direction: column; min-height: auto; padding: 90px 20px 40px; }
            .c-text { text-align: center; }
            .c-p { max-width: 100%; }
            .c-btns { justify-content: center; }
            .c-trust { justify-content: center; }
            .c-visual { margin-top: 10px; }
            .c-img { animation: none; }
            .f-badge { display: none; }
            .c-arr { display: none; }
        }
        @media (max-width: 768px) {
            .hero h1 { font-size: 3rem; }
            .p-card.featured { transform: scale(1); }
            .nav-links { display: none; }
            .section-title { font-size: 28px; }
            .grid { grid-template-columns: 1fr; }
            .price-grid { grid-template-columns: 1fr; }
            .t-grid { grid-template-columns: 1fr; }
            .features, .pricing, .faq, .testimonials { padding: 60px 16px; }
        }
    </style>
</head>
<body>
    <div style="background: #FF9F0A; color: #000; text-align: center; padding: 12px; font-weight: 700; position: sticky; top: 0; z-index: 9999; font-size: 13px; letter-spacing: 0.5px; border-bottom: 2px solid rgba(0,0,0,0.1);">
        ⚠️ MODO DE PRUEBAS ACTIVO - LAS VENTAS ESTÁN EN FASE DE VALIDACIÓN ⚠️
    </div>

    <div class="math-bg" id="mathBg"></div>

    <nav>
        <div class="nav-content">
            <a href="/" class="logo-box">
                <img src="assets/img/logo.png" alt="CajaYa" onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                <span class="logo-fallback" style="display:none">CajaYa</span>
            </a>
            <div class="nav-links">
                <a href="#beneficios">Beneficios</a>
                <a href="#planes">Planes</a>
                <a href="#faq">Preguntas</a>
            </div>
        </div>
    </nav>

    <!-- HERO CAROUSEL -->
    <section class="hero-wrap" id="hero">
        <button class="c-arr c-prev" onclick="cMove(-1)">&#8249;</button>
        <button class="c-arr c-next" onclick="cMove(1)">&#8250;</button>

        <div class="c-track" id="ctrack">

            <!-- SLIDE 1 -->
            <div class="c-slide active">
                <div class="c-text">
                    <span class="c-badge">&#10024; SII Certificado 2026</span>
                    <h1 class="c-h1">Tu negocio vende m&aacute;s.<br><span>T&uacute; trabajas menos.</span></h1>
                    <p class="c-p">El POS m&aacute;s r&aacute;pido de Chile. 100% Offline, Boletas Electr&oacute;nicas y cierre de caja autom&aacute;tico desde $20.000/mes.</p>
                    <div class="c-btns">
                        <a href="/mercadopago/checkout.php" class="btn-apple">Comprar Ahora</a>
                        <a href="/api/auth/google" class="btn-gmail"><svg viewBox="0 0 24 24" style="width:18px;height:18px"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg> Prueba Gratis</a>
                    </div>
                    <div class="c-trust"><span>&#10003; SII 2026</span><span>&#10003; +400 Pymes</span><span>&#10003; 30 D&iacute;as Garant&iacute;a</span></div>
                </div>
                <div class="c-visual">
                    <img src="assets/cajaya_pos_mockup.png" alt="CajaYa POS" class="c-img">
                    <div class="f-badge fb1"><div class="f-dot" style="background:#28C840"></div> Venta OK &mdash; $12.500</div>
                    <div class="f-badge fb2"><div class="f-dot" style="background:#0071E3"></div> Boleta SII emitida</div>
                    <div class="f-badge fb3"><div class="f-dot" style="background:#FF9F0A"></div> Stock: 245 unidades</div>
                </div>
            </div>

            <!-- SLIDE 2 -->
            <div class="c-slide">
                <div class="c-text">
                    <span class="c-badge">&#128246; 100% Offline</span>
                    <h1 class="c-h1">&iquest;Se cay&oacute; el internet?<br><span>CajaYa sigue vendiendo.</span></h1>
                    <p class="c-p">Tecnolog&iacute;a offline-first que garantiza que nunca pierdas una venta. Sincroniza autom&aacute;ticamente al volver la conexi&oacute;n.</p>
                    <div class="c-btns"><a href="/mercadopago/checkout.php" class="btn-apple">Ver Planes desde $20.000/mes</a></div>
                </div>
                <div class="c-visual">
                    <img src="assets/cajaya_pos_v2.png" alt="CajaYa Offline" class="c-img">
                    <div class="f-badge fb1"><div class="f-dot" style="background:#FF5F57"></div> Sin internet &mdash; Vendiendo</div>
                    <div class="f-badge fb2"><div class="f-dot" style="background:#28C840"></div> Sync pendiente: 8 ventas</div>
                    <div class="f-badge fb3"><div class="f-dot" style="background:#0071E3"></div> Total hoy: $450.000</div>
                </div>
            </div>

            <!-- SLIDE 3 -->
            <div class="c-slide">
                <div class="c-text">
                    <span class="c-badge">&#128424; Plug &amp; Play</span>
                    <h1 class="c-h1">Compatible con<br><span>todo tu hardware.</span></h1>
                    <p class="c-p">Impresoras t&eacute;rmicas 58/80mm, gaveta autom&aacute;tica y lector de c&oacute;digo de barras. Listo en minutos.</p>
                    <div class="c-btns"><a href="/mercadopago/checkout.php" class="btn-apple">Empezar Ahora &rarr;</a></div>
                </div>
                <div class="c-visual">
                    <img src="assets/cajaya_hardware_mockup.png" alt="CajaYa Hardware" class="c-img">
                    <div class="f-badge fb1"><div class="f-dot" style="background:#28C840"></div> Impresora conectada</div>
                    <div class="f-badge fb2"><div class="f-dot" style="background:#0071E3"></div> Lector c&oacute;d. barras OK</div>
                    <div class="f-badge fb3"><div class="f-dot" style="background:#FF9F0A"></div> Gaveta lista</div>
                </div>
            </div>

        </div><!-- /c-track -->
        <div class="c-dots">
            <button class="c-dot on" onclick="cGo(0)"></button>
            <button class="c-dot" onclick="cGo(1)"></button>
            <button class="c-dot" onclick="cGo(2)"></button>
        </div>
    </section>

    <section class="features" id="beneficios">
        <h2 class="section-title reveal">¿Por qué CajaYa es superior?</h2>
        <div class="grid">
            <div class="card reveal"><div style="font-size:32px;margin-bottom:16px">🧾</div><h3>Boletas SII Certificadas</h3><p>Emisión automática de Boletas y Facturas electrónicas. Certificado SII 2026 sin trámites extras.</p></div>
            <div class="card reveal"><div style="font-size:32px;margin-bottom:16px">📶</div><h3>100% Offline</h3><p>Si se corta internet, sigues vendiendo. CajaYa sincroniza automáticamente al restaurarse la conexión.</p></div>
            <div class="card reveal"><div style="font-size:32px;margin-bottom:16px">⚡</div><h3>Ventas Ultra-Rápidas</h3><p>Cobra en segundos con lector de código de barras, impresora térmica 58/80mm y gaveta automática.</p></div>
            <div class="card reveal"><div style="font-size:32px;margin-bottom:16px">📊</div><h3>Reportes en Tiempo Real</h3><p>Dashboard con ventas del día, semana y mes. Cierre de caja automático con desglose completo.</p></div>
            <div class="card reveal"><div style="font-size:32px;margin-bottom:16px">📦</div><h3>Control de Inventario</h3><p>Alertas automáticas de stock bajo. Gestiona miles de productos con código de barras o categorías.</p></div>
            <div class="card reveal"><div style="font-size:32px;margin-bottom:16px">🔒</div><h3>Multi-Usuario Seguro</h3><p>Roles de vendedor, supervisor y administrador. Cada empleado con su acceso y límites definidos.</p></div>
        </div>
        <div style="text-align:center; margin-top:60px" class="reveal">
            <img src="assets/cajaya_hardware_mockup.png" alt="Hardware CajaYa" style="max-width:700px; width:100%; border-radius:20px; box-shadow: 0 30px 60px rgba(0,0,0,0.08);">
        </div>
    </section>

    <section class="pricing" id="planes">
        <h2 class="section-title reveal">Planes para cada etapa</h2>
        <p style="text-align:center;color:var(--apple-muted);margin-bottom:60px;font-size:19px" class="reveal">Sin letras chicas. Sin sorpresas. Cancela cuando quieras.</p>
        <div class="price-grid">
            <div class="p-card reveal">
                <h3>Plan Mensual</h3>
                <div class="p-price">$20.000<span style="font-size:16px;font-weight:400">/mes</span></div>
                <p style="color:var(--apple-muted);font-size:14px">Ideal para empezar sin riesgo.</p>
                <ul class="p-features">
                    <li>1 Punto de Venta</li>
                    <li>Boletas Electrónicas SII</li>
                    <li>Inventario ilimitado</li>
                    <li>Soporte por WhatsApp</li>
                    <li>Actualizaciones incluidas</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-apple" style="background:transparent;color:var(--apple-blue);border:1px solid var(--apple-blue);display:block;text-align:center">Comenzar</a>
            </div>
            <div class="p-card featured reveal">
                <span class="badge-rec">⭐ Más Popular</span>
                <h3>Plan Lifetime</h3>
                <div class="p-price">$180.000</div>
                <p style="color:var(--apple-muted);font-size:14px">Un solo pago. Tuyo para siempre.</p>
                <ul class="p-features">
                    <li>3 Puntos de Venta</li>
                    <li>Boletas y Facturas SII</li>
                    <li>Inventario ilimitado</li>
                    <li>Cierre de caja avanzado</li>
                    <li>Reportes y estadísticas</li>
                    <li>Soporte prioritario</li>
                    <li>Actualizaciones de por vida</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-apple" style="display:block;text-align:center">Comprar Ahora</a>
            </div>
            <div class="p-card reveal">
                <h3>Plan Empresa</h3>
                <div class="p-price">$35.000<span style="font-size:16px;font-weight:400">/mes</span></div>
                <p style="color:var(--apple-muted);font-size:14px">Para negocios en crecimiento.</p>
                <ul class="p-features">
                    <li>Cajas ilimitadas</li>
                    <li>Multi-sucursal</li>
                    <li>Boletas y Facturas SII</li>
                    <li>Reportes avanzados</li>
                    <li>API de integración</li>
                    <li>Soporte dedicado 24/7</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-apple" style="background:transparent;color:var(--apple-blue);border:1px solid var(--apple-blue);display:block;text-align:center">Contratar</a>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <h2 class="section-title reveal">+400 Pymes confían en CajaYa</h2>
        <div class="t-grid">
            <div class="t-card reveal"><p>"El cierre de caja pasó de ser una pesadilla a un clic. La boleta electrónica vuela."</p><span class="t-author">Roberto M. — Minimarket</span></div>
            <div class="t-card reveal"><p>"Dejé de pagar cuotas mensuales para siempre. El Plan Lifetime es la mejor inversión."</p><span class="t-author">Sandra P. — Bazar</span></div>
            <div class="t-card reveal"><p>"Si se corta el internet, seguimos vendiendo. El modo offline es realmente robusto."</p><span class="t-author">Carlos V. — Ferretería</span></div>
        </div>
    </section>

    <section class="faq" id="faq">
        <h2 class="section-title reveal">Preguntas Frecuentes</h2>
        <div class="faq-box">
            <div class="faq-item reveal"><h4>¿Cómo recibo mi licencia?</h4><p>Tras el pago con Mercado Pago, recibirás un correo instantáneo con tus credenciales y el link de descarga de la app.</p></div>
            <div class="faq-item reveal"><h4>¿Realmente funciona sin internet?</h4><p>Sí. CajaYa usa una base de datos local. Cuando vuelve la conexión, sincroniza automáticamente con el SII.</p></div>
            <div class="faq-item reveal"><h4>¿Sirve con mi impresora térmica?</h4><p>Compatible con impresoras térmicas de 58mm y 80mm de las marcas más populares en el mercado chileno.</p></div>
            <div class="faq-item reveal"><h4>¿Puedo tener más de una caja?</h4><p>Sí. El Plan Lifetime incluye 3 cajas y el Plan Empresa permite cajas ilimitadas con sincronización en tiempo real.</p></div>
            <div class="faq-item reveal"><h4>¿Qué pasa si tengo problemas?</h4><p>Tenemos soporte por WhatsApp disponible en horario comercial. El Plan Empresa incluye soporte 24/7.</p></div>
            <div class="faq-item reveal"><h4>¿Emite facturas además de boletas?</h4><p>Sí. CajaYa emite Boletas Electrónicas (Tipo 39) y Facturas Electrónicas (Tipo 33), ambas certificadas SII 2026.</p></div>
        </div>
    </section>

    <footer>
        <p style="margin-bottom:10px; font-size:16px; color:#F5F5F7; font-weight:600">CajaYa &copy; 2026 — Hecho en Chile 🇨🇱</p>
        <p><a href="#planes">Planes</a> <a href="#faq">FAQ</a> <a href="https://wa.me/56912345678">WhatsApp</a> <a href="/mercadopago/checkout.php">Comprar</a></p>
    </footer>

    <script>
        // Math symbols background animation
        const symbols = ['+', '-', '%', '$', '=', '×', '÷'];
        const container = document.getElementById('mathBg');
        for (let i = 0; i < 30; i++) {
            const span = document.createElement('span');
            span.className = 'symbol';
            span.innerText = symbols[Math.floor(Math.random() * symbols.length)];
            span.style.left = Math.random() * 100 + 'vw';
            span.style.animationDuration = (Math.random() * 15 + 12) + 's';
            span.style.animationDelay = (Math.random() * 25) + 's';
            span.style.fontSize = (Math.random() * 18 + 14) + 'px';
            span.style.opacity = (Math.random() * 0.5 + 0.3);
            container.appendChild(span);
        }

        // iOS-style Scroll Reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, i * 80);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // ---- CAROUSEL ----
        let cCur = 0;
        const cSlides = document.querySelectorAll('.c-slide');
        const cDots   = document.querySelectorAll('.c-dot');
        const cTotal  = cSlides.length;

        function cGo(n) {
            cSlides[cCur].classList.remove('active');
            cDots[cCur].classList.remove('on');
            cCur = (n + cTotal) % cTotal;
            cSlides[cCur].classList.add('active');
            cDots[cCur].classList.add('on');
        }
        function cMove(dir) { cGo(cCur + dir); }

        // Autoplay 5s — pausa al hacer hover
        let cTimer = setInterval(() => cMove(1), 5000);
        const cWrap = document.querySelector('.hero-wrap');
        cWrap.addEventListener('mouseenter', () => clearInterval(cTimer));
        cWrap.addEventListener('mouseleave', () => { cTimer = setInterval(() => cMove(1), 5000); });

        // Swipe touch
        let cTouchX = 0;
        cWrap.addEventListener('touchstart', e => { cTouchX = e.touches[0].clientX; });
        cWrap.addEventListener('touchend',   e => {
            const diff = cTouchX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 50) cMove(diff > 0 ? 1 : -1);
        });
    </script>
</body>
</html>
