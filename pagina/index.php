<?php
/**
 * index.php — Landing Page CAJAYA ELITE FINAL V20 (ULTRA PREMIUM & AUTO-FLOW)
 */
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/Database.php';
require_once __DIR__ . '/../src/Repositories/PlanRepository.php';

use App\Repositories\PlanRepository;

$plans = [];
try {
    $planRepo = new PlanRepository();
    $plansRaw = $planRepo->getAll();
    foreach ($plansRaw as $p) { $plans[trim(strtolower($p['slug']))] = $p; }
} catch (\Exception $e) {
    error_log("CAJAYA: DB Fail, using static defaults. " . $e->getMessage());
}

$pMensual  = number_format($plans['mensual']['price']  ?? 20000, 0, ',', '.');
$pLifetime = number_format($plans['lifetime']['price'] ?? 180000, 0, ',', '.');
$pEmpresa  = number_format($plans['empresa']['price']  ?? 35000, 0, ',', '.');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>CajaYa Elite — El Futuro de tu Negocio</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;700;900&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6A37B7;
            --primary-dark: #4A268A;
            --primary-glow: #9D6CFF;
            --primary-soft: #F4F0FF;
            --text-dark: #1D1D1F;
            --text-light: #6E6E73;
            --bg-white: #FFFFFF;
            --bg-off: #FBFBFE;
            --transition-mac: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-font-smoothing: antialiased; scroll-behavior: smooth; }
        body { background: var(--bg-white); color: var(--text-dark); font-family: 'Inter', sans-serif; overflow-x: hidden; }

        #preloader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: #fff; display: flex; align-items: center; justify-content: center;
            z-index: 10000; transition: opacity 1.2s ease-out;
        }
        .pre-logo { width: 140px; animation: pulse 2s infinite ease-in-out; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.7; } 50% { transform: scale(1.1); opacity: 1; } }

        nav { 
            position: fixed; top: 0; width: 100%; height: 80px; z-index: 1000;
            display: flex; justify-content: space-between; align-items: center; padding: 0 5%;
            transition: var(--transition-mac);
        }
        nav.scrolled { background: rgba(255,255,255,0.85); backdrop-filter: blur(25px); height: 70px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); }
        .nav-logo img { height: 35px; }
        .nav-links a { color: var(--text-dark); text-decoration: none; font-weight: 600; font-size: 14px; margin-left: 30px; transition: 0.3s; }
        .nav-links a:hover { color: var(--primary); }
        .btn-wa { background: #25D366; color: #fff !important; padding: 10px 22px; border-radius: 50px; font-weight: 700; box-shadow: 0 10px 20px rgba(37,211,102,0.2); }

        /* HERO CAROUSEL */
        .hero-carousel { position: relative; height: 100vh; overflow: hidden; background: #000; }
        .carousel-track { display: flex; height: 100%; transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
        .slide { min-width: 100%; height: 100%; position: relative; display: flex; align-items: center; justify-content: center; padding: 0 8%; }
        
        .slide-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1; opacity: 0.7; }
        .slide-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0.6) 40%, transparent 100%); z-index: 2; }
        .slide-overlay.dark { background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(10,5,20,0.5) 100%); }

        .hero-content { position: relative; z-index: 10; max-width: 850px; text-align: left; }
        .hero-content h1 { font-family: 'Outfit', sans-serif; font-size: clamp(3rem, 8vw, 5.5rem); line-height: 0.9; font-weight: 900; margin-bottom: 30px; letter-spacing: -4px; color: var(--text-dark); }
        .hero-content h1 span { color: var(--primary); }
        .hero-content p { font-size: 1.5rem; color: var(--text-light); margin-bottom: 50px; max-width: 650px; border-left: 5px solid var(--primary); padding-left: 30px; }
        .btn-primary { background: var(--primary); color: #fff; padding: 24px 50px; border-radius: 20px; text-decoration: none; font-weight: 700; display: inline-block; transition: 0.3s; box-shadow: 0 20px 40px rgba(106,55,183,0.3); }
        .btn-primary:hover { transform: translateY(-5px); box-shadow: 0 30px 60px rgba(106,55,183,0.4); }

        /* PEARL FORM STYLE */
        .pearl-container { 
            background: rgba(255,255,255,0.1); backdrop-filter: blur(25px);
            padding: 60px 50px; border-radius: 50px; color: #fff;
            box-shadow: 0 40px 100px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.2); text-align: center;
            max-width: 600px; width: 100%;
        }
        .pearl-container h2 { font-family: 'Outfit', sans-serif; font-size: 3rem; margin-bottom: 15px; color: #fff; letter-spacing: -2px; }
        .pearl-container h2 span { color: var(--primary-glow); }
        .pearl-container p { color: rgba(255,255,255,0.7); font-size: 1.2rem; margin-bottom: 40px; }
        
        .lead-form { display: grid; grid-template-columns: 1fr; gap: 20px; width: 100%; }
        .input-group { position: relative; }
        .input-group i { position: absolute; left: 25px; top: 50%; transform: translateY(-50%); color: var(--primary-glow); font-size: 18px; }
        .lead-input { 
            width: 100%; padding: 22px 25px 22px 65px; border-radius: 22px; border: 1px solid rgba(255,255,255,0.15); 
            background: rgba(255,255,255,0.05); color: #fff; font-size: 16px; transition: 0.4s;
        }
        .lead-input::placeholder { color: rgba(255,255,255,0.4); }
        .lead-input:focus { outline: none; border-color: var(--primary-glow); background: rgba(255,255,255,0.1); box-shadow: 0 0 30px rgba(157,108,255,0.2); }
        .btn-submit { 
            background: var(--primary); color: #fff; border: none; padding: 24px; 
            border-radius: 22px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px;
            cursor: pointer; transition: 0.5s; box-shadow: 0 15px 40px rgba(106,55,183,0.4);
        }
        .btn-submit:hover { transform: scale(1.02); background: var(--primary-glow); box-shadow: 0 25px 50px rgba(106,55,183,0.6); }

        /* PRODUCT DESCRIPTION */
        .product-desc { background: #fff; padding: 120px 8%; text-align: center; }
        .section-header { text-align: center; margin-bottom: 80px; }
        .section-header h2 { font-family: 'Outfit', sans-serif; font-size: 4rem; letter-spacing: -2px; }
        .section-header h2 span { color: var(--primary); }
        .desc-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; margin-top: 60px; }
        .desc-item { padding: 50px 40px; border-radius: 40px; background: var(--bg-off); transition: 0.5s; border: 1px solid transparent; }
        .desc-item:hover { transform: translateY(-15px); border-color: var(--primary-soft); box-shadow: 0 30px 60px rgba(106,55,183,0.08); }
        .desc-item i { font-size: 50px; color: var(--primary); margin-bottom: 30px; }
        .desc-item h3 { margin-bottom: 15px; font-size: 1.8rem; font-weight: 800; }

        /* PLAN CARDS */
        .section-padding { padding: 150px 8%; background: var(--bg-off); }
        .p-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 40px; }
        .p-card { 
            background: #fff; padding: 80px 50px; border-radius: 45px; flex: 1; min-width: 350px; max-width: 450px;
            position: relative; box-shadow: 0 10px 40px rgba(0,0,0,0.02); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        }
        .p-card:hover { transform: translateY(-20px); box-shadow: 0 50px 100px rgba(106,55,183,0.12); }
        .p-card.featured { background: var(--primary); color: #fff; }
        .p-card.featured * { color: #fff; }
        .badge-sugerido { position: absolute; top: -18px; right: 40px; background: var(--primary-dark); color: #fff !important; padding: 12px 30px; border-radius: 50px; font-size: 12px; font-weight: 900; z-index: 100; text-transform: uppercase; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .p-card h3 { font-size: 14px; color: var(--primary); letter-spacing: 5px; text-transform: uppercase; margin-bottom: 30px; font-weight: 900; }
        .price { font-size: 4.5rem; font-weight: 900; letter-spacing: -3px; display: flex; align-items: baseline; justify-content: center; margin: 30px 0; }
        .price-sub { font-size: 1.3rem; opacity: 0.6; margin-left: 8px; }
        .p-features { list-style: none; margin-bottom: 50px; flex-grow: 1; text-align: left; }
        .p-features li { margin-bottom: 20px; font-size: 16px; color: var(--text-light); display: flex; align-items: center; }
        .p-features li i { color: var(--primary); margin-right: 15px; font-size: 18px; }
        .p-card.featured .p-features li i { color: var(--primary-glow); }
        .btn-plan { background: var(--primary-soft); color: var(--primary); text-decoration: none; padding: 25px; display: block; border-radius: 25px; text-align: center; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; transition: 0.3s; }
        .p-card.featured .btn-plan { background: #fff; color: var(--primary); }
        .btn-plan:hover { transform: scale(1.05); }

        /* FOOTER */
        footer { 
            padding: 150px 8% 60px; 
            background: linear-gradient(-45deg, var(--primary-dark), var(--primary), #5a2ea3, var(--primary-glow));
            background-size: 400% 400%; animation: footer-gradient 15s ease infinite;
            color: #fff; position: relative; overflow: hidden;
        }
        @keyframes footer-gradient { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        .footer-wave { position: absolute; top: 0; left: 0; width: 100%; line-height: 0; transform: rotate(180deg); }
        .footer-wave svg { position: relative; display: block; width: calc(150% + 1.3px); height: 80px; fill: #fff; }
        
        .f-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 60px; position: relative; z-index: 2; }
        .f-col img { height: 40px; margin-bottom: 30px; filter: brightness(0) invert(1); }
        .f-col p { opacity: 0.7; line-height: 1.8; font-size: 15px; }
        .f-col h5 { font-size: 14px; opacity: 0.5; margin-bottom: 30px; letter-spacing: 4px; text-transform: uppercase; }
        .f-col a { color: #fff; text-decoration: none; display: block; margin-bottom: 18px; opacity: 0.7; transition: 0.3s; font-size: 15px; }
        .f-col a:hover { opacity: 1; transform: translateX(10px); color: var(--primary-glow); }

        @media (max-width: 768px) {
            .hero-content h1 { font-size: 3.2rem; text-align: center; letter-spacing: -2px; }
            .hero-content p { border-left: none; border-top: 5px solid var(--primary); padding: 30px 0 0; text-align: center; font-size: 1.2rem; }
            .hero-btns { display: flex; flex-direction: column; gap: 15px; align-items: center; }
            .slide-overlay { background: rgba(255,255,255,0.92); }
            .f-grid { grid-template-columns: 1fr; text-align: center; gap: 50px; }
            .f-col { align-items: center; display: flex; flex-direction: column; }
            .pearl-container { padding: 40px 25px; border-radius: 35px; }
            .pearl-container h2 { font-size: 2.2rem; }
            .price { font-size: 3.5rem; }
        }
        .reveal { opacity: 0; transform: translateY(50px); transition: 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>

    <div id="preloader"><img src="assets/img/logo.png" class="pre-logo" alt="CajaYa"></div>

    <nav id="navbar">
        <a href="#" class="nav-logo"><img src="assets/img/logo.png" alt="CajaYa"></a>
        <div class="nav-links">
            <a href="#planes">Planes</a>
            <a href="https://wa.me/56900000000" target="_blank" class="btn-wa">Soporte WhatsApp</a>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-carousel">
            <div class="carousel-track" id="heroTrack">
                <!-- Slide 1: Welcome -->
                <div class="slide">
                    <img src="assets/img/banner_super.png" class="slide-bg">
                    <div class="slide-overlay"></div>
                    <div class="hero-content">
                        <h1 class="reveal">El Software para tu <span>Supermercado.</span></h1>
                        <p class="reveal">La plataforma Élite diseñada para minimizar tus tiempos de espera y maximizar tus ganancias en Minimarkets y Pymes.</p>
                        <div class="hero-btns reveal">
                            <a href="#planes" class="btn-primary" style="margin-right: 15px;">Ver Planes</a>
                            <button onclick="moveCarousel(1)" style="background: rgba(106,55,183,0.1); border: 2px solid var(--primary); color: var(--primary); padding: 22px 45px; border-radius: 20px; font-weight: 800; cursor: pointer; transition: 0.3s; text-transform: uppercase; letter-spacing: 1px;">¡Infórmame más!</button>
                        </div>
                    </div>
                </div>
                <!-- Slide 2: Luxury Form -->
                <div class="slide">
                    <img src="assets/img/banner_super.png" class="slide-bg" style="filter: blur(8px) brightness(0.5); transform: scale(1.1);">
                    <div class="slide-overlay dark"></div>
                    <div class="pearl-container reveal">
                        <h2>Únete a la <span>Élite</span></h2>
                        <p>Déjanos tus datos y obtén una consultoría estratégica gratuita para tu negocio.</p>
                        <form onsubmit="handleLead(event, this)" class="lead-form">
                            <div class="input-group">
                                <i class="fa-solid fa-user"></i>
                                <input type="text" name="nombre" class="lead-input" placeholder="Nombre completo" required>
                            </div>
                            <div class="input-group">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" name="email" class="lead-input" placeholder="Correo electrónico" required>
                            </div>
                            <div class="input-group">
                                <i class="fa-solid fa-whatsapp"></i>
                                <input type="text" name="whatsapp" class="lead-input" placeholder="WhatsApp de contacto" required>
                            </div>
                            <button type="submit" class="btn-submit">¡Quiero el Poder de CajaYa!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PRODUCT DESCRIPTION -->
    <section class="product-desc" id="desc">
        <div class="section-header">
            <h2 class="reveal">El Poder de <span>CajaYa.</span></h2>
            <p class="reveal" style="font-size: 1.3rem; color: var(--text-light); max-width: 800px; margin: 20px auto;">Llevamos tu negocio al siguiente nivel con tecnología de clase mundial diseñada para Chile.</p>
        </div>
        <div class="desc-grid">
            <div class="desc-item reveal">
                <i class="fa-solid fa-bolt"></i>
                <h3>Velocidad Extrema</h3>
                <p>Ventas en menos de 2 segundos. Olvídate de las filas y las esperas interminables.</p>
            </div>
            <div class="desc-item reveal">
                <i class="fa-solid fa-cloud"></i>
                <h3>Nube Híbrida</h3>
                <p>¿Sin internet? No hay problema. CajaYa sigue funcionando y sincroniza todo al volver.</p>
            </div>
            <div class="desc-item reveal">
                <i class="fa-solid fa-chart-line"></i>
                <h3>Control Total</h3>
                <p>Stock, ventas y reportes en tiempo real desde tu celular o cualquier lugar del mundo.</p>
            </div>
        </div>
        <div class="reveal" style="margin-top: 80px;">
            <button onclick="moveCarousel(1)" class="btn-primary" style="font-size: 1.2rem; padding: 25px 70px;">¡Comenzar ahora mismo!</button>
        </div>
    </section>

    <!-- PLAN CARDS -->
    <section class="section-padding" id="planes">
        <div class="section-header">
            <h2 class="reveal">Inversión <span>Inteligente.</span></h2>
        </div>

        <div class="p-grid" id="plan-cards">
            <div class="p-card reveal">
                <h3>PLAN EMPRENDE</h3>
                <div class="price">
                    $<?php echo $pMensual; ?>
                    <span class="price-sub">/mes</span>
                </div>
                <ul class="p-features">
                    <li><i class="fa-solid fa-circle-check"></i> <b>Catálogo Maestro (+20k SKU)</b></li>
                    <li><i class="fa-solid fa-circle-check"></i> Boletas SII Ilimitadas</li>
                    <li><i class="fa-solid fa-circle-check"></i> Control de Stock en Vivo</li>
                    <li><i class="fa-solid fa-circle-check"></i> Reportes de Venta Diarios</li>
                </ul>
                <a href="auth/google_redirect.php?plan=mensual" class="btn-plan">Activar Ahora</a>
            </div>

            <div class="p-card featured reveal">
                <div class="badge-sugerido">Sugerido por CajaYa</div>
                <h3>LICENCIA ÉLITE</h3>
                <div class="price">
                    $<?php echo $pLifetime; ?>
                </div>
                <p style="margin-top:-30px; margin-bottom:40px; font-weight:800; font-size:13px; letter-spacing:3px; opacity:0.8; color:#fff; text-align: center;">PAGO ÚNICO • PROPIEDAD TOTAL</p>
                <ul class="p-features">
                    <li><i class="fa-solid fa-crown"></i> <b>Todo el Plan Emprende</b></li>
                    <li><i class="fa-solid fa-crown"></i> 3 Cajas Simultáneas</li>
                    <li><i class="fa-solid fa-crown"></i> Cero Mensualidades</li>
                    <li><i class="fa-solid fa-crown"></i> Soporte VIP 24/7</li>
                    <li><i class="fa-solid fa-crown"></i> Inteligencia de Negocios</li>
                </ul>
                <a href="auth/google_redirect.php?plan=lifetime" class="btn-plan">Comprar Para Siempre</a>
            </div>

            <div class="p-card reveal">
                <h3>RED EMPRESA</h3>
                <div class="price">
                    $<?php echo $pEmpresa; ?>
                    <span class="price-sub">/mes</span>
                </div>
                <ul class="p-features">
                    <li><i class="fa-solid fa-building"></i> <b>Multi-sucursal Centralizado</b></li>
                    <li><i class="fa-solid fa-building"></i> Facturación y Guías</li>
                    <li><i class="fa-solid fa-building"></i> API de Integración Pro</li>
                    <li><i class="fa-solid fa-building"></i> Auditoría de Inventarios</li>
                </ul>
                <a href="auth/google_redirect.php?plan=empresa" class="btn-plan">Hablar con Ventas</a>
            </div>
        </div>
    </section>

    <canvas id="celeb-canvas" style="position: fixed; top:0; left:0; width:100%; height:100%; pointer-events:none; z-index:9999; display:none;"></canvas>

    <!-- FAQ SECTION -->
    <section class="section-padding" style="background:#fff;">
        <div class="section-header">
            <h2 class="reveal">Dudas <span>Frecuentes.</span></h2>
        </div>
        <div class="faq-container reveal" style="max-width: 900px; margin: 0 auto; text-align: left;">
            <div class="faq-item" style="margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
                <h4 style="font-size: 1.4rem; margin-bottom: 10px;">¿Cómo instalo el catálogo de productos?</h4>
                <p style="color: var(--text-light); line-height: 1.6;">No requiere instalación. CajaYa incluye una base de datos con más de 20,000 productos de consumo masivo precargados. Solo escaneas y vendes al instante.</p>
            </div>
            <div class="faq-item" style="margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
                <h4 style="font-size: 1.4rem; margin-bottom: 10px;">¿Qué pasa si pierdo el Internet?</h4>
                <p style="color: var(--text-light); line-height: 1.6;">CajaYa es Offline-First. Puedes seguir vendiendo sin interrupciones y el sistema sincronizará todas las transacciones automáticamente al detectar conexión.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-wave">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
            </svg>
        </div>
        <div class="f-grid">
            <div class="f-col">
                <img src="assets/img/logo.png">
                <p>Potenciando el crecimiento de los minimarkets y pymes en todo Chile con tecnología de vanguardia.</p>
            </div>
            <div class="f-col">
                <h5>PLATAFORMA</h5>
                <a href="#">Panel Maestro</a>
                <a href="#">Descargar App</a>
                <a href="#">Guía de Uso</a>
            </div>
            <div class="f-col">
                <h5>LEGAL</h5>
                <a href="#">Privacidad</a>
                <a href="#">Términos de Uso</a>
            </div>
            <div class="f-col">
                <h5>CONTACTO</h5>
                <a href="mailto:ventas@cajaya.cl">ventas@cajaya.cl</a>
                <p style="margin-top:20px; font-size:13px; opacity:0.6; letter-spacing: 2px;">RM, SANTIAGO DE CHILE</p>
            </div>
        </div>
        <div style="text-align:center; margin-top:100px; opacity:0.3; font-size:11px; letter-spacing:4px;">
            &copy; 2026 CAJAYA — EL FUTURO DEL RETAIL CHILENO.
        </div>
    </footer>

    <script>
        // PRELOADER
        window.addEventListener('load', () => {
            const pre = document.getElementById('preloader');
            setTimeout(() => {
                pre.style.opacity = '0';
                setTimeout(() => pre.style.display = 'none', 1200);
            }, 1000);
        });

        // NAVBAR SCROLL
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });

        // REVEAL ANIMATIONS
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    if (entry.target.id === 'plan-cards') {
                        document.querySelectorAll('.p-card').forEach((card, i) => {
                            setTimeout(() => card.classList.add('visible'), i * 200);
                        });
                    }
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // CAROUSEL LOGIC
        let currentSlide = 0;
        const totalSlides = 2;
        
        function moveCarousel(index) {
            currentSlide = index;
            const track = document.getElementById('heroTrack');
            track.style.transform = `translateX(-${index * 100}%)`;
        }

        // Auto-play cada 6 segundos
        setInterval(() => {
            currentSlide = (currentSlide + 1) % totalSlides;
            moveCarousel(currentSlide);
        }, 7000);

        // CELEBRATION ENGINE
        function launchCelebration() {
            const canvas = document.getElementById('celeb-canvas');
            canvas.style.display = 'block';
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            
            let particles = [];
            const colors = ['#6A37B7', '#9D50BB', '#FFD700', '#FFFFFF'];
            
            class Particle {
                constructor() {
                    this.x = canvas.width / 2;
                    this.y = canvas.height / 2;
                    this.angle = Math.random() * Math.PI * 2;
                    this.speed = Math.random() * 10 + 5;
                    this.friction = 0.96;
                    this.gravity = 0.2;
                    this.size = Math.random() * 8 + 3;
                    this.color = colors[Math.floor(Math.random() * colors.length)];
                    this.opacity = 1;
                }
                update() {
                    this.speed *= this.friction;
                    this.x += Math.cos(this.angle) * this.speed;
                    this.y += Math.sin(this.angle) * this.speed + this.gravity;
                    this.opacity -= 0.008;
                }
                draw() {
                    ctx.globalAlpha = this.opacity;
                    ctx.fillStyle = this.color;
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            for(let i=0; i<200; i++) particles.push(new Particle());

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach((p, i) => {
                    if(p.opacity <= 0) particles.splice(i, 1);
                    else { p.update(); p.draw(); }
                });
                if(particles.length > 0) requestAnimationFrame(animate);
                else canvas.style.display = 'none';
            }
            animate();
        }

        async function handleLead(e, formElement) {
            e.preventDefault();
            const btn = formElement.querySelector('.btn-submit');
            const originalText = btn.innerHTML;
            
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> PROCESANDO...';
            btn.disabled = true;

            const formData = new FormData(formElement);
            try {
                const resp = await fetch('save_lead.php', { method: 'POST', body: formData });
                if (resp.ok) {
                    formElement.innerHTML = `
                        <div style="padding: 40px; text-align: center;">
                            <i class="fa-solid fa-circle-check" style="font-size: 80px; color: #25D366; margin-bottom: 20px;"></i>
                            <h3 style="color: #fff; font-size: 2rem;">¡SOLICITUD EXITOSA!</h3>
                            <p style="color: rgba(255,255,255,0.7); margin-top: 15px;">Pronto un consultor Élite te contactará.</p>
                        </div>
                    `;
                    launchCelebration();
                } else {
                    throw new Error();
                }
            } catch (err) {
                alert('Error al enviar. Por favor intenta de nuevo.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }
    </script>
</body>
</html>
