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
    <title>CajaYa | Tecnología POS de Alto Rendimiento</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #09090b;
            --zinc-900: #18181b;
            --zinc-800: #27272a;
            --zinc-400: #a1a1aa;
            --primary: #a855f7;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            background: var(--bg); 
            color: #fff; 
            font-family: 'Inter', sans-serif; 
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        .container { max-width: 1400px; margin: 0 auto; padding: 0 4rem; }

        /* HEADER */
        header {
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255,255,255,0.03);
            background: rgba(9, 9, 11, 0.7);
            backdrop-filter: blur(20px);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .logo { height: 45px; }
        .nav-link { color: var(--zinc-400); text-decoration: none; font-size: 0.85rem; font-weight: 600; letter-spacing: 1px; transition: 0.2s; }
        .nav-link:hover { color: #fff; }

        /* HERO SPLIT */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 90px;
        }
        
        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6rem;
            align-items: center;
            width: 100%;
        }

        .badge-sii {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(168, 85, 247, 0.1);
            border: 1px solid rgba(168, 85, 247, 0.2);
            padding: 8px 16px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        h1 {
            font-size: 5rem;
            font-weight: 800;
            letter-spacing: -0.05em;
            line-height: 1;
            margin-bottom: 2rem;
            background: linear-gradient(to bottom, #fff 40%, #555 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-desc {
            font-size: 1.2rem;
            color: var(--zinc-400);
            margin-bottom: 3rem;
            max-width: 550px;
        }

        .btn-group { display: flex; gap: 20px; }
        .btn-main {
            background: #fff;
            color: #000;
            padding: 18px 36px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: 0.3s cubic-bezier(0.19, 1, 0.22, 1);
        }
        .btn-main:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(255,255,255,0.15); }

        /* CARRUSEL PRO */
        .carousel-wrapper {
            position: relative;
            width: 100%;
            aspect-ratio: 16/10;
            border-radius: 24px;
            overflow: hidden;
            background: #000;
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 40px 100px rgba(0,0,0,0.8);
        }
        
        .carousel-item {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
        }
        .carousel-item.active { opacity: 1; }

        .glow-effect {
            position: absolute;
            top: 50%; left: 50%;
            width: 140%; height: 140%;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.15) 0%, transparent 70%);
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: -1;
        }

        /* FEATURES SECTION (DARK CONTINUITY) */
        .features { padding: 120px 0; background: linear-gradient(to bottom, #09090b 0%, #000 100%); }
        .feature-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
        .f-card {
            padding: 50px;
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 30px;
            transition: 0.4s;
        }
        .f-card:hover { border-color: var(--primary); background: rgba(255,255,255,0.04); transform: translateY(-10px); }

        @media (max-width: 1100px) {
            .hero-grid { grid-template-columns: 1fr; text-align: center; }
            h1 { font-size: 3.5rem; }
            .hero-desc { margin: 0 auto 3rem; }
            .btn-group { justify-content: center; }
            .container { padding: 0 2rem; }
        }
    </style>
</head>
<body>
    <header>
        <div class="container" style="display: flex; width: 100%; justify-content: space-between; align-items: center;">
            <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" class="logo">
            <nav>
                <a href="#nosotros" class="nav-link">SABER MÁS</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="container hero">
            <div class="hero-grid">
                <div class="hero-text">
                    <div class="badge-sii">
                        <i class="fa-solid fa-check-circle"></i> SII Integrado 2026
                    </div>
                    <h1>Control Total.<br><span style="color: #fff">Sin Límites.</span></h1>
                    <p class="hero-desc">
                        Lidera tu negocio con el POS más avanzado. Gestión de inventario, boleta electrónica y reportes en tiempo real con una interfaz diseñada para la velocidad.
                    </p>
                    <div class="btn-group">
                        <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-main">
                            <img src="https://www.gstatic.com/images/branding/product/2x/googleg_48dp.png" alt="G" style="width: 20px;">
                            ACCESO A DEMO
                        </a>
                        <a href="https://wa.me/56936316154" class="btn-main" style="background: transparent; color: #fff; border: 1px solid var(--zinc-800);">
                            CONSULTAR LICENCIA
                        </a>
                    </div>
                </div>

                <div style="position: relative;">
                    <div class="glow-effect"></div>
                    <div class="carousel-wrapper">
                        <!-- Imagen Dashboard (Ocultando bordes blancos con background-size) -->
                        <div class="carousel-item active" style="background-image: url('assets/cajaya_dashboard_mockup.png'); background-size: 110%; background-position: center;"></div>
                        <!-- Imagen POS -->
                        <div class="carousel-item" style="background-image: url('assets/cajaya_pos_mockup.png'); background-size: 110%; background-position: center;"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="features" id="nosotros">
            <div class="container">
                <div class="feature-grid">
                    <div class="f-card">
                        <i class="fa-solid fa-shield-halved" style="font-size: 2rem; color: var(--primary); margin-bottom: 2rem;"></i>
                        <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">Máxima Seguridad</h3>
                        <p style="color: var(--zinc-400);">Tus datos están protegidos con encriptación de grado bancario y respaldos automáticos.</p>
                    </div>
                    <div class="f-card">
                        <i class="fa-solid fa-bolt-lightning" style="font-size: 2rem; color: var(--primary); margin-bottom: 2rem;"></i>
                        <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">Operación Offline</h3>
                        <p style="color: var(--zinc-400);">Sigue vendiendo incluso sin internet. El sistema se sincroniza automáticamente al reconectar.</p>
                    </div>
                    <div class="f-card">
                        <i class="fa-solid fa-layer-group" style="font-size: 2rem; color: var(--primary); margin-bottom: 2rem;"></i>
                        <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">Multi-Sucursal</h3>
                        <p style="color: var(--zinc-400);">Gestiona todos tus locales desde una sola cuenta. Control centralizado de stock y ventas.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="container" style="padding: 100px 0; text-align: center;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; max-width: 1000px; margin: 0 auto;">
                <div style="background: var(--zinc-900); padding: 50px; border-radius: 40px; border: 1px solid var(--zinc-800);">
                    <h4 style="color: var(--zinc-400); margin-bottom: 20px;">PRUEBA GRATIS</h4>
                    <div style="font-size: 4rem; font-weight: 800; margin-bottom: 20px;">$0</div>
                    <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-main" style="width: 100%; justify-content: center;">LOGUÉATE PARA DEMO</a>
                </div>
                <div style="background: linear-gradient(145deg, #1e1b4b 0%, #09090b 100%); padding: 50px; border-radius: 40px; border: 1px solid var(--primary);">
                    <h4 style="color: var(--primary); margin-bottom: 20px;">LICENCIA FULL</h4>
                    <div style="font-size: 3rem; font-weight: 800; margin-bottom: 20px;">CONSULTAR</div>
                    <a href="https://wa.me/56936316154" class="btn-main" style="width: 100%; justify-content: center; background: var(--primary); color: #fff;">PEDIR LICENCIA</a>
                </div>
            </div>
        </section>
    </main>

    <footer style="padding: 100px 0; text-align: center; color: var(--zinc-400); font-size: 0.9rem; border-top: 1px solid rgba(255,255,255,0.03);">
        <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 35px; opacity: 0.5; margin-bottom: 30px;">
        <p>&copy; 2026 CajaYa.cl - Líderes en Tecnología para el Comercio.</p>
    </footer>

    <script>
        // LÓGICA DE CARRUSEL FADE-IN
        const items = document.querySelectorAll('.carousel-item');
        let current = 0;

        function nextSlide() {
            items[current].classList.remove('active');
            current = (current + 1) % items.length;
            items[current].classList.add('active');
        }

        setInterval(nextSlide, 4000);
    </script>
</body>
</html>
