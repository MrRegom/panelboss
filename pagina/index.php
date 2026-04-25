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
    <title>CajaYa - El Punto de Venta que nunca se detiene</title>
    <link rel="stylesheet" href="assets/css/modern.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8b5cf6; /* Púrpura Aeris */
            --primary-glow: rgba(139, 92, 246, 0.5);
        }
        h1 { font-family: 'Outfit', sans-serif; letter-spacing: -2px; }
        .hero-split {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 4rem;
            padding: 8rem 0;
            text-align: left;
        }
        .hero-content { flex: 1; }
        .hero-image { flex: 1; position: relative; }
        .hero-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 50px 100px rgba(0,0,0,0.5);
            transform: perspective(1000px) rotateY(-10deg);
            transition: transform 0.5s ease;
        }
        .hero-image img:hover { transform: perspective(1000px) rotateY(0deg); }
        
        .stats-bar {
            display: flex;
            justify-content: space-around;
            padding: 3rem;
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 24px;
            margin-top: -2rem;
            backdrop-filter: blur(20px);
        }
        .stat-item h2 { font-size: 2.5rem; color: var(--primary); margin-bottom: 0.5rem; }
        .stat-item p { font-size: 0.9rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }

        @media (max-width: 992px) {
            .hero-split { flex-direction: column; text-align: center; padding: 4rem 0; }
            .hero-image img { transform: none; }
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>

    <header>
        <div class="container nav">
            <div class="logo">
                <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 45px;">
            </div>
            <div class="nav-links">
                <a href="../admin/auth/google" class="btn-primary" style="background: var(--primary); box-shadow: 0 0 20px var(--primary-glow);">COTIZAR AHORA</a>
            </div>
        </div>
    </header>

    <main>
        <section class="container hero-split">
            <div class="hero-content">
                <span class="badge" style="color: var(--primary); border-color: var(--primary);">✨ SOFTWARE POS DE VANGUARDIA</span>
                <h1 style="font-size: 4.5rem; margin-bottom: 2rem;">Vende sin límites,<br><span style="color: var(--primary)">estés donde estés.</span></h1>
                <p style="font-size: 1.2rem; margin-bottom: 3rem; color: var(--text-muted);">
                    Diseñamos el punto de venta más resiliente del mercado. Modo offline real, sincronización multi-caja y boleta electrónica en un solo lugar.
                </p>
                <div class="hero-actions">
                    <!-- ESTRATEGIA: TODO LLEVA A GOOGLE PARA CAPTURAR CORREO -->
                    <a href="../admin/auth/google" class="btn-primary" style="background: var(--primary); font-size: 1.1rem; padding: 1.2rem 2.5rem;">
                        <i class="fa-brands fa-google me-2"></i> DESCARGAR DEMO GRATIS
                    </a>
                    <p style="margin-top: 1rem; font-size: 0.8rem; color: var(--text-muted);">* Requiere registro rápido para activar tu licencia demo.</p>
                </div>
            </div>
            <div class="hero-image">
                <img src="assets/cajaya_pos_mockup.png" alt="CajaYa App" class="reveal-app">
            </div>
        </section>

        <section class="container">
            <div class="stats-bar">
                <div class="stat-item">
                    <h2>+500</h2>
                    <p>Empresas Activas</p>
                </div>
                <div class="stat-item">
                    <h2>8+</h2>
                    <p>Años de Experiencia</p>
                </div>
                <div class="stat-item">
                    <h2>98%</h2>
                    <p>Clientes Satisfechos</p>
                </div>
            </div>
        </section>

        <section class="container" id="beneficios" style="padding: 120px 0;">
            <div style="text-align: center; margin-bottom: 5rem;">
                <h2 style="font-size: 3rem; font-weight: 800;">Potencia tu negocio con tecnología AI</h2>
            </div>
            <div class="features">
                <div class="feature-card">
                    <i class="fa-solid fa-bolt" style="color: var(--primary);"></i>
                    <h3>Rapidez Extrema</h3>
                    <p>Atiende a tus clientes en segundos con nuestra interfaz optimizada.</p>
                </div>
                <div class="feature-card">
                    <i class="fa-solid fa-cloud-slash" style="color: var(--primary);"></i>
                    <h3>Independencia Total</h3>
                    <p>Sigue vendiendo aunque se corte el internet o la luz.</p>
                </div>
                <div class="feature-card">
                    <i class="fa-solid fa-mobile-screen-button" style="color: var(--primary);"></i>
                    <h3>Control Móvil</h3>
                    <p>Revisa tus ventas desde cualquier parte del mundo.</p>
                </div>
            </div>
        </section>
    </main>

    <footer style="background: #050505; padding: 6rem 0;">
        <div class="container" style="text-align: center;">
            <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 50px; margin-bottom: 2rem;">
            <p style="color: var(--text-muted);">&copy; 2026 CajaYa. La nueva era de los puntos de venta en Chile.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script>
        ScrollReveal().reveal('.hero-content', { origin: 'left', distance: '100px', duration: 1000 });
        ScrollReveal().reveal('.hero-image', { origin: 'right', distance: '100px', duration: 1200, delay: 200 });
        ScrollReveal().reveal('.stat-item', { interval: 200, scale: 0.85, duration: 800 });
        ScrollReveal().reveal('.feature-card', { interval: 100, origin: 'bottom', distance: '50px' });
    </script>
</body>
</html>
