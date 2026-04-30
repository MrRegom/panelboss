<?php
/**
 * index.php — Landing Page CAJAYA ELITE V21 (RESTORED PEARL AESTHETIC)
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
            --primary-dark: #4A268A;
            --primary-glow: #9D6CFF;
            --primary-soft: #F4F0FF;
            --text-dark: #1D1D1F;
            --text-light: #6E6E73;
            --bg-white: #FFFFFF;
            --bg-off: #FBFBFE;
            --transition-mac: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-font-smoothing: antialiased; scroll-behavior: smooth; }
        body { background: var(--bg-white); color: var(--text-dark); font-family: 'Inter', sans-serif; overflow-x: hidden; }

        #preloader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: #fff; display: flex; align-items: center; justify-content: center;
            z-index: 10000; transition: opacity 1.2s ease-out;
        }
        .pre-logo { width: 140px; animation: pulse 2s infinite ease-in-out; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.7; } 50% { transform: scale(1.1); opacity: 1; } }

        nav { 
            position: fixed; top: 0; width: 100%; height: 80px; z-index: 1000;
            display: flex; justify-content: space-between; align-items: center; padding: 0 5%;
            transition: var(--transition-mac);
        }
        nav.scrolled { background: rgba(255,255,255,0.85); backdrop-filter: blur(25px); height: 70px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); }
        .nav-logo img { height: 35px; }
        .nav-links a { color: var(--text-dark); text-decoration: none; font-weight: 600; font-size: 14px; margin-left: 30px; transition: 0.3s; }
        .nav-links a:hover { color: var(--primary); }
        .btn-wa { background: #25D366; color: #fff !important; padding: 10px 22px; border-radius: 50px; font-weight: 700; box-shadow: 0 10px 20px rgba(37,211,102,0.2); }

        /* HERO CAROUSEL */
        .hero-carousel { position: relative; height: 100vh; overflow: hidden; background: #fff; }
        .carousel-track { display: flex; height: 100%; transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
        .slide { min-width: 100%; height: 100%; position: relative; display: flex; align-items: center; justify-content: center; padding: 0 8%; }
        
        .slide-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1; }
        .slide-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.7) 50%, transparent 100%); z-index: 2; }

        .hero-content { position: relative; z-index: 10; max-width: 850px; text-align: left; }
        .hero-content h1 { font-family: 'Outfit', sans-serif; font-size: clamp(3rem, 8vw, 5.5rem); line-height: 0.9; font-weight: 900; margin-bottom: 30px; letter-spacing: -4px; color: var(--text-dark); }
        .hero-content h1 span { color: var(--primary); }
        .hero-content p { font-size: 1.5rem; color: var(--text-light); margin-bottom: 50px; max-width: 650px; border-left: 5px solid var(--primary); padding-left: 30px; }
        .btn-primary { background: var(--primary); color: #fff; padding: 24px 50px; border-radius: 20px; text-decoration: none; font-weight: 700; display: inline-block; transition: 0.3s; box-shadow: 0 20px 40px rgba(106,55,183,0.2); }
        .btn-primary:hover { transform: translateY(-5px); box-shadow: 0 30px 60px rgba(106,55,183,0.3); }

        /* PEARL FORM (CLEAN) */
        .pearl-container { 
            background: rgba(255,255,255,0.85); backdrop-filter: blur(20px);
            padding: 60px 50px; border-radius: 50px; color: var(--text-dark);
            box-shadow: 0 40px 100px rgba(106,55,183,0.1);
            border: 1px solid rgba(255,255,255,1); text-align: center;
            max-width: 600px; width: 100%;
        }
        .pearl-container h2 { font-family: 'Outfit', sans-serif; font-size: 3rem; margin-bottom: 15px; color: var(--primary); letter-spacing: -2px; }
        .pearl-container p { color: var(--text-light); font-size: 1.2rem; margin-bottom: 40px; }
        
        .lead-form { display: grid; grid-template-columns: 1fr; gap: 20px; width: 100%; }
        .input-group { position: relative; }
        .input-group i { position: absolute; left: 25px; top: 50%; transform: translateY(-50%); color: var(--primary); font-size: 18px; opacity: 0.5; }
        .lead-input { 
            width: 100%; padding: 22px 25px 22px 65px; border-radius: 22px; border: 1px solid rgba(106,55,183,0.1); 
            background: #fff; color: var(--text-dark); font-size: 16px; transition: 0.4s;
        }
        .lead-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 30px rgba(106,55,183,0.1); }
        .btn-submit { 
            background: var(--primary); color: #fff; border: none; padding: 24px; 
            border-radius: 22px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px;
            cursor: pointer; transition: 0.5s; box-shadow: 0 15px 40px rgba(106,55,183,0.2);
        }
        .btn-submit:hover { transform: translateY(-5px); box-shadow: 0 25px 50px rgba(106,55,183,0.3); }

        /* PRODUCT DESCRIPTION */
        .product-desc { background: #fff; padding: 120px 8%; text-align: center; }
        .section-header h2 { font-family: 'Outfit', sans-serif; font-size: 4rem; letter-spacing: -2px; }
        .section-header h2 span { color: var(--primary); }
        .desc-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; margin-top: 60px; }
        .desc-item { padding: 50px 40px; border-radius: 40px; background: var(--bg-off); transition: 0.5s; }
        .desc-item:hover { transform: translateY(-15px); box-shadow: 0 30px 60px rgba(0,0,0,0.05); }
        .desc-item i { font-size: 50px; color: var(--primary); margin-bottom: 30px; }
        .desc-item h3 { margin-bottom: 15px; font-size: 1.8rem; font-weight: 800; }

        /* PLAN CARDS (CLEAN) */
        .section-padding { padding: 150px 8%; background: var(--bg-off); }
        .p-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 40px; }
        .p-card { 
            background: #fff; padding: 80px 50px; border-radius: 45px; flex: 1; min-width: 350px; max-width: 450px;
            position: relative; box-shadow: 0 10px 40px rgba(0,0,0,0.02); transition: 0.8s;
        }
        .p-card.featured { border: 2px solid var(--primary-glow); }
        .badge-sugerido { position: absolute; top: -18px; right: 40px; background: var(--primary); color: #fff; padding: 12px 30px; border-radius: 50px; font-size: 12px; font-weight: 900; text-transform: uppercase; }
        .p-card h3 { font-size: 14px; color: var(--primary); letter-spacing: 5px; text-transform: uppercase; margin-bottom: 30px; font-weight: 900; }
        .price { font-size: 4.5rem; font-weight: 900; letter-spacing: -3px; display: flex; align-items: baseline; justify-content: center; margin: 30px 0; }
        .price-sub { font-size: 1.3rem; opacity: 0.4; margin-left: 8px; }
        .p-features { list-style: none; margin-bottom: 50px; text-align: left; }
        .p-features li { margin-bottom: 20px; font-size: 16px; color: var(--text-light); display: flex; align-items: center; }
        .p-features li i { color: var(--primary); margin-right: 15px; font-size: 18px; }
        .btn-plan { background: var(--primary-soft); color: var(--primary); text-decoration: none; padding: 25px; display: block; border-radius: 25px; text-align: center; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; transition: 0.3s; }
        .btn-plan:hover { transform: scale(1.05); background: var(--primary); color: #fff; }

        /* FOOTER (RESTORED) */
        footer { padding: 120px 8% 60px; background: #fff; color: var(--text-dark); border-top: 1px solid #eee; }
        .f-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 60px; }
        .f-col img { height: 35px; margin-bottom: 30px; }
        .f-col p { color: var(--text-light); line-height: 1.8; font-size: 15px; }
        .f-col h5 { font-size: 14px; color: var(--primary); margin-bottom: 30px; letter-spacing: 3px; text-transform: uppercase; font-weight: 900; }
        .f-col a { color: var(--text-dark); text-decoration: none; display: block; margin-bottom: 15px; opacity: 0.7; transition: 0.3s; font-size: 15px; }
        .f-col a:hover { opacity: 1; transform: translateX(10px); color: var(--primary); }

        @media (max-width: 768px) {
            .hero-content h1 { font-size: 3.2rem; text-align: center; }
            .hero-content p { border-left: none; border-top: 5px solid var(--primary); padding: 30px 0 0; text-align: center; }
            .hero-btns { display: flex; flex-direction: column; gap: 15px; align-items: center; }
            .f-grid { grid-template-columns: 1fr; text-align: center; }
            .f-col { align-items: center; display: flex; flex-direction: column; }
            .price { font-size: 3.5rem; }
        }
        .reveal { opacity: 0; transform: translateY(40px); transition: 1s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>

    <div id="preloader"><img src="assets/img/logo.png" class="pre-logo" alt="CajaYa"></div>

    <nav id="navbar">
        <a href="#" class="nav-logo"><img src="assets/img/logo.png" alt="CajaYa"></a>
        <div class="nav-links">
            <a href="#planes">Planes</a>
            <a href="https://wa.me/56900000000" target="_blank" class="btn-wa">Soporte WhatsApp</a>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-carousel">
            <div class="carousel-track" id="heroTrack">
                <!-- Slide 1 -->
                <div class="slide">
                    <img src="assets/img/banner_super.png" class="slide-bg">
                    <div class="slide-overlay"></div>
                    <div class="hero-content">
                        <h1 class="reveal">El Software para tu <span>Supermercado.</span></h1>
                        <p class="reveal">La plataforma Élite diseñada para minimizar tus tiempos de espera y maximizar tus ganancias en Minimarkets y Pymes.</p>
                        <div class="hero-btns reveal">
                            <a href="#planes" class="btn-primary" style="margin-right: 15px;">Ver Planes</a>
                            <button onclick="moveCarousel(1)" style="background: var(--primary-soft); color: var(--primary); border: none; padding: 22px 45px; border-radius: 20px; font-weight: 800; cursor: pointer; transition: 0.3s; text-transform: uppercase;">¡Infórmame más!</button>
                        </div>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="slide">
                    <img src="assets/img/banner_super.png" class="slide-bg" style="filter: blur(5px); opacity: 0.3;">
                    <div class="pearl-container reveal">
                        <h2>Únete a la <span>Élite</span></h2>
                        <p>Déjanos tus datos y obtén una consultoría gratuita para tu negocio.</p>
                        <form onsubmit="handleLead(event, this)" class="lead-form">
                            <div class="input-group">
                                <i class="fa-solid fa-user"></i>
                                <input type="text" name="nombre" class="lead-input" placeholder="Nombre completo" required>
                            </div>
                            <div class="input-group">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" name="email" class="lead-input" placeholder="Correo electrónico" required>
                            </div>
                            <div class="input-group">
                                <i class="fa-solid fa-whatsapp"></i>
                                <input type="text" name="whatsapp" class="lead-input" placeholder="WhatsApp de contacto" required>
                            </div>
                            <button type="submit" class="btn-submit">¡Quiero el Poder de CajaYa!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PRODUCT DESCRIPTION -->
    <section class="product-desc" id="desc">
        <div class="section-header">
            <h2 class="reveal">El Poder de <span>CajaYa.</span></h2>
            <p class="reveal" style="font-size: 1.3rem; color: var(--text-light); margin-top: 20px;">Llevamos tu negocio al siguiente nivel con tecnología de clase mundial.</p>
        </div>
        <div class="desc-grid">
            <div class="desc-item reveal">
                <i class="fa-solid fa-bolt"></i>
                <h3>Velocidad Extrema</h3>
                <p>Ventas en menos de 2 segundos. Olvídate de las filas.</p>
            </div>
            <div class="desc-item reveal">
                <i class="fa-solid fa-cloud"></i>
                <h3>Nube Híbrida</h3>
                <p>¿Sin internet? No hay problema. CajaYa sigue funcionando.</p>
            </div>
            <div class="desc-item reveal">
                <i class="fa-solid fa-chart-line"></i>
                <h3>Control Total</h3>
                <p>Stock y ventas en tiempo real desde cualquier lugar.</p>
            </div>
        </div>
        <div class="reveal" style="margin-top: 60px;">
            <button onclick="moveCarousel(1)" class="btn-primary" style="padding: 25px 70px;">¡Comenzar ahora!</button>
        </div>
    </section>

    <!-- PLAN CARDS -->
    <section class="section-padding" id="planes">
        <div class="section-header" style="text-align: center; margin-bottom: 80px;">
            <h2 class="reveal">Inversión <span>Inteligente.</span></h2>
        </div>

        <div class="p-grid" id="plan-cards">
            <div class="p-card reveal">
                <h3>PLAN EMPRENDE</h3>
                <div class="price">
                    $<?php echo $pMensual; ?>
                    <span class="price-sub">/mes</span>
                </div>
                <ul class="p-features">
                    <li><i class="fa-solid fa-circle-check"></i> Catálogo Maestro (+20k SKU)</li>
                    <li><i class="fa-solid fa-circle-check"></i> Boletas SII Ilimitadas</li>
                    <li><i class="fa-solid fa-circle-check"></i> Control de Stock en Vivo</li>
                    <li><i class="fa-solid fa-circle-check"></i> Reportes de Venta Diarios</li>
                </ul>
                <a href="auth/google_redirect.php?plan=mensual" class="btn-plan">Activar Ahora</a>
            </div>

            <div class="p-card featured reveal">
                <div class="badge-sugerido">Sugerido por CajaYa</div>
                <h3>LICENCIA ÉLITE</h3>
                <div class="price">
                    $<?php echo $pLifetime; ?>
                </div>
                <p style="margin-top:-30px; margin-bottom:40px; font-weight:800; font-size:13px; letter-spacing:3px; opacity:0.4; text-align: center;">PAGO ÚNICO • PROPIEDAD TOTAL</p>
                <ul class="p-features">
                    <li><i class="fa-solid fa-crown"></i> <b>Todo el Plan Emprende</b></li>
                    <li><i class="fa-solid fa-crown"></i> 3 Cajas Simultáneas</li>
                    <li><i class="fa-solid fa-crown"></i> Cero Mensualidades</li>
                    <li><i class="fa-solid fa-crown"></i> Soporte VIP 24/7</li>
                    <li><i class="fa-solid fa-crown"></i> Inteligencia de Negocios</li>
                </ul>
                <a href="auth/google_redirect.php?plan=lifetime" class="btn-plan">Comprar Para Siempre</a>
            </div>

            <div class="p-card reveal">
                <h3>RED EMPRESA</h3>
                <div class="price">
                    $<?php echo $pEmpresa; ?>
                    <span class="price-sub">/mes</span>
                </div>
                <ul class="p-features">
                    <li><i class="fa-solid fa-building"></i> Multi-sucursal Centralizado</li>
                    <li><i class="fa-solid fa-building"></i> Facturación y Guías</li>
                    <li><i class="fa-solid fa-building"></i> API de Integración Pro</li>
                    <li><i class="fa-solid fa-building"></i> Auditoría de Inventarios</li>
                </ul>
                <a href="auth/google_redirect.php?plan=empresa" class="btn-plan">Hablar con Ventas</a>
            </div>
        </div>
    </section>

    <canvas id="celeb-canvas" style="position: fixed; top:0; left:0; width:100%; height:100%; pointer-events:none; z-index:9999; display:none;"></canvas>

    <footer>
        <div class="f-grid">
            <div class="f-col">
                <img src="assets/img/logo.png">
                <p>Potenciando el crecimiento de los minimarkets y pymes en todo Chile con tecnología de vanguardia.</p>
            </div>
            <div class="f-col">
                <h5>PLATAFORMA</h5>
                <a href="#">Panel Maestro</a>
                <a href="#">Descargar App</a>
                <a href="#">Guía de Uso</a>
            </div>
            <div class="f-col">
                <h5>LEGAL</h5>
                <a href="#">Privacidad</a>
                <a href="#">Términos de Uso</a>
            </div>
            <div class="f-col">
                <h5>CONTACTO</h5>
                <a href="mailto:ventas@cajaya.cl">ventas@cajaya.cl</a>
                <p style="margin-top:20px; font-size:13px; opacity:0.4;">RM, SANTIAGO DE CHILE</p>
            </div>
        </div>
        <div style="text-align:center; margin-top:80px; opacity:0.2; font-size:11px; letter-spacing:4px;">
            &copy; 2026 CAJAYA — EL FUTURO DEL RETAIL CHILENO.
        </div>
    </footer>

    <script>
        // PRELOADER
        window.addEventListener('load', () => {
            const pre = document.getElementById('preloader');
            setTimeout(() => {
                pre.style.opacity = '0';
                setTimeout(() => pre.style.display = 'none', 1200);
            }, 1000);
        });

        // NAVBAR SCROLL
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });

        // REVEAL ANIMATIONS
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    if (entry.target.id === 'plan-cards') {
                        document.querySelectorAll('.p-card').forEach((card, i) => {
                            setTimeout(() => card.classList.add('visible'), i * 200);
                        });
                    }
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // CAROUSEL LOGIC
        let currentSlide = 0;
        function moveCarousel(index) {
            currentSlide = index;
            const track = document.getElementById('heroTrack');
            track.style.transform = `translateX(-${index * 100}%)`;
        }

        setInterval(() => {
            currentSlide = (currentSlide + 1) % 2;
            moveCarousel(currentSlide);
        }, 8000);

        // CELEBRATION
        function launchCelebration() {
            const canvas = document.getElementById('celeb-canvas');
            canvas.style.display = 'block';
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            let particles = [];
            for(let i=0; i<150; i++) {
                particles.push({
                    x: canvas.width/2, y: canvas.height/2,
                    angle: Math.random()*Math.PI*2, speed: Math.random()*8+2,
                    opacity: 1, color: ['#6A37B7', '#FFD700', '#fff'][Math.floor(Math.random()*3)]
                });
            }
            function animate() {
                ctx.clearRect(0,0,canvas.width,canvas.height);
                particles.forEach((p, i) => {
                    p.opacity -= 0.01;
                    p.x += Math.cos(p.angle)*p.speed;
                    p.y += Math.sin(p.angle)*p.speed + 0.2;
                    if(p.opacity <= 0) particles.splice(i, 1);
                    else {
                        ctx.globalAlpha = p.opacity;
                        ctx.fillStyle = p.color;
                        ctx.beginPath(); ctx.arc(p.x, p.y, 4, 0, Math.PI*2); ctx.fill();
                    }
                });
                if(particles.length > 0) requestAnimationFrame(animate);
                else canvas.style.display = 'none';
            }
            animate();
        }

        async function handleLead(e, formElement) {
            e.preventDefault();
            const btn = formElement.querySelector('.btn-submit');
            btn.innerHTML = 'ENVIANDO...'; btn.disabled = true;
            try {
                const resp = await fetch('save_lead.php', { method: 'POST', body: new FormData(formElement) });
                if (resp.ok) {
                    formElement.innerHTML = '<h3 style="color:var(--primary); padding:40px;">¡Gracias! Recibimos tus datos.</h3>';
                    launchCelebration();
                }
            } catch (err) {
                btn.innerHTML = '¡Reintentar!'; btn.disabled = false;
            }
        }
    </script>
</body>
</html>
