<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajaYa - Control Total para tu Negocio | POS SII 2026</title>
    
    <meta name="description" content="El sistema POS líder para Pymes chilenas. Certificado SII 2026, 100% Offline y Plan Lifetime. Prueba gratis hoy.">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #7c3aed;
            --primary-light: #a78bfa;
            --bg-dark: #07070a;
            --bg-card: #0d0d14;
            --text-main: #f1f5f9;
            --text-dim: #94a3b8;
            --success: #10b981;
            --border: rgba(124, 58, 237, 0.15);
            --gradient: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            background-color: var(--bg-dark);
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(124, 58, 237, 0.1) 0%, transparent 35%),
                radial-gradient(circle at 100% 100%, rgba(79, 70, 229, 0.1) 0%, transparent 35%);
            color: var(--text-main);
            font-family: 'Plus Jakarta Sans', sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 30px; }

        /* --- SALES UNIVERSE --- */
        .universe { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: -1; opacity: 0.25; }
        .symbol { position: absolute; color: var(--primary-light); font-family: 'Outfit'; font-weight: 900; animation: float linear infinite; }
        @keyframes float { 0% { transform: translateY(105vh) rotate(0deg); opacity: 0; } 10% { opacity: 0.3; } 90% { opacity: 0.3; } 100% { transform: translateY(-5vh) rotate(360deg); opacity: 0; } }

        /* --- TOP BANNER (MORADO) --- */
        .top-banner {
            background: linear-gradient(90deg, #4c1d95, #7c3aed, #4c1d95);
            background-size: 200% auto;
            color: #fff; text-align: center; padding: 12px 0; font-size: 0.85rem; font-weight: 700;
            position: sticky; top: 0; z-index: 1500; border-bottom: 1px solid rgba(255,255,255,0.1);
            animation: move-bg 4s linear infinite;
        }
        @keyframes move-bg { 0% { background-position: 0% center; } 100% { background-position: 200% center; } }

        /* --- HEADER --- */
        header {
            padding: 20px 0; background: rgba(7, 7, 10, 0.85); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border); position: sticky; top: 43px; z-index: 1000;
        }
        .header-flex { display: flex; justify-content: space-between; align-items: center; }
        
        .logo-box { position: relative; height: 42px; width: 135px; }
        .logo-img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url('assets/img/logo.png') no-repeat; background-size: contain; }
        .logo-white { filter: brightness(0) invert(1); clip-path: inset(0 57% 0 0); z-index: 2; }

        .btn-main {
            background: var(--gradient); color: #fff; padding: 12px 28px; border-radius: 14px;
            font-weight: 700; text-decoration: none; border: none; cursor: pointer;
            box-shadow: 0 10px 20px rgba(124, 58, 237, 0.3); transition: 0.3s;
            display: inline-flex; align-items: center; gap: 10px; font-size: 0.95rem;
        }
        .btn-main:hover { transform: translateY(-2px); box-shadow: 0 15px 30px rgba(124, 58, 237, 0.5); }

        /* --- HERO --- */
        .hero { padding: 100px 0 60px; }
        .hero-title { font-size: 5rem; font-weight: 800; font-family: 'Outfit'; line-height: 1; letter-spacing: -3px; margin-bottom: 30px; }
        .hero-title span { color: var(--primary-light); }
        .hero-desc { font-size: 1.25rem; color: var(--text-dim); max-width: 650px; margin-bottom: 45px; }

        /* --- SOCIAL PROOF --- */
        .social-proof { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-top: 60px; }
        .testimonial { background: var(--bg-card); padding: 35px; border-radius: 24px; border: 1px solid var(--border); transition: 0.3s; }
        .testimonial:hover { border-color: var(--primary); transform: translateY(-5px); }
        .testimonial p { font-size: 0.95rem; font-style: italic; color: var(--text-main); margin-bottom: 25px; line-height: 1.7; }
        .user-meta { display: flex; align-items: center; gap: 12px; }
        .avatar { width: 45px; height: 45px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 800; }

        /* --- FEATURES / MOCKUPS --- */
        .feature-block { padding: 100px 0; }
        .feature-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
        .mockup-frame { background: var(--bg-card); padding: 15px; border-radius: 20px; border: 1px solid var(--border); box-shadow: 0 30px 60px rgba(0,0,0,0.6); }
        .mockup-frame img { width: 100%; border-radius: 12px; display: block; }
        .feature-content h2 { font-size: 2.8rem; margin-bottom: 25px; font-family: 'Outfit'; }
        .feature-list { list-style: none; margin-top: 30px; }
        .feature-list li { display: flex; align-items: center; gap: 12px; margin-bottom: 15px; font-size: 1.1rem; }
        .feature-list i { color: var(--success); }

        /* --- COMPARISON TABLE --- */
        .table-container { margin: 80px 0; overflow-x: auto; }
        .pro-table { width: 100%; border-collapse: separate; border-spacing: 0; background: var(--bg-card); border-radius: 30px; overflow: hidden; border: 1px solid var(--border); }
        .pro-table th, .pro-table td { padding: 25px 40px; text-align: center; border-bottom: 1px solid var(--border); }
        .pro-table th { background: rgba(124, 58, 237, 0.05); font-family: 'Outfit'; font-size: 1.2rem; }
        .pro-table .feat-col { text-align: left; font-weight: 600; width: 40%; }
        .pro-table .cajaya-highlight { background: rgba(124, 58, 237, 0.1); font-weight: 800; color: #fff; border-left: 1px solid var(--border); border-right: 1px solid var(--border); }
        
        /* --- PRICING --- */
        .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 35px; }
        .plan-card { background: var(--bg-card); padding: 60px 45px; border-radius: 32px; border: 1px solid var(--border); text-align: center; position: relative; transition: 0.3s; display: flex; flex-direction: column; }
        .plan-card.popular { border-color: var(--primary); transform: scale(1.05); z-index: 10; box-shadow: 0 20px 50px rgba(124, 58, 237, 0.15); }
        .plan-price { font-size: 3.5rem; font-weight: 900; margin: 25px 0; font-family: 'Outfit'; }
        .plan-price span { font-size: 1rem; color: var(--text-dim); font-weight: 400; }
        .plan-features { list-style: none; text-align: left; margin: 35px 0; flex-grow: 1; }
        .plan-features li { margin-bottom: 15px; font-size: 0.95rem; display: flex; align-items: center; gap: 12px; }
        .plan-features i { color: var(--success); }

        /* --- RESPONSIVE --- */
        @media (max-width: 992px) {
            .hero-title { font-size: 3.5rem; text-align: center; }
            .hero-desc { text-align: center; margin: 0 auto 40px; }
            .header-flex { flex-direction: column; gap: 20px; }
            .feature-grid { grid-template-columns: 1fr; text-align: center; }
            .feature-list { display: inline-block; text-align: left; }
            .social-proof { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="universe" id="universe"></div>

    <div class="top-banner">
        🚀 OFERTA INSTALACIÓN GRATIS: Finaliza en <span id="timer">02:45:12</span>. (Solo 3 cupos disponibles hoy)
    </div>

    <header>
        <div class="container header-flex">
            <a href="#hero" class="logo-box">
                <div class="logo-img"></div>
                <div class="logo-img logo-white"></div>
            </a>
            <nav style="display: flex; gap: 40px; align-items: center;">
                <a href="#demo" style="color: var(--text-dim); text-decoration: none; font-weight: 600;">Cómo funciona</a>
                <a href="#precios" style="color: var(--text-dim); text-decoration: none; font-weight: 600;">Planes</a>
                <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-main" style="background: transparent; border: 1px solid var(--primary); padding: 8px 20px;">Iniciar Sesión</a>
            </nav>
            <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-main">Prueba Gratis 30 Días <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </header>

    <section id="hero" class="hero container">
        <div style="max-width: 900px; margin: 0 auto; text-align: center;">
            <h1 class="hero-title">Tu negocio vende más. <br> <span>Tú trabajas menos.</span></h1>
            <p class="hero-desc" style="margin: 0 auto 45px;">Controla tus ventas, stock y facturación con el sistema POS más rápido y confiable de Chile. 100% Offline y Certificado SII 2026.</p>
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-main" style="padding: 20px 45px; font-size: 1.2rem;">Empezar mi Prueba Gratis</a>
                <a href="https://wa.me/56959764771" style="color: #fff; text-decoration: none; font-weight: 700; padding: 18px 30px; border: 1px solid var(--border); border-radius: 14px; display: inline-flex; align-items: center; gap: 10px;">Consultar por WhatsApp <i class="fa-brands fa-whatsapp" style="color: #22c55e;"></i></a>
            </div>
            
            <div style="display: flex; gap: 40px; justify-content: center; margin-top: 60px; opacity: 0.6;">
                <div style="display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-shield-check" style="color: var(--success);"></i> SII Certificado 2026</div>
                <div style="display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-star" style="color: #fbbf24;"></i> +400 Negocios Felices</div>
                <div style="display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-rotate" style="color: var(--primary-light);"></i> 30 Días Garantizados</div>
            </div>
        </div>

        <div class="social-proof">
            <div class="testimonial">
                <p>"El cierre de caja pasó de ser un dolor de cabeza a un clic. La boleta electrónica vuela."</p>
                <div class="user-meta">
                    <div class="avatar">R</div>
                    <div><strong>Roberto M.</strong><br><span style="color: var(--text-dim); font-size: 0.8rem;">Dueño de Minimarket</span></div>
                </div>
            </div>
            <div class="testimonial" style="border-color: var(--primary);">
                <p>"El Plan Lifetime es la mejor inversión. Un solo pago y te olvidas de las cuotas para siempre."</p>
                <div class="user-meta">
                    <div class="avatar">S</div>
                    <div><strong>Sandra P.</strong><br><span style="color: var(--text-dim); font-size: 0.8rem;">Dueña de Botillería</span></div>
                </div>
            </div>
            <div class="testimonial">
                <p>"Incluso cuando se corta el internet en el local, el sistema no se detiene. Muy confiable."</p>
                <div class="user-meta">
                    <div class="avatar">J</div>
                    <div><strong>Juan Carlos L.</strong><br><span style="color: var(--text-dim); font-size: 0.8rem;">Ferretería El Trébol</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURE BLOCKS -->
    <section id="demo" class="feature-block container">
        <div class="feature-grid">
            <div class="feature-content">
                <h2 style="color: var(--primary-light);">Dashboard de Inteligencia</h2>
                <p style="color: var(--text-dim); font-size: 1.1rem;">Mira tus ganancias reales al instante. Gráficos interactivos de ventas, márgenes y alertas de stock bajo automáticas.</p>
                <ul class="feature-list">
                    <li><i class="fa-solid fa-check"></i> Reportes X y Z en 2 segundos</li>
                    <li><i class="fa-solid fa-check"></i> Acceso desde tu celular</li>
                    <li><i class="fa-solid fa-check"></i> Control de mermas y gastos</li>
                </ul>
            </div>
            <div class="mockup-frame">
                <img src="assets/cajaya_software_interface_v1.png" alt="Dashboard CajaYa">
            </div>
        </div>

        <div class="feature-grid" style="margin-top: 120px;">
            <div class="mockup-frame" style="order: 2;">
                <img src="assets/cajaya_pos_selling_v1.png" alt="POS CajaYa">
            </div>
            <div class="feature-content" style="order: 1;">
                <h2 style="color: var(--primary-light);">Ventas en un toque</h2>
                <p style="color: var(--text-dim); font-size: 1.1rem;">Optimizado para pantallas táctiles. Busca por código de barras o fotos de productos. Vende 100% Offline sin interrupciones.</p>
                <ul class="feature-list">
                    <li><i class="fa-solid fa-check"></i> Compatible con gavetas y scanners</li>
                    <li><i class="fa-solid fa-check"></i> Pago Mixto (Efectivo / Tarjeta)</li>
                    <li><i class="fa-solid fa-check"></i> Impresión térmica de alta velocidad</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- COMPARISON -->
    <section class="container">
        <div style="text-align: center; margin-bottom: 50px;">
            <h2 style="font-size: 3.5rem; font-family: 'Outfit';">Por qué elegir CajaYa</h2>
        </div>
        <div class="table-container">
            <table class="pro-table">
                <thead>
                    <tr>
                        <th class="feat-col">Característica</th>
                        <th class="cajaya-highlight">CajaYa</th>
                        <th>Competencia</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td class="feat-col">Modo Offline Real</td><td class="cajaya-highlight">SÍ (100% Funcional)</td><td>No (Se bloquea)</td></tr>
                    <tr><td class="feat-col">Costo Anual (Ejemplo)</td><td class="cajaya-highlight">$180.000 (Lifetime)</td><td>$360.000+ (Anual)</td></tr>
                    <tr><td class="feat-col">Soporte Premium 24/7</td><td class="cajaya-highlight">SÍ (WhatsApp)</td><td>Tickets / Email</td></tr>
                    <tr><td class="feat-col">Garantía de Devolución</td><td class="cajaya-highlight">SÍ (30 Días)</td><td>Sin reembolso</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- PRICING -->
    <section id="precios" style="padding: 100px 0; background: #050508;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 60px;">
                <h2 style="font-size: 4rem; font-family: 'Outfit';">Planes a tu medida</h2>
                <p style="color: var(--text-dim);">Todos incluyen la integración SII y Soporte Premium.</p>
            </div>
            <div class="pricing-grid">
                <div class="plan-card">
                    <h3>Plan Básico</h3>
                    <div class="plan-price">$20.000 <span>/mes</span></div>
                    <ul class="plan-features">
                        <li><i class="fa-solid fa-check"></i> Integración SII Completa</li>
                        <li><i class="fa-solid fa-check"></i> Gestión de Inventario</li>
                        <li><i class="fa-solid fa-check"></i> Reportes X/Z Diarios</li>
                        <li><i class="fa-solid fa-check"></i> Soporte vía WhatsApp</li>
                    </ul>
                    <a href="#" class="btn-main" style="background: transparent; border: 1px solid var(--primary); justify-content: center;">Suscribirse</a>
                </div>
                <div class="plan-card popular">
                    <div style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: var(--primary); color: #fff; padding: 6px 20px; border-radius: 50px; font-size: 0.8rem; font-weight: 800;">EL MÁS RENTABLE</div>
                    <h3>Plan Lifetime</h3>
                    <div class="plan-price">$180.000 <span>ÚNICO PAGO</span></div>
                    <p style="color: var(--primary-light); font-weight: 800; margin-bottom: 10px;">¡Ahorras $360.000 al año!</p>
                    <ul class="plan-features">
                        <li><i class="fa-solid fa-check"></i> <strong>Licencia Perpetua</strong></li>
                        <li><i class="fa-solid fa-check"></i> Multi-Caja Ilimitado</li>
                        <li><i class="fa-solid fa-check"></i> Actualizaciones 2026+ Incluidas</li>
                        <li><i class="fa-solid fa-check"></i> Sin mensualidades, NUNCA MÁS</li>
                    </ul>
                    <a href="#" class="btn-main" style="justify-content: center;">Comprar Licencia</a>
                </div>
                <div class="plan-card">
                    <h3>Plan Premium</h3>
                    <div class="plan-price">$35.000 <span>/mes</span></div>
                    <ul class="plan-features">
                        <li><i class="fa-solid fa-check"></i> Todo lo del Plan Básico</li>
                        <li><i class="fa-solid fa-check"></i> Respaldos Cloud Automáticos</li>
                        <li><i class="fa-solid fa-check"></i> Multi-Sucursal Avanzado</li>
                        <li><i class="fa-solid fa-check"></i> Soporte 24/7 Prioritario</li>
                    </ul>
                    <a href="#" class="btn-main" style="background: transparent; border: 1px solid var(--primary); justify-content: center;">Suscribirse</a>
                </div>
            </div>
        </div>
    </section>

    <footer style="padding: 80px 0; border-top: 1px solid var(--border);">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 30px;">
            <div>
                <div class="logo-box" style="margin-bottom: 20px;">
                    <div class="logo-img"></div>
                    <div class="logo-img logo-white"></div>
                </div>
                <p style="color: var(--text-dim); font-size: 0.9rem;">CajaYa SpA - Líderes en tecnología POS para Pymes.</p>
            </div>
            <div style="text-align: right;">
                <p style="font-size: 0.85rem; color: var(--text-dim);">RUT: 77.XXX.XXX-X | Santiago, Chile</p>
                <p style="font-size: 0.85rem; color: var(--text-dim);">© 2026 CajaYa. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        const univ = document.getElementById('universe');
        const syms = ['$', '%', '+', '-', '×'];
        for (let i = 0; i < 35; i++) {
            const s = document.createElement('span');
            s.className = 'symbol';
            s.innerText = syms[Math.floor(Math.random()*syms.length)];
            s.style.left = Math.random()*100 + 'vw';
            s.style.fontSize = (Math.random()*20 + 10) + 'px';
            s.style.animationDelay = Math.random()*15 + 's';
            s.style.animationDuration = (Math.random()*10 + 15) + 's';
            univ.appendChild(s);
        }

        let timeLeft = 9912;
        setInterval(() => {
            timeLeft--;
            let h = Math.floor(timeLeft/3600);
            let m = Math.floor((timeLeft%3600)/60);
            let s = timeLeft%60;
            document.getElementById('timer').innerText = 
                `${h < 10 ? '0'+h : h}:${m < 10 ? '0'+m : m}:${s < 10 ? '0'+s : s}`;
        }, 1000);
    </script>
</body>
</html>
