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

        html { scroll-behavior: smooth; max-width: 100%; overflow-x: hidden; }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--white);
            color: var(--apple-gray);
            font-family: 'Inter', -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* --- INTRO SCREEN --- */
        #intro-screen {
            position: fixed; inset: 0; background: #000; z-index: 9999;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            animation: introExit 0.7s cubic-bezier(0.77,0,0.18,1) 2.8s forwards;
        }
        #intro-screen.gone { display: none; }
        .intro-logo {
            font-size: clamp(2.5rem, 8vw, 5rem); font-weight: 800; color: #fff;
            letter-spacing: -2px; opacity: 0;
            animation: introLogoIn 0.8s cubic-bezier(0.23,1,0.32,1) 0.3s forwards;
        }
        .intro-logo span { color: #0071E3; }
        .intro-tag {
            font-size: clamp(0.9rem, 2vw, 1.1rem); color: #86868B; margin-top: 16px;
            opacity: 0; letter-spacing: 4px; text-transform: uppercase;
            animation: introTagIn 0.8s ease 1.1s forwards;
        }
        .intro-bar {
            width: 200px; height: 3px; background: #222; border-radius: 10px;
            margin-top: 50px; overflow: hidden; opacity: 0;
            animation: introTagIn 0.5s ease 1.4s forwards;
        }
        .intro-bar-fill {
            height: 100%; background: #0071E3; border-radius: 10px; width: 0%;
            animation: introBarFill 1.2s cubic-bezier(0.23,1,0.32,1) 1.6s forwards;
        }
        @keyframes introLogoIn {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes introTagIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes introBarFill { from { width: 0%; } to { width: 100%; } }
        @keyframes introExit {
            0%   { opacity: 1; transform: scale(1); }
            100% { opacity: 0; transform: scale(1.05); pointer-events: none; }
        }

        /* --- BACKGROUND ANIMATION (MATH SYMBOLS) --- */
        .math-bg {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: -1; opacity: 0.28;
        }
        .symbol {
            position: absolute; color: var(--apple-blue); font-weight: 800;
            animation: float 20s linear infinite;
        }
        @keyframes float {
            0%   { transform: translateY(110vh) rotate(0deg); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { transform: translateY(-10vh) rotate(360deg); opacity: 0; }
        }

        /* --- iMAC SCROLL ANIMATIONS --- */
        .reveal-left  { opacity: 0; transform: translateX(-60px) rotate(-2deg); transition: opacity 0.7s ease, transform 0.7s cubic-bezier(0.23,1,0.32,1); }
        .reveal-right { opacity: 0; transform: translateX(60px) rotate(2deg);  transition: opacity 0.7s ease, transform 0.7s cubic-bezier(0.23,1,0.32,1); }
        .reveal-up    { opacity: 0; transform: translateY(50px) scale(0.96);   transition: opacity 0.7s ease, transform 0.7s cubic-bezier(0.23,1,0.32,1); }
        .reveal-left.visible, .reveal-right.visible, .reveal-up.visible { opacity: 1; transform: none; }

        /* iMac floating window cards */
        .imac-window {
            background: #fff; border-radius: 16px; overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
            transition: transform 0.4s cubic-bezier(0.23,1,0.32,1), box-shadow 0.4s ease;
        }
        .imac-window:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 40px 80px rgba(0,0,0,0.12);
        }
        .imac-titlebar {
            background: #F5F5F7; padding: 10px 16px;
            display: flex; align-items: center; gap: 7px;
        }
        .dot { width: 12px; height: 12px; border-radius: 50%; }
        .dot-r { background: #FF5F57; }
        .dot-y { background: #FEBC2E; }
        .dot-g { background: #28C840; }

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

        /* --- CAROUSEL HERO (Bulletproof) --- */
        .carousel-hero {
            position: relative;
            width: 100%;
            overflow: hidden;   /* clave: clip aqui */
            background: var(--white);
        }
        .carousel-track {
            display: flex;
            will-change: transform;
            transition: transform 0.75s cubic-bezier(0.77, 0, 0.18, 1);
        }
        .carousel-slide {
            flex: 0 0 100vw;    /* exactamente el ancho del viewport */
            width: 100vw;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            text-align: center;
            padding: 110px 20px 70px;
            box-sizing: border-box;
            overflow: hidden;
        }
        .slide-badge {
            display: inline-block;
            background: rgba(0,113,227,0.08);
            color: var(--apple-blue);
            font-size: 11px; font-weight: 700;
            letter-spacing: 2px; text-transform: uppercase;
            padding: 6px 16px; border-radius: 980px;
            border: 1px solid rgba(0,113,227,0.15);
            margin-bottom: 20px;
        }
        .slide-h1 {
            font-size: clamp(1.8rem, 6vw, 4.5rem);
            font-weight: 800; letter-spacing: -0.03em;
            line-height: 1.1; margin-bottom: 16px;
            max-width: 800px;
        }
        .slide-p {
            font-size: clamp(0.95rem, 2vw, 1.2rem);
            color: var(--apple-muted);
            max-width: 600px; margin: 0 auto 32px;
            line-height: 1.6;
        }
        .slide-img {
            width: 100%; max-width: 820px;
            border-radius: 16px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.08);
            margin-top: 32px;
            display: block;
        }
        /* Dots */
        .carousel-dots {
            display: flex; gap: 8px;
            justify-content: center;
            padding: 20px 0;
        }
        .c-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #D2D2D7; transition: all 0.3s;
            cursor: pointer; border: none;
        }
        .c-dot.active { background: var(--apple-blue); width: 22px; border-radius: 4px; }
        /* Arrows */
        .c-arrow {
            position: absolute; top: 50%; transform: translateY(-50%);
            background: rgba(255,255,255,0.9);
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 50%; width: 44px; height: 44px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 20px; z-index: 10;
            transition: 0.2s; backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .c-arrow:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.12); }
        .c-prev { left: 16px; }
        .c-next { right: 16px; }
        /* Trust bar */
        .trust-bar { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; font-size: 13px; color: var(--apple-muted); margin-bottom: 8px; }

        /* ===== RESPONSIVE GLOBAL ===== */
        @media (max-width: 768px) {
            .slide-h1 { font-size: 1.8rem; }
            .slide-p { font-size: 0.95rem; }
            .carousel-slide { padding: 100px 16px 60px; }
            .c-arrow { display: none; }
            .p-card.featured { transform: scale(1); }
            .nav-links { display: none; }
            .nav-content { padding: 0 16px; }
            .section-title { font-size: 26px; margin-bottom: 30px; }
            .grid { grid-template-columns: 1fr; }
            .price-grid { grid-template-columns: 1fr; }
            .t-grid { grid-template-columns: 1fr; }
            .features, .pricing, .faq, .testimonials { padding: 60px 16px; }
            .p-card { padding: 28px 20px; }
            .imac-frame { padding: 10px; border-radius: 14px; }
            .btn-gmail { font-size: 14px; padding: 10px 16px; }
            .slide-img { border-radius: 12px; }
            .imac-window { border-radius: 14px; }
            footer { padding: 30px 16px; }
        }
    </style>
</head>
<body>

    <!-- INTRO SCREEN -->
    <div id="intro-screen">
        <img src="assets/img/logo.png" alt="CajaYa" style="height:60px;margin-bottom:20px;opacity:0;animation:introLogoIn 0.8s cubic-bezier(0.23,1,0.32,1) 0.3s forwards" onerror="this.style.display='none';document.getElementById('intro-txt').style.display='block'">
        <div id="intro-txt" class="intro-logo" style="display:none">Caja<span>Ya</span></div>
        <div class="intro-tag">El POS más rápido de Chile</div>
        <div class="intro-bar"><div class="intro-bar-fill"></div></div>
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

    <section class="carousel-hero" id="hero">
        <button class="c-arrow c-prev" onclick="moveSlide(-1)">&#8249;</button>
        <button class="c-arrow c-next" onclick="moveSlide(1)">&#8250;</button>

        <div class="carousel-track" id="ctrack">

            <!-- SLIDE 1 -->
            <div class="carousel-slide">
                <span class="slide-badge">&#10024; Nuevo 2026 &mdash; SII Certificado</span>
                <h1 class="slide-h1">Tu negocio vende m&aacute;s.<br><span style="color:var(--apple-blue)">T&uacute; trabajas menos.</span></h1>
                <p class="slide-p">El punto de venta m&aacute;s r&aacute;pido de Chile. 100% Offline, Boletas Electr&oacute;nicas y cierre de caja autom&aacute;tico.</p>
                <div style="display:flex;flex-wrap:wrap;gap:12px;justify-content:center;margin-bottom:16px">
                    <a href="/mercadopago/checkout.php" class="btn-apple">Comprar Ahora</a>
                    <a href="/api/auth/google" class="btn-gmail">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                        Prueba Gratis con Google
                    </a>
                </div>
                <div class="trust-bar"><span>&#10003; SII 2026</span><span>&#10003; +400 Pymes</span><span>&#10003; 30 D&iacute;as Garant&iacute;a</span></div>
                <img src="assets/cajaya_pos_mockup.png" alt="CajaYa POS" class="slide-img">
            </div>

            <!-- SLIDE 2 -->
            <div class="carousel-slide">
                <span class="slide-badge">&#128246; 100% Offline</span>
                <h1 class="slide-h1">&iquest;Se cay&oacute; el internet?<br><span style="color:var(--apple-blue)">CajaYa sigue vendiendo.</span></h1>
                <p class="slide-p">Tecnolog&iacute;a offline-first que garantiza que nunca pierdas una venta. Sincroniza con el SII autom&aacute;ticamente.</p>
                <a href="/mercadopago/checkout.php" class="btn-apple">Ver Planes desde $20.000/mes</a>
                <img src="assets/cajaya_pos_v2.png" alt="CajaYa Offline" class="slide-img">
            </div>

            <!-- SLIDE 3 -->
            <div class="carousel-slide">
                <span class="slide-badge">&#128424; Listo para tu hardware</span>
                <h1 class="slide-h1">Compatible con<br><span style="color:var(--apple-blue)">todo tu equipamiento.</span></h1>
                <p class="slide-p">Impresoras t&eacute;rmicas 58/80mm, gaveta autom&aacute;tica y lector de c&oacute;digo de barras. Plug &amp; Play.</p>
                <a href="/mercadopago/checkout.php" class="btn-apple">Empezar Ahora &rarr;</a>
                <img src="assets/cajaya_hardware_mockup.png" alt="CajaYa Hardware" class="slide-img">
            </div>
        </div>

        <div class="carousel-dots">
            <button class="c-dot active" onclick="goSlide(0)"></button>
            <button class="c-dot" onclick="goSlide(1)"></button>
            <button class="c-dot" onclick="goSlide(2)"></button>
        </div>
    </section>

    <section class="features" id="beneficios">
        <h2 class="section-title reveal-up">¿Por qué CajaYa es superior?</h2>
        <div class="grid">
            <div class="imac-window reveal-left"><div class="imac-titlebar"><div class="dot dot-r"></div><div class="dot dot-y"></div><div class="dot dot-g"></div></div><div style="padding:30px"><div style="font-size:32px;margin-bottom:12px">🧾</div><h3>Boletas SII Certificadas</h3><p style="color:var(--apple-muted);margin-top:10px;line-height:1.6">Emisión automática de Boletas y Facturas electrónicas. Certificado SII 2026 sin trámites extras.</p></div></div>
            <div class="imac-window reveal-up"><div class="imac-titlebar"><div class="dot dot-r"></div><div class="dot dot-y"></div><div class="dot dot-g"></div></div><div style="padding:30px"><div style="font-size:32px;margin-bottom:12px">📶</div><h3>100% Offline</h3><p style="color:var(--apple-muted);margin-top:10px;line-height:1.6">Si se corta internet, sigues vendiendo. CajaYa sincroniza automáticamente al restaurarse la conexión.</p></div></div>
            <div class="imac-window reveal-right"><div class="imac-titlebar"><div class="dot dot-r"></div><div class="dot dot-y"></div><div class="dot dot-g"></div></div><div style="padding:30px"><div style="font-size:32px;margin-bottom:12px">⚡</div><h3>Ventas Ultra-Rápidas</h3><p style="color:var(--apple-muted);margin-top:10px;line-height:1.6">Cobra en segundos con lector de código de barras, impresora térmica 58/80mm y gaveta automática.</p></div></div>
            <div class="imac-window reveal-right"><div class="imac-titlebar"><div class="dot dot-r"></div><div class="dot dot-y"></div><div class="dot dot-g"></div></div><div style="padding:30px"><div style="font-size:32px;margin-bottom:12px">📊</div><h3>Reportes en Tiempo Real</h3><p style="color:var(--apple-muted);margin-top:10px;line-height:1.6">Dashboard con ventas del día, semana y mes. Cierre de caja automático con desglose completo.</p></div></div>
            <div class="imac-window reveal-up"><div class="imac-titlebar"><div class="dot dot-r"></div><div class="dot dot-y"></div><div class="dot dot-g"></div></div><div style="padding:30px"><div style="font-size:32px;margin-bottom:12px">📦</div><h3>Control de Inventario</h3><p style="color:var(--apple-muted);margin-top:10px;line-height:1.6">Alertas automáticas de stock bajo. Gestiona miles de productos con código de barras o categorías.</p></div></div>
            <div class="imac-window reveal-left"><div class="imac-titlebar"><div class="dot dot-r"></div><div class="dot dot-y"></div><div class="dot dot-g"></div></div><div style="padding:30px"><div style="font-size:32px;margin-bottom:12px">🔒</div><h3>Multi-Usuario Seguro</h3><p style="color:var(--apple-muted);margin-top:10px;line-height:1.6">Roles de vendedor, supervisor y administrador. Cada empleado con su acceso y límites definidos.</p></div></div>
        </div>
        <div style="text-align:center; margin-top:60px" class="reveal-up">
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
                <a href="/mercadopago/checkout.php" class="btn-apple" style="background:transparent;color:var(--apple-blue);border:1px solid var(--apple-blue);display:block;text-align:center">Comenzar</a>
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
                <a href="/mercadopago/checkout.php" class="btn-apple" style="display:block;text-align:center">Comprar Ahora</a>
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
                <a href="/mercadopago/checkout.php" class="btn-apple" style="background:transparent;color:var(--apple-blue);border:1px solid var(--apple-blue);display:block;text-align:center">Contactar</a>
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

        // Ocultar intro y mostrar página
        const intro = document.getElementById('intro-screen');
        setTimeout(() => {
            intro.addEventListener('animationend', () => intro.classList.add('gone'));
        }, 2800);

        // iOS-style Scroll Reveal (todos los tipos)
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('visible'), i * 100);
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-up').forEach(el => revealObserver.observe(el));

        // --- CAROUSEL ---
        let current = 0;
        const total = 3;
        const track = document.getElementById('ctrack');
        const dots = document.querySelectorAll('.c-dot');

        function goSlide(n) {
            current = (n + total) % total;
            track.style.transform = `translateX(-${current * 100}%)`;
            dots.forEach((d, i) => d.classList.toggle('active', i === current));
        }
        function moveSlide(dir) { goSlide(current + dir); }

        // Autoplay cada 5 segundos
        let autoplay = setInterval(() => moveSlide(1), 5000);
        document.querySelector('.carousel-hero').addEventListener('mouseenter', () => clearInterval(autoplay));
        document.querySelector('.carousel-hero').addEventListener('mouseleave', () => { autoplay = setInterval(() => moveSlide(1), 5000); });

        // Swipe táctil para móvil
        let startX = 0;
        track.addEventListener('touchstart', e => startX = e.touches[0].clientX);
        track.addEventListener('touchend', e => {
            const diff = startX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 50) moveSlide(diff > 0 ? 1 : -1);
        });
    </script>
</body>
</html>
