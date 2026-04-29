<?php
/**
 * index.php — Landing Page MASTER PRO (VERSION DEFINITIVA)
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
            --dark: #1D1D1F;
            --gray: #86868B;
            --light: #F5F5F7;
            --white: #FFFFFF;
            --transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--white); color: var(--dark); font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; overflow-x: hidden; }

        /* Global Components */
        .test-banner { background: #FF9F0A; color: #000; text-align: center; padding: 10px; font-weight: 700; position: fixed; top: 0; width: 100%; z-index: 9999; font-size: 11px; letter-spacing: 1px; }
        nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: saturate(180%) blur(20px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 64px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 38px; z-index: 2000; }
        .nav-content { width: 1200px; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; }
        .logo { font-weight: 800; font-size: 24px; text-decoration: none; color: var(--dark); }

        /* Master Hero Section (iMac Style) */
        .hero { position: relative; width: 100%; height: 85vh; background: var(--white); overflow: hidden; padding-top: 100px; }
        .slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1.5s ease; display: flex; align-items: center; justify-content: center; pointer-events: none; }
        .slide.active { opacity: 1; pointer-events: auto; }
        
        .slide-content { width: 1200px; display: flex; align-items: center; justify-content: space-between; padding: 0 60px; }
        .slide-text { flex: 1; max-width: 600px; }
        .slide-img { flex: 1; display: flex; justify-content: flex-end; }
        .slide-img img { width: 100%; max-width: 650px; filter: drop-shadow(0 40px 80px rgba(0,0,0,0.1)); transition: transform 1.2s var(--transition); }
        .active .slide-img img { transform: scale(1.05) translateY(-20px); }

        .slide h1 { font-size: clamp(2.8rem, 5vw, 4.5rem); font-weight: 800; line-height: 1.05; letter-spacing: -0.04em; color: var(--dark); margin-bottom: 24px; }
        .slide p { font-size: clamp(1.1rem, 1.6vw, 1.4rem); color: var(--gray); font-weight: 400; line-height: 1.6; margin-bottom: 40px; }
        .btn-apple { background: var(--primary); color: white; padding: 18px 45px; border-radius: 980px; font-size: 19px; font-weight: 600; text-decoration: none; display: inline-block; transition: 0.3s; }
        .btn-apple:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,113,227,0.3); }

        .c-nav { position: absolute; bottom: 40px; width: 100%; display: flex; justify-content: center; gap: 15px; z-index: 100; }
        .c-dot { width: 12px; height: 12px; background: #D2D2D7; border-radius: 50%; cursor: pointer; transition: 0.4s; }
        .c-dot.on { background: var(--dark); transform: scale(1.4); }

        /* Animation Layer */
        .math-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none; z-index: 1; }
        .symbol { position: absolute; color: var(--primary); opacity: 0.07; font-weight: 800; animation: float linear infinite; }
        @keyframes float { from { transform: translateY(110vh) rotate(0deg); } to { transform: translateY(-10vh) rotate(360deg); } }

        /* Features Section */
        .section { padding: 120px 10%; text-align: center; }
        .grid-3 { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px; margin-top: 80px; }
        .feat-card { padding: 50px 40px; border-radius: 35px; background: var(--light); text-align: left; transition: var(--transition); }
        .feat-card:hover { transform: translateY(-10px); background: #fff; box-shadow: 0 40px 80px rgba(0,0,0,0.05); }
        .feat-card i { font-size: 40px; color: var(--primary); margin-bottom: 30px; }
        .feat-card h3 { font-size: 24px; margin-bottom: 15px; font-weight: 700; }
        .feat-card p { color: var(--gray); line-height: 1.6; font-size: 16px; }

        /* Pricing Section */
        .pricing { background: var(--light); padding: 120px 5%; border-radius: 60px 60px 0 0; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 30px; max-width: 1200px; margin: 60px auto 0; }
        .p-card { background: white; padding: 60px 40px; border-radius: 40px; text-align: left; transition: var(--transition); }
        .p-card:hover { transform: scale(1.02); box-shadow: 0 40px 80px rgba(0,0,0,0.05); }
        .p-card.featured { border: 2px solid var(--primary); transform: scale(1.03); }
        .p-price { font-size: 64px; font-weight: 800; margin: 30px 0; letter-spacing: -3px; }
        .p-features { list-style: none; margin: 40px 0; }
        .p-features li { padding: 12px 0; border-bottom: 1px solid rgba(0,0,0,0.04); font-size: 16px; display: flex; align-items: center; gap: 12px; color: var(--gray); }
        .p-features li::before { content: '✓'; color: var(--primary); font-weight: 800; }

        /* FAQ Section */
        .faq { padding: 120px 10%; background: #fff; }
        .faq-grid { max-width: 900px; margin: 80px auto 0; display: grid; gap: 40px; text-align: left; }
        .faq-item h4 { font-size: 22px; font-weight: 700; margin-bottom: 12px; }
        .faq-item p { color: var(--gray); line-height: 1.7; font-size: 17px; }

        /* Master Footer (Corporate Style) */
        .footer { background: #fff; border-top: 1px solid rgba(0,0,0,0.05); padding: 120px 10% 60px; }
        .f-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 60px; max-width: 1200px; margin: 0 auto; }
        .f-col h4 { font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 30px; color: var(--dark); }
        .f-col ul { list-style: none; }
        .f-col ul li { margin-bottom: 15px; }
        .f-col a { color: var(--gray); text-decoration: none; font-size: 15px; transition: 0.2s; }
        .f-col a:hover { color: var(--primary); text-decoration: underline; }
        
        .f-bottom { max-width: 1200px; margin: 80px auto 0; padding-top: 40px; border-top: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; color: var(--gray); font-size: 14px; }

        .reveal { opacity: 0; transform: translateY(40px); transition: 1.2s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 1000px) {
            .slide-content { flex-direction: column; text-align: center; }
            .slide-text { max-width: 100%; order: 2; margin-top: 40px; }
            .slide-img { order: 1; }
            .p-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="test-banner">⚠️ MODO DE PRUEBAS ACTIVO - INTEGRACIÓN COMERCIAL SII 2026 ⚠️</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="logo">CajaYa<span style="color:var(--primary)">.</span></a>
            <div style="font-weight:700; font-size:12px; color:var(--gray)">TECNOLOGÍA SII CERTIFICADA 🇨🇱</div>
        </div>
    </nav>

    <div class="hero">
        <div class="math-bg" id="mathBg"></div>
        <div class="c-container">
            <!-- SLIDE 1 -->
            <div class="slide active">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1 style="color:var(--primary)">CajaYa Pro</h1>
                        <h1>Tu Negocio Merece<br>Tecnología de Clase Mundial.</h1>
                        <p>El POS más avanzado de Chile. Emisión de boletas instantánea, reportes en tiempo real y una experiencia de usuario que te encantará.</p>
                        <a href="#planes" class="btn-apple">Ver Planes de Inversión</a>
                    </div>
                    <div class="slide-img">
                        <img src="banner1.png" alt="CajaYa System">
                    </div>
                </div>
            </div>

            <!-- SLIDE 2 -->
            <div class="slide">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1 style="color:var(--accent)">Resiliencia Total</h1>
                        <h1>Vende Sin Interrupciones,<br>Sin Depender del Internet.</h1>
                        <p>Nuestro motor Offline garantiza que tu negocio nunca se detenga. Sincronización automática de alta seguridad certificada por el SII.</p>
                        <a href="#planes" class="btn-apple">Comenzar Ahora</a>
                    </div>
                    <div class="slide-img">
                        <img src="banner2.png" alt="CajaYa Offline">
                    </div>
                </div>
            </div>
        </div>

        <div class="c-nav">
            <div class="c-dot on" onclick="cGo(0)"></div>
            <div class="c-dot" onclick="cGo(1)"></div>
        </div>
    </div>

    <section class="section">
        <h2 style="font-size:42px; font-weight:800; letter-spacing:-2px;" class="reveal">Ingeniería que Potencia tu Empresa</h2>
        <div class="grid-3">
            <div class="feat-card reveal">
                <i class="fa-solid fa-bolt"></i>
                <h3>Velocidad SII</h3>
                <p>Emite documentos tributarios en menos de 2 segundos. Cumple con la normativa 2026 de forma automática y transparente.</p>
            </div>
            <div class="feat-card reveal">
                <i class="fa-solid fa-cloud-slash"></i>
                <h3>Modo Offline Pro</h3>
                <p>Base de datos local robusta. Sigue operando en zonas sin cobertura o ante caídas de red sin perder ni una sola venta.</p>
            </div>
            <div class="feat-card reveal">
                <i class="fa-solid fa-chart-line"></i>
                <h3>Control Total</h3>
                <p>Gestiona inventarios, cierres de caja y multi-sucursales desde una interfaz intuitiva diseñada para dueños de negocios.</p>
            </div>
        </div>
    </section>

    <section class="pricing" id="planes">
        <h2 style="font-size:48px; font-weight:800; text-align:center; margin-bottom:80px;" class="reveal">Inversión en Crecimiento</h2>
        <div class="p-grid">
            <div class="p-card reveal">
                <h4 style="color:var(--primary); font-size:13px; letter-spacing:2px;">PLAN MENSUAL</h4>
                <div class="p-price">$<?php echo $pMensual; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li>1 Punto de Venta Full</li>
                    <li>Boletas Electrónicas SII</li>
                    <li>Inventario Inteligente</li>
                    <li>Soporte Técnico WhatsApp</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-apple" style="width:100%; text-align:center; background:#eee; color:#000;">Seleccionar</a>
            </div>
            <div class="p-card featured reveal">
                <h4 style="color:var(--accent); font-size:13px; letter-spacing:2px;">PLAN LIFETIME</h4>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:12px; color:var(--gray); margin-top:-15px;">PAGO ÚNICO. PROPIEDAD DE POR VIDA.</p>
                <ul class="p-features">
                    <li>3 Puntos de Venta Full</li>
                    <li>Boletas y Facturas SII</li>
                    <li>Reportes Business Intelligence</li>
                    <li>Actualizaciones Eternas</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-apple" style="width:100%; text-align:center;">Comprar Ahora</a>
            </div>
            <div class="p-card reveal">
                <h4 style="color:var(--primary); font-size:13px; letter-spacing:2px;">PLAN EMPRESA</h4>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li>Cajas Ilimitadas</li>
                    <li>Gestión Multi-Sucursal</li>
                    <li>API para Integración ERP</li>
                    <li>Soporte Crítico 24/7</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-apple" style="width:100%; text-align:center; background:#eee; color:#000;">Contactar</a>
            </div>
        </div>
    </section>

    <section class="faq" id="faq">
        <h2 style="font-size:42px; font-weight:800; text-align:center;" class="reveal">Preguntas Frecuentes</h2>
        <div class="faq-grid">
            <div class="faq-item reveal">
                <h4>¿Cómo recibo mi licencia?</h4>
                <p>Tras validar tu pago vía Mercado Pago, recibirás un correo electrónico automático con tu llave de activación y el enlace de descarga oficial.</p>
            </div>
            <div class="faq-item reveal">
                <h4>¿Es compatible con mi impresora?</h4>
                <p>CajaYa es compatible con todas las impresoras térmicas (58mm y 80mm) con conexión USB, Bluetooth o Red en el mercado chileno.</p>
            </div>
            <div class="faq-item reveal">
                <h4>¿Cómo funciona la integración SII?</h4>
                <p>Estamos certificados. Solo cargas tus certificados digitales en la app y comienzas a emitir boletas legales al instante sin trámites adicionales.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="f-grid">
            <div class="f-col">
                <a href="#" class="logo" style="font-size:32px;">CajaYa.</a>
                <p style="margin-top:20px; font-size:16px; color:var(--gray);">Liderando la revolución del POS inteligente en Chile.</p>
            </div>
            <div class="f-col">
                <h4>Producto</h4>
                <ul>
                    <li><a href="#">Características</a></li>
                    <li><a href="#planes">Planes</a></li>
                    <li><a href="#">Casos de Éxito</a></li>
                    <li><a href="#">Descargas</a></li>
                </ul>
            </div>
            <div class="f-col">
                <h4>Soporte</h4>
                <ul>
                    <li><a href="#">Centro de Ayuda</a></li>
                    <li><a href="https://wa.me/56912345678">WhatsApp Directo</a></li>
                    <li><a href="#">Video Tutoriales</a></li>
                    <li><a href="#">Estado del Servicio</a></li>
                </ul>
            </div>
            <div class="f-col">
                <h4>Empresa</h4>
                <ul>
                    <li><a href="#">Sobre Nosotros</a></li>
                    <li><a href="#">Certificación SII</a></li>
                    <li><a href="#">Privacidad</a></li>
                    <li><a href="#">Términos Legales</a></li>
                </ul>
            </div>
        </div>
        <div class="f-bottom">
            <p>&copy; 2026 CajaYa Technologies S.A. Todos los derechos reservados.</p>
            <p>Hecho con Ingeniería Superior en Chile 🇨🇱</p>
        </div>
    </footer>

    <script>
        // Math Animation
        const symbols = ['+', '-', '%', '$', '=', '×', '÷'];
        const container = document.getElementById('mathBg');
        for (let i = 0; i < 40; i++) {
            const span = document.createElement('span');
            span.className = 'symbol';
            span.innerText = symbols[Math.floor(Math.random() * symbols.length)];
            span.style.left = Math.random() * 100 + 'vw';
            span.style.animationDuration = (Math.random() * 15 + 10) + 's';
            span.style.animationDelay = (Math.random() * 20) + 's';
            span.style.fontSize = (Math.random() * 22 + 15) + 'px';
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
