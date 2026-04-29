<?php
/**
 * index.php — Landing Page CAJAYA GOLD (MAX CONTRAST & MODERN IMAGES)
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
    <title>CajaYa — Potencia y Control para tu Negocio</title>
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
        .preloader-logo { width: 130px; animation: pulse 2s infinite; filter: brightness(0) invert(1); }
        @keyframes pulse { 0% { opacity: 0.5; transform: scale(0.95); } 50% { opacity: 1; transform: scale(1); } 100% { opacity: 0.5; transform: scale(0.95); } }

        /* Header */
        .test-banner { background: #FF9F0A; color: #000; text-align: center; padding: 8px; font-weight: 700; position: fixed; top: 0; width: 100%; z-index: 9000; font-size: 10px; letter-spacing: 1px; }
        nav { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(30px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 70px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 32px; z-index: 8000; }
        .nav-content { width: 1400px; display: flex; justify-content: space-between; align-items: center; padding: 0 40px; }
        .nav-logo img { height: 38px; }

        /* Hero (MAX CONTRAST) */
        .hero { position: relative; width: 100%; height: 85vh; background: #000; overflow: hidden; z-index: 1000; margin-top: 102px; }
        .slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1.5s ease; display: flex; align-items: center; }
        .slide.active { opacity: 1; }
        
        .slide-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
        .slide-bg img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.7); }
        /* Capa de contraste más oscura para máxima legibilidad */
        .slide-bg::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(90deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 60%, transparent 100%); }

        .slide-content { position: relative; z-index: 10; width: 1200px; margin: 0 auto; padding: 0 60px; color: #fff; }
        
        /* Animaciones Zen */
        .slide h1, .slide p, .slide .btn-brand { opacity: 0; transform: translateY(20px); }
        .slide.active h1 { animation: tranquilFade 1.2s forwards 0.4s; }
        .slide.active p { animation: tranquilFade 1.2s forwards 0.7s; }
        .slide.active .btn-brand { animation: tranquilFade 1.2s forwards 1s; }

        @keyframes tranquilFade { to { opacity: 1; transform: translateY(0); } }

        .slide h1 { font-size: clamp(2.4rem, 6vw, 4.4rem); font-weight: 800; line-height: 1.05; letter-spacing: -0.04em; margin-bottom: 24px; text-shadow: 0 4px 15px rgba(0,0,0,0.5); }
        .slide p { font-size: clamp(1.1rem, 1.8vw, 1.35rem); opacity: 0.95; margin-bottom: 45px; max-width: 600px; font-weight: 400; line-height: 1.6; text-shadow: 0 2px 10px rgba(0,0,0,0.3); }

        .btn-brand { background: var(--brand-purple); color: white; padding: 18px 45px; border-radius: 12px; font-size: 19px; font-weight: 700; text-decoration: none; display: inline-block; transition: 0.4s; border: 1px solid rgba(255,255,255,0.1); }
        .btn-brand:hover { transform: translateY(-3px); box-shadow: 0 20px 40px rgba(0,0,0,0.4); background: #7B1FA2; }

        /* Pricing (Premium Contrast) */
        .pricing { background: #fff; padding: 120px 5%; position: relative; z-index: 2000; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 40px; max-width: 1300px; margin: 0 auto; }
        .p-card { background: #fff; padding: 60px 45px; border-radius: 24px; border: 1px solid #eee; transition: var(--transition); text-align: left; }
        .p-card:hover { border-color: var(--brand-purple); transform: translateY(-12px); box-shadow: 0 50px 100px rgba(0,0,0,0.08); }
        .p-card.featured { border: 2.5px solid var(--brand-purple); background: #fdfbff; }

        .p-card h4 { font-size: 14px; letter-spacing: 2.5px; color: var(--brand-purple); margin-bottom: 25px; font-weight: 800; text-transform: uppercase; }
        .p-price { font-size: clamp(38px, 5vw, 50px); font-weight: 800; color: var(--dark); margin-bottom: 35px; letter-spacing: -2px; }
        .p-price span { font-size: 18px; color: var(--gray); font-weight: 400; }

        .p-features { list-style: none; margin-bottom: 50px; }
        .p-features li { padding: 14px 0; border-bottom: 1px solid #f9f9f9; display: flex; align-items: center; gap: 15px; font-size: 16px; color: #444; }
        .p-features li i { color: var(--brand-purple); font-size: 14px; }

        .btn-p { width: 100%; text-align: center; padding: 16px; border-radius: 12px; font-weight: 700; text-decoration: none; display: block; transition: 0.3s; }
        .btn-p.outline { background: #f8f9fa; color: #000; border: 1px solid #eee; }
        .btn-p.solid { background: var(--brand-purple); color: #fff; }
        .btn-p:hover { transform: scale(1.02); }

        /* Modern FAQ */
        .faq { padding: 120px 10%; background: var(--light); border-radius: 80px 80px 0 0; }
        .faq-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 40px; max-width: 1200px; margin: 60px auto 0; }
        .faq-item { background: #fff; padding: 45px; border-radius: 30px; border: 1px solid rgba(0,0,0,0.01); box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
        .faq-item h4 { font-size: 22px; margin-bottom: 15px; font-weight: 800; color: var(--dark); }
        .faq-item p { color: var(--gray); line-height: 1.7; font-size: 16px; }

        /* Footer */
        .footer { background: #111; color: #fff; padding: 120px 10% 60px; }
        .f-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 80px; max-width: 1200px; margin: 0 auto; }
        .f-col h4 { font-size: 14px; font-weight: 800; color: rgba(255,255,255,0.3); margin-bottom: 35px; text-transform: uppercase; letter-spacing: 2px; }
        .f-col a { color: rgba(255,255,255,0.6); text-decoration: none; font-size: 16px; transition: 0.2s; display: block; margin-bottom: 18px; }
        .f-col a:hover { color: var(--brand-purple); padding-left: 5px; }

        .reveal { opacity: 0; transform: translateY(40px); transition: 1.2s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 768px) {
            .nav-content { padding: 0 25px; }
            .hero { height: 75vh; }
            .slide h1 { font-size: 2.5rem; }
            .slide-content { padding: 0 30px; }
            .p-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div id="preloader">
        <img src="assets/img/logo.png" class="preloader-logo" alt="CajaYa Gold">
    </div>

    <div class="test-banner">⚠️ INTEGRACIÓN SII 2026 CERTIFICADA - MODO COMERCIAL ACTIVO ⚠️</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="nav-logo"><img src="assets/img/logo.png" alt="CajaYa Official"></a>
            <div style="font-weight:800; font-size:10px; color:var(--brand-purple); letter-spacing:2px; text-transform:uppercase;">Tecnología POS de Vanguardia</div>
        </div>
    </nav>

    <div class="hero">
        <div class="c-container">
            <div class="slide active">
                <div class="slide-bg"><img src="banner1.png" alt="Hardware CajaYa Gold"></div>
                <div class="slide-content">
                    <h1>Tu Negocio Merece<br>Tecnología de Élite.</h1>
                    <p>CajaYa transforma tu punto de venta en una estación de alto rendimiento. Facturación instantánea y control absoluto desde cualquier lugar.</p>
                    <a href="#planes" class="btn-brand">Ver Planes y Precios</a>
                </div>
            </div>
            <div class="slide">
                <div class="slide-bg"><img src="banner2.png" alt="CajaYa App Mobile"></div>
                <div class="slide-content">
                    <h1>Libertad para Vender,<br>Incluso sin Internet.</h1>
                    <p>Nuestra arquitectura Offline-First garantiza continuidad total. Vende hoy, sincroniza mañana. Seguridad certificada por el SII.</p>
                    <a href="#planes" class="btn-brand" style="background:var(--brand-blue)">Activar CajaYa Ahora</a>
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
                    <li><i class="fa-solid fa-circle-check"></i> 1 Punto de Venta Full</li>
                    <li><i class="fa-solid fa-circle-check"></i> Boletas Electrónicas SII</li>
                    <li><i class="fa-solid fa-circle-check"></i> Control de Stock Real</li>
                    <li><i class="fa-solid fa-circle-check"></i> Soporte VIP WhatsApp</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-p outline">Seleccionar</a>
            </div>
            <div class="p-card featured reveal">
                <h4>PLAN LIFETIME</h4>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:12px; color:var(--gray); margin-top:-30px; margin-bottom:30px; font-weight:700;">PROPIEDAD TOTAL. UN SOLO PAGO.</p>
                <ul class="p-features">
                    <li><i class="fa-solid fa-circle-check"></i> 3 Puntos de Venta Full</li>
                    <li><i class="fa-solid fa-circle-check"></i> Facturación SII Ilimitada</li>
                    <li><i class="fa-solid fa-circle-check"></i> Reportes Avanzados BI</li>
                    <li><i class="fa-solid fa-circle-check"></i> Soporte Prioritario 24/7</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-p solid">Comprar Ahora</a>
            </div>
            <div class="p-card reveal">
                <h4>PLAN EMPRESA</h4>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li><i class="fa-solid fa-circle-check"></i> Cajas y Terminales Ilimitados</li>
                    <li><i class="fa-solid fa-circle-check"></i> Gestión Multi-Sucursal Cloud</li>
                    <li><i class="fa-solid fa-circle-check"></i> API de Integración ERP</li>
                    <li><i class="fa-solid fa-circle-check"></i> Soporte Crítico VIP 24/7</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-p outline">Contactar Ventas</a>
            </div>
        </div>
    </section>

    <section class="faq">
        <h2 style="font-size:48px; font-weight:800; text-align:center; margin-bottom:80px;" class="reveal">Confianza CajaYa</h2>
        <div class="faq-grid">
            <div class="faq-item reveal">
                <h4>¿Cómo obtengo mi activación?</h4>
                <p>Es instantáneo. Al completar tu inversión mediante Mercado Pago, recibirás un correo automático con tu llave de licencia y el enlace de descarga oficial.</p>
            </div>
            <div class="faq-item reveal">
                <h4>¿Cumple con la normativa SII?</h4>
                <p>Totalmente. CajaYa está certificado para emitir boletas y facturas legales. Solo carga tu certificado digital y estarás vendiendo legalmente en minutos.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="f-grid">
            <div class="f-col">
                <img src="assets/img/logo.png" style="height:45px; margin-bottom:30px; filter:brightness(0) invert(1);" alt="CajaYa White Logo">
                <p style="opacity:0.5; line-height:1.8; font-size:15px;">Transformando el comercio tradicional en empresas digitales de alta eficiencia.</p>
            </div>
            <div class="f-col">
                <h4>Ecosistema</h4>
                <a href="#">Tecnología SII</a>
                <a href="#planes">Precios</a>
                <a href="#">Soporte Técnico</a>
            </div>
            <div class="f-col">
                <h4>Legal</h4>
                <a href="#">Términos de Servicio</a>
                <a href="#">Privacidad</a>
                <a href="#">Certificaciones</a>
            </div>
        </div>
        <div class="f-bottom">
            <p>&copy; 2026 CajaYa Technologies S.A. Liderando el POS en Chile.</p>
            <p>Ingeniería de Clase Mundial</p>
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
