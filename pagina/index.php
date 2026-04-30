<?php
/**
 * index.php — Landing Page CAJAYA ELITE FINAL (MOBILE PRICES & EPIC INTRO)
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --brand-purple: #6A1B9A;
            --brand-glow: #9C27B0;
            --dark: #000;
            --white: #FFF;
            --transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; scroll-behavior: smooth; }
        body { background: var(--white); color: #1d1d1f; font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; overflow-x: hidden; width: 100%; }

        /* INTRO MODERNA Y ESPECTACULAR */
        #preloader { 
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: #000; display: flex; align-items: center; justify-content: center; 
            z-index: 10000; transition: opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1); 
        }
        .preloader-content { display: flex; flex-direction: column; align-items: center; text-align: center; }
        .preloader-logo { 
            width: 220px; margin-bottom: 60px; 
            opacity: 0; transform: scale(0.9);
            animation: logoReveal 1.2s cubic-bezier(0.2, 1, 0.3, 1) forwards;
            filter: drop-shadow(0 0 20px rgba(156, 39, 176, 0.5));
        }
        @keyframes logoReveal { 100% { opacity: 1; transform: scale(1); } }
        
        .loader-bar-wrap { width: 320px; height: 1px; background: rgba(255,255,255,0.05); position: relative; overflow: visible; }
        .loader-bar-fill { 
            position: absolute; left: 50%; top: 0; width: 0%; height: 100%; 
            background: #fff; transform: translateX(-50%);
            animation: laserFill 3s cubic-bezier(0.7, 0, 0.3, 1) forwards; 
            box-shadow: 0 0 15px #fff, 0 0 30px var(--brand-purple);
        }
        @keyframes laserFill { 100% { width: 100%; } }
        .preloader-text { 
            color: #fff; font-size: 8px; letter-spacing: 6px; margin-top: 30px; 
            opacity: 0; animation: fadeIn 2s 1s forwards; text-transform: uppercase; 
        }
        @keyframes fadeIn { 100% { opacity: 0.4; } }

        /* Header */
        .top-banner { background: var(--brand-purple); color: #fff; text-align: center; padding: 10px; font-weight: 800; font-size: 10px; letter-spacing: 2px; position: fixed; top: 0; width: 100%; z-index: 9000; }
        nav { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(30px); height: 75px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 35px; z-index: 8000; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .nav-content { width: 100%; max-width: 1400px; display: flex; justify-content: space-between; align-items: center; padding: 0 5%; }
        .nav-logo img { height: 38px; }

        /* Hero */
        .hero { position: relative; width: 100%; height: 90vh; background: #000; overflow: hidden; z-index: 1000; margin-top: 110px; }
        .hero-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
        .hero-bg img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.7); animation: kenBurns 40s infinite alternate; }
        @keyframes kenBurns { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }
        .hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2; background: linear-gradient(90deg, #000 0%, rgba(106,27,154,0.2) 60%, transparent 100%); }
        .hero-content { position: relative; z-index: 10; width: 100%; max-width: 1400px; margin: 0 auto; height: 100%; display: flex; flex-direction: column; justify-content: center; color: #fff; padding: 0 8%; }
        .hero-content h1 { font-size: clamp(2.8rem, 6.5vw, 5rem); font-weight: 800; line-height: 1.05; margin-bottom: 25px; }
        .hero-content p { font-size: clamp(1.1rem, 2vw, 1.4rem); opacity: 0.9; margin-bottom: 50px; max-width: 650px; line-height: 1.6; }
        .btn-hero { background: var(--brand-purple); color: #fff; padding: 22px 55px; border-radius: 15px; font-size: 20px; font-weight: 800; text-decoration: none; transition: 0.3s; box-shadow: 0 15px 40px rgba(106, 27, 154, 0.4); border: 2px solid rgba(255,255,255,0.1); display: inline-block; width: fit-content; }
        .btn-hero:hover { transform: translateY(-7px); background: var(--brand-glow); box-shadow: 0 20px 60px rgba(106, 27, 154, 0.6); }

        /* Pricing */
        .pricing { padding: 120px 5%; background: #fff; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px; max-width: 1350px; margin: 0 auto; }
        .p-card { background: #fff; padding: 60px 45px; border-radius: 40px; border: 2px solid #f2f2f2; transition: var(--transition); cursor: pointer; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.02); z-index: 1; }
        .p-card::after { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: conic-gradient(transparent, var(--brand-purple), transparent 30%); animation: rotateB 5s linear infinite; opacity: 0; transition: 0.3s; z-index: -1; }
        .p-card:hover::after { opacity: 0.2; }
        @keyframes rotateB { 100% { transform: rotate(360deg); } }
        .p-card.selected { border: 3px solid var(--brand-purple); background: #faf8ff; transform: scale(1.02); box-shadow: 0 20px 50px rgba(106,27,154,0.1); }
        
        /* PRECIO ARREGLADO PARA MOBILE */
        .p-price { font-size: clamp(34px, 10vw, 55px); font-weight: 800; margin-bottom: 40px; color: #000; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .p-price span { font-size: 0.4em; color: #888; font-weight: 400; }

        /* FAQ */
        .faq { padding: 120px 10%; background: #fdfdfd; }
        .faq-title { text-align: center; font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; margin-bottom: 80px; }
        .faq-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 40px; max-width: 1200px; margin: 0 auto; }
        .faq-item { background: #fff; padding: 45px; border-radius: 35px; border: 1px solid #f2f2f2; transition: 0.3s; }
        .faq-item:hover { border-color: var(--brand-purple); transform: translateY(-5px); }
        .faq-item h4 { font-size: 20px; margin-bottom: 20px; font-weight: 700; color: var(--brand-purple); }
        .faq-item p { font-size: 16px; line-height: 1.6; opacity: 0.7; }

        /* Footer */
        .footer { background: #000; color: #fff; padding: 120px 10% 60px; }
        .f-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 80px; max-width: 1400px; margin: 0 auto; }
        .f-col h4 { font-size: 13px; color: rgba(255,255,255,0.4); margin-bottom: 30px; letter-spacing: 2px; text-transform: uppercase; }
        .f-col a { color: rgba(255,255,255,0.7); text-decoration: none; display: block; margin-bottom: 15px; font-size: 15px; }

        .reveal { opacity: 0; transform: translateY(50px); transition: 1.2s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 768px) {
            .hero { height: 90vh; margin-top: 0; }
            .hero-content { padding: 0 10%; text-align: center; align-items: center; }
            .hero-content h1 { font-size: 2.6rem; margin-top: 80px; }
            .nav-elite-text { display: none; }
            .nav-content { justify-content: center; }
            .faq-grid { grid-template-columns: 1fr; }
            .p-grid { grid-template-columns: 1fr; padding: 0 10px; }
        }
    </style>
</head>
<body>

    <div id="preloader">
        <div class="preloader-content">
            <img src="assets/img/logo.png" class="preloader-logo" alt="CajaYa">
            <div class="loader-bar-wrap"><div class="loader-bar-fill"></div></div>
            <div class="preloader-text">Digitalizando tu Negocio</div>
        </div>
    </div>

    <div class="top-banner">🚀 LIDERAZGO COMERCIAL EN TODO CHILE — INTEGRACIÓN SII 2026 🚀</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="nav-logo"><img src="assets/img/logo.png" alt="CajaYa"></a>
            <div class="nav-elite-text" style="font-weight:800; font-size:11px; color:var(--brand-purple); letter-spacing:3px;">TECNOLOGÍA DE VANGUARDIA</div>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-bg"><img src="https://images.unsplash.com/photo-1556740758-90de374c12ad?q=80&w=2070&auto=format&fit=crop" alt="Retail Tech"></div>
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
                <h4 style="font-size:12px; letter-spacing:3px; color:var(--brand-purple); font-weight:800; margin-bottom:20px;">PLAN MENSUAL</h4>
                <div class="p-price">$<?php echo $pMensual; ?><span>/mes</span></div>
                <ul style="list-style:none; line-height:2.6; font-size:16px; margin-bottom:40px;">
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple); margin-right:12px;"></i> 1 Punto de Venta Full</li>
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple); margin-right:12px;"></i> Boletas SII Instantáneas</li>
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple); margin-right:12px;"></i> Soporte VIP WhatsApp</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" style="background:#f8f9fa; color:#000; text-align:center; padding:20px; border-radius:15px; font-weight:700; text-decoration:none; display:block; border:1px solid #eee;">Seleccionar</a>
            </div>
            <div class="p-card selected reveal" onclick="selectPlan(this)">
                <h4 style="font-size:12px; letter-spacing:3px; color:var(--brand-purple); font-weight:800; margin-bottom:20px;">PLAN LIFETIME</h4>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:12px; color:#888; margin-top:-35px; margin-bottom:35px; font-weight:800;">LICENCIA ETERNA. PAGO ÚNICO.</p>
                <ul style="list-style:none; line-height:2.6; font-size:16px; margin-bottom:40px;">
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple); margin-right:12px;"></i> 3 Puntos de Venta Full</li>
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple); margin-right:12px;"></i> Boleta y Factura SII</li>
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple); margin-right:12px;"></i> Actualizaciones Eternas</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" style="background:var(--brand-purple); color:#fff; text-align:center; padding:20px; border-radius:15px; font-weight:700; text-decoration:none; display:block;">Comprar Licencia</a>
            </div>
            <div class="p-card reveal" onclick="selectPlan(this)">
                <h4 style="font-size:12px; letter-spacing:3px; color:var(--brand-purple); font-weight:800; margin-bottom:20px;">PLAN EMPRESA</h4>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul style="list-style:none; line-height:2.6; font-size:16px; margin-bottom:40px;">
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple); margin-right:12px;"></i> Cajas Ilimitadas</li>
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple); margin-right:12px;"></i> Gestión Multi-Sucursal</li>
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple); margin-right:12px;"></i> Soporte 24/7 Crítico</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" style="background:#f8f9fa; color:#000; text-align:center; padding:20px; border-radius:15px; font-weight:700; text-decoration:none; display:block; border:1px solid #eee;">Contactar</a>
            </div>
        </div>
    </section>

    <section class="faq">
        <h2 class="faq-title reveal">Preguntas Frecuentes</h2>
        <div class="faq-grid">
            <div class="faq-item reveal">
                <h4>¿La activación es inmediata?</h4>
                <p>Sí. Al procesar tu pago, recibirás de forma automática tus credenciales y el manual de bienvenida.</p>
            </div>
            <div class="faq-item reveal">
                <h4>¿Funciona sin conexión?</h4>
                <p>Sí, CajaYa es Offline-First. Sigue vendiendo; los datos se sincronizarán al volver la conexión.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="f-grid">
            <div class="f-col">
                <img src="assets/img/logo.png" style="height:50px; margin-bottom:30px; filter:brightness(0) invert(1);">
                <p style="opacity:0.6; font-size:15px; line-height:1.7;">Digitalizando el futuro del comercio chileno.</p>
            </div>
            <div class="f-col">
                <h4>Ecosistema</h4>
                <a href="#">Panel Boss</a>
                <a href="#">CajaYa App</a>
            </div>
            <div class="f-col">
                <h4>Legal</h4>
                <a href="#">Términos</a>
                <a href="#">Privacidad</a>
            </div>
            <div class="f-col">
                <h4>Soporte</h4>
                <a href="#">ventas@cajaya.cl</a>
                <a href="#">Santiago, Chile</a>
            </div>
        </div>
        <div style="text-align:center; opacity:0.1; font-size:12px; margin-top:80px;">&copy; 2026 CajaYa S.A.</div>
    </footer>

    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const p = document.getElementById('preloader');
                p.style.opacity = '0';
                setTimeout(() => p.style.display = 'none', 1200);
            }, 3200);
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
