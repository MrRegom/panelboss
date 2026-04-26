<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajaYa - El Sistema POS Líder para Pymes en Chile | SII 2026</title>
    
    <!-- SEO & Meta Tags -->
    <meta name="description" content="Controla tu inventario con el sistema líder para Pymes en Chile. Emite boletas, facturas y gestiona tu stock 100% offline. Certificado SII 2026.">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Outfit:wght@500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #7c3aed;
            --accent: #a855f7;
            --bg-deep: #0a0910; /* Deep Midnight Purple */
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

        /* --- HEADER ENTERPRISE --- */
        header {
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(5, 5, 6, 0.8);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border);
        }
        .nav-wrapper { display: flex; justify-content: space-between; align-items: center; }
        .nav-menu { display: flex; gap: 35px; }
        .nav-link { color: var(--text-muted); text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: all 0.3s; }
        .nav-link:hover { color: var(--accent); }

        .btn-neon {
            background: var(--accent);
            color: #fff;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 0 25px rgba(168, 85, 247, 0.4);
            transition: all 0.3s;
            border: none;
        }
        .btn-neon:hover { transform: translateY(-2px); box-shadow: 0 0 35px rgba(168, 85, 247, 0.6); }

        /* --- HERO SPLIT (RESTAURADO) --- */
        .hero { padding: 100px 0; position: relative; }
        .hero-grid { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 60px; align-items: center; }
        
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(168, 85, 247, 0.1);
            border: 1px solid rgba(168, 85, 247, 0.2);
            padding: 8px 18px;
            border-radius: 100px;
            color: var(--accent);
            font-size: 0.75rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .hero-title { font-size: 4.2rem; font-weight: 900; line-height: 1.1; margin-bottom: 30px; letter-spacing: -2px; }
        .hero-title span { background: linear-gradient(135deg, #fff 0%, var(--accent) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-desc { font-size: 1.2rem; color: var(--text-muted); margin-bottom: 45px; max-width: 550px; }

        /* MOCKUP CON EFECTO ORGÁNICO (DERECHA) */
        .hero-visual { position: relative; }
        .organic-shape {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(15, 15, 18, 1) 100%);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            padding: 40px;
            border: 1px solid var(--border);
            position: relative;
            aspect-ratio: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        .mockup-img {
            max-width: 120%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.5);
            transition: all 0.8s ease;
        }

        /* --- FEATURES SECTIONS --- */
        .features { padding: 100px 0; background: #08080a; }
        .feature-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            padding: 40px;
            border-radius: 24px;
            transition: all 0.3s;
        }
        .feature-card:hover { border-color: var(--accent); transform: translateY(-10px); }
        .feature-icon { font-size: 2.5rem; color: var(--accent); margin-bottom: 25px; }

        /* --- CATEGORIES SLIDER --- */
        .categories-banner {
            padding: 50px 0;
            background: rgba(15, 15, 18, 0.5);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            overflow: hidden;
        }
        .slider-track { display: flex; gap: 80px; animation: scroll 40s linear infinite; width: max-content; }
        .slider-item { color: var(--text-muted); font-weight: 600; display: flex; align-items: center; gap: 12px; }

        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-50% - 40px)); }
        }

        /* FAQ */
        #faq { padding: 120px 0; }
        .faq-item { background: var(--bg-card); border: 1px solid var(--border); border-radius: 15px; margin-bottom: 15px; cursor: pointer; }
        .faq-question { padding: 25px; font-weight: 700; display: flex; justify-content: space-between; align-items: center; }
        .faq-answer { max-height: 0; opacity: 0; overflow: hidden; transition: all 0.4s ease; padding: 0 25px; color: var(--text-muted); }
        .faq-item.active .faq-answer { max-height: 200px; opacity: 1; padding-bottom: 25px; }

        @media (max-width: 992px) {
            .hero-grid { grid-template-columns: 1fr; text-align: center; }
            .hero-title { font-size: 3rem; }
            .hero-desc { margin: 0 auto 40px; }
            .hero-visual { margin-top: 50px; }
        }
    </style>
