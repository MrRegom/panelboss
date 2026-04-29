<?php
/**
 * index.php — Landing Page CAJAYA CLEAN PURPLE (OFFICIAL COLORS & ORDERED)
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/Database.php';
require_once __DIR__ . '/../src/Repositories/PlanRepository.php';

use App\Repositories\PlanRepository;

$planRepo = new PlanRepository();
$plansRaw = $planRepo->getAll();
$plans = [];
foreach ($plansRaw as $p) { $plans[$p['slug']] = $p; }

$pMensual  = number_format($plans['mensual']['price']  ?? 20000, 0, ',', '.');
$pLifetime = number_format($plans['lifetime']['price'] ?? 180000, 0, ',', '.');
$pEmpresa  = number_format($plans['empresa']['price']  ?? 35000, 0, ',', '.');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CajaYa — El Ecosistema POS Nº1 de Chile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --brand-purple: #6A1B9A;
            --brand-light: #F3E5F5;
            --dark: #121212;
            --white: #FFFFFF;
            --transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: var(--white); color: #1d1d1f; font-family: 'Outfit', sans-serif; -webkit-font-smoothing: antialiased; }

        /* INTRO PRO */
        #preloader { 
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: #000; display: flex; align-items: center; justify-content: center; z-index: 10000; 
            transition: opacity 1s ease-in-out; 
        }
        .preloader-content { position: relative; text-align: center; }
        .preloader-logo { width: 180px; position: relative; z-index: 10; animation: logoFloat 3s infinite ease-in-out; }
        .logo-aura {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
            width: 250px; height: 250px; background: radial-gradient(circle, var(--brand-purple) 0%, transparent 70%);
            opacity: 0.5; filter: blur(40px); animation: auraPulse 2s infinite alternate;
        }
        @keyframes logoFloat { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes auraPulse { from { opacity: 0.3; transform: translate(-50%, -50%) scale(0.8); } to { opacity: 0.6; transform: translate(-50%, -50%) scale(1.2); } }

        /* Headers */
        .top-announcement { background: var(--brand-purple); color: #fff; text-align: center; padding: 10px; font-weight: 700; font-size: 11px; letter-spacing: 2.5px; position: fixed; top: 0; width: 100%; z-index: 9000; text-transform: uppercase; }
        nav { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(30px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 75px; display: flex; align-items: center; justify-content: center; position: fixed; width: 100%; top: 36px; z-index: 8000; }
        .nav-content { width: 1400px; display: flex; justify-content: space-between; align-items: center; padding: 0 50px; }
        .nav-logo img { height: 42px; }

        /* Hero Clean Ken Burns */
        .hero { position: relative; width: 100%; height: 85vh; background: #000; overflow: hidden; z-index: 1000; margin-top: 111px; }
        .hero-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
        .hero-bg img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.65); animation: kenBurns 25s infinite alternate ease-in-out; }
        @keyframes kenBurns { 0% { transform: scale(1.1); } 100% { transform: scale(1); } }
        
        .hero-overlay { 
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2; 
            background: linear-gradient(90deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.4) 50%, transparent 100%); 
        }

        .hero-content { position: relative; z-index: 10; width: 1300px; margin: 0 auto; padding: 120px 80px; color: #fff; }
        .hero-content h1 { font-size: clamp(2.4rem, 6vw, 4.2rem); font-weight: 800; line-height: 1.1; margin-bottom: 25px; letter-spacing: -0.04em; }
        .hero-content p { font-size: 1.3rem; opacity: 0.9; margin-bottom: 50px; max-width: 600px; line-height: 1.6; }

        .btn-brand { background: var(--brand-purple); color: white; padding: 18px 45px; border-radius: 14px; font-size: 19px; font-weight: 700; text-decoration: none; display: inline-block; transition: 0.4s; }
        .btn-brand:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.3); }

        /* Sections */
        .pricing { padding: 120px 5%; background: #fff; position: relative; z-index: 2000; }
        .p-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px; max-width: 1300px; margin: 0 auto; }
        .p-card { background: #fff; padding: 60px 45px; border-radius: 30px; border: 1px solid #f0f0f0; transition: var(--transition); }
        .p-card:hover { border-color: var(--brand-purple); transform: translateY(-10px); box-shadow: 0 40px 80px rgba(0,0,0,0.05); }
        .p-card.featured { border: 2.5px solid var(--brand-purple); background: #fdfbff; }
        
        /* FAQ Section */
        .faq { padding: 120px 10%; background: #f9f9fb; }
        .faq-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 40px; max-width: 1200px; margin: 60px auto 0; }
        .faq-item { background: #fff; padding: 40px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
        .faq-item h4 { font-size: 22px; margin-bottom: 15px; font-weight: 800; color: var(--brand-purple); }
        .faq-item p { line-height: 1.7; color: #666; font-size: 16px; }

        .footer { background: #000; color: #fff; padding: 100px 10% 50px; }
        .f-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 60px; }

        .reveal { opacity: 0; transform: translateY(30px); transition: 1s var(--transition); }
        .reveal.visible { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>

    <div id="preloader">
        <div class="preloader-content">
            <div class="logo-aura"></div>
            <img src="assets/img/logo.png" class="preloader-logo" alt="CajaYa Official">
            <p style="color:#fff; margin-top:30px; letter-spacing:5px; font-size:10px; opacity:0.6; font-weight:800;">CALIDAD SIN COMPROMISO</p>
        </div>
    </div>

    <div class="top-announcement">🚀 EL POS Nº1 PARA MINIMARKETS — LIDERAZGO TECNOLÓGICO 2026 🚀</div>

    <nav id="navbar">
        <div class="nav-content">
            <a href="#" class="nav-logo"><img src="assets/img/logo.png" alt="CajaYa Official"></a>
            <div style="font-weight:800; font-size:11px; color:var(--brand-purple); letter-spacing:2px; text-transform:uppercase;">El Estándar POS en Chile</div>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-bg"><img src="banner1.png" alt="CajaYa Minimarket"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Tu Negocio Merece<br>Vender con Elegancia.</h1>
            <p>La tecnología que transforma tu minimarket. Rapidez absoluta, control total de inventario y cumplimiento SII 100% automático.</p>
            <a href="#planes" class="btn-brand">Ver Planes de Éxito</a>
        </div>
    </div>

    <section class="pricing" id="planes">
        <div class="p-grid">
            <div class="p-card reveal">
                <h4>PLAN MENSUAL</h4>
                <div class="p-price">$<?php echo $pMensual; ?><span>/mes</span></div>
                <ul style="list-style:none; margin-bottom:40px; font-size:16px; line-height:2.2;">
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> 1 Punto de Venta Full</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> Boletas SII Instantáneas</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> Soporte VIP WhatsApp</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=mensual" class="btn-p outline">Seleccionar</a>
            </div>
            <div class="p-card featured reveal">
                <h4>PLAN LIFETIME</h4>
                <div class="p-price">$<?php echo $pLifetime; ?></div>
                <p style="font-size:12px; color:#888; margin-top:-30px; margin-bottom:30px; font-weight:800;">TUYO PARA SIEMPRE. PAGO ÚNICO.</p>
                <ul style="list-style:none; margin-bottom:40px; font-size:16px; line-height:2.2;">
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> 3 Puntos de Venta Full</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> Boleta y Factura SII</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> Actualizaciones Eternas</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=lifetime" class="btn-p solid">Comprar Licencia</a>
            </div>
            <div class="p-card reveal">
                <h4>PLAN EMPRESA</h4>
                <div class="p-price">$<?php echo $pEmpresa; ?><span>/mes</span></div>
                <ul style="list-style:none; margin-bottom:40px; font-size:16px; line-height:2.2;">
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> Cajas Ilimitadas</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> Gestión Multi-Sucursal</li>
                    <li><i class="fa-solid fa-check" style="color:var(--brand-purple); margin-right:10px;"></i> Soporte 24/7 Crítico</li>
                </ul>
                <a href="/mercadopago/checkout.php?plan=empresa" class="btn-p outline">Contactar</a>
            </div>
        </div>
    </section>

    <section class="faq">
        <h2 style="text-align:center; font-size:42px; font-weight:800; margin-bottom:20px;">Preguntas Frecuentes</h2>
        <p style="text-align:center; color:#888; margin-bottom:60px;">Todo lo que necesitas saber sobre CajaYa</p>
        <div class="faq-grid">
            <div class="faq-item reveal">
                <h4>¿Es compatible con el SII?</h4>
                <p>Sí, CajaYa está certificado y se integra directamente con el Servicio de Impuestos Internos para emitir boletas y facturas de forma automática.</p>
            </div>
            <div class="faq-item reveal">
                <h4>¿Funciona sin Internet?</h4>
                <p>Nuestra tecnología Offline-First te permite seguir vendiendo aunque se caiga el internet. Los datos se sincronizan solos al volver la conexión.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="f-grid">
            <div class="f-col">
                <img src="assets/img/logo.png" style="height:45px; margin-bottom:30px; filter:brightness(0) invert(1);" alt="CajaYa Footer">
                <p style="opacity:0.4; line-height:1.8;">Digitalizando el corazón del comercio chileno con tecnología de elite.</p>
            </div>
            <div class="f-col">
                <h4>Producto</h4>
                <a href="#">Tecnología SII</a>
                <a href="#planes">Planes</a>
            </div>
            <div class="f-col">
                <h4>Ayuda</h4>
                <a href="#">Soporte</a>
                <a href="#">Contacto</a>
            </div>
        </div>
        <div style="margin-top:80px; opacity:0.2; text-align:center; font-size:13px;">&copy; 2026 CajaYa S.A. Hecho con Ingeniería Superior en Chile.</div>
    </footer>

    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const p = document.getElementById('preloader');
                p.style.opacity = '0';
                setTimeout(() => p.style.display = 'none', 1000);
            }, 2500);
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>
</html>
