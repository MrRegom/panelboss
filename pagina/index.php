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
    <title>CajaYa - El Punto de Venta definitivo</title>
    <link rel="stylesheet" href="assets/css/modern.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #a855f7; /* Púrpura más vibrante */
            --primary-glow: rgba(168, 85, 247, 0.6);
            --bg: #020203;
        }
        body { background: var(--bg); font-family: 'Outfit', sans-serif; }
        
        .hero-split {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            padding: 10rem 0 6rem;
        }
        
        h1 { 
            font-size: 5.5rem; 
            line-height: 0.9; 
            font-weight: 900; 
            letter-spacing: -4px;
            background: linear-gradient(180deg, #fff 30%, #555);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-main {
            background: var(--primary);
            color: white;
            padding: 1.5rem 3rem;
            border-radius: 12px;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 0 40px var(--primary-glow);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-size: 1.1rem;
        }
        .btn-main:hover {
            transform: scale(1.05) translateY(-5px);
            box-shadow: 0 0 60px var(--primary-glow);
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            padding: 4rem 0;
        }
        .card-premium {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.05);
            padding: 2.5rem;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        .card-premium:hover {
            background: rgba(168, 85, 247, 0.05);
            border-color: var(--primary);
            transform: translateY(-10px);
        }
        .card-premium i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            display: block;
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>

    <header>
        <div class="container nav">
            <div class="logo">
                <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 50px; filter: drop-shadow(0 0 10px var(--primary-glow));">
            </div>
            <div>
                <a href="https://panel.cajaya.cl/auth/google" class="btn-main" style="padding: 0.7rem 1.5rem; font-size: 0.9rem;">ENTRAR AL PANEL</a>
            </div>
        </div>
    </header>

    <main>
        <section class="container hero-split">
            <div style="flex: 1.2;">
                <span class="badge" style="background: rgba(168,85,247,0.1); color: var(--primary); font-weight: 700; border: 1px solid var(--primary);">NUEVA GENERACIÓN POS</span>
                <h1 style="margin-top: 1rem;">EL POS QUE<br>LO CAMBIA<br><span style="color: var(--primary);">TODO.</span></h1>
                <p style="color: var(--text-muted); font-size: 1.3rem; margin: 2rem 0 3rem; max-width: 500px;">
                    Tecnología de élite para tu negocio. Vende, sincroniza y escala sin importar la conexión.
                </p>
                <!-- RUTA ABSOLUTA PARA EVITAR EL 404 -->
                <a href="https://panel.cajaya.cl/auth/google" class="btn-main">
                    <i class="fa-brands fa-google"></i> BAJAR DEMO CON GOOGLE
                </a>
            </div>
            <div style="flex: 1; text-align: right;">
                <img src="assets/cajaya_pos_mockup.png" alt="POS" style="width: 120%; margin-right: -20%; filter: drop-shadow(0 0 50px rgba(168,85,247,0.2));">
            </div>
        </section>

        <section class="container" style="padding: 100px 0;">
            <div style="text-align: left; margin-bottom: 4rem;">
                <h2 style="font-size: 3rem; font-weight: 900;">Beneficios de Élite</h2>
            </div>
            <div class="feature-grid">
                <div class="card-premium">
                    <i class="fa-solid fa-cloud-slash"></i>
                    <h3>OFFLINE REAL</h3>
                    <p>Sigue vendiendo incluso si el mundo se queda sin internet.</p>
                </div>
                <div class="card-premium">
                    <i class="fa-solid fa-sync"></i>
                    <h3>MULTI-SYNC</h3>
                    <p>Todas tus sucursales y cajas conectadas en un latido.</p>
                </div>
                <div class="card-premium">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <h3>BOLETA SII</h3>
                    <p>Integración automática. Sin formularios, sin estrés.</p>
                </div>
                <div class="card-premium">
                    <i class="fa-solid fa-chart-pie"></i>
                    <h3>ANALÍTICA AI</h3>
                    <p>Entiende tu negocio con reportes visuales avanzados.</p>
                </div>
                <div class="card-premium">
                    <i class="fa-solid fa-shield-halved"></i>
                    <h3>MÁXIMA SEGURIDAD</h3>
                    <p>Tus datos protegidos con los estándares más altos.</p>
                </div>
                <div class="card-premium">
                    <i class="fa-solid fa-layer-group"></i>
                    <h3>STOCK GLOBAL</h3>
                    <p>Control total de inventario en tiempo real.</p>
                </div>
                <div class="card-premium">
                    <i class="fa-solid fa-receipt"></i>
                    <h3>TICKET PERSONALIZADO</h3>
                    <p>Diseña tus boletas con el branding de tu marca.</p>
                </div>
                <div class="card-premium">
                    <i class="fa-solid fa-headset"></i>
                    <h3>SOPORTE 24/7</h3>
                    <p>Estamos contigo en cada paso del camino.</p>
                </div>
            </div>
        </section>
    </main>

    <footer style="padding: 8rem 0; border-top: 1px solid rgba(255,255,255,0.05);">
        <div class="container" style="text-align: center;">
            <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 60px; margin-bottom: 2rem;">
            <p style="color: var(--text-muted);">&copy; 2026 CAJAYA CL. LA EVOLUCIÓN DEL POS.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script>
        ScrollReveal().reveal('.hero-split > div', { interval: 200, origin: 'bottom', distance: '50px' });
        ScrollReveal().reveal('.card-premium', { interval: 100, scale: 0.9, duration: 800 });
    </script>
</body>
</html>
