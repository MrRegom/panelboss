<?php
/**
 * index.php — Landing Page ULTRA PRO (VERSION BRAND IDENTITY)
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
    <title>CajaYa — El Estándar Maestro en Gestión de Ventas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0071E3;
            --accent: #34C759;
            --brand-purple: #6A1B9A;
            --brand-blue: #2962FF;
            --dark: #000000;
            --gray: #86868B;
            --light: #F5F5F7;
            --white: #FFFFFF;
            --transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--white); color: var(--dark); font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; overflow-x: hidden; }

        /* PRELOADER */
        #preloader { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #000; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 10000; transition: opacity 1s ease-in-out; }
        #preloader .logo-p { font-size: 50px; font-weight: 800; color: #fff; margin-bottom: 20px; animation: pulse 2s infinite; }
        #preloader .slogan { color: var(--gray); font-size: 14px; letter-spacing: 4px; text-transform: uppercase; }
        @keyframes pulse { 0% { opacity: 0.5; transform: scale(0.95); } 50% { opacity: 1; transform: scale(1); } 100% { opacity: 0.5; transform: scale(0.95); } }

        /* Global Header Fixes */
        .test-banner { background: #FF9F0A; color: #000; text-align: center; padding: 8px; font-weight: 700; position: fixed; top: 0; width: 100%; z-index: 9000; font-size: 10px; letter-spacing: 1px; }
        nav { background: rgba(255, 255, 255, 0.85); backdrop-filter: saturate(180%) blur(20px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 60px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 32px; z-index: 8000; }
        .nav-content { width: 1200px; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; }
        .logo { font-weight: 800; font-size: 24px; text-decoration: none; color: var(--dark); }

        /* Hero Carousel (Z-index Fix) */
        .hero { position: relative; width: 100%; height: 90vh; background: var(--white); overflow: hidden; padding-top: 100px; z-index: 1000; }
        .slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1.2s ease; display: flex; align-items: center; justify-content: center; pointer-events: none; }
        .slide.active { opacity: 1; pointer-events: auto; }
        .slide-content { width: 1200px; display: flex; align-items: center; justify-content: space-between; padding: 0 60px; }
        .slide-text { flex: 1; max-width: 550px; z-index: 20; }
        .slide-img { flex: 1.3; display: flex; justify-content: flex-end; z-index: 10; }
        .slide-img img { width: 100%; max-width: 750px; filter: drop-shadow(0 30px 60px rgba(0,0,0,0.08)); transition: transform 1.5s var(--transition); }
        .active .slide-img img { transform: scale(1.02) translateX(-20px); }

        .slide h1 { font-size: clamp(2.5rem, 5.5vw, 4.5rem); font-weight: 800; line-height: 1.02; letter-spacing: -0.05em; color: var(--dark); margin-bottom: 24px; }
        .slide p { font-size: clamp(1.1rem, 1.5vw, 1.3rem); color: var(--gray); margin-bottom: 40px; font-weight: 400; line-height: 1.5; }
        .btn-apple { background: var(--primary); color: white; padding: 18px 40px; border-radius: 980px; font-size: 18px; font-weight: 600; text-decoration: none; display: inline-block; transition: 0.3s; }
        .btn-apple:hover { transform: scale(1.05); box-shadow: 0 20px 40px rgba(0,113,227,0.3); }

        /* Pricing Border Glow Effect */
        .pricing { background: var(--light); padding: 140px 5%; border-radius: 60px 60px 0 0; margin-top: -60px; position: relative; z-index: 2000; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto; }
        .p-card { background: white; padding: 60px 40px; border-radius: 35px; position: relative; transition: var(--transition); border: 2px solid transparent; overflow: hidden; cursor: pointer; }
        .p-card:hover { transform: translateY(-15px); box-shadow: 0 40px 80px rgba(0,0,0,0.08); border-color: var(--brand-purple); }
        .p-card.selected { border-color: var(--brand-blue); box-shadow: 0 0 20px rgba(41, 98, 255, 0.2); }
        
        .p-card::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: conic-gradient(transparent, var(--brand-purple), transparent 30%); animation: rotate 6s linear infinite; opacity: 0; transition: 0.3s; pointer-events: none; }
        .p-card:hover::before { opacity: 0.2; }
        @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        .p-price { font-size: 58px; font-weight: 800; margin: 30px 0; letter-spacing: -3px; }
        .p-features { list-style: none; margin: 30px 0; text-align: left; }
        .p-features li { padding: 12px 0; border-bottom: 1px solid rgba(0,0,0,0.04); display: flex; align-items: center; gap: 12px; color: var(--gray); font-size: 15px; }

        /* Modern FAQ */
        .faq { padding: 120px 10%; background: #fff; }
        .faq-grid { max-width: 1000px; margin: 60px auto 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 40px; }
        .faq-item { background: var(--light); padding: 40px; border-radius: 25px; transition: 0.3s; }
        .faq-item:hover { background: #eee; }
        .faq-item h4 { font-size: 20px; font-weight: 700; margin-bottom: 15px; display: flex; align-items: center; gap: 15px; }
        .faq-item h4::before { content: '?'; background: var(--brand-purple); color: #fff; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; }

        /* Purple Footer Contrast */
        .footer { background: #000; color: #fff; padding: 120px 10% 60px; }
        .f-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 60px; max-width: 1200px; margin: 0 auto; }
        .f-col h4 { font-size: 14px; font-weight: 700; color: var(--brand-purple); margin-bottom: 30px; text-transform: uppercase; letter-spacing: 2px; }
        .f-col a { color: rgba(255,255,255,0.6); text-decoration: none; font-size: 15px; transition: 0.2s; }
        .f-col a:hover { color: #fff; text-decoration: underline; }
        
        .f-bottom { max-width: 1200px; margin: 80px auto 0; padding-top: 40px; border-top: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: rgba(255,255,255,0.4); }

        .reveal { opacity: 0; transform: translateY(40px); transition: 1s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 900px) {
            .slide-content { flex-direction: column; text-align: center; }
            .slide-text { order: 2; margin-top: 50px; }
            .slide-img { order: 1; }
            .faq-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div id="preloader">
        <div class="logo-p">CajaYa<span style="color:var(--brand-purple)">.</span></div>
        <div class="slogan">Potencia Maestra en Ventas</div>
    </div>

    <div class="test-banner">⚠️ INTEGRACIÓN SII 2026 CERTIFICADA - MODO COMERCIAL ACTIVO ⚠️</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="logo">CajaYa<span style="color:var(--brand-purple)">.</span></a>
            <div style="font-weight:700; font-size:11px; letter-spacing:1px; color:var(--brand-purple)">SISTEMA DE FACTURACIÓN PROFESIONAL</div>
        </div>
    </nav>

    <div class="hero">
        <div class="c-container">
            <div class="slide active">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1 style="color:var(--brand-purple)">CajaYa Pro</h1>
                        <h1>La App que Tu<br>Negocio Estaba Esperando.</h1>
                        <p>Diseñada en Chile para el mundo real. Control de ventas, inventario y facturación SII en la palma de tu mano.</p>
                        <a href="#planes" class="btn-apple" style="background:var(--brand-purple)">Ver Planes</a>
                    </div>
                    <div class="slide-img">
                        <img src="banner1.png" alt="CajaYa App Real">
                    </div>
                </div>
            </div>
            <div class="slide">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1 style="color:var(--brand-blue)">Control Total</h1>
                        <h1>Vende Sin Pausas,<br>Incluso Sin Internet.</h1>
                        <p>Nuestra tecnología local garantiza que tu caja nunca se detenga. Sincronización automática con el SII certificada.</p>
                        <a href="#planes" class="btn-apple" style="background:var(--brand-blue)">Empezar Ahora</a>
                    </div>
                    <div class="slide-img">
                        <img src="banner2.png" alt="CajaYa Dashboard">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="pricing" id="planes">
        <h2 style="font-size:48px; font-weight:800; text-align:center; margin-bottom:80px;" class="reveal">Inversión Inteligente</h2>
        <div class="p-grid">
            <div class="p-card reveal" onclick="this.classList.toggle('selected')">
                <h4 style="color:var(--brand-purple); font-size:12px; letter-spacing:2px;">PLAN MENSUAL</h4>
                <div class="p-price">$<?php echo $pMensual; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li>1 Punto de Venta Full</li>
                    <li>Boletas Electrónicas SII</li>
                    <li>Control de Stock</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-apple" style="width:100%; text-align:center; background:#eee; color:#000;">Seleccionar</a>
            </div>
            <div class="p-card reveal" onclick="this.classList.toggle('selected')">
                <h4 style="color:var(--brand-blue); font-size:12px; letter-spacing:2px;">PLAN LIFETIME</h4>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:11px; color:var(--gray); margin-top:-15px;">PAGO ÚNICO PARA SIEMPRE</p>
                <ul class="p-features">
                    <li>3 Puntos de Venta Full</li>
                    <li>Facturas y Boletas SII</li>
                    <li>Actualizaciones Eternas</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-apple" style="width:100%; text-align:center;">Comprar Ahora</a>
            </div>
            <div class="p-card reveal" onclick="this.classList.toggle('selected')">
                <h4 style="color:var(--brand-purple); font-size:12px; letter-spacing:2px;">PLAN EMPRESA</h4>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li>Terminales Ilimitados</li>
                    <li>Multi-sucursal en tiempo real</li>
                    <li>Soporte 24/7 Prioritario</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-apple" style="width:100%; text-align:center; background:#eee; color:#000;">Contactar</a>
            </div>
        </div>
    </section>

    <section class="faq">
        <h2 style="font-size:42px; font-weight:800; text-align:center;" class="reveal">Preguntas Frecuentes</h2>
        <div class="faq-grid">
            <div class="faq-item reveal">
                <h4>¿Es seguro mi pago?</h4>
                <p>Absolutamente. Utilizamos Mercado Pago para procesar todas las transacciones bajo los más altos estándares de seguridad bancaria.</p>
            </div>
            <div class="faq-item reveal">
                <h4>¿Cómo descargo la app?</h4>
                <p>Inmediatamente después del pago, recibirás un enlace de descarga oficial y tus credenciales de activación en tu correo.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="f-grid">
            <div class="f-col">
                <div class="logo" style="color:#fff; font-size:32px; margin-bottom:20px;">CajaYa<span style="color:var(--brand-purple)">.</span></div>
                <p style="color:rgba(255,255,255,0.4); line-height:1.6;">Liderando la tecnología de puntos de venta en Chile con ingeniería superior.</p>
            </div>
            <div class="f-col">
                <h4>Soluciones</h4>
                <ul>
                    <li><a href="#">Para Almacenes</a></li>
                    <li><a href="#">Para Restaurantes</a></li>
                    <li><a href="#">Facturación SII</a></li>
                </ul>
            </div>
            <div class="f-col">
                <h4>Empresa</h4>
                <ul>
                    <li><a href="#">Sobre Nosotros</a></li>
                    <li><a href="#">Términos de Uso</a></li>
                    <li><a href="#">Privacidad</a></li>
                </ul>
            </div>
        </div>
        <div class="f-bottom">
            <p>&copy; 2026 CajaYa Technologies S.A.</p>
            <p>Slogan: "Simplicidad que Potencia tu Éxito"</p>
        </div>
    </footer>

    <script>
        // PRELOADER
        window.addEventListener('load', () => {
            setTimeout(() => {
                const preloader = document.getElementById('preloader');
                preloader.style.opacity = '0';
                setTimeout(() => preloader.style.display = 'none', 1000);
            }, 1500);
        });

        // Carousel Logic
        let cCur = 0;
        const slides = document.querySelectorAll('.slide');
        function cGo(n) {
            slides[cCur].classList.remove('active');
            cCur = (n + slides.length) % slides.length;
            slides[cCur].classList.add('active');
        }
        setInterval(() => cGo(cCur + 1), 6000);

        // Reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>
</html>
