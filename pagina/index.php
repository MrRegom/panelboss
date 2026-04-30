<?php
/**
 * index.php — Landing Page CAJAYA ELITE FINAL V22 (MASTER EDITION)
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
    <title>CajaYa Elite — El Software para tu Negocio</title>
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
            --transition-mac: all 1s cubic-bezier(0.16, 1, 0.3, 1);
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

        /* HERO CAROUSEL LEFT ALIGNED */
        .hero-carousel { position: relative; height: 100vh; overflow: hidden; background: #fff; }
        .carousel-track { display: flex; height: 100%; transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
        .slide { min-width: 100%; height: 100%; position: relative; display: flex; align-items: center; justify-content: flex-start; padding: 0 8%; }
        
        .slide-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1; }
        .slide-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0.8) 40%, transparent 100%); z-index: 2; }

        .hero-content { position: relative; z-index: 10; max-width: 750px; text-align: left; }
        .hero-content h1 { font-family: 'Outfit', sans-serif; font-size: clamp(3rem, 7vw, 5rem); line-height: 0.9; font-weight: 900; margin-bottom: 30px; letter-spacing: -4px; color: var(--text-dark); }
        .hero-content h1 span { color: var(--primary); }
        .hero-content p { font-size: 1.4rem; color: var(--text-light); margin-bottom: 50px; border-left: 5px solid var(--primary); padding-left: 30px; }
        .btn-primary { background: var(--primary); color: #fff; padding: 24px 50px; border-radius: 20px; text-decoration: none; font-weight: 700; display: inline-block; transition: 0.3s; box-shadow: 0 20px 40px rgba(106,55,183,0.3); }

        /* SOLID PEARL FORM */
        .pearl-container { 
            background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);
            padding: 60px 50px; border-radius: 50px; color: var(--text-dark);
            box-shadow: 0 40px 100px rgba(0,0,0,0.1);
            border: 1px solid #fff; text-align: center;
            max-width: 550px; width: 100%;
        }
        .pearl-container h2 { font-family: 'Outfit', sans-serif; font-size: 2.8rem; margin-bottom: 15px; color: var(--primary); letter-spacing: -2px; }
        .pearl-container p { color: var(--text-light); font-size: 1.1rem; margin-bottom: 35px; }
        
        .lead-form { display: grid; grid-template-columns: 1fr; gap: 15px; width: 100%; }
        .input-group { position: relative; }
        .input-group i { position: absolute; left: 25px; top: 50%; transform: translateY(-50%); color: var(--primary); opacity: 0.5; }
        .lead-input { 
            width: 100%; padding: 20px 25px 20px 60px; border-radius: 20px; border: 1px solid rgba(106,55,183,0.1); 
            background: #fff; color: var(--text-dark); font-size: 16px; transition: 0.4s;
        }
        .lead-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 30px rgba(106,55,183,0.1); }
        .btn-submit { 
            background: var(--primary); color: #fff; border: none; padding: 22px; 
            border-radius: 20px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px;
            cursor: pointer; transition: 0.5s; box-shadow: 0 15px 40px rgba(106,55,183,0.3);
        }

        /* PODER CAJAYA MODERN */
        .product-desc { background: #fff; padding: 120px 8%; text-align: center; }
        .section-header h2 { font-family: 'Outfit', sans-serif; font-size: 4rem; letter-spacing: -2px; }
        .desc-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; margin-top: 60px; }
        .desc-item { padding: 50px 40px; border-radius: 40px; background: var(--bg-off); transition: 0.5s; border-bottom: 5px solid transparent; }
        .desc-item:hover { transform: translateY(-15px); border-bottom-color: var(--primary); box-shadow: 0 40px 80px rgba(0,0,0,0.06); }
        .desc-item i { font-size: 50px; color: var(--primary); margin-bottom: 25px; display: inline-block; animation: float 3s infinite ease-in-out; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

        /* PLAN CARDS WITH ANIMATION */
        .section-padding { padding: 150px 8%; background: var(--bg-off); }
        .p-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 40px; }
        .p-card { 
            background: #fff; padding: 80px 50px; border-radius: 45px; flex: 1; min-width: 350px; max-width: 450px;
            position: relative; box-shadow: 0 10px 40px rgba(0,0,0,0.02); transition: 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .p-card.featured { transform: scale(1.05); border: 3px solid var(--primary-glow); z-index: 10; box-shadow: 0 50px 100px rgba(106,55,183,0.15); }
        .p-card.featured::after { content: ''; position: absolute; inset: -10px; border-radius: 55px; background: var(--primary-glow); opacity: 0.1; z-index: -1; animation: pulse-glow 2s infinite; }
        @keyframes pulse-glow { 0% { transform: scale(1); opacity: 0.1; } 50% { transform: scale(1.05); opacity: 0.2; } 100% { transform: scale(1); opacity: 0.1; } }
        
        .price { font-size: 4.5rem; font-weight: 900; letter-spacing: -3px; display: flex; align-items: baseline; justify-content: center; margin: 30px 0; color: var(--primary); }
        .price-sub { font-size: 1.3rem; opacity: 0.4; margin-left: 8px; color: var(--text-dark); }
        .p-features { list-style: none; margin-bottom: 50px; text-align: left; }
        .p-features li { margin-bottom: 20px; font-size: 16px; color: var(--text-light); display: flex; align-items: center; }
        .p-features li i { color: var(--primary); margin-right: 15px; font-size: 20px; }
        .btn-plan { background: var(--primary-soft); color: var(--primary); text-decoration: none; padding: 25px; display: block; border-radius: 25px; text-align: center; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; transition: 0.4s; }
        .btn-plan:hover { transform: translateY(-5px); background: var(--primary); color: #fff; box-shadow: 0 20px 40px rgba(106,55,183,0.3); }

        /* FAQ MODERN */
        .faq-section { padding: 120px 8%; background: #fff; }
        .faq-container { max-width: 900px; margin: 0 auto; }
        .faq-item { margin-bottom: 20px; border-radius: 25px; background: var(--bg-off); overflow: hidden; transition: 0.3s; }
        .faq-header { padding: 30px 40px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
        .faq-header h4 { font-size: 1.3rem; font-weight: 700; }
        .faq-body { padding: 0 40px; max-height: 0; transition: 0.5s ease; opacity: 0; }
        .faq-item.active .faq-body { padding: 10px 40px 40px; max-height: 200px; opacity: 1; }
        .faq-item.active { box-shadow: 0 20px 40px rgba(0,0,0,0.05); }

        /* FOOTER MORADO MODERN */
        footer { 
            padding: 150px 8% 60px; 
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            color: #fff; position: relative; overflow: hidden;
        }
        .footer-wave { position: absolute; top: -1px; left: 0; width: 100%; line-height: 0; transform: rotate(180deg); }
        .footer-wave svg { display: block; width: calc(160% + 1.3px); height: 100px; fill: #fff; }
        
        .f-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 60px; position: relative; z-index: 5; }
        .f-col img { height: 40px; margin-bottom: 30px; filter: brightness(0) invert(1); }
        .f-col h5 { font-size: 14px; opacity: 0.5; margin-bottom: 30px; letter-spacing: 4px; text-transform: uppercase; }
        .f-col a { color: #fff; text-decoration: none; display: block; margin-bottom: 18px; opacity: 0.7; transition: 0.3s; }
        .f-col a:hover { opacity: 1; transform: translateX(10px); color: var(--primary-glow); }

        @media (max-width: 768px) {
            .slide { padding: 100px 5% 50px; justify-content: center; }
            .hero-content { text-align: center; }
            .hero-content p { border-left: none; border-top: 5px solid var(--primary); padding: 25px 0 0; text-align: center; }
            .hero-btns { display: flex; flex-direction: column; gap: 15px; }
            .desc-grid { grid-template-columns: 1fr; }
            .p-card.featured { transform: scale(1); margin: 20px 0; }
            .f-grid { grid-template-columns: 1fr; text-align: center; }
            .f-col { align-items: center; }
        }
        .reveal { opacity: 0; transform: translateY(40px); transition: 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
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
                            <button onclick="moveCarousel(1)" style="background: var(--primary-soft); color: var(--primary); border: none; padding: 22px 45px; border-radius: 20px; font-weight: 800; cursor: pointer; transition: 0.3s; text-transform: uppercase;">¡Infórmame más!</button>
                        </div>
                    </div>
                </div>
                <!-- Slide 2: Solid Form -->
                <div class="slide">
                    <img src="assets/img/banner_super.png" class="slide-bg" style="filter: blur(5px); opacity: 0.5;">
                    <div class="pearl-container reveal">
                        <h2>Únete a la <span>Élite</span></h2>
                        <p>Déjanos tus datos y obtén una consultoría estratégica gratuita.</p>
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
            <p class="reveal" style="font-size: 1.4rem; color: var(--text-light); max-width: 800px; margin: 25px auto;">Llevamos tu negocio al siguiente nivel con tecnología de clase mundial diseñada para Chile.</p>
        </div>
        <div class="desc-grid">
            <div class="desc-item reveal">
                <i class="fa-solid fa-bolt"></i>
                <h3>Velocidad Extrema</h3>
                <p>Ventas en menos de 2 segundos. Olvídate de las filas.</p>
            </div>
            <div class="desc-item reveal">
                <i class="fa-solid fa-cloud"></i>
                <h3>Nube Híbrida</h3>
                <p>¿Sin internet? No hay problema. Sigue vendiendo.</p>
            </div>
            <div class="desc-item reveal">
                <i class="fa-solid fa-chart-line"></i>
                <h3>Control Total</h3>
                <p>Reportes en tiempo real desde cualquier lugar.</p>
            </div>
        </div>
    </section>

    <!-- PLAN CARDS -->
    <section class="section-padding" id="planes">
        <div class="section-header" style="text-align: center; margin-bottom: 80px;">
            <h2 class="reveal">Inversión <span>Inteligente.</span></h2>
        </div>

        <div class="p-grid" id="plan-cards">
            <div class="p-card reveal">
                <h3>PLAN EMPRENDE</h3>
                <div class="price">$<?php echo $pMensual; ?><span class="price-sub">/mes</span></div>
                <ul class="p-features">
                    <li><i class="fa-solid fa-circle-check"></i> Catálogo Maestro (+20k SKU)</li>
                    <li><i class="fa-solid fa-circle-check"></i> Boletas SII Ilimitadas</li>
                    <li><i class="fa-solid fa-circle-check"></i> Control de Stock en Vivo</li>
                </ul>
                <a href="auth/google_redirect.php?plan=mensual" class="btn-plan">Activar Ahora</a>
            </div>

            <div class="p-card featured reveal">
                <div class="badge-sugerido">Sugerido por CajaYa</div>
                <h3>LICENCIA ÉLITE</h3>
                <div class="price">$<?php echo $pLifetime; ?></div>
                <p style="margin-top:-30px; margin-bottom:40px; font-weight:800; font-size:13px; letter-spacing:3px; opacity:0.4; text-align: center;">PAGO ÚNICO • PROPIEDAD TOTAL</p>
                <ul class="p-features">
                    <li><i class="fa-solid fa-crown"></i> <b>Todo el Plan Emprende</b></li>
                    <li><i class="fa-solid fa-crown"></i> 3 Cajas Simultáneas</li>
                    <li><i class="fa-solid fa-crown"></i> Cero Mensualidades</li>
                </ul>
                <a href="auth/google_redirect.php?plan=lifetime" class="btn-plan">Comprar Para Siempre</a>
            </div>

            <div class="p-card reveal">
                <h3>RED EMPRESA</h3>
                <div class="price">$<?php echo $pEmpresa; ?><span class="price-sub">/mes</span></div>
                <ul class="p-features">
                    <li><i class="fa-solid fa-building"></i> Multi-sucursal Centralizado</li>
                    <li><i class="fa-solid fa-building"></i> Facturación y Guías</li>
                    <li><i class="fa-solid fa-building"></i> Auditoría de Inventarios</li>
                </ul>
                <a href="auth/google_redirect.php?plan=empresa" class="btn-plan">Hablar con Ventas</a>
            </div>
        </div>
    </section>

    <!-- FAQ SECTION -->
    <section class="faq-section">
        <div class="section-header">
            <h2 class="reveal">Dudas <span>Frecuentes.</span></h2>
        </div>
        <div class="faq-container reveal">
            <div class="faq-item">
                <div class="faq-header"><h4>¿Cómo instalo el catálogo de productos?</h4><i class="fa-solid fa-plus"></i></div>
                <div class="faq-body"><p>No requiere instalación. CajaYa incluye una base de datos con más de 20,000 productos precargados. Solo escaneas y vendes.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-header"><h4>¿Qué pasa si pierdo el Internet?</h4><i class="fa-solid fa-plus"></i></div>
                <div class="faq-body"><p>Es Offline-First. Puedes seguir vendiendo y el sistema sincronizará todo automáticamente al detectar conexión.</p></div>
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
                <p>Potenciando el crecimiento de los minimarkets y pymes en todo Chile.</p>
            </div>
            <div class="f-col">
                <h5>PLATAFORMA</h5>
                <a href="#">Panel Maestro</a>
                <a href="#">Descargar App</a>
            </div>
            <div class="f-col">
                <h5>LEGAL</h5>
                <a href="#">Privacidad</a>
                <a href="#">Términos</a>
            </div>
            <div class="f-col">
                <h5>CONTACTO</h5>
                <a href="mailto:ventas@cajaya.cl">ventas@cajaya.cl</a>
                <p style="margin-top:20px; font-size:13px; opacity:0.4;">RM, CHILE</p>
            </div>
        </div>
        <div style="text-align:center; margin-top:80px; opacity:0.2; font-size:11px; letter-spacing:4px;">
            &copy; 2026 CAJAYA — EL FUTURO DEL RETAIL.
        </div>
    </footer>

    <script>
        // PRELOADER
        window.addEventListener('load', () => {
            document.getElementById('preloader').style.opacity = '0';
            setTimeout(() => document.getElementById('preloader').style.display = 'none', 1200);
        });

        // NAVBAR
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });

        // FAQ
        document.querySelectorAll('.faq-header').forEach(header => {
            header.addEventListener('click', () => {
                const item = header.parentElement;
                item.classList.toggle('active');
            });
        });

        // REVEAL
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // CAROUSEL
        let currentSlide = 0;
        function moveCarousel(index) {
            currentSlide = index;
            document.getElementById('heroTrack').style.transform = `translateX(-${index * 100}%)`;
        }
        setInterval(() => {
            currentSlide = (currentSlide + 1) % 2;
            moveCarousel(currentSlide);
        }, 8000);

        async function handleLead(e, form) {
            e.preventDefault();
            const btn = form.querySelector('.btn-submit');
            btn.innerHTML = 'PROCESANDO...';
            try {
                const resp = await fetch('save_lead.php', { method: 'POST', body: new FormData(form) });
                if (resp.ok) form.innerHTML = '<h3 style="color:var(--primary); padding:40px;">¡Datos Recibidos!</h3>';
            } catch (err) { btn.innerHTML = 'REINTENTAR'; }
        }
    </script>
</body>
</html>
