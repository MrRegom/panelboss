<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajaYa - Apple Style POS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --apple-blue: #0071E3;
            --apple-gray: #1D1D1F;
            --apple-silver: #F5F5F7;
            --apple-muted: #86868B;
            --white: #FFFFFF;
            --transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--white);
            color: var(--apple-gray);
            font-family: 'Inter', -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* --- NAVIGATION --- */
        nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 2000;
        }

        .nav-content { width: 1024px; display: flex; justify-content: space-between; padding: 0 20px; }
        .logo { font-weight: 700; font-size: 1.2rem; color: var(--apple-gray); text-decoration: none; letter-spacing: -0.5px; }
        .nav-links a { color: var(--apple-gray); text-decoration: none; font-size: 12px; margin-left: 30px; opacity: 0.8; font-weight: 400; transition: 0.3s; }
        .nav-links a:hover { opacity: 1; }

        /* --- HERO SECTION (SPECTACULAR) --- */
        .hero {
            padding: 160px 20px 80px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .hero h1 {
            font-size: clamp(3rem, 10vw, 5.5rem);
            font-weight: 700;
            letter-spacing: -0.03em;
            line-height: 1.05;
            margin-bottom: 20px;
        }

        .hero h2 {
            font-size: clamp(1.5rem, 4vw, 2.8rem);
            color: var(--apple-blue);
            font-weight: 600;
            margin-bottom: 40px;
        }

        .hero p {
            font-size: 21px;
            color: var(--apple-muted);
            max-width: 700px;
            margin-bottom: 50px;
            line-height: 1.4;
        }

        .cta-group { display: flex; gap: 20px; align-items: center; }
        .btn-buy {
            background: var(--apple-blue);
            color: white;
            padding: 14px 28px;
            border-radius: 980px;
            font-size: 17px;
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
        }
        .btn-buy:hover { transform: scale(1.05); background: #0077ED; }
        
        .btn-learn { color: var(--apple-blue); text-decoration: none; font-size: 19px; font-weight: 500; }
        .btn-learn:after { content: ' >'; }
        .btn-learn:hover { text-decoration: underline; }

        /* --- IMAC MOCKUP EFFECT --- */
        .mockup-container {
            width: 100%;
            max-width: 1100px;
            margin: 80px auto 0;
            padding: 0 20px;
            perspective: 2000px;
        }

        .imac-frame {
            background: #000;
            padding: 2.5%;
            border-radius: 30px 30px 0 0;
            box-shadow: 0 50px 100px rgba(0,0,0,0.1);
            transform: rotateX(5deg);
            transition: var(--transition);
        }

        .imac-screen {
            background: var(--apple-silver);
            aspect-ratio: 16/9;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .imac-screen img { width: 100%; height: 100%; object-fit: cover; }

        /* --- FEATURES (APPLE GRID) --- */
        .features { background: var(--apple-silver); padding: 100px 20px; text-align: center; }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 20px;
            max-width: 1080px;
            margin: 0 auto;
        }

        .feature-card {
            background: var(--white);
            border-radius: 28px;
            padding: 50px;
            text-align: left;
            transition: var(--transition);
            overflow: hidden;
            position: relative;
        }

        .feature-card:hover { transform: scale(1.01); }
        .feature-card h3 { font-size: 28px; font-weight: 600; margin-bottom: 15px; }
        .feature-card p { font-size: 17px; color: var(--apple-muted); line-height: 1.5; }

        /* --- PRICING (LUXURY) --- */
        .pricing { padding: 120px 20px; text-align: center; }
        .price-card {
            max-width: 500px;
            margin: 0 auto;
            background: var(--white);
            border: 1px solid var(--apple-silver);
            border-radius: 30px;
            padding: 60px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.03);
        }
        .price-tag { font-size: 64px; font-weight: 700; margin: 20px 0; }
        .price-label { color: var(--apple-muted); text-transform: uppercase; letter-spacing: 2px; font-size: 12px; font-weight: 700; }

        @media (max-width: 768px) {
            .feature-grid { grid-template-columns: 1fr; }
            .hero h1 { font-size: 3.5rem; }
        }
    </style>
</head>
<body>

    <nav>
        <div class="nav-content">
            <a href="#" class="logo">CajaYa</a>
            <div class="nav-links">
                <a href="#funciona">Cómo funciona</a>
                <a href="#planes">Planes</a>
                <a href="/mercadopago/checkout.php" class="btn-buy" style="padding: 6px 15px; font-size: 12px;">Comprar</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <h1>Tu negocio vende más.</h1>
        <h2>Tú trabajas menos.</h2>
        <p>Controla tus ventas, stock y facturación con el sistema POS más rápido y elegante de Chile. 100% Offline y Certificado SII 2026.</p>
        <div class="cta-group">
            <a href="/mercadopago/checkout.php" class="btn-buy">Empezar ahora</a>
            <a href="https://wa.me/56912345678" class="btn-learn">Consultar por WhatsApp</a>
        </div>

        <div class="mockup-container">
            <div class="imac-frame">
                <div class="imac-screen">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=1000" alt="Dashboard CajaYa">
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="funciona">
        <div class="feature-grid">
            <div class="feature-card">
                <h3>Dashboard Inteligente</h3>
                <p>Mira tus ganancias reales al instante. Gráficos de ventas y alertas de stock bajo automáticas.</p>
                <div style="margin-top: 30px; height: 200px; background: var(--apple-silver); border-radius: 15px;"></div>
            </div>
            <div class="feature-card">
                <h3>Ventas Ultra-Rápidas</h3>
                <p>Vende 100% Offline. Compatible con gavetas, scanners e impresoras térmicas de 58/80mm.</p>
                <div style="margin-top: 30px; height: 200px; background: var(--apple-silver); border-radius: 15px;"></div>
            </div>
        </div>
    </section>

    <section class="pricing" id="planes">
        <div class="price-card">
            <span class="price-label">Oferta Limitada</span>
            <div class="price-tag">$180.000</div>
            <p style="margin-bottom: 40px;">Licencia Perpetua. Sin mensualidades. Actualizaciones 2026 incluidas.</p>
            <a href="/mercadopago/checkout.php" class="btn-buy" style="display: block; width: 100%;">Comprar Licencia Ahora</a>
        </div>
    </section>

</body>
</html>
