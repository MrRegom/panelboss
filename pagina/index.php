<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajaYa - El Sistema POS Líder para Pymes en Chile | SII 2026</title>
    
    <!-- SEO & Meta Tags -->
    <meta name="description" content="Controla tu inventario con el sistema líder para Pymes en Chile. Emite boletas, facturas electrónicas y reportes X/Z. 100% offline. Certificado SII 2026.">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Outfit:wght@500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #7c3aed;
            --accent: #a855f7;
            --bg-deep: #0a0910;
            --bg-card: #0f0e1a;
            --text-main: #f8fafc;
            --text-muted: #8b8a9e;
            --border: rgba(168, 85, 247, 0.15);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            background-color: var(--bg-deep);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
            position: relative;
        }

        /* --- EFECTO SALES UNIVERSE (SÍMBOLOS FLOTANTES) --- */
        .sales-universe {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
            opacity: 0.4;
        }
        .symbol {
            position: absolute;
            color: var(--accent);
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            opacity: 0.1;
            animation: float-random 20s linear infinite;
        }

        @keyframes float-random {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.2; }
            90% { opacity: 0.2; }
            100% { transform: translateY(-10vh) rotate(360deg); opacity: 0; }
        }

        /* --- PROMO BANNER --- */
        .promo-banner {
            background: linear-gradient(90deg, #7c3aed, #db2777, #7c3aed);
            background-size: 200% auto;
            color: #fff;
            text-align: center;
            padding: 8px 10px;
            font-size: 0.85rem;
            font-weight: 800;
            position: sticky;
            top: 0;
            z-index: 1100;
            animation: shimmer 4s linear infinite;
        }

        @keyframes shimmer {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }

        /* --- HEADER --- */
        header {
            padding: 15px 0;
            position: sticky;
            top: 36px;
            z-index: 1000;
            background: rgba(10, 9, 16, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
        }
        .nav-wrapper { display: flex; justify-content: space-between; align-items: center; }
        
        .logo-container {
            position: relative;
            height: 40px;
            width: 130px;
            overflow: hidden;
        }
        .logo-base, .logo-overlay {
            position: absolute;
            top: 0; left: 0;
            height: 100%;
            width: 100%;
            background-image: url('assets/img/logo.png');
            background-size: contain;
            background-repeat: no-repeat;
        }
        .logo-overlay {
            filter: brightness(0) invert(1);
            clip-path: inset(0 57% 0 0);
            z-index: 2;
        }
        
        .nav-menu { display: flex; gap: 15px; align-items: center; }
        .nav-link { color: var(--text-muted); text-decoration: none; font-weight: 500; font-size: 0.9rem; transition: 0.3s; }
        .nav-link:hover { color: var(--accent); }

        .btn-neon {
            background: var(--accent);
            color: #fff;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 0 15px rgba(168, 85, 247, 0.3);
            transition: 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .btn-green {
            background: #25d366;
            color: #fff;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 0 15px rgba(37, 211, 102, 0.2);
            transition: 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        /* --- HERO --- */
        .hero { padding: 80px 0; }
        .hero-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
        .hero-title { font-size: 3.8rem; font-weight: 900; line-height: 1.1; margin-bottom: 25px; letter-spacing: -1.5px; }
        .text-gradient { background: linear-gradient(135deg, #fff 0%, var(--accent) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-desc { font-size: 1.1rem; color: var(--text-muted); margin-bottom: 35px; max-width: 500px; }
        .mockup-img { max-width: 100%; border-radius: 12px; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.6)); }

        /* --- PRICING --- */
        .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .price-card { background: var(--bg-card); border: 1px solid var(--border); padding: 40px 30px; border-radius: 20px; display: flex; flex-direction: column; text-align: center; position: relative; }
        .price-card.featured { border-color: var(--accent); box-shadow: 0 0 30px rgba(168, 85, 247, 0.1); }
        .price-tag { font-size: 2.2rem; font-weight: 900; margin: 15px 0; }
        .price-tag span { font-size: 0.9rem; color: var(--text-muted); font-weight: 400; }
        .price-features { list-style: none; margin: 20px 0; text-align: left; flex-grow: 1; }
        .price-features li { margin-bottom: 10px; display: flex; align-items: center; gap: 10px; font-size: 0.85rem; }
        .price-features i { color: #22c55e; }
        
        .badge-recommended {
            position: absolute;
            top: -12px; left: 50%; transform: translateX(-50%);
            background: var(--accent); color: #fff; padding: 4px 15px; border-radius: 50px; font-size: 0.65rem; font-weight: 800;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 992px) {
            .hero-grid { grid-template-columns: 1fr; text-align: center; }
            .hero-title { font-size: 3rem; }
            .hero-desc { margin: 0 auto 30px; }
            .nav-menu { display: none; }
        }

        @media (max-width: 480px) {
            header { top: 32px; padding: 10px 0; }
            .logo-container { width: 95px; height: 30px; }
            header .btn-neon { padding: 6px 12px; font-size: 0.7rem; border-radius: 6px; }
            .hero-title { font-size: 2.2rem; }
            .hero-btns { display: flex; flex-direction: column; gap: 12px; }
            .hero-btns .btn-neon, .hero-btns .btn-green { width: 100%; justify-content: center; padding: 14px; }
        }
    </style>
</head>
<body>

    <!-- EFECTO SALES UNIVERSE -->
    <div class="sales-universe" id="universe"></div>

    <div class="promo-banner">
        Oferta: Mes Gratis + Instalacion(Solo 5 cupos)
    </div>

    <header>
        <div class="container nav-wrapper">
            <a href="#hero" class="logo-container">
                <div class="logo-base"></div>
                <div class="logo-overlay"></div>
            </a>
            <nav class="nav-menu">
                <a href="#que-ofrecemos" class="nav-link">Beneficios</a>
                <a href="#precios" class="nav-link">Precios</a>
                <a href="#faq" class="nav-link">Preguntas</a>
            </nav>
            <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-neon">Prueba Gratis</a>
        </div>
    </header>

    <section id="hero" class="hero">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <h1 class="hero-title">
                        Vende más, <br> <span class="text-gradient">controla todo.</span>
                    </h1>
                    <p class="hero-desc">
                        El sistema POS que automatiza tus ventas, gestiona tu stock y genera reportes X/Z en segundos.
                    </p>
                    <div class="hero-btns">
                        <a href="#precios" class="btn-neon">Ver Planes <i class="fa-solid fa-chevron-down"></i></a>
                        <a href="https://wa.me/56959764771" class="btn-green">Soporte en línea <i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="hero-visual">
                    <img src="assets/cajaya_hardware_mockup.png" alt="Hardware CajaYa" class="mockup-img">
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION QUE OFRECEMOS -->
    <section id="que-ofrecemos" style="padding: 80px 0; background: rgba(255,255,255,0.01);">
        <div class="container">
            <div style="text-align: center; margin-bottom: 50px;">
                <h2 style="font-size: 2.8rem;">¿Qué ofrecemos?</h2>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div style="background: var(--bg-card); padding: 25px; border-radius: 18px; border: 1px solid var(--border);">
                    <i class="fa-solid fa-file-invoice-dollar" style="color: var(--accent); margin-bottom: 15px; display: block;"></i>
                    <h4>Reportes X y Z</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">Cierres de caja bajo normativa SII.</p>
                </div>
                <div style="background: var(--bg-card); padding: 25px; border-radius: 18px; border: 1px solid var(--border);">
                    <i class="fa-solid fa-wifi-slash" style="color: var(--accent); margin-bottom: 15px; display: block;"></i>
                    <h4>Offline-Ready</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">Sigue vendiendo sin internet.</p>
                </div>
                <div style="background: var(--bg-card); padding: 25px; border-radius: 18px; border: 1px solid var(--border);">
                    <i class="fa-solid fa-shield-halved" style="color: var(--accent); margin-bottom: 15px; display: block;"></i>
                    <h4>Seguridad</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">Datos encriptados en la nube.</p>
                </div>
                <div style="background: var(--bg-card); padding: 25px; border-radius: 18px; border: 1px solid var(--border);">
                    <i class="fa-solid fa-users-gear" style="color: var(--accent); margin-bottom: 15px; display: block;"></i>
                    <h4>Multi-Caja</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">Gestiona múltiples puntos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION PRECIOS -->
    <section id="precios" style="padding: 80px 0; background: #08080c;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 50px;">
                <h2 style="font-size: 2.8rem;">Planes a tu Medida</h2>
            </div>
            <div class="pricing-grid">
                <div class="price-card">
                    <h3>Plan Básico</h3>
                    <div class="price-tag">$20.000 <span>/mes</span></div>
                    <ul class="price-features">
                        <li><i class="fa-solid fa-check"></i> Integración SII (Boletas)</li>
                        <li><i class="fa-solid fa-check"></i> Soporte Técnico</li>
                    </ul>
                    <a href="#" class="btn-neon" style="justify-content: center;">Suscribirse</a>
                </div>
                <div class="price-card featured">
                    <div class="badge-recommended">RECOMENDADO</div>
                    <h3>Plan Premium</h3>
                    <div class="price-tag">$35.000 <span>/mes</span></div>
                    <ul class="price-features">
                        <li><i class="fa-solid fa-check"></i> Integración SII</li>
                        <li><i class="fa-solid fa-check"></i> <strong>Soporte 24/7</strong></li>
                        <li><i class="fa-solid fa-check"></i> <strong>Respaldos Automáticos</strong></li>
                    </ul>
                    <a href="#" class="btn-neon" style="justify-content: center;">Suscribirse</a>
                </div>
                <div class="price-card">
                    <h3>Plan Lifetime</h3>
                    <div class="price-tag">$180.000 <span>pago único</span></div>
                    <ul class="price-features">
                        <li><i class="fa-solid fa-check"></i> <strong>Licencia de por vida</strong></li>
                        <li><i class="fa-solid fa-check"></i> Multi Caja Ilimitado</li>
                        <li><i class="fa-solid fa-check"></i> 3 Meses Soporte Full</li>
                        <li><i class="fa-solid fa-check"></i> Integración SII</li>
                    </ul>
                    <a href="#" class="btn-neon" style="justify-content: center;">Comprar Licencia</a>
                </div>
            </div>
        </div>
    </section>

    <footer style="padding: 40px 0; border-top: 1px solid var(--border); text-align: center;">
        <div class="container">
            <p style="color: var(--text-muted); font-size: 0.8rem;">© 2026 CajaYa Chile. POS Profesional.</p>
        </div>
    </footer>

    <script>
        // GENERADOR DE SALES UNIVERSE (Símbolos matemáticos)
        const universe = document.getElementById('universe');
        const symbols = ['$', '%', '+', '-', '×', '÷', '='];
        const symbolCount = 30;

        for (let i = 0; i < symbolCount; i++) {
            const span = document.createElement('span');
            span.className = 'symbol';
            span.innerText = symbols[Math.floor(Math.random() * symbols.length)];
            
            // Posición y animación aleatoria
            span.style.left = Math.random() * 100 + 'vw';
            span.style.fontSize = (Math.random() * 20 + 10) + 'px';
            span.style.animationDelay = (Math.random() * 20) + 's';
            span.style.animationDuration = (Math.random() * 10 + 15) + 's';
            
            universe.appendChild(span);
        }
    </script>

</body>
</html>
