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
    // Filtramos solo los 3 planes oficiales (V63)
    $plansRaw = array_filter($planRepo->getAll(), function($p) {
        return in_array(trim(strtolower($p['slug'])), ['mensual', 'lifetime', 'empresa']);
    });
    // Ordenamos manualmente para asegurar el diseño (V63)
    usort($plansRaw, function($a, $b) {
        $order = ['mensual' => 1, 'lifetime' => 2, 'empresa' => 3];
        return $order[trim(strtolower($a['slug']))] <=> $order[trim(strtolower($b['slug']))];
    });
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
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/build/jwt-decode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
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
        .nav-links a { color: var(--text-dark); text-decoration: none; font-weight: 700; font-size: 14px; margin-left: 15px; transition: 0.3s; white-space: nowrap; }
        .btn-nav-purple { background: var(--primary); color: #fff !important; padding: 8px 18px; border-radius: 50px; font-weight: 800; font-size: 12px; box-shadow: 0 10px 20px rgba(106,55,183,0.15); text-transform: uppercase; }
        .btn-wa { background: #25D366; color: #fff !important; padding: 8px 18px; border-radius: 50px; font-weight: 800; font-size: 12px; box-shadow: 0 10px 20px rgba(37,211,102,0.15); text-transform: uppercase; }
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
        
        /* ESTILOS BOTONES HERO (V69) */
        .hero-actions { display: flex; gap: 15px; justify-content: flex-start; align-items: center; }
        .btn-outline-hero {
            background: rgba(255,255,255,0.1); border: 2px solid rgba(255,255,255,0.4); color: #fff;
            padding: 18px 35px; border-radius: 18px; font-weight: 800; cursor: pointer; transition: 0.3s;
            backdrop-filter: blur(5px);
        }
        .btn-outline-hero:hover { background: #fff; color: var(--primary); border-color: #fff; transform: translateY(-3px); }
        .btn-google-elite { 
            background: #fff; color: #444; border: 1px solid #e0e0e0; width: 100%; padding: 15px; border-radius: 50px; 
            font-weight: 700; font-size: 15px; display: flex; align-items: center; justify-content: center; gap: 12px; 
            cursor: pointer; transition: 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.05); font-family: 'Inter', sans-serif;
        }
        .btn-google-elite:hover { background: #f8f9fa; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); border-color: #ccc; }
        .btn-google-elite i { color: #DB4437; font-size: 1.1rem; }

        /* FAQ ULTRA MODERN (V32) */
        .section-faq { padding: 120px 10%; background: var(--bg-off); text-align: center; }
        .faq-container { max-width: 900px; margin: 60px auto 0; text-align: left; }
        .faq-item { margin-bottom: 25px; border-radius: 35px; background: #fff; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 15px 40px rgba(0,0,0,0.03); transition: 0.5s cubic-bezier(0.16, 1, 0.3, 1); overflow: hidden; }
        .faq-item h4 { padding: 40px 50px; font-size: 1.4rem; font-weight: 800; display: flex; justify-content: space-between; align-items: center; color: var(--text-dark); cursor: pointer; letter-spacing: -0.5px; }
        .faq-item i { width: 45px; height: 45px; background: var(--primary-soft); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem; transition: 0.5s; }
        .faq-body { padding: 0 50px 0; max-height: 0; opacity: 0; overflow: hidden; transition: 0.6s cubic-bezier(0.16, 1, 0.3, 1); color: var(--text-light); font-size: 1.15rem; line-height: 1.9; }
        .faq-item.active { box-shadow: 0 40px 80px rgba(106,55,183,0.1); border-color: var(--primary-soft); }
        .faq-item.active .faq-body { padding-bottom: 45px; max-height: 350px; opacity: 1; }
        .faq-item.active i { transform: rotate(135deg); background: var(--primary); color: #fff; }

        /* RIBBON CTA (V31) */
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

        @media (max-width: 1024px) {
            .ribbon-cta { 
                flex-direction: column; 
                text-align: center; 
                gap: 30px; 
                padding: 60px 8%; 
                border-radius: 0; 
            }
            .ribbon-text h3 { font-size: 1.8rem; }
            .ribbon-text p { font-size: 1rem; margin-bottom: 0; }
            .btn-white { width: 100%; max-width: 300px; padding: 20px; }
        }

        /* MODAL GLASS (V31) */
        .modal-overlay { position: fixed; inset: 0; background: rgba(13, 11, 20, 0.85); backdrop-filter: blur(15px); z-index: 10000; display: none; align-items: center; justify-content: center; padding: 20px; cursor: pointer; }
        .modal-glass { 
            background: rgba(255,255,255,0.98); padding: 60px; border-radius: 40px; width: 100%; max-width: 550px; 
            position: relative; animation: modalUp 0.6s cubic-bezier(0.16, 1, 0.3, 1); cursor: default;
            box-shadow: 0 50px 100px rgba(0,0,0,0.5);
        }
        @keyframes modalUp { from { transform: translateY(50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-close { position: absolute; top: 30px; right: 30px; font-size: 28px; cursor: pointer; opacity: 0.5; transition: 0.3s; color: var(--text-dark); }
        .modal-close:hover { opacity: 1; color: var(--primary); transform: rotate(90deg); }

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
            nav { padding: 0 5%; height: 70px; }
            .nav-logo img { height: 28px; }
            .nav-links { display: flex; gap: 8px; }
            .nav-links a { margin-left: 0; padding: 6px 12px; font-size: 10px; }
            .hero-content h1 { 
                font-size: 2.3rem; letter-spacing: -1.5px; margin-bottom: 20px; text-align: center; 
                color: #ffffff !important;
                text-shadow: 0 4px 20px rgba(0,0,0,0.8); 
            }
            .hero-content h1 span { 
                color: #B28DFF !important; 
                text-shadow: 0 0 15px rgba(178,141,255,0.6); /* Efecto Neón (V71) */
            }
            .hero-content p { 
                font-size: 1.1rem; 
                padding: 0 10px;
                text-align: center; 
                margin-bottom: 40px; 
                line-height: 1.5;
                color: rgba(255,255,255,0.95) !important;
                text-shadow: 0 2px 15px rgba(0,0,0,0.9);
                border-left: none !important; /* Elimina la línea lateral (V71) */
            }
            .slide-overlay {
                background: rgba(0,0,0,0.6) !important;
            }
            .hero-actions { display: flex; flex-direction: column; gap: 20px; align-items: center; width: 100%; }
            .btn-primary { width: 100%; max-width: 300px; padding: 20px; font-size: 16px; }
            .btn-outline-hero { 
                width: 100%; max-width: 300px; padding: 20px; font-size: 16px;
                background: rgba(255,255,255,0.15) !important; /* Cristal más limpio (V71) */
                border: 1px solid rgba(255,255,255,0.5) !important;
            }
            
            .section-planes { padding: 60px 6%; }
            .grid-planes { display: flex; flex-direction: column; gap: 30px; margin-top: 40px; }
            .p-card { padding: 50px 30px; border-radius: 35px; width: 100% !important; max-width: 100%; }
            .price-box { font-size: 3.5rem; flex-wrap: wrap; justify-content: center; }
            .price-sub { font-size: 1.1rem; width: 100%; margin-top: -10px; }

            .grid-poder { grid-template-columns: 1fr; gap: 20px; }
            .f-grid { grid-template-columns: 1fr; text-align: center; }
            .f-col { align-items: center; display: flex; flex-direction: column; }
            .f-bottom { flex-direction: column; gap: 20px; text-align: center; }
            .slide { justify-content: center; padding: 0 5%; }
            .hero-content { text-align: center; width: 100%; max-width: 100%; padding: 0 10px; }
            .c-arrow { width: 38px; height: 38px; font-size: 10px; background: rgba(255,255,255,0.95); color: var(--primary); }
            .c-prev { left: 5px; z-index: 200; }
            .c-next { right: 5px; z-index: 200; }
            .faq-item h4 { padding: 25px 20px; font-size: 1.1rem; }
            .faq-body { padding: 0 20px 0; font-size: 1rem; }
            .faq-item.active .faq-body { padding-bottom: 25px; }
        }

        /* REVEAL ON SCROLL ANIMATIONS (V60) - ULTRA RICH iOS STYLE */
        .reveal-section { 
            opacity: 0; 
            transform: translateY(120px) scale(0.94); 
            filter: blur(15px);
            transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform, opacity, filter;
        }
        .reveal-section.revealed { 
            opacity: 1; 
            transform: translateY(0) scale(1); 
            filter: blur(0);
        }

        /* BOTÓN ÉLITE PREMIUM (V65) */
        .btn-elite {
            background: linear-gradient(135deg, #6A37B7 0%, #9D6CFF 100%);
            color: #fff;
            border: none;
            padding: 18px 30px;
            border-radius: 20px;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 10px 25px rgba(106, 55, 183, 0.3);
            width: 100%;
        }
        .btn-elite:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px rgba(157, 108, 255, 0.4);
            filter: brightness(1.1);
        }
        .btn-elite i { font-size: 20px; }
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
                        <h1 class="reveal">Transforma tu Minimarket en un <span>Gigante</span> del Retail.</h1>
                        <p class="reveal">La tecnología Élite que las grandes cadenas no quieren que tengas. Gestión inteligente y ventas ultra-rápidas para tu Pyme.</p>
                        <div class="hero-actions reveal">
                            <a href="#planes" class="btn-primary" style="text-align: center;">Ver Planes</a>
                            <button onclick="moveCarousel(1)" class="btn-outline-hero">¡Infórmame más!</button>
                        </div>
                    </div>
                </div>
                <div class="slide">
                    <img src="assets/img/banner_super.png" class="slide-bg" style="filter: blur(5px) brightness(0.6);">
                    <div class="slide-overlay" style="background: rgba(255,255,255,0.4);"></div>
                    <div class="pearl-form reveal">
                        <h2>Únete a la <span>Élite</span></h2>
                        <p>Déjanos tus datos y un consultor experto te contactará hoy mismo.</p>
                    <form onsubmit="handleLead(event, this, false)" class="form-grid">
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

    <section class="section-poder reveal-section" id="poder" style="background: var(--bg-off);">
        <div class="header-elite">
            <h2>El Poder de <span>CajaYa.</span></h2>
            <p style="color: var(--text-light); margin-top: 20px; font-size: 1.3rem;">La tecnología que tu negocio merece.</p>
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

    <section class="section-planes reveal-section" id="planes">
        <div class="header-elite" style="text-align: center;">
            <h2>Planes a tu <span>Medida.</span></h2>
            <p style="color: var(--text-light); margin-top: 20px;">Elige el nivel de potencia que tu negocio necesita hoy.</p>
        </div>
        <div class="grid-planes">
            <?php foreach ($plansRaw as $p): 
                $slug = trim(strtolower($p['slug']));
                $isFeatured = ($slug === 'lifetime');
                $price = number_format($p['price'], 0, ',', '.');
                $isEnterprise = ($slug === 'empresa');
            ?>
            <div class="p-card <?php echo $isFeatured ? 'featured' : ''; ?> reveal">
                <?php if ($isFeatured): ?><div class="badge-elite">Sugerido</div><?php endif; ?>
                
                <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                
                <div class="price-box">$<?php echo $price; ?><?php if (!$isFeatured && !$isEnterprise): ?><span class="price-sub">/mes</span><?php endif; ?></div>
                
                <?php if ($isFeatured): ?>
                    <p style="margin-top:-20px; margin-bottom:20px; font-weight:800; opacity:0.4; text-transform:uppercase;">PAGO ÚNICO</p>
                <?php endif; ?>

                <ul class="p-features">
                    <?php 
                        $rawDesc = trim($p['description'] ?? '');
                        $points = !empty($rawDesc) ? explode("\n", $rawDesc) : ["Consultar beneficios"];
                        foreach ($points as $point): if(trim($point) === "") continue;
                    ?>
                        <li><i class="fa-solid fa-check"></i> <?php echo htmlspecialchars(trim($point)); ?></li>
                    <?php endforeach; ?>
                </ul>

                <button onclick="startPurchase('<?php echo $slug; ?>', '<?php echo htmlspecialchars($p['name']); ?>', <?php echo $p['price']; ?>)" class="btn-cta" style="border:none; cursor:pointer;">
                    <?php echo $isEnterprise ? 'Consultar Ventas' : ($isFeatured ? 'Comprar Vitalicia' : 'Elegir Plan'); ?>
                </button>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="section-faq reveal-section">
        <h2>Dudas <span>Frecuentes.</span></h2>
        <div class="faq-container">
            <div class="faq-item"><h4><span>¿Cómo instalo el catálogo?</span><i class="fa-solid fa-plus"></i></h4><div class="faq-body"><p>Ya viene integrado con más de 20,000 productos precargados.</p></div></div>
            <div class="faq-item"><h4><span>¿Funciona sin Internet?</span><i class="fa-solid fa-plus"></i></h4><div class="faq-body"><p>Sí, el sistema funciona offline y sincroniza al detectar conexión.</p></div></div>
        </div>
    </section>

    <footer>
        <div class="modal-overlay" id="leadModal">
            <div class="modal-glass">
                <i class="fa-solid fa-xmark modal-close" onclick="closeModal()"></i>
                <div style="text-align:center; margin-bottom:30px;">
                    <h2 style="font-family:'Outfit'; font-size:2.5rem; color:var(--primary); margin-bottom:10px;">¡Tu Demo te espera!</h2>
                    <p style="color:var(--text-light);">La forma más rápida de entrar a la Élite.</p>
                </div>

                <!-- Botón de Google Real (V44) -->
                <div id="google-capture-area" style="margin-bottom:30px; display:flex; justify-content:center;">
                    <div id="g_id_onload"
                         data-client_id="630347695888-uaeq5t3h6i9urd5lfmn7odovlauhmrau.apps.googleusercontent.com"
                         data-callback="handleGoogleLead"
                         data-auto_prompt="true">
                    </div>
                    <div class="g_id_signin" data-type="standard" data-shape="pill" data-theme="filled_blue" data-text="continue_with" data-size="large" data-logo_alignment="left"></div>
                </div>

                <div style="display:flex; align-items:center; margin-bottom:30px; opacity:0.3;"><hr style="flex:1;"><span style="padding:0 15px; font-size:12px;">O USA TU CORREO</span><hr style="flex:1;"></div>

                <form onsubmit="handleLead(event, this, true)" class="form-grid">
                    <div class="input-wrap"><i class="fa-solid fa-user"></i><input type="text" name="nombre" class="form-input" placeholder="Nombre completo" autocomplete="name" required></div>
                    <div class="input-wrap"><i class="fa-solid fa-envelope"></i><input type="email" name="email" class="form-input" placeholder="Tu Gmail Corporativo" autocomplete="email" required></div>
                    <div class="input-wrap"><i class="fa-solid fa-whatsapp"></i><input type="text" name="whatsapp" class="form-input" placeholder="Tu WhatsApp (Ej: +569...)" autocomplete="tel" required></div>
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

        function openModal() { 
            const m = document.getElementById('leadModal');
            m.style.display = 'flex'; 
            
            // Auto-relleno desde Memoria (V39)
            const saved = JSON.parse(localStorage.getItem('cajaya_lead') || '{}');
            if(saved.nombre) m.querySelector('[name="nombre"]').value = saved.nombre;
            if(saved.email) m.querySelector('[name="email"]').value = saved.email;
            if(saved.whatsapp) m.querySelector('[name="whatsapp"]').value = saved.whatsapp;
            
            m.querySelector('.form-input').focus();
        }
        function closeModal() { document.getElementById('leadModal').style.display = 'none'; }
        
        document.getElementById('leadModal').addEventListener('click', (e) => {
            if(e.target.id === 'leadModal') closeModal();
        });

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

        function focusGmail() {
            document.querySelector('#leadModal input[name="email"]').focus();
        }

        async function handleLead(e, f, isModal) {
            if(e) e.preventDefault();
            const b = f.querySelector('button'); 
            const originalText = b ? b.innerHTML : '';
            if(b) b.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> PROCESANDO...';
            
            try {
                const r = await fetch('save_lead.php', { method: 'POST', body: new FormData(f) });
                if(r.ok) {
                    // Guardar en memoria para "Menos Clics" la próxima vez (V39)
                    const data = new FormData(f);
                    localStorage.setItem('cajaya_lead', JSON.stringify({
                        nombre: data.get('nombre'),
                        email: data.get('email'),
                        whatsapp: data.get('whatsapp')
                    }));

                    // SUPERNOVA ELITE (V37) - EXPLOSIÓN TOTAL
                    const end = Date.now() + 3000;
                    const colors = ['#6A37B7', '#ffffff', '#FFD700', '#25D366'];

                    (function frame() {
                        confetti({ particleCount: 7, angle: 60, spread: 55, origin: { x: 0 }, colors: colors });
                        confetti({ particleCount: 7, angle: 120, spread: 55, origin: { x: 1 }, colors: colors });
                        if (Date.now() < end) requestAnimationFrame(frame);
                    }());

                    const container = isModal ? document.querySelector('.modal-glass') : f.parentElement;
                    container.innerHTML = `<div style="text-align:center; padding:60px; animation: modalUp 0.8s ease;">
                        <div class="reveal visible"><i class="fa-solid fa-crown" style="font-size:6rem; color:#FFD700; margin-bottom:30px; filter: drop-shadow(0 0 20px rgba(255,215,0,0.5));"></i></div>
                        <h2 style="color:var(--primary); font-size:3.5rem; margin-bottom:15px; font-family:'Outfit';">¡Nivel Élite!</h2>
                        <p style="color:var(--text-light); font-size:1.5rem;">Bienvenido a la nueva era de tu negocio.<br>Un consultor experto te contactará de inmediato.</p>
                    </div>`;
                    if(isModal) setTimeout(closeModal, 6000);
                }
            } catch(e) { 
                if(b) b.innerHTML = 'REINTENTAR'; 
                setTimeout(() => { if(b) b.innerHTML = originalText; }, 2000);
            }
        }

        // REVEAL ENGINE (V59)
        const observerOptions = { threshold: 0.1 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal-section').forEach(section => {
            observer.observe(section);
        });

        function handleGoogleLead(response) {
            const data = jwt_decode(response.credential);
            const container = document.querySelector('.modal-glass');
            
            // Transformación del modal para pedir WhatsApp (V48)
            container.innerHTML = `
                <div style="text-align:center; padding:40px; animation: modalUp 0.6s ease;">
                    <img src="${data.picture}" style="width:80px; height:80px; border-radius:50%; border:3px solid var(--primary); margin-bottom:20px; box-shadow:0 10px 20px rgba(0,0,0,0.1);">
                    <h3 style="color:var(--primary); font-size:2rem; margin-bottom:10px; font-family:'Outfit';">¡Hola, ${data.given_name}!</h3>
                    <p style="color:var(--text-light); margin-bottom:30px;">Solo nos falta tu WhatsApp para enviarte la Demo ahora mismo.</p>
                    
                    <form onsubmit="finishGoogleLead(event, this, '${data.name}', '${data.email}')" class="lead-form">
                        <div class="input-group" style="margin-bottom:20px;">
                            <i class="fa-brands fa-whatsapp"></i>
                            <input type="tel" name="whatsapp" placeholder="+569..." required class="form-input" autofocus>
                        </div>
                        <button type="submit" class="btn-elite" style="width:100%; height:60px;">
                            <i class="fa-solid fa-bolt"></i> ACTIVAR DEMO GRATIS
                        </button>
                    </form>
                </div>
            `;
            container.querySelector('input[name="whatsapp"]').focus();
        }

        async function finishGoogleLead(e, f, nombre, email) {
            e.preventDefault();
            const formData = new FormData(f);
            formData.append('nombre', nombre);
            formData.append('email', email);
            
            // Llamamos a la función de envío principal (isModal = true)
            handleLead(e, f.parentElement, true, formData);
        }

        // PURCHASE FLOW (V61)
        let selectedPlan = null;

        function startPurchase(slug, name, price) {
            selectedPlan = { slug, name, price };
            
            // Reutilizamos el modal de captura
            const m = document.getElementById('leadModal');
            m.querySelector('h2').innerText = '¡Casi es tuyo!';
            m.querySelector('p').innerText = `Estás adquiriendo el ${name}. Por favor, regístrate para generar tu licencia.`;
            m.querySelector('button').innerText = 'Proceder al Pago';
            
            openModal();
        }

        // Modificamos handleLead para soportar redirección a pago (V61)
        async function handleLead(e, container_el, isModal, externalData = null) {
            if(e) e.preventDefault();
            const form = externalData ? null : container_el.querySelector('form');
            const btn = container_el.querySelector('button');
            const originalText = btn.innerHTML;
            
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> PROCESANDO...';
            
            const dataToSend = externalData || new FormData(form);

            // Si es una compra, marcamos el provider
            if (selectedPlan) {
                dataToSend.append('provider', 'purchase_' + selectedPlan.slug);
            }

            try {
                const r = await fetch('save_lead.php', { method: 'POST', body: dataToSend });
                if(r.ok) {
                    localStorage.setItem('cajaya_lead', JSON.stringify({
                        nombre: dataToSend.get('nombre'),
                        email: dataToSend.get('email'),
                        whatsapp: dataToSend.get('whatsapp')
                    }));

                    confetti({ particleCount: 150, spread: 70, origin: { y: 0.6 } });

                    if (selectedPlan) {
                        // REDIRECCIÓN A MERCADO PAGO REAL (V65)
                        const target = isModal ? document.querySelector('.modal-glass') : container_el;
                        target.innerHTML = `<div style="text-align:center; padding:60px; animation: modalUp 0.8s ease;">
                            <i class="fa-solid fa-circle-notch fa-spin" style="font-size:5rem; color:var(--primary); margin-bottom:30px;"></i>
                            <h2 style="color:var(--primary); font-size:2.8rem; margin-bottom:15px; font-family:'Outfit';">¡Validando Pago!</h2>
                            <p style="color:var(--text-light); font-size:1.2rem; margin-bottom:30px;">Conectando con la pasarela segura de Mercado Pago...</p>
                        </div>`;
                        
                        // Usamos tu sistema dinámico de checkout (V65)
                        const checkoutBase = 'mercadopago/checkout.php?plan=';
                        const mpLinks = {
                            'mensual': checkoutBase + 'mensual',
                            'lifetime': checkoutBase + 'lifetime',
                            'empresa': 'https://wa.me/56900000000?text=Hola, quiero consultar por el Plan Empresa'
                        };
                        
                        setTimeout(() => {
                            window.location.href = mpLinks[selectedPlan.slug] || (checkoutBase + selectedPlan.slug);
                        }, 2500);

                    } else {
                        // Flujo normal de Demo
                        const target = isModal ? document.querySelector('.modal-glass') : container_el;
                        target.innerHTML = `<div style="text-align:center; padding:60px; animation: modalUp 0.8s ease;">
                            <i class="fa-solid fa-crown" style="font-size:6rem; color:#FFD700; margin-bottom:30px;"></i>
                            <h2 style="color:var(--primary); font-size:3.5rem; margin-bottom:15px; font-family:'Outfit';">¡Nivel Élite!</h2>
                            <p style="color:var(--text-light); font-size:1.5rem;">Bienvenido, ${dataToSend.get('nombre')}.<br>Tu Demo está siendo preparada.</p>
                        </div>`;
                        setTimeout(closeModal, 6000);
                    }
                }
            } catch(err) {
                btn.innerHTML = 'REINTENTAR';
            }
        }
    </script>
</body>
</html>
