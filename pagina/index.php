<?php
/**
 * index.php — Landing Page MERCADO PAGO STYLE (FINAL REFINEMENT)
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
    <title>CajaYa — El Poder de Vender Hecho Simple</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0071E3;
            --accent: #34C759;
            --brand-purple: #6A1B9A;
            --brand-blue: #2962FF;
            --dark: #1D1D1F;
            --gray: #86868B;
            --light: #F5F5F7;
            --white: #FFFFFF;
            --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--white); color: var(--dark); font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; overflow-x: hidden; }

        /* PRELOADER */
        #preloader { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #000; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 10000; transition: opacity 0.8s ease; }
        .logo-p { font-size: 48px; font-weight: 800; color: #fff; letter-spacing: -2px; }
        .logo-p span { color: var(--brand-purple); }
        .loader-bar { width: 150px; height: 2px; background: rgba(255,255,255,0.1); margin-top: 20px; position: relative; overflow: hidden; }
        .loader-bar::after { content: ''; position: absolute; left: -100%; width: 100%; height: 100%; background: var(--brand-purple); animation: loading 1.5s infinite; }
        @keyframes loading { to { left: 100%; } }

        /* Header Fixes */
        .test-banner { background: #FF9F0A; color: #000; text-align: center; padding: 8px; font-weight: 700; position: fixed; top: 0; width: 100%; z-index: 9000; font-size: 10px; letter-spacing: 1px; }
        nav { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 60px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 32px; z-index: 8000; }
        .nav-content { width: 1200px; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; }
        .nav-logo { font-weight: 800; font-size: 22px; text-decoration: none; color: var(--dark); letter-spacing: -1px; }
        .nav-logo span { color: var(--brand-purple); }

        /* Hero Mercado Pago Style */
        .hero { position: relative; width: 100%; height: 80vh; background: #000; overflow: hidden; z-index: 1000; margin-top: 92px; }
        .slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1s ease; display: flex; align-items: center; }
        .slide.active { opacity: 1; }
        
        .slide-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
        .slide-bg img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.85); }
        .slide-bg::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(90deg, rgba(0,0,0,0.6) 0%, transparent 60%); }

        .slide-content { position: relative; z-index: 10; width: 1200px; margin: 0 auto; padding: 0 60px; color: #fff; }
        .slide h1 { font-size: clamp(2.5rem, 5vw, 4.2rem); font-weight: 800; line-height: 1.1; letter-spacing: -0.04em; margin-bottom: 24px; text-shadow: 0 2px 10px rgba(0,0,0,0.3); }
        .slide p { font-size: clamp(1.1rem, 1.6vw, 1.3rem); opacity: 0.9; margin-bottom: 40px; max-width: 500px; text-shadow: 0 2px 5px rgba(0,0,0,0.2); }

        .btn-brand { background: var(--brand-purple); color: white; padding: 16px 36px; border-radius: 8px; font-size: 17px; font-weight: 600; text-decoration: none; display: inline-block; transition: 0.3s; }
        .btn-brand:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); background: #7B1FA2; }

        /* Pricing Section (Contained) */
        .pricing { background: #fff; padding: 120px 5%; position: relative; z-index: 2000; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto; }
        .p-card { background: #fff; padding: 50px 40px; border-radius: 12px; border: 1px solid #eee; transition: var(--transition); text-align: left; }
        .p-card:hover { border-color: var(--brand-purple); transform: translateY(-8px); box-shadow: 0 30px 60px rgba(0,0,0,0.05); }
        .p-card.featured { border: 2.5px solid var(--brand-purple); }

        .p-card h4 { font-size: 13px; letter-spacing: 1.5px; color: var(--gray); margin-bottom: 20px; font-weight: 700; text-transform: uppercase; }
        .p-price { font-size: 46px; font-weight: 800; color: var(--dark); margin-bottom: 30px; letter-spacing: -2px; }
        .p-price span { font-size: 18px; color: var(--gray); font-weight: 400; }

        .p-features { list-style: none; margin-bottom: 40px; }
        .p-features li { padding: 10px 0; border-bottom: 1px solid #f9f9f9; display: flex; align-items: center; gap: 12px; font-size: 15px; color: #444; }
        .p-features li::before { content: '✓'; color: var(--brand-purple); font-weight: 800; }

        /* FAQ Modern Cards */
        .faq { padding: 100px 10%; background: var(--light); }
        .faq-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 30px; max-width: 1200px; margin: 60px auto 0; }
        .faq-item { background: #fff; padding: 35px; border-radius: 12px; transition: 0.3s; }
        .faq-item h4 { font-size: 20px; margin-bottom: 15px; font-weight: 700; color: var(--dark); }
        .faq-item p { color: var(--gray); line-height: 1.6; }

        /* Footer Purple Contrast */
        .footer { background: #1D1D1F; color: #fff; padding: 100px 10% 40px; }
        .f-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 60px; max-width: 1200px; margin: 0 auto; }
        .f-col h4 { font-size: 14px; font-weight: 700; color: #fff; margin-bottom: 25px; opacity: 0.5; text-transform: uppercase; letter-spacing: 1px; }
        .f-col ul { list-style: none; }
        .f-col a { color: #fff; opacity: 0.8; text-decoration: none; font-size: 15px; transition: 0.2s; }
        .f-col a:hover { opacity: 1; color: var(--brand-purple); }
        
        .f-bottom { max-width: 1200px; margin: 60px auto 0; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: rgba(255,255,255,0.4); }

        .reveal { opacity: 0; transform: translateY(30px); transition: 0.8s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 768px) {
            .nav-content { padding: 0 15px; }
            .slide-content { padding: 0 20px; }
            .faq-grid { grid-template-columns: 1fr; }
            .hero { margin-top: 80px; }
        }
    </style>
</head>
<body>

    <div id="preloader">
        <div class="logo-p">CajaYa<span>.</span></div>
        <div class="loader-bar"></div>
    </div>

    <div class="test-banner">⚠️ INTEGRACIÓN SII 2026 CERTIFICADA - MODO COMERCIAL ACTIVO ⚠️</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="nav-logo">CajaYa<span>.</span></a>
            <div style="font-weight:700; font-size:11px; color:var(--brand-purple); letter-spacing:1px;">TECNOLOGÍA DE VENTA SUPERIOR</div>
        </div>
    </nav>

    <div class="hero">
        <div class="c-container">
            <div class="slide active">
                <div class="slide-bg"><img src="banner1.png" alt="Retail Success"></div>
                <div class="slide-content">
                    <h1>Potencia tu Negocio con<br>el POS del Futuro.</h1>
                    <p>Facturación SII instantánea, control de inventario y reportes inteligentes en una sola app diseñada para crecer contigo.</p>
                    <a href="#planes" class="btn-brand">Ver Planes y Precios</a>
                </div>
            </div>
            <div class="slide">
                <div class="slide-bg"><img src="banner2.png" alt="Coffee Shop Payment"></div>
                <div class="slide-content">
                    <h1>Tu Caja Nunca se Detiene.<br>Ni Siquiera sin Internet.</h1>
                    <p>Resiliencia offline de grado bancario. Sigue vendiendo en cualquier lugar y sincroniza automáticamente al recuperar la señal.</p>
                    <a href="#planes" class="btn-brand" style="background:var(--brand-blue)">Empezar Ahora</a>
                </div>
            </div>
        </div>
    </div>

    <section class="pricing" id="planes">
        <h2 style="font-size:42px; font-weight:800; text-align:center; margin-bottom:60px;" class="reveal">Planes para cada Etapa</h2>
        <div class="p-grid">
            <div class="p-card reveal">
                <h4>EMPRENDEDOR</h4>
                <div class="p-price">$<?php echo $pMensual; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li>1 Punto de Venta Full</li>
                    <li>Boletas Electrónicas SII</li>
                    <li>Control de Inventario</li>
                    <li>Soporte WhatsApp</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-brand" style="width:100%; text-align:center; background:#f4f4f4; color:#000;">Seleccionar</a>
            </div>
            <div class="p-card featured reveal">
                <h4 style="color:var(--brand-purple)">LIFETIME</h4>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:11px; color:var(--gray); margin-top:-20px; margin-bottom:20px;">PAGO ÚNICO PARA SIEMPRE</p>
                <ul class="p-features">
                    <li>3 Puntos de Venta Full</li>
                    <li>Facturas y Boletas SII</li>
                    <li>Business Intelligence</li>
                    <li>Actualizaciones Eternas</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-brand" style="width:100%; text-align:center;">Comprar Ahora</a>
            </div>
            <div class="p-card reveal">
                <h4>CORPORATIVO</h4>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li>Terminales Ilimitados</li>
                    <li>Multi-sucursal Cloud</li>
                    <li>Integración API ERP</li>
                    <li>Soporte 24/7 VIP</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-brand" style="width:100%; text-align:center; background:#f4f4f4; color:#000;">Contactar</a>
            </div>
        </div>
    </section>

    <section class="faq">
        <h2 style="font-size:36px; font-weight:800; text-align:center;" class="reveal">¿Tienes preguntas?</h2>
        <div class="faq-grid">
            <div class="faq-item reveal">
                <h4>¿Cómo funciona la activación?</h4>
                <p>Una vez procesado tu pago, recibirás un correo automático con tu licencia y el enlace de descarga. La activación es instantánea.</p>
            </div>
            <div class="faq-item reveal">
                <h4>¿Es compatible con el SII?</h4>
                <p>Sí, estamos 100% certificados. Solo subes tu certificado digital y la app se encarga de todo el proceso tributario legal.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="f-grid">
            <div class="f-col">
                <div class="nav-logo" style="color:#fff; font-size:28px;">CajaYa<span>.</span></div>
                <p style="margin-top:20px; opacity:0.6; line-height:1.6;">La tecnología que transforma almacenes en empresas digitales.</p>
            </div>
            <div class="f-col">
                <h4>Producto</h4>
                <ul>
                    <li><a href="#">Características</a></li>
                    <li><a href="#planes">Precios</a></li>
                    <li><a href="#">SII Chile</a></li>
                </ul>
            </div>
            <div class="f-col">
                <h4>Soporte</h4>
                <ul>
                    <li><a href="#">Ayuda</a></li>
                    <li><a href="#">WhatsApp</a></li>
                    <li><a href="#">Estado</a></li>
                </ul>
            </div>
        </div>
        <div class="f-bottom">
            <p>&copy; 2026 CajaYa Technologies S.A.</p>
            <p>Slogan: "Vender nunca fue tan fácil"</p>
        </div>
    </footer>

    <script>
        // PRELOADER
        window.addEventListener('load', () => {
            setTimeout(() => {
                const p = document.getElementById('preloader');
                p.style.opacity = '0';
                setTimeout(() => p.style.display = 'none', 800);
            }, 1200);
        });

        // Carousel
        let c = 0;
        const slides = document.querySelectorAll('.slide');
        function next() {
            slides[c].classList.remove('active');
            c = (c + 1) % slides.length;
            slides[c].classList.add('active');
        }
        setInterval(next, 7000);

        // Reveal
        const obs = new IntersectionObserver((es) => {
            es.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
    </script>
</body>
</html>
