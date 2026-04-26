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
    <title>CajaYa | El Futuro del POS</title>
    <link rel="stylesheet" href="assets/css/modern.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #c084fc;
            --bg: #000000;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { background: var(--bg); color: #fff; font-family: 'Outfit', sans-serif; overflow-x: hidden; }

        #star-field { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; }

        /* HEADER TOTALMENTE EXTENDIDO */
        header { 
            padding: 2rem 4rem; 
            position: absolute; 
            width: 100%; 
            z-index: 100; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }
        .logo-img { height: 70px; }
        .nav-links a { 
            color: #fff; 
            text-decoration: none; 
            font-weight: 800; 
            font-size: 1rem; 
            letter-spacing: 3px; 
            text-transform: uppercase; 
        }

        /* HERO FULL WIDTH */
        .hero { 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            padding: 0 4rem;
        }
        .hero-grid { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 2rem; 
            align-items: center; 
            width: 100%; 
        }

        h1 { font-size: 6rem; font-weight: 900; letter-spacing: -5px; line-height: 0.8; margin-bottom: 2rem; text-transform: uppercase; }
        
        /* EFECTO LED SII */
        @keyframes ledPulse {
            0% { box-shadow: 0 0 5px var(--primary); border-color: rgba(192, 132, 252, 0.5); }
            50% { box-shadow: 0 0 25px var(--primary); border-color: rgba(192, 132, 252, 1); }
            100% { box-shadow: 0 0 5px var(--primary); border-color: rgba(192, 132, 252, 0.5); }
        }

        .badge-sii-led {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 0.8rem 1.8rem;
            border-radius: 100px;
            background: rgba(0,0,0,0.8);
            border: 2px solid var(--primary);
            color: var(--primary);
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 2.5rem;
            animation: ledPulse 3s infinite ease-in-out;
        }

        .btn-google { 
            background: #fff; 
            color: #000; 
            padding: 1.5rem 4rem; 
            border-radius: 100px; 
            font-weight: 900; 
            text-decoration: none; 
            display: inline-flex; 
            align-items: center; 
            gap: 15px; 
            font-size: 1.2rem; 
            box-shadow: 0 10px 40px rgba(255,255,255,0.2); 
            transition: 0.4s; 
            text-transform: uppercase; 
        }
        .btn-google:hover { transform: scale(1.05); }

        /* IMAGEN PURA SIN RECTANGULOS */
        .app-pure {
            width: 100%;
            transform: perspective(1000px) rotateY(-12deg);
            filter: drop-shadow(0 0 60px rgba(192, 132, 252, 0.5));
            transition: 0.6s;
        }
        .app-pure:hover { transform: perspective(1000px) rotateY(0deg) scale(1.05); }

        /* SECCIONES INFERIORES */
        .content-section { padding: 120px 4rem; }
        .f-card { background: #fff; border-radius: 40px; padding: 3rem; text-align: center; color: #333; box-shadow: 0 30px 60px rgba(0,0,0,0.1); }
        .price-box { background: rgba(255,255,255,0.02); padding: 5rem 3rem; border-radius: 50px; text-align: center; border: 1px solid rgba(255,255,255,0.05); }
        .price-box.featured { border: 2px solid var(--primary); background: rgba(168, 85, 247, 0.05); }

        @media (max-width: 1024px) {
            header, .hero, .content-section { padding: 2rem; }
            .hero-grid { grid-template-columns: 1fr; text-align: center; }
            h1 { font-size: 4rem; }
        }
    </style>
</head>
<body>
    <canvas id="star-field"></canvas>

    <header>
        <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" class="logo-img">
        <nav class="nav-links">
            <a href="#nosotros">NOSOTROS</a>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-grid">
                <div>
                    <div class="badge-sii-led">
                        <i class="fa-solid fa-bolt"></i> SII INTEGRADO - BOLETA ELECTRÓNICA
                    </div>
                    <h1>TODO EL<br>CONTROL<br><span style="color: var(--primary)">EN TU MANO.</span></h1>
                    <p style="font-size: 1.6rem; color: rgba(255,255,255,0.6); margin-bottom: 4rem;">Gestión profesional, boleta automática y stock en tiempo real. 100% Offline.</p>
                    <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-google">
                        <img src="https://www.gstatic.com/images/branding/product/2x/googleg_48dp.png" alt="G" style="width: 25px;">
                        ACCESO A DEMO
                    </a>
                </div>
                <div>
                    <img src="assets/cajaya_pos_mockup.png" alt="CajaYa App" class="app-pure">
                </div>
            </div>
        </section>

        <section class="content-section" id="nosotros" style="background: #fff; border-radius: 80px 80px 0 0;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 3rem;">
                <div class="f-card">
                    <img src="assets/cajaya_dashboard_mockup.png" alt="Reportes" style="width: 100%; margin-bottom: 2rem;">
                    <h3>Reportes inteligentes</h3>
                    <p>Decide con datos reales, donde quieras y cuando quieras.</p>
                </div>
                <div class="f-card">
                    <img src="assets/cajaya_pos_mockup.png" alt="Ventas" style="width: 100%; margin-bottom: 2rem;">
                    <h3>Ventas ultra rápidas</h3>
                    <p>Atiende a tus clientes en segundos y sin errores.</p>
                </div>
                <div class="f-card" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-boxes-stacked" style="font-size: 5rem; color: var(--primary); margin-bottom: 2rem;"></i>
                    <h3>Stock Automático</h3>
                    <p>Sincronización instantánea de inventario en todas tus sucursales.</p>
                </div>
            </div>
        </section>

        <section class="content-section">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 4rem;">
                <div class="price-box">
                    <h3 style="font-size: 1.8rem; margin-bottom: 1rem;">DEMO GRATUITA</h3>
                    <div style="font-size: 5rem; font-weight: 900; margin-bottom: 2rem;">$0</div>
                    <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-google" style="width: 100%; justify-content: center;">BAJAR AHORA</a>
                </div>
                <div class="price-box featured">
                    <h3 style="font-size: 1.8rem; margin-bottom: 1rem;">LICENCIA FULL</h3>
                    <div style="font-size: 4rem; font-weight: 900; margin-bottom: 2rem;">CONSULTAR</div>
                    <a href="https://wa.me/56936316154" class="btn-google" style="width: 100%; justify-content: center; background: var(--primary); color: #fff; border: none;">PEDIR LICENCIA</a>
                </div>
            </div>
        </section>
    </main>

    <footer style="padding: 4rem; text-align: center; opacity: 0.2;">&copy; 2026 CAJAYA CL</footer>

    <script>
        const canvas = document.getElementById('star-field');
        const ctx = canvas.getContext('2d');
        let stars = [];
        function init() { canvas.width = window.innerWidth; canvas.height = window.innerHeight; stars = []; for(let i=0; i<500; i++) stars.push({ x:Math.random()*canvas.width, y:Math.random()*canvas.height, size:Math.random()*2, speed:Math.random()*0.5 }); }
        function animate() { ctx.clearRect(0,0,canvas.width,canvas.height); ctx.fillStyle="#fff"; stars.forEach(s => { ctx.beginPath(); ctx.arc(s.x, s.y, s.size, 0, Math.PI*2); ctx.fill(); s.y += s.speed; if(s.y > canvas.height) s.y = 0; }); requestAnimationFrame(animate); }
        window.addEventListener('resize', init); init(); animate();
    </script>
</body>
</html>
