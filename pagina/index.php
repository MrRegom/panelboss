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
    <title>CajaYa - La nueva era del POS</title>
    <link rel="stylesheet" href="assets/css/modern.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #c084fc;
            --primary-glow: rgba(192, 132, 252, 0.4);
            --bg: #050505;
        }
        body { background: var(--bg); color: #fff; font-family: 'Outfit', sans-serif; overflow-x: hidden; }
        
        .hero-split {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            align-items: center;
            gap: 4rem;
            padding: 12rem 0 8rem;
        }
        
        h1 { 
            font-size: 5rem; 
            line-height: 0.85; 
            font-weight: 900; 
            letter-spacing: -4px;
            margin-bottom: 2rem;
        }

        .btn-modern {
            background: #fff;
            color: #000;
            padding: 1.2rem 2.5rem;
            border-radius: 100px;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            border: 2px solid #fff;
        }
        .btn-modern:hover {
            background: transparent;
            color: #fff;
            transform: translateY(-3px);
        }

        .btn-google-modern {
            background: rgba(255,255,255,0.05);
            color: #fff;
            padding: 1.2rem 2.5rem;
            border-radius: 100px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            border: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }
        .btn-google-modern:hover {
            background: rgba(255,255,255,0.1);
            border-color: var(--primary);
        }

        /* Contenedor de Imagen "Pantalla Flotante" */
        .screen-container {
            position: relative;
            border-radius: 20px;
            background: #111;
            padding: 10px;
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 50px 100px rgba(0,0,0,0.8), 0 0 40px var(--primary-glow);
            transform: perspective(1000px) rotateY(-15deg) rotateX(5deg);
            transition: all 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .screen-container:hover {
            transform: perspective(1000px) rotateY(0deg) rotateX(0deg) scale(1.05);
        }
        .screen-container img {
            width: 100%;
            border-radius: 12px;
            display: block;
        }

        .feature-box {
            background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0) 100%);
            border: 1px solid rgba(255,255,255,0.05);
            padding: 2.5rem;
            border-radius: 24px;
            text-align: center;
        }

        @media (max-width: 992px) {
            .hero-split { grid-template-columns: 1fr; text-align: center; padding-top: 8rem; }
            .screen-container { transform: none; margin-top: 3rem; }
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>

    <header style="padding: 2rem 0; position: absolute; width: 100%; z-index: 10;">
        <div class="container nav">
            <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 45px;">
            <a href="https://panel.cajaya.cl/login.php" style="color: #fff; text-decoration: none; font-weight: 700; font-size: 0.9rem; letter-spacing: 1px;">ACCESO CLIENTES →</a>
        </div>
    </header>

    <main>
        <section class="container hero-split">
            <div>
                <span style="color: var(--primary); font-weight: 800; letter-spacing: 2px; font-size: 0.8rem;">[ SOFTWARE POS EMPRESARIAL ]</span>
                <h1 style="margin-top: 1.5rem;">Vende más.<br>Sin pausas.<br><span style="color: var(--primary)">Sin límites.</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 1.2rem; margin-bottom: 3rem; line-height: 1.5;">
                    El único punto de venta diseñado para resistir. Sincronización inteligente y boleta SII en una interfaz que te encantará usar.
                </p>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="https://panel.cajaya.cl/login.php" class="btn-modern">PROBAR DEMO GRATIS</a>
                    <a href="https://panel.cajaya.cl/login.php" class="btn-google-modern">
                        <img src="https://www.gstatic.com/images/branding/product/2x/googleg_48dp.png" alt="G" style="width: 20px;">
                        Registro con Google
                    </a>
                </div>
            </div>
            <div>
                <div class="screen-container">
                    <img src="assets/cajaya_dashboard_mockup.png" alt="CajaYa Dashboard">
                </div>
            </div>
        </section>

        <section class="container" style="padding-bottom: 120px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <div class="feature-box">
                    <i class="fa-solid fa-cloud-slash" style="font-size: 2rem; color: var(--primary); margin-bottom: 1.5rem;"></i>
                    <h3 style="margin-bottom: 1rem;">Modo Offline</h3>
                    <p style="color: rgba(255,255,255,0.5);">Tu negocio nunca se detiene, incluso sin conexión.</p>
                </div>
                <div class="feature-box">
                    <i class="fa-solid fa-sync" style="font-size: 2rem; color: var(--primary); margin-bottom: 1.5rem;"></i>
                    <h3 style="margin-bottom: 1rem;">Sincronización</h3>
                    <p style="color: rgba(255,255,255,0.5);">Inventario y ventas al día en todas tus cajas.</p>
                </div>
                <div class="feature-box">
                    <i class="fa-solid fa-bolt" style="font-size: 2rem; color: var(--primary); margin-bottom: 1.5rem;"></i>
                    <h3 style="margin-bottom: 1rem;">Boleta SII</h3>
                    <p style="color: rgba(255,255,255,0.5);">Facturación electrónica rápida y certificada.</p>
                </div>
            </div>
        </section>
    </main>

    <footer style="padding: 4rem 0; text-align: center; border-top: 1px solid rgba(255,255,255,0.05);">
        <p style="color: rgba(255,255,255,0.3); font-size: 0.9rem;">&copy; 2026 CAJAYA CL. TODOS LOS DERECHOS RESERVADOS.</p>
    </footer>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script>
        ScrollReveal().reveal('.hero-split > div', { interval: 200, origin: 'bottom', distance: '60px', duration: 1000 });
        ScrollReveal().reveal('.feature-box', { interval: 150, origin: 'bottom', distance: '30px' });
    </script>
</body>
</html>
