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
            background-image: radial-gradient(circle at top right, rgba(168, 85, 247, 0.08) 0%, transparent 40%);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1, h2, h3 { font-family: 'Outfit', sans-serif; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        /* --- PROMO BANNER --- */
        .promo-banner {
            background: linear-gradient(90deg, #7c3aed, #db2777, #7c3aed);
            background-size: 200% auto;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            font-size: 0.9rem;
            font-weight: 800;
            position: sticky;
            top: 0;
            z-index: 1100;
            animation: shimmer 4s linear infinite, pulse-soft 3s ease-in-out infinite;
        }

        @keyframes pulse-soft {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.01); }
        }

        @keyframes shimmer {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }

        /* --- HEADER --- */
        header {
            padding: 20px 0;
            position: sticky;
            top: 40px;
            z-index: 1000;
            background: rgba(10, 9, 16, 0.95);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border);
        }
        .nav-wrapper { display: flex; justify-content: space-between; align-items: center; }
        
        .logo-container {
            position: relative;
            height: 45px;
            width: 140px;
            overflow: hidden;
            animation: fadeInDown 0.8s ease-out;
        }
        .logo-base, .logo-overlay {
            position: absolute;
            top: 0; left: 0;
            height: 100%;
            width: 100%;
            background-image: url('assets/img/logo.png');
            background-size: contain;
            background-repeat: no-repeat;
            transition: transform 0.3s ease;
        }
        .logo-overlay {
            filter: brightness(0) invert(1);
            clip-path: inset(0 57% 0 0);
            z-index: 2;
        }
        
        .nav-menu { display: flex; gap: 20px; align-items: center; }
        .nav-separator { color: rgba(255,255,255,0.1); }
        .nav-link { color: var(--text-muted); text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: 0.3s; }
        .nav-link:hover { color: var(--accent); }

        .btn-neon {
            background: var(--accent);
            color: #fff;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 0 25px rgba(168, 85, 247, 0.4);
            transition: 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-green {
            background: #25d366;
            color: #fff;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 0 25px rgba(37, 211, 102, 0.3);
            transition: 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        /* --- HERO --- */
        .hero { padding: 80px 0; }
        .hero-grid { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 60px; align-items: center; }
        .hero-title { font-size: 4.5rem; font-weight: 900; line-height: 1.1; margin-bottom: 30px; letter-spacing: -2px; }
        .text-gradient { background: linear-gradient(135deg, #fff 0%, var(--accent) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-desc { font-size: 1.2rem; color: var(--text-muted); margin-bottom: 45px; max-width: 550px; }
        .mockup-img { max-width: 120%; border-radius: 12px; filter: drop-shadow(0 30px 60px rgba(0,0,0,0.8)); }

        /* --- BENEFICIOS --- */
        .benefits-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; }
        .benefit-card { background: var(--bg-card); padding: 40px; border-radius: 24px; border: 1px solid var(--border); transition: 0.3s; }
        .benefit-card:hover { border-color: var(--accent); transform: translateY(-5px); }

        /* --- PRICING --- */
        .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; }
        .price-card { background: var(--bg-card); border: 1px solid var(--border); padding: 50px 40px; border-radius: 24px; display: flex; flex-direction: column; transition: 0.3s; }
        .price-card.featured { border-color: var(--accent); box-shadow: 0 0 40px rgba(168, 85, 247, 0.15); }
        .price-features { list-style: none; margin: 30px 0; flex-grow: 1; }
        .price-features li { margin-bottom: 12px; display: flex; align-items: center; gap: 10px; font-size: 0.95rem; }
        .price-features i { color: #22c55e; }

        /* --- FAQ --- */
        .faq-item { background: rgba(255,255,255,0.02); border: 1px solid var(--border); border-radius: 15px; margin-bottom: 15px; overflow: hidden; }
        .faq-question { padding: 20px 25px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: 600; }
        .faq-answer { padding: 0 25px; max-height: 0; overflow: hidden; transition: 0.4s; color: var(--text-muted); font-size: 0.95rem; }
        .faq-item.active .faq-answer { padding: 0 25px 25px; max-height: 200px; }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 992px) {
            .hero-grid { grid-template-columns: 1fr; text-align: center; }
            .hero-title { font-size: 3.2rem; }
            .hero-desc { margin: 0 auto 40px; }
            .nav-menu { display: none; }
        }

        @media (max-width: 480px) {
            header { top: 38px; padding: 10px 0; }
            .logo-container { width: 100px; height: 32px; }
            header .btn-neon { padding: 8px 12px; font-size: 0.7rem; border-radius: 8px; }
            .hero-title { font-size: 2.4rem; }
            .hero-btns { display: flex; flex-direction: column; gap: 15px; }
            .hero-btns .btn-neon, .hero-btns .btn-green { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

    <div class="promo-banner">
        🔥 OFERTA: 1 Mes Gratis + Instalación Prioritaria (Solo 5 cupos disponibles esta semana)
    </div>

    <header>
        <div class="container nav-wrapper">
            <a href="#hero" class="logo-container">
                <div class="logo-base"></div>
                <div class="logo-overlay"></div>
            </a>
            <nav class="nav-menu">
                <a href="#que-ofrecemos" class="nav-link">Beneficios</a>
                <span class="nav-separator">|</span>
                <a href="#precios" class="nav-link">Precios</a>
                <span class="nav-separator">|</span>
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
                        El sistema POS que automatiza tus ventas, gestiona tu stock y genera reportes X/Z en segundos. Diseñado para la velocidad de tu negocio.
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
    <section id="que-ofrecemos" style="padding: 100px 0; background: rgba(255,255,255,0.01);">
        <div class="container">
            <div style="text-align: center; margin-bottom: 60px;">
                <h2 style="font-size: 3.5rem;">¿Qué ofrecemos?</h2>
                <p style="color: var(--text-muted);">Tecnología de vanguardia para el crecimiento de tu empresa.</p>
            </div>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <i class="fa-solid fa-file-invoice-dollar" style="font-size: 2rem; color: var(--accent); margin-bottom: 20px; display: block;"></i>
                    <h4>Reportes X y Z</h4>
                    <p style="color: var(--text-muted);">Cumple con la normativa tributaria chilena. Genera tus cierres de caja profesionales en un clic.</p>
                </div>
                <div class="benefit-card">
                    <i class="fa-solid fa-wifi-slash" style="font-size: 2rem; color: var(--accent); margin-bottom: 20px; display: block;"></i>
                    <h4>100% Offline-Ready</h4>
                    <p style="color: var(--text-muted);">¿Se fue el internet? No detengas tus ventas. El sistema sincroniza todo cuando vuelve la conexión.</p>
                </div>
                <div class="benefit-card">
                    <i class="fa-solid fa-shield-halved" style="font-size: 2rem; color: var(--accent); margin-bottom: 20px; display: block;"></i>
                    <h4>Seguridad Bancaria</h4>
                    <p style="color: var(--text-muted);">Tus datos están encriptados y respaldados en la nube. Tu información es solo tuya y de nadie más.</p>
                </div>
                <div class="benefit-card">
                    <i class="fa-solid fa-users-gear" style="font-size: 2rem; color: var(--accent); margin-bottom: 20px; display: block;"></i>
                    <h4>Multi-Caja</h4>
                    <p style="color: var(--text-muted);">Gestiona múltiples puntos de venta en tiempo real desde un solo panel de administración centralizado.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION PRECIOS -->
    <section id="precios" style="padding: 100px 0; background: #08080c;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 60px;">
                <h2 style="font-size: 3.5rem;">Planes a tu Medida</h2>
            </div>
            <div class="pricing-grid">
                <!-- Básico -->
                <div class="price-card">
                    <h3>Plan Básico</h3>
                    <div style="font-size: 3rem; font-weight: 900; margin: 25px 0;">$20.000 <span>/mes</span></div>
                    <ul class="price-features">
                        <li><i class="fa-solid fa-check"></i> Integración SII (Boletas)</li>
                        <li><i class="fa-solid fa-check"></i> Soporte Técnico</li>
                    </ul>
                    <a href="#" class="btn-neon" style="justify-content: center;">Suscribirse Ahora</a>
                </div>
                <!-- Premium -->
                <div class="price-card featured">
                    <h3>Plan Premium</h3>
                    <div style="font-size: 3rem; font-weight: 900; margin: 25px 0;">$35.000 <span>/mes</span></div>
                    <ul class="price-features">
                        <li><i class="fa-solid fa-check"></i> Integración SII</li>
                        <li><i class="fa-solid fa-check"></i> <strong>Soporte 24/7</strong></li>
                        <li><i class="fa-solid fa-check"></i> <strong>Respaldos Automáticos</strong></li>
                    </ul>
                    <a href="#" class="btn-neon" style="justify-content: center; background: var(--accent);">Suscribirse Ahora</a>
                </div>
                <!-- Lifetime -->
                <div class="price-card">
                    <h3>Plan Lifetime</h3>
                    <div style="font-size: 3rem; font-weight: 900; margin: 25px 0;">$180.000 <span>pago único</span></div>
                    <ul class="price-features">
                        <li><i class="fa-solid fa-check"></i> <strong>Licencia de por vida</strong></li>
                        <li><i class="fa-solid fa-check"></i> <strong>Multi Caja Ilimitado</strong></li>
                        <li><i class="fa-solid fa-check"></i> 3 Meses de Soporte Full</li>
                        <li><i class="fa-solid fa-check"></i> Posibilidad de Integración SII</li>
                    </ul>
                    <a href="#" class="btn-neon" style="justify-content: center;">Comprar Licencia</a>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION FAQ -->
    <section id="faq" style="padding: 100px 0;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 60px;">
                <h2 style="font-size: 3rem;">Preguntas Frecuentes</h2>
            </div>
            <div style="max-width: 800px; margin: 0 auto;">
                <div class="faq-item">
                    <div class="faq-question">¿Tienen integración con el SII? <i class="fa-solid fa-chevron-down"></i></div>
                    <div class="faq-answer">Sí, CajaYa está certificado para emitir boletas y facturas electrónicas cumpliendo con la normativa vigente 2026.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">¿Funciona sin internet? <i class="fa-solid fa-chevron-down"></i></div>
                    <div class="faq-answer">¡Absolutamente! El sistema está diseñado para trabajar 100% offline y sincronizar todos los datos automáticamente cuando recuperes la conexión.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">¿Qué métodos de pago aceptan? <i class="fa-solid fa-chevron-down"></i></div>
                    <div class="faq-answer">Aceptamos todas las tarjetas de crédito, débito y transferencias a través de nuestra integración segura con MercadoPago.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">¿Cómo funciona el soporte técnico? <i class="fa-solid fa-chevron-down"></i></div>
                    <div class="faq-answer">Contamos con soporte técnico en línea prioritario. Dependiendo de tu plan (Básico o Premium), puedes acceder a atención personalizada 24/7.</div>
                </div>
            </div>
        </div>
    </section>

    <footer style="padding: 80px 0; border-top: 1px solid var(--border); text-align: center;">
        <div class="container">
            <p style="color: var(--text-muted); font-size: 0.9rem;">© 2026 CajaYa Chile. El sistema POS que tu Pyme merece.</p>
        </div>
    </footer>

    <script>
        document.querySelectorAll('.faq-question').forEach(item => {
            item.addEventListener('click', () => {
                const parent = item.parentElement;
                parent.classList.toggle('active');
            });
        });
    </script>

</body>
</html>
