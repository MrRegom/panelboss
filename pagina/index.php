<?php
/**
 * index.php — Landing Page Dinámica (RESTAURADA AL 100%)
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/Database.php';
require_once __DIR__ . '/../src/Repositories/PlanRepository.php';

use App\Repositories\PlanRepository;

// Lógica de Precios Dinámicos
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
    <title>CajaYa — El Punto de Venta m&aacute;s r&aacute;pido de Chile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --apple-blue: #0071E3;
            --apple-gray: #1D1D1F;
            --apple-silver: #F5F5F7;
            --apple-muted: #86868B;
            --white: #FFFFFF;
            --border: rgba(0,0,0,0.1);
            --transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--white); color: var(--apple-gray); font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; overflow-x: hidden; }

        .test-banner { background: #FF9F0A; color: #000; text-align: center; padding: 12px; font-weight: 700; position: sticky; top: 0; z-index: 9999; font-size: 13px; letter-spacing: 0.5px; border-bottom: 2px solid rgba(0,0,0,0.1); }

        nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: saturate(180%) blur(20px); border-bottom: 1px solid var(--border); height: 52px; display: flex; align-items: center; justify-content: center; position: sticky; width: 100%; top: 40px; z-index: 2000; }
        .nav-content { width: 1024px; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .logo-fallback { font-weight: 700; color: var(--apple-gray); font-size: 1.2rem; letter-spacing: -0.5px; }

        .hero-wrap { position: relative; overflow: hidden; background: #fff; }
        .c-slide { display: none; align-items: center; min-height: 75vh; padding: 40px 6%; gap: 48px; position: relative; }
        .c-slide.active { display: flex; animation: slideIn 0.8s var(--transition); }
        @keyframes slideIn { from { opacity:0; transform: translateX(30px); } to { opacity:1; transform: translateX(0); } }

        .c-text { flex: 1; max-width: 580px; z-index: 2; }
        .c-h1 { font-size: clamp(2.2rem, 4.5vw, 4rem); font-weight: 800; letter-spacing: -0.03em; line-height: 1.08; color: #1D1D1F; margin-bottom: 18px; }
        .c-p { font-size: clamp(1rem, 1.6vw, 1.15rem); color: #515154; max-width: 440px; line-height: 1.65; margin-bottom: 30px; }
        
        .c-img { flex: 1.2; display: flex; justify-content: center; position: relative; z-index: 2; }
        .c-img img { width: 100%; max-width: 650px; filter: drop-shadow(0 30px 60px rgba(0,0,0,0.12)); border-radius: 12px; }

        .btn-apple { background: var(--apple-blue); color: white; padding: 12px 28px; border-radius: 980px; font-size: 17px; font-weight: 500; text-decoration: none; transition: var(--transition); display: inline-block; cursor: pointer; border: none; }
        .btn-apple:hover { transform: scale(1.04) translateY(-2px); box-shadow: 0 10px 20px rgba(0,113,227,0.25); }

        .c-controls { position: absolute; bottom: 40px; left: 50%; transform: translateX(-50%); display: flex; gap: 12px; z-index: 10; }
        .c-dot { width: 8px; height: 8px; background: #D2D2D7; border-radius: 50%; cursor: pointer; transition: 0.3s; }
        .c-dot.on { background: var(--apple-gray); width: 24px; border-radius: 10px; }

        .math-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none; z-index: 1; }
        .symbol { position: absolute; color: var(--apple-blue); opacity: 0.3; font-weight: 700; animation: float linear infinite; }
        @keyframes float { from { transform: translateY(110vh) rotate(0deg); } to { transform: translateY(-10vh) rotate(360deg); } }

        .section-title { font-size: clamp(1.8rem, 3.5vw, 2.8rem); font-weight: 700; text-align: center; margin-bottom: 12px; letter-spacing: -0.015em; }
        .pricing { padding: 100px 5% 120px; background: var(--apple-silver); }
        .price-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; max-width: 1200px; margin: 0 auto; }
        .p-card { background: white; padding: 48px 32px; border-radius: 28px; border: 1px solid var(--border); transition: var(--transition); position: relative; }
        .p-card:hover { transform: translateY(-10px); box-shadow: 0 30px 60px rgba(0,0,0,0.08); border-color: var(--apple-blue); }
        .p-card.featured { border: 2px solid var(--apple-blue); }
        .p-price { font-size: 52px; font-weight: 700; margin: 18px 0; letter-spacing: -0.04em; }
        .badge-rec { background: var(--apple-blue); color: white; font-size: 11px; font-weight: 700; padding: 5px 14px; border-radius: 20px; position: absolute; top: 24px; right: 24px; }
        
        .p-features { list-style: none; margin: 30px 0; font-size: 15px; }
        .p-features li { padding: 10px 0; border-bottom: 1px solid rgba(0,0,0,0.04); display: flex; align-items: center; gap: 10px; }
        .p-features li::before { content: '✓'; color: var(--apple-blue); font-weight: 800; }

        .testimonials { padding: 100px 8%; background: #fff; }
        .t-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 40px; margin-top: 60px; }
        .t-card { text-align: left; }
        .t-card p { font-size: 1.1rem; font-style: italic; color: #1D1D1F; line-height: 1.5; margin-bottom: 15px; }
        .t-author { font-weight: 600; font-size: 0.9rem; color: var(--apple-muted); }

        .faq { padding: 100px 8%; background: #fff; border-top: 1px solid var(--border); }
        .faq-box { max-width: 800px; margin: 60px auto 0; display: grid; gap: 32px; }
        .faq-item h4 { font-size: 18px; margin-bottom: 8px; font-weight: 600; }
        .faq-item p { color: var(--apple-muted); line-height: 1.6; }

        footer { background: #1D1D1F; padding: 60px 5%; text-align: center; color: #86868B; }
        footer a { color: #F5F5F7; text-decoration: none; margin: 0 15px; font-weight: 500; font-size: 14px; }

        .reveal { opacity: 0; transform: translateY(30px); transition: 0.8s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 900px) {
            .c-slide { flex-direction: column; text-align: center; padding-top: 60px; }
            .c-img img { max-width: 100%; }
            nav { top: 0; }
        }
    </style>
</head>
<body>

    <div class="test-banner">
        ⚠️ MODO DE PRUEBAS ACTIVO - LAS VENTAS ESTÁN EN FASE DE VALIDACIÓN ⚠️
    </div>

    <nav>
        <div class="nav-content">
            <a href="/" style="text-decoration:none"><span class="logo-fallback">CajaYa</span></a>
            <div style="font-size: 12px; color: var(--apple-muted); font-weight: 600;">SII Certificado 2026 🇨🇱</div>
        </div>
    </nav>

    <div class="hero-wrap">
        <div class="math-bg" id="mathBg"></div>

        <!-- SLIDE 1 -->
        <div class="c-slide active">
            <div class="c-text">
                <h1 class="c-h1">Tu negocio vende m&aacute;s.<br><span style="color:var(--apple-blue)">T&uacute; trabajas menos.</span></h1>
                <p class="c-p">El POS m&aacute;s r&aacute;pido de Chile. Certificado por el SII para Boletas Electr&oacute;nicas y Facturas.</p>
                <a href="#planes" class="btn-apple">Ver Planes</a>
            </div>
            <div class="c-img">
                <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&q=80&w=1000" alt="CajaYa POS">
            </div>
        </div>

        <!-- SLIDE 2 -->
        <div class="c-slide">
            <div class="c-text">
                <h1 class="c-h1">Sigue vendiendo,<br><span style="color:#34C759">incluso sin internet.</span></h1>
                <p class="c-p">Nuestro motor Offline robusto garantiza que nunca pierdas una venta. Sincronizaci&oacute;n autom&aacute;tica.</p>
                <a href="#planes" class="btn-apple" style="background:#34C759">Empezar Ahora</a>
            </div>
            <div class="c-img">
                <img src="https://images.unsplash.com/photo-1556740758-90de374c12ad?auto=format&fit=crop&q=80&w=1000" alt="Offline Mode">
            </div>
        </div>

        <div class="c-controls">
            <div class="c-dot on" onclick="cGo(0)"></div>
            <div class="c-dot" onclick="cGo(1)"></div>
        </div>
    </div>

    <section class="pricing" id="planes">
        <h2 class="section-title reveal">Planes para cada etapa</h2>
        <p style="text-align:center;color:var(--apple-muted);margin-bottom:60px;font-size:19px" class="reveal">Sin letras chicas. Sin sorpresas. Cancela cuando quieras.</p>
        <div class="price-grid">
            
            <!-- PLAN MENSUAL -->
            <div class="p-card reveal">
                <h3>Plan Mensual</h3>
                <div class="p-price">$<?php echo $pMensual; ?><span style="font-size:16px;font-weight:400">/mes</span></div>
                <p style="color:var(--apple-muted);font-size:14px">Ideal para empezar sin riesgo.</p>
                <ul class="p-features">
                    <li>1 Punto de Venta</li>
                    <li>Boletas Electrónicas SII</li>
                    <li>Inventario ilimitado</li>
                    <li>Soporte por WhatsApp</li>
                    <li>Actualizaciones incluidas</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-apple" style="background:transparent;color:var(--apple-blue);border:1px solid var(--apple-blue);display:block;text-align:center">Comenzar</a>
            </div>

            <!-- PLAN LIFETIME -->
            <div class="p-card featured reveal">
                <span class="badge-rec">⭐ Más Popular</span>
                <h3>Plan Lifetime</h3>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="color:var(--apple-muted);font-size:14px">Un solo pago. Tuyo para siempre.</p>
                <ul class="p-features">
                    <li>3 Puntos de Venta</li>
                    <li>Boletas y Facturas SII</li>
                    <li>Inventario ilimitado</li>
                    <li>Cierre de caja avanzado</li>
                    <li>Reportes y estadísticas</li>
                    <li>Soporte prioritario</li>
                    <li>Actualizaciones de por vida</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-apple" style="display:block;text-align:center">Comprar Ahora</a>
            </div>

            <!-- PLAN EMPRESA -->
            <div class="p-card reveal">
                <h3>Plan Empresa</h3>
                <div class="p-price">$<?php echo $pEmpresa; ?><span style="font-size:16px;font-weight:400">/mes</span></div>
                <p style="color:var(--apple-muted);font-size:14px">Para negocios en crecimiento.</p>
                <ul class="p-features">
                    <li>Cajas ilimitadas</li>
                    <li>Multi-sucursal</li>
                    <li>Boletas y Facturas SII</li>
                    <li>Reportes avanzados</li>
                    <li>API de integración</li>
                    <li>Soporte dedicado 24/7</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-apple" style="background:transparent;color:var(--apple-blue);border:1px solid var(--apple-blue);display:block;text-align:center">Contratar</a>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <h2 class="section-title reveal">+400 Pymes confían en CajaYa</h2>
        <div class="t-grid">
            <div class="t-card reveal">
                <p>"El cierre de caja pasó de ser una pesadilla a un clic. La boleta electrónica vuela."</p>
                <span class="t-author">Roberto M. — Minimarket</span>
            </div>
            <div class="t-card reveal">
                <p>"Dejé de pagar cuotas mensuales para siempre. El Plan Lifetime es la mejor inversión."</p>
                <span class="t-author">Sandra P. — Bazar</span>
            </div>
            <div class="t-card reveal">
                <p>"Si se corta el internet, seguimos vendiendo. El modo offline es realmente robusto."</p>
                <span class="t-author">Carlos V. — Ferretería</span>
            </div>
        </div>
    </section>

    <section class="faq" id="faq">
        <h2 class="section-title reveal">Preguntas Frecuentes</h2>
        <div class="faq-box">
            <div class="faq-item reveal"><h4>¿Cómo recibo mi licencia?</h4><p>Tras el pago con Mercado Pago, recibirás un correo instantáneo con tus credenciales y el link de descarga de la app.</p></div>
            <div class="faq-item reveal"><h4>¿Realmente funciona sin internet?</h4><p>Sí. CajaYa usa una base de datos local. Cuando vuelve la conexión, sincroniza automáticamente con el SII.</p></div>
            <div class="faq-item reveal"><h4>¿Qué pasa si tengo problemas?</h4><p>Tenemos soporte por WhatsApp disponible en horario comercial. El Plan Empresa incluye soporte 24/7.</p></div>
        </div>
    </section>

    <footer>
        <p style="margin-bottom:10px; font-size:16px; color:#F5F5F7; font-weight:600">CajaYa &copy; 2026 — Hecho en Chile 🇨🇱</p>
        <p><a href="#planes">Planes</a> <a href="#faq">FAQ</a> <a href="https://wa.me/56912345678">WhatsApp</a></p>
    </footer>

    <script>
        // Math background animation
        const symbols = ['+', '-', '%', '$', '=', '×', '÷'];
        const container = document.getElementById('mathBg');
        for (let i = 0; i < 30; i++) {
            const span = document.createElement('span');
            span.className = 'symbol';
            span.innerText = symbols[Math.floor(Math.random() * symbols.length)];
            span.style.left = Math.random() * 100 + 'vw';
            span.style.animationDuration = (Math.random() * 15 + 12) + 's';
            span.style.animationDelay = (Math.random() * 25) + 's';
            span.style.fontSize = (Math.random() * 18 + 14) + 'px';
            span.style.opacity = (Math.random() * 0.5 + 0.3);
            container.appendChild(span);
        }

        // iOS-style Scroll Reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, i * 80);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Carousel logic
        let cCur = 0;
        const cSlides = document.querySelectorAll('.c-slide');
        const cDots   = document.querySelectorAll('.c-dot');
        const cTotal  = cSlides.length;

        function cGo(n) {
            cSlides[cCur].classList.remove('active');
            cDots[cCur].classList.remove('on');
            cCur = (n + cTotal) % cTotal;
            cSlides[cCur].classList.add('active');
            cDots[cCur].classList.add('on');
        }
        function cMove(dir) { cGo(cCur + dir); }

        // Autoplay 5s
        let cTimer = setInterval(() => cMove(1), 5000);
    </script>
</body>
</html>
