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

        /* PRELOADER ÉLITE V84 (LOGO + BARRA) */
        #preloader { position: fixed; inset: 0; background: #fff; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 10000; transition: opacity 0.6s ease-in-out; }
        .pre-content { text-align: center; width: 300px; }
        .pre-logo { width: 150px; opacity: 0; transform: scale(0.9); animation: logoAppear 0.8s ease-out forwards; margin-bottom: 30px; }
        @keyframes logoAppear {
            to { opacity: 1; transform: scale(1); filter: drop-shadow(0 10px 20px rgba(106,55,183,0.15)); }
        }
        .load-bar-wrap { width: 100%; height: 3px; background: #f0f0f0; border-radius: 10px; overflow: hidden; position: relative; }
        .load-bar-fill { width: 0%; height: 100%; background: var(--primary); box-shadow: 0 0 15px var(--primary-glow); transition: width 2s cubic-bezier(0.1, 0.5, 0.5, 1); }
        
        /* Cursor de escritura (V74) */
        
        /* Cursor de escritura (V74) */
        .typing-cursor::after { content: '|'; animation: blink 1s infinite; margin-left: 2px; color: var(--primary); font-weight: 900; }
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }

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
        .hero-content p { font-size: 1.5rem; color: var(--text-dark); margin-bottom: 50px; border-left: 5px solid var(--primary); padding-left: 30px; max-width: 600px; font-weight: 500; }
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
                color: var(--text-dark) !important;
                text-shadow: 0 1px 10px rgba(255,255,255,0.8); /* Brillo sutil para despegar del fondo (V73) */
            }
            .hero-content h1 span { 
                color: var(--primary) !important; 
                text-shadow: none;
            }
            .hero-content p { 
                font-size: 1.1rem; 
                padding: 0 10px;
                text-align: center; 
                margin-bottom: 40px; 
                line-height: 1.5;
                color: var(--text-dark) !important; /* Letra Negra (V76) */
                font-weight: 500;
                text-shadow: none;
                border-left: none !important;
            }
            .slide-overlay {
                background: rgba(255,255,255,0.7) !important; /* Más transparencia = más contraste de imagen (V73) */
            }
            .hero-actions { display: flex; flex-direction: column; gap: 15px; align-items: center; width: 100%; }
            .btn-primary { width: 100%; max-width: 300px; padding: 20px; font-size: 15px; border-radius: 20px; }
            .btn-outline-hero { 
                width: 100%; max-width: 300px; padding: 18px; font-size: 15px;
                background: rgba(255,255,255,0.3) !important;
                border: 2px solid var(--primary) !important;
                color: var(--primary) !important;
                backdrop-filter: blur(5px);
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

        /* NUEVOS ESTILOS V77 - CONVERSIÓN PRO */
        .trust-bar { padding: 40px 10%; background: #fff; display: flex; justify-content: center; align-items: center; gap: 60px; opacity: 0.5; filter: grayscale(1); flex-wrap: wrap; border-bottom: 1px solid #f0f0f0; }
        .trust-bar img { height: 35px; }

        .mockup-section { padding: 120px 10%; display: grid; grid-template-columns: 1fr 1.2fr; gap: 80px; align-items: center; background: #fff; overflow: hidden; }
        .mockup-img { position: relative; }
        .mockup-img img { width: 100%; border-radius: 30px; box-shadow: 0 50px 100px rgba(106,55,183,0.15); transform: perspective(1000px) rotateY(-10deg); transition: 0.5s; }
        .mockup-img:hover img { transform: perspective(1000px) rotateY(0deg); }
        .mockup-badge { position: absolute; top: -20px; left: -20px; background: var(--primary); color: #fff; padding: 15px 25px; border-radius: 20px; font-weight: 900; box-shadow: 0 10px 30px rgba(106,55,183,0.4); z-index: 10; }

        /* STEPS V80 - SVG UI Mockups */
        .section-steps { padding: 120px 10%; text-align: center; background: var(--bg-off); }
        .grid-steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; margin-top: 60px; }
        .step-card { padding: 40px; background: #fff; border-radius: 40px; position: relative; transition: 0.4s; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
        .step-card:hover { transform: translateY(-10px); box-shadow: 0 20px 50px rgba(106,55,183,0.1); }
        .step-ui { width: 100%; height: 190px; margin-bottom: 25px; border-radius: 20px; background: linear-gradient(135deg, #fdfbff 0%, #f0eaff 100%); border: 1.5px solid #ede5ff; overflow: hidden; position: relative; }
        .step-num { width: 36px; height: 36px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 900; margin: 0 auto 15px; }
        .step-card h3 { margin-bottom: 12px; font-size: 1.5rem; font-weight: 800; }

        /* COMPARATIVA V80 - Feature Cards Mobile-First (sin scroll horizontal) */
        .comp-grid { margin-top: 60px; display: flex; flex-direction: column; gap: 16px; }
        .comp-row { display: grid; grid-template-columns: 1fr 1fr 1fr; align-items: center; background: #fff; border-radius: 20px; padding: 22px 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1.5px solid #f0f0f0; transition: 0.3s; }
        .comp-row:hover { border-color: var(--primary-soft); box-shadow: 0 8px 30px rgba(106,55,183,0.08); }
        .comp-row.header-row { background: var(--primary); border-color: var(--primary); border-radius: 20px; padding: 18px 30px; }
        .comp-row.header-row span { color: #fff; font-weight: 800; font-size: 1rem; text-align: center; }
        .comp-row.header-row .comp-feature { color: rgba(255,255,255,0.7); font-size: 0.85rem; }
        .comp-feature { font-weight: 700; color: var(--text-dark); font-size: 1rem; }
        .comp-old { text-align: center; }
        .comp-new { text-align: center; }
        .comp-check { color: #22c55e; font-size: 1.4rem; }
        .comp-x { color: #ef4444; font-size: 1.4rem; }
        .badge-no { display: inline-block; background: #fff5f5; color: #ef4444; border-radius: 8px; padding: 6px 14px; font-weight: 700; font-size: 0.85rem; }
        .badge-yes { display: inline-block; background: #f0fdf4; color: #16a34a; border-radius: 8px; padding: 6px 14px; font-weight: 700; font-size: 0.85rem; }

        /* CALCULADORA ROI V85 */
        .section-roi { padding: 100px 10%; background: #fff; text-align: center; }
        .roi-card { 
            max-width: 900px; margin: 60px auto; background: var(--bg-off); 
            border-radius: 40px; padding: 60px; display: grid; grid-template-columns: 1fr 1fr; gap: 60px;
            text-align: left; border: 1px solid #eee; box-shadow: 0 40px 80px rgba(0,0,0,0.03);
        }
        .roi-inputs { display: flex; flex-direction: column; gap: 30px; }
        .roi-control { display: flex; flex-direction: column; gap: 10px; }
        .roi-control label { font-weight: 700; color: var(--text-dark); display: flex; justify-content: space-between; }
        .roi-control label span { color: var(--primary); font-weight: 900; }
        
        .roi-slider { 
            -webkit-appearance: none; width: 100%; height: 6px; border-radius: 5px; 
            background: #e0e0e0; outline: none; transition: 0.3s; 
        }
        .roi-slider::-webkit-slider-thumb { 
            -webkit-appearance: none; width: 24px; height: 24px; border-radius: 50%; 
            background: var(--primary); cursor: pointer; border: 4px solid #fff; 
            box-shadow: 0 4px 10px rgba(106,55,183,0.3);
        }

        .roi-results { 
            background: var(--primary); border-radius: 30px; padding: 40px; color: #fff; 
            display: flex; flex-direction: column; justify-content: center; gap: 25px;
            box-shadow: 0 20px 40px rgba(106,55,183,0.2);
        }
        .res-item { border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; }
        .res-item:last-child { border: none; }
        .res-val { font-size: 2.2rem; font-weight: 900; display: block; font-family: 'Outfit'; }
        .res-lab { font-size: 0.9rem; opacity: 0.8; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        .res-total { background: rgba(255,255,255,0.1); padding: 20px; border-radius: 20px; text-align: center; }

        @media (max-width: 1024px) {
            .trust-bar { gap: 30px; padding: 30px 5%; }
            .mockup-section { grid-template-columns: 1fr; text-align: center; padding: 80px 8%; gap: 40px; }
            .mockup-img img { transform: none; }
            .grid-steps { grid-template-columns: 1fr; gap: 40px; }
            .comp-row { grid-template-columns: 1fr 80px 80px; padding: 16px 20px; border-radius: 16px; }
            .comp-feature { font-size: 0.9rem; }
            .badge-no, .badge-yes { padding: 5px 10px; font-size: 0.78rem; }
            .comp-row.header-row { padding: 14px 20px; }
            
            /* ROI Mobile Fix V88 */
            .section-roi { padding: 80px 5%; }
            .roi-card { grid-template-columns: 1fr; padding: 30px 20px; gap: 30px; border-radius: 30px; }
            .roi-control label { font-size: 1rem !important; flex-direction: column; align-items: flex-start; gap: 5px; }
            .roi-control label span { font-size: 1.2rem !important; }
            .res-val { font-size: 1.8rem !important; }
            #resAnnual { font-size: 2.2rem !important; }
            .roi-results { padding: 30px 20px; }

            /* Fix V91: Testimonios y Libertad Mobile */
            .mockup-section h2 { font-size: 2.5rem !important; text-align: center; }
            .mockup-text { text-align: center !important; }
            .mockup-img img { max-width: 90% !important; margin: 0 auto; display: block; }
            .grid-poder .card-poder i.fa-star { font-size: 12px !important; }
            .grid-poder .card-poder p { font-size: 0.95rem; text-align: center; }
        }

        /* ESTRELLAS ÉPICAS V93 */
        .star-epic {
            color: #FFC107 !important;
            text-shadow: 0 0 8px rgba(255, 193, 7, 0.8);
            animation: starPulse 2.5s infinite ease-in-out;
            display: inline-block;
            font-size: 12px !important;
        }

        @keyframes starPulse {
            0% { transform: scale(1); filter: brightness(1); }
            50% { transform: scale(1.15); filter: brightness(1.4); text-shadow: 0 0 20px rgba(255, 193, 7, 1); }
            100% { transform: scale(1); filter: brightness(1); }
        }
    </style>
</head>
<body>

    <div id="preloader">
        <div class="pre-content">
            <img src="assets/img/logo.png" class="pre-logo">
            <div class="load-bar-wrap">
                <div class="load-bar-fill" id="loadFill"></div>
            </div>
        </div>
    </div>

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
                        <p id="heroSubtitle" class="typing-cursor" data-text="La tecnología Élite que las grandes cadenas no quieren que tengas. Gestión inteligente y ventas ultra-rápidas para tu Pyme."></p>
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

    <!-- TRUST BAR V77 -->
    <div class="trust-bar reveal-section">
        <img src="assets/img/logo.png" alt="Trusted" style="opacity: 0.8; filter: none;">
        <span style="font-weight: 800; color: var(--text-light); letter-spacing: 2px;">TECNOLOGÍA RESPALDADA POR EXPERTOS</span>
        <img src="assets/img/logo.png" alt="Trusted" style="opacity: 0.8; filter: none; transform: scale(0.8);">
    </div>

    <!-- MOCKUP PRODUCT VISUALIZATION V77 -->
    <section class="mockup-section reveal-section">
        <div class="mockup-img reveal">
            <div class="mockup-badge">APP ÉLITE</div>
            <img src="assets/img/mockup_elite.png" alt="CajaYa POS Interface">
        </div>
        <div class="mockup-text reveal">
            <h2 style="font-size: 3.5rem; font-weight: 900; line-height: 1; margin-bottom: 30px;">Una Interfaz diseñada para la <span>Velocidad.</span></h2>
            <p style="font-size: 1.2rem; color: var(--text-light); margin-bottom: 40px;">No pierdas tiempo con sistemas complicados. CajaYa es tan intuitivo que tu personal estará vendiendo en menos de 5 minutos. Grillas inteligentes, búsqueda instantánea y ticket digital.</p>
            <ul class="p-features" style="column-count: 2; gap: 40px;">
                <li><i class="fa-solid fa-check"></i> Interfaz Touch</li>
                <li><i class="fa-solid fa-check"></i> Venta en 1-Clic</li>
                <li><i class="fa-solid fa-check"></i> Integración SII</li>
                <li><i class="fa-solid fa-check"></i> Inventario Real</li>
            </ul>
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

    <!-- CALCULADORA ROI V90 (MOVIDA PARA IMPACTO TEMPRANO) -->
    <section class="section-roi reveal-section">
        <div class="header-elite">
            <h2>Simulador de <span>Ganancias.</span></h2>
            <p style="color: var(--text-light); margin-top: 20px;">Sigue estos 2 simples pasos para ver cuánto estás perdiendo hoy:</p>
        </div>
        
        <div class="roi-card reveal">
            <div class="roi-inputs">
                <div class="roi-control">
                    <label style="font-size:1.2rem;">
                        <span style="background:var(--primary); color:#fff; width:28px; height:28px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; margin-right:10px; font-size:14px;">1</span>
                        ¿Cuánto vendes al mes?
                        <span id="valSales" style="font-size:1.4rem;">$10.000.000</span>
                    </label>
                    <p style="font-size:0.85rem; color:var(--text-light); margin-bottom:10px;">Desliza para ajustar tu nivel de ventas actual.</p>
                    <input type="range" class="roi-slider" id="inputSales" min="100000" max="50000000" step="100000" value="10000000">
                </div>

                <div class="roi-control" style="margin-top:20px;">
                    <label style="font-size:1.2rem;">
                        <span style="background:var(--primary); color:#fff; width:28px; height:28px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; margin-right:10px; font-size:14px;">2</span>
                        ¿Horas perdidas al día?
                        <span id="valTime" style="font-size:1.4rem;">4 Horas</span>
                    </label>
                    <p style="font-size:0.85rem; color:var(--text-light); margin-bottom:10px;">Tiempo que gastas hoy contando stock o haciendo cuentas a mano.</p>
                    <input type="range" class="roi-slider" id="inputTime" min="1" max="12" step="1" value="4">
                </div>

                <div style="margin-top:30px; background:#fff; padding:25px; border-radius:24px; border:1px solid #f0f0f0; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                    <h4 style="color:var(--primary); margin-bottom:15px; font-size:1.1rem;"><i class="fa-solid fa-triangle-exclamation"></i> El Costo del Desorden</h4>
                    <ul style="list-style:none; font-size:0.85rem; color:var(--text-light); line-height:1.6; display:flex; flex-direction:column; gap:10px;">
                        <li><i class="fa-solid fa-check" style="color:var(--primary); margin-right:8px;"></i> <strong>Fugas de Caja:</strong> Errores en vueltos y redondeos.</li>
                        <li><i class="fa-solid fa-check" style="color:var(--primary); margin-right:8px;"></i> <strong>Mermas Ciegas:</strong> Productos que vencen sin control.</li>
                        <li><i class="fa-solid fa-check" style="color:var(--primary); margin-right:8px;"></i> <strong>Tranquilidad SII:</strong> Emisión automática, cero multas.</li>
                    </ul>
                </div>
            </div>
            
            <div class="roi-results">
                <div style="text-align:center; margin-bottom:20px;">
                    <i class="fa-solid fa-chart-line" style="font-size:3rem; margin-bottom:15px; opacity:0.8;"></i>
                    <h3 style="font-family:'Outfit';">Tu Resultado Élite</h3>
                </div>
                <div class="res-item">
                    <span class="res-lab">Dinero recuperado (Mensual)</span>
                    <span class="res-val" id="resMonthly">$300.000</span>
                </div>
                <div class="res-item">
                    <span class="res-lab">Tiempo de vida recuperado</span>
                    <span class="res-val" id="resTime">96 Horas</span>
                </div>
                <div class="res-total">
                    <span class="res-lab">GANANCIA TOTAL AL AÑO</span>
                    <span class="res-val" id="resAnnual" style="color:#FFD700; font-size:2.8rem;">$3.600.000</span>
                </div>
                <a href="#planes" class="btn-white" style="width:100%; text-align:center; text-decoration:none; margin-top:10px;">Quiero Ganar Esto con CajaYa</a>
            </div>
        </div>
    </section>

    <!-- SECCIÓN POTENCIA ÉLITE V95 -->
    <section class="mockup-section reveal-section" style="background: #fff; padding: 100px 10%;">
        <div class="mockup-text reveal">
            <h2 style="font-size: 3.5rem; font-weight: 900; line-height: 1; margin-bottom: 30px;">El Corazón de tu <span>Mostrador.</span></h2>
            <p style="font-size: 1.2rem; color: var(--text-light); margin-bottom: 40px;">CajaYa no es solo un software; es el socio que nunca descansa. Convierte tu computadora en una terminal de venta de clase mundial. Velocidad de respuesta instantánea, control de inventario en tiempo real y la robustez que tu negocio merece.</p>
            <div style="background: var(--primary-soft); padding: 30px; border-radius: 24px; border-left: 5px solid var(--primary);">
                <p style="font-weight: 700; color: var(--primary); font-size: 1.1rem; margin-bottom: 5px;">"La rapidez en el mostrador es clave"</p>
                <p style="font-size: 0.95rem; color: var(--text-light);">— Ricardo M., Dueño de Minimarket El Trébol.</p>
            </div>
        </div>
        <div class="mockup-img reveal" style="position: relative;">
            <!-- Imagen de local real con overlay de App -->
            <img src="https://images.unsplash.com/photo-1556740734-7f96267b118a?auto=format&fit=crop&q=80&w=1000" alt="Local Real CajaYa" style="border-radius: 40px; box-shadow: 0 40px 80px rgba(0,0,0,0.2); width: 100%; filter: brightness(0.9);">
            
            <!-- Floating UI Overlay -->
            <div style="position: absolute; top: 10%; right: -5%; background: rgba(255,255,255,0.9); backdrop-filter: blur(10px); padding: 20px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); border: 1px solid rgba(106, 55, 183, 0.2); max-width: 250px;">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
                    <div style="width:10px; height:10px; background:#4CAF50; border-radius:50%;"></div>
                    <span style="font-size:0.8rem; font-weight:900; color:var(--primary);">SISTEMA ACTIVO</span>
                </div>
                <p style="font-size:0.9rem; font-weight:700; margin-bottom:5px;">Venta Total Hoy</p>
                <p style="font-size:1.5rem; font-weight:900; color:var(--primary);">$415.790</p>
                <div style="margin-top:15px; height:4px; background:#eee; border-radius:2px; overflow:hidden;">
                    <div style="width:75%; height:100%; background:var(--primary);"></div>
                </div>
                <p style="font-size:0.7rem; color:var(--text-light); margin-top:5px;">Meta diaria: 75% alcanzado</p>
            </div>
        </div>
    </section>

    <!-- PROCESS STEPS V77 -->
    <section class="section-steps reveal-section">
        <div class="header-elite">
            <h2>Empieza en <span>3 Pasos.</span></h2>
            <p style="color: var(--text-light); margin-top: 20px;">Del registro a tu primera venta en tiempo récord.</p>
        </div>
        <div class="grid-steps">
            <!-- Paso 1: SVG replica el modal REAL de CajaYa -->
            <div class="step-card reveal">
                <div class="step-ui" style="background:#1a1a2e;">
                    <svg viewBox="0 0 280 190" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                        <!-- Fondo oscuro tipo overlay -->
                        <rect width="280" height="190" fill="#1a1a2e" opacity="0.95"/>
                        <!-- Card blanca principal -->
                        <rect x="20" y="14" width="240" height="162" rx="14" fill="white" filter="url(#shadow)"/>
                        <defs><filter id="shadow"><feDropShadow dx="0" dy="4" stdDeviation="6" flood-opacity="0.25"/></filter></defs>
                        <!-- X cerrar -->
                        <text x="248" y="30" font-size="10" fill="#999" font-family="Arial">×</text>
                        <!-- Título -->
                        <text x="140" y="44" font-size="12" fill="#6A37B7" text-anchor="middle" font-family="Arial" font-weight="bold">¡Casi es tuyo!</text>
                        <text x="140" y="56" font-size="7" fill="#888" text-anchor="middle" font-family="Arial">Estás adquiriendo el Plan Lifetime.</text>
                        <!-- Botón Google pill -->
                        <rect x="50" y="62" width="180" height="22" rx="11" fill="#4285F4"/>
                        <circle cx="64" cy="73" r="8" fill="white"/>
                        <text x="64" y="77" font-size="9" fill="#4285F4" text-anchor="middle" font-family="Arial" font-weight="bold">R</text>
                        <text x="155" y="77" font-size="8" fill="white" text-anchor="middle" font-family="Arial" font-weight="bold">Continue as Reinaldo ✓</text>
                        <!-- Divider -->
                        <line x1="30" y1="92" x2="120" y2="92" stroke="#eee" stroke-width="1"/>
                        <text x="140" y="96" font-size="7" fill="#bbb" text-anchor="middle" font-family="Arial">O USA TU CORREO</text>
                        <line x1="160" y1="92" x2="250" y2="92" stroke="#eee" stroke-width="1"/>
                        <!-- Campo nombre -->
                        <rect x="30" y="100" width="220" height="17" rx="6" fill="white" stroke="#6A37B7" stroke-width="1.2"/>
                        <text x="42" y="112" font-size="8" fill="#555" font-family="Arial">👤 Nombre completo</text>
                        <!-- Campo email -->
                        <rect x="30" y="121" width="220" height="17" rx="6" fill="white" stroke="#ddd" stroke-width="1"/>
                        <text x="42" y="133" font-size="8" fill="#aaa" font-family="Arial">✉️ correo@gmail.com</text>
                        <!-- Campo whatsapp -->
                        <rect x="30" y="142" width="220" height="17" rx="6" fill="white" stroke="#ddd" stroke-width="1"/>
                        <text x="42" y="154" font-size="8" fill="#aaa" font-family="Arial">📱 +569...</text>
                        <!-- Botón Proceder -->
                        <rect x="30" y="163" width="220" height="8" rx="4" fill="#6A37B7"/>
                        <text x="140" y="170" font-size="6" fill="white" text-anchor="middle" font-family="Arial" font-weight="bold">PROCEDER AL PAGO</text>
                    </svg>
                </div>
                <div class="step-num">1</div>
                <h3>Regístrate</h3>
                <p>Crea tu cuenta en segundos con tu correo o Google. Sin tarjeta, sin burocracia.</p>
            </div>
            <!-- Paso 2: SVG simula grilla de productos CajaYa -->
            <div class="step-card reveal">
                <div class="step-ui">
                    <svg viewBox="0 0 280 190" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                        <rect width="280" height="190" fill="#f8f4ff"/>
                        <rect x="0" y="0" width="280" height="32" fill="#6A37B7"/>
                        <text x="14" y="21" font-size="11" fill="white" font-family="Arial" font-weight="bold">CajaYa — Inventario</text>
                        <text x="200" y="21" font-size="9" fill="white" font-family="Arial">7.000+ items</text>
                        <!-- Grilla 3x2 de productos -->
                        <rect x="14" y="40" width="74" height="60" rx="8" fill="white" stroke="#ede5ff" stroke-width="1.5"/>
                        <rect x="96" y="40" width="74" height="60" rx="8" fill="white" stroke="#ede5ff" stroke-width="1.5"/>
                        <rect x="178" y="40" width="74" height="60" rx="8" fill="white" stroke="#ede5ff" stroke-width="1.5"/>
                        <rect x="14" y="108" width="74" height="60" rx="8" fill="white" stroke="#ede5ff" stroke-width="1.5"/>
                        <rect x="96" y="108" width="74" height="60" rx="8" fill="white" stroke="#ede5ff" stroke-width="1.5"/>
                        <rect x="178" y="108" width="74" height="60" rx="8" fill="#6A37B7"/>
                        <!-- Texto productos -->
                        <text x="51" y="67" font-size="18" text-anchor="middle" font-family="Arial">🥛</text>
                        <text x="133" y="67" font-size="18" text-anchor="middle" font-family="Arial">🍞</text>
                        <text x="215" y="67" font-size="18" text-anchor="middle" font-family="Arial">🥩</text>
                        <text x="51" y="135" font-size="18" text-anchor="middle" font-family="Arial">🥤</text>
                        <text x="133" y="135" font-size="18" text-anchor="middle" font-family="Arial">🍫</text>
                        <text x="215" y="135" font-size="12" fill="white" text-anchor="middle" font-family="Arial" font-weight="bold">+</text>
                        <text x="51" y="82" font-size="7" fill="#6A37B7" text-anchor="middle" font-family="Arial" font-weight="bold">$890</text>
                        <text x="133" y="82" font-size="7" fill="#6A37B7" text-anchor="middle" font-family="Arial" font-weight="bold">$1.200</text>
                        <text x="215" y="82" font-size="7" fill="#6A37B7" text-anchor="middle" font-family="Arial" font-weight="bold">$4.500</text>
                    </svg>
                </div>
                <div class="step-num">2</div>
                <h3>Carga Stock</h3>
                <p>Usa nuestra base de 7.000 productos o importa los tuyos desde Excel en minutos.</p>
            </div>
            <!-- Paso 3: SVG simula pantalla de venta/boleta CajaYa -->
            <div class="step-card reveal">
                <div class="step-ui">
                    <svg viewBox="0 0 280 190" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                        <rect width="280" height="190" fill="#f8f4ff"/>
                        <rect x="0" y="0" width="280" height="32" fill="#6A37B7"/>
                        <text x="14" y="21" font-size="11" fill="white" font-family="Arial" font-weight="bold">CajaYa — Boleta #00842</text>
                        <!-- Ticket de venta -->
                        <rect x="14" y="40" width="252" height="105" rx="10" fill="white" stroke="#ede5ff" stroke-width="1.5"/>
                        <line x1="14" y1="60" x2="266" y2="60" stroke="#f0f0f0" stroke-width="1"/>
                        <text x="22" y="55" font-size="8" fill="#999" font-family="Arial">Producto</text>
                        <text x="200" y="55" font-size="8" fill="#999" font-family="Arial">Total</text>
                        <text x="22" y="75" font-size="9" fill="#333" font-family="Arial">Leche Loncoleche 1L</text>
                        <text x="220" y="75" font-size="9" fill="#333" font-family="Arial">$890</text>
                        <text x="22" y="91" font-size="9" fill="#333" font-family="Arial">Pan Marraqueta x2</text>
                        <text x="220" y="91" font-size="9" fill="#333" font-family="Arial">$600</text>
                        <text x="22" y="107" font-size="9" fill="#333" font-family="Arial">Coca-Cola 1.5L</text>
                        <text x="220" y="107" font-size="9" fill="#333" font-family="Arial">$1.490</text>
                        <line x1="14" y1="118" x2="266" y2="118" stroke="#ede5ff" stroke-width="1.5"/>
                        <text x="22" y="133" font-size="10" fill="#6A37B7" font-family="Arial" font-weight="bold">TOTAL</text>
                        <text x="195" y="133" font-size="11" fill="#6A37B7" font-family="Arial" font-weight="bold">$2.980</text>
                        <!-- Botón cobrar -->
                        <rect x="14" y="153" width="252" height="26" rx="8" fill="#22c55e"/>
                        <text x="140" y="170" font-size="11" fill="white" text-anchor="middle" font-family="Arial" font-weight="bold">✓ Cobrar $2.980</text>
                    </svg>
                </div>
                <div class="step-num">3</div>
                <h3>¡A Vender!</h3>
                <p>Cobra en un clic. Boleta electrónica SII integrada. Rápido como los grandes.</p>
            </div>
        </div>
    </section>

    </div>

    <!-- COMPARISON TABLE V77 -->
    <section class="reveal-section" style="padding: 100px 10%; text-align: center; background: #fff;">
        <div class="header-elite">
            <h2>Por qué elegir <span>CajaYa.</span></h2>
            <p style="color: var(--text-light); margin-top: 20px;">La diferencia entre sobrevivir y dominar el mercado.</p>
        </div>
        <div class="comp-grid reveal">
            <!-- Header -->
            <div class="comp-row header-row">
                <span class="comp-feature">Característica</span>
                <span style="text-align:center;">Sistemas Viejos</span>
                <span style="text-align:center;">CajaYa Élite</span>
            </div>
            <!-- Filas -->
            <div class="comp-row">
                <span class="comp-feature"><i class="fa-solid fa-wifi-slash" style="color:var(--primary);margin-right:8px;"></i>Modo Offline Real</span>
                <div class="comp-old"><span class="badge-no">✗ No tiene</span></div>
                <div class="comp-new"><span class="badge-yes">✓ Incluido</span></div>
            </div>
            <div class="comp-row">
                <span class="comp-feature"><i class="fa-solid fa-boxes-stacked" style="color:var(--primary);margin-right:8px;"></i>Catálogo 7k Productos</span>
                <div class="comp-old"><span class="badge-no">✗ No tiene</span></div>
                <div class="comp-new"><span class="badge-yes">✓ Incluido</span></div>
            </div>
            <div class="comp-row">
                <span class="comp-feature"><i class="fa-solid fa-headset" style="color:var(--primary);margin-right:8px;"></i>Soporte WhatsApp VIP</span>
                <div class="comp-old"><span class="badge-no">✗ No tiene</span></div>
                <div class="comp-new"><span class="badge-yes">✓ Incluido</span></div>
            </div>
            <div class="comp-row">
                <span class="comp-feature"><i class="fa-solid fa-file-invoice" style="color:var(--primary);margin-right:8px;"></i>Integración SII</span>
                <div class="comp-old"><span class="badge-no">✗ No tiene</span></div>
                <div class="comp-new"><span class="badge-yes">✓ Incluido</span></div>
            </div>
            <div class="comp-row">
                <span class="comp-feature"><i class="fa-solid fa-rotate" style="color:var(--primary);margin-right:8px;"></i>Actualizaciones Gratis</span>
                <div class="comp-old"><span class="badge-no">✗ No tiene</span></div>
                <div class="comp-new"><span class="badge-yes">✓ Incluido</span></div>
            </div>
        </div>
    </section>
    
    <!-- CTA RAPIDO V77 -->
    <div class="ribbon-cta reveal">
        <div class="ribbon-text">
            <h3>Prueba la potencia de CajaYa hoy mismo.</h3>
            <p>Captura la eficiencia de un sistema de clase mundial en tu negocio.</p>
        </div>
        <button onclick="openModal()" class="btn-white">Obtener Demo Gratis</button>
    </div>

    <!-- TESTIMONIOS ÉLITE V94 -->
    <section class="reveal-section" style="padding: 100px 10%; background: var(--bg-off); text-align: center;">
        <div class="header-elite">
            <h2>Negocios que ya son <span>Élite.</span></h2>
            <p style="color: var(--text-light); margin-top: 20px;">Únete a cientos de dueños que recuperaron el control.</p>
        </div>
        <div class="grid-poder" style="margin-top: 60px;">
            <div class="card-poder reveal">
                <div style="display:flex; margin-bottom:15px; justify-content:center; gap:8px;">
                    <i class="fa-solid fa-star star-epic"></i>
                    <i class="fa-solid fa-star star-epic"></i>
                    <i class="fa-solid fa-star star-epic"></i>
                    <i class="fa-solid fa-star star-epic"></i>
                    <i class="fa-solid fa-star star-epic"></i>
                </div>
                <p style="font-style:italic; margin-bottom:20px; line-height:1.4;">"Antes pasaba 3 horas cuadrando caja. Hoy lo hago en 1 minuto desde mi celular."</p>
                <h4 style="font-weight:900;">Juan P.</h4>
                <small style="color:var(--primary); font-weight:700;">Botillería Santa Elena</small>
            </div>
            <div class="card-poder reveal">
                <div style="display:flex; margin-bottom:15px; justify-content:center; gap:8px;">
                    <i class="fa-solid fa-star star-epic"></i>
                    <i class="fa-solid fa-star star-epic"></i>
                    <i class="fa-solid fa-star star-epic"></i>
                    <i class="fa-solid fa-star star-epic"></i>
                    <i class="fa-solid fa-star star-epic"></i>
                </div>
                <p style="font-style:italic; margin-bottom:20px; line-height:1.4;">"El SII ya no es un dolor de cabeza. Todo automático y sin multas."</p>
                <h4 style="font-weight:900;">María L.</h4>
                <small style="color:var(--primary); font-weight:700;">Almacén El Sol</small>
            </div>
            <div class="card-poder reveal">
                <div style="display:flex; margin-bottom:15px; justify-content:center; gap:8px;">
                    <i class="fa-solid fa-star star-epic"></i>
                    <i class="fa-solid fa-star star-epic"></i>
                    <i class="fa-solid fa-star star-epic"></i>
                    <i class="fa-solid fa-star star-epic"></i>
                    <i class="fa-solid fa-star star-epic"></i>
                </div>
                <p style="font-style:italic; margin-bottom:20px; line-height:1.4;">"El soporte por WhatsApp es increíble. Siempre responden en minutos."</p>
                <h4 style="font-weight:900;">Carlos R.</h4>
                <small style="color:var(--primary); font-weight:700;">Ferretería Central</small>
            </div>
        </div>
    </section>

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
                            $pText = htmlspecialchars(trim($point));
                            // Soporte para Negritas Élite (V96)
                            $pText = preg_replace('/\*\*(.*?)\*\*/', '<strong style="color:var(--text-dark);">$1</strong>', $pText);
                    ?>
                        <li><i class="fa-solid fa-check"></i> <?php echo $pText; ?></li>
                    <?php endforeach; ?>
                </ul>

                <button onclick="startPurchase('<?php echo $slug; ?>', '<?php echo htmlspecialchars($p['name']); ?>', <?php echo $p['price']; ?>)" class="btn-cta" style="border:none; cursor:pointer;">
                    <?php echo $isEnterprise ? 'Consultar Ventas' : ($isFeatured ? 'Comprar Vitalicia' : 'Elegir Plan'); ?>
                </button>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- ALERTA SII ÉLITE V96 -->
        <div class="reveal-section" style="max-width: 800px; margin: 60px auto 0; padding: 25px 40px; background: rgba(106, 55, 183, 0.05); border: 2px dashed var(--primary); border-radius: 25px; display: flex; align-items: center; gap: 20px; justify-content: center;">
            <i class="fa-solid fa-circle-info" style="font-size: 2rem; color: var(--primary);"></i>
            <p style="font-weight: 700; color: var(--text-dark); margin: 0;">Contamos con integración a SII, se requiere contar con internet.</p>
        </div>
    </section>

    <section class="section-faq reveal-section">
        <h2>Dudas <span>Frecuentes.</span></h2>
        <div class="faq-container">
            <div class="faq-item"><h4><span>¿Cómo instalo el catálogo?</span><i class="fa-solid fa-plus"></i></h4><div class="faq-body"><p>Ya viene integrado con más de 7.000 productos precargados.</p></div></div>
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
        window.addEventListener('DOMContentLoaded', () => {
            const fill = document.getElementById('loadFill');
            if(fill) setTimeout(() => fill.style.width = '100%', 100);
        });

        function updateROI() {
            const sales = parseInt(document.getElementById('inputSales').value);
            const time = parseInt(document.getElementById('inputTime').value);
            
            // UI Labels
            document.getElementById('valSales').innerText = '$' + sales.toLocaleString('es-CL');
            document.getElementById('valTime').innerText = time + (time === 1 ? ' Hora' : ' Horas');
            
            // Cálculos
            const monthlySavings = sales * 0.03; // 3% ahorro fugas/errores
            const hoursRecovered = (time * 0.8) * 30; // 80% eficiencia * 30 días
            const annualGain = monthlySavings * 12;
            
            // Results UI
            document.getElementById('resMonthly').innerText = '$' + Math.round(monthlySavings).toLocaleString('es-CL');
            document.getElementById('resTime').innerText = Math.round(hoursRecovered) + ' Horas';
            document.getElementById('resAnnual').innerText = '$' + Math.round(annualGain).toLocaleString('es-CL');
        }

        document.getElementById('inputSales').addEventListener('input', updateROI);
        document.getElementById('inputTime').addEventListener('input', updateROI);

        window.addEventListener('load', () => {
            setTimeout(() => {
                const preloader = document.getElementById('preloader');
                if(preloader) {
                    preloader.style.opacity = '0';
                    setTimeout(() => { 
                        preloader.style.display = 'none'; 
                        startTypewriter();
                    }, 600);
                }
            }, 2200); // Tiempo justo para que la barra se vea llenar
        });

        function startTypewriter() {
            const el = document.getElementById('heroSubtitle');
            if(!el) return;
            const text = el.getAttribute('data-text');
            if(!text) return;
            let i = 0;
            el.innerHTML = '';
            
            function type() {
                if (i < text.length) {
                    el.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, 35); // Velocidad Élite
                }
            }
            type();
        }
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

    <!-- BOTÓN FLOTANTE WHATSAPP V82 -->
    <a href="https://wa.me/56900000000?text=Hola%2C%20quiero%20info%20sobre%20CajaYa" 
       target="_blank" 
       id="wa-float"
       aria-label="Contactar por WhatsApp"
       title="Chatea con nosotros">
        <i class="fa-brands fa-whatsapp"></i>
        <span class="wa-tooltip">Escríbenos ahora</span>
    </a>
    <style>
        #wa-float {
            position: fixed; bottom: 30px; right: 30px; z-index: 9999;
            width: 62px; height: 62px; background: #25D366;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 30px; color: white; text-decoration: none;
            box-shadow: 0 6px 24px rgba(37,211,102,0.45);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: waPulse 2.5s infinite;
        }
        #wa-float:hover { transform: scale(1.12); box-shadow: 0 10px 35px rgba(37,211,102,0.55); animation: none; }
        .wa-tooltip {
            position: absolute; right: 74px; background: #1a1a1a; color: #fff;
            padding: 8px 14px; border-radius: 10px; font-size: 13px; font-weight: 600;
            white-space: nowrap; opacity: 0; pointer-events: none;
            transition: opacity 0.3s ease; font-family: 'Inter', sans-serif;
        }
        #wa-float:hover .wa-tooltip { opacity: 1; }
        @keyframes waPulse {
            0%   { box-shadow: 0 0 0 0 rgba(37,211,102,0.5); }
            70%  { box-shadow: 0 0 0 14px rgba(37,211,102,0); }
            100% { box-shadow: 0 0 0 0 rgba(37,211,102,0); }
        }
        @media (max-width: 768px) {
            #wa-float { bottom: 20px; right: 20px; width: 54px; height: 54px; font-size: 26px; }
            .wa-tooltip { display: none; }
        }
    </style>

</body>
</html>
