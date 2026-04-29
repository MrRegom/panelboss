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

        /* BANNER DE ADVERTENCIA */
        .test-banner {
            background: #FF9F0A;
            color: #000;
            text-align: center;
            padding: 12px;
            font-weight: 700;
            position: sticky;
            top: 0;
            z-index: 9999;
            font-size: 13px;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
            position: sticky; width: 100%; top: 40px; z-index: 2000;
        }
        .nav-content { width: 1024px; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .logo-box { height: 30px; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-box img { height: 100%; }
        .logo-fallback { font-weight: 700; color: var(--apple-gray); font-size: 1.2rem; letter-spacing: -0.5px; }
        
        .reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.7s ease, transform 0.7s cubic-bezier(0.23,1,0.32,1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        .btn-apple {
            background: var(--apple-blue); color: white; padding: 12px 28px; border-radius: 980px;
            font-size: 17px; font-weight: 500; text-decoration: none; transition: var(--transition);
            display: inline-block;
        }
        .btn-apple:hover { transform: scale(1.05); background: #0077ED; box-shadow: 0 10px 20px rgba(0,113,227,0.2); }

        .section-title { font-size: 40px; font-weight: 700; text-align: center; margin-bottom: 60px; letter-spacing: -1px; }
        .features { padding: 100px 5%; background: var(--apple-silver); }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; max-width: 1100px; margin: 0 auto; }
        .card { background: #fff; padding: 40px; border-radius: 24px; transition: var(--transition); border: 1px solid transparent; }
        .card:hover { transform: translateY(-5px); border-color: var(--apple-blue); }
        .card h3 { font-size: 24px; margin-bottom: 15px; }
        .card p { color: var(--apple-muted); line-height: 1.6; }

        .pricing { padding: 100px 5%; background: #fff; }
        .price-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; max-width: 1100px; margin: 0 auto; }
        .p-card { padding: 50px 30px; border-radius: 32px; border: 1px solid var(--border); text-align: center; transition: 0.3s; }
        .p-card.featured { border: 2px solid var(--apple-blue); position: relative; transform: scale(1.05); }
        .p-price { font-size: 48px; font-weight: 700; margin: 20px 0; }
        .badge-rec { background: var(--apple-blue); color: #fff; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 980px; text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-bottom: 16px; }
        .p-features { list-style: none; text-align: left; margin: 20px 0; }
        .p-features li { padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05); font-size: 14px; color: var(--apple-muted); }
        .p-features li::before { content: '✓ '; color: var(--apple-blue); font-weight: 700; }

        .faq { padding: 100px 5%; background: var(--apple-silver); }
        .faq-box { max-width: 800px; margin: 0 auto; text-align: left; }
        .faq-item { background: #fff; margin-bottom: 15px; border-radius: 15px; padding: 25px; cursor: pointer; }
        .faq-item h4 { margin-bottom: 10px; color: var(--apple-blue); }

        footer { background: #1D1D1F; color: #86868B; text-align: center; padding: 40px 20px; font-size: 13px; }
        footer a { color: var(--apple-blue); text-decoration: none; margin: 0 10px; }

        /* HERO CAROUSEL */
        .hero-wrap { position: relative; overflow: hidden; padding-top: 50px; }
        .c-track { display: grid; width: 100%; }
        .c-slide {
            grid-column: 1; grid-row: 1;
            display: flex; align-items: center; min-height: 80vh;
            padding: 40px 6%; gap: 48px; opacity: 0; visibility: hidden;
            transform: scale(1.03); transition: all 0.7s cubic-bezier(.23,1,.32,1);
        }
        .c-slide.active { opacity: 1; visibility: visible; transform: scale(1); }
        .c-text { flex: 1; }
        .c-visual { flex: 1; display: flex; align-items: center; justify-content: center; position: relative; }
        .c-img { width: 100%; max-width: 500px; border-radius: 22px; box-shadow: 0 40px 80px rgba(0,0,0,0.13); }
        .c-h1 { font-size: clamp(2.2rem, 4.5vw, 4rem); font-weight: 800; letter-spacing: -0.03em; line-height: 1.08; color: #1D1D1F; margin-bottom: 18px; }
        .c-p { font-size: clamp(1rem, 1.6vw, 1.15rem); color: #515154; max-width: 440px; line-height: 1.65; margin-bottom: 30px; }
        
        .c-dots { display:flex; gap:8px; justify-content:center; padding:20px 0; }
        .c-dot { width:8px; height:8px; border-radius:50%; background:#D2D2D7; border:none; cursor:pointer; }
        .c-dot.on { background:var(--apple-blue); width:22px; border-radius:4px; }

        @media (max-width: 820px) {
            .c-slide { flex-direction: column; text-align: center; }
            .c-p { max-width: 100%; }
        }
    </style>
</head>
<body>

    <!-- BANNER DE ADVERTENCIA (Lo que pediste) -->
    <div class="test-banner">
        🚧 MODO PRUEBA ACTIVO: LAS COMPRAS ESTÁN DESACTIVADAS TEMPORALMENTE 🚧
    </div>

    <div class="math-bg" id="mathBg"></div>

    <nav>
        <div class="nav-content">
            <a href="/" class="logo-box">
                <span class="logo-fallback">CajaYa</span>
            </a>
            <div style="font-size: 12px; color: var(--apple-muted); font-weight: 600;">
                SII Certificado 2026 🇨🇱
            </div>
        </div>
    </nav>

    <section class="hero-wrap">
        <div class="c-track">
            <div class="c-slide active">
                <div class="c-text">
                    <h1 class="c-h1">Tu negocio vende m&aacute;s.<br><span style="color:var(--apple-blue)">T&uacute; trabajas menos.</span></h1>
                    <p class="c-p">El POS m&aacute;s r&aacute;pido de Chile. 100% Offline, Boletas Electr&oacute;nicas y cierre de caja autom&aacute;tico.</p>
                    <a href="#planes" class="btn-apple">Ver Beneficios</a>
                </div>
                <div class="c-visual">
                    <img src="assets/cajaya_pos_mockup.png" alt="CajaYa POS" class="c-img" onerror="this.src='https://via.placeholder.com/500x300?text=CajaYa+POS'">
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="beneficios">
        <h2 class="section-title reveal">Beneficios Exclusivos</h2>
        <div class="grid">
            <div class="card reveal"><h3>🧾 SII Certificado</h3><p>Emisión de boletas y facturas electrónicas al instante.</p></div>
            <div class="card reveal"><h3>📶 Modo Offline</h3><p>Sigue vendiendo aunque se corte el internet.</p></div>
            <div class="card reveal"><h3>⚡ Ultra Rápido</h3><p>Interfaz diseñada para cobrar en menos de 3 segundos.</p></div>
        </div>
    </section>

    <section class="pricing" id="planes">
        <h2 class="section-title reveal">Nuestros Planes</h2>
        <div class="price-grid">
            <div class="p-card featured reveal">
                <span class="badge-rec">⭐ Recomendado</span>
                <h3>Plan Lifetime</h3>
                <div class="p-price">$180.000</div>
                <p style="color:var(--apple-muted);margin-bottom:20px">Pago único para siempre.</p>
                <ul class="p-features">
                    <li>Ventas Ilimitadas</li>
                    <li>Soporte Prioritario</li>
                    <li>Actualizaciones de por vida</li>
                </ul>
                <button class="btn-apple" style="width:100%; opacity:0.6; cursor:not-allowed">No disponible por mantenimiento</button>
            </div>
        </div>
    </section>

    <footer>
        <p>CajaYa &copy; 2026 — Hecho con ❤️ en Chile 🇨🇱</p>
    </footer>

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Math symbols background
        const container = document.getElementById('mathBg');
        for (let i = 0; i < 20; i++) {
            const span = document.createElement('span');
            span.className = 'symbol';
            span.innerText = ['+', '%', '$', '='][Math.floor(Math.random() * 4)];
            span.style.left = Math.random() * 100 + 'vw';
            span.style.animationDuration = (Math.random() * 10 + 10) + 's';
            span.style.opacity = '0.1';
            container.appendChild(span);
        }
    </script>
</body>
</html>
