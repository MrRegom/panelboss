<?php
/**
 * index.php — Landing Page Dinámica
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Config/Database.php';
require_once __DIR__ . '/src/Repositories/PlanRepository.php';

use App\Repositories\PlanRepository;

$planRepo = new PlanRepository();
$plansRaw = $planRepo->getAll();
$plans = [];

// Indexar planes por slug para fácil acceso
foreach ($plansRaw as $p) {
    $plans[$p['slug']] = $p;
}

// Precios por defecto si la BD falla (fallback)
$pMensual  = number_format($plans['mensual']['price']  ?? 20000, 0, ',', '.');
$pLifetime = number_format($plans['lifetime']['price'] ?? 180000, 0, ',', '.');
$pEmpresa  = number_format($plans['empresa']['price']  ?? 35000, 0, ',', '.');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajaYa - El Punto de Venta más rápido de Chile</title>
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

        .test-banner { background: #FF9F0A; color: #000; text-align: center; padding: 12px; font-weight: 700; position: sticky; top: 0; z-index: 9999; font-size: 13px; letter-spacing: 0.5px; }

        nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: saturate(180%) blur(20px); border-bottom: 1px solid var(--border); height: 52px; display: flex; align-items: center; justify-content: center; position: sticky; width: 100%; top: 40px; z-index: 2000; }
        .nav-content { width: 1024px; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .logo-fallback { font-weight: 700; color: var(--apple-gray); font-size: 1.2rem; letter-spacing: -0.5px; }

        .hero-wrap { position: relative; overflow: hidden; padding-top: 50px; }
        .c-slide { display: flex; align-items: center; min-height: 70vh; padding: 40px 6%; gap: 48px; }
        .c-h1 { font-size: clamp(2.2rem, 4.5vw, 4rem); font-weight: 800; letter-spacing: -0.03em; line-height: 1.08; color: #1D1D1F; margin-bottom: 18px; }
        .c-p { font-size: clamp(1rem, 1.6vw, 1.15rem); color: #515154; max-width: 440px; line-height: 1.65; margin-bottom: 30px; }

        .btn-apple { background: var(--apple-blue); color: white; padding: 12px 28px; border-radius: 980px; font-size: 17px; font-weight: 500; text-decoration: none; transition: var(--transition); display: inline-block; }
        .btn-apple:hover { transform: scale(1.05); background: #0077ED; }

        .pricing { padding: 80px 5%; background: #fff; text-align: center; }
        .section-title { font-size: 40px; font-weight: 700; margin-bottom: 50px; }
        .price-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; max-width: 1100px; margin: 0 auto; }
        .p-card { padding: 50px 30px; border-radius: 32px; border: 1px solid var(--border); transition: 0.3s; }
        .p-card.featured { border: 2px solid var(--apple-blue); transform: scale(1.05); }
        .p-price { font-size: 48px; font-weight: 700; margin: 20px 0; }
        .badge-rec { background: var(--apple-blue); color: #fff; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 980px; text-transform: uppercase; margin-bottom: 16px; display: inline-block; }
        
        .p-features { list-style: none; text-align: left; margin: 20px 0; font-size: 14px; color: var(--apple-muted); }
        .p-features li { padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .p-features li::before { content: '✓ '; color: var(--apple-blue); font-weight: 700; }

        footer { background: #1D1D1F; color: #86868B; text-align: center; padding: 40px; font-size: 13px; }
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

    <section class="hero-wrap">
        <div class="c-slide">
            <div class="c-text">
                <h1 class="c-h1">Tu negocio vende m&aacute;s.<br><span style="color:var(--apple-blue)">T&uacute; trabajas menos.</span></h1>
                <p class="c-p">El POS m&aacute;s r&aacute;pido de Chile. 100% Offline y Boletas Electr&oacute;nicas.</p>
                <a href="#planes" class="btn-apple">Ver Planes</a>
            </div>
        </div>
    </section>

    <section class="pricing" id="planes">
        <h2 class="section-title">Planes para tu negocio</h2>
        <div class="price-grid">
            
            <!-- PLAN MENSUAL -->
            <div class="p-card">
                <h3>Plan Mensual</h3>
                <div class="p-price">$<?php echo $pMensual; ?></div>
                <p style="color:var(--apple-muted)">Ideal para empezar.</p>
                <ul class="p-features">
                    <li>1 Punto de Venta</li>
                    <li>Boletas Electrónicas SII</li>
                    <li>Soporte WhatsApp</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-apple" style="width:100%">Elegir Plan</a>
            </div>

            <!-- PLAN LIFETIME -->
            <div class="p-card featured">
                <span class="badge-rec">⭐ Más Popular</span>
                <h3>Plan Lifetime</h3>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="color:var(--apple-muted)">Un solo pago para siempre.</p>
                <ul class="p-features">
                    <li>3 Puntos de Venta</li>
                    <li>Boletas y Facturas SII</li>
                    <li>Actualizaciones de por vida</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-apple" style="width:100%">Comprar Ahora</a>
            </div>

            <!-- PLAN EMPRESA -->
            <div class="p-card">
                <h3>Plan Empresa</h3>
                <div class="p-price">$<?php echo $pEmpresa; ?></div>
                <p style="color:var(--apple-muted)">Para grandes negocios.</p>
                <ul class="p-features">
                    <li>Cajas ilimitadas</li>
                    <li>Multi-sucursal</li>
                    <li>Soporte 24/7</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-apple" style="width:100%">Contratar</a>
            </div>

        </div>
    </section>

    <footer>
        <p>CajaYa &copy; 2026 — Ingeniería Chilena 🇨🇱</p>
    </footer>

</body>
</html>