</head>
<body>

    <header>
        <div class="container nav-wrapper">
            <a href="#hero" class="logo">
                <img src="assets/img/logo.png" alt="CajaYa" style="height: 40px;">
            </a>
            <nav class="nav-menu">
                <a href="#beneficios" class="nav-link">Beneficios</a>
                <a href="#que-ofrecemos" class="nav-link">¿Qué ofrecemos?</a>
                <a href="#faq" class="nav-link">Preguntas</a>
            </nav>
            <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-neon">Prueba Gratis</a>
        </div>
    </header>

    <section id="hero" class="hero">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <div class="hero-badge"><i class="fa-solid fa-shield-check"></i> SII CERTIFICADO 2026</div>
                    <h1 class="hero-title">
                        Controla tu negocio con el <span>Sistema POS Líder</span> en Chile.
                    </h1>
                    <p class="hero-desc">
                        Emite boletas, facturas electrónicas y gestiona tu stock en tiempo real. La solución robusta diseñada para la seriedad de tu empresa.
                    </p>
                    <div style="display: flex; gap: 20px;">
                        <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-neon" style="padding: 16px 45px; font-size: 1.1rem;">Contratar Ahora</a>
                        <a href="https://wa.me/56959764771" class="nav-link d-flex align-items-center" style="font-weight: 700;">Ver Demo en Vivo <i class="fa-solid fa-play ms-2"></i></a>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="organic-shape">
                        <img src="assets/cajaya_pos_mockup.png" alt="CajaYa POS" class="mockup-img">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="que-ofrecemos" class="categories-banner">
        <div class="slider-track">
            <div class="slider-item"><i class="fa-solid fa-utensils"></i> Restoranes</div>
            <div class="slider-item"><i class="fa-solid fa-wrench"></i> Ferreterías</div>
            <div class="slider-item"><i class="fa-solid fa-shop"></i> Almacenes</div>
            <div class="slider-item"><i class="fa-solid fa-cart-shopping"></i> Minimarkets</div>
            <!-- Duplicate -->
            <div class="slider-item"><i class="fa-solid fa-utensils"></i> Restoranes</div>
            <div class="slider-item"><i class="fa-solid fa-wrench"></i> Ferreterías</div>
            <div class="slider-item"><i class="fa-solid fa-shop"></i> Almacenes</div>
            <div class="slider-item"><i class="fa-solid fa-cart-shopping"></i> Minimarkets</div>
        </div>
    </div>

    <section id="beneficios" class="features">
        <div class="container">
            <div style="text-align: center; margin-bottom: 80px;">
                <h2 style="font-size: 3.5rem; letter-spacing: -1px;">Potencia Empresarial</h2>
                <p style="color: var(--text-muted);">Tecnología de vanguardia para el control total de tu operación.</p>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                <div class="feature-card">
                    <i class="fa-solid fa-cloud-arrow-up feature-icon"></i>
                    <h3>Sincronización SII</h3>
                    <p style="color: var(--text-muted); margin-top: 15px;">Emisión inmediata de documentos tributarios con certificación oficial 2026.</p>
                </div>
                <div class="feature-card">
                    <i class="fa-solid fa-signal-slash feature-icon"></i>
                    <h3>Modo Offline Real</h3>
                    <p style="color: var(--text-muted); margin-top: 15px;">Sigue vendiendo sin internet. Los datos se sincronizan automáticamente al volver la conexión.</p>
                </div>
                <div class="feature-card">
                    <i class="fa-solid fa-layer-group feature-icon"></i>
                    <h3>Multi-caja y Stock</h3>
                    <p style="color: var(--text-muted); margin-top: 15px;">Gestiona múltiples puntos de venta y controla tu inventario desde un solo lugar.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="faq">
        <div class="container" style="max-width: 800px;">
            <h2 style="font-size: 3rem; text-align: center; margin-bottom: 60px;">Preguntas Frecuentes</h2>
            <div class="faq-list">
                <div class="faq-item">
                    <div class="faq-question"><span>¿Qué es la licencia Lifetime?</span> <i class="fa-solid fa-chevron-down"></i></div>
                    <div class="faq-answer">Un pago único de por vida. Sin mensualidades ni suscripciones para las funciones principales.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question"><span>¿Tienen soporte en Chile?</span> <i class="fa-solid fa-chevron-down"></i></div>
                    <div class="faq-answer">Sí, contamos con un equipo especializado en Chile para soporte vía WhatsApp y remoto.</div>
                </div>
            </div>
        </div>
    </section>

    <footer style="padding: 80px 0; border-top: 1px solid var(--border); background: #050506;">
        <div class="container" style="text-align: center;">
            <img src="assets/img/logo.png" alt="CajaYa" style="height: 35px; opacity: 0.6; margin-bottom: 30px;">
            <div style="display: flex; gap: 30px; justify-content: center; margin-bottom: 30px;">
                <a href="#" class="nav-link">Términos</a>
                <a href="#" class="nav-link">Privacidad</a>
                <a href="tel:+56959764771" class="nav-link">+56 9 5976 4771</a>
            </div>
            <p style="color: var(--text-muted); font-size: 0.85rem;">© 2026 CajaYa Chile. La solución definitiva para Pymes.</p>
        </div>
    </footer>

    <script>
        // FAQ Accordion
        document.querySelectorAll('.faq-item').forEach(item => {
            item.addEventListener('click', () => {
                const isActive = item.classList.contains('active');
                document.querySelectorAll('.faq-item').forEach(el => el.classList.remove('active'));
                if (!isActive) item.classList.add('active');
            });
        });
    </script>
</body>
</html>
