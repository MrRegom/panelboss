<?php
/**
 * index.php — Landing Page CAJAYA ELITE FINAL V24 (THE SOLID CLEAN)
 */
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/Database.php';
require_once __DIR__ . '/../src/Repositories/PlanRepository.php';

use App\Repositories\PlanRepository;

$plans = [];
try {
    $planRepo = new PlanRepository();
    $plansRaw = $planRepo->getAll();
    foreach ($plansRaw as $p) { $plans[trim(strtolower($p['slug']))] = $p; }
} catch (\Exception $e) {
    error_log("CAJAYA: DB Fail, using static defaults. " . $e->getMessage());
}

$pMensual  = number_format($plans['mensual']['price']  ?? 20000, 0, ',', '.');
$pLifetime = number_format($plans['lifetime']['price'] ?? 180000, 0, ',', '.');
$pEmpresa  = number_format($plans['empresa']['price']  ?? 35000, 0, ',', '.');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>CajaYa Elite — El Futuro de tu Negocio</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;700;900&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6A37B7;
            --primary-dark: #4A268A;
            --primary-glow: #9D6CFF;
            --primary-soft: #F4F0FF;
            --text-dark: #1D1D1F;
            --text-light: #6E6E73;
            --bg-white: #FFFFFF;
            --bg-off: #FBFBFE;
            --transition-elite: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-font-smoothing: antialiased; scroll-behavior: smooth; }
        body { background: var(--bg-white); color: var(--text-dark); font-family: 'Inter', sans-serif; overflow-x: hidden; }

        /* PRELOADER */
        #preloader { position: fixed; inset: 0; background: #fff; display: flex; align-items: center; justify-content: center; z-index: 10000; transition: opacity 0.6s ease; }
        .pre-logo { width: 120px; animation: pulse 2s infinite ease-in-out; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.7; } 50% { transform: scale(1.1); opacity: 1; } }

        /* NAVBAR */
        nav { 
            position: fixed; top: 0; width: 100%; height: 80px; z-index: 1000;
            display: flex; justify-content: space-between; align-items: center; padding: 0 8%;
            transition: var(--transition-elite);
        }
        nav.scrolled { background: rgba(255,255,255,0.9); backdrop-filter: blur(20px); height: 70px; box-shadow: 0 4px 30px rgba(0,0,0,0.03); }
        .nav-logo img { height: 35px; }
        .nav-links a { color: var(--text-dark); text-decoration: none; font-weight: 700; font-size: 14px; margin-left: 20px; transition: 0.3s; }
        .btn-nav-purple { background: var(--primary); color: #fff !important; padding: 10px 22px; border-radius: 50px; font-weight: 800; box-shadow: 0 10px 20px rgba(106,55,183,0.15); }
        .btn-wa { background: #25D366; color: #fff !important; padding: 10px 22px; border-radius: 50px; font-weight: 800; box-shadow: 0 10px 20px rgba(37,211,102,0.15); }
        .btn-nav-purple:hover, .btn-wa:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }

        /* HERO CAROUSEL */
        .hero-carousel { position: relative; height: 100vh; overflow: hidden; background: #fff; }
        .carousel-track { display: flex; height: 100%; transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
        .slide { min-width: 100%; height: 100%; position: relative; display: flex; align-items: center; justify-content: flex-start; padding: 0 10%; }
        
        .slide-bg { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1; }
        .slide-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0.85) 45%, transparent 100%); z-index: 2; }

        .hero-content { position: relative; z-index: 10; max-width: 800px; text-align: left; }
        .hero-content h1 { font-family: 'Outfit', sans-serif; font-size: clamp(3rem, 7vw, 5.5rem); line-height: 0.9; font-weight: 900; margin-bottom: 30px; letter-spacing: -4px; color: var(--text-dark); }
        .hero-content h1 span { color: var(--primary); }
        .hero-content p { font-size: 1.5rem; color: var(--text-light); margin-bottom: 50px; border-left: 5px solid var(--primary); padding-left: 30px; max-width: 600px; }
        .btn-primary { background: var(--primary); color: #fff; padding: 22px 50px; border-radius: 18px; text-decoration: none; font-weight: 800; display: inline-block; transition: 0.3s; box-shadow: 0 15px 30px rgba(106,55,183,0.3); border: none; cursor: pointer; text-transform: uppercase; }
        .btn-primary:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(106,55,183,0.4); }
        
        /* CAROUSEL ARROWS (V29) */
        .c-arrow {
            position: absolute; top: 50%; transform: translateY(-50%);
            width: 60px; height: 60px; background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3);
            border-radius: 50%; color: var(--primary); display: flex;
            align-items: center; justify-content: center; font-size: 20px;
            cursor: pointer; z-index: 100; transition: 0.4s;
        }
        .c-arrow:hover { background: var(--primary); color: #fff; transform: translateY(-50%) scale(1.1); box-shadow: 0 10px 30px rgba(106,55,183,0.3); }
        .c-prev { left: 40px; }
        .c-next { right: 40px; }

        /* PEARL FORM (SOLID & VISIBLE) */
        .pearl-form { 
            background: rgba(255,255,255,0.98); backdrop-filter: blur(20px);
            padding: 50px; border-radius: 40px; border: 1px solid #eee;
            box-shadow: 0 40px 80px rgba(0,0,0,0.1);
            width: 100%; max-width: 500px; position: relative; z-index: 100;
        }
        .pearl-form h2 { font-family: 'Outfit', sans-serif; font-size: 2.8rem; margin-bottom: 10px; color: var(--primary); letter-spacing: -2px; }
        .pearl-form p { color: var(--text-light); margin-bottom: 30px; font-size: 1.1rem; }
        
        .form-grid { display: grid; grid-template-columns: 1fr; gap: 15px; }
        .input-wrap { position: relative; }
        .input-wrap i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: var(--primary); opacity: 0.5; }
        .form-input { 
            width: 100%; padding: 20px 20px 20px 55px; border-radius: 18px; border: 1px solid #eee; 
            background: #fff; color: var(--text-dark); font-size: 16px; transition: 0.3s;
        }
        .form-input:focus { outline: none; border-color: var(--primary); background: #fdfbff; }

        /* PODER CAJAYA (GRID 3 COLS) */
        .section-poder { background: #fff; padding: 120px 10%; text-align: center; }
        .header-elite h2 { font-family: 'Outfit', sans-serif; font-size: 4rem; letter-spacing: -2px; font-weight: 900; }
        .header-elite h2 span { color: var(--primary); }
        .grid-poder { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; margin-top: 60px; }
        .card-poder { 
            padding: 50px 35px; border-radius: 40px; background: var(--bg-off); 
            transition: var(--transition-elite); border: 2px solid transparent;
        }
        .card-poder:hover { 
            transform: translateY(-15px); background: #fff; 
            border-color: var(--primary-soft); box-shadow: 0 40px 80px rgba(106,55,183,0.1);
        }
        .card-poder i { font-size: 50px; color: var(--primary); margin-bottom: 25px; }
        .card-poder h3 { font-size: 1.6rem; font-weight: 900; margin-bottom: 15px; }

        /* PLANES (GRID 3 COLS) */
        .section-planes { padding: 120px 8%; background: var(--bg-off); }
        .grid-planes { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; max-width: 1300px; margin: 60px auto 0; }
        .p-card { 
            background: #fff; padding: 70px 40px; border-radius: 45px; 
            position: relative; transition: var(--transition-elite); box-shadow: 0 10px 40px rgba(0,0,0,0.02);
            display: flex; flex-direction: column; align-items: center; text-align: center;
            border: 3px solid transparent;
        }
        .p-card:hover { 
            transform: translateY(-15px) scale(1.02); 
            box-shadow: 0 50px 100px rgba(106,55,183,0.12);
            border-color: var(--primary-glow);
        }
        .p-card.featured { border-color: var(--primary-glow); z-index: 10; }
        .badge-elite { position: absolute; top: -15px; right: 30px; background: var(--primary); color: #fff; padding: 10px 25px; border-radius: 50px; font-size: 12px; font-weight: 900; }
        
        .price-box { font-size: 4.5rem; font-weight: 900; color: var(--primary); margin: 20px 0; display: flex; align-items: baseline; }
        .price-sub { font-size: 1.2rem; color: var(--text-light); opacity: 0.5; margin-left: 5px; }
        .p-features { list-style: none; margin-bottom: 40px; text-align: left; width: 100%; }
        .p-features li { margin-bottom: 15px; font-size: 15px; display: flex; align-items: center; color: var(--text-light); }
        .p-features li i { color: var(--primary); margin-right: 12px; font-size: 18px; }
        .btn-cta { width: 100%; background: var(--primary-soft); color: var(--primary); text-decoration: none; padding: 22px; border-radius: 20px; font-weight: 900; text-transform: uppercase; transition: 0.3s; }
        .p-card.featured .btn-cta { background: var(--primary); color: #fff; }

        /* FAQ ELITE MINIMALIST (V31) */
        .section-faq { padding: 120px 10%; background: #fff; text-align: center; }
        .faq-container { max-width: 850px; margin: 60px auto 0; text-align: left; }
        .faq-item { border-bottom: 1px solid #eee; transition: 0.3s; }
        .faq-item h4 { padding: 35px 0; font-size: 1.25rem; font-weight: 600; display: flex; justify-content: space-between; align-items: center; color: var(--text-dark); cursor: pointer; }
        .faq-item i { font-size: 0.9rem; opacity: 0.3; transition: 0.4s; }
        .faq-body { max-height: 0; opacity: 0; overflow: hidden; transition: 0.5s cubic-bezier(0.16, 1, 0.3, 1); color: var(--text-light); line-height: 1.8; }
        .faq-item.active .faq-body { padding-bottom: 35px; max-height: 200px; opacity: 1; }
        .faq-item.active i { transform: rotate(45deg); opacity: 1; color: var(--primary); }

        /* RIBBON CTA (V31) */
        .ribbon-cta { 
            background: linear-gradient(90deg, #2D1452, #6A37B7); 
            padding: 60px 10%; color: #fff; display: flex; align-items: center; justify-content: space-between; 
            border-radius: 0; position: relative; z-index: 10;
        }
        .ribbon-text h3 { font-family: 'Outfit', sans-serif; font-size: 2.2rem; margin-bottom: 5px; letter-spacing: -1px; }
        .ribbon-text p { opacity: 0.7; font-size: 1.1rem; }
        .btn-white { background: #fff; color: var(--primary); padding: 18px 40px; border-radius: 15px; font-weight: 800; text-decoration: none; transition: 0.3s; border: none; cursor: pointer; text-transform: uppercase; font-size: 14px; }
        .btn-white:hover { transform: scale(1.05); box-shadow: 0 10px 30px rgba(0,0,0,0.2); }

        /* MODAL GLASS (V31) */
        .modal-overlay { position: fixed; inset: 0; background: rgba(13, 11, 20, 0.85); backdrop-filter: blur(15px); z-index: 10000; display: none; align-items: center; justify-content: center; padding: 20px; }
        .modal-glass { 
            background: rgba(255,255,255,0.95); padding: 60px; border-radius: 40px; width: 100%; max-width: 550px; 
            position: relative; animation: modalUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes modalUp { from { transform: translateY(50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-close { position: absolute; top: 30px; right: 30px; font-size: 24px; cursor: pointer; opacity: 0.3; transition: 0.3s; }
        .modal-close:hover { opacity: 1; color: var(--primary); }

        /* FOOTER MIDNIGHT ELITE (V28) */
        footer { 
            padding: 160px 10% 60px; 
            background: #0D0B14;
            color: #fff; position: relative; overflow: visible;
        }
        .f-wave { 
            position: absolute; top: -90px; left: 0; width: 100%; height: 100px; 
            z-index: 1; pointer-events: none;
        }
        .f-wave svg { display: block; width: 100%; height: 100%; }
        
        .f-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 60px; position: relative; z-index: 10; }
        .f-col img { height: 40px; margin-bottom: 30px; filter: brightness(0) invert(1); }
        .f-col p { color: rgba(255,255,255,0.5); line-height: 1.8; font-size: 15px; }
        .f-col h5 { font-size: 14px; color: var(--primary-glow); margin-bottom: 30px; letter-spacing: 3px; text-transform: uppercase; font-weight: 900; }
        .f-col a { color: rgba(255,255,255,0.7); text-decoration: none; display: block; margin-bottom: 15px; transition: 0.3s; font-size: 15px; }
        .f-col a:hover { color: #fff; transform: translateX(5px); }

        .f-bottom { margin-top: 100px; padding-top: 40px; border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; opacity: 0.3; font-size: 12px; letter-spacing: 2px; }

        @media (max-width: 1024px) {
            .grid-poder, .grid-planes { grid-template-columns: 1fr; }
            .f-grid { grid-template-columns: 1fr; text-align: center; }
            .f-col { align-items: center; display: flex; flex-direction: column; }
            .f-bottom { flex-direction: column; gap: 20px; text-align: center; }
            .slide { justify-content: center; padding: 0 5%; }
            .hero-content { text-align: center; }
            .hero-content p { border-left: none; border-top: 5px solid var(--primary); padding-top: 25px; }
        }
    </style>
</head>
<body>

    <div id="preloader"><img src="assets/img/logo.png" class="pre-logo"></div>

    <nav id="navbar">
        <a href="#" class="nav-logo"><img src="assets/img/logo.png"></a>
        <div class="nav-links">
            <a href="#planes" class="btn-nav-purple">Planes Élite</a>
            <a href="https://wa.me/56900000000" target="_blank" class="btn-wa">Soporte WhatsApp</a>
        </div>
    </nav>

    <section class="hero">
        <div class="c-arrow c-prev" onclick="prevSlide()"><i class="fa-solid fa-chevron-left"></i></div>
        <div class="c-arrow c-next" onclick="nextSlide()"><i class="fa-solid fa-chevron-right"></i></div>
        <div class="hero-carousel">
            <div class="carousel-track" id="heroTrack">
                <div class="slide">
                    <img src="assets/img/banner_super.png" class="slide-bg">
                    <div class="slide-overlay"></div>
                    <div class="hero-content">
                        <h1 class="reveal">Software para tu <span>Supermercado.</span></h1>
                        <p class="reveal">Optimiza tus ventas y controla tu stock con la plataforma Élite líder en Minimarkets de Chile.</p>
                        <div class="reveal">
                            <a href="#planes" class="btn-primary">Ver Planes</a>
                            <button onclick="moveCarousel(1)" style="background: none; border: 2px solid var(--primary); color: var(--primary); padding: 18px 35px; border-radius: 18px; font-weight: 800; cursor: pointer; margin-left: 10px;">¡Infórmame más!</button>
                        </div>
                    </div>
                </div>
                <div class="slide">
                    <img src="assets/img/banner_super.png" class="slide-bg" style="filter: blur(5px) brightness(0.6);">
                    <div class="slide-overlay" style="background: rgba(255,255,255,0.4);"></div>
                    <div class="pearl-form reveal">
                        <h2>Únete a la <span>Élite</span></h2>
                        <p>Déjanos tus datos y un consultor experto te contactará hoy mismo.</p>
                        <form onsubmit="handleLead(event, this)" class="form-grid">
                            <div class="input-wrap"><i class="fa-solid fa-user"></i><input type="text" name="nombre" class="form-input" placeholder="Nombre completo" required></div>
                            <div class="input-wrap"><i class="fa-solid fa-envelope"></i><input type="email" name="email" class="form-input" placeholder="Correo electrónico" required></div>
                            <div class="input-wrap"><i class="fa-solid fa-whatsapp"></i><input type="text" name="whatsapp" class="form-input" placeholder="WhatsApp" required></div>
                            <button type="submit" class="btn-primary" style="width: 100%;">Solicitar Info Ahora</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-poder" id="poder" style="background: var(--bg-off);">
        <div class="header-elite">
            <h2 class="reveal">El Poder de <span>CajaYa.</span></h2>
            <p class="reveal" style="color: var(--text-light); margin-top: 20px; font-size: 1.3rem;">La tecnología que tu negocio merece.</p>
        </div>
        <div class="grid-poder">
            <div class="card-poder reveal"><i class="fa-solid fa-bolt"></i><h3>Velocidad</h3><p>Ventas ultra-rápidas para evitar colas en tu local.</p></div>
            <div class="card-poder reveal"><i class="fa-solid fa-cloud"></i><h3>Nube Híbrida</h3><p>Sigue vendiendo incluso si pierdes el Internet.</p></div>
            <div class="card-poder reveal"><i class="fa-solid fa-chart-pie"></i><h3>Control</h3><p>Stock e inventarios bajo control total desde tu celular.</p></div>
        </div>
    </section>

    <div class="ribbon-cta reveal">
        <div class="ribbon-text">
            <h3>Prueba la potencia de CajaYa hoy mismo.</h3>
            <p>Captura la eficiencia de un sistema de clase mundial en tu negocio.</p>
        </div>
        <button onclick="openModal()" class="btn-white">Obtener Demo Gratis</button>
    </div>

    <section class="section-planes" id="planes">
        <div class="header-elite" style="text-align: center;">
            <h2 class="reveal">Planes a tu <span>Medida.</span></h2>
        </div>
        <div class="grid-planes">
            <div class="p-card reveal">
                <h3>PLAN EMPRENDE</h3>
                <div class="price-box">$<?php echo $pMensual; ?><span class="price-sub">/mes</span></div>
                <ul class="p-features"><li><i class="fa-solid fa-check"></i> Catálogo Maestro</li><li><i class="fa-solid fa-check"></i> Boletas SII</li></ul>
                <a href="#" class="btn-cta">Elegir Plan</a>
            </div>
            <div class="p-card featured reveal">
                <div class="badge-elite">Sugerido</div>
                <h3>LICENCIA ÉLITE</h3>
                <div class="price-box">$<?php echo $pLifetime; ?></div>
                <p style="margin-top:-20px; margin-bottom:20px; font-weight:800; opacity:0.4;">PAGO ÚNICO</p>
                <ul class="p-features"><li><i class="fa-solid fa-crown"></i> 3 Cajas Simultáneas</li><li><i class="fa-solid fa-crown"></i> Cero Mensualidades</li></ul>
                <a href="#" class="btn-cta">Comprar Vitalicía</a>
            </div>
            <div class="p-card reveal">
                <h3>PLAN EMPRESA</h3>
                <div class="price-box">$<?php echo $pEmpresa; ?><span class="price-sub">/mes</span></div>
                <ul class="p-features"><li><i class="fa-solid fa-building"></i> Multi-sucursal</li><li><i class="fa-solid fa-building"></i> API Pro</li></ul>
                <a href="#" class="btn-cta">Consultar Ventas</a>
            </div>
        </div>
    </section>

    <section class="section-faq">
        <h2 class="reveal">Dudas <span>Frecuentes.</span></h2>
        <div class="faq-container reveal">
            <div class="faq-item"><h4><span>¿Cómo instalo el catálogo?</span><i class="fa-solid fa-plus"></i></h4><div class="faq-body"><p>Ya viene integrado con más de 20,000 productos precargados.</p></div></div>
            <div class="faq-item"><h4><span>¿Funciona sin Internet?</span><i class="fa-solid fa-plus"></i></h4><div class="faq-body"><p>Sí, el sistema funciona offline y sincroniza al detectar conexión.</p></div></div>
        </div>
    </section>

    <footer>
        <div class="modal-overlay" id="leadModal">
            <div class="modal-glass">
                <i class="fa-solid fa-xmark modal-close" onclick="closeModal()"></i>
                <div style="text-align:center; margin-bottom:40px;">
                    <h2 style="font-family:'Outfit'; font-size:2.5rem; color:var(--primary); margin-bottom:10px;">¡Tu Demo te espera!</h2>
                    <p style="color:var(--text-light);">Completa estos datos y descarga el instalador al instante.</p>
                </div>
                <form onsubmit="handleLead(event, this)" class="form-grid">
                    <div class="input-wrap"><i class="fa-solid fa-envelope"></i><input type="email" name="email" class="form-input" placeholder="Tu Gmail Corporativo" required></div>
                    <div class="input-wrap"><i class="fa-solid fa-whatsapp"></i><input type="text" name="whatsapp" class="form-input" placeholder="Tu WhatsApp (Ej: +569...)" required></div>
                    <button type="submit" class="btn-primary" style="width: 100%; margin-top:10px;">Descargar Demo Ahora</button>
                </form>
            </div>
        </div>

        <div class="f-wave">
            <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path fill="#ffffff" fill-opacity="1" d="M0,160L48,176C96,192,192,224,288,213.3C384,203,480,149,576,144C672,139,768,181,864,202.7C960,224,1056,224,1152,197.3C1248,171,1344,117,1392,90.7L1440,64L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
            </svg>
        </div>
        <div class="f-grid">
            <div class="f-col">
                <img src="assets/img/logo.png">
                <p>Potenciando el retail independiente en Chile con tecnología de clase mundial.</p>
            </div>
            <div class="f-col">
                <h5>PLATAFORMA</h5>
                <a href="#">Panel Maestro</a>
                <a href="#">Descargar App</a>
                <a href="#">Guía de Uso</a>
            </div>
            <div class="f-col">
                <h5>SOPORTE</h5>
                <a href="#">Centro de Ayuda</a>
                <a href="#">WhatsApp VIP</a>
                <a href="#">Contacto</a>
            </div>
            <div class="f-col">
                <h5>LEGAL</h5>
                <a href="#">Privacidad</a>
                <a href="#">Términos</a>
                <a href="#">Contrato</a>
            </div>
        </div>
        <div class="f-bottom">
            <span>&copy; 2026 CAJAYA ELITE. TODOS LOS DERECHOS RESERVADOS.</span>
            <span>RM, SANTIAGO DE CHILE</span>
        </div>
    </footer>

    <script>
        window.addEventListener('load', () => {
            const pre = document.getElementById('preloader');
            pre.style.opacity = '0';
            setTimeout(() => pre.style.display = 'none', 600);
        });
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });
        const obs = new IntersectionObserver(ents => ents.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); }), { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

        document.querySelectorAll('.faq-item h4').forEach(it => it.addEventListener('click', () => it.parentElement.classList.toggle('active')));

        function openModal() { document.getElementById('leadModal').style.display = 'flex'; }
        function closeModal() { document.getElementById('leadModal').style.display = 'none'; }

        let slide = 0;
        function moveCarousel(idx) { 
            slide = idx; 
            document.getElementById('heroTrack').style.transform = `translateX(-${idx*100}%)`; 
        }
        function nextSlide() { slide = (slide + 1) % 2; moveCarousel(slide); }
        function prevSlide() { slide = (slide - 1 + 2) % 2; moveCarousel(slide); }
        
        let autoPlay = setInterval(nextSlide, 9000);
        
        // Reset timer on manual click
        document.querySelectorAll('.c-arrow').forEach(btn => {
            btn.addEventListener('click', () => {
                clearInterval(autoPlay);
                autoPlay = setInterval(nextSlide, 10000);
            });
        });

        async function handleLead(e, f) {
            e.preventDefault();
            const b = f.querySelector('button'); b.innerHTML = 'ENVIANDO...';
            try {
                const r = await fetch('save_lead.php', { method: 'POST', body: new FormData(f) });
                if(r.ok) f.innerHTML = '<h3 style="color:var(--primary); padding:30px;">¡Recibido!</h3>';
            } catch(e) { b.innerHTML = 'REINTENTAR'; }
        }
    </script>
</body>
</html>
