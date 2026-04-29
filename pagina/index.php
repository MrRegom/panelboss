<?php
/**
 * index.php — Landing Page CAJAYA MASTER ELITE (PERFECT ALIGNMENT & NEON LOADING)
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
    <title>CajaYa — El Ecosistema POS Más Avanzado de Chile</title>
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
        body { background: var(--white); color: #1d1d1f; font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; }

        /* INTRO CON BARRA NEÓN */
        #preloader { 
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: #000; display: flex; flex-direction: column; 
            align-items: center; justify-content: center; z-index: 10000; 
            transition: opacity 1.2s ease; 
        }
        .preloader-content { text-align: center; position: relative; }
        .preloader-logo { width: 180px; position: relative; z-index: 10; margin-bottom: 40px; }
        .logo-aura { 
            position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%); 
            width: 250px; height: 250px; background: radial-gradient(circle, var(--brand-purple) 0%, transparent 70%); 
            opacity: 0.5; filter: blur(40px); animation: auraPulse 2s infinite alternate; 
        }
        @keyframes auraPulse { from { opacity: 0.3; transform: translate(-50%, -50%) scale(0.8); } to { opacity: 0.6; transform: translate(-50%, -50%) scale(1.2); } }

        /* Barra de Carga Espectacular */
        .loader-bar-wrap { width: 220px; height: 4px; background: rgba(255,255,255,0.1); border-radius: 20px; overflow: hidden; position: relative; }
        .loader-bar-fill { 
            width: 0%; height: 100%; background: linear-gradient(90deg, var(--brand-purple), var(--brand-glow)); 
            box-shadow: 0 0 15px var(--brand-glow); animation: fillLoader 2.5s forwards cubic-bezier(0.65, 0, 0.35, 1); 
        }
        @keyframes fillLoader { to { width: 100%; } }

        /* Navigation */
        .top-banner { background: var(--brand-purple); color: #fff; text-align: center; padding: 10px; font-weight: 800; font-size: 11px; letter-spacing: 2.5px; position: fixed; top: 0; width: 100%; z-index: 9000; text-transform: uppercase; }
        nav { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(40px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 75px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 36px; z-index: 8000; }
        .nav-content { width: 1400px; display: flex; justify-content: space-between; align-items: center; padding: 0 50px; }
        .nav-logo img { height: 42px; }

        /* Hero Elite (PERFECT ALIGNMENT) */
        .hero { position: relative; width: 100%; height: 85vh; background: #000; overflow: hidden; z-index: 1000; margin-top: 111px; }
        .hero-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
        .hero-bg img { 
            width: 100%; height: 100%; object-fit: cover; 
            object-position: 85% center; /* Alineación mejorada para mostrar el local sin errores */
            filter: brightness(0.65); 
            animation: kenBurns 35s infinite alternate ease-in-out; 
        }
        @keyframes kenBurns { 0% { transform: scale(1); } 100% { transform: scale(1.15) translateX(-20px); } }
        
        .hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2; background: linear-gradient(90deg, #000 0%, #000 40%, rgba(0,0,0,0.3) 70%, transparent 100%); }
        .hero-content { position: relative; z-index: 10; width: 1300px; margin: 0 auto; padding: 120px 80px; color: #fff; }
        .hero-content h1 { font-size: clamp(2.4rem, 6vw, 4.2rem); font-weight: 800; line-height: 1.1; margin-bottom: 25px; letter-spacing: -0.04em; }
        .hero-content p { font-size: 1.3rem; opacity: 0.9; margin-bottom: 50px; max-width: 600px; line-height: 1.6; }

        .btn-brand { background: var(--brand-purple); color: white; padding: 18px 45px; border-radius: 14px; font-size: 19px; font-weight: 700; text-decoration: none; display: inline-block; transition: 0.4s; }
        .btn-brand:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(106, 27, 154, 0.4); }

        /* Pricing (STUNNING ANIMATIONS) */
        .pricing { padding: 120px 5%; background: #fff; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px; max-width: 1300px; margin: 0 auto; }
        .p-card { 
            background: #fff; padding: 60px 45px; border-radius: 35px; border: 2px solid #f0f0f0; 
            transition: var(--transition); cursor: pointer; position: relative; overflow: hidden; 
        }
        .p-card:hover { transform: translateY(-10px); border-color: var(--brand-purple); box-shadow: 0 0 30px rgba(106, 27, 154, 0.2); }
        .p-card::after { 
            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; 
            background: conic-gradient(transparent, var(--brand-purple), transparent 30%); 
            animation: rotateB 5s linear infinite; opacity: 0; transition: 0.3s; z-index: -1; 
        }
        .p-card:hover::after { opacity: 0.2; }
        @keyframes rotateB { 100% { transform: rotate(360deg); } }
        .p-card.selected { border: 3px solid var(--brand-purple); background: #faf8ff; box-shadow: 0 0 40px rgba(106, 27, 154, 0.3); }
        
        .p-card h4 { font-size: 14px; letter-spacing: 3px; color: var(--brand-purple); font-weight: 800; margin-bottom: 25px; text-transform: uppercase; }
        .p-price { font-size: 50px; font-weight: 800; margin-bottom: 35px; letter-spacing: -2px; }
        .p-price span { font-size: 18px; color: #888; font-weight: 400; }
        .btn-p { width: 100%; text-align: center; padding: 18px; border-radius: 15px; font-weight: 700; text-decoration: none; display: block; transition: 0.3s; margin-top: 40px; }
        .btn-p.outline { background: #f8f9fa; color: #000; border: 1px solid #eee; }
        .btn-p.solid { background: var(--brand-purple); color: #fff; }

        /* FAQ */
        .faq { padding: 120px 10%; background: #fdfdfd; }
        .faq-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 40px; max-width: 1200px; margin: 60px auto 0; }
        .faq-item { background: #fff; padding: 40px; border-radius: 30px; border: 1px solid #f2f2f2; }

        /* FOOTER ROBUSTO */
        .footer { background: #000; color: #fff; padding: 120px 10% 80px; }
        .f-container { max-width: 1300px; margin: 0 auto; }
        .f-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 80px; margin-bottom: 100px; }
        .f-col h4 { font-size: 14px; font-weight: 800; color: rgba(255,255,255,0.25); margin-bottom: 35px; text-transform: uppercase; letter-spacing: 2px; }
        .f-col p { color: rgba(255,255,255,0.5); line-height: 1.8; margin-bottom: 25px; }
        .f-col a { color: rgba(255,255,255,0.7); text-decoration: none; display: block; margin-bottom: 18px; transition: 0.3s; }
        .f-col a:hover { color: var(--brand-purple); padding-left: 8px; }
        .f-socials { display: flex; gap: 20px; }
        .f-socials a { font-size: 20px; color: #fff; opacity: 0.5; transition: 0.3s; }
        .f-socials a:hover { opacity: 1; color: var(--brand-purple); }

        .reveal { opacity: 0; transform: translateY(40px); transition: 1s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>

    <div id="preloader">
        <div class="preloader-content">
            <div class="logo-aura"></div>
            <img src="assets/img/logo.png" class="preloader-logo" alt="CajaYa Official">
            <div class="loader-bar-wrap">
                <div class="loader-bar-fill"></div>
            </div>
            <p style="color:#fff; margin-top:25px; letter-spacing:4px; font-size:9px; opacity:0.4; font-weight:800;">INICIANDO SISTEMA POS ELITE</p>
        </div>
    </div>

    <div class="top-banner">🚀 LIDERAZGO COMERCIAL EN TODO CHILE — INTEGRACIÓN SII 2026 🚀</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="nav-logo"><img src="assets/img/logo.png" alt="CajaYa Logo"></a>
            <div style="font-weight:800; font-size:11px; color:var(--brand-purple); letter-spacing:3px; text-transform:uppercase;">Ecosistema de Éxito</div>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-bg"><img src="banner1.png" alt="Minimarket Vanguarda"></div>
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
                <h4>PLAN MENSUAL</h4>
                <div class="p-price">$<?php echo $pMensual; ?><span>/mes</span></div>
                <ul style="list-style:none; line-height:2.4; font-size:16px;">
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> 1 Punto de Venta Full</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Boletas SII Instantáneas</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Soporte VIP WhatsApp</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-p outline">Seleccionar</a>
            </div>
            <div class="p-card featured reveal" onclick="selectPlan(this)">
                <h4>PLAN LIFETIME</h4>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:12px; color:#888; margin-top:-30px; margin-bottom:30px; font-weight:800;">LICENCIA ETERNA. PAGO ÚNICO.</p>
                <ul style="list-style:none; line-height:2.4; font-size:16px;">
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> 3 Puntos de Venta Full</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Boleta y Factura SII</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Actualizaciones Eternas</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-p solid">Comprar Licencia</a>
            </div>
            <div class="p-card reveal" onclick="selectPlan(this)">
                <h4>PLAN EMPRESA</h4>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul style="list-style:none; line-height:2.4; font-size:16px;">
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Cajas Ilimitadas</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Gestión Multi-Sucursal</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:12px;"></i> Soporte 24/7 Crítico</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-p outline">Contactar</a>
            </div>
        </div>
    </section>

    <section class="faq">
        <h2 style="text-align:center; font-size:45px; font-weight:800; margin-bottom:80px;" class="reveal">Preguntas Frecuentes</h2>
        <div class="faq-grid">
            <div class="faq-item reveal">
                <h4>¿La activación es inmediata?</h4>
                <p>Absolutamente. Al procesar tu pago, recibirás de forma automática tus credenciales y el manual de bienvenida en tu correo.</p>
            </div>
            <div class="faq-item reveal">
                <h4>¿Qué pasa si no tengo señal?</h4>
                <p>CajaYa es Offline-First. Sigue vendiendo sin pausas; los datos se subirán al SII automáticamente cuando se restablezca la conexión.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="f-container">
            <div class="f-grid">
                <div class="f-col">
                    <img src="assets/img/logo.png" style="height:50px; margin-bottom:30px; filter:brightness(0) invert(1);" alt="CajaYa Logo">
                    <p>Digitalizando el corazón del comercio chileno con tecnología robusta, elegante y certificada.</p>
                    <div class="f-socials">
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    </div>
                </div>
                <div class="f-col">
                    <h4>Ecosistema</h4>
                    <a href="#">Motor de Ventas</a>
                    <a href="#">Gestión de Stock</a>
                </div>
                <div class="f-col">
                    <h4>Legal</h4>
                    <a href="#">Privacidad</a>
                    <a href="#">Términos</a>
                </div>
                <div class="f-col">
                    <h4>Soporte</h4>
                    <a href="#"><i class="fa-solid fa-envelope"></i> ventas@cajaya.cl</a>
                    <a href="#"><i class="fa-solid fa-phone"></i> +56 9 1234 5678</a>
                </div>
            </div>
            <div class="f-bottom">
                &copy; 2026 CajaYa S.A. Hecho con Ingeniería Superior en Chile.
            </div>
        </div>
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
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>
</html>
