<?php
/**
 * index.php — Landing Page Enterprise Premium (REDISEÑO TOTAL)
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
    <title>CajaYa — El Estándar de Oro en Puntos de Venta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0071E3;
            --accent: #34C759;
            --dark: #000000;
            --gray-deep: #1D1D1F;
            --gray-light: #F5F5F7;
            --white: #FFFFFF;
            --glass: rgba(255, 255, 255, 0.75);
            --transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--white); color: var(--gray-deep); font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; overflow-x: hidden; }

        /* Banner & Nav Glassmorphism */
        .test-banner { background: #FF9F0A; color: #000; text-align: center; padding: 10px; font-weight: 700; position: sticky; top: 0; z-index: 9999; font-size: 12px; letter-spacing: 1px; border-bottom: 1px solid rgba(0,0,0,0.1); }
        nav { background: var(--glass); backdrop-filter: saturate(180%) blur(25px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 60px; display: flex; align-items: center; justify-content: center; position: sticky; width: 100%; top: 38px; z-index: 2000; transition: 0.3s; }
        .nav-content { width: 1200px; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; }
        .logo { font-weight: 800; font-size: 22px; letter-spacing: -1px; text-decoration: none; color: var(--dark); }

        /* Full Width Dynamic Carousel */
        .hero-wrap { position: relative; width: 100%; height: 85vh; min-height: 650px; background: #000; overflow: hidden; }
        .c-container { width: 100%; height: 100%; position: relative; }
        .c-slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1.2s ease-in-out, transform 1.2s var(--transition); display: flex; align-items: center; justify-content: center; transform: scale(1.05); pointer-events: none; }
        .c-slide.active { opacity: 1; transform: scale(1); pointer-events: auto; }
        
        .c-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
        .c-bg img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.65) contrast(1.1); }
        .c-bg::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to right, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 50%, rgba(0,0,0,0.8) 100%); }

        .c-content { position: relative; z-index: 5; text-align: center; color: var(--white); max-width: 900px; padding: 0 40px; }
        .c-h1 { font-size: clamp(2.5rem, 6vw, 4.8rem); font-weight: 800; line-height: 1.05; letter-spacing: -0.04em; margin-bottom: 24px; animation: textUp 1s 0.2s both; }
        .c-p { font-size: clamp(1.1rem, 1.8vw, 1.4rem); opacity: 0.9; margin-bottom: 40px; font-weight: 300; letter-spacing: 0.02em; animation: textUp 1s 0.4s both; }
        @keyframes textUp { from { opacity: 0; transform: translateY(40px); filter: blur(10px); } to { opacity: 1; transform: translateY(0); filter: blur(0); } }

        .btn-premium { background: var(--primary); color: white; padding: 16px 42px; border-radius: 100px; font-size: 18px; font-weight: 600; text-decoration: none; display: inline-block; transition: var(--transition); border: 2px solid transparent; }
        .btn-premium:hover { background: transparent; border-color: var(--white); transform: translateY(-4px); box-shadow: 0 15px 30px rgba(0,113,227,0.3); }

        .c-nav { position: absolute; bottom: 40px; width: 100%; display: flex; justify-content: center; gap: 15px; z-index: 100; }
        .c-dot { width: 40px; height: 4px; background: rgba(255,255,255,0.2); border-radius: 10px; cursor: pointer; transition: 0.4s; }
        .c-dot.on { background: var(--white); width: 80px; }

        /* Dynamic Pricing Section */
        .pricing { padding: 120px 5%; background: var(--gray-light); position: relative; }
        .pricing::before { content: 'PLANS'; position: absolute; top: 40px; left: 50%; transform: translateX(-50%); font-size: 120px; font-weight: 900; color: rgba(0,0,0,0.02); letter-spacing: 15px; }
        
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 30px; max-width: 1200px; margin: 60px auto 0; }
        .p-card { background: var(--white); padding: 60px 40px; border-radius: 40px; border: 1px solid rgba(0,0,0,0.03); transition: var(--transition); text-align: center; position: relative; overflow: hidden; }
        .p-card:hover { transform: translateY(-15px) scale(1.02); box-shadow: 0 40px 80px rgba(0,0,0,0.08); border-color: var(--primary); }
        .p-card.featured { background: var(--dark); color: var(--white); transform: scale(1.05); z-index: 10; }
        
        .p-title { font-size: 20px; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 10px; }
        .featured .p-title { color: var(--accent); }
        
        .p-price { font-size: 64px; font-weight: 800; margin: 25px 0; letter-spacing: -0.05em; }
        .p-price span { font-size: 18px; font-weight: 400; opacity: 0.6; }
        
        .p-features { list-style: none; margin: 40px 0; text-align: left; }
        .p-features li { padding: 12px 0; border-bottom: 1px solid rgba(0,0,0,0.04); font-size: 15px; display: flex; align-items: center; gap: 12px; }
        .featured .p-features li { border-color: rgba(255,255,255,0.08); }
        .p-features li i { color: var(--primary); font-size: 12px; }
        .featured .p-features li i { color: var(--accent); }

        .btn-buy { width: 100%; padding: 18px; border-radius: 20px; border: none; font-weight: 700; font-size: 16px; cursor: pointer; transition: 0.3s; text-decoration: none; display: block; }
        .p-card .btn-buy { background: var(--gray-light); color: var(--dark); }
        .p-card.featured .btn-buy { background: var(--primary); color: var(--white); }
        .btn-buy:hover { filter: brightness(1.1); }

        /* Footer & Extra Info */
        .footer { background: var(--dark); color: #86868B; padding: 100px 5% 40px; text-align: center; }
        .footer-logo { font-size: 32px; font-weight: 800; color: white; margin-bottom: 40px; display: block; }
        .footer a { color: #f5f5f7; text-decoration: none; margin: 0 20px; font-weight: 500; font-size: 15px; transition: 0.3s; }
        .footer a:hover { color: var(--primary); }

        /* Responsive */
        @media (max-width: 768px) {
            .c-h1 { font-size: 3rem; }
            .p-grid { grid-template-columns: 1fr; }
            nav { top: 0; }
        }
    </style>
</head>
<body>

    <div class="test-banner">
        ⚠️ MODO DE PRUEBAS ACTIVO - LAS VENTAS ESTÁN EN FASE DE VALIDACIÓN ⚠️
    </div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="logo">CajaYa<span style="color:var(--primary)">.</span></a>
            <div style="font-size: 12px; font-weight: 700; letter-spacing: 1px;">SISTEMA CERTIFICADO 2026</div>
        </div>
    </nav>

    <div class="hero-wrap">
        <div class="c-container">
            <!-- SLIDE 1: EL PODER -->
            <div class="c-slide active">
                <div class="c-bg"><img src="cajaya_hero_banner_1_1777497423878.png" alt="CajaYa Enterprise"></div>
                <div class="c-content">
                    <h1 class="c-h1">La Ingeniería Detrás de<br><span style="color:var(--primary)">Tu Éxito Comercial.</span></h1>
                    <p class="c-p">Descubre el Punto de Venta más avanzado de Chile. Velocidad extrema, reportes en tiempo real y una interfaz que amarás usar.</p>
                    <a href="#planes" class="btn-premium">Explorar Planes</a>
                </div>
            </div>

            <!-- SLIDE 2: OFFLINE -->
            <div class="c-slide">
                <div class="c-bg"><img src="cajaya_hero_banner_2_1777497458638.png" alt="Offline Resilience"></div>
                <div class="c-content">
                    <h1 class="c-h1">Vende Sin Límites,<br><span style="color:var(--accent)">Incluso Sin Internet.</span></h1>
                    <p class="c-p">Tecnología de Resiliencia Offline: Tu base de datos local garantiza que el negocio nunca se detenga. Sincronización inteligente al recuperar conexión.</p>
                    <a href="#planes" class="btn-premium" style="background:var(--accent)">Contratar Ahora</a>
                </div>
            </div>
        </div>

        <div class="c-nav">
            <div class="c-dot on" onclick="cGo(0)"></div>
            <div class="c-dot" onclick="cGo(1)"></div>
        </div>
    </div>

    <section class="pricing" id="planes">
        <div style="text-align:center; margin-bottom:80px;">
            <h2 style="font-size:48px; font-weight:800; letter-spacing:-2px;">Inversión en Crecimiento</h2>
            <p style="color:var(--apple-muted); font-size:20px; font-weight:300;">Elige el motor que impulsará tu empresa al siguiente nivel.</p>
        </div>

        <div class="p-grid">
            <!-- PLAN MENSUAL -->
            <div class="p-card">
                <div class="p-title">Plan Mensual</div>
                <div class="p-price">$<?php echo $pMensual; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li><i class="fa-solid fa-check"></i> 1 Punto de Venta</li>
                    <li><i class="fa-solid fa-check"></i> Boletas Electrónicas SII</li>
                    <li><i class="fa-solid fa-check"></i> Inventario Ilimitado</li>
                    <li><i class="fa-solid fa-check"></i> Soporte Especializado</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-buy">Comenzar Suscripción</a>
            </div>

            <!-- PLAN LIFETIME -->
            <div class="p-card featured">
                <div class="p-title">Plan Lifetime</div>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="opacity:0.7; font-size:14px; margin-top:-15px;">UN SOLO PAGO. PROPIEDAD DE POR VIDA.</p>
                <ul class="p-features">
                    <li><i class="fa-solid fa-check"></i> 3 Puntos de Venta Full</li>
                    <li><i class="fa-solid fa-check"></i> Boletas y Facturas SII</li>
                    <li><i class="fa-solid fa-check"></i> Cierre de Caja Pro</li>
                    <li><i class="fa-solid fa-check"></i> Soporte Prioritario 1-on-1</li>
                    <li><i class="fa-solid fa-check"></i> Actualizaciones Eternas</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-buy">Adquirir Propiedad</a>
            </div>

            <!-- PLAN EMPRESA -->
            <div class="p-card">
                <div class="p-title">Plan Empresa</div>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li><i class="fa-solid fa-check"></i> Terminales Ilimitados</li>
                    <li><i class="fa-solid fa-check"></i> Gestión Multi-sucursal</li>
                    <li><i class="fa-solid fa-check"></i> API de Integración ERP</li>
                    <li><i class="fa-solid fa-check"></i> Reportes Business Intelligence</li>
                    <li><i class="fa-solid fa-check"></i> Soporte 24/7 Crítico</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-buy">Contactar Consultor</a>
            </div>
        </div>
    </section>

    <section style="padding:120px 8%; text-align:center; background:#fff;">
        <h2 style="font-size:36px; font-weight:800; margin-bottom:60px;">Tecnología Certificada 2026</h2>
        <div style="display:flex; justify-content:center; gap:80px; flex-wrap:wrap; opacity:0.6;">
            <div style="font-size:24px; font-weight:800;"><i class="fa-solid fa-building-shield"></i> SII CHILE</div>
            <div style="font-size:24px; font-weight:800;"><i class="fa-solid fa-microchip"></i> CLOUD SYNC</div>
            <div style="font-size:24px; font-weight:800;"><i class="fa-solid fa-fingerprint"></i> SECURE POS</div>
        </div>
    </section>

    <footer class="footer">
        <a href="#" class="footer-logo">CajaYa</a>
        <div style="margin-bottom:60px;">
            <a href="#planes">Planes</a>
            <a href="#">Privacidad</a>
            <a href="#">Términos</a>
            <a href="https://wa.me/56912345678">Soporte Corporativo</a>
        </div>
        <p style="font-size:12px; letter-spacing:1px; opacity:0.5;">CajaYa &copy; 2026 — Advanced Agentic Engineering by Reinaldo Arturo.</p>
    </footer>

    <script>
        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({ behavior: 'smooth' });
            });
        });

        // Carousel Logic
        let cCur = 0;
        const cSlides = document.querySelectorAll('.c-slide');
        const cDots = document.querySelectorAll('.c-dot');
        const cTotal = cSlides.length;

        function cGo(n) {
            cSlides[cCur].classList.remove('active');
            cDots[cCur].classList.remove('on');
            cCur = (n + cTotal) % cTotal;
            cSlides[cCur].classList.add('active');
            cDots[cCur].classList.add('on');
        }

        function cMove(dir) { cGo(cCur + dir); }
        let cTimer = setInterval(() => cMove(1), 6000);

        // Navbar effect on scroll
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 100) {
                nav.style.background = 'rgba(255,255,255,0.95)';
                nav.style.boxShadow = '0 10px 30px rgba(0,0,0,0.1)';
            } else {
                nav.style.background = 'var(--glass)';
                nav.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>
