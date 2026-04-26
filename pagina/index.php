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
            padding: 8px 10px;
            font-size: 0.85rem;
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
            padding: 15px 0;
            position: sticky;
            top: 35px;
            z-index: 1000;
            background: rgba(10, 9, 16, 0.95);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border);
        }
        .nav-wrapper { display: flex; justify-content: space-between; align-items: center; }
        
        .logo-container {
            position: relative;
            height: 38px;
            width: 120px;
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
        .nav-separator { color: rgba(255,255,255,0.1); }
        .nav-link { color: var(--text-muted); text-decoration: none; font-weight: 500; font-size: 0.9rem; transition: 0.3s; }
        .nav-link:hover { color: var(--accent); }

        .btn-neon {
            background: var(--accent);
            color: #fff;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.9rem;
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.3);
            transition: 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-green {
            background: #25d366;
            color: #fff;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.9rem;
            box-shadow: 0 0 20px rgba(37, 211, 102, 0.2);
            transition: 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* --- FAQ --- */
        .faq-item { background: rgba(255,255,255,0.02); border: 1px solid var(--border); border-radius: 12px; margin-bottom: 12px; }
        .faq-question { padding: 15px 20px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: 600; }
        .faq-answer { padding: 0 20px; max-height: 0; overflow: hidden; transition: 0.4s; color: var(--text-muted); font-size: 0.9rem; }
        .faq-item.active .faq-answer { padding: 0 20px 20px; max-height: 200px; }

        /* --- HERO --- */
        .hero { padding: 60px 0; }
        .hero-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
        .hero-title { font-size: 4rem; font-weight: 900; line-height: 1.1; margin-bottom: 25px; letter-spacing: -2px; }
        .text-gradient { background: linear-gradient(135deg, #fff 0%, var(--accent) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-desc { font-size: 1.1rem; color: var(--text-muted); margin-bottom: 35px; max-width: 500px; }
        .mockup-img { max-width: 100%; border-radius: 12px; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.6)); }

        /* --- RESPONSIVE --- */
        @media (max-width: 992px) {
            .hero-grid { grid-template-columns: 1fr; text-align: center; }
            .hero-title { font-size: 3.2rem; }
            .hero-desc { margin: 0 auto 30px; }
            .nav-menu { display: none; }
        }

        @media (max-width: 480px) {
            .promo-banner { font-size: 0.75rem; padding: 10px 5px; }
            header { top: 38px; padding: 10px 0; }
            .logo-container { width: 100px; height: 32px; }
            .hero-title { font-size: 2.4rem; letter-spacing: -1px; }
            .hero-desc { font-size: 1rem; }
            .hero-btns .btn-neon, .hero-btns .btn-green { width: 100%; justify-content: center; padding: 14px; }
            .hero-btns { display: flex; flex-direction: column; gap: 15px; width: 100%; }
            header .btn-neon { padding: 8px 15px; font-size: 0.75rem; border-radius: 8px; }
        }
    </style>
</head>
<body>

    <div class="promo-banner">
        🔥 OFERTA: 1 Mes Gratis + Instalación Prioritaria (Solo 5 cupos)
    </div>

    <header>
        <div class="container nav-wrapper">
            <a href="#hero" class="logo-container">
                <div class="logo-base"></div>
                <div class="logo-overlay"></div>
            </a>
            <nav class="nav-menu">
                <a href="#beneficios" class="nav-link">Beneficios</a>
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

    <!-- BENEFICIOS -->
    <section id="beneficios" style="padding: 60px 0; background: rgba(255,255,255,0.01);">
        <div class="container">
            <div style="text-align: center; margin-bottom: 40px;">
                <h2 style="font-size: 2.5rem;">Lo que ofrecemos</h2>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px;">
                <div style="background: var(--bg-card); padding: 25px; border-radius: 15px; border: 1px solid var(--border);">
                    <i class="fa-solid fa-file-invoice-dollar" style="font-size: 1.5rem; color: var(--accent); margin-bottom: 15px; display: block;"></i>
                    <h4>Reportes X y Z</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Genera cierres de caja profesionales cumpliendo la normativa SII.</p>
                </div>
                <div style="background: var(--bg-card); padding: 25px; border-radius: 15px; border: 1px solid var(--border);">
                    <i class="fa-solid fa-wifi-slash" style="font-size: 1.5rem; color: var(--accent); margin-bottom: 15px; display: block;"></i>
                    <h4>Modo Offline</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Vende sin internet. El sistema sincroniza todo automáticamente.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PRECIOS -->
    <section id="precios" style="padding: 80px 0; background: #08080c;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 40px;">
                <h2 style="font-size: 2.8rem;">Planes de Lanzamiento</h2>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                <!-- Básico -->
                <div style="background: var(--bg-card); border: 1px solid var(--border); padding: 40px 30px; border-radius: 20px; text-align: center;">
                    <h3>Plan Básico</h3>
                    <div style="font-size: 2.5rem; font-weight: 800; margin: 20px 0;">$20.000 <span style="font-size: 1rem; color: var(--text-muted);">/mes</span></div>
                    <a href="#" class="btn-neon" style="width: 100%; justify-content: center;">Suscribirse</a>
                </div>
                <!-- Premium -->
                <div style="background: var(--bg-card); border: 1px solid var(--accent); padding: 40px 30px; border-radius: 20px; text-align: center; position: relative;">
                    <div style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: var(--accent); padding: 4px 15px; border-radius: 50px; font-size: 0.7rem; font-weight: 800;">RECOMENDADO</div>
                    <h3>Plan Premium</h3>
                    <div style="font-size: 2.5rem; font-weight: 800; margin: 20px 0;">$35.000 <span style="font-size: 1rem; color: var(--text-muted);">/mes</span></div>
                    <a href="#" class="btn-neon" style="width: 100%; justify-content: center;">Suscribirse</a>
                </div>
                <!-- Lifetime -->
                <div style="background: var(--bg-card); border: 1px solid var(--border); padding: 40px 30px; border-radius: 20px; text-align: center;">
                    <h3>Lifetime</h3>
                    <div style="font-size: 2.5rem; font-weight: 800; margin: 20px 0;">$180.000 <span style="font-size: 0.8rem; color: var(--text-muted);">pago único</span></div>
                    <a href="#" class="btn-neon" style="width: 100%; justify-content: center;">Comprar Licencia</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" style="padding: 60px 0;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 40px;">
                <h2 style="font-size: 2.5rem;">Preguntas</h2>
            </div>
            <div style="max-width: 700px; margin: 0 auto;">
                <div class="faq-item">
                    <div class="faq-question">¿Tienen integración con el SII? <i class="fa-solid fa-chevron-down"></i></div>
                    <div class="faq-answer">Sí, CajaYa está certificado para emitir boletas y facturas electrónicas cumpliendo con la normativa 2026.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">¿Funciona sin internet? <i class="fa-solid fa-chevron-down"></i></div>
                    <div class="faq-answer">¡Absolutamente! El sistema está diseñado para trabajar 100% offline y sincronizar cuando haya conexión.</div>
                </div>
            </div>
        </div>
    </section>

    <footer style="padding: 50px 0; border-top: 1px solid var(--border); text-align: center;">
        <div class="container">
            <p style="color: var(--text-muted); font-size: 0.85rem;">© 2026 CajaYa Chile. El sistema POS que tu Pyme merece.</p>
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
