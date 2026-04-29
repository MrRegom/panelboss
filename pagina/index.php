<?php
/**
 * index.php — Landing Page ENTERPRISE FULL (BANNER + FAQ + TESTIMONIOS)
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
    <title>CajaYa — El Poder de Vender m&aacute;s</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0071E3;
            --accent: #34C759;
            --dark: #09090b;
            --gray: #86868B;
            --light: #F5F5F7;
            --white: #FFFFFF;
            --transition: all 0.7s cubic-bezier(0.19, 1, 0.22, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--white); color: var(--dark); font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; overflow-x: hidden; }

        /* Navigation & Banner */
        .test-banner { background: #FF9F0A; color: #000; text-align: center; padding: 10px; font-weight: 700; position: sticky; top: 0; z-index: 9999; font-size: 11px; letter-spacing: 1px; }
        nav { background: rgba(255,255,255,0.8); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 64px; display: flex; align-items: center; justify-content: center; position: sticky; top: 36px; z-index: 2000; }
        .nav-content { width: 1200px; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; }
        .logo { font-weight: 800; font-size: 24px; text-decoration: none; color: var(--dark); }

        /* Full Width Carousel */
        .hero { position: relative; height: 85vh; min-height: 600px; background: #000; overflow: hidden; }
        .slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1.5s ease-in-out; display: flex; align-items: center; justify-content: center; }
        .slide.active { opacity: 1; }
        .slide-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
        .slide-bg img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.5) contrast(1.1); transition: transform 8s linear; }
        .slide.active .slide-bg img { transform: scale(1.15); }
        
        .slide-content { position: relative; z-index: 10; text-align: center; color: white; max-width: 1000px; padding: 0 40px; }
        .slide h1 { font-size: clamp(2.5rem, 6vw, 4.5rem); font-weight: 800; letter-spacing: -0.04em; line-height: 1.1; margin-bottom: 24px; }
        .slide p { font-size: clamp(1.1rem, 2vw, 1.4rem); font-weight: 300; opacity: 0.9; margin-bottom: 40px; }

        .btn-premium { background: var(--primary); color: white; padding: 18px 40px; border-radius: 100px; font-size: 18px; font-weight: 600; text-decoration: none; transition: 0.3s; display: inline-block; }
        .btn-premium:hover { transform: scale(1.05); box-shadow: 0 20px 40px rgba(0,113,227,0.3); }

        /* Benefits Section */
        .section { padding: 120px 8%; text-align: center; }
        .grid-3 { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; margin-top: 80px; }
        .feat-card { padding: 40px; border-radius: 30px; background: var(--light); transition: var(--transition); text-align: left; }
        .feat-card:hover { background: #fff; box-shadow: 0 30px 60px rgba(0,0,0,0.05); transform: translateY(-10px); }
        .feat-card i { font-size: 32px; color: var(--primary); margin-bottom: 24px; }
        .feat-card h3 { font-size: 22px; margin-bottom: 12px; }
        .feat-card p { color: var(--gray); line-height: 1.6; }

        /* Pricing Section */
        .pricing { background: var(--light); padding: 120px 5%; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 30px; max-width: 1200px; margin: 60px auto 0; }
        .p-card { background: white; padding: 60px 40px; border-radius: 40px; text-align: center; transition: var(--transition); border: 1px solid rgba(0,0,0,0.03); }
        .p-card.featured { background: var(--dark); color: white; transform: scale(1.05); box-shadow: 0 40px 80px rgba(0,0,0,0.1); }
        .p-price { font-size: 58px; font-weight: 800; margin: 20px 0; letter-spacing: -3px; }
        .p-features { list-style: none; margin: 40px 0; text-align: left; }
        .p-features li { padding: 12px 0; border-bottom: 1px solid rgba(0,0,0,0.05); font-size: 15px; display: flex; align-items: center; gap: 10px; }
        .featured .p-features li { border-color: rgba(255,255,255,0.08); }
        .p-features li::before { content: '✓'; color: var(--primary); font-weight: 800; }

        /* Testimonials */
        .testimonials { background: #fff; }
        .t-card { background: var(--light); padding: 40px; border-radius: 24px; text-align: left; }
        .t-card blockquote { font-size: 1.2rem; font-weight: 500; margin-bottom: 20px; line-height: 1.5; }
        .t-card cite { font-style: normal; color: var(--gray); font-weight: 600; font-size: 0.9rem; }

        /* FAQ */
        .faq { background: #fff; border-top: 1px solid rgba(0,0,0,0.05); }
        .faq-grid { max-width: 900px; margin: 60px auto 0; display: grid; gap: 32px; text-align: left; }
        .faq-item h4 { font-size: 20px; margin-bottom: 10px; }
        .faq-item p { color: var(--gray); line-height: 1.6; }

        footer { background: var(--dark); padding: 80px 5%; text-align: center; color: rgba(255,255,255,0.4); }
        footer a { color: #fff; text-decoration: none; margin: 0 15px; font-weight: 500; }
    </style>
</head>
<body>

    <div class="test-banner">⚠️ MODO DE PRUEBAS ACTIVO - LAS VENTAS ESTÁN EN FASE DE VALIDACIÓN ⚠️</div>

    <nav>
        <div class="nav-content">
            <a href="/" class="logo">CajaYa<span style="color:var(--primary)">.</span></a>
            <div style="font-weight:700; font-size:12px; opacity:0.6">SISTEMA CERTIFICADO 2026</div>
        </div>
    </nav>

    <section class="hero">
        <div class="slide active">
            <div class="slide-bg"><img src="banner1.png" alt="CajaYa Pro"></div>
            <div class="slide-content">
                <h1>Tu negocio en el<br><span style="color:var(--primary)">Siguiente Nivel.</span></h1>
                <p>El POS m&aacute;s r&aacute;pido de Chile. Boletas Electr&oacute;nicas y Facturas con tecnolog&iacute;a de punta.</p>
                <a href="#planes" class="btn-premium">Ver Planes de Inversi&oacute;n</a>
            </div>
        </div>
        <div class="slide">
            <div class="slide-bg"><img src="banner2.png" alt="Offline Mode"></div>
            <div class="slide-content">
                <h1>Ventas Sin Pausas,<br><span style="color:var(--accent)">Incluso Sin Internet.</span></h1>
                <p>Nuestra Resiliencia Offline asegura que nunca pierdas una venta. Sincronizaci&oacute;n inteligente al volver la red.</p>
                <a href="#planes" class="btn-premium" style="background:var(--accent)">Saber M&aacute;s</a>
            </div>
        </div>
    </section>

    <section class="section">
        <h2 style="font-size:42px; font-weight:800">¿Por qué elegir CajaYa?</h2>
        <div class="grid-3">
            <div class="feat-card">
                <i class="fa-solid fa-bolt"></i>
                <h3>Velocidad Extrema</h3>
                <p>Emite una boleta en menos de 3 segundos. Optimizamos cada proceso para que no pierdas tiempo.</p>
            </div>
            <div class="feat-card">
                <i class="fa-solid fa-cloud-slash"></i>
                <h3>Modo Offline Real</h3>
                <p>No dependas del Wi-Fi. CajaYa funciona 100% desconectado y sincroniza cuando detecta red.</p>
            </div>
            <div class="feat-card">
                <i class="fa-solid fa-shield-halved"></i>
                <h3>Certificado SII</h3>
                <p>Cumple con toda la normativa legal 2026. Boletas y facturas timbradas al instante.</p>
            </div>
        </div>
    </section>

    <section class="pricing" id="planes">
        <h2 style="font-size:42px; font-weight:800; text-align:center">Inversi&oacute;n Transparente</h2>
        <div class="p-grid">
            <div class="p-card">
                <h3 style="color:var(--primary); font-size:14px; letter-spacing:2px">PLAN MENSUAL</h3>
                <div class="p-price">$<?php echo $pMensual; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li>1 Punto de Venta Full</li>
                    <li>Boletas Electrónicas SII</li>
                    <li>Inventario Ilimitado</li>
                    <li>Soporte WhatsApp</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-premium" style="width:100%; text-align:center; background:var(--light); color:var(--dark)">Comenzar</a>
            </div>
            <div class="p-card featured">
                <h3 style="color:var(--accent); font-size:14px; letter-spacing:2px">PLAN LIFETIME</h3>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:12px; opacity:0.6; margin-top:-15px">UN SOLO PAGO PARA SIEMPRE</p>
                <ul class="p-features">
                    <li>3 Puntos de Venta Full</li>
                    <li>Boletas y Facturas SII</li>
                    <li>Reportes Business Intelligence</li>
                    <li>Actualizaciones de por vida</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-premium" style="width:100%; text-align:center">Adquirir Propiedad</a>
            </div>
            <div class="p-card">
                <h3 style="color:var(--primary); font-size:14px; letter-spacing:2px">PLAN EMPRESA</h3>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul class="p-features">
                    <li>Terminales Ilimitados</li>
                    <li>Gestión Multi-sucursal</li>
                    <li>API de Integración ERP</li>
                    <li>Soporte 24/7 Crítico</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-premium" style="width:100%; text-align:center; background:var(--light); color:var(--dark)">Contactar</a>
            </div>
        </div>
    </section>

    <section class="section testimonials">
        <h2 style="font-size:32px; font-weight:800; margin-bottom:60px">Lo que dicen nuestros clientes</h2>
        <div class="grid-3">
            <div class="t-card">
                <blockquote>"CajaYa transform&oacute; mi negocio. El Plan Lifetime es la mejor inversi&oacute;n que he hecho."</blockquote>
                <cite>— Roberto M., Due&ntilde;o de Minimarket</cite>
            </div>
            <div class="t-card">
                <blockquote>"La velocidad de emisi&oacute;n es incre&iacute;ble. Mis clientes ya no hacen filas."</blockquote>
                <cite>— Sandra P., Administradora de Bazar</cite>
            </div>
            <div class="t-card">
                <blockquote>"El soporte técnico es de primer nivel. Siempre responden rápido por WhatsApp."</blockquote>
                <cite>— Carlos V., Due&ntilde;o de Ferreter&iacute;a</cite>
            </div>
        </div>
    </section>

    <section class="section faq" id="faq">
        <h2 style="font-size:32px; font-weight:800">Preguntas Frecuentes</h2>
        <div class="faq-grid">
            <div class="faq-item">
                <h4>¿C&oacute;mo recibo mi licencia?</h4>
                <p>Tras el pago, recibir&aacute;s un correo instant&aacute;neo con tu llave de activaci&oacute;n y manual de instalaci&oacute;n.</p>
            </div>
            <div class="faq-item">
                <h4>¿Funciona con mi impresora t&eacute;rmica?</h4>
                <p>Compatible con el 99% de impresoras t&eacute;rmicas del mercado (58mm y 80mm).</p>
            </div>
            <div class="faq-item">
                <h4>¿Qué pasa si no tengo internet?</h4>
                <p>Puedes seguir vendiendo normalmente. Las boletas se env&iacute;an al SII autom&aacute;ticamente cuando recuperas la conexi&oacute;n.</p>
            </div>
        </div>
    </section>

    <footer>
        <h2 style="color:#fff; margin-bottom:40px">CajaYa<span style="color:var(--primary)">.</span></h2>
        <div style="margin-bottom:40px">
            <a href="#planes">Planes</a>
            <a href="#faq">FAQ</a>
            <a href="https://wa.me/56912345678">WhatsApp</a>
        </div>
        <p>&copy; 2026 CajaYa. Hecho con ❤️ por Mr.Yo para el mundo.</p>
    </footer>

    <script>
        // Carousel Logic
        let cur = 0;
        const slides = document.querySelectorAll('.slide');
        setInterval(() => {
            slides[cur].classList.remove('active');
            cur = (cur + 1) % slides.length;
            slides[cur].classList.add('active');
        }, 6000);

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
