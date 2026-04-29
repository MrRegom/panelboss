<?php
/**
 * index.php — Landing Page CAJAYA ELITE (RESTORED & RESPONSIVE)
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/Database.php';
require_once __DIR__ . '/../src/Repositories/PlanRepository.php';

use App\Repositories\PlanRepository;

$planRepo = new PlanRepository();
$plansRaw = $planRepo->getAll();
$plans = [];
foreach ($plansRaw as $p) { $plans[$p['slug']] = $p; }

$pMensual  = number_format($plans['mensual']['price']  ?? 20000, 0, ',', '.');
$pLifetime = number_format($plans['lifetime']['price'] ?? 180000, 0, ',', '.');
$pEmpresa  = number_format($plans['empresa']['price']  ?? 35000, 0, ',', '.');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CajaYa — El POS de Elite para Minimarkets</title>
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

        /* INTRO MASTER (MANTENIDA) */
        #preloader { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #000; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 10000; transition: opacity 1.2s ease; }
        .preloader-content { text-align: center; position: relative; }
        .preloader-logo { width: 180px; position: relative; z-index: 10; margin-bottom: 40px; }
        .loader-bar-wrap { width: 220px; height: 4px; background: rgba(255,255,255,0.1); border-radius: 20px; overflow: hidden; }
        .loader-bar-fill { width: 0%; height: 100%; background: linear-gradient(90deg, var(--brand-purple), var(--brand-glow)); box-shadow: 0 0 15px var(--brand-glow); animation: fillLoader 2.5s forwards cubic-bezier(0.65, 0, 0.35, 1); }
        @keyframes fillLoader { to { width: 100%; } }

        /* Header */
        .top-banner { background: var(--brand-purple); color: #fff; text-align: center; padding: 10px; font-weight: 800; font-size: 11px; letter-spacing: 2px; position: fixed; top: 0; width: 100%; z-index: 9000; text-transform: uppercase; }
        nav { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(40px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 75px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 36px; z-index: 8000; }
        .nav-content { width: 1400px; display: flex; justify-content: space-between; align-items: center; padding: 0 50px; }
        .nav-logo img { height: 42px; }

        /* Hero MASTER (Ajustado) */
        .hero { position: relative; width: 100%; height: 85vh; background: #000; overflow: hidden; z-index: 1000; margin-top: 111px; }
        .hero-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
        .hero-bg img { width: 100%; height: 100%; object-fit: cover; object-position: 85% center; filter: brightness(0.65); animation: kenBurns 35s infinite alternate ease-in-out; }
        @keyframes kenBurns { 0% { transform: scale(1); } 100% { transform: scale(1.15) translateX(-20px); } }
        .hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2; background: linear-gradient(90deg, #000 0%, #000 35%, rgba(0,0,0,0.3) 70%, transparent 100%); }
        .hero-content { position: relative; z-index: 10; width: 1300px; margin: 0 auto; padding: 120px 80px; color: #fff; }
        .hero-content h1 { font-size: clamp(2.2rem, 6vw, 4.2rem); font-weight: 800; line-height: 1.1; margin-bottom: 25px; }
        .hero-content p { font-size: 1.3rem; opacity: 0.9; margin-bottom: 50px; max-width: 600px; line-height: 1.6; }

        .btn-brand { background: var(--brand-purple); color: white; padding: 18px 45px; border-radius: 14px; font-size: 19px; font-weight: 700; text-decoration: none; display: inline-block; transition: 0.4s; }

        /* Pricing con ANIMACIÓN DE BRILLO (RESTAURADO) */
        .pricing { padding: 120px 5%; background: #fff; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px; max-width: 1300px; margin: 0 auto; }
        .p-card { 
            background: #fff; padding: 60px 45px; border-radius: 35px; border: 2px solid #f0f0f0; 
            transition: var(--transition); cursor: pointer; position: relative; overflow: hidden; 
        }
        .p-card:hover { transform: translateY(-10px); border-color: var(--brand-purple); box-shadow: 0 0 30px rgba(106, 27, 154, 0.2); }
        /* Animación Neón que tanto te gustó */
        .p-card::after { 
            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; 
            background: conic-gradient(transparent, var(--brand-purple), transparent 30%); 
            animation: rotateB 5s linear infinite; opacity: 0; transition: 0.3s; z-index: -1; 
        }
        .p-card:hover::after { opacity: 0.2; }
        @keyframes rotateB { 100% { transform: rotate(360deg); } }
        .p-card.selected { border: 3px solid var(--brand-purple); background: #faf8ff; box-shadow: 0 0 40px rgba(106, 27, 154, 0.3); }

        .p-price { font-size: 50px; font-weight: 800; margin-bottom: 35px; }
        .p-price span { font-size: 18px; color: #888; font-weight: 400; }

        /* FAQ (RESTAURADO) */
        .faq { padding: 120px 10%; background: #fdfdfd; }
        .faq-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 40px; max-width: 1200px; margin: 60px auto 0; }
        .faq-item { background: #fff; padding: 40px; border-radius: 30px; border: 1px solid #f2f2f2; }

        /* Footer Robusto */
        .footer { background: #000; color: #fff; padding: 120px 10% 80px; }
        .f-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 80px; margin-bottom: 80px; }

        .reveal { opacity: 0; transform: translateY(40px); transition: 1s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* Responsive corregido sin borrar nada */
        @media (max-width: 768px) {
            .hero-content { padding: 60px 20px; text-align: center; }
            .hero-overlay { background: linear-gradient(0deg, #000 30%, rgba(0,0,0,0.5) 100%); }
            .p-grid { grid-template-columns: 1fr; }
            .f-grid { grid-template-columns: 1fr; text-align: center; }
            .nav-content { padding: 0 20px; }
        }
    </style>
</head>
<body>

    <div id="preloader">
        <div class="preloader-content">
            <div class="logo-aura"></div>
            <img src="assets/img/logo.png" class="preloader-logo" alt="CajaYa">
            <div class="loader-bar-wrap"><div class="loader-bar-fill"></div></div>
        </div>
    </div>

    <div class="top-banner">🚀 LIDERAZGO COMERCIAL EN TODO CHILE — INTEGRACIÓN SII 2026 🚀</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="nav-logo"><img src="assets/img/logo.png" alt="CajaYa"></a>
            <div style="font-weight:800; font-size:11px; color:var(--brand-purple); letter-spacing:3px;">Ecosistema de Éxito</div>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-bg"><img src="banner1.png"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Tu Negocio Merece<br>Vender con Elegancia.</h1>
            <p>El estándar tecnológico que transforma tu minimarket. Control absoluto, rapidez extrema y cumplimiento SII garantizado.</p>
            <a href="#planes" class="btn-brand">Ver Planes de Inversión</a>
        </div>
    </div>

    <section class="pricing" id="planes">
        <div class="p-grid">
            <div class="p-card reveal" onclick="selectPlan(this)">
                <h4 style="font-size:14px; letter-spacing:3px; color:var(--brand-purple); font-weight:800; margin-bottom:25px; text-transform:uppercase;">PLAN MENSUAL</h4>
                <div class="p-price">$<?php echo $pMensual; ?><span>/mes</span></div>
                <ul style="list-style:none; line-height:2.4; font-size:16px;">
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> 1 Punto de Venta Full</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Boletas SII Instantáneas</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Soporte VIP WhatsApp</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" style="background:#f8f9fa; color:#000; text-align:center; padding:18px; border-radius:15px; font-weight:700; text-decoration:none; display:block; margin-top:40px; border:1px solid #eee;">Seleccionar</a>
            </div>
            <div class="p-card selected reveal" onclick="selectPlan(this)">
                <h4 style="font-size:14px; letter-spacing:3px; color:var(--brand-purple); font-weight:800; margin-bottom:25px; text-transform:uppercase;">PLAN LIFETIME</h4>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:12px; color:#888; margin-top:-30px; margin-bottom:30px; font-weight:800;">LICENCIA ETERNA. PAGO ÚNICO.</p>
                <ul style="list-style:none; line-height:2.4; font-size:16px;">
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> 3 Puntos de Venta Full</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Boleta y Factura SII</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Actualizaciones Eternas</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" style="background:var(--brand-purple); color:#fff; text-align:center; padding:18px; border-radius:15px; font-weight:700; text-decoration:none; display:block; margin-top:40px;">Comprar Licencia</a>
            </div>
            <div class="p-card reveal" onclick="selectPlan(this)">
                <h4 style="font-size:14px; letter-spacing:3px; color:var(--brand-purple); font-weight:800; margin-bottom:25px; text-transform:uppercase;">PLAN EMPRESA</h4>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul style="list-style:none; line-height:2.4; font-size:16px;">
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
                <p style="opacity:0.5;">Digitalizando el corazón del comercio chileno con tecnología robusta y certificada.</p>
            </div>
            <div class="f-col">
                <h4>Producto</h4>
                <a href="#">Motor SII</a>
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
        <div style="text-align:center; opacity:0.1; font-size:12px;">&copy; 2026 CajaYa S.A. Hecho en Chile.</div>
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
