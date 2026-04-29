<?php
/**
 * index.php — Landing Page CAJAYA ELITE CHILE (ULTRA CONTRAST & MAC VANGUARD)
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
    <title>CajaYa — El POS del Futuro, Hoy.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0071E3;
            --brand-purple: #6A1B9A;
            --brand-blue: #2962FF;
            --dark: #000000;
            --gray: #86868B;
            --light: #F5F5F7;
            --white: #FFFFFF;
            --transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--white); color: #1d1d1f; font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; overflow-x: hidden; }

        /* PRELOADER */
        #preloader { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #000; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 10000; transition: opacity 1s ease; }
        .preloader-logo { width: 140px; animation: pulse 2s infinite; filter: brightness(0) invert(1); }
        @keyframes pulse { 0% { opacity: 0.4; transform: scale(0.9); } 50% { opacity: 1; transform: scale(1); } 100% { opacity: 0.4; transform: scale(0.9); } }

        /* Header */
        .test-banner { background: #FF9F0A; color: #000; text-align: center; padding: 8px; font-weight: 800; position: fixed; top: 0; width: 100%; z-index: 9000; font-size: 11px; letter-spacing: 1.5px; }
        nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(40px); border-bottom: 1px solid rgba(0,0,0,0.03); height: 75px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 35px; z-index: 8000; }
        .nav-content { width: 1400px; display: flex; justify-content: space-between; align-items: center; padding: 0 50px; }
        .nav-logo img { height: 42px; transition: 0.3s; }
        .nav-logo img:hover { transform: scale(1.05); }

        /* Hero (ULTRA CONTRAST) */
        .hero { position: relative; width: 100%; height: 90vh; background: #000; overflow: hidden; z-index: 1000; margin-top: 110px; }
        .slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1.8s ease; display: flex; align-items: center; }
        .slide.active { opacity: 1; }
        
        .slide-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
        .slide-bg img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.7); }
        /* Gradiente más agresivo para legibilidad perfecta */
        .slide-bg::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(90deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.5) 50%, transparent 100%); }

        .slide-content { position: relative; z-index: 10; width: 1300px; margin: 0 auto; padding: 0 80px; color: #fff; }
        
        /* Animaciones Zen Refinadas */
        .slide h1, .slide p, .slide .btn-brand { opacity: 0; transform: translateY(40px); }
        .slide.active h1 { animation: slideUp 1.2s forwards 0.5s; }
        .slide.active p { animation: slideUp 1.2s forwards 0.8s; }
        .slide.active .btn-brand { animation: slideUp 1.2s forwards 1.1s; }

        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }

        .slide h1 { font-size: clamp(2.8rem, 7vw, 4.8rem); font-weight: 800; line-height: 1; letter-spacing: -0.05em; margin-bottom: 30px; text-shadow: 0 10px 30px rgba(0,0,0,0.4); }
        .slide p { font-size: clamp(1.2rem, 2vw, 1.4rem); opacity: 0.9; margin-bottom: 50px; max-width: 650px; font-weight: 400; line-height: 1.6; }

        .btn-brand { background: var(--brand-purple); color: white; padding: 20px 50px; border-radius: 14px; font-size: 20px; font-weight: 700; text-decoration: none; display: inline-block; transition: 0.5s; border: 1px solid rgba(255,255,255,0.15); }
        .btn-brand:hover { transform: translateY(-5px); box-shadow: 0 25px 50px rgba(0,0,0,0.5); background: #7B1FA2; }

        /* Pricing (Elite Grid) */
        .pricing { background: #fff; padding: 140px 5%; position: relative; z-index: 2000; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 50px; max-width: 1400px; margin: 0 auto; }
        .p-card { background: #fff; padding: 70px 50px; border-radius: 30px; border: 1px solid #f0f0f0; transition: var(--transition); text-align: left; }
        .p-card:hover { border-color: var(--brand-purple); transform: translateY(-15px); box-shadow: 0 60px 120px rgba(0,0,0,0.06); }
        .p-card.featured { border: 3px solid var(--brand-purple); background: #fafafa; }

        .p-card h4 { font-size: 15px; letter-spacing: 3px; color: var(--brand-purple); margin-bottom: 30px; font-weight: 800; text-transform: uppercase; }
        .p-price { font-size: clamp(42px, 6vw, 56px); font-weight: 800; color: var(--dark); margin-bottom: 40px; letter-spacing: -2.5px; }
        .p-price span { font-size: 20px; color: var(--gray); font-weight: 400; }

        .p-features { list-style: none; margin-bottom: 60px; }
        .p-features li { padding: 16px 0; border-bottom: 1px solid #f5f5f5; display: flex; align-items: center; gap: 18px; font-size: 17px; color: #333; }
        .p-features li i { color: var(--brand-purple); font-size: 15px; }

        .btn-p { width: 100%; text-align: center; padding: 18px; border-radius: 15px; font-weight: 800; text-decoration: none; display: block; transition: 0.3s; font-size: 18px; }
        .btn-p.outline { background: #fdfdfd; color: #000; border: 1px solid #ddd; }
        .btn-p.solid { background: var(--brand-purple); color: #fff; }
        .btn-p:hover { transform: scale(1.02); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }

        /* Modern FAQ */
        .faq { padding: 140px 10%; background: var(--light); border-radius: 100px 100px 0 0; }
        .faq-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 50px; max-width: 1300px; margin: 80px auto 0; }
        .faq-item { background: #fff; padding: 50px; border-radius: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.02); }
        .faq-item h4 { font-size: 24px; margin-bottom: 20px; font-weight: 800; color: var(--dark); }
        .faq-item p { color: var(--gray); line-height: 1.8; font-size: 17px; }

        /* Footer */
        .footer { background: #000; color: #fff; padding: 140px 10% 70px; }
        .f-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 100px; max-width: 1300px; margin: 0 auto; }
        .f-col h4 { font-size: 15px; font-weight: 800; color: rgba(255,255,255,0.25); margin-bottom: 40px; text-transform: uppercase; letter-spacing: 2.5px; }
        .f-col a { color: rgba(255,255,255,0.5); text-decoration: none; font-size: 17px; transition: 0.3s; display: block; margin-bottom: 20px; }
        .f-col a:hover { color: var(--brand-purple); padding-left: 10px; }

        .reveal { opacity: 0; transform: translateY(50px); transition: 1.5s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 768px) {
            .nav-content { padding: 0 30px; }
            .hero { height: 80vh; margin-top: 110px; }
            .slide h1 { font-size: 2.8rem; }
            .slide-content { padding: 0 40px; }
            .p-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div id="preloader">
        <img src="assets/img/logo.png" class="preloader-logo" alt="CajaYa Elite">
    </div>

    <div class="test-banner">🚀 VANGUARDIA TECNOLÓGICA — INTEGRACIÓN SII 2026 CERTIFICADA 🚀</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="nav-logo"><img src="assets/img/logo.png" alt="CajaYa Official"></a>
            <div style="font-weight:800; font-size:11px; color:var(--brand-purple); letter-spacing:3px; text-transform:uppercase;">El Estándar POS en Chile</div>
        </div>
    </nav>

    <div class="hero">
        <div class="c-container">
            <div class="slide active">
                <div class="slide-bg"><img src="banner1.png" alt="CajaYa iMac Elite"></div>
                <div class="slide-content">
                    <h1>Sencillez de un Mac.<br>Potencia de un ERP.</h1>
                    <p>Diseñado para quienes buscan lo mejor. CajaYa ofrece una interfaz minimalista con el motor más potente del mercado chileno.</p>
                    <a href="#planes" class="btn-brand">Explorar Planes de Éxito</a>
                </div>
            </div>
            <div class="slide">
                <div class="slide-bg"><img src="banner2.png" alt="CajaYa MacBook Pro"></div>
                <div class="slide-content">
                    <h1>Control Total,<br>En Cualquier Lugar.</h1>
                    <p>Gestiona tu inventario, ventas y facturación desde tu laptop con elegancia. Nuestra nube sincroniza todo en tiempo real.</p>
                    <a href="#planes" class="btn-brand" style="background:var(--brand-blue)">Activar Mi Negocio</a>
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
                    <li><i class="fa-solid fa-check-circle"></i> 1 Punto de Venta Full</li>
                    <li><i class="fa-solid fa-check-circle"></i> Boletas Electrónicas SII</li>
                    <li><i class="fa-solid fa-check-circle"></i> Inventario Inteligente</li>
                    <li><i class="fa-solid fa-check-circle"></i> Soporte VIP WhatsApp</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-p outline">Elegir Plan</a>
            </div>
            <div class="p-card featured reveal">
                <h4>PLAN LIFETIME</h4>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:13px; color:var(--gray); margin-top:-35px; margin-bottom:35px; font-weight:800; letter-spacing:1px;">PROPIEDAD DEFINITIVA. PAGO ÚNICO.</p>
                <ul class="p-features">
                    <li><i class="fa-solid fa-check-circle"></i> 3 Puntos de Venta Full</li>
                    <li><i class="fa-solid fa-check-circle"></i> Facturación SII Ilimitada</li>
                    <li><i class="fa-solid fa-check-circle"></i> Analítica Business Intelligence</li>
                    <li><i class="fa-solid fa-check-circle"></i> Soporte Prioritario 24/7</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-p solid">Comprar Licencia</a>
            </div>
            <div class="p-card reveal">
                <h4>PLAN EMPRESA</h4>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li><i class="fa-solid fa-check-circle"></i> Terminales Ilimitados</li>
                    <li><i class="fa-solid fa-check-circle"></i> Multi-sucursal Cloud Sync</li>
                    <li><i class="fa-solid fa-check-circle"></i> API para Integración ERP</li>
                    <li><i class="fa-solid fa-check-circle"></i> Soporte Crítico VIP 24/7</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-p outline">Contactar</a>
            </div>
        </div>
    </section>

    <section class="faq">
        <h2 style="font-size:52px; font-weight:800; text-align:center; margin-bottom:80px;" class="reveal">Excelencia CajaYa</h2>
        <div class="faq-grid">
            <div class="faq-item reveal">
                <h4>¿La activación es inmediata?</h4>
                <p>Absolutamente. Tras procesar tu inversión con Mercado Pago, nuestro sistema te envía automáticamente las llaves de activación y accesos a tu correo.</p>
            </div>
            <div class="faq-item reveal">
                <h4>¿Funciona en Mac y PC?</h4>
                <p>CajaYa es una plataforma moderna diseñada para funcionar de forma fluida en cualquier sistema operativo moderno a través de nuestra arquitectura web y offline.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="f-grid">
            <div class="f-col">
                <img src="assets/img/logo.png" style="height:50px; margin-bottom:35px; filter:brightness(0) invert(1);" alt="CajaYa White Elite">
                <p style="opacity:0.4; line-height:1.9; font-size:16px;">Definiendo el nuevo estándar de eficiencia para el comercio chileno de alta gama.</p>
            </div>
            <div class="f-col">
                <h4>Soluciones</h4>
                <a href="#">Motor SII 2026</a>
                <a href="#planes">Planes Elite</a>
                <a href="#">API Developer</a>
            </div>
            <div class="f-col">
                <h4>Corporativo</h4>
                <a href="#">Términos Legales</a>
                <a href="#">Privacidad</a>
                <a href="#">Contacto Directo</a>
            </div>
        </div>
        <div class="f-bottom">
            <p>&copy; 2026 CajaYa Technologies S.A. Hecho con Ingeniería Superior en Chile.</p>
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
        setInterval(nextSlide, 8000);

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>
</html>
