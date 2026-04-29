<?php
/**
 * index.php — Landing Page CAJAYA ELITE FULLY RESPONSIVE (DB FIXED & MOBILE READY)
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
    <title>CajaYa — El POS Nº1 de Chile (Elite Experience)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
        body { background: var(--white); color: #1d1d1f; font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; overflow-x: hidden; width: 100%; }

        /* INTRO MANTENIDA */
        #preloader { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #000; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 10000; transition: opacity 1.2s ease; }
        .preloader-content { text-align: center; position: relative; }
        .preloader-logo { width: 180px; position: relative; z-index: 10; margin-bottom: 40px; }
        .loader-bar-wrap { width: 220px; height: 4px; background: rgba(255,255,255,0.1); border-radius: 20px; overflow: hidden; }
        .loader-bar-fill { width: 0%; height: 100%; background: linear-gradient(90deg, var(--brand-purple), var(--brand-glow)); box-shadow: 0 0 15px var(--brand-glow); animation: fillLoader 2.5s forwards cubic-bezier(0.65, 0, 0.35, 1); }
        @keyframes fillLoader { to { width: 100%; } }

        /* Header Responsive */
        .top-banner { background: var(--brand-purple); color: #fff; text-align: center; padding: 10px; font-weight: 800; font-size: 10px; letter-spacing: 1.5px; position: fixed; top: 0; width: 100%; z-index: 9000; text-transform: uppercase; }
        nav { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(40px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 70px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 35px; z-index: 8000; }
        .nav-content { width: 100%; max-width: 1400px; display: flex; justify-content: space-between; align-items: center; padding: 0 5%; }
        .nav-logo img { height: 38px; }

        /* Hero Responsive */
        .hero { position: relative; width: 100%; height: 90vh; min-height: 600px; background: #000; overflow: hidden; z-index: 1000; margin-top: 105px; }
        .hero-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
        .hero-bg img { width: 100%; height: 100%; object-fit: cover; object-position: center; filter: brightness(0.6); animation: kenBurns 40s infinite alternate linear; }
        @keyframes kenBurns { 0% { transform: scale(1); } 100% { transform: scale(1.2); } }
        
        .hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2; background: linear-gradient(0deg, #000 0%, rgba(0,0,0,0.4) 50%, transparent 100%), linear-gradient(90deg, #000 0%, rgba(0,0,0,0.7) 30%, transparent 100%); }
        .hero-content { position: relative; z-index: 10; width: 100%; max-width: 1300px; margin: 0 auto; padding: 10% 5%; color: #fff; }
        .hero-content h1 { font-size: clamp(2rem, 8vw, 4.2rem); font-weight: 800; line-height: 1.1; margin-bottom: 25px; max-width: 800px; }
        .hero-content p { font-size: clamp(1.1rem, 4vw, 1.3rem); opacity: 0.9; margin-bottom: 40px; max-width: 550px; line-height: 1.6; }

        /* Pricing Responsive */
        .pricing { padding: 100px 5%; background: #fff; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; max-width: 1300px; margin: 0 auto; }
        .p-card { background: #fff; padding: 50px 35px; border-radius: 30px; border: 2px solid #f2f2f2; transition: var(--transition); cursor: pointer; position: relative; overflow: hidden; }
        .p-card:hover { transform: translateY(-10px); border-color: var(--brand-purple); box-shadow: 0 20px 50px rgba(106, 27, 154, 0.1); }
        .p-card.selected { border: 3px solid var(--brand-purple); background: #faf8ff; box-shadow: 0 0 40px rgba(106, 27, 154, 0.2); }
        .p-price { font-size: 45px; font-weight: 800; margin-bottom: 30px; }
        .p-price span { font-size: 16px; color: #888; font-weight: 400; }

        /* Footer Responsive */
        .footer { background: #000; color: #fff; padding: 100px 5% 50px; }
        .f-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 50px; max-width: 1300px; margin: 0 auto 80px; }

        .reveal { opacity: 0; transform: translateY(30px); transition: 1s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* MOBILE FIXES */
        @media (max-width: 768px) {
            nav { height: 60px; top: 30px; }
            .hero { margin-top: 90px; height: 80vh; }
            .hero-content { padding-top: 20%; text-align: center; display: flex; flex-direction: column; align-items: center; }
            .hero-overlay { background: linear-gradient(0deg, #000 20%, rgba(0,0,0,0.5) 100%); }
            .p-grid { grid-template-columns: 1fr; }
            .f-grid { text-align: center; }
            .f-socials { justify-content: center; }
        }
    </style>
</head>
<body>

    <div id="preloader">
        <div class="preloader-content">
            <img src="assets/img/logo.png" class="preloader-logo" alt="CajaYa Official">
            <div class="loader-bar-wrap"><div class="loader-bar-fill"></div></div>
        </div>
    </div>

    <div class="top-banner">🚀 VANGUARDIA POS EN CHILE — INTEGRACIÓN SII 2026 🚀</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="nav-logo"><img src="assets/img/logo.png" alt="CajaYa"></a>
            <div style="font-weight:800; font-size:10px; color:var(--brand-purple); letter-spacing:2px; text-transform:uppercase;" class="d-mobile-hide">Elite Experience</div>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-bg"><img src="banner1.png" alt="CajaYa Minimarket"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Tu Negocio Merece<br>Vender con Elegancia.</h1>
            <p>El estándar tecnológico que transforma tu minimarket. Control total, rapidez absoluta y cumplimiento SII garantizado.</p>
            <a href="#planes" class="btn-brand" style="text-align:center;">Explorar Planes de Éxito</a>
        </div>
    </div>

    <section class="pricing" id="planes">
        <div class="p-grid">
            <!-- Plan Mensual -->
            <div class="p-card reveal" onclick="selectPlan(this)">
                <h4 style="font-size:13px; color:var(--brand-purple); font-weight:800; margin-bottom:20px; letter-spacing:2px;">PLAN MENSUAL</h4>
                <div class="p-price">$<?php echo $pMensual; ?><span>/mes</span></div>
                <ul style="list-style:none; line-height:2.4; margin-bottom:30px;">
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> 1 Punto de Venta Full</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> Boletas SII Instantáneas</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> Soporte VIP WhatsApp</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" style="background:#f5f5f7; color:#000; text-align:center; padding:15px; border-radius:12px; display:block; text-decoration:none; font-weight:700;">Seleccionar</a>
            </div>
            <!-- Plan Lifetime -->
            <div class="p-card selected reveal" onclick="selectPlan(this)">
                <h4 style="font-size:13px; color:var(--brand-purple); font-weight:800; margin-bottom:20px; letter-spacing:2px;">PLAN LIFETIME</h4>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:11px; font-weight:800; color:#888; margin-top:-20px; margin-bottom:25px;">PAGO ÚNICO. PARA SIEMPRE.</p>
                <ul style="list-style:none; line-height:2.4; margin-bottom:30px;">
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> 3 Puntos de Venta Full</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> Boleta y Factura SII</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> Actualizaciones Eternas</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" style="background:var(--brand-purple); color:#fff; text-align:center; padding:15px; border-radius:12px; display:block; text-decoration:none; font-weight:700;">Comprar Licencia</a>
            </div>
            <!-- Plan Empresa -->
            <div class="p-card reveal" onclick="selectPlan(this)">
                <h4 style="font-size:13px; color:var(--brand-purple); font-weight:800; margin-bottom:20px; letter-spacing:2px;">PLAN EMPRESA</h4>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul style="list-style:none; line-height:2.4; margin-bottom:30px;">
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> Cajas Ilimitadas</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> Gestión Multi-Sucursal</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> Soporte 24/7 Crítico</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" style="background:#f5f5f7; color:#000; text-align:center; padding:15px; border-radius:12px; display:block; text-decoration:none; font-weight:700;">Contactar</a>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="f-grid">
            <div class="f-col">
                <img src="assets/img/logo.png" style="height:45px; margin-bottom:25px; filter:brightness(0) invert(1);">
                <p style="opacity:0.5; font-size:14px;">Liderando el comercio digital en Chile con tecnología de vanguardia.</p>
                <div class="f-socials" style="display:flex; gap:15px; margin-top:20px;">
                    <a href="#" style="color:#fff; opacity:0.6;"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" style="color:#fff; opacity:0.6;"><i class="fa-brands fa-facebook"></i></a>
                </div>
            </div>
            <div class="f-col">
                <h4 style="font-size:12px; opacity:0.3; margin-bottom:25px; letter-spacing:2px;">PRODUCTO</h4>
                <a href="#" style="color:#fff; text-decoration:none; display:block; margin-bottom:12px; opacity:0.7;">Tecnología SII</a>
                <a href="#" style="color:#fff; text-decoration:none; display:block; margin-bottom:12px; opacity:0.7;">Gestión Stock</a>
            </div>
            <div class="f-col">
                <h4 style="font-size:12px; opacity:0.3; margin-bottom:25px; letter-spacing:2px;">CONTACTO</h4>
                <p style="opacity:0.7; font-size:14px; margin-bottom:10px;">ventas@cajaya.cl</p>
                <p style="opacity:0.7; font-size:14px;">Santiago, Chile</p>
            </div>
        </div>
        <div style="text-align:center; opacity:0.1; font-size:12px; padding-top:50px; border-top:1px solid rgba(255,255,255,0.05);">
            &copy; 2026 CajaYa S.A. Hecho con Ingeniería Superior en Chile.
        </div>
    </footer>

    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const p = document.getElementById('preloader');
                p.style.opacity = '0';
                setTimeout(() => p.style.display = 'none', 1000);
            }, 2500);
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
