<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajaYa - El Sistema POS que Cautiva a tus Clientes</title>
    
    <!-- SEO & Meta Tags -->
    <meta name="description" content="Controla tu inventario con el sistema líder para Pymes. Emite boletas, facturas y gestiona tu stock 100% offline. Certificado SII 2026.">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Outfit:wght@500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.min.css">
    
    <style>
        :root {
            --primary: #a855f7;
            --bg-deep: #000000;
            --bg-card: #0a0a0a;
            --text-main: #ffffff;
            --text-muted: #888888;
            --border: rgba(255, 255, 255, 0.05);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            background-color: var(--bg-deep);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .container { max-width: 1100px; margin: 0 auto; padding: 0 20px; }

        /* --- MODERN HEADER --- */
        header {
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }
        .nav-wrapper { display: flex; justify-content: space-between; align-items: center; }
        .nav-menu { display: flex; gap: 40px; }
        .nav-link { 
            color: var(--text-muted); 
            text-decoration: none; 
            font-weight: 500; 
            font-size: 0.9rem; 
            transition: color 0.3s ease; 
        }
        .nav-link:hover { color: #fff; }

        .btn-neon {
            background: var(--primary);
            color: #fff;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.4);
            animation: pulse-glow 2s infinite;
            border: none;
        }

        @keyframes pulse-glow {
            0% { box-shadow: 0 0 15px rgba(168, 85, 247, 0.4); }
            50% { box-shadow: 0 0 30px rgba(168, 85, 247, 0.6); }
            100% { box-shadow: 0 0 15px rgba(168, 85, 247, 0.4); }
        }

        /* --- HERO SECTION (CAUTIVADORA) --- */
        .hero {
            padding: 120px 0;
            text-align: center;
            background: radial-gradient(circle at center, rgba(168, 85, 247, 0.1) 0%, transparent 70%);
        }
        .hero-badge {
            display: inline-block;
            background: rgba(168, 85, 247, 0.1);
            color: var(--primary);
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-bottom: 30px;
            border: 1px solid rgba(168, 85, 247, 0.2);
        }
        .hero-title { 
            font-size: 5rem; 
            font-weight: 800; 
            line-height: 1; 
            margin-bottom: 30px; 
            letter-spacing: -3px; 
        }
        .text-gradient {
            background: linear-gradient(135deg, #fff 40%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-desc { 
            font-size: 1.2rem; 
            color: var(--text-muted); 
            margin: 0 auto 50px; 
            max-width: 600px; 
            line-height: 1.5;
        }

        /* --- CATEGORIES SLIDER --- */
        .categories-banner {
            padding: 40px 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            overflow: hidden;
            background: #050505;
        }
        .slider-track {
            display: flex;
            gap: 80px;
            animation: scroll 40s linear infinite;
            width: max-content;
        }
        .slider-item {
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .slider-item i { color: var(--primary); }

        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-50% - 40px)); }
        }

        /* --- FAQ (SIMPLE & CLEAN) --- */
        #faq { padding: 120px 0; }
        .faq-title { font-size: 3rem; font-weight: 800; text-align: center; margin-bottom: 80px; letter-spacing: -1px; }
        .faq-item {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .faq-item:hover { border-color: rgba(255,255,255,0.1); }
        .faq-question { padding: 24px; font-weight: 600; font-size: 1.1rem; display: flex; justify-content: space-between; align-items: center; }
        .faq-answer { max-height: 0; opacity: 0; overflow: hidden; transition: all 0.5s ease; padding: 0 24px; color: var(--text-muted); }
        .faq-item.active .faq-answer { max-height: 200px; opacity: 1; padding-bottom: 24px; }
        .faq-icon { transition: transform 0.3s; color: var(--text-muted); }
        .faq-item.active .faq-icon { transform: rotate(180deg); color: #fff; }

        /* --- CTA SECTION --- */
        #contacto { padding: 120px 0; text-align: center; }
        .cta-box {
            padding: 80px 40px;
            background: linear-gradient(135deg, #0a0a0a 0%, #111 100%);
            border: 1px solid var(--border);
            border-radius: 24px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title { font-size: 3rem; letter-spacing: -1px; }
            .nav-menu { display: none; }
        }
    </style>
</head>
<body>

    <header>
        <div class="container nav-wrapper">
            <a href="#hero" class="logo">
                <img src="assets/img/logo.png" alt="CajaYa" style="height: 35px;">
            </a>
            <nav class="nav-menu">
                <a href="#hero" class="nav-link">Inicio</a>
                <a href="#categorias" class="nav-link">¿Qué ofrecemos?</a>
                <a href="#faq" class="nav-link">Preguntas</a>
            </nav>
            <a href="#contacto" class="btn-neon">Empezar Ahora</a>
        </div>
    </header>

    <section id="hero" class="hero">
        <div class="container">
            <span class="hero-badge">SII CERTIFICADO 2026</span>
            <h1 class="hero-title">El POS que cautiva <br> <span class="text-gradient">a tu negocio.</span></h1>
            <p class="hero-desc">
                Sincronización en tiempo real, modo offline inteligente y una interfaz diseñada para ser prolija, moderna y elegante.
            </p>
            <div style="display: flex; gap: 20px; justify-content: center;">
                <a href="#contacto" class="btn-neon" style="padding: 15px 40px; font-size: 1.1rem;">Prueba Gratis</a>
                <a href="https://wa.me/56959764771" class="nav-link d-flex align-items-center" style="font-weight: 700;">Hablar con experto <i class="fa-solid fa-arrow-right ms-2"></i></a>
            </div>

            <div style="margin-top: 80px; position: relative;">
                <img src="assets/cajaya_pos_mockup.png" alt="CajaYa POS" style="max-width: 90%; border-radius: 12px; box-shadow: 0 50px 100px rgba(0,0,0,0.5);">
            </div>
        </div>
    </section>

    <div id="categorias" class="categories-banner">
        <div class="slider-track">
            <div class="slider-item"><i class="fa-solid fa-utensils"></i> Restoranes</div>
            <div class="slider-item"><i class="fa-solid fa-wrench"></i> Ferreterías</div>
            <div class="slider-item"><i class="fa-solid fa-shop"></i> Almacenes</div>
            <div class="slider-item"><i class="fa-solid fa-cart-shopping"></i> Minimarkets</div>
            <div class="slider-item"><i class="fa-solid fa-utensils"></i> Restoranes</div>
            <div class="slider-item"><i class="fa-solid fa-wrench"></i> Ferreterías</div>
            <div class="slider-item"><i class="fa-solid fa-shop"></i> Almacenes</div>
            <div class="slider-item"><i class="fa-solid fa-cart-shopping"></i> Minimarkets</div>
        </div>
    </div>

    <section id="faq">
        <div class="container">
            <h2 class="faq-title">Preguntas Frecuentes</h2>
            <div class="faq-list">
                <div class="faq-item">
                    <div class="faq-question"><span>¿Qué es la licencia Lifetime?</span> <i class="fa-solid fa-chevron-down faq-icon"></i></div>
                    <div class="faq-answer">Un pago único para siempre, sin suscripciones mensuales para las funciones core.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question"><span>¿Funciona sin internet?</span> <i class="fa-solid fa-chevron-down faq-icon"></i></div>
                    <div class="faq-answer">Sí, CajaYa está diseñado para operar 100% offline y sincronizar cuando detecte conexión.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question"><span>¿Tienen soporte técnico?</span> <i class="fa-solid fa-chevron-down faq-icon"></i></div>
                    <div class="faq-answer">Sí, contamos con soporte especializado en Chile vía WhatsApp y remoto.</div>
                </div>
            </div>
        </div>
    </section>

    <section id="contacto">
        <div class="container">
            <div class="cta-box">
                <h2 style="font-size: 3rem; margin-bottom: 20px;">¿Listo para el cambio?</h2>
                <p style="color: var(--text-muted); margin-bottom: 40px;">Únete a las miles de pymes que ya confían en CajaYa.</p>
                <a href="https://wa.me/56959764771" class="btn-neon" style="padding: 18px 50px; font-size: 1.2rem;">Contactar por WhatsApp</a>
            </div>
        </div>
    </section>

    <footer style="padding: 60px 0; border-top: 1px solid var(--border); text-align: center;">
        <div class="container">
            <img src="assets/img/logo.png" alt="CajaYa" style="height: 30px; opacity: 0.5; margin-bottom: 20px;">
            <p style="color: var(--text-muted); font-size: 0.8rem;">© 2026 CajaYa Chile. Todos los derechos reservados.</p>
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
