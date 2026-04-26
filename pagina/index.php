<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Repositories\SettingRepository;

$settings = new SettingRepository();
$downloadUrl = $settings->get('download_url') ?? 'https://cajaya.cl/downloads/CajaYa-Setup-1.0.0.exe';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajaYa | El Sistema POS para Empresas Modernas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #09090b;
            --zinc-900: #18181b;
            --zinc-800: #27272a;
            --zinc-400: #a1a1aa;
            --primary: #a855f7;
            --primary-soft: rgba(168, 85, 247, 0.1);
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            background: var(--bg); 
            color: #fff; 
            font-family: 'Inter', sans-serif; 
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* FONDO SOFISTICADO */
        .glow-bg {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: 
                radial-gradient(circle at 50% -20%, #1e1b4b 0%, transparent 50%),
                radial-gradient(circle at 0% 100%, #0c0a09 0%, transparent 50%);
            z-index: -1;
        }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }

        /* HEADER CORPORATIVO */
        header {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            background: rgba(9, 9, 11, 0.8);
            backdrop-filter: blur(20px);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .logo { height: 40px; }
        .nav-link { color: var(--zinc-400); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: 0.2s; }
        .nav-link:hover { color: #fff; }

        /* HERO ELITE */
        .hero {
            padding: 100px 0;
            text-align: center;
            position: relative;
        }
        
        .badge-sii {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--zinc-900);
            border: 1px solid var(--zinc-800);
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 32px;
            letter-spacing: 0.5px;
        }

        h1 {
            font-size: 4.5rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1.1;
            margin-bottom: 24px;
            background: linear-gradient(180deg, #fff 0%, #a1a1aa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-desc {
            font-size: 1.25rem;
            color: var(--zinc-400);
            max-width: 700px;
            margin: 0 auto 48px;
        }

        .btn-primary {
            background: #fff;
            color: #000;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: 0.2s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(255,255,255,0.1); }

        /* MOCKUP ELEGANTE */
        .mockup-container {
            margin-top: 80px;
            padding: 20px;
            background: linear-gradient(145deg, rgba(255,255,255,0.05) 0%, transparent 100%);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px;
            box-shadow: 0 50px 100px rgba(0,0,0,0.5);
            position: relative;
        }
        .mockup-container img { width: 100%; border-radius: 12px; display: block; }

        /* FEATURES SECTION */
        .features { padding: 100px 0; border-top: 1px solid rgba(255,255,255,0.05); }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
        
        .feature-card {
            padding: 40px;
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 24px;
            transition: 0.3s;
        }
        .feature-card:hover { border-color: rgba(255,255,255,0.1); background: rgba(255,255,255,0.04); }
        
        .icon-box {
            width: 48px; height: 48px;
            background: var(--primary-soft);
            color: var(--primary);
            display: flex; align-items: center; justify-content: center;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 1.2rem;
        }
        
        .feature-card h3 { font-size: 1.25rem; margin-bottom: 12px; font-weight: 700; }
        .feature-card p { color: var(--zinc-400); font-size: 0.95rem; }

        /* PRICING */
        .pricing { padding: 100px 0; background: radial-gradient(circle at center, #111 0%, transparent 100%); }
        .price-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; max-width: 900px; margin: 0 auto; }
        
        .price-card {
            padding: 48px;
            border-radius: 32px;
            background: var(--zinc-900);
            border: 1px solid var(--zinc-800);
            text-align: center;
        }
        .price-card.featured { border-color: var(--primary); background: linear-gradient(180deg, #18181b 0%, #09090b 100%); }

        @media (max-width: 768px) {
            h1 { font-size: 2.5rem; }
            .grid-3, .price-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="glow-bg"></div>

    <header>
        <div class="container" style="display: flex; width: 100%; justify-content: space-between; align-items: center;">
            <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" class="logo">
            <nav>
                <a href="#features" class="nav-link">NOSOTROS</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero container">
            <div class="badge-sii">
                <i class="fa-solid fa-certificate"></i> CERTIFICACIÓN SII INTEGRADA
            </div>
            <h1>Gestión inteligente para<br>negocios de alto rendimiento.</h1>
            <p class="hero-desc">
                Potencia tu operación con el sistema POS más robusto de Chile. Boleta electrónica, control de inventario y analítica avanzada en un solo lugar.
            </p>
            <div style="display: flex; gap: 16px; justify-content: center;">
                <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-primary">
                    <img src="https://www.gstatic.com/images/branding/product/2x/googleg_48dp.png" alt="G" style="width: 20px;">
                    ACCESO A DEMO
                </a>
                <a href="https://wa.me/56936316154" class="btn-primary" style="background: transparent; color: #fff; border: 1px solid var(--zinc-800);">
                    HABLAR CON SOPORTE
                </a>
            </div>

            <div class="mockup-container">
                <img src="assets/cajaya_pos_mockup.png" alt="CajaYa POS Interface">
            </div>
        </section>

        <section class="features container" id="features">
            <div class="grid-3">
                <div class="feature-card">
                    <div class="icon-box"><i class="fa-solid fa-chart-line"></i></div>
                    <h3>Análisis de Datos</h3>
                    <p>Visualiza el rendimiento de tus ventas y márgenes en tiempo real con reportes automatizados.</p>
                </div>
                <div class="feature-card">
                    <div class="icon-box"><i class="fa-solid fa-bolt"></i></div>
                    <h3>Venta Ágil</h3>
                    <p>Interfaz optimizada para la velocidad. Procesa transacciones y emite boletas en segundos.</p>
                </div>
                <div class="feature-card">
                    <div class="icon-box"><i class="fa-solid fa-warehouse"></i></div>
                    <h3>Inventario Crítico</h3>
                    <p>Alertas de stock bajo y sincronización multi-tienda para que nunca pierdas una venta.</p>
                </div>
            </div>
        </section>

        <section class="pricing container">
            <div class="price-grid">
                <div class="price-card">
                    <span style="color: var(--zinc-400); font-weight: 600; font-size: 0.8rem; text-transform: uppercase;">Prueba Gratuita</span>
                    <h3 style="font-size: 2rem; margin: 16px 0;">Versión Demo</h3>
                    <div style="font-size: 3rem; font-weight: 800; margin-bottom: 24px;">$0</div>
                    <p style="color: var(--zinc-400); margin-bottom: 32px;">Explora todas las capacidades del sistema sin costo inicial.</p>
                    <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-primary" style="width: 100%; justify-content: center;">EMPEZAR AHORA</a>
                </div>
                <div class="price-card featured">
                    <span style="color: var(--primary); font-weight: 600; font-size: 0.8rem; text-transform: uppercase;">Plan Corporativo</span>
                    <h3 style="font-size: 2rem; margin: 16px 0;">Licencia Full</h3>
                    <div style="font-size: 2rem; font-weight: 800; margin-bottom: 35px;">CONSULTAR</div>
                    <p style="color: var(--zinc-400); margin-bottom: 32px;">Sincronización ilimitada, boleta SII y soporte prioritario.</p>
                    <a href="https://wa.me/56936316154" class="btn-primary" style="width: 100%; justify-content: center; background: var(--primary); color: #fff;">PEDIR LICENCIA</a>
                </div>
            </div>
        </section>
    </main>

    <footer style="padding: 100px 0; border-top: 1px solid rgba(255,255,255,0.05); text-align: center; color: var(--zinc-400); font-size: 0.9rem;">
        <div class="container">
            <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 30px; opacity: 0.5; margin-bottom: 24px;">
            <p>&copy; 2026 CajaYa.cl - Tecnología POS de alto rendimiento para Chile.</p>
        </div>
    </footer>
</body>
</html>
