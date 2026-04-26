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
    <title>CajaYa POS | Sistema de Ventas e Inventario para Pymes en Chile</title>
    <meta name="description" content="El punto de venta más rápido y seguro para tu negocio. Boleta electrónica, control de inventario y gestión multi-sucursal.">
    
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #7c3aed; /* Violet 600 */
            --primary-light: #a78bfa;
            --accent: #a855f7; /* Morado claro (CajaYa Logo Style) */
            --bg-deep: #050506;
            --bg-card: #0f0f12;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --glass: rgba(15, 15, 18, 0.7);
            --border: rgba(255, 255, 255, 0.08);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            background-color: var(--bg-deep);
            color: var(--text-main);
            font-family: 'Plus Jakarta Sans', sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, .nav-link { font-family: 'Outfit', sans-serif; }

        .container { max-width: 1300px; margin: 0 auto; padding: 0 2rem; }

        /* TOP UTILITY BAR */
        .top-bar {
            background: #000;
            padding: 8px 0;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }
        .top-bar-content { display: flex; justify-content: flex-end; gap: 25px; }
        .top-bar a { color: inherit; text-decoration: none; transition: 0.2s; }
        .top-bar a:hover { color: #fff; }
        .top-bar i { color: var(--primary-light); margin-right: 5px; }

        /* NAVBAR */
        header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: var(--glass);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border);
            padding: 15px 0;
        }
        .nav-content { display: flex; align-items: center; justify-content: space-between; }
        .logo { height: 42px; filter: brightness(1.1); }
        
        .nav-menu { display: flex; gap: 30px; align-items: center; }
        .nav-link { 
            color: var(--text-muted); 
            text-decoration: none; 
            font-size: 0.9rem; 
            font-weight: 600; 
            transition: 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .nav-link:hover { color: var(--primary-light); }

        .nav-actions { display: flex; align-items: center; gap: 20px; }
        
        /* BUTTONS */
        .btn {
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        .btn-primary { background: var(--accent); color: #fff; box-shadow: 0 4px 15px rgba(168, 85, 247, 0.3); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(168, 85, 247, 0.4); background: var(--primary-light); }
        
        .btn-outline { border: 1.5px solid var(--border); color: #fff; }
        .btn-outline:hover { background: rgba(255,255,255,0.05); border-color: #fff; }

        .btn-ghost { color: var(--text-main); font-weight: 600; font-size: 0.9rem; }
        .btn-ghost:hover { color: var(--primary-light); }

        /* HERO SECTION */
        .hero {
            padding: 100px 0 140px;
            position: relative;
            overflow: hidden;
        }
        
        /* Background Glows */
        .hero::before {
            content: '';
            position: absolute;
            top: -20%; left: -10%;
            width: 50%; height: 80%;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.1) 0%, transparent 70%);
            z-index: -1;
            filter: blur(80px);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 80px;
            align-items: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(124, 58, 237, 0.1);
            border: 1px solid rgba(124, 58, 237, 0.2);
            padding: 8px 16px;
            border-radius: 100px;
            color: var(--primary-light);
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 25px;
            animation: pulse-violet 3s infinite;
        }
        
        @keyframes pulse-violet {
            0% { box-shadow: 0 0 0 0 rgba(124, 58, 237, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(124, 58, 237, 0); }
            100% { box-shadow: 0 0 0 0 rgba(124, 58, 237, 0); }
        }

        .hero h1 {
            font-size: 3.8rem;
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: -2px;
            margin-bottom: 25px;
            color: #fff;
        }
        .hero h1 span {
            background: linear-gradient(135deg, #fff 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.15rem;
            color: var(--text-muted);
            margin-bottom: 40px;
            max-width: 580px;
        }

        .hero-btns { display: flex; gap: 15px; }

        /* MOCKUP IMAGE (ORGANIC BUBBLE) */
        .hero-visual { position: relative; }
        .organic-shape {
            width: 100%;
            aspect-ratio: 1;
            background: var(--bg-card);
            border-radius: 42% 58% 70% 30% / 45% 45% 55% 55%;
            overflow: hidden;
            border: 1px solid var(--border);
            position: relative;
            box-shadow: 0 50px 100px -20px rgba(0,0,0,0.5);
            animation: morph 12s ease-in-out infinite alternate;
        }
        
        @keyframes morph {
            0% { border-radius: 42% 58% 70% 30% / 45% 45% 55% 55%; }
            100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
        }

        .mockup-img {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 115%;
            height: 115%;
            object-fit: cover;
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.4));
        }

        /* FLOATING BADGES IN HERO */
        .floating-badge {
            position: absolute;
            background: var(--glass);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            padding: 15px 20px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            z-index: 10;
        }
        .badge-1 { top: 15%; left: -10%; animation: float 6s ease-in-out infinite; }
        .badge-2 { bottom: 15%; right: -5%; animation: float 8s ease-in-out infinite reverse; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        /* STATS BAR */
        .stats-bar {
            background: var(--bg-card);
            padding: 50px 0;
            border-y: 1px solid var(--border);
        }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); text-align: center; gap: 40px; }
        .stat-item h4 { font-size: 2.5rem; font-weight: 800; color: #fff; margin-bottom: 5px; }
        .stat-item p { font-size: 0.85rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }

        /* FEATURES GRID */
        .features { padding: 140px 0; }
        .section-header { text-align: center; margin-bottom: 80px; }
        .section-header h2 { font-size: 2.8rem; font-weight: 800; margin-bottom: 15px; }
        .section-header p { color: var(--text-muted); font-size: 1.1rem; }

        .feature-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
        .f-card {
            background: var(--bg-card);
            padding: 50px 40px;
            border-radius: 32px;
            border: 1px solid var(--border);
            transition: 0.4s;
            position: relative;
            overflow: hidden;
        }
        .f-card:hover { transform: translateY(-10px); border-color: var(--primary); }
        .f-card i { font-size: 2.5rem; color: var(--primary-light); margin-bottom: 25px; display: block; }
        .f-card h3 { font-size: 1.5rem; font-weight: 700; margin-bottom: 15px; }
        .f-card p { color: var(--text-muted); font-size: 0.95rem; }

        /* PRICING / CTA */
        .cta-box {
            background: linear-gradient(135deg, #1e1b4b 0%, #0c0a1a 100%);
            border: 1px solid rgba(124, 58, 237, 0.3);
            border-radius: 40px;
            padding: 80px;
            text-align: center;
            margin: 100px 0;
            position: relative;
            overflow: hidden;
        }
        .cta-box::after {
            content: '';
            position: absolute;
            bottom: -50px; right: -50px;
            width: 200px; height: 200px;
            background: var(--primary);
            filter: blur(100px);
            opacity: 0.3;
        }

        .cta-box h2 { font-size: 3rem; font-weight: 800; margin-bottom: 20px; }
        .cta-box p { font-size: 1.2rem; color: var(--primary-light); margin-bottom: 40px; font-weight: 600; }

        /* FOOTER */
        footer { padding: 80px 0 40px; border-top: 1px solid var(--border); background: #000; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 60px; margin-bottom: 60px; }
        .footer-info p { color: var(--text-muted); margin-top: 20px; font-size: 0.9rem; }
        .footer-col h5 { font-size: 1rem; margin-bottom: 25px; color: #fff; }
        .footer-col ul { list-style: none; }
        .footer-col li { margin-bottom: 12px; }
        .footer-col a { color: var(--text-muted); text-decoration: none; font-size: 0.85rem; transition: 0.2s; }
        .footer-col a:hover { color: #fff; }

        .footer-bottom { border-top: 1px solid var(--border); padding-top: 30px; text-align: center; font-size: 0.75rem; color: var(--text-muted); }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .hero-grid { grid-template-columns: 1fr; text-align: center; gap: 60px; }
            .hero h1 { font-size: 3rem; }
            .hero p { margin: 0 auto 40px; }
            .hero-btns { justify-content: center; }
            .organic-shape { max-width: 500px; margin: 0 auto; }
            .feature-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

    <div class="top-bar">
        <div class="container top-bar-content">
            <a href="tel:+56959764771"><i class="fa-solid fa-phone"></i> +56 9 5976 4771</a>
            <a href="#"><i class="fa-solid fa-circle-question"></i> Centro de ayuda</a>
            <a href="#"><i class="fa-solid fa-bullhorn"></i> ¡Recomiéndanos!</a>
        </div>
    </div>

    <header>
        <div class="container nav-content">
            <a href="/"><img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" class="logo"></a>
            
            <nav class="nav-menu">
                <a href="#precios" class="nav-link">Precios</a>
                <a href="#recursos" class="nav-link">¿Qué ofrecemos?</a>
                <div class="dropdown">
                    <a href="#" class="nav-link">Recursos <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                </div>
            </nav>

            <div class="nav-actions">
                <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn btn-primary">Prueba Gratis</a>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container hero-grid">
                <div class="hero-text">
                    <div class="hero-badge">
                        <i class="fa-solid fa-shield-check"></i> SII Certificado 2026
                    </div>
                    <h1>Controla tu inventario con el <span>Sistema Líder</span> para Pymes.</h1>
                    <p>
                        Emite boleta, factura electrónica y gestiona tu stock en tiempo real. La solución POS robusta, rápida y 100% offline-ready diseñada para Chile.
                    </p>
                    <div class="hero-btns">
                        <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn btn-primary">Contrata aquí <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="https://wa.me/56959764771" class="btn btn-outline"><i class="fa-solid fa-play"></i> Ver video</a>
                    </div>
                    <div style="margin-top: 30px; display: flex; gap: 20px; font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">
                        <span><i class="fa-solid fa-check text-success"></i> Demo 30 días gratis</span>
                        <span><i class="fa-solid fa-check text-success"></i> Sin tarjetas asociadas</span>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="floating-badge badge-1">
                        <div class="bg-success rounded-circle" style="width: 10px; height: 10px;"></div>
                        <div style="line-height: 1.2;">
                            <span style="font-size: 0.7rem; color: var(--text-muted); font-weight: 700; display: block;">VENTAS HOY</span>
                            <span style="font-size: 1.1rem; font-weight: 800;">$ 234.670</span>
                        </div>
                    </div>
                    
                    <div class="floating-badge badge-2">
                        <i class="fa-solid fa-users text-primary"></i>
                        <div style="line-height: 1.2;">
                            <span style="font-size: 0.7rem; color: var(--text-muted); font-weight: 700; display: block;">CLIENTES</span>
                            <span style="font-size: 1.1rem; font-weight: 800;">+ 12.000</span>
                        </div>
                    </div>

                    <div class="organic-shape">
                        <img src="assets/cajaya_pos_mockup.png" alt="POS CajaYa" class="mockup-img">
                    </div>
                </div>
            </div>
        </section>

        <section class="stats-bar">
            <div class="container stats-grid">
                <div class="stat-item">
                    <h4 id="count1">12.132</h4>
                    <p>Clientes activos</p>
                </div>
                <div class="stat-item">
                    <h4 id="count2">113.398</h4>
                    <p>Usuarios felices</p>
                </div>
                <div class="stat-item">
                    <h4 id="count3">52.204</h4>
                    <p>Puntos de venta</p>
                </div>
                <div class="stat-item">
                    <h4 id="count4">2.370</h4>
                    <p>Soporte 24/7</p>
                </div>
            </div>
        </section>

        <section class="features" id="recursos">
            <div class="container">
                <div class="section-header">
                    <div class="hero-badge" style="animation: none;">Nuestras Ventajas</div>
                    <h2>¿Por qué elegir CajaYa?</h2>
                    <p>Diseñamos herramientas potentes que simplifican la vida del comerciante.</p>
                </div>

                <div class="feature-grid">
                    <div class="f-card">
                        <i class="fa-solid fa-bolt"></i>
                        <h3>Rapidez Absoluta</h3>
                        <p>Carga de productos y cierre de caja en segundos. No pierdas ventas por esperas innecesarias.</p>
                    </div>
                    <div class="f-card">
                        <i class="fa-solid fa-cloud-slash"></i>
                        <h3>Modo Offline</h3>
                        <p>¿Se cayó el internet? No importa. Sigue vendiendo y el sistema sincronizará todo cuando vuelva la red.</p>
                    </div>
                    <div class="f-card">
                        <i class="fa-solid fa-chart-line"></i>
                        <h3>Reportes Pro</h3>
                        <p>Visualiza tus márgenes, stock crítico y productos más vendidos desde cualquier lugar del mundo.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="container" id="precios">
            <div class="cta-box">
                <div class="hero-badge" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #fff;">Impulsa tu negocio hoy</div>
                <h2>¿Listo para el siguiente nivel?</h2>
                <p>Únete a las miles de pymes que ya transformaron su gestión con CajaYa.</p>
                <div style="display: flex; gap: 20px; justify-content: center; margin-top: 40px;">
                    <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn btn-primary" style="padding: 18px 40px; font-size: 1.1rem;">Comenzar Demo Gratis</a>
                    <a href="https://wa.me/56959764771" class="btn btn-outline" style="padding: 18px 40px; font-size: 1.1rem;">Hablar con un Experto</a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container footer-grid">
            <div class="footer-info">
                <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 40px;">
                <p>CajaYa es la solución definitiva para la administración de locales comerciales en Chile. Tecnología de punta al alcance de todos.</p>
                <div style="margin-top: 25px; display: flex; gap: 15px;">
                    <a href="#" style="font-size: 1.2rem;"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" style="font-size: 1.2rem;"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" style="font-size: 1.2rem;"><i class="fa-brands fa-linkedin"></i></a>
                </div>
            </div>
            
            <div class="footer-col">
                <h5>Producto</h5>
                <ul>
                    <li><a href="#">Funcionalidades</a></li>
                    <li><a href="#">Boleta Electrónica</a></li>
                    <li><a href="#">Inventario</a></li>
                    <li><a href="#">Reportes</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h5>Empresa</h5>
                <ul>
                    <li><a href="#">Sobre nosotros</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h5>Contacto</h5>
                <ul>
                    <li><a href="tel:+56959764771"><i class="fa-solid fa-phone me-2"></i> +56 9 5976 4771</a></li>
                    <li><a href="mailto:soporte@cajaya.cl"><i class="fa-solid fa-envelope me-2"></i> soporte@cajaya.cl</a></li>
                    <li><a href="#"><i class="fa-solid fa-location-dot me-2"></i> Viña del Mar, Chile</a></li>
                </ul>
            </div>
        </div>
        
        <div class="container footer-bottom">
            <p>&copy; 2026 CajaYa POS - Una marca de PanelBoss PRO. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        // Animación simple de contadores
        function animateCount(id, target) {
            let current = 0;
            const step = Math.ceil(target / 100);
            const element = document.getElementById(id);
            const interval = setInterval(() => {
                current += step;
                if (current >= target) {
                    element.innerText = target.toLocaleString();
                    clearInterval(interval);
                } else {
                    element.innerText = current.toLocaleString();
                }
            }, 30);
        }

        // Ejecutar al entrar en scroll (opcionalmente) o al cargar
        window.addEventListener('DOMContentLoaded', () => {
            animateCount('count1', 12132);
            animateCount('count2', 113398);
            animateCount('count3', 52204);
            animateCount('count4', 2370);
        });
    </script>
</body>
</html>
