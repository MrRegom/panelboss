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

        /* --- PROMO BANNER ELEGANTE --- */
        .promo-banner {
            background: linear-gradient(90deg, #7c3aed, #db2777, #7c3aed);
            background-size: 200% auto;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            position: sticky;
            top: 0;
            z-index: 1100;
            animation: shimmer 4s linear infinite, pulse-soft 3s ease-in-out infinite;
        }

        @keyframes pulse-soft {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.01); } /* Pulso más suave */
        }

        @keyframes shimmer {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }

        /* --- HEADER --- */
        header {
            padding: 25px 0;
            position: sticky;
            top: 40px;
            z-index: 1000;
            background: rgba(10, 9, 16, 0.95);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border);
        }
        .nav-wrapper { display: flex; justify-content: space-between; align-items: center; }
        
        /* --- LOGO DUAL CON IMAGEN ORIGINAL (MANTENIENDO LÍNEAS) --- */
        .logo-container {
            position: relative;
            height: 45px;
            width: 140px; /* Ajustar según el ancho real del logo */
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
            filter: brightness(0) invert(1); /* Capa blanca */
            clip-path: inset(0 42% 0 0); /* Recorta para mostrar solo "Caja" */
            z-index: 2;
        }
        .logo-container:hover .logo-base, 
        .logo-container:hover .logo-overlay { 
            transform: scale(1.05); 
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .nav-menu { display: flex; gap: 20px; align-items: center; }
        .nav-separator { color: rgba(255,255,255,0.2); font-weight: 300; }
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
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .btn-neon:hover { transform: translateY(-2px); box-shadow: 0 0 35px rgba(168, 85, 247, 0.6); }

        .btn-green {
            background: #25d366;
            color: #fff;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 0 25px rgba(37, 211, 102, 0.3);
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .btn-green:hover { transform: translateY(-2px); box-shadow: 0 0 35px rgba(37, 211, 102, 0.5); color: #fff; }

        /* --- HERO SPLIT --- */
        .hero { padding: 80px 0; }
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
        }

        .hero-title { font-size: 4.5rem; font-weight: 900; line-height: 1.1; margin-bottom: 30px; letter-spacing: -2px; }
        .text-gradient { background: linear-gradient(135deg, #fff 0%, var(--accent) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-desc { font-size: 1.2rem; color: var(--text-muted); margin-bottom: 45px; max-width: 550px; }

        .hero-visual { position: relative; }
        .organic-shape {
            background: radial-gradient(circle, rgba(168, 85, 247, 0.15) 0%, transparent 70%);
            display: flex; justify-content: center; align-items: center;
        }
        .mockup-img { max-width: 120%; border-radius: 12px; filter: drop-shadow(0 30px 60px rgba(0,0,0,0.8)); }

        /* --- PRICING SECTION --- */
        .pricing { padding: 100px 0; background: #08080c; }
        .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; margin-top: 60px; }
        
        .price-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            padding: 50px 40px;
            border-radius: 24px;
            position: relative;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }
        .price-card.featured { border-color: var(--accent); box-shadow: 0 0 40px rgba(168, 85, 247, 0.15); }
        .price-card.featured::after {
            content: 'RECOMENDADO';
            position: absolute;
            top: 20px; right: 20px;
            background: var(--accent);
            color: #fff;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 800;
        }

        .price-card h3 { font-size: 1.8rem; margin-bottom: 10px; }
        .price-tag { font-size: 3rem; font-weight: 900; margin: 25px 0; }
        .price-tag span { font-size: 1rem; color: var(--text-muted); font-weight: 400; }
        
        .price-features { list-style: none; margin-bottom: 40px; flex-grow: 1; }
        .price-features li { margin-bottom: 15px; display: flex; align-items: center; gap: 10px; font-size: 0.95rem; }
        .price-features i { color: #22c55e; }

        .btn-mp {
            background: #009ee3; /* MercadoPago Blue */
            color: #fff;
            text-align: center;
            padding: 15px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: 0.3s;
        }
        .btn-mp:hover { filter: brightness(1.1); transform: scale(1.02); }

        /* --- RESPONSIVE --- */
        @media (max-width: 992px) {
            .hero-grid { grid-template-columns: 1fr; text-align: center; }
            .hero-title { font-size: 3.2rem; }
            .hero-desc { margin: 0 auto 40px; }
            header { top: 35px; }
        }

        @media (max-width: 480px) {
            .hero-title { font-size: 2.6rem; }
            .nav-menu { display: none; }
            .btn-neon { padding: 10px 20px; font-size: 0.85rem; }
        }
    </style>
</head>
<body>

    <div class="promo-banner">
        🔥 OFERTA DE LANZAMIENTO: 1 Mes Gratis + Instalación Prioritaria (Solo 5 cupos disponibles esta semana)
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
                <a href="#que-ofrecemos" class="nav-link">¿Qué ofrecemos?</a>
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
                    <div class="hero-badge"><i class="fa-solid fa-bolt"></i> SII CERTIFICADO 2026</div>
                    <h1 class="hero-title">
                        Vende más, <br> <span class="text-gradient">controla todo.</span>
                    </h1>
                    <p class="hero-desc">
                        El sistema POS que automatiza tus ventas, gestiona tu stock y genera reportes X/Z en segundos. Diseñado para la velocidad de tu negocio.
                    </p>
                    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                        <a href="#precios" class="btn-neon" style="padding: 16px 45px; font-size: 1.1rem;">Ver Planes <i class="fa-solid fa-chevron-down"></i></a>
                        <a href="https://wa.me/56959764771" class="btn-green" style="padding: 16px 40px; font-size: 1.1rem;">Soporte en línea <i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="organic-shape">
                        <img src="assets/cajaya_hardware_mockup.png" alt="Hardware CajaYa" class="mockup-img">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION PRECIOS -->
    <section id="precios" class="pricing">
        <div class="container">
            <div style="text-align: center;">
                <h2 style="font-size: 3.5rem; letter-spacing: -1px;">Planes que crecen contigo</h2>
                <p style="color: var(--text-muted); margin-top: 15px;">Transparente, simple y sin letras chicas.</p>
            </div>

            <div class="pricing-grid">
                <!-- Básico -->
                <div class="price-card">
                    <h3>Plan Básico</h3>
                    <p style="color: var(--text-muted);">Ideal para emprendedores</p>
                    <div class="price-tag">$20.000 <span>/mes</span></div>
                    <ul class="price-features">
                        <li><i class="fa-solid fa-check"></i> Integración SII (Boletas)</li>
                        <li><i class="fa-solid fa-check"></i> Reportes X y Z Diarios</li>
                        <li><i class="fa-solid fa-check"></i> Gestión de Stock Base</li>
                        <li><i class="fa-solid fa-check"></i> Soporte por Email</li>
                    </ul>
                    <a href="#" class="btn-mp"><i class="fa-solid fa-credit-card"></i> Pagar con MercadoPago</a>
                </div>

                <!-- Premium -->
                <div class="price-card featured">
                    <h3>Plan Premium</h3>
                    <p style="color: var(--text-muted);">El estándar para negocios pro</p>
                    <div class="price-tag">$35.000 <span>/mes</span></div>
                    <ul class="price-features">
                        <li><i class="fa-solid fa-check"></i> Todo lo del Plan Básico</li>
                        <li><i class="fa-solid fa-check"></i> <strong>Respaldos Automáticos</strong></li>
                        <li><i class="fa-solid fa-check"></i> <strong>Soporte 24/7 VIP</strong></li>
                        <li><i class="fa-solid fa-check"></i> Multi-usuario</li>
                    </ul>
                    <a href="#" class="btn-mp" style="background: var(--accent);"><i class="fa-solid fa-credit-card"></i> Suscribirse Ahora</a>
                </div>

                <!-- Lifetime -->
                <div class="price-card">
                    <h3>Plan Lifetime</h3>
                    <p style="color: var(--text-muted);">Ahorro total de por vida</p>
                    <div class="price-tag">$180.000 <span>pago único</span></div>
                    <ul class="price-features">
                        <li><i class="fa-solid fa-check"></i> <strong>Licencia Perpetua</strong></li>
                        <li><i class="fa-solid fa-check"></i> Multi-caja Ilimitado</li>
                        <li><i class="fa-solid fa-check"></i> 3 Meses Soporte Full</li>
                        <li><i class="fa-solid fa-check"></i> Integración SII Incluida</li>
                    </ul>
                    <a href="#" class="btn-mp"><i class="fa-solid fa-bag-shopping"></i> Comprar Licencia</a>
                </div>
            </div>
        </div>
    </section>

    <!-- BENEFICIOS SECTION -->
    <section id="beneficios" style="padding: 100px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px;">
                <div style="background: rgba(255,255,255,0.02); padding: 30px; border-radius: 20px; border: 1px solid var(--border);">
                    <i class="fa-solid fa-file-invoice-dollar" style="font-size: 2rem; color: var(--accent); margin-bottom: 20px; display: block;"></i>
                    <h4 style="font-size: 1.5rem; margin-bottom: 10px;">Reportes X y Z</h4>
                    <p style="color: var(--text-muted);">Cumple con la normativa tributaria chilena. Genera tus cierres de caja profesionales en un clic.</p>
                </div>
                <div style="background: rgba(255,255,255,0.02); padding: 30px; border-radius: 20px; border: 1px solid var(--border);">
                    <i class="fa-solid fa-wifi-slash" style="font-size: 2rem; color: var(--accent); margin-bottom: 20px; display: block;"></i>
                    <h4 style="font-size: 1.5rem; margin-bottom: 10px;">100% Offline-Ready</h4>
                    <p style="color: var(--text-muted);">¿Se fue el internet? No detengas tus ventas. El sistema sincroniza todo cuando vuelve la conexión.</p>
                </div>
                <div style="background: rgba(255,255,255,0.02); padding: 30px; border-radius: 20px; border: 1px solid var(--border);">
                    <i class="fa-solid fa-shield-halved" style="font-size: 2rem; color: var(--accent); margin-bottom: 20px; display: block;"></i>
                    <h4 style="font-size: 1.5rem; margin-bottom: 10px;">Seguridad Bancaria</h4>
                    <p style="color: var(--text-muted);">Tus datos están encriptados y respaldados en la nube. Tu información es solo tuya.</p>
                </div>
            </div>
        </div>
    </section>

    <footer style="padding: 80px 0; border-top: 1px solid var(--border); text-align: center;">
        <div class="container">
            <img src="assets/img/logo.png" alt="CajaYa" style="height: 35px; opacity: 0.6; margin-bottom: 30px;">
            <p style="color: var(--text-muted); font-size: 0.9rem;">© 2026 CajaYa Chile. El sistema POS que tu Pyme merece.</p>
        </div>
    </footer>

</body>
</html>
