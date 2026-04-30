<?php
/**
 * index.php — Landing Page CAJAYA ELITE FINAL (SUPER BUTTON & DB SYNC)
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/Database.php';
require_once __DIR__ . '/../src/Repositories/PlanRepository.php';

use App\Repositories\PlanRepository;

$planRepo = new PlanRepository();
$plansRaw = $planRepo->getAll();
$plans = [];
foreach ($plansRaw as $p) { $plans[trim(strtolower($p['slug']))] = $p; }

$pMensual  = number_format($plans['mensual']['price']  ?? 20000, 0, ',', '.');
$pLifetime = number_format($plans['lifetime']['price'] ?? 180000, 0, ',', '.');
$pEmpresa  = number_format($plans['empresa']['price']  ?? 35000, 0, ',', '.');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CajaYa — El POS de Elite para Chile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --brand-purple: #6A1B9A;
            --brand-glow: #9C27B0;
            --dark: #000;
            --white: #FFF;
            --transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; scroll-behavior: smooth; }
        body { background: var(--white); color: #1d1d1f; font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; overflow-x: hidden; }

        /* PRELOADER */
        #preloader { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #000; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 10000; transition: opacity 1s ease; }
        .preloader-logo { width: 180px; margin-bottom: 40px; }
        .loader-bar-wrap { width: 220px; height: 4px; background: rgba(255,255,255,0.1); border-radius: 20px; overflow: hidden; }
        .loader-bar-fill { width: 0%; height: 100%; background: linear-gradient(90deg, var(--brand-purple), var(--brand-glow)); animation: fillLoader 2.5s forwards linear; }
        @keyframes fillLoader { to { width: 100%; } }

        /* Header */
        .top-banner { background: var(--brand-purple); color: #fff; text-align: center; padding: 10px; font-weight: 800; font-size: 11px; letter-spacing: 2.5px; position: fixed; top: 0; width: 100%; z-index: 9000; }
        nav { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(40px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 75px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 36px; z-index: 8000; }
        .nav-content { width: 1400px; display: flex; justify-content: space-between; align-items: center; padding: 0 50px; }
        .nav-logo img { height: 42px; }

        /* Hero */
        .hero { position: relative; width: 100%; height: 85vh; background: #000; overflow: hidden; z-index: 1000; margin-top: 111px; }
        .hero-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
        .hero-bg img { width: 100%; height: 100%; object-fit: cover; object-position: 85% center; filter: brightness(0.6); animation: kenBurns 40s infinite alternate; }
        @keyframes kenBurns { 0% { transform: scale(1); } 100% { transform: scale(1.15); } }
        .hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2; background: linear-gradient(90deg, #000 0%, #000 45%, transparent 100%); }
        .hero-content { position: relative; z-index: 10; width: 1300px; margin: 0 auto; padding: 120px 80px; color: #fff; }
        .hero-content h1 { font-size: 4rem; font-weight: 800; line-height: 1.1; margin-bottom: 25px; }
        .hero-content p { font-size: 1.3rem; opacity: 0.9; margin-bottom: 50px; max-width: 600px; line-height: 1.6; }
        
        /* BOTÓN MASTER FIX - GRANDE, PURPURA Y VISIBLE */
        .btn-hero { 
            background: var(--brand-purple); color: #fff; padding: 22px 50px; border-radius: 18px; 
            font-size: 20px; font-weight: 800; text-decoration: none; display: inline-block; 
            transition: 0.3s; box-shadow: 0 15px 35px rgba(106, 27, 154, 0.4); 
            border: 2px solid rgba(255,255,255,0.1);
        }
        .btn-hero:hover { transform: translateY(-5px); background: var(--brand-glow); box-shadow: 0 20px 50px rgba(106, 27, 154, 0.6); border-color: #fff; }

        /* Pricing */
        .pricing { padding: 120px 5%; background: #fff; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px; max-width: 1300px; margin: 0 auto; }
        .p-card { background: #fff; padding: 60px 45px; border-radius: 35px; border: 2px solid #f0f0f0; transition: var(--transition); cursor: pointer; position: relative; overflow: hidden; }
        .p-card::after { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: conic-gradient(transparent, var(--brand-purple), transparent 30%); animation: rotateB 5s linear infinite; opacity: 0; transition: 0.3s; z-index: -1; }
        .p-card:hover::after { opacity: 0.2; }
        @keyframes rotateB { 100% { transform: rotate(360deg); } }
        .p-card.selected { border: 3px solid var(--brand-purple); background: #faf8ff; }
        .p-price { font-size: 50px; font-weight: 800; margin-bottom: 35px; }

        /* FAQ */
        .faq { padding: 120px 10%; background: #fdfdfd; }
        .faq-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 40px; max-width: 1200px; margin-top: 60px; }
        .faq-item { background: #fff; padding: 40px; border-radius: 30px; border: 1px solid #f2f2f2; }

        /* Footer Robusto */
        .footer { background: #000; color: #fff; padding: 120px 10% 80px; }
        .f-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 80px; max-width: 1300px; margin: 0 auto; }
        .f-col h4 { font-size: 14px; color: rgba(255,255,255,0.3); margin-bottom: 30px; letter-spacing: 2px; }
        .f-col a { color: rgba(255,255,255,0.7); text-decoration: none; display: block; margin-bottom: 15px; }

        .reveal { opacity: 0; transform: translateY(40px); transition: 1s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 768px) {
            .hero-content { padding: 60px 20px; text-align: center; }
            .hero-content h1 { font-size: 2.6rem; }
            .hero-overlay { background: linear-gradient(0deg, #000 40%, rgba(0,0,0,0.5) 100%); }
            .p-grid { grid-template-columns: 1fr; }
            .f-grid { grid-template-columns: 1fr; text-align: center; }
        }
    </style>
</head>
<body>

    <div id="preloader">
        <div class="preloader-content">
            <img src="assets/img/logo.png" class="preloader-logo" alt="CajaYa">
            <div class="loader-bar-wrap"><div class="loader-bar-fill"></div></div>
        </div>
    </div>

    <div class="top-banner">🚀 LIDERAZGO COMERCIAL EN TODO CHILE — INTEGRACIÓN SII 2026 🚀</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="nav-logo"><img src="assets/img/logo.png" alt="CajaYa"></a>
            <div style="font-weight:800; font-size:11px; color:var(--brand-purple); letter-spacing:3px;">TECNOLOGÍA ELITE</div>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-bg"><img src="banner1.png"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Tu Negocio Merece<br>Vender con Elegancia.</h1>
            <p>El estándar tecnológico que transforma tu minimarket. Control absoluto, rapidez extrema y cumplimiento SII garantizado.</p>
            <a href="#planes" class="btn-hero">Ver Planes de Inversión</a>
        </div>
    </div>

    <section class="pricing" id="planes">
        <div class="p-grid">
            <div class="p-card reveal" onclick="selectPlan(this)">
                <h4>PLAN MENSUAL</h4>
                <div class="p-price">$<?php echo $pMensual; ?><span>/mes</span></div>
                <ul style="list-style:none; line-height:2.4;">
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> 1 Punto de Venta Full</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Boletas SII Instantáneas</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Soporte VIP WhatsApp</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" style="background:#f8f9fa; color:#000; text-align:center; padding:18px; border-radius:15px; font-weight:700; text-decoration:none; display:block; margin-top:40px; border:1px solid #eee;">Seleccionar</a>
            </div>
            <div class="p-card selected reveal" onclick="selectPlan(this)">
                <h4>PLAN LIFETIME</h4>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:12px; color:#888; margin-top:-30px; margin-bottom:30px; font-weight:800;">LICENCIA ETERNA. PAGO ÚNICO.</p>
                <ul style="list-style:none; line-height:2.4;">
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> 3 Puntos de Venta Full</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Boleta y Factura SII</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Actualizaciones Eternas</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" style="background:var(--brand-purple); color:#fff; text-align:center; padding:18px; border-radius:15px; font-weight:700; text-decoration:none; display:block; margin-top:40px;">Comprar Licencia</a>
            </div>
            <div class="p-card reveal" onclick="selectPlan(this)">
                <h4>PLAN EMPRESA</h4>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul style="list-style:none; line-height:2.4;">
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Cajas Ilimitadas</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Gestión Multi-Sucursal</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Soporte 24/7 Crítico</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" style="background:#f8f9fa; color:#000; text-align:center; padding:18px; border-radius:15px; font-weight:700; text-decoration:none; display:block; margin-top:40px; border:1px solid #eee;">Contactar</a>
            </div>
        </div>
    </section>

    <section class="faq">
        <h2 style="text-align:center; font-size:45px; font-weight:800; margin-bottom:80px;">Preguntas Frecuentes</h2>
        <div class="faq-grid">
            <div class="faq-item reveal">
                <h4>¿La activación es inmediata?</h4>
                <p>Sí. Al procesar tu pago, recibirás de forma automática tus credenciales y el manual de bienvenida en tu correo.</p>
            </div>
            <div class="faq-item reveal">
                <h4>¿Qué pasa si no tengo internet?</h4>
                <p>CajaYa es Offline-First. Sigue vendiendo con normalidad; los datos se subirán al SII cuando vuelva la señal.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="f-grid">
            <div class="f-col">
                <img src="assets/img/logo.png" style="height:50px; margin-bottom:30px; filter:brightness(0) invert(1);">
                <p style="opacity:0.5;">Digitalizando el comercio chileno con tecnología robusta y certificada por el SII.</p>
            </div>
            <div class="f-col">
                <h4>Producto</h4>
                <a href="#">Motor de Ventas</a>
                <a href="#planes">Planes</a>
            </div>
            <div class="f-col">
                <h4>Legal</h4>
                <a href="#">Privacidad</a>
                <a href="#">Términos</a>
            </div>
            <div class="f-col">
                <h4>Soporte</h4>
                <a href="#">ventas@cajaya.cl</a>
                <a href="#">Santiago, Chile</a>
            </div>
        </div>
        <div style="text-align:center; opacity:0.1; font-size:12px; margin-top:80px;">&copy; 2026 CajaYa S.A. Hecho en Chile.</div>
    </footer>

    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const p = document.getElementById('preloader');
                p.style.opacity = '0';
                setTimeout(() => p.style.display = 'none', 1000);
            }, 2600);
        });
        function selectPlan(card) {
            document.querySelectorAll('.p-card').forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
        }
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>
</html>
