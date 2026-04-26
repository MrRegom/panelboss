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
            --primary-bright: #e9d5ff;
            --bg: #000000;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            background: var(--bg); 
            color: #fff; 
            font-family: 'Outfit', sans-serif; 
            overflow-x: hidden;
            line-height: 1.4;
        }

        /* FONDO ESTRELLAS ANTIGRAVITY */
        #star-field {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: radial-gradient(circle at center, #0a051a 0%, #000 100%);
        }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }

        /* HEADER PRO */
        header {
            padding: 2.5rem 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: absolute;
            width: 100%;
            z-index: 100;
        }

        .btn-contact {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
            padding: 0.8rem 1.8rem;
            border-radius: 100px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            backdrop-filter: blur(10px);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }
        .btn-contact:hover {
            background: #fff;
            color: #000;
            border-color: #fff;
        }

        /* HERO ULTRA CONTRASTE */
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 100vh;
            padding-top: 5rem;
            gap: 4rem;
        }

        .hero-content { flex: 1; }
        
        h1 { 
            font-size: 6rem; 
            font-weight: 900; 
            letter-spacing: -5px; 
            line-height: 0.8;
            margin-bottom: 2.5rem;
            text-transform: uppercase;
            text-shadow: 0 0 30px rgba(192, 132, 252, 0.3);
        }

        .p-main {
            font-size: 1.4rem;
            color: rgba(255,255,255,0.7);
            margin-bottom: 3.5rem;
            max-width: 500px;
        }

        .btn-demo-smart {
            background: #fff;
            color: #000;
            padding: 1.4rem 3rem;
            border-radius: 100px;
            font-weight: 900;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 15px;
            font-size: 1.1rem;
            box-shadow: 0 10px 40px rgba(255,255,255,0.2);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-transform: uppercase;
        }
        .btn-demo-smart:hover {
            transform: scale(1.05) translateY(-5px);
            box-shadow: 0 20px 60px rgba(255,255,255,0.4);
        }

        /* IMAGEN APP PRO */
        .hero-image {
            flex: 1.2;
            position: relative;
        }
        .app-frame {
            background: #fff;
            padding: 1rem;
            border-radius: 40px;
            box-shadow: 0 50px 100px rgba(0,0,0,0.9), 0 0 50px rgba(192, 132, 252, 0.2);
            transform: perspective(1000px) rotateY(-15deg) rotateX(5deg);
            transition: 0.8s;
        }
        .app-frame:hover { transform: perspective(1000px) rotateY(0deg) rotateX(0deg) scale(1.02); }
        .app-frame img { width: 100%; border-radius: 25px; display: block; }

        /* PRECIOS COMERCIALES */
        .pricing { padding: 120px 0; background: rgba(255,255,255,0.01); }
        .price-card {
            background: #080808;
            border: 1px solid rgba(255,255,255,0.05);
            padding: 4rem 3rem;
            border-radius: 40px;
            text-align: center;
            transition: 0.4s;
        }
        .price-card:hover {
            border-color: var(--primary);
            background: #0a0a0a;
            transform: translateY(-10px);
        }
        .price-card.featured {
            background: linear-gradient(145deg, #0f0f0f 0%, #000 100%);
            border: 2px solid var(--primary);
        }

        @media (max-width: 992px) {
            .hero { flex-direction: column; text-align: center; padding-top: 10rem; }
            h1 { font-size: 4rem; letter-spacing: -2px; }
            .app-frame { transform: none; margin-top: 3rem; }
        }
    </style>
</head>
<body>
    <canvas id="star-field"></canvas>

    <header class="container">
        <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 50px;">
        <a href="https://wa.me/56936316154" class="btn-contact">¿NECESITAS AYUDA?</a>
    </header>

    <main>
        <section class="container hero">
            <div class="hero-content">
                <span style="color: var(--primary); font-weight: 800; letter-spacing: 3px; font-size: 0.9rem; margin-bottom: 1.5rem; display: block;">PRO-TECH POINT OF SALE</span>
                <h1>TODO EL<br>CONTROL<br><span style="color: var(--primary)">EN TU MANO.</span></h1>
                <p class="p-main">
                    Vende, emite boletas y controla tu stock con la tecnología más avanzada de Chile. Funciona 100% offline.
                </p>
                <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-demo-smart">
                    <img src="https://www.gstatic.com/images/branding/product/2x/googleg_48dp.png" alt="G" style="width: 24px;">
                    ACCESO DEMO VÍA GOOGLE
                </a>
            </div>
            <div class="hero-image">
                <div class="app-frame">
                    <img src="assets/cajaya_pos_mockup.png" alt="CajaYa POS">
                </div>
            </div>
        </section>

        <section class="container pricing">
            <h2 style="text-align: center; font-size: 3rem; font-weight: 900; margin-bottom: 5rem; text-transform: uppercase;">Elige tu camino</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                <div class="price-card">
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">VERSION DEMO</h3>
                    <div style="font-size: 4rem; font-weight: 900; margin-bottom: 2rem;">$0</div>
                    <p style="color: rgba(255,255,255,0.5); margin-bottom: 3rem;">Prueba todas las capacidades del sistema sin costo inicial.</p>
                    <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-demo-smart" style="width: 100%; justify-content: center; padding: 1.2rem;">DESCARGAR AHORA</a>
                </div>
                <div class="price-card featured">
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">LICENCIA FULL</h3>
                    <div style="font-size: 3rem; font-weight: 900; margin-bottom: 2rem;">CONSULTAR</div>
                    <p style="color: rgba(255,255,255,0.5); margin-bottom: 3rem;">Sincronización ilimitada, boleta SII y soporte prioritario.</p>
                    <a href="https://wa.me/56936316154" class="btn-demo-smart" style="width: 100%; justify-content: center; padding: 1.2rem; background: var(--primary); color: #fff;">PEDIR LICENCIA</a>
                </div>
            </div>
        </section>
    </main>

    <footer style="padding: 6rem 0; text-align: center; border-top: 1px solid rgba(255,255,255,0.05);">
        <p style="color: rgba(255,255,255,0.3); font-size: 0.8rem; letter-spacing: 2px;">&copy; 2026 CAJAYA CL | LIDERANDO LA INNOVACIÓN POS</p>
    </footer>

    <script>
        // MOTOR DE ESTRELLAS PRO (Antigravity Style)
        const canvas = document.getElementById('star-field');
        const ctx = canvas.getContext('2d');
        let stars = [];
        let mouse = { x: 0, y: 0 };

        function init() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            stars = [];
            for(let i = 0; i < 400; i++) {
                stars.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    size: Math.random() * 1.5,
                    speed: Math.random() * 0.3 + 0.1,
                    opacity: Math.random()
                });
            }
        }

        window.addEventListener('resize', init);
        window.addEventListener('mousemove', (e) => {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        });

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = "#fff";
            stars.forEach(s => {
                ctx.globalAlpha = s.opacity;
                ctx.beginPath();
                ctx.arc(s.x, s.y, s.size, 0, Math.PI * 2);
                ctx.fill();
                
                s.y += s.speed;
                // Reacción sutil al mouse
                let dx = mouse.x - s.x;
                let dy = mouse.y - s.y;
                let dist = Math.sqrt(dx*dx + dy*dy);
                if(dist < 200) {
                    s.x -= dx * 0.01;
                    s.y -= dy * 0.01;
                }

                if(s.y > canvas.height) s.y = 0;
            });
            requestAnimationFrame(animate);
        }

        init();
        animate();
    </script>
</body>
</html>
