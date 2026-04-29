<?php
/**
 * index.php — Landing Page ENTERPRISE MASTER (FINAL REFINEMENT)
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/Database.php';
require_once __DIR__ . '/../src/Repositories/PlanRepository.php';

use App\Repositories\PlanRepository;

$planRepo = new PlanRepository();
$plansRaw = $planRepo->getAll();
$plans = [];
foreach ($plansRaw as $p) { $plans[$p['slug']] = $p; }

// Solo los 3 planes que queremos mostrar
$pMensual  = number_format($plans['mensual']['price']  ?? 20000, 0, ',', '.');
$pLifetime = number_format($plans['lifetime']['price'] ?? 180000, 0, ',', '.');
$pEmpresa  = number_format($plans['empresa']['price']  ?? 35000, 0, ',', '.');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CajaYa — Tecnología Superior en Puntos de Venta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0071E3;
            --accent: #34C759;
            --dark: #000000;
            --gray: #86868B;
            --light: #F5F5F7;
            --white: #FFFFFF;
            --transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; outline: none; }
        body { background-color: var(--white); color: var(--dark); font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; overflow-x: hidden; }

        /* Banner & Navigation */
        .test-banner { background: #FF9F0A; color: #000; text-align: center; padding: 10px; font-weight: 700; position: sticky; top: 0; z-index: 9999; font-size: 11px; letter-spacing: 1px; }
        nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: saturate(180%) blur(20px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 60px; display: flex; align-items: center; justify-content: center; position: sticky; width: 100%; top: 36px; z-index: 2000; }
        .nav-content { width: 1200px; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; }
        .logo { font-weight: 800; font-size: 24px; text-decoration: none; color: var(--dark); }

        /* Full Width Hero Carousel */
        .hero { position: relative; width: 100%; height: 90vh; background: #000; overflow: hidden; }
        .c-container { width: 100%; height: 100%; position: relative; }
        .slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1.5s ease-in-out, transform 1.5s var(--transition); display: flex; align-items: center; justify-content: center; transform: scale(1.1); pointer-events: none; }
        .slide.active { opacity: 1; transform: scale(1); pointer-events: auto; }
        .slide-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
        .slide-bg img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.6) contrast(1.1); }
        .slide-bg::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.4)); }

        .slide-content { position: relative; z-index: 5; text-align: center; color: var(--white); max-width: 950px; padding: 0 30px; }
        .slide h1 { font-size: clamp(2.5rem, 6vw, 4.5rem); font-weight: 800; line-height: 1.05; letter-spacing: -0.04em; margin-bottom: 24px; }
        .slide p { font-size: clamp(1.1rem, 1.8vw, 1.4rem); opacity: 0.9; margin-bottom: 40px; font-weight: 300; }

        .btn-premium { background: var(--primary); color: white; padding: 18px 45px; border-radius: 100px; font-size: 18px; font-weight: 600; text-decoration: none; display: inline-block; transition: var(--transition); border: 2px solid transparent; }
        .btn-premium:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,113,227,0.4); }

        .c-nav { position: absolute; bottom: 40px; width: 100%; display: flex; justify-content: center; gap: 12px; z-index: 100; }
        .c-dot { width: 10px; height: 10px; background: rgba(255,255,255,0.3); border-radius: 50%; cursor: pointer; transition: 0.4s; }
        .c-dot.on { background: var(--white); transform: scale(1.4); }

        /* Math Symbols Background */
        .math-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none; z-index: 1; }
        .symbol { position: absolute; color: var(--primary); opacity: 0.15; font-weight: 800; animation: float linear infinite; }
        @keyframes float { from { transform: translateY(110vh) rotate(0deg); } to { transform: translateY(-10vh) rotate(360deg); } }

        /* Pricing Section */
        .pricing { padding: 120px 5%; background: var(--light); position: relative; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto; }
        .p-card { background: var(--white); padding: 60px 40px; border-radius: 35px; border: 1px solid rgba(0,0,0,0.03); transition: var(--transition); text-align: center; }
        .p-card:hover { transform: translateY(-15px); box-shadow: 0 40px 80px rgba(0,0,0,0.08); border-color: var(--primary); }
        .p-card.featured { background: var(--dark); color: var(--white); transform: scale(1.05); }
        .p-price { font-size: 60px; font-weight: 800; margin: 25px 0; letter-spacing: -3px; }
        .p-features { list-style: none; margin: 40px 0; text-align: left; }
        .p-features li { padding: 12px 0; border-bottom: 1px solid rgba(0,0,0,0.05); font-size: 15px; display: flex; align-items: center; gap: 12px; }
        .featured .p-features li { border-color: rgba(255,255,255,0.08); }
        .p-features li::before { content: '✓'; color: var(--primary); font-weight: 800; }

        /* Big Corporate Footer */
        .footer { background: var(--white); padding: 100px 8% 40px; border-top: 1px solid rgba(0,0,0,0.05); }
        .f-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; max-width: 1200px; margin: 0 auto; }
        .f-col h4 { font-size: 14px; font-weight: 700; color: var(--dark); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 25px; }
        .f-col ul { list-style: none; }
        .f-col ul li { margin-bottom: 12px; }
        .f-col ul li a { color: var(--gray); text-decoration: none; font-size: 14px; transition: 0.3s; }
        .f-col ul li a:hover { color: var(--primary); }
        
        .f-bottom { max-width: 1200px; margin: 80px auto 0; padding-top: 30px; border-top: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; color: var(--gray); font-size: 12px; }

        /* Reveal Animation */
        .reveal { opacity: 0; transform: translateY(40px); transition: 1s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 768px) {
            .f-bottom { flex-direction: column; gap: 20px; text-align: center; }
            nav { top: 0; }
        }
    </style>
