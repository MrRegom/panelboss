<?php
/**
 * index.php — Landing Page CAJAYA ELITE FINAL V14.1 (DEBUG MODE)
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

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
    <title>CAJAYA — El Motor de tu Crecimiento</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
            --transition-mac: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-font-smoothing: antialiased; scroll-behavior: smooth; }
        body { background: var(--bg-white); color: var(--text-dark); font-family: 'Inter', sans-serif; overflow-x: hidden; }

        /* PRELOADER */
        #preloader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: #fff; display: flex; align-items: center; justify-content: center;
            z-index: 10000; transition: opacity 1.2s ease-out;
        }
        .pre-logo { width: 140px; animation: pulse 2s infinite ease-in-out; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.7; } 50% { transform: scale(1.1); opacity: 1; } }

        /* NAVIGATION */
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

        /* HERO - MOBILE CENTERED */
        .hero { 
            position: relative; height: 100vh; width: 100%; 
            background: url('assets/img/banner_super.png') center right/cover no-repeat;
            display: flex; align-items: center; padding: 0 8%;
        }
        .hero-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0.8) 35%, rgba(255,255,255,0) 100%);
            z-index: 1;
        }

        .hero-content { position: relative; z-index: 10; max-width: 850px; }
        .hero-content h1 { 
            font-family: 'Outfit', sans-serif; font-size: clamp(3rem, 8vw, 5.8rem); 
            line-height: 0.9; font-weight: 900; color: var(--text-dark); margin-bottom: 30px; letter-spacing: -3px;
        }
        .hero-content h1 span { color: var(--primary); }
        .hero-content p { 
            font-size: clamp(1.1rem, 2.5vw, 1.5rem); color: var(--text-light); line-height: 1.6; 
            margin-bottom: 50px; max-width: 650px; border-left: 5px solid var(--primary); padding-left: 30px;
        }
        .btn-cta { 
            background: var(--primary); color: #fff; text-decoration: none; padding: 24px 50px; 
            border-radius: 20px; font-weight: 700; display: inline-block; transition: var(--transition-mac);
            box-shadow: 0 20px 40px rgba(106,55,183,0.3); font-size: 16px;
        }
        .btn-cta:hover { transform: translateY(-8px) scale(1.05); box-shadow: 0 30px 60px rgba(106,55,183,0.4); background: var(--primary-dark); }

        /* PLANES - CARDS WITH DELICATE AURORA LIGHT */
        .section-padding { padding: 150px 8%; background: var(--bg-off); position: relative; }
        .section-header { text-align: center; margin-bottom: 100px; }
        .section-header h2 { font-family: 'Outfit', sans-serif; font-size: 4rem; letter-spacing: -2px; }
        .section-header h2 span { color: var(--primary); }
        
        .p-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 40px; }
        .p-card { 
            background: #fff; padding: 80px 50px; border-radius: 40px; flex: 1; min-width: 350px; max-width: 450px;
            position: relative; box-shadow: 0 10px 40px rgba(0,0,0,0.02); 
            transition: all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1); display: flex; flex-direction: column; 
            opacity: 0; transform: translateY(50px);
            z-index: 1; overflow: visible;
        }
        
        /* THE DELICATE AURORA (SPOTLIGHT EFFECT) */
        .p-card::before {
            content: ''; position: absolute; inset: -1px; 
            background: linear-gradient(135deg, transparent 30%, rgba(157,108,255,0.4) 50%, transparent 70%);
            background-size: 200% 200%;
            border-radius: 41px; z-index: -1; opacity: 0; transition: 1s;
            animation: aurora 6s linear infinite;
        }
        .p-card.featured::before, .p-card:hover::before { opacity: 1; }
        
        @keyframes aurora {
            0% { background-position: -100% -100%; }
            100% { background-position: 100% 100%; }
        }

        .p-card::after {
            content: ''; position: absolute; inset: 0; background: inherit; border-radius: 40px; z-index: -1;
        }

        .p-card.visible { opacity: 1; transform: translateY(0); }
        .p-card:hover { transform: translateY(-12px); box-shadow: 0 40px 80px rgba(106,55,183,0.1); }
        .p-card:active { transform: scale(0.98); }

        .p-card.featured { background: var(--primary); }
        .p-card.featured * { color: #fff !important; }
        .p-card.featured .btn-plan { background: #fff; color: var(--primary) !important; box-shadow: 0 10px 25px rgba(0,0,0,0.15); }
        .p-card.featured::before { 
            background: linear-gradient(135deg, transparent 30%, rgba(255,255,255,0.6) 50%, transparent 70%);
            background-size: 200% 200%;
        }

        /* SUGGESTED BADGE - HIGH VISIBILITY */
        .badge-sugerido {
            position: absolute; top: -18px; right: 40px; 
            background: var(--primary-dark); color: #fff !important; 
            padding: 10px 25px; border-radius: 50px; 
            font-size: 11px; font-weight: 900; letter-spacing: 1.5px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.1);
            z-index: 100;
            text-transform: uppercase;
        }

        .p-card h3 { font-size: 14px; color: var(--primary); letter-spacing: 4px; text-transform: uppercase; margin-bottom: 25px; font-weight: 900; }
        .p-price { font-size: 70px; font-weight: 900; font-family: 'Outfit', sans-serif; margin-bottom: 40px; letter-spacing: -4px; }
        .p-price span { font-size: 20px; opacity: 0.5; letter-spacing: 0; }
        
        .p-features { list-style: none; margin-bottom: 50px; flex-grow: 1; }
        .p-features li { margin-bottom: 18px; font-size: 16px; color: var(--text-light); display: flex; align-items: center; }
        .p-features li i { color: var(--primary); margin-right: 15px; font-size: 18px; transition: 0.3s; }
        .p-card:hover .p-features li i { transform: scale(1.3); }

        .btn-plan { 
            background: var(--primary-soft); color: var(--primary); text-decoration: none; padding: 22px; 
            border-radius: 20px; text-align: center; font-weight: 800; text-transform: uppercase; 
            letter-spacing: 2px; font-size: 14px; transition: 0.3s;
        }
        .btn-plan:hover { transform: scale(1.05); }

        /* FAQ - ANIMATED & FUN */
        .faq-section { background: #fff; padding: 150px 5%; }
        .faq-container { max-width: 900px; margin: 0 auto; }
        .faq-item { 
            background: var(--bg-off); border-radius: 35px; margin-bottom: 20px; 
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55); border: 2px solid transparent;
            overflow: hidden;
        }
        .faq-header { padding: 35px 50px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
        .faq-header h4 { font-size: 20px; font-weight: 800; color: var(--text-dark); transition: 0.3s; }
        .faq-header i { 
            background: #fff; width: 45px; height: 45px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--primary); font-size: 18px; transition: 0.5s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .faq-body { max-height: 0; padding: 0 50px; overflow: hidden; transition: 0.6s cubic-bezier(0.19, 1, 0.22, 1); color: var(--text-light); line-height: 1.8; }
        
        .faq-item.active { background: #fff; border-color: var(--primary); transform: scale(1.02); box-shadow: 0 30px 60px rgba(106,55,183,0.1); }
        .faq-item.active .faq-header h4 { color: var(--primary); }
        .faq-item.active i { transform: rotate(135deg); background: var(--primary); color: #fff; }
        .faq-item.active .faq-body { max-height: 400px; padding-bottom: 45px; }

        /* FOOTER - VIBRANT */
        footer { 
            padding: 120px 8% 60px; 
            padding: 150px 8% 60px; 
            background: linear-gradient(-45deg, var(--primary-dark), var(--primary), #5a2ea3, var(--primary-glow));
            background-size: 400% 400%;
            animation: footer-gradient 15s ease infinite;
            color: #fff; position: relative; overflow: hidden;
        }
        @keyframes footer-gradient { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        
        .footer-wave {
            position: absolute; top: 0; left: 0; width: 100%; overflow: hidden; line-height: 0;
        }
        .footer-wave svg { position: relative; display: block; width: calc(100% + 1.3px); height: 70px; }
        .footer-wave .shape-fill { fill: var(--bg-off); }

        footer::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
            opacity: 0.03; pointer-events: none;
        }
        .f-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 80px; position: relative; z-index: 2; }
        .f-col img { height: 65px; margin-bottom: 35px; filter: brightness(0) invert(1); transition: 0.5s; }
        .f-col img:hover { transform: scale(1.05) rotate(-2deg); }
        .f-col h5 { font-size: 14px; color: rgba(255,255,255,0.5); margin-bottom: 30px; letter-spacing: 3px; text-transform: uppercase; }
        .f-col a { color: #fff; text-decoration: none; display: block; margin-bottom: 15px; font-size: 16px; transition: 0.3s; opacity: 0.7; position: relative; width: fit-content; }
        .f-col a::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 0; height: 1px; background: #fff; transition: 0.3s; }
        .f-col a:hover { opacity: 1; color: #fff; }
        .f-col a:hover::after { width: 100%; }
        .f-col p { color: rgba(255,255,255,0.6); line-height: 1.8; font-size: 15px; }

        /* REVEAL */
        .reveal { opacity: 0; transform: translateY(40px); transition: var(--transition-mac); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* MOBILE OPTIMIZATION - ALL CENTERED */
        @media (max-width: 1024px) {
            .hero { padding: 0 5%; text-align: center; }
            .hero-overlay { background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0.75) 100%); }
            .hero-content { margin: 0 auto; }
            .hero-content p { border-left: none; border-top: 5px solid var(--primary); padding-left: 0; padding-top: 20px; margin: 0 auto 50px; }
            .section-header { text-align: center; }
            .p-grid { gap: 30px; }
            .f-grid { grid-template-columns: 1fr; gap: 60px; text-align: center; }
            .f-col a { transform: none; }
            .f-col a:hover { transform: scale(1.1); }
            nav { padding: 0 20px; }
            .nav-links { display: none; } /* On mobile we usually have a menu, but staying simple as requested */
            .faq-header { padding: 25px 30px; }
            .faq-body { padding: 0 30px; }
            .faq-header h4 { font-size: 17px; }
        }
    </style>
</head>
<body>

    <div id="preloader">
        <img src="assets/img/logo.png" class="pre-logo" alt="CajaYa">
    </div>

    <nav id="navbar">
        <a href="#" class="nav-logo"><img src="assets/img/logo.png" alt="CajaYa"></a>
        <div class="nav-links">
            <a href="#planes">Planes</a>
            <a href="https://wa.me/56900000000" target="_blank" class="btn-wa">Soporte WhatsApp</a>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="reveal">El Cerebro Digital para tu <span>Minimarket y Pyme.</span></h1>
            <p class="reveal">CajaYa potencia el crecimiento de tu negocio con tecnología de elite. Controla tus ventas, stock y cumple con el SII de la forma más prolija y eficiente del mercado.</p>
            <a href="#planes" class="btn-cta reveal">Descubre los Planes</a>
        </div>
    </section>

    <section class="section-padding" id="planes">
        <div class="section-header">
            <h2 class="reveal">Inversión <span>Inteligente.</span></h2>
        </div>

        <div class="p-grid" id="plan-cards">
            <div class="p-card reveal">
                <h3>PLAN EMPRENDE</h3>
                <div class="p-price">$<?php echo $pMensual; ?><span>/mes</span></div>
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
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="margin-top:-30px; margin-bottom:30px; font-weight:800; font-size:12px; letter-spacing:2px; opacity:0.8; color:#fff;">PAGO ÚNICO • PROPIEDAD TOTAL</p>
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
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
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

    <section class="faq-section">
        <div class="section-header">
            <h2 class="reveal">Dudas <span>Frecuentes.</span></h2>
        </div>
        <div class="faq-container reveal">
            <div class="faq-item">
                <div class="faq-header"><h4>¿Cómo instalo el catálogo de productos?</h4><i class="fa-solid fa-plus"></i></div>
                <div class="faq-body"><p>No requiere instalación. CajaYa incluye una base de datos con más de 20,000 productos de consumo masivo precargados. Solo escaneas y vendes al instante.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-header"><h4>¿Qué pasa si pierdo el Internet?</h4><i class="fa-solid fa-plus"></i></div>
                <div class="faq-body"><p>CajaYa es Offline-First. Puedes seguir vendiendo sin interrupciones y el sistema sincronizará todas las transacciones automáticamente al detectar conexión.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-header"><h4>¿Es compatible con mis equipos?</h4><i class="fa-solid fa-plus"></i></div>
                <div class="faq-body"><p>Totalmente. Funciona en cualquier PC, Notebook o Tablet con Windows o Android. Sin necesidad de comprar hardware propietario costoso.</p></div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-wave">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
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
                <p style="margin-top:20px; font-size:13px; opacity:0.4;">RM, SANTIAGO DE CHILE</p>
            </div>
        </div>
        <div style="text-align:center; margin-top:80px; opacity:0.2; font-size:11px; letter-spacing:3px;">
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

        // ACCORDION - INTERACTIVE
        document.querySelectorAll('.faq-header').forEach(header => {
            header.addEventListener('click', () => {
                const item = header.parentElement;
                const wasActive = item.classList.contains('active');
                document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
                if (!wasActive) item.classList.add('active');
            });
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
        }, { threshold: 0.15 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        observer.observe(document.getElementById('plan-cards'));
    </script>
</body>
</html>
