<?php
/**
 * index.php — Landing Page CAJAYA ELITE FINAL (VIBRANT TECH EDITION)
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

        /* INTRO ÉPICA */
        #preloader { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #000; display: flex; align-items: center; justify-content: center; z-index: 10000; transition: opacity 1s, visibility 1s; }
        .preloader-content { display: flex; flex-direction: column; align-items: center; }
        .preloader-logo { width: 200px; margin-bottom: 40px; animation: glowLogo 2s infinite alternate; }
        @keyframes glowLogo { from { filter: drop-shadow(0 0 5px var(--brand-glow)); } to { filter: drop-shadow(0 0 25px var(--brand-glow)); } }
        .loader-bar-wrap { width: 250px; height: 3px; background: rgba(255,255,255,0.1); border-radius: 10px; overflow: hidden; }
        .loader-bar-fill { width: 0%; height: 100%; background: var(--brand-purple); animation: fillLoader 3s forwards; box-shadow: 0 0 15px var(--brand-glow); }
        @keyframes fillLoader { to { width: 100%; } }

        /* Header */
        .top-banner { background: var(--brand-purple); color: #fff; text-align: center; padding: 8px; font-weight: 800; font-size: 10px; letter-spacing: 2px; position: fixed; top: 0; width: 100%; z-index: 9000; }
        nav { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(25px); height: 70px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 30px; z-index: 8000; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .nav-content { width: 100%; max-width: 1400px; display: flex; justify-content: space-between; align-items: center; padding: 0 5%; }
        .nav-logo img { height: 35px; }

        /* Hero VIBRANTE & TECNOLÓGICO */
        .hero { position: relative; width: 100%; height: 95vh; background: #000; overflow: hidden; z-index: 1000; margin-top: 100px; }
        .hero-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
        /* IMAGEN VIVA Y TECNOLOGICA (BRIGHT & TECH) */
        .hero-bg img { 
            width: 100%; height: 100%; object-fit: cover; 
            filter: brightness(0.7) contrast(1.1); animation: kenBurns 40s infinite alternate; 
        }
        @keyframes kenBurns { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }
        
        /* OVERLAY MORADO VIBRANTE */
        .hero-overlay { 
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2; 
            background: linear-gradient(90deg, rgba(0,0,0,0.9) 0%, rgba(106,27,154,0.3) 50%, transparent 100%); 
        }
        
        .hero-content { position: relative; z-index: 10; width: 100%; max-width: 1400px; margin: 0 auto; height: 100%; display: flex; flex-direction: column; justify-content: center; color: #fff; padding: 0 8%; }
        .hero-content h1 { font-size: clamp(2.8rem, 6.5vw, 5rem); font-weight: 800; line-height: 1; margin-bottom: 25px; text-shadow: 0 5px 20px rgba(0,0,0,0.5); }
        .hero-content p { font-size: clamp(1.1rem, 2vw, 1.5rem); opacity: 0.95; margin-bottom: 50px; max-width: 650px; line-height: 1.6; text-shadow: 0 2px 10px rgba(0,0,0,0.3); }
        
        .btn-hero { 
            background: var(--brand-purple); color: #fff; padding: 22px 55px; border-radius: 15px; 
            font-size: 22px; font-weight: 800; text-decoration: none; transition: 0.3s; 
            box-shadow: 0 20px 50px rgba(106, 27, 154, 0.5); border: 2px solid rgba(255,255,255,0.2);
            display: inline-block; width: fit-content; text-transform: uppercase; letter-spacing: 1px;
        }
        .btn-hero:hover { transform: translateY(-7px) scale(1.02); background: var(--brand-glow); border-color: #fff; box-shadow: 0 25px 60px rgba(106, 27, 154, 0.7); }

        /* Pricing */
        .pricing { padding: 120px 5%; background: #fff; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 40px; max-width: 1350px; margin: 0 auto; }
        .p-card { background: #fff; padding: 60px 45px; border-radius: 40px; border: 2px solid #f2f2f2; transition: var(--transition); cursor: pointer; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
        .p-card.selected { border: 3px solid var(--brand-purple); background: #faf8ff; transform: scale(1.02); box-shadow: 0 20px 50px rgba(106,27,154,0.1); }
        .p-price { font-size: 55px; font-weight: 800; margin-bottom: 40px; color: #000; }

        /* FAQ */
        .faq { padding: 120px 10%; background: #fdfdfd; }
        .faq-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 40px; max-width: 1200px; margin-top: 60px; }
        .faq-item { background: #fff; padding: 45px; border-radius: 35px; border: 1px solid #f2f2f2; }

        /* Footer */
        .footer { background: #000; color: #fff; padding: 120px 10% 60px; }
        .f-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 80px; max-width: 1400px; margin: 0 auto; }
        .f-col h4 { font-size: 13px; color: rgba(255,255,255,0.4); margin-bottom: 30px; letter-spacing: 2px; text-transform: uppercase; font-weight: 800; }
        .f-col a { color: rgba(255,255,255,0.7); text-decoration: none; display: block; margin-bottom: 15px; font-size: 15px; transition: 0.3s; }
        .f-col a:hover { color: var(--brand-glow); padding-left: 5px; }

        .reveal { opacity: 0; transform: translateY(50px); transition: 1.2s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 768px) {
            .hero { height: 90vh; margin-top: 0; }
            .hero-overlay { background: linear-gradient(0deg, #000 35%, rgba(106,27,154,0.4) 100%); }
            .hero-content { padding: 0 10%; text-align: center; align-items: center; }
            .hero-content h1 { font-size: 2.6rem; margin-top: 80px; }
            .btn-hero { padding: 18px 40px; font-size: 18px; }
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
            <div class="nav-elite-text" style="font-weight:800; font-size:11px; color:var(--brand-purple); letter-spacing:3px;">TECNOLOGÍA DE VANGUARDIA</div>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-bg">
            <!-- IMAGEN VIBRANTE, LIMPIA Y TECNOLOGICA -->
            <img src="https://images.unsplash.com/photo-1556740758-90de374c12ad?q=80&w=2070&auto=format&fit=crop" alt="Retail Tech Revolution">
        </div>
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

    <footer class="footer">
        <div class="f-grid">
            <div class="f-col">
                <img src="assets/img/logo.png" style="height:50px; margin-bottom:30px; filter:brightness(0) invert(1);">
                <p style="opacity:0.6; font-size:15px; line-height:1.7;">La plataforma de gestión comercial líder para minimarkets y retail en Chile.</p>
            </div>
            <div class="f-col">
                <h4>Ecosistema</h4>
                <a href="#">Panel Boss</a>
                <a href="#">CajaYa App</a>
                <a href="#">ServiRec</a>
            </div>
            <div class="f-col">
                <h4>Legal</h4>
                <a href="#">Términos de Uso</a>
                <a href="#">Privacidad</a>
            </div>
            <div class="f-col">
                <h4>Empresa</h4>
                <a href="#">Sobre Nosotros</a>
                <a href="#">ventas@cajaya.cl</a>
            </div>
        </div>
        <div style="text-align:center; opacity:0.1; font-size:12px; margin-top:80px;">&copy; 2026 CajaYa S.A. Digitalizando el futuro.</div>
    </footer>

    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const p = document.getElementById('preloader');
                p.style.opacity = '0';
                setTimeout(() => p.style.display = 'none', 1200);
            }, 2800);
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
