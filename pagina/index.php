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
    <title>CajaYa - Tu Negocio, Sin Límites</title>
    <link rel="stylesheet" href="assets/css/modern.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8b5cf6;
            --primary-dark: #7c3aed;
            --accent: #00f2ff;
            --bg: #030303;
        }
        body { background: var(--bg); color: #fff; font-family: 'Outfit', sans-serif; }
        
        .hero-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 4rem;
            padding: 10rem 0 6rem;
        }

        .cta-button {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 1.2rem 2.5rem;
            border-radius: 12px;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);
            transition: all 0.3s ease;
        }
        .cta-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 92, 246, 0.4);
        }

        /* Cómo funciona */
        .step-card {
            background: rgba(255,255,255,0.02);
            padding: 3rem;
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,0.05);
            text-align: center;
        }
        .step-number {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-weight: 900;
        }

        /* Precios */
        .price-card {
            background: rgba(255,255,255,0.02);
            padding: 3rem;
            border-radius: 30px;
            border: 1px solid rgba(255,255,255,0.05);
            position: relative;
            overflow: hidden;
        }
        .price-card.featured {
            border: 2px solid var(--primary);
            background: rgba(139, 92, 246, 0.05);
        }

        .floating-image {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 40px 80px rgba(0,0,0,0.8);
            transform: perspective(1000px) rotateY(-10deg) rotateX(5deg);
            transition: 0.5s;
        }
        .floating-image:hover { transform: scale(1.05); }

        @media (max-width: 992px) {
            .hero-section { grid-template-columns: 1fr; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>

    <header>
        <div class="container nav">
            <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 40px;">
            <a href="https://panel.cajaya.cl/login.php" class="cta-button" style="padding: 0.7rem 1.5rem; font-size: 0.8rem;">ACCESO CLIENTES</a>
        </div>
    </header>

    <main>
        <section class="container hero-section">
            <div>
                <h1 style="font-size: 5rem; line-height: 0.9; margin-bottom: 2rem;">Vende más rápido con <span style="color: var(--primary)">CajaYa.</span></h1>
                <p style="font-size: 1.3rem; color: rgba(255,255,255,0.6); margin-bottom: 3rem;">
                    El punto de venta que funciona incluso sin internet. Sincroniza, vende y escala tu negocio hoy mismo.
                </p>
                <!-- BOTÓN ESTRATÉGICO: CAPTURA DE GOOGLE -->
                <a href="https://api.cajaya.cl/auth.php?provider=google" class="cta-button">
                    <img src="https://www.gstatic.com/images/branding/product/2x/googleg_48dp.png" alt="G" style="width: 24px;">
                    CONECTAR GOOGLE Y BAJAR DEMO
                </a>
            </div>
            <div>
                <img src="assets/cajaya_dashboard_mockup.png" alt="Dashboard" class="floating-image">
            </div>
        </section>

        <!-- CÓMO FUNCIONA -->
        <section class="container" style="padding: 100px 0;">
            <h2 style="text-align: center; font-size: 3rem; margin-bottom: 5rem;">Empieza en 3 pasos</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3>Regístrate</h3>
                    <p>Conecta tu cuenta de Google en un clic. Sin formularios largos.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3>Descarga</h3>
                    <p>Obtén el instalador de CajaYa y configúralo en segundos.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3>Vende</h3>
                    <p>¡Listo! Empieza a emitir boletas y controlar tu stock.</p>
                </div>
            </div>
        </section>

        <!-- BENEFICIOS (CARDS) -->
        <section class="container" style="padding: 100px 0; border-top: 1px solid rgba(255,255,255,0.05);">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <div class="step-card" style="padding: 2rem;">
                    <i class="fa-solid fa-cloud-slash" style="color: var(--primary); font-size: 2rem; margin-bottom: 1rem;"></i>
                    <h4>Modo Offline</h4>
                    <p>Venta continua sin internet.</p>
                </div>
                <div class="step-card" style="padding: 2rem;">
                    <i class="fa-solid fa-sync" style="color: var(--primary); font-size: 2rem; margin-bottom: 1rem;"></i>
                    <h4>Multi-Caja</h4>
                    <p>Sincronización en tiempo real.</p>
                </div>
                <div class="step-card" style="padding: 2rem;">
                    <i class="fa-solid fa-receipt" style="color: var(--primary); font-size: 2rem; margin-bottom: 1rem;"></i>
                    <h4>Boleta SII</h4>
                    <p>Integración nativa rápida.</p>
                </div>
                <div class="step-card" style="padding: 2rem;">
                    <i class="fa-solid fa-shield-halved" style="color: var(--primary); font-size: 2rem; margin-bottom: 1rem;"></i>
                    <h4>Seguridad</h4>
                    <p>Datos encriptados siempre.</p>
                </div>
            </div>
        </section>

        <!-- PRECIOS -->
        <section class="container" style="padding: 120px 0;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                <div class="price-card">
                    <h3>Plan Demo</h3>
                    <p style="font-size: 3rem; font-weight: 900; margin: 1.5rem 0;">$0 <span style="font-size: 1rem; color: #666;">/ por siempre</span></p>
                    <ul style="list-style: none; color: rgba(255,255,255,0.6); margin-bottom: 2rem;">
                        <li>✓ 1 Caja</li>
                        <li>✓ Reportes básicos</li>
                        <li>✓ Soporte por email</li>
                    </ul>
                    <a href="https://api.cajaya.cl/auth.php?provider=google" class="cta-button" style="width: 100%; justify-content: center;">BAJAR AHORA</a>
                </div>
                <div class="price-card featured">
                    <span style="background: var(--primary); padding: 0.3rem 1rem; border-radius: 100px; font-size: 0.7rem; position: absolute; top: 2rem; right: 2rem;">RECOMENDADO</span>
                    <h3>Plan Profesional</h3>
                    <p style="font-size: 3rem; font-weight: 900; margin: 1.5rem 0;">Cotizar <span style="font-size: 1rem; color: #666;">/ personalizado</span></p>
                    <ul style="list-style: none; color: rgba(255,255,255,0.6); margin-bottom: 2rem;">
                        <li>✓ Cajas ilimitadas</li>
                        <li>✓ Sincronización multi-sucursal</li>
                        <li>✓ Boleta SII ilimitada</li>
                        <li>✓ Soporte prioritario 24/7</li>
                    </ul>
                    <a href="https://api.cajaya.cl/auth.php?provider=google" class="cta-button" style="width: 100%; justify-content: center;">SOLICITAR DEMO PRO</a>
                </div>
            </div>
        </section>
    </main>

    <footer style="padding: 6rem 0; background: #050505; text-align: center;">
        <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 50px; margin-bottom: 2rem;">
        <p style="color: rgba(255,255,255,0.3);">&copy; 2026 CajaYa CL. Tecnología para tu crecimiento.</p>
    </footer>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script>
        ScrollReveal().reveal('.step-card', { interval: 200, origin: 'bottom', distance: '50px' });
        ScrollReveal().reveal('.price-card', { interval: 200, scale: 0.9 });
    </script>
</body>
</html>
