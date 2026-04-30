<?php
/**
 * index.php — Landing Page CAJAYA ELITE V23 (THE LUXURY BALANCE)
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
    <title>CajaYa Elite — El Software para tu Negocio</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;700;900&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6A37B7;
            --primary-dark: #321958;
            --primary-glow: #9D6CFF;
            --primary-soft: #F4F0FF;
            --text-dark: #121214;
            --text-light: #52525B;
            --bg-white: #FFFFFF;
            --bg-off: #F8FAFC;
            --transition-elite: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-font-smoothing: antialiased; scroll-behavior: smooth; }
        body { background: var(--bg-white); color: var(--text-dark); font-family: 'Inter', sans-serif; overflow-x: hidden; }

        /* PRELOADER */
        #preloader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: #fff; display: flex; align-items: center; justify-content: center;
            z-index: 10000; transition: opacity 0.8s ease-out;
        }
        .pre-logo { width: 120px; animation: pulse 1.5s infinite ease-in-out; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.6; } 50% { transform: scale(1.05); opacity: 1; } }

        /* NAV */
        nav { 
            position: fixed; top: 0; width: 100%; height: 90px; z-index: 1000;
            display: flex; justify-content: space-between; align-items: center; padding: 0 8%;
            transition: var(--transition-elite);
        }
        nav.scrolled { background: rgba(255,255,255,0.9); backdrop-filter: blur(20px); height: 75px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); }
        .nav-logo img { height: 40px; }
        .nav-links a { color: var(--text-dark); text-decoration: none; font-weight: 700; font-size: 14px; margin-left: 40px; transition: 0.3s; }
        .btn-wa { background: #22C55E; color: #fff !important; padding: 12px 28px; border-radius: 50px; font-weight: 800; box-shadow: 0 10px 25px rgba(34,197,94,0.3); }

        /* HERO CAROUSEL LUXURY */
        .hero-carousel { position: relative; height: 100vh; overflow: hidden; background: #fff; }
        .carousel-track { display: flex; height: 100%; transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
        .slide { min-width: 100%; height: 100%; position: relative; display: flex; align-items: center; justify-content: flex-start; padding: 0 10%; }
        
        .slide-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1; transform: scale(1.02); }
        .slide-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0.85) 45%, transparent 100%); z-index: 2; }

        .hero-content { position: relative; z-index: 10; max-width: 800px; }
        .hero-content h1 { font-family: 'Outfit', sans-serif; font-size: clamp(3.5rem, 8vw, 6rem); line-height: 0.85; font-weight: 900; margin-bottom: 35px; letter-spacing: -5px; color: var(--text-dark); }
        .hero-content h1 span { color: var(--primary); }
        .hero-content p { font-size: 1.6rem; color: var(--text-light); margin-bottom: 50px; border-left: 8px solid var(--primary); padding-left: 35px; max-width: 650px; line-height: 1.4; }
        
        /* THE FORM - PEARL LUXURY */
        .pearl-form { 
            background: rgba(255,255,255,0.92); backdrop-filter: blur(25px);
            padding: 55px; border-radius: 45px; border: 1px solid #fff;
            box-shadow: 0 40px 100px rgba(0,0,0,0.08);
            width: 100%; max-width: 550px; text-align: center;
        }
        .pearl-form h2 { font-family: 'Outfit', sans-serif; font-size: 3rem; margin-bottom: 15px; color: var(--text-dark); letter-spacing: -2px; }
        .pearl-form h2 span { color: var(--primary); }
        .pearl-form p { color: var(--text-light); font-size: 1.2rem; margin-bottom: 40px; }
        
        .form-grid { display: grid; grid-template-columns: 1fr; gap: 20px; }
        .input-wrap { position: relative; }
        .input-wrap i { position: absolute; left: 25px; top: 50%; transform: translateY(-50%); color: var(--primary); opacity: 0.6; font-size: 18px; }
        .form-input { 
            width: 100%; padding: 22px 25px 22px 65px; border-radius: 22px; border: 1px solid rgba(0,0,0,0.05); 
            background: #fff; color: var(--text-dark); font-size: 16px; transition: 0.3s;
        }
        .form-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 30px rgba(106,55,183,0.1); }
        .btn-luxury { 
            background: var(--primary); color: #fff; border: none; padding: 25px; 
            border-radius: 22px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px;
            cursor: pointer; transition: 0.5s; box-shadow: 0 15px 40px rgba(106,55,183,0.3);
        }
        .btn-luxury:hover { transform: scale(1.02); background: var(--primary-dark); }

        /* PODER CAJAYA - HIGH CONTRAST */
        .section-poder { background: #fff; padding: 150px 10%; text-align: center; }
        .header-elite h2 { font-family: 'Outfit', sans-serif; font-size: 4.5rem; letter-spacing: -3px; font-weight: 900; }
        .header-elite h2 span { color: var(--primary); }
        .grid-poder { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; margin-top: 80px; }
        .card-poder { 
            padding: 60px 45px; border-radius: 45px; background: var(--bg-off); 
            transition: var(--transition-elite); border: 2px solid transparent; text-align: center;
        }
        .card-poder:hover { 
            transform: translateY(-20px) scale(1.03); 
            background: #fff; border-color: var(--primary-soft);
            box-shadow: 0 50px 100px rgba(106,55,183,0.08);
        }
        .card-poder i { font-size: 60px; color: var(--primary); margin-bottom: 35px; }
        .card-poder h3 { font-size: 2rem; font-weight: 900; margin-bottom: 20px; color: var(--text-dark); }
        .card-poder p { font-size: 1.1rem; color: var(--text-light); line-height: 1.6; }

        /* PLANES - ANIMATED */
        .section-planes { padding: 150px 8%; background: var(--bg-off); }
        .p-card { 
            background: #fff; padding: 85px 55px; border-radius: 50px; flex: 1; min-width: 360px; max-width: 460px;
            position: relative; transition: var(--transition-elite); box-shadow: 0 10px 40px rgba(0,0,0,0.01);
        }
        .p-card:hover { transform: translateY(-20px) scale(1.02); box-shadow: 0 60px 120px rgba(0,0,0,0.06); }
        .p-card.elite { 
            border: 4px solid var(--primary-glow); transform: scale(1.05); z-index: 10;
            box-shadow: 0 40px 80px rgba(106,55,183,0.15);
        }
        .p-card.elite:hover { transform: scale(1.08) translateY(-25px); }
        .badge-elite { position: absolute; top: -20px; right: 50px; background: var(--primary); color: #fff; padding: 12px 35px; border-radius: 50px; font-size: 13px; font-weight: 900; letter-spacing: 2px; }
        
        .price-tag { font-size: 5rem; font-weight: 900; letter-spacing: -4px; color: var(--primary); margin: 35px 0; }
        .p-features li { list-style: none; margin-bottom: 22px; font-size: 1.1rem; color: var(--text-light); display: flex; align-items: center; }
        .p-features li i { color: var(--primary); margin-right: 18px; font-size: 20px; }
        .btn-cta { background: var(--primary-soft); color: var(--primary); text-decoration: none; padding: 25px; display: block; border-radius: 25px; text-align: center; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; transition: 0.4s; }
        .btn-cta:hover { background: var(--primary); color: #fff; box-shadow: 0 20px 40px rgba(106,55,183,0.3); }

        /* FAQ */
        .section-faq { padding: 120px 10%; background: #fff; }
        .faq-item { margin-bottom: 25px; border-radius: 30px; background: var(--bg-off); transition: 0.4s; cursor: pointer; }
        .faq-q { padding: 35px 45px; display: flex; justify-content: space-between; align-items: center; font-size: 1.4rem; font-weight: 800; }
        .faq-a { padding: 0 45px; max-height: 0; overflow: hidden; transition: 0.6s cubic-bezier(0.16, 1, 0.3, 1); opacity: 0; color: var(--text-light); line-height: 1.8; }
        .faq-item.active .faq-a { padding-bottom: 45px; max-height: 300px; opacity: 1; }
        .faq-item.active { box-shadow: 0 30px 60px rgba(0,0,0,0.04); background: #fff; transform: scale(1.02); }

        /* FOOTER LUXURY (NON-UNIFORM) */
        footer { 
            padding: 180px 10% 80px; 
            background: linear-gradient(145deg, var(--primary-dark) 0%, var(--primary) 50%, #7e4dcc 100%);
            color: #fff; position: relative; overflow: hidden;
        }
        footer::after { content: ''; position: absolute; inset: 0; background: url('https://www.transparenttextures.com/patterns/p6.png'); opacity: 0.05; pointer-events: none; }
        
        .f-wave { position: absolute; top: -1px; left: 0; width: 100%; transform: rotate(180deg); }
        .f-wave svg { display: block; width: calc(150% + 1.3px); height: 110px; fill: #fff; }
        
        .f-grid { display: grid; grid-template-columns: 2.5fr 1fr 1fr 1.2fr; gap: 80px; position: relative; z-index: 10; }
        .f-col h5 { font-size: 15px; opacity: 0.4; margin-bottom: 35px; letter-spacing: 5px; text-transform: uppercase; font-weight: 900; }
        .f-col a { color: #fff; text-decoration: none; display: block; margin-bottom: 20px; opacity: 0.6; transition: 0.3s; font-size: 16px; }
        .f-col a:hover { opacity: 1; transform: translateX(12px); color: var(--primary-glow); }

        @media (max-width: 1024px) { .grid-poder { grid-template-columns: 1fr; } .f-grid { grid-template-columns: 1fr; text-align: center; } .f-col { align-items: center; } }
        @media (max-width: 768px) {
            .slide { justify-content: center; padding: 0 5%; }
            .hero-content { text-align: center; }
            .hero-content h1 { font-size: 3.5rem; letter-spacing: -2px; }
            .hero-content p { border-left: none; border-top: 8px solid var(--primary); padding: 30px 0 0; text-align: center; }
        }
        .reveal { opacity: 0; transform: translateY(50px); transition: 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>

    <div id="preloader"><img src="assets/img/logo.png" class="pre-logo"></div>

    <nav id="navbar">
        <a href="#" class="nav-logo"><img src="assets/img/logo.png"></a>
        <div class="nav-links">
            <a href="#poder">Poder</a>
            <a href="#planes">Planes</a>
            <a href="https://wa.me/56900000000" target="_blank" class="btn-wa">WhatsApp VIP</a>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-carousel">
            <div class="carousel-track" id="heroTrack">
                <div class="slide">
                    <img src="assets/img/banner_super.png" class="slide-bg">
                    <div class="slide-overlay"></div>
                    <div class="hero-content">
                        <h1 class="reveal">El Software para tu <span>Supermercado.</span></h1>
                        <p class="reveal">La plataforma Élite diseñada para minimizar tus tiempos de espera y maximizar tus ganancias en Minimarkets y Pymes.</p>
                        <div class="reveal">
                            <a href="#planes" class="btn-luxury" style="padding: 24px 60px;">Explorar Planes</a>
                            <button onclick="moveCarousel(1)" style="margin-left: 15px; background: none; border: 2px solid var(--primary); color: var(--primary); padding: 22px 45px; border-radius: 20px; font-weight: 900; cursor: pointer; transition: 0.3s;">MÁS INFO</button>
                        </div>
                    </div>
                </div>
                <div class="slide">
                    <img src="assets/img/banner_super.png" class="slide-bg" style="filter: blur(8px) brightness(0.6);">
                    <div class="pearl-form reveal">
                        <h2>Únete a la <span>Élite</span></h2>
                        <p>Gestión inteligente para negocios que no aceptan límites.</p>
                        <form onsubmit="handleLead(event, this)" class="form-grid">
                            <div class="input-wrap">
                                <i class="fa-solid fa-user"></i>
                                <input type="text" name="nombre" class="form-input" placeholder="Nombre completo" required>
                            </div>
                            <div class="input-wrap">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" name="email" class="form-input" placeholder="Correo electrónico" required>
                            </div>
                            <div class="input-wrap">
                                <i class="fa-solid fa-whatsapp"></i>
                                <input type="text" name="whatsapp" class="form-input" placeholder="WhatsApp" required>
                            </div>
                            <button type="submit" class="btn-luxury">Solicitar Acceso Élite</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PODER CAJAYA - HIGH CONTRAST -->
    <section class="section-poder" id="poder">
        <div class="header-elite">
            <h2 class="reveal">El Poder de <span>CajaYa.</span></h2>
            <p class="reveal" style="font-size: 1.5rem; color: var(--text-light); margin-top: 25px; max-width: 900px; margin-inline: auto;">Tecnología disruptiva para el comercio minorista chileno.</p>
        </div>
        <div class="grid-poder">
            <div class="card-poder reveal">
                <i class="fa-solid fa-bolt-lightning"></i>
                <h3>Velocidad Extrema</h3>
                <p>Procesa transacciones en milisegundos. Elimina las colas y mantén a tus clientes felices.</p>
            </div>
            <div class="card-poder reveal">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <h3>Nube Resiliente</h3>
                <p>Sincronización inteligente. Tu negocio nunca se detiene, incluso sin conexión a internet.</p>
            </div>
            <div class="card-poder reveal">
                <i class="fa-solid fa-shield-halved"></i>
                <h3>Control Absoluto</h3>
                <p>Auditoría de inventario y reportes financieros con precisión quirúrgica desde tu smartphone.</p>
            </div>
        </div>
    </section>

    <!-- PLANES - ANIMATED -->
    <section class="section-planes" id="planes">
        <div class="header-elite" style="text-align: center; margin-bottom: 100px;">
            <h2 class="reveal">Inversión <span>Estratégica.</span></h2>
        </div>
        <div class="p-grid">
            <div class="p-card reveal">
                <h3>PLAN EMPRENDE</h3>
                <div class="price-tag">$<?php echo $pMensual; ?><span style="font-size: 1.5rem; opacity: 0.3;">/mes</span></div>
                <ul class="p-features">
                    <li><i class="fa-solid fa-check"></i> Catálogo Maestro (+20k SKU)</li>
                    <li><i class="fa-solid fa-check"></i> Boletas SII Ilimitadas</li>
                    <li><i class="fa-solid fa-check"></i> Control de Stock en Vivo</li>
                </ul>
                <a href="auth/google_redirect.php?plan=mensual" class="btn-cta">Comenzar Ahora</a>
            </div>
            <div class="p-card elite reveal">
                <div class="badge-elite">OFERTA ÉLITE</div>
                <h3>LICENCIA VITALICIA</h3>
                <div class="price-tag">$<?php echo $pLifetime; ?></div>
                <p style="margin-top:-40px; margin-bottom:40px; font-weight:900; opacity:0.4; letter-spacing:4px; text-align:center;">PAGO ÚNICO • PARA SIEMPRE</p>
                <ul class="p-features">
                    <li><i class="fa-solid fa-crown"></i> 3 Cajas Simultáneas</li>
                    <li><i class="fa-solid fa-crown"></i> Soporte VIP 24/7</li>
                    <li><i class="fa-solid fa-crown"></i> Cero Mensualidades</li>
                </ul>
                <a href="auth/google_redirect.php?plan=lifetime" class="btn-cta" style="background: var(--primary); color: #fff;">Obtener Propiedad Total</a>
            </div>
            <div class="p-card reveal">
                <h3>PLAN EMPRESA</h3>
                <div class="price-tag">$<?php echo $pEmpresa; ?><span style="font-size: 1.5rem; opacity: 0.3;">/mes</span></div>
                <ul class="p-features">
                    <li><i class="fa-solid fa-building"></i> Multi-sucursal Centralizado</li>
                    <li><i class="fa-solid fa-building"></i> Facturación y Guías</li>
                    <li><i class="fa-solid fa-building"></i> API de Integración</li>
                </ul>
                <a href="auth/google_redirect.php?plan=empresa" class="btn-cta">Hablar con Ventas</a>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="section-faq">
        <div class="header-elite">
            <h2 class="reveal">Preguntas <span>Frecuentes.</span></h2>
        </div>
        <div class="faq-container reveal" style="margin-top: 80px;">
            <div class="faq-item">
                <div class="faq-q"><span>¿El catálogo ya viene cargado?</span><i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-a">Sí. CajaYa incluye más de 20,000 productos de consumo masivo con sus códigos de barra y precios sugeridos para que empieces a vender hoy mismo.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q"><span>¿Funciona sin Internet?</span><i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-a">Correcto. Nuestra arquitectura híbrida permite realizar ventas offline y sincronizar los datos automáticamente cuando la conexión se restablece.</div>
            </div>
        </div>
    </section>

    <footer>
        <div class="f-wave">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path></svg>
        </div>
        <div class="f-grid">
            <div class="f-col">
                <img src="assets/img/logo.png">
                <p>Revolucionando la gestión del retail independiente con tecnología de clase mundial.</p>
            </div>
            <div class="f-col">
                <h5>PRODUCTO</h5>
                <a href="#">Panel Maestro</a>
                <a href="#">ServiRec App</a>
            </div>
            <div class="f-col">
                <h5>SOPORTE</h5>
                <a href="#">Centro de Ayuda</a>
                <a href="#">WhatsApp VIP</a>
            </div>
            <div class="f-col">
                <h5>ESTADO</h5>
                <p style="font-weight: 800; font-size: 14px; margin-bottom: 10px;"><i class="fa-solid fa-circle" style="color: #22C55E; font-size: 10px; margin-right: 8px;"></i> Sistemas Online</p>
                <p style="opacity: 0.4; font-size: 12px;">RM, SANTIAGO DE CHILE</p>
            </div>
        </div>
        <div style="text-align:center; margin-top:100px; opacity:0.2; font-size:12px; letter-spacing:5px;">&copy; 2026 CAJAYA ELITE. TODOS LOS DERECHOS RESERVADOS.</div>
    </footer>

    <script>
        window.addEventListener('load', () => {
            const pre = document.getElementById('preloader');
            pre.style.opacity = '0';
            setTimeout(() => pre.style.display = 'none', 800);
        });

        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 60) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        document.querySelectorAll('.faq-item').forEach(item => {
            item.addEventListener('click', () => {
                item.classList.toggle('active');
                const icon = item.querySelector('i');
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
            });
        });

        let currentSlide = 0;
        function moveCarousel(index) {
            currentSlide = index;
            document.getElementById('heroTrack').style.transform = `translateX(-${index * 100}%)`;
        }
        setInterval(() => {
            currentSlide = (currentSlide + 1) % 2;
            moveCarousel(currentSlide);
        }, 9000);

        async function handleLead(e, form) {
            e.preventDefault();
            const btn = form.querySelector('button');
            btn.innerHTML = 'PROCESANDO ACCESO...'; btn.disabled = true;
            try {
                const resp = await fetch('save_lead.php', { method: 'POST', body: new FormData(form) });
                if (resp.ok) form.innerHTML = '<h3 style="color:var(--primary); padding:40px;">¡Acceso Solicitado! Pronto te contactaremos.</h3>';
            } catch (err) { btn.innerHTML = 'REINTENTAR'; btn.disabled = false; }
        }
    </script>
</body>
</html>
