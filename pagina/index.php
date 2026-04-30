<?php
/**
 * index.php — Landing Page CAJAYA ELITE FINAL V18.1 (PERFECT FLOW)
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
            --transition-mac: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
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

        .hero-carousel { position: relative; height: 100vh; overflow: hidden; background: url('assets/img/banner_super.png') center/cover; }
        .carousel-track { display: flex; height: 100%; transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .slide { min-width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; padding: 0 8%; }
        
        .hero-content { max-width: 850px; text-align: left; }
        .hero-content h1 { font-family: 'Outfit', sans-serif; font-size: clamp(3rem, 8vw, 5.8rem); line-height: 0.9; font-weight: 900; margin-bottom: 30px; letter-spacing: -3px; }
        .hero-content h1 span { color: var(--primary); }
        .hero-content p { font-size: 1.5rem; color: var(--text-light); margin-bottom: 50px; }
        .btn-primary { background: var(--primary); color: #fff; padding: 24px 50px; border-radius: 20px; text-decoration: none; font-weight: 700; display: inline-block; }

        .product-desc { background: #fff; padding: 120px 8%; text-align: center; }
        .desc-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; margin-top: 60px; }
        .desc-item { padding: 40px; border-radius: 30px; background: #f9f9f9; transition: 0.3s; }
        .desc-item:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
        .desc-item i { font-size: 40px; color: var(--primary); margin-bottom: 20px; }
        .desc-item h3 { margin-bottom: 15px; font-size: 1.5rem; }

        .section-padding { padding: 150px 8%; background: var(--bg-off); }
        .section-header { text-align: center; margin-bottom: 100px; }
        .section-header h2 { font-family: 'Outfit', sans-serif; font-size: 4rem; letter-spacing: -2px; }
        .section-header h2 span { color: var(--primary); }
        
        .p-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 40px; }
        .p-card { background: #fff; padding: 80px 50px; border-radius: 40px; flex: 1; min-width: 350px; max-width: 450px; box-shadow: 0 10px 40px rgba(0,0,0,0.02); }
        .badge-sugerido { position: absolute; top: -18px; right: 40px; background: var(--primary-dark); color: #fff !important; padding: 10px 25px; border-radius: 50px; font-size: 11px; font-weight: 900; z-index: 100; text-transform: uppercase; }
        .p-card h3 { font-size: 14px; color: var(--primary); letter-spacing: 4px; text-transform: uppercase; margin-bottom: 25px; font-weight: 900; }
        .price { font-size: 3.5rem; font-weight: 900; letter-spacing: -2px; line-height: 1; margin: 20px 0; display: flex; align-items: baseline; justify-content: center; }
        .price-sub { font-size: 1.1rem; opacity: 0.5; font-weight: 600; margin-left: 5px; }
        .p-features { list-style: none; margin-bottom: 50px; flex-grow: 1; }
        .p-features li { margin-bottom: 18px; font-size: 15px; color: var(--text-light); display: flex; align-items: center; text-align: left; }
        .p-features li i { color: var(--primary); margin-right: 15px; font-size: 16px; }
        .btn-plan { background: var(--primary-soft); color: var(--primary); text-decoration: none; padding: 22px; display: block; border-radius: 20px; text-align: center; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; transition: 0.3s; }
        .btn-plan:hover { transform: scale(1.02); background: var(--primary); color: #fff; }

        footer { padding: 120px 8% 60px; background: #111; color: #fff; }
        .f-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 40px; }
        
        @media (max-width: 768px) {
            .hero-carousel { height: auto; min-height: 100vh; }
            .slide { padding: 120px 5% 60px; }
            .hero-content h1 { font-size: 2.8rem; text-align: center; }
            .hero-content p { font-size: 1.1rem; text-align: center; }
            .hero-btns { display: flex; flex-direction: column; gap: 15px; align-items: center; }
            
            .desc-grid { grid-template-columns: 1fr; }
            .p-grid { gap: 20px; }
            .p-card { min-width: 100%; padding: 40px 25px; }
            .price { font-size: 3rem; }
            
            footer { padding: 80px 5% 40px; }
            .f-grid { grid-template-columns: 1fr !important; text-align: center !important; gap: 50px; }
            .f-col { align-items: center !important; }
        }
        .reveal { opacity: 0; transform: translateY(40px); transition: var(--transition-mac); }
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
            <div class="slide hero">
                <div class="hero-content">
                    <h1 class="reveal">El Software para tu <span>Supermercado</span>.</h1>
                    <p class="reveal">La plataforma Élite diseñada para minimizar tus tiempos de espera y maximizar tus ganancias en Minimarkets y Pymes.</p>
                    <div class="hero-btns reveal">
                        <a href="#planes" class="btn-primary" style="margin-right: 15px;">Ver Planes</a>
                        <button onclick="moveCarousel(1)" style="background: rgba(106,55,183,0.1); border: 1px solid var(--primary); color: var(--primary); padding: 22px 40px; border-radius: 20px; font-weight: 700; cursor: pointer; transition: 0.3s;">¡Infórmame más!</button>
                    </div>
                </div>
            </div>
            <!-- Slide 2: Quick Form -->
            <div class="slide" style="background: var(--bg-off);">
                <div class="early-container" style="width: 100%; max-width: 800px; padding: 60px 40px; border: 1px solid rgba(106,55,183,0.1); background: #fff;">
                    <div class="early-content">
                        <h2 style="font-size: 2.5rem; margin-bottom: 15px;">Únete a la <span>Élite</span></h2>
                        <p style="margin-bottom: 40px;">Déjanos tus datos y obtén una consultoría estratégica gratuita.</p>
                        <form onsubmit="handleLead(event, this)" class="lead-form" style="grid-template-columns: 1fr;">
                            <div class="input-group">
                                <i class="fa-solid fa-user"></i>
                                <input type="text" name="nombre" class="lead-input" placeholder="Nombre completo" required>
                            </div>
                            <div class="input-group">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" name="email" class="lead-input" placeholder="Correo electrónico" required>
                            </div>
                            <button type="submit" class="btn-submit" style="width: 100%;">¡Activar ahora!</button>
                        </form>
                        <button onclick="moveCarousel(0)" style="margin-top: 25px; background: transparent; border: none; color: var(--primary); font-weight: 700; cursor: pointer; text-decoration: underline;">Volver al inicio</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="product-desc" id="desc">
        <div class="section-header">
            <h2 class="reveal">El Poder de <span>CajaYa.</span></h2>
        </div>
        <div class="desc-grid">
            <div class="desc-item reveal">
                <i class="fa-solid fa-bolt"></i>
                <h3>Velocidad Extrema</h3>
                <p>Ventas en menos de 2 segundos. Diseñado para no hacer esperar a tus clientes.</p>
            </div>
            <div class="desc-item reveal">
                <i class="fa-solid fa-cloud"></i>
                <h3>Nube Híbrida</h3>
                <p>¿Sin internet? No hay problema. CajaYa sigue funcionando y sincroniza todo al volver.</p>
            </div>
            <div class="desc-item reveal">
                <i class="fa-solid fa-chart-line"></i>
                <h3>Control Total</h3>
                <p>Stock, ventas y reportes en tiempo real desde cualquier lugar del mundo.</p>
            </div>
        </div>
        <div class="reveal" style="margin-top: 60px;">
            <button onclick="document.getElementById('early').scrollIntoView();" class="btn-primary" style="font-size: 1.1rem; padding: 25px 60px;">¡Quiero esta tecnología en mi negocio!</button>
        </div>
    </section>

    <section class="section-padding" id="planes">
        <div class="section-header">
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
                    <li><i class="fa-solid fa-circle-check"></i> <b>Catálogo Maestro (+20k SKU)</b></li>
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
                <p style="margin-top:-30px; margin-bottom:30px; font-weight:800; font-size:12px; letter-spacing:2px; opacity:0.8; color:#fff; text-align: center;">PAGO ÚNICO • PROPIEDAD TOTAL</p>
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
                    <li><i class="fa-solid fa-building"></i> <b>Multi-sucursal Centralizado</b></li>
                    <li><i class="fa-solid fa-building"></i> Facturación y Guías</li>
                    <li><i class="fa-solid fa-building"></i> API de Integración Pro</li>
                    <li><i class="fa-solid fa-building"></i> Auditoría de Inventarios</li>
                </ul>
                <a href="auth/google_redirect.php?plan=empresa" class="btn-plan">Hablar con Ventas</a>
            </div>
        </div>
    </section>

    </section>

    <canvas id="celeb-canvas"></canvas>

    <section class="early-access" id="early">
        <div class="early-container reveal">
            <div class="early-content">
                <h2>Lanzamiento en <span>10 Días</span></h2>
                <p>Únete a los fundadores y obtén un beneficio exclusivo.</p>
                <form id="leadForm" class="lead-form">
                    <div class="input-group">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="nombre" class="lead-input" placeholder="Nombre completo" required>
                    </div>
                    <div class="input-group">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" class="lead-input" placeholder="Correo corporativo" required>
                    </div>
                    <div class="input-group" style="grid-column: span 2;">
                        <i class="fa-solid fa-whatsapp"></i>
                        <input type="text" name="whatsapp" class="lead-input" placeholder="WhatsApp de contacto" required>
                    </div>
                    <button type="submit" class="btn-submit">¡Infórmame más!</button>
                </form>
                <div id="successMsg" class="success-msg">
                    <i class="fa-solid fa-star" style="font-size: 60px; margin-bottom: 25px; color: var(--primary-glow);"></i>
                    <br>¡SOLICITUD RECIBIDA!<br>Pronto conocerás el poder de CajaYa.
                </div>
            </div>
        </div>
    </section>

    <section class="faq-section">
        <div class="section-header">
            <h2 class="reveal">Dudas <span>Frecuentes.</span></h2>
        </div>
        <div class="faq-container reveal">
            <div class="faq-item">
                <div class="faq-header"><h4>¿Cómo instalo el catálogo de productos?</h4><i class="fa-solid fa-plus"></i></div>
                <div class="faq-body"><p>No requiere instalación. CajaYa incluye una base de datos con más de 20,000 productos de consumo masivo precargados. Solo escaneas y vendes al instante.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-header"><h4>¿Qué pasa si pierdo el Internet?</h4><i class="fa-solid fa-plus"></i></div>
                <div class="faq-body"><p>CajaYa es Offline-First. Puedes seguir vendiendo sin interrupciones y el sistema sincronizará todas las transacciones automáticamente al detectar conexión.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-header"><h4>¿Es compatible con mis equipos?</h4><i class="fa-solid fa-plus"></i></div>
                <div class="faq-body"><p>Totalmente. Funciona en cualquier PC, Notebook o Tablet con Windows o Android. Sin necesidad de comprar hardware propietario costoso.</p></div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-wave">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
            </svg>
        </div>
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
        <div style="text-align:center; margin-top:80px; opacity:0.2; font-size:11px; letter-spacing:3px;">
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

        // ACCORDION - INTERACTIVE
        document.querySelectorAll('.faq-header').forEach(header => {
            header.addEventListener('click', () => {
                const item = header.parentElement;
                const wasActive = item.classList.contains('active');
                document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
                if (!wasActive) item.classList.add('active');
            });
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
        }, { threshold: 0.15 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        observer.observe(document.getElementById('plan-cards'));

        // CELEBRATION ENGINE
        function launchCelebration() {
            const canvas = document.getElementById('celeb-canvas');
            canvas.style.display = 'block';
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            
            let particles = [];
            const colors = ['#6A37B7', '#9D50BB', '#FFD700', '#FFFFFF'];
            
            class Particle {
                constructor() {
                    this.x = canvas.width / 2;
                    this.y = canvas.height / 2;
                    this.angle = Math.random() * Math.PI * 2;
                    this.speed = Math.random() * 8 + 2;
                    this.friction = 0.95;
                    this.gravity = 0.15;
                    this.size = Math.random() * 6 + 2;
                    this.color = colors[Math.floor(Math.random() * colors.length)];
                    this.opacity = 1;
                }
                update() {
                    this.speed *= this.friction;
                    this.x += Math.cos(this.angle) * this.speed;
                    this.y += Math.sin(this.angle) * this.speed + this.gravity;
                    this.opacity -= 0.01;
                }
                draw() {
                    ctx.globalAlpha = this.opacity;
                    ctx.fillStyle = this.color;
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            for(let i=0; i<150; i++) particles.push(new Particle());

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach((p, i) => {
                    if(p.opacity <= 0) particles.splice(i, 1);
                    else { p.update(); p.draw(); }
                });
                if(particles.length > 0) requestAnimationFrame(animate);
                else canvas.style.display = 'none';
            }
            animate();
        }

        // CAROUSEL LOGIC
        function moveCarousel(index) {
            const track = document.getElementById('heroTrack');
            track.style.transform = `translateX(-${index * 100}%)`;
        }

        async function handleLead(e, formElement) {
            e.preventDefault();
            const btn = formElement.querySelector('.btn-submit');
            const success = document.createElement('div');
            success.innerHTML = '¡Enviado!';
            success.style.color = '#fff';
            success.style.fontWeight = 'bold';
            success.style.marginTop = '20px';
            
            btn.innerHTML = '...';
            btn.disabled = true;

            const formData = new FormData(formElement);
            try {
                const resp = await fetch('save_lead.php', { method: 'POST', body: formData });
                if (resp.ok) {
                    formElement.style.display = 'none';
                    formElement.parentNode.appendChild(success);
                    launchCelebration();
                }
            } catch (err) {
                btn.innerHTML = 'Error';
                btn.disabled = false;
            }
        }

        // LEAD FORM HANDLING (FOOTER ONE)
        document.getElementById('leadForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = e.target.querySelector('.btn-submit');
            const form = e.target;
            const success = document.getElementById('successMsg');
            
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> PROCESANDO...';
            btn.disabled = true;

            const formData = new FormData(form);
            try {
                const resp = await fetch('save_lead.php', { method: 'POST', body: formData });
                if (resp.ok) {
                    form.style.display = 'none';
                    success.style.display = 'block';
                    launchCelebration(); // ¡BOOM!
                }
            } catch (err) {
                console.error(err);
                alert('Hubo un error, por favor intenta de nuevo.');
                btn.innerHTML = '¡Infórmame más!';
                btn.disabled = false;
            }
        });
    </script>
</body>
</html>