</head>
<body>

    <div class="test-banner">⚠️ MODO DE PRUEBAS ACTIVO - VALIDACIÓN COMERCIAL EN CURSO ⚠️</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="logo">CajaYa<span style="color:var(--primary)">.</span></a>
            <div style="font-size: 11px; font-weight: 800; letter-spacing: 1px; opacity:0.6">TECNOLOGÍA SII CERTIFICADA</div>
        </div>
    </nav>

    <div class="hero">
        <div class="c-container">
            <div class="slide active">
                <div class="slide-bg"><img src="banner1.png" alt="CajaYa Enterprise"></div>
                <div class="slide-content">
                    <h1>La Solución Maestra para<br><span style="color:var(--primary)">Tu Punto de Venta.</span></h1>
                    <p>Velocidad, Resiliencia y Control Total. Diseñado para empresas que no aceptan menos que la perfección.</p>
                    <a href="#planes" class="btn-premium">Descubrir Planes</a>
                </div>
            </div>
            <div class="slide">
                <div class="slide-bg"><img src="banner2.png" alt="CajaYa Connect"></div>
                <div class="slide-content">
                    <h1>Sincronización Inteligente<br><span style="color:var(--accent)">Sin Depender de la Red.</span></h1>
                    <p>Nuestro motor de datos garantiza operatividad 24/7. Vende, emite y controla, incluso en los entornos más aislados.</p>
                    <a href="#planes" class="btn-premium" style="background:var(--accent)">Empezar Ahora</a>
                </div>
            </div>
        </div>
        <div class="c-nav">
            <div class="c-dot on" onclick="cGo(0)"></div>
            <div class="c-dot" onclick="cGo(1)"></div>
        </div>
    </div>

    <section class="section" style="padding:100px 8%; text-align:center; position:relative;">
        <div class="math-bg" id="mathBg"></div>
        <h2 style="font-size:42px; font-weight:800; margin-bottom:60px;" class="reveal">Ingeniería que Convierte</h2>
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:40px; position:relative; z-index:10;">
            <div class="reveal">
                <i class="fa-solid fa-microchip" style="font-size:40px; color:var(--primary); margin-bottom:20px;"></i>
                <h3>Arquitectura Robusta</h3>
                <p style="color:var(--gray); margin-top:15px;">Construido sobre PostgreSQL y PHP 8.3 para garantizar estabilidad bajo carga extrema.</p>
            </div>
            <div class="reveal">
                <i class="fa-solid fa-bolt-lightning" style="font-size:40px; color:var(--primary); margin-bottom:20px;"></i>
                <h3>Velocidad de Respuesta</h3>
                <p style="color:var(--gray); margin-top:15px;">Emisión de documentos tributarios en milisegundos. Sin esperas, sin errores.</p>
            </div>
            <div class="reveal">
                <i class="fa-solid fa-earth-americas" style="font-size:40px; color:var(--primary); margin-bottom:20px;"></i>
                <h3>Multi-Sucursal</h3>
                <p style="color:var(--gray); margin-top:15px;">Controla 1 o 100 locales desde una sola consola centralizada en la nube.</p>
            </div>
        </div>
    </section>

    <section class="pricing" id="planes">
        <h2 style="font-size:48px; font-weight:800; text-align:center; margin-bottom:80px;" class="reveal">Planes Corporativos</h2>
        <div class="p-grid">
            <div class="p-card reveal">
                <div style="font-weight:700; color:var(--primary); font-size:12px; letter-spacing:2px;">MENSUAL</div>
                <div class="p-price">$<?php echo $pMensual; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li>1 Punto de Venta Full</li>
                    <li>Boletas Electrónicas SII</li>
                    <li>Inventario Inteligente</li>
                    <li>Soporte Técnico WhatsApp</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-premium" style="width:100%; background:var(--light); color:var(--dark);">Seleccionar</a>
            </div>
            <div class="p-card featured reveal">
                <div style="font-weight:700; color:var(--accent); font-size:12px; letter-spacing:2px;">LIFETIME</div>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:11px; opacity:0.6; margin-top:-15px;">UN SOLO PAGO. PROPIEDAD TOTAL.</p>
                <ul class="p-features">
                    <li>3 Puntos de Venta Full</li>
                    <li>Boletas y Facturas SII</li>
                    <li>Módulo de Gestión Avanzada</li>
                    <li>Actualizaciones de por Vida</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-premium" style="width:100%;">Comprar Ahora</a>
            </div>
            <div class="p-card reveal">
                <div style="font-weight:700; color:var(--primary); font-size:12px; letter-spacing:2px;">EMPRESA</div>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li>Cajas Ilimitadas</li>
                    <li>Sincronización Multi-Local</li>
                    <li>API para Integraciones</li>
                    <li>Soporte 24/7 Prioritario</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-premium" style="width:100%; background:var(--light); color:var(--dark);">Contactar</a>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="f-grid">
            <div class="f-col">
                <a href="#" class="logo">CajaYa<span style="color:var(--primary)">.</span></a>
                <p style="margin-top:20px; font-size:14px; color:var(--gray);">Liderando la transformación digital del retail en Chile.</p>
            </div>
            <div class="f-col">
                <h4>Producto</h4>
                <ul>
                    <li><a href="#">Características</a></li>
                    <li><a href="#planes">Planes y Precios</a></li>
                    <li><a href="#">Certificación SII</a></li>
                    <li><a href="#">Descargas</a></li>
                </ul>
            </div>
            <div class="f-col">
                <h4>Soporte</h4>
                <ul>
                    <li><a href="#">Centro de Ayuda</a></li>
                    <li><a href="#">Video Tutoriales</a></li>
                    <li><a href="https://wa.me/56912345678">WhatsApp Soporte</a></li>
                    <li><a href="#">Estado del Servicio</a></li>
                </ul>
            </div>
            <div class="f-col">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#">Términos de Uso</a></li>
                    <li><a href="#">Privacidad</a></li>
                    <li><a href="#">Políticas SII</a></li>
                </ul>
            </div>
        </div>
        <div class="f-bottom">
            <p>&copy; 2026 CajaYa Technologies S.A. Todos los derechos reservados.</p>
            <p>Hecho en Chile 🇨🇱 con Ingeniería Superior.</p>
        </div>
    </footer>

    <script>
        // Math Symbols Animation
        const symbols = ['+', '-', '%', '$', '=', '×', '÷'];
        const container = document.getElementById('mathBg');
        for (let i = 0; i < 40; i++) {
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
        setInterval(() => cGo(cCur + 1), 6000);

        // Scroll Reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({ behavior: 'smooth' });
            });
        });
    </script>
</body>
</html>
