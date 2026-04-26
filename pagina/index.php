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
    <title>CajaYa | Tu Negocio a otro nivel</title>
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

        .container { max-width: 1400px; margin: 0 auto; padding: 0 4rem; }

        /* HEADER */
        header { padding: 3rem 0; position: absolute; width: 100%; z-index: 100; display: flex; justify-content: space-between; align-items: center; }
        .nav-links a { color: #fff; text-decoration: none; font-weight: 800; font-size: 0.9rem; letter-spacing: 2px; text-transform: uppercase; }

        /* HERO FULL EDGE */
        .hero { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 8rem 0; }
        .hero-grid { display: grid; grid-template-columns: 1fr 1.3fr; gap: 5rem; align-items: center; width: 100%; }

        h1 { font-size: 6rem; font-weight: 900; letter-spacing: -5px; line-height: 0.85; margin-bottom: 2.5rem; text-transform: uppercase; }
        .btn-google { background: #fff; color: #000; padding: 1.5rem 3.5rem; border-radius: 100px; font-weight: 900; text-decoration: none; display: inline-flex; align-items: center; gap: 15px; font-size: 1.1rem; box-shadow: 0 10px 40px rgba(255,255,255,0.2); transition: 0.4s; text-transform: uppercase; }
        .btn-google:hover { transform: scale(1.05); box-shadow: 0 20px 60px rgba(255,255,255,0.4); }

        .app-frame { background: #fff; padding: 1.5rem; border-radius: 50px; box-shadow: 0 50px 100px rgba(168,85,247,0.3); transform: perspective(1000px) rotateY(-10deg); }
        .app-frame img { width: 100%; border-radius: 30px; display: block; }

        /* SECCIÓN CARDS BENEFICIOS */
        .features-section { padding: 120px 0; background: #ffffff; color: #333; position: relative; z-index: 1; }
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem; margin-top: 4rem; }
        .f-card { background: #fff; border-radius: 40px; padding: 3rem; text-align: center; box-shadow: 0 30px 60px rgba(0,0,0,0.08); transition: 0.3s; border: 1px solid #eee; }
        .f-card:hover { transform: translateY(-10px); }
        .f-card img { width: 100%; height: 200px; object-fit: contain; margin-bottom: 2rem; }
        .f-card h3 { font-size: 1.6rem; font-weight: 900; margin-bottom: 1rem; color: #000; }
        .f-card p { font-size: 1rem; line-height: 1.6; color: #555; }

        /* SECCIÓN PRECIOS */
        .pricing-section { padding: 120px 0; background: transparent; }
        .price-box { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); padding: 4rem 3rem; border-radius: 40px; text-align: center; backdrop-filter: blur(10px); }
        .price-box.featured { border: 2px solid var(--primary); background: rgba(168, 85, 247, 0.05); }

        .btn-whatsapp { position: fixed; bottom: 30px; right: 30px; width: 65px; height: 65px; background: #25d366; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 35px; box-shadow: 0 10px 30px rgba(37,211,102,0.4); z-index: 1000; text-decoration: none; transition: 0.3s; }

        @media (max-width: 1200px) { h1 { font-size: 4rem; } .hero-grid { grid-template-columns: 1fr; text-align: center; } .app-frame { transform: none; } }
    </style>
</head>
<body>
    <canvas id="star-field"></canvas>

    <header class="container">
        <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 50px;">
        <nav class="nav-links">
            <a href="#nosotros">NOSOTROS</a>
        </nav>
    </header>

    <main>
        <section class="container hero">
            <div class="hero-grid">
                <div>
                    <span style="color: var(--primary); font-weight: 900; letter-spacing: 5px; font-size: 0.8rem; margin-bottom: 2rem; display: block;">CHILEAN TECH POS</span>
                    <h1>TODO EL<br>CONTROL<br><span style="color: var(--primary)">EN TU MANO.</span></h1>
                    <p style="font-size: 1.4rem; color: rgba(255,255,255,0.7); margin-bottom: 3.5rem;">Vende, emite boletas y controla tu stock con la tecnología más avanzada. 100% offline.</p>
                    <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-google">
                        <img src="https://www.gstatic.com/images/branding/product/2x/googleg_48dp.png" alt="G" style="width: 25px;">
                        ACCESO DEMO VÍA GOOGLE
                    </a>
                </div>
                <div class="app-frame">
                    <img src="assets/cajaya_pos_mockup.png" alt="CajaYa App">
                </div>
            </div>
        </section>

        <section class="features-section" id="nosotros">
            <div class="container">
                <div style="text-align: center;">
                    <h2 style="font-size: 3.5rem; font-weight: 900; text-transform: uppercase;">Potencia tu crecimiento</h2>
                </div>
                <div class="features-grid">
                    <div class="f-card">
                        <img src="assets/cajaya_dashboard_mockup.png" alt="Reportes">
                        <h3>Reportes actualizados</h3>
                        <p>Informes de tu negocio en tiempo real. Revisa ventas desde tu celular o PC y mantente siempre informado.</p>
                    </div>
                    <div class="f-card">
                        <img src="assets/cajaya_pos_mockup.png" alt="POS">
                        <h3>Punto de Ventas rápido</h3>
                        <p>Vende de manera profesional con tres clics. Olvídate de los errores manuales y de las filas en la caja.</p>
                    </div>
                    <div class="f-card">
                        <div style="height: 200px; display: flex; align-items: center; justify-content: center; font-size: 5rem; color: var(--primary);"><i class="fa-solid fa-boxes-stacked"></i></div>
                        <h3>Controla tu inventario</h3>
                        <p>Inventario sincronizado minuto a minuto. Sabrás qué productos se agotan y evitarás quiebres de stock.</p>
                    </div>
                    <div class="f-card">
                        <div style="height: 200px; display: flex; align-items: center; justify-content: center; font-size: 5rem; color: var(--primary);"><i class="fa-solid fa-users-gear"></i></div>
                        <h3>Usuarios ilimitados</h3>
                        <p>Crea todos los perfiles que necesites sin costo adicional. Personaliza permisos para cada colaborador.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="container pricing-section">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem;">
                <div class="price-box">
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">ACCESO DEMO</h3>
                    <div style="font-size: 4rem; font-weight: 900; margin-bottom: 2rem;">$0</div>
                    <p style="color: rgba(255,255,255,0.5); margin-bottom: 3rem;">Prueba el poder de CajaYa sin costo hoy mismo.</p>
                    <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-google" style="width: 100%; justify-content: center;">BAJAR AHORA</a>
                </div>
                <div class="price-box featured">
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">LICENCIA FULL</h3>
                    <div style="font-size: 3rem; font-weight: 900; margin-bottom: 2rem;">CONSULTAR</div>
                    <p style="color: rgba(255,255,255,0.5); margin-bottom: 3rem;">Sincronización ilimitada, boleta SII y soporte prioritario.</p>
                    <a href="https://wa.me/56936316154" class="btn-google" style="width: 100%; justify-content: center; background: var(--primary); color: #fff; border: none;">PEDIR LICENCIA</a>
                </div>
            </div>
        </section>
    </main>

    <a href="https://wa.me/56936316154" class="btn-whatsapp" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>

    <footer style="padding: 4rem 0; text-align: center; opacity: 0.3; font-size: 0.8rem;">
        &copy; 2026 CAJAYA CL | EL FUTURO DEL POS
    </footer>

    <script>
        const canvas = document.getElementById('star-field');
        const ctx = canvas.getContext('2d');
        let stars = [];
        function init() { canvas.width = window.innerWidth; canvas.height = window.innerHeight; stars = []; for(let i=0; i<400; i++) stars.push({ x:Math.random()*canvas.width, y:Math.random()*canvas.height, size:Math.random()*1.5, speed:Math.random()*0.3 }); }
        function animate() { ctx.clearRect(0,0,canvas.width,canvas.height); ctx.fillStyle="#fff"; stars.forEach(s => { ctx.beginPath(); ctx.arc(s.x, s.y, s.size, 0, Math.PI*2); ctx.fill(); s.y += s.speed; if(s.y > canvas.height) s.y = 0; }); requestAnimationFrame(animate); }
        window.addEventListener('resize', init); init(); animate();
    </script>
</body>
</html>
