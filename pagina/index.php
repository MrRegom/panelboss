<?php
/**
 * index.php — Landing Page CAJAYA EXPERIENCE (IMPACT INTRO & KEN BURNS HERO)
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
    <title>CajaYa — Tecnología POS de Clase Mundial</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0071E3;
            --brand-purple: #6A1B9A;
            --brand-glow: #9C27B0;
            --dark: #000;
            --white: #FFF;
            --transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: var(--dark); color: #fff; font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; overflow-x: hidden; }

        /* PRELOADER IMPACTANTE */
        #preloader { 
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: #000; display: flex; flex-direction: column; 
            align-items: center; justify-content: center; z-index: 10000; 
            transition: transform 1.2s cubic-bezier(0.86, 0, 0.07, 1); 
        }
        .preloader-content { position: relative; text-align: center; }
        .preloader-logo { 
            width: 160px; filter: brightness(0) invert(1); 
            animation: logoScale 3s infinite ease-in-out;
            z-index: 10; position: relative;
        }
        .logo-glow {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
            width: 200px; height: 200px; background: radial-gradient(circle, var(--brand-glow) 0%, transparent 70%);
            opacity: 0.6; filter: blur(30px); animation: pulseGlow 2s infinite alternate;
        }
        @keyframes logoScale { 0%, 100% { transform: scale(1); filter: brightness(1) invert(1); } 50% { transform: scale(1.1); filter: brightness(1.5) invert(1) drop-shadow(0 0 20px var(--brand-glow)); } }
        @keyframes pulseGlow { from { transform: translate(-50%, -50%) scale(0.8); opacity: 0.3; } to { transform: translate(-50%, -50%) scale(1.3); opacity: 0.7; } }
        
        .loading-bar-container { width: 200px; height: 2px; background: rgba(255,255,255,0.1); margin-top: 40px; border-radius: 10px; overflow: hidden; }
        .loading-bar { width: 0%; height: 100%; background: var(--brand-purple); animation: load 2.5s forwards; }
        @keyframes load { to { width: 100%; } }

        /* Layout */
        .test-banner { background: #FF9F0A; color: #000; text-align: center; padding: 10px; font-weight: 800; position: fixed; top: 0; width: 100%; z-index: 9000; font-size: 11px; letter-spacing: 2px; }
        nav { background: rgba(0, 0, 0, 0.8); backdrop-filter: blur(50px); border-bottom: 1px solid rgba(255,255,255,0.05); height: 75px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 37px; z-index: 8000; transition: 0.5s; }
        .nav-content { width: 1400px; display: flex; justify-content: space-between; align-items: center; padding: 0 50px; }
        .nav-logo img { height: 40px; filter: brightness(0) invert(1); }

        /* Hero Ken Burns */
        .hero { position: relative; width: 100%; height: 90vh; background: #000; overflow: hidden; z-index: 1000; margin-top: 112px; }
        .hero-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
        .hero-bg img { 
            width: 100%; height: 100%; object-fit: cover; 
            filter: brightness(0.4);
            animation: kenBurns 20s infinite alternate ease-in-out;
        }
        @keyframes kenBurns { 0% { transform: scale(1); } 100% { transform: scale(1.15) translate(20px, 10px); } }
        
        .hero-overlay { 
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2; 
            background: linear-gradient(90deg, #000 0%, #000 35%, rgba(0,0,0,0.6) 60%, transparent 100%); 
        }

        .hero-content { position: relative; z-index: 10; width: 1200px; margin: 0 auto; padding: 120px 60px; }
        .hero-content h1 { font-size: clamp(2.5rem, 6.5vw, 4.8rem); font-weight: 800; line-height: 1.05; letter-spacing: -0.04em; margin-bottom: 30px; animation: slideUp 1s forwards 3s; opacity: 0; }
        .hero-content p { font-size: clamp(1.1rem, 2vw, 1.4rem); opacity: 0.8; margin-bottom: 50px; max-width: 650px; line-height: 1.6; animation: slideUp 1s forwards 3.3s; opacity: 0; }
        .btn-brand { background: var(--brand-purple); color: white; padding: 20px 55px; border-radius: 16px; font-size: 20px; font-weight: 700; text-decoration: none; display: inline-block; transition: 0.4s; animation: slideUp 1s forwards 3.6s; opacity: 0; }
        .btn-brand:hover { transform: translateY(-5px); box-shadow: 0 25px 50px rgba(106, 27, 154, 0.4); background: var(--brand-glow); }

        @keyframes slideUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }

        /* Planes Section */
        .pricing { background: #fff; color: #000; padding: 140px 5%; border-radius: 60px 60px 0 0; position: relative; z-index: 2000; margin-top: -60px; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 50px; max-width: 1400px; margin: 0 auto; }
        .p-card { background: #fff; padding: 70px 50px; border-radius: 40px; border: 1px solid #f0f0f0; transition: var(--transition); }
        .p-card:hover { transform: translateY(-15px); box-shadow: 0 60px 120px rgba(0,0,0,0.06); border-color: var(--brand-purple); }
        .p-card.featured { border: 3px solid var(--brand-purple); background: #fafafa; }
        
        .p-card h4 { font-size: 15px; letter-spacing: 3px; color: var(--brand-purple); font-weight: 800; margin-bottom: 30px; text-transform: uppercase; }
        .p-price { font-size: 54px; font-weight: 800; letter-spacing: -2px; margin-bottom: 40px; }
        .p-price span { font-size: 20px; color: #888; font-weight: 400; }

        .btn-p { width: 100%; text-align: center; padding: 20px; border-radius: 16px; font-weight: 800; text-decoration: none; display: block; transition: 0.3s; }
        .btn-p.outline { background: #f8f9fa; color: #000; }
        .btn-p.solid { background: var(--brand-purple); color: #fff; }

        /* Footer */
        .footer { background: #000; padding: 140px 10% 70px; }
        .f-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 100px; }
        .f-col h4 { font-size: 15px; font-weight: 800; color: rgba(255,255,255,0.3); margin-bottom: 40px; text-transform: uppercase; }
        .f-col a { color: rgba(255,255,255,0.6); text-decoration: none; display: block; margin-bottom: 20px; font-size: 17px; }

        @media (max-width: 768px) {
            .hero-content { padding: 80px 40px; }
            .p-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- INTRO ANIMATION -->
    <div id="preloader">
        <div class="preloader-content">
            <div class="logo-glow"></div>
            <img src="assets/img/logo.png" class="preloader-logo" alt="CajaYa Intro">
            <div class="loading-bar-container">
                <div class="loading-bar"></div>
            </div>
            <p style="margin-top:20px; letter-spacing:4px; font-size:10px; opacity:0.4; font-weight:800; text-transform:uppercase;">Iniciando Ecosistema Vanguarda</p>
        </div>
    </div>

    <div class="test-banner">🚀 EL POS Nº1 PARA MINIMARKETS EN CHILE — LIDERAZGO TECNOLÓGICO 2026 🚀</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="nav-logo"><img src="assets/img/logo.png" alt="CajaYa Official"></a>
            <div style="font-weight:800; font-size:11px; color:var(--brand-glow); letter-spacing:3px;">MINIMARKETS AL SIGUIENTE NIVEL</div>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-bg"><img src="banner1.png" alt="Minimarket Experience"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Tu Negocio Merece<br>Vender con Rapidez.</h1>
            <p>El estándar tecnológico para el minimarket moderno. Control total, cumplimiento SII y rapidez absoluta en cada transacción.</p>
            <a href="#planes" class="btn-brand">Explorar Planes de Éxito</a>
        </div>
    </div>

    <section class="pricing" id="planes">
        <div class="p-grid">
            <div class="p-card">
                <h4>PLAN MENSUAL</h4>
                <div class="p-price">$<?php echo $pMensual; ?><span>/mes</span></div>
                <ul style="list-style:none; margin-bottom:50px; font-size:17px; line-height:2.5;">
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple)"></i> 1 Punto de Venta Full</li>
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple)"></i> Boletas SII Instantáneas</li>
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple)"></i> Control de Stock 24/7</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-p outline">Elegir</a>
            </div>
            <div class="p-card featured">
                <h4>PLAN LIFETIME</h4>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:13px; color:#888; margin-top:-30px; margin-bottom:30px; font-weight:800;">LICENCIA DEFINITIVA. SIN PAGOS MENSUALES.</p>
                <ul style="list-style:none; margin-bottom:50px; font-size:17px; line-height:2.5;">
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple)"></i> 3 Puntos de Venta Full</li>
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple)"></i> Boleta y Factura SII</li>
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple)"></i> Actualizaciones Eternas</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-p solid">Comprar Ahora</a>
            </div>
            <div class="p-card">
                <h4>PLAN EMPRESA</h4>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul style="list-style:none; margin-bottom:50px; font-size:17px; line-height:2.5;">
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple)"></i> Terminales Ilimitados</li>
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple)"></i> Gestión Multi-Sucursal</li>
                    <li><i class="fa-solid fa-circle-check" style="color:var(--brand-purple)"></i> Soporte Crítico 24/7</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-p outline">Contactar</a>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="f-grid">
            <div class="f-col">
                <img src="assets/img/logo.png" style="height:50px; margin-bottom:40px; filter:brightness(0) invert(1);" alt="CajaYa Footer">
                <p style="opacity:0.4; line-height:2; font-size:17px;">Liderando el futuro comercial de Chile con tecnología robusta y elegante.</p>
            </div>
            <div class="f-col">
                <h4>Soluciones</h4>
                <a href="#">Sincronización SII</a>
                <a href="#planes">Licenciamiento</a>
            </div>
            <div class="f-col">
                <h4>Compañía</h4>
                <a href="#">Sobre CajaYa</a>
                <a href="#">Soporte</a>
            </div>
        </div>
        <div style="margin-top:100px; opacity:0.2; font-size:14px; text-align:center;">&copy; 2026 CajaYa S.A. Hecho con Ingeniería de Elite en Chile.</div>
    </footer>

    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const p = document.getElementById('preloader');
                p.style.transform = 'translateY(-100%)';
                setTimeout(() => p.style.display = 'none', 1200);
            }, 2500);
        });

        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.style.background = 'rgba(0,0,0,0.95)';
                nav.style.height = '65px';
            } else {
                nav.style.background = 'rgba(0,0,0,0.8)';
                nav.style.height = '75px';
            }
        });
    </script>
</body>
</html>
