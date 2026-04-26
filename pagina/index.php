<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajaYa - El Sistema POS Líder para Pymes en Chile</title>
    
    <!-- SEO & Meta Tags -->
    <meta name="description" content="Controla tu inventario con el sistema líder para Pymes. Emite boletas, facturas y gestiona tu stock 100% offline. Certificado SII 2026.">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Outfit:wght@500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #7c3aed; /* Violet 600 */
            --primary-light: #a78bfa;
            --accent: #a855f7; /* Morado claro (CajaYa Logo Style) */
            --bg-deep: #050506;
            --bg-card: #0f0f12;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: rgba(255, 255, 255, 0.08);
            --glass: rgba(15, 15, 18, 0.6);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--bg-deep);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1, h2, h3, .font-outfit { font-family: 'Outfit', sans-serif; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        /* --- TOP BAR --- */
        .top-bar {
            background: rgba(124, 58, 237, 0.1);
            border-bottom: 1px solid var(--border);
            padding: 8px 0;
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 500;
        }
        .top-bar-content { display: flex; justify-content: flex-end; gap: 25px; }
        .top-bar-content a { color: inherit; text-decoration: none; transition: color 0.3s; }
        .top-bar-content a:hover { color: #fff; }

        /* --- HEADER --- */
        header {
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            background: var(--glass);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }
        .nav-wrapper { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.8rem; font-weight: 900; color: #fff; display: flex; align-items: center; gap: 8px; text-decoration: none; }
        .logo span { color: var(--accent); }
        
        .nav-menu { display: flex; gap: 30px; }
        .nav-link { color: var(--text-muted); text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: all 0.3s; }
        .nav-link:hover { color: var(--accent); }

        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        .btn-primary { background: var(--accent); color: #fff; box-shadow: 0 4px 15px rgba(168, 85, 247, 0.3); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(168, 85, 247, 0.4); background: var(--primary-light); }
        
        .btn-outline { border: 1.5px solid var(--border); color: #fff; }
        .btn-outline:hover { background: rgba(255,255,255,0.05); border-color: #fff; }

        /* --- HERO SECTION (SPLIT) --- */
        .hero {
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -20%;
            left: -10%;
            width: 50%;
            height: 80%;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.15) 0%, transparent 70%);
            filter: blur(60px);
            z-index: -1;
        }

        .hero-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }

        .hero-content { z-index: 10; }
        .badge-sii {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(168, 85, 247, 0.1);
            border: 1px solid rgba(168, 85, 247, 0.2);
            padding: 6px 16px;
            border-radius: 100px;
            color: var(--accent);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 25px;
            animation: pulse-led 2s infinite;
        }

        @keyframes pulse-led {
            0% { box-shadow: 0 0 0 0 rgba(168, 85, 247, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(168, 85, 247, 0); }
            100% { box-shadow: 0 0 0 0 rgba(168, 85, 247, 0); }
        }

        .hero-title { font-size: 4rem; font-weight: 900; line-height: 1.1; margin-bottom: 25px; letter-spacing: -2px; }
        .hero-title span { background: linear-gradient(135deg, #fff 0%, var(--primary-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        
        .hero-desc { font-size: 1.15rem; color: var(--text-muted); margin-bottom: 40px; max-width: 500px; }
        .hero-btns { display: flex; gap: 20px; }

        /* --- MOCKUP CAROUSEL --- */
        .hero-visual { position: relative; }
        .organic-shape {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(15, 15, 18, 1) 100%);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            padding: 40px;
            border: 1px solid var(--border);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            aspect-ratio: 1;
        }
        
        .mockup-img {
            max-width: 110%;
            height: auto;
            border-radius: 12px;
            position: absolute;
            transition: all 1s ease-in-out;
            opacity: 0;
            transform: scale(0.95);
        }
        .mockup-img.active { opacity: 1; transform: scale(1); }

        /* Floating Info Cards */
        .floating-card {
            position: absolute;
            background: var(--glass);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            padding: 15px 20px;
            border-radius: 16px;
            z-index: 20;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
            animation: float 4s ease-in-out infinite;
        }
        .card-stats { top: 10%; left: -10%; }
        .card-users { bottom: 15%; right: -5%; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        /* --- CATEGORIES INFINITE BANNER --- */
        .categories-banner {
            padding: 40px 0;
            background: rgba(15, 15, 18, 0.5);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            overflow: hidden;
            white-space: nowrap;
            position: relative;
        }
        .categories-banner::before, .categories-banner::after {
            content: "";
            position: absolute;
            top: 0; width: 100px; height: 100%;
            z-index: 2;
        }
        .categories-banner::before { left: 0; background: linear-gradient(to right, var(--bg-deep), transparent); }
        .categories-banner::after { right: 0; background: linear-gradient(to left, var(--bg-deep), transparent); }

        .slider-track {
            display: flex;
            gap: 60px;
            animation: scroll 40s linear infinite;
            width: max-content;
        }
        .slider-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 600;
            transition: color 0.3s;
        }
        .slider-item i { color: var(--accent); font-size: 1.2rem; }
        .slider-item:hover { color: #fff; }

        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-50% - 30px)); }
        }

        /* --- RESPONSIVE ADJUSTMENTS --- */
        @media (max-width: 992px) {
            .hero-grid { grid-template-columns: 1fr; text-align: center; gap: 40px; }
            .hero-title { font-size: 3rem; }
            .hero-desc { margin: 0 auto 40px; }
            .hero-btns { justify-content: center; }
            .nav-menu { display: none; }
            .top-bar-content { justify-content: center; font-size: 0.7rem; }
            .card-stats { left: 0; top: 0; }
            .card-users { right: 0; bottom: 0; }
        }

        @media (max-width: 480px) {
            .hero-title { font-size: 2.4rem; }
            .hero-btns { flex-direction: column; width: 100%; }
            .btn { width: 100%; justify-content: center; }
            .badge-sii { margin-bottom: 15px; }
            .organic-shape { padding: 20px; }
            .slider-track { animation-duration: 25s; }
        }

        /* Footer */
        footer { padding: 80px 0 40px; border-top: 1px solid var(--border); }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 60px; }
        .footer-logo { margin-bottom: 20px; display: block; }
        .footer-links h5 { font-weight: 700; margin-bottom: 20px; color: #fff; }
        .footer-links ul { list-style: none; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a { color: var(--text-muted); text-decoration: none; font-size: 0.9rem; transition: color 0.3s; }
        .footer-links a:hover { color: var(--accent); }

        @media (max-width: 768px) {
            .footer-grid { grid-template-columns: 1fr; gap: 40px; text-align: center; }
        }

    </style>
</head>
<body>

    <div class="top-bar">
        <div class="container top-bar-content">
            <a href="tel:+56959764771"><i class="fa-solid fa-phone"></i> +56 9 5976 4771</a>
            <a href="#"><i class="fa-solid fa-circle-question"></i> Centro de ayuda</a>
            <a href="#"><i class="fa-solid fa-bullhorn"></i> ¡Recomiéndanos!</a>
        </div>
    </div>

    <header>
        <div class="container nav-wrapper">
            <a href="#" class="logo">Caja<span>YA</span></a>
            
            <nav class="nav-menu">
                <a href="#precios" class="nav-link">Precios</a>
                <a href="#recursos" class="nav-link">¿Qué ofrecemos?</a>
                <a href="#" class="nav-link">Recursos <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
            </nav>

            <div class="nav-actions">
                <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn btn-primary">Prueba Gratis</a>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <div class="badge-sii"><i class="fa-solid fa-shield-check"></i> SII CERTIFICADO 2026</div>
                    <h1 class="hero-title">
                        Controla tu inventario con el <span>Sistema Líder</span> para Pymes.
                    </h1>
                    <p class="hero-desc">
                        Emite boleta, factura electrónica y gestiona tu stock en tiempo real. La solución POS robusta, rápida y 100% offline-ready diseñada para Chile.
                    </p>
                    <div class="hero-btns">
                        <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn btn-primary">Contrata aquí <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="https://wa.me/56959764771" class="btn btn-outline"><i class="fa-solid fa-play"></i> Ver video</a>
                    </div>
                    <div style="margin-top: 30px; display: flex; gap: 20px; font-size: 0.8rem; color: var(--text-muted); font-weight: 600; justify-content: inherit;">
                        <span><i class="fa-solid fa-check text-success" style="color: #22c55e;"></i> Demo 30 días gratis</span>
                        <span><i class="fa-solid fa-check text-success" style="color: #22c55e;"></i> Sin tarjetas asociadas</span>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="floating-card card-stats">
                        <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Ventas Hoy</div>
                        <div style="font-size: 1.4rem; font-weight: 900; color: #fff;">$ 234.670</div>
                    </div>

                    <div class="floating-card card-users">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="background: var(--accent); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <div style="font-size: 0.6rem; color: var(--text-muted); font-weight: 700;">CLIENTES</div>
                                <div style="font-size: 1.1rem; font-weight: 900;">+ 12.000</div>
                            </div>
                        </div>
                    </div>

                    <div class="organic-shape">
                        <img src="assets/cajaya_pos_mockup.png" alt="POS CajaYa" class="mockup-img active">
                        <img src="assets/cajaya_dashboard_mockup.png" alt="Dashboard CajaYa" class="mockup-img">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CATEGORIES SLIDER -->
    <div class="categories-banner">
        <div class="slider-track">
            <!-- First set -->
            <div class="slider-item"><i class="fa-solid fa-utensils"></i> Restoranes</div>
            <div class="slider-item"><i class="fa-solid fa-wrench"></i> Ferreterías</div>
            <div class="slider-item"><i class="fa-solid fa-drumstick-bite"></i> Carnicerías</div>
            <div class="slider-item"><i class="fa-solid fa-box-open"></i> Bazares</div>
            <div class="slider-item"><i class="fa-solid fa-shop"></i> Almacenes</div>
            <div class="slider-item"><i class="fa-solid fa-wine-bottle"></i> Botillerías</div>
            <div class="slider-item"><i class="fa-solid fa-cart-shopping"></i> Minimarkets</div>
            <div class="slider-item"><i class="fa-solid fa-bread-slice"></i> Panaderías</div>
            <!-- Duplicate for infinite effect -->
            <div class="slider-item"><i class="fa-solid fa-utensils"></i> Restoranes</div>
            <div class="slider-item"><i class="fa-solid fa-wrench"></i> Ferreterías</div>
            <div class="slider-item"><i class="fa-solid fa-drumstick-bite"></i> Carnicerías</div>
            <div class="slider-item"><i class="fa-solid fa-box-open"></i> Bazares</div>
            <div class="slider-item"><i class="fa-solid fa-shop"></i> Almacenes</div>
            <div class="slider-item"><i class="fa-solid fa-wine-bottle"></i> Botillerías</div>
            <div class="slider-item"><i class="fa-solid fa-cart-shopping"></i> Minimarkets</div>
            <div class="slider-item"><i class="fa-solid fa-bread-slice"></i> Panaderías</div>
        </div>
    </div>

    <!-- CALL TO ACTION -->
    <section style="padding: 100px 0; text-align: center;">
        <div class="container">
            <h2 style="font-size: 3rem; margin-bottom: 20px;">¿Listo para escalar tu negocio?</h2>
            <p style="color: var(--text-muted); margin-bottom: 40px;">Únete a las miles de pymes que ya transformaron su gestión con CajaYa.</p>
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn btn-primary" style="padding: 18px 40px; font-size: 1.1rem;">Comenzar Demo Gratis</a>
                <a href="https://wa.me/56959764771" class="btn btn-outline" style="padding: 18px 40px; font-size: 1.1rem;">Hablar con un Experto</a>
            </div>
        </div>
    </section>

    <footer>
        <div class="container footer-grid">
            <div>
                <a href="#" class="footer-logo logo">Caja<span>YA</span></a>
                <p style="color: var(--text-muted); font-size: 0.9rem; max-width: 300px;">
                    La solución POS más completa de Chile. Potencia tu negocio con tecnología de vanguardia.
                </p>
            </div>

            <div class="footer-links">
                <h5>Empresa</h5>
                <ul>
                    <li><a href="#">Sobre nosotros</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h5>Contacto</h5>
                <ul>
                    <li><a href="tel:+56959764771"><i class="fa-solid fa-phone me-2"></i> +56 9 5976 4771</a></li>
                    <li><a href="mailto:soporte@cajaya.cl"><i class="fa-solid fa-envelope me-2"></i> soporte@cajaya.cl</a></li>
                    <li><a href="#"><i class="fa-solid fa-location-dot me-2"></i> Viña del Mar, Chile</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        // Simple Carousel Logic for Mockups
        const images = document.querySelectorAll('.mockup-img');
        let current = 0;

        setInterval(() => {
            images[current].classList.remove('active');
            current = (current + 1) % images.length;
            images[current].classList.add('active');
        }, 5000);
    </script>
</body>
</html>
