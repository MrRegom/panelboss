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
        .nav-links a { color: var(--text-dark); text-decoration: none; font-weight: 700; font-size: 14px; margin-left: 30px; }
        .btn-wa { background: #25D366; color: #fff !important; padding: 10px 22px; border-radius: 50px; font-weight: 800; box-shadow: 0 10px 20px rgba(37,211,102,0.2); }

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
        }
        .p-card:hover { transform: translateY(-15px) scale(1.02); box-shadow: 0 50px 100px rgba(106,55,183,0.12); }
        .p-card.featured { border: 3px solid var(--primary-glow); z-index: 10; }
        .badge-elite { position: absolute; top: -15px; right: 30px; background: var(--primary); color: #fff; padding: 10px 25px; border-radius: 50px; font-size: 12px; font-weight: 900; }
        
        .price-box { font-size: 4.5rem; font-weight: 900; color: var(--primary); margin: 20px 0; display: flex; align-items: baseline; }
        .price-sub { font-size: 1.2rem; color: var(--text-light); opacity: 0.5; margin-left: 5px; }
        .p-features { list-style: none; margin-bottom: 40px; text-align: left; width: 100%; }
        .p-features li { margin-bottom: 15px; font-size: 15px; display: flex; align-items: center; color: var(--text-light); }
        .p-features li i { color: var(--primary); margin-right: 12px; font-size: 18px; }
        .btn-cta { width: 100%; background: var(--primary-soft); color: var(--primary); text-decoration: none; padding: 22px; border-radius: 20px; font-weight: 900; text-transform: uppercase; transition: 0.3s; }
        .p-card.featured .btn-cta { background: var(--primary); color: #fff; }

        /* FAQ */
        .section-faq { padding: 100px 10%; background: #fff; text-align: center; }
        .faq-container { max-width: 800px; margin: 60px auto 0; text-align: left; }
        .faq-item { margin-bottom: 15px; border-radius: 25px; background: var(--bg-off); overflow: hidden; cursor: pointer; transition: 0.3s; }
        .faq-item h4 { padding: 30px 40px; font-size: 1.2rem; display: flex; justify-content: space-between; align-items: center; }
        .faq-body { padding: 0 40px 0; max-height: 0; opacity: 0; transition: 0.5s ease; color: var(--text-light); line-height: 1.7; }
        .faq-item.active .faq-body { padding-bottom: 35px; max-height: 200px; opacity: 1; }
        .faq-item.active { background: #fff; box-shadow: 0 20px 40px rgba(0,0,0,0.05); }

        /* FOOTER (CLEAN PURPLE) */
        footer { 
            padding: 150px 10% 60px; 
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            color: #fff; position: relative; overflow: hidden;
        }
        .f-wave { position: absolute; top: -1px; left: 0; width: 100%; transform: rotate(180deg); }
        .f-wave svg { display: block; width: calc(160% + 1.3px); height: 80px; fill: #fff; }
        
        .f-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 60px; position: relative; z-index: 10; }
        .f-col img { height: 35px; margin-bottom: 25px; filter: brightness(0) invert(1); }
        .f-col h5 { font-size: 13px; opacity: 0.5; margin-bottom: 25px; letter-spacing: 3px; text-transform: uppercase; }
        .f-col a { color: #fff; text-decoration: none; display: block; margin-bottom: 15px; opacity: 0.7; transition: 0.3s; }
        .f-col a:hover { opacity: 1; transform: translateX(10px); color: var(--primary-glow); }

        @media (max-width: 1024px) {
            .grid-poder, .grid-planes { grid-template-columns: 1fr; }
            .f-grid { grid-template-columns: 1fr; text-align: center; }
            .f-col { align-items: center; }
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
            <a href="#planes">Planes</a>
            <a href="https://wa.me/56900000000" target="_blank" class="btn-wa">Soporte WhatsApp</a>
        </div>
    </nav>

    <section class="hero">
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

    <section class="section-poder" id="poder">
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
        <div class="f-wave"><svg viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path></svg></div>
        <div class="f-grid">
            <div class="f-col"><img src="assets/img/logo.png"><p>Tecnología líder para el retail en Chile.</p></div>
            <div class="f-col"><h5>PRODUCTO</h5><a href="#">Panel</a><a href="#">App</a></div>
            <div class="f-col"><h5>SOPORTE</h5><a href="#">Ayuda</a><a href="#">WhatsApp</a></div>
            <div class="f-col"><h5>LEGAL</h5><a href="#">Privacidad</a></div>
        </div>
        <div style="text-align:center; margin-top:80px; opacity:0.2; font-size:12px;">&copy; 2026 CAJAYA.</div>
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

        document.querySelectorAll('.faq-item').forEach(it => it.addEventListener('click', () => it.classList.toggle('active')));

        let slide = 0;
        function moveCarousel(idx) { slide = idx; document.getElementById('heroTrack').style.transform = `translateX(-${idx*100}%)`; }
        setInterval(() => { slide = (slide+1)%2; moveCarousel(slide); }, 8000);

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
