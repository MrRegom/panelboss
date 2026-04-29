<?php
/**
 * index.php — Landing Page IMAC CLEAN STYLE
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
    <title>CajaYa — Simplicidad. Poder. Control.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0071E3;
            --accent: #34C759;
            --dark: #1D1D1F;
            --gray: #86868B;
            --light: #F5F5F7;
            --white: #FFFFFF;
            --transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--white); color: var(--dark); font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; overflow-x: hidden; }

        .test-banner { background: #FF9F0A; color: #000; text-align: center; padding: 8px; font-weight: 700; position: fixed; top: 0; width: 100%; z-index: 9999; font-size: 10px; letter-spacing: 1px; }
        nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: saturate(180%) blur(20px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 54px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 32px; z-index: 2000; transition: 0.3s; }
        .nav-content { width: 1100px; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .logo { font-weight: 800; font-size: 20px; text-decoration: none; color: var(--dark); }

        /* Hero iMac Style (White Background) */
        .hero { position: relative; width: 100%; height: 90vh; background: var(--white); overflow: hidden; padding-top: 100px; }
        .c-container { width: 100%; height: 100%; position: relative; }
        .slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1.2s ease; display: flex; align-items: center; justify-content: space-between; padding: 0 10%; pointer-events: none; }
        .slide.active { opacity: 1; pointer-events: auto; }
        
        .slide-text { flex: 1; max-width: 550px; z-index: 10; }
        .slide-img { flex: 1.2; display: flex; justify-content: center; align-items: center; z-index: 5; }
        .slide-img img { width: 100%; max-width: 700px; filter: drop-shadow(0 30px 60px rgba(0,0,0,0.1)); transition: transform 1s var(--transition); }
        .slide.active .slide-img img { transform: translateY(-20px); }

        .slide h2 { font-size: 20px; font-weight: 700; margin-bottom: 15px; color: var(--dark); letter-spacing: -0.5px; }
        .slide h1 { font-size: clamp(2.5rem, 5vw, 4.2rem); font-weight: 800; line-height: 1.08; letter-spacing: -0.04em; margin-bottom: 24px; color: var(--dark); }
        .gradient-text { background: linear-gradient(135deg, #0071E3 0%, #34C759 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .slide p { font-size: clamp(1rem, 1.5vw, 1.2rem); color: var(--gray); margin-bottom: 40px; line-height: 1.5; font-weight: 400; max-width: 450px; }

        .btn-apple { background: var(--primary); color: white; padding: 14px 32px; border-radius: 980px; font-size: 17px; font-weight: 600; text-decoration: none; display: inline-block; transition: 0.3s; }
        .btn-apple:hover { background: #0077ED; transform: scale(1.05); }

        .c-nav { position: absolute; bottom: 50px; width: 100%; display: flex; justify-content: center; gap: 15px; z-index: 100; }
        .c-dot { width: 8px; height: 8px; background: #D2D2D7; border-radius: 50%; cursor: pointer; transition: 0.4s; }
        .c-dot.on { background: var(--dark); transform: scale(1.3); }

        /* Sections Reveal */
        .section { padding: 120px 10%; text-align: center; background: #fff; }
        .reveal { opacity: 0; transform: translateY(30px); transition: 1s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* Math Bg (Sutil over white) */
        .math-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none; z-index: 1; }
        .symbol { position: absolute; color: var(--primary); opacity: 0.08; font-weight: 800; animation: float linear infinite; }
        @keyframes float { from { transform: translateY(110vh) rotate(0deg); } to { transform: translateY(-10vh) rotate(360deg); } }

        /* Pricing iMac Style */
        .pricing { background: var(--light); padding: 120px 5%; border-radius: 50px 50px 0 0; margin-top: -50px; position: relative; z-index: 20; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; max-width: 1100px; margin: 0 auto; }
        .p-card { background: var(--white); padding: 60px 40px; border-radius: 28px; transition: var(--transition); text-align: left; }
        .p-card:hover { transform: scale(1.02); box-shadow: 0 40px 80px rgba(0,0,0,0.06); }
        .p-card.featured { border: 1.5px solid var(--primary); }
        .p-price { font-size: 52px; font-weight: 800; margin: 20px 0; letter-spacing: -2px; }
        .p-features { list-style: none; margin: 30px 0; }
        .p-features li { padding: 10px 0; border-bottom: 1px solid rgba(0,0,0,0.04); color: var(--gray); font-size: 15px; }

        /* Footer Corporate */
        .footer { padding: 100px 10% 40px; background: var(--white); border-top: 1px solid rgba(0,0,0,0.05); color: var(--gray); }
        .f-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 40px; max-width: 1100px; margin: 0 auto; }
        .f-col h4 { font-size: 13px; font-weight: 700; color: var(--dark); margin-bottom: 20px; text-transform: uppercase; }
        .f-col ul { list-style: none; }
        .f-col ul li { margin-bottom: 10px; font-size: 13px; }
        .f-col a { color: var(--gray); text-decoration: none; transition: 0.2s; }
        .f-col a:hover { color: var(--primary); text-decoration: underline; }

        @media (max-width: 900px) {
            .slide { flex-direction: column; text-align: center; padding-top: 50px; }
            .slide-text { max-width: 100%; order: 2; }
            .slide-img { order: 1; margin-bottom: 40px; }
            .p-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="test-banner">⚠️ MODO DE PRUEBAS ACTIVO - VALIDACIÓN COMERCIAL EN CURSO ⚠️</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="logo">CajaYa<span style="color:var(--primary)">.</span></a>
            <div style="font-size: 11px; font-weight: 700; color:var(--gray)">CERTIFICACIÓN SII 2026</div>
        </div>
    </nav>

    <div class="hero">
        <div class="math-bg" id="mathBg"></div>
        <div class="c-container">
            <!-- SLIDE 1 -->
            <div class="slide active">
                <div class="slide-text">
                    <h2>Nuevo CajaYa Pro</h2>
                    <h1>Diseñado para<br><span class="gradient-text">Tu Éxito Comercial.</span></h1>
                    <p>El punto de venta m&aacute;s r&aacute;pido, robusto y elegante de Chile. Potencia tu negocio con tecnolog&iacute;a de clase mundial.</p>
                    <a href="#planes" class="btn-apple">Ver Planes</a>
                </div>
                <div class="slide-img">
                    <img src="banner1.png" alt="CajaYa POS">
                </div>
            </div>

            <!-- SLIDE 2 -->
            <div class="slide">
                <div class="slide-text">
                    <h2>Resiliencia Offline</h2>
                    <h1>Vende Sin Pausas.<br><span class="gradient-text">Sin Depender del Wi-Fi.</span></h1>
                    <p>Nuestro motor de datos local garantiza que nunca pierdas una venta. Sincronizaci&oacute;n autom&aacute;tica de alta velocidad.</p>
                    <a href="#planes" class="btn-apple">Empezar Ahora</a>
                </div>
                <div class="slide-img">
                    <img src="banner2.png" alt="Offline Mode">
                </div>
            </div>
        </div>

        <div class="c-nav">
            <div class="c-dot on" onclick="cGo(0)"></div>
            <div class="c-dot" onclick="cGo(1)"></div>
        </div>
    </div>

    <section class="section">
        <div class="reveal">
            <h2 style="font-size:32px; font-weight:800; letter-spacing:-1px;">Ingeniería de Primer Nivel</h2>
            <p style="color:var(--gray); margin-top:10px; font-size:18px;">Simplicidad en el exterior. Poder en el interior.</p>
        </div>
    </section>

    <section class="pricing" id="planes">
        <div class="p-grid">
            <div class="p-card reveal">
                <h4 style="font-size:12px; color:var(--primary); margin-bottom:10px;">MENSUAL</h4>
                <div class="p-price">$<?php echo $pMensual; ?></div>
                <ul class="p-features">
                    <li>1 Punto de Venta Full</li>
                    <li>Boletas Electrónicas SII</li>
                    <li>Inventario Inteligente</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-apple" style="width:100%; text-align:center; background:#eee; color:#000;">Comenzar</a>
            </div>
            <div class="p-card featured reveal">
                <h4 style="font-size:12px; color:var(--accent); margin-bottom:10px;">LIFETIME</h4>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:11px; color:var(--gray); margin-top:-10px;">UN SOLO PAGO PARA SIEMPRE</p>
                <ul class="p-features">
                    <li>3 Puntos de Venta Full</li>
                    <li>Boletas y Facturas SII</li>
                    <li>Actualizaciones de por vida</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-apple" style="width:100%; text-align:center;">Comprar Ahora</a>
            </div>
            <div class="p-card reveal">
                <h4 style="font-size:12px; color:var(--primary); margin-bottom:10px;">EMPRESA</h4>
                <div class="p-price">$<?php echo $pEmpresa; ?></div>
                <ul class="p-features">
                    <li>Terminales Ilimitados</li>
                    <li>Sincronización Multi-sucursal</li>
                    <li>Soporte 24/7 Prioritario</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-apple" style="width:100%; text-align:center; background:#eee; color:#000;">Contactar</a>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="f-grid">
            <div class="f-col">
                <h4>Producto</h4>
                <ul>
                    <li><a href="#">Características</a></li>
                    <li><a href="#planes">Planes</a></li>
                    <li><a href="#">Descargas</a></li>
                </ul>
            </div>
            <div class="f-col">
                <h4>Soporte</h4>
                <ul>
                    <li><a href="#">Centro de Ayuda</a></li>
                    <li><a href="https://wa.me/56912345678">WhatsApp</a></li>
                    <li><a href="#">Estado del SII</a></li>
                </ul>
            </div>
            <div class="f-col">
                <h4>Compañía</h4>
                <ul>
                    <li><a href="#">Sobre CajaYa</a></li>
                    <li><a href="#">Privacidad</a></li>
                    <li><a href="#">Legal</a></li>
                </ul>
            </div>
        </div>
        <div style="max-width:1100px; margin:60px auto 0; padding-top:20px; border-top:1px solid #eee; font-size:12px; display:flex; justify-content:space-between;">
            <p>&copy; 2026 CajaYa Chile. Todos los derechos reservados.</p>
            <p>Hecho con ❤️ por Reinaldo Arturo.</p>
        </div>
    </footer>

    <script>
        // Math Symbols Animation
        const symbols = ['+', '-', '%', '$', '=', '×', '÷'];
        const container = document.getElementById('mathBg');
        for (let i = 0; i < 35; i++) {
            const span = document.createElement('span');
            span.className = 'symbol';
            span.innerText = symbols[Math.floor(Math.random() * symbols.length)];
            span.style.left = Math.random() * 100 + 'vw';
            span.style.animationDuration = (Math.random() * 15 + 10) + 's';
            span.style.animationDelay = (Math.random() * 20) + 's';
            span.style.fontSize = (Math.random() * 20 + 15) + 'px';
            container.appendChild(span);
        }

        // Carousel Logic
        let cCur = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.c-dot');
        function cGo(n) {
            slides[cCur].classList.remove('active');
            dots[cCur].classList.remove('on');
            cCur = (n + slides.length) % slides.length;
            slides[cCur].classList.add('active');
            dots[cCur].classList.add('on');
        }
        setInterval(() => cGo(cCur + 1), 7000);

        // Scroll Reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>
</html>
