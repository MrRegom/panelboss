<?php
/**
 * index.php — Landing Page ELITE (VERSION FINAL REFINADA)
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
    <title>CajaYa — Tecnología Maestra para tu Negocio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0071E3;
            --brand-purple: #6A1B9A;
            --brand-blue: #2962FF;
            --dark: #1D1D1F;
            --gray: #86868B;
            --light: #F5F5F7;
            --white: #FFFFFF;
            --transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--white); color: var(--dark); font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; overflow-x: hidden; }

        /* PRELOADER */
        #preloader { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #000; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 10000; transition: opacity 1s ease; }
        .preloader-logo { width: 120px; animation: pulse 2s infinite; filter: brightness(0) invert(1); }
        @keyframes pulse { 0% { opacity: 0.5; transform: scale(0.95); } 50% { opacity: 1; transform: scale(1); } 100% { opacity: 0.5; transform: scale(0.95); } }

        /* Header Fixes */
        .test-banner { background: #FF9F0A; color: #000; text-align: center; padding: 8px; font-weight: 700; position: fixed; top: 0; width: 100%; z-index: 9000; font-size: 10px; letter-spacing: 1px; }
        nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(25px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 70px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 32px; z-index: 8000; transition: 0.3s; }
        .nav-content { width: 1400px; display: flex; justify-content: space-between; align-items: center; padding: 0 40px; }
        .nav-logo img { height: 35px; }

        /* Hero Mercado Pago Style + Tranquil Animations */
        .hero { position: relative; width: 100%; height: 85vh; background: #000; overflow: hidden; z-index: 1000; margin-top: 102px; }
        .slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1.5s ease; display: flex; align-items: center; }
        .slide.active { opacity: 1; }
        
        .slide-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
        .slide-bg img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.8); }
        .slide-bg::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(90deg, rgba(0,0,0,0.7) 0%, transparent 70%); }

        .slide-content { position: relative; z-index: 10; width: 1200px; margin: 0 auto; padding: 0 60px; color: #fff; }
        
        /* Animación Hermosa y Tranquila */
        .slide h1, .slide p, .slide .btn-brand { opacity: 0; transform: translateY(30px); }
        .slide.active h1 { animation: tranquilFade 1.2s forwards 0.3s; }
        .slide.active p { animation: tranquilFade 1.2s forwards 0.6s; }
        .slide.active .btn-brand { animation: tranquilFade 1.2s forwards 0.9s; }

        @keyframes tranquilFade {
            to { opacity: 1; transform: translateY(0); }
        }

        .slide h1 { font-size: clamp(2.2rem, 6vw, 4.2rem); font-weight: 800; line-height: 1.1; letter-spacing: -0.04em; margin-bottom: 24px; }
        .slide p { font-size: clamp(1rem, 1.8vw, 1.25rem); opacity: 0.9; margin-bottom: 45px; max-width: 550px; font-weight: 400; line-height: 1.5; }

        .btn-brand { background: var(--brand-purple); color: white; padding: 18px 42px; border-radius: 12px; font-size: 18px; font-weight: 600; text-decoration: none; display: inline-block; transition: 0.4s; }
        .btn-brand:hover { transform: scale(1.03); box-shadow: 0 20px 40px rgba(0,0,0,0.3); }

        /* Pricing Section (Responsive Optimized) */
        .pricing { background: #fff; padding: 100px 5%; position: relative; z-index: 2000; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto; }
        .p-card { background: #fff; padding: 50px 35px; border-radius: 20px; border: 1px solid #f0f0f0; transition: var(--transition); text-align: left; position: relative; }
        .p-card:hover { border-color: var(--brand-purple); transform: translateY(-10px); box-shadow: 0 40px 80px rgba(0,0,0,0.06); }
        .p-card.featured { border: 2px solid var(--brand-purple); box-shadow: 0 20px 40px rgba(106, 27, 154, 0.05); }

        .p-card h4 { font-size: 13px; letter-spacing: 2px; color: var(--gray); margin-bottom: 20px; font-weight: 800; text-transform: uppercase; }
        .p-price { font-size: clamp(32px, 5vw, 44px); font-weight: 800; color: var(--dark); margin-bottom: 35px; letter-spacing: -1.5px; white-space: nowrap; }
        .p-price span { font-size: 16px; color: var(--gray); font-weight: 400; }

        .p-features { list-style: none; margin-bottom: 45px; }
        .p-features li { padding: 12px 0; border-bottom: 1px solid #fcfcfc; display: flex; align-items: center; gap: 14px; font-size: 15px; color: #555; }
        .p-features li i { color: var(--brand-purple); font-size: 14px; }

        /* Modern FAQ */
        .faq { padding: 120px 10%; background: var(--light); border-radius: 60px 60px 0 0; }
        .faq-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 40px; max-width: 1200px; margin: 0 auto; }
        .faq-item { background: #fff; padding: 40px; border-radius: 24px; border: 1px solid rgba(0,0,0,0.02); }
        .faq-item h4 { font-size: 20px; margin-bottom: 15px; font-weight: 700; color: var(--dark); }
        
        /* Footer */
        .footer { background: #1D1D1F; color: #fff; padding: 120px 10% 50px; }
        .f-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 60px; max-width: 1200px; margin: 0 auto; }
        .f-col h4 { font-size: 14px; font-weight: 700; color: rgba(255,255,255,0.4); margin-bottom: 30px; text-transform: uppercase; letter-spacing: 2px; }
        .f-col a { color: rgba(255,255,255,0.7); text-decoration: none; font-size: 15px; transition: 0.2s; display: block; margin-bottom: 15px; }
        .f-col a:hover { color: var(--brand-purple); }

        .reveal { opacity: 0; transform: translateY(40px); transition: 1.2s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 768px) {
            .nav-content { padding: 0 20px; }
            .hero { height: 70vh; margin-top: 102px; }
            .slide h1 { font-size: 2.2rem; }
            .p-grid { grid-template-columns: 1fr; }
            .p-price { font-size: 36px; }
        }
    </style>
</head>
<body>

    <div id="preloader">
        <img src="assets/img/logo.png" class="preloader-logo" alt="CajaYa">
    </div>

    <div class="test-banner">⚠️ INTEGRACIÓN SII 2026 CERTIFICADA - MODO COMERCIAL ACTIVO ⚠️</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="nav-logo"><img src="assets/img/logo.png" alt="CajaYa Official"></a>
            <div style="font-weight:700; font-size:10px; color:var(--brand-purple); letter-spacing:1.5px; text-transform:uppercase;">Tecnología POS Superior</div>
        </div>
    </nav>

    <div class="hero">
        <div class="c-container">
            <div class="slide active">
                <div class="slide-bg"><img src="banner1.png" alt="CajaYa Business"></div>
                <div class="slide-content">
                    <h1>Tu Negocio Merece<br>Tecnología de Clase Mundial.</h1>
                    <p>El POS más avanzado de Chile. Emisión de boletas instantánea, reportes en tiempo real y una experiencia que te encantará.</p>
                    <a href="#planes" class="btn-brand">Ver Planes de Inversión</a>
                </div>
            </div>
            <div class="slide">
                <div class="slide-bg"><img src="banner2.png" alt="CajaYa Offline"></div>
                <div class="slide-content">
                    <h1>Vende Sin Pausas,<br>Sin Depender de Internet.</h1>
                    <p>Nuestro motor Offline garantiza que tu caja nunca se detenga. Sincronización automática de alta seguridad certificada por el SII.</p>
                    <a href="#planes" class="btn-brand" style="background:var(--brand-blue)">Empezar Ahora</a>
                </div>
            </div>
        </div>
    </div>

    <section class="pricing" id="planes">
        <div class="p-grid">
            <div class="p-card reveal">
                <h4>PLAN MENSUAL</h4>
                <div class="p-price">$<?php echo $pMensual; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li><i class="fa-solid fa-check"></i> 1 Punto de Venta Full</li>
                    <li><i class="fa-solid fa-check"></i> Boletas Electrónicas SII</li>
                    <li><i class="fa-solid fa-check"></i> Inventario Inteligente</li>
                    <li><i class="fa-solid fa-check"></i> Soporte Técnico WhatsApp</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-brand" style="width:100%; text-align:center; background:#f4f4f7; color:#000;">Seleccionar</a>
            </div>
            <div class="p-card featured reveal">
                <h4 style="color:var(--brand-purple)">PLAN LIFETIME</h4>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:11px; color:var(--gray); margin-top:-25px; margin-bottom:25px; font-weight:600;">PAGO ÚNICO. PROPIEDAD DE POR VIDA.</p>
                <ul class="p-features">
                    <li><i class="fa-solid fa-check"></i> 3 Puntos de Venta Full</li>
                    <li><i class="fa-solid fa-check"></i> Boletas y Facturas SII</li>
                    <li><i class="fa-solid fa-check"></i> Reportes Business Intelligence</li>
                    <li><i class="fa-solid fa-check"></i> Actualizaciones Eternas</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-brand" style="width:100%; text-align:center;">Comprar Ahora</a>
            </div>
            <div class="p-card reveal">
                <h4>PLAN EMPRESA</h4>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li><i class="fa-solid fa-check"></i> Cajas Ilimitadas</li>
                    <li><i class="fa-solid fa-check"></i> Gestión Multi-Sucursal</li>
                    <li><i class="fa-solid fa-check"></i> API para Integración ERP</li>
                    <li><i class="fa-solid fa-check"></i> Soporte Crítico 24/7</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-brand" style="width:100%; text-align:center; background:#f4f4f7; color:#000;">Contactar</a>
            </div>
        </div>
    </section>

    <section class="faq">
        <h2 style="font-size:42px; font-weight:800; text-align:center; margin-bottom:60px;" class="reveal">Preguntas Frecuentes</h2>
        <div class="faq-grid">
            <div class="faq-item reveal">
                <h4>¿Cómo recibo mi licencia?</h4>
                <p>Tras validar tu pago vía Mercado Pago, recibirás un correo electrónico automático con tu llave de activación y el enlace de descarga oficial.</p>
            </div>
            <div class="faq-item reveal">
                <h4>¿Es compatible con mi impresora?</h4>
                <p>CajaYa es compatible con todas las impresoras térmicas (58mm y 80mm) con conexión USB, Bluetooth o Red en el mercado chileno.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="f-grid">
            <div class="f-col">
                <img src="assets/img/logo.png" style="height:40px; margin-bottom:25px; filter:brightness(0) invert(1);" alt="CajaYa White">
                <p style="opacity:0.5; line-height:1.7;">Liderando la revolución del POS inteligente en Chile.</p>
            </div>
            <div class="f-col">
                <h4>Producto</h4>
                <a href="#">Características</a>
                <a href="#planes">Planes</a>
                <a href="#">SII Chile</a>
            </div>
            <div class="f-col">
                <h4>Empresa</h4>
                <a href="#">Sobre Nosotros</a>
                <a href="#">Privacidad</a>
                <a href="#">Términos Legales</a>
            </div>
        </div>
        <div class="f-bottom">
            <p>&copy; 2026 CajaYa Technologies S.A. Todos los derechos reservados.</p>
            <p>Hecho con Ingeniería Superior en Chile</p>
        </div>
    </footer>

    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const p = document.getElementById('preloader');
                p.style.opacity = '0';
                setTimeout(() => p.style.display = 'none', 1000);
            }, 1000);
        });

        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        function nextSlide() {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }
        setInterval(nextSlide, 7000);

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>
</html>
