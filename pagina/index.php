<?php
/**
 * index.php — Landing Page CAJAYA CLEAN & ELITE (MAX PURITY)
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
    <title>CajaYa — El POS Líder para tu Minimarket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0071E3;
            --brand-purple: #6A1B9A;
            --brand-blue: #2962FF;
            --dark: #000;
            --white: #FFF;
            --transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: var(--white); color: #1d1d1f; font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; }

        #preloader { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #000; display: flex; align-items: center; justify-content: center; z-index: 10000; transition: opacity 1s; }
        .preloader-logo { width: 120px; filter: brightness(0) invert(1); animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 0.5; transform: scale(0.9); } 50% { opacity: 1; transform: scale(1); } }

        .test-banner { background: #FF9F0A; color: #000; text-align: center; padding: 10px; font-weight: 800; position: fixed; top: 0; width: 100%; z-index: 9000; font-size: 11px; letter-spacing: 2px; }
        nav { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(50px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 75px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 37px; z-index: 8000; }
        .nav-content { width: 1400px; display: flex; justify-content: space-between; align-items: center; padding: 0 50px; }
        .nav-logo img { height: 40px; }

        /* Hero Elite - Eliminación de distracciones */
        .hero { position: relative; width: 100%; height: 85vh; background: #000; overflow: hidden; z-index: 1000; margin-top: 112px; }
        .slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1.5s ease; display: flex; align-items: center; }
        .slide.active { opacity: 1; }
        
        .slide-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; background: #000; }
        .slide-bg img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            filter: brightness(0.5) blur(1px);
            transform: scale(1.1);
        }
        /* Bloqueo sólido a la izquierda para borrar letras de la IA */
        .slide-bg::after { 
            content: ''; 
            position: absolute; 
            top: 0; left: 0; width: 100%; height: 100%; 
            background: linear-gradient(90deg, #000 0%, #000 35%, rgba(0,0,0,0.4) 70%, transparent 100%); 
        }

        /* Variación para la segunda slide */
        .slide.alt-view .slide-bg img { 
            transform: scale(1.2) scaleX(-1); /* Espejo para que parezca otra foto */
            filter: brightness(0.4) grayscale(0.2);
        }

        .slide-content { position: relative; z-index: 10; width: 1200px; margin: 0 auto; padding: 0 60px; color: #fff; }
        .slide h1, .slide p, .slide .btn-brand { opacity: 0; transform: translateY(30px); }
        .slide.active h1 { animation: slideUp 1s forwards 0.4s; }
        .slide.active p { animation: slideUp 1s forwards 0.7s; }
        .slide.active .btn-brand { animation: slideUp 1s forwards 1s; }

        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }

        .slide h1 { font-size: clamp(2.5rem, 6vw, 4.5rem); font-weight: 800; line-height: 1.1; margin-bottom: 25px; letter-spacing: -0.03em; }
        .slide p { font-size: clamp(1.1rem, 1.8vw, 1.35rem); opacity: 0.9; margin-bottom: 45px; max-width: 600px; line-height: 1.6; }

        .btn-brand { background: var(--brand-purple); color: white; padding: 18px 50px; border-radius: 14px; font-size: 20px; font-weight: 700; text-decoration: none; display: inline-block; transition: 0.4s; }
        .btn-brand:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.4); }

        /* Pricing Cards */
        .pricing { background: #fff; padding: 120px 5%; position: relative; z-index: 2000; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 40px; max-width: 1300px; margin: 0 auto; }
        .p-card { background: #fff; padding: 60px 45px; border-radius: 30px; border: 1px solid #f0f0f0; transition: var(--transition); }
        .p-card:hover { border-color: var(--brand-purple); transform: translateY(-10px); box-shadow: 0 40px 80px rgba(0,0,0,0.05); }
        .p-card.featured { border: 3px solid var(--brand-purple); }

        .p-card h4 { font-size: 14px; letter-spacing: 2px; color: var(--brand-purple); margin-bottom: 25px; font-weight: 800; text-transform: uppercase; }
        .p-price { font-size: 48px; font-weight: 800; color: #000; margin-bottom: 40px; }
        .p-price span { font-size: 18px; color: #888; font-weight: 400; }

        .p-features { list-style: none; margin-bottom: 50px; }
        .p-features li { padding: 15px 0; border-bottom: 1px solid #f9f9f9; display: flex; align-items: center; gap: 15px; font-size: 16px; }
        .p-features li i { color: var(--brand-purple); }

        .btn-p { width: 100%; text-align: center; padding: 18px; border-radius: 14px; font-weight: 700; text-decoration: none; display: block; transition: 0.3s; }
        .btn-p.outline { background: #f8f9fa; color: #000; }
        .btn-p.solid { background: var(--brand-purple); color: #fff; }

        /* Footer */
        .footer { background: #000; color: #fff; padding: 120px 10% 60px; }
        .f-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 80px; max-width: 1200px; margin: 0 auto; }
        .f-col h4 { font-size: 14px; font-weight: 800; color: rgba(255,255,255,0.3); margin-bottom: 35px; text-transform: uppercase; }
        .f-col a { color: rgba(255,255,255,0.6); text-decoration: none; font-size: 16px; transition: 0.2s; display: block; margin-bottom: 15px; }

        .reveal { opacity: 0; transform: translateY(40px); transition: 1.2s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 768px) {
            .hero { height: 75vh; }
            .p-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div id="preloader">
        <img src="assets/img/logo.png" class="preloader-logo" alt="CajaYa Elite">
    </div>

    <div class="test-banner">🚀 EL POS Nº1 PARA MINIMARKETS EN CHILE — INTEGRACIÓN SII 2026 🚀</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="nav-logo"><img src="assets/img/logo.png" alt="CajaYa Official"></a>
            <div style="font-weight:800; font-size:11px; color:var(--brand-purple); letter-spacing:2px;">TECNOLOGÍA PARA TU ÉXITO</div>
        </div>
    </nav>

    <div class="hero">
        <div class="c-container">
            <div class="slide active">
                <div class="slide-bg"><img src="banner1.png" alt="Minimarket Clean"></div>
                <div class="slide-content">
                    <h1>Vende con Rapidez,<br>Controla con Elegancia.</h1>
                    <p>CajaYa es la herramienta definitiva para tu minimarket. Boletas SII automáticas y control de stock en la palma de tu mano.</p>
                    <a href="#planes" class="btn-brand">Ver Planes de Inversión</a>
                </div>
            </div>
            <div class="slide alt-view">
                <div class="slide-bg"><img src="banner1.png" alt="POS Modern"></div>
                <div class="slide-content">
                    <h1>Tu Negocio Merece<br>Lo Mejor de la Tecnología.</h1>
                    <p>Diseñado para el comercio chileno moderno. Offline-First para que nunca dejes de vender, pase lo que pase.</p>
                    <a href="#planes" class="btn-brand" style="background:var(--brand-blue)">Comenzar Ahora</a>
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
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-p outline">Seleccionar</a>
            </div>
            <div class="p-card featured reveal">
                <h4>PLAN LIFETIME</h4>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:12px; color:var(--gray); margin-top:-30px; margin-bottom:30px; font-weight:800;">TUYO PARA SIEMPRE. PAGO ÚNICO.</p>
                <ul class="p-features">
                    <li><i class="fa-solid fa-check-circle"></i> 3 Puntos de Venta Full</li>
                    <li><i class="fa-solid fa-check-circle"></i> Boletas y Facturas SII</li>
                    <li><i class="fa-solid fa-check-circle"></i> Analítica Business Intelligence</li>
                    <li><i class="fa-solid fa-check-circle"></i> Actualizaciones Eternas</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-p solid">Comprar Licencia</a>
            </div>
            <div class="p-card reveal">
                <h4>PLAN EMPRESA</h4>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li><i class="fa-solid fa-check-circle"></i> Cajas Ilimitadas</li>
                    <li><i class="fa-solid fa-check-circle"></i> Gestión Multi-Sucursal</li>
                    <li><i class="fa-solid fa-check-circle"></i> Integración API ERP</li>
                    <li><i class="fa-solid fa-check-circle"></i> Soporte 24/7 Crítico</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-p outline">Contactar</a>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="f-grid">
            <div class="f-col">
                <img src="assets/img/logo.png" style="height:45px; margin-bottom:30px; filter:brightness(0) invert(1);" alt="CajaYa Logo">
                <p style="opacity:0.4; line-height:1.8;">Impulsando la transformación digital de los minimarkets en todo Chile.</p>
            </div>
            <div class="f-col">
                <h4>Producto</h4>
                <a href="#">Motor SII</a>
                <a href="#planes">Precios</a>
            </div>
            <div class="f-col">
                <h4>Legal</h4>
                <a href="#">Privacidad</a>
                <a href="#">Términos</a>
            </div>
        </div>
        <div class="f-bottom">
            <p>&copy; 2026 CajaYa S.A. Ingeniería Chilena de Elite.</p>
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
