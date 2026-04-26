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

        /* --- TOP BANNER --- */
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

        /* --- TESTIMONIALS --- */
        .social-proof { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-top: 60px; }
        .testimonial { background: var(--bg-card); padding: 35px; border-radius: 24px; border: 1px solid var(--border); transition: 0.3s; }
        .testimonial p { font-size: 0.95rem; font-style: italic; color: var(--text-main); margin-bottom: 25px; line-height: 1.7; }
        .user-meta { display: flex; align-items: center; gap: 12px; }
        .avatar { width: 45px; height: 45px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 800; }

        /* --- MOCKUPS --- */
        .feature-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; padding: 80px 0; }
        .mockup-frame { background: var(--bg-card); padding: 15px; border-radius: 20px; border: 1px solid var(--border); box-shadow: 0 30px 60px rgba(0,0,0,0.6); }
        .mockup-frame img { width: 100%; border-radius: 12px; display: block; }
        .feature-content h2 { font-size: 2.8rem; margin-bottom: 25px; font-family: 'Outfit'; }
        .feature-list { list-style: none; margin-top: 25px; }
        .feature-list li { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
        .feature-list i { color: var(--success); }

        /* --- TABLE --- */
        .pro-table { width: 100%; border-collapse: separate; border-spacing: 0; background: var(--bg-card); border-radius: 30px; overflow: hidden; border: 1px solid var(--border); margin: 60px 0; }
        .pro-table th, .pro-table td { padding: 25px; text-align: center; border-bottom: 1px solid var(--border); }
        .pro-table .feat-col { text-align: left; padding-left: 40px; font-weight: 600; width: 40%; }
        .pro-table .cajaya-highlight { background: rgba(124, 58, 237, 0.1); font-weight: 800; color: #fff; }
        
        /* --- PRICING --- */
        .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 35px; }
        .plan-card { background: var(--bg-card); padding: 60px 45px; border-radius: 32px; border: 1px solid var(--border); text-align: center; position: relative; transition: 0.3s; display: flex; flex-direction: column; }
        .plan-card.popular { border-color: var(--primary); transform: scale(1.05); z-index: 10; box-shadow: 0 20px 50px rgba(124, 58, 237, 0.15); }
        .plan-price { font-size: 3.5rem; font-weight: 900; margin: 25px 0; font-family: 'Outfit'; }
        .plan-price span { font-size: 1rem; color: var(--text-dim); }
        .plan-features { list-style: none; text-align: left; margin: 35px 0; flex-grow: 1; }
        .plan-features li { margin-bottom: 12px; font-size: 0.95rem; display: flex; align-items: center; gap: 12px; }
        .plan-features i { color: var(--success); }

        @media (max-width: 992px) {
            .hero-title { font-size: 3.5rem; text-align: center; }
            .hero-desc { text-align: center; margin: 0 auto 40px; }
            .feature-grid { grid-template-columns: 1fr; text-align: center; }
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
            </nav>
            <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-main">Prueba Gratis 30 Días <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </header>

    <section id="hero" class="hero container">
        <div style="max-width: 900px; margin: 0 auto; text-align: center;">
            <h1 class="hero-title">Tu negocio vende más. <br> <span>Tú trabajas menos.</span></h1>
            <p class="hero-desc" style="margin: 0 auto 45px;">Controla tus ventas, stock y facturación con el sistema POS más rápido de Chile. 100% Offline y Certificado SII 2026.</p>
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-main" style="padding: 20px 45px; font-size: 1.2rem;">Empezar mi Prueba Gratis</a>
                <a href="https://wa.me/56959764771" style="color: #fff; text-decoration: none; font-weight: 700; padding: 18px 30px; border: 1px solid var(--border); border-radius: 14px; display: inline-flex; align-items: center; gap: 10px;">Consultar por WhatsApp <i class="fa-brands fa-whatsapp" style="color: #22c55e;"></i></a>
            </div>
            
            <div style="display: flex; gap: 40px; justify-content: center; margin-top: 60px; opacity: 0.6; font-size: 0.9rem;">
                <div><i class="fa-solid fa-shield-check" style="color: var(--success);"></i> SII Certificado 2026</div>
                <div><i class="fa-solid fa-star" style="color: #fbbf24;"></i> +400 Pymes Felices</div>
                <div><i class="fa-solid fa-rotate" style="color: var(--primary-light);"></i> 30 Días Garantizados</div>
            </div>
        </div>

        <div class="social-proof">
            <div class="testimonial">
                <p>"El cierre de caja pasó de ser una pesadilla a un clic. La boleta electrónica vuela."</p>
                <div class="user-meta"><div class="avatar">R</div><div><strong>Roberto M.</strong><br><span style="color: var(--text-dim); font-size: 0.8rem;">Minimarket Santiago</span></div></div>
            </div>
            <div class="testimonial" style="border-color: var(--primary);">
                <p>"El Plan Lifetime es la mejor inversión. Dejé de pagar cuotas mensuales para siempre."</p>
                <div class="user-meta"><div class="avatar">S</div><div><strong>Sandra P.</strong><br><span style="color: var(--text-dim); font-size: 0.8rem;">Botillería Providencia</span></div></div>
            </div>
            <div class="testimonial">
                <p>"Si se corta el internet, seguimos vendiendo. El modo offline es realmente robusto."</p>
                <div class="user-meta"><div class="avatar">J</div><div><strong>Juan C.</strong><br><span style="color: var(--text-dim); font-size: 0.8rem;">Ferretería Maipú</span></div></div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section id="demo" class="container">
        <div class="feature-grid">
            <div class="feature-content">
                <h2 style="color: var(--primary-light);">Dashboard Inteligente</h2>
                <p style="color: var(--text-dim);">Mira tus ganancias reales al instante. Gráficos de ventas y alertas de stock bajo automáticas.</p>
                <ul class="feature-list">
                    <li><i class="fa-solid fa-check"></i> Reportes X y Z inmediatos</li>
                    <li><i class="fa-solid fa-check"></i> Acceso remoto desde celular</li>
                    <li><i class="fa-solid fa-check"></i> Control de inventario en vivo</li>
                </ul>
            </div>
            <div class="mockup-frame">
                <img src="assets/cajaya_dashboard_v2.png" alt="Dashboard CajaYa">
            </div>
        </div>

        <div class="feature-grid" style="margin-top: 40px;">
            <div class="mockup-frame" style="order: 2;">
                <img src="assets/cajaya_pos_v2.png" alt="POS CajaYa">
            </div>
            <div class="feature-content" style="order: 1;">
                <h2 style="color: var(--primary-light);">Ventas Ultra-Rápidas</h2>
                <p style="color: var(--text-dim);">Vende 100% Offline. Compatible con gavetas, scanners e impresoras térmicas de 58/80mm.</p>
                <ul class="feature-list">
                    <li><i class="fa-solid fa-check"></i> Búsqueda por fotos o código</li>
                    <li><i class="fa-solid fa-check"></i> Pago Mixto Efectivo/Tarjeta</li>
                    <li><i class="fa-solid fa-check"></i> Sincronización Cloud automática</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- ULTRA-MODERN COMPARISON (POWER GRID) -->
    <section class="container" style="padding: 120px 0;">
        <div style="text-align: center; margin-bottom: 80px;">
            <h2 style="font-size: 3.5rem; font-family: 'Outfit'; font-weight: 900; letter-spacing: -2px;">
                ¿Por qué <span style="color: var(--primary-light);">CajaYa</span> es superior?
            </h2>
            <p style="color: var(--text-dim); font-size: 1.2rem; margin-top: 15px;">Compara la tecnología que impulsará tu crecimiento.</p>
        </div>

        <div class="modern-grid">
            <style>
                .modern-grid {
                    display: flex; flex-direction: column; gap: 40px; max-width: 900px; margin: 0 auto;
                }
                .comp-row {
                    display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center;
                    padding: 30px; border-radius: 24px; transition: 0.4s; position: relative;
                }
                .comp-row::before {
                    content: attr(data-label); position: absolute; top: -15px; left: 50%;
                    transform: translateX(-50%); background: var(--bg-dark); padding: 0 15px;
                    color: var(--primary-light); font-weight: 800; font-size: 0.75rem; letter-spacing: 2px;
                    font-family: 'Outfit'; z-index: 2;
                }
                .comp-row:hover { background: rgba(124, 58, 237, 0.03); }

                .side-bad {
                    text-align: right; opacity: 0.4; filter: grayscale(1); transition: 0.3s;
                }
                .side-good {
                    text-align: left; padding: 25px 35px; border-radius: 20px;
                    background: rgba(124, 58, 237, 0.05); border: 1px solid var(--border);
                    box-shadow: 0 10px 30px rgba(124, 58, 237, 0.1); position: relative;
                }
                .side-good::after {
                    content: ''; position: absolute; inset: -1px; border-radius: 20px;
                    padding: 1px; background: linear-gradient(135deg, var(--primary), transparent);
                    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
                    -webkit-mask-composite: xor; mask-composite: exclude; pointer-events: none;
                }

                .comp-icon { font-size: 1.5rem; margin-bottom: 10px; display: block; }
                .val-title { font-size: 1.1rem; font-weight: 800; display: block; margin-bottom: 5px; font-family: 'Outfit'; }
                .val-desc { font-size: 0.9rem; color: var(--text-dim); }

                .vs-divider {
                    position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);
                    width: 40px; height: 40px; background: var(--bg-dark); border: 1px solid var(--border);
                    border-radius: 50%; display: flex; align-items: center; justify-content: center;
                    font-size: 0.7rem; font-weight: 900; color: var(--text-dim); z-index: 5;
                }

                @media (max-width: 768px) {
                    .comp-row { grid-template-columns: 1fr; gap: 20px; text-align: center; }
                    .side-bad { text-align: center; order: 2; }
                    .side-good { text-align: center; order: 1; }
                    .vs-divider { display: none; }
                }
            </style>

            <!-- ROW 1 -->
            <div class="comp-row" data-label="CONECTIVIDAD">
                <div class="side-bad">
                    <i class="fa-solid fa-cloud-slash comp-icon" style="color: #ef4444;"></i>
                    <span class="val-title">Otros Sistemas</span>
                    <span class="val-desc">Se bloquean sin internet. Pierdes ventas y clientes.</span>
                </div>
                <div class="vs-divider">VS</div>
                <div class="side-good">
                    <i class="fa-solid fa-bolt comp-icon" style="color: var(--success);"></i>
                    <span class="val-title" style="color: #fff;">CajaYa Offline</span>
                    <span class="val-desc">Sigue vendiendo al 100%. Sincronización inteligente al volver.</span>
                </div>
            </div>

            <!-- ROW 2 -->
            <div class="comp-row" data-label="INVERSIÓN">
                <div class="side-bad">
                    <i class="fa-solid fa-calendar-minus comp-icon" style="color: #ef4444;"></i>
                    <span class="val-title">Mensualidades</span>
                    <span class="val-desc">Pagos eternos que nunca terminan. Gasto fijo infinito.</span>
                </div>
                <div class="vs-divider">VS</div>
                <div class="side-good" style="box-shadow: 0 0 40px rgba(124, 58, 237, 0.2);">
                    <i class="fa-solid fa-crown comp-icon" style="color: #fbbf24;"></i>
                    <span class="val-title" style="color: #fff;">Plan Lifetime</span>
                    <span class="val-desc">Un solo pago. El software es tuyo para siempre. Sin cuotas.</span>
                </div>
            </div>

            <!-- ROW 3 -->
            <div class="comp-row" data-label="ATENCIÓN">
                <div class="side-bad">
                    <i class="fa-solid fa-ticket comp-icon" style="color: #ef4444;"></i>
                    <span class="val-title">Soporte Lento</span>
                    <span class="val-desc">Tickets y correos que tardan días en responder.</span>
                </div>
                <div class="vs-divider">VS</div>
                <div class="side-good">
                    <i class="fa-solid fa-comment-dots comp-icon" style="color: #22c55e;"></i>
                    <span class="val-title" style="color: #fff;">Soporte WhatsApp</span>
                    <span class="val-desc">Atención humana e inmediata. Estamos contigo 24/7.</span>
                </div>
            </div>
        </div>
    </section>

    <!-- PRICING -->
    <section id="precios" style="padding: 100px 0; background: #050508;">
        <div class="container">
            <div class="pricing-grid">
                <div class="plan-card">
                    <h3>Plan Básico</h3>
                    <div class="plan-price">$20.000 <span>/mes</span></div>
                    <ul class="plan-features">
                        <li><i class="fa-solid fa-check"></i> Integración SII Completa</li>
                        <li><i class="fa-solid fa-check"></i> Gestión de Inventario</li>
                        <li><i class="fa-solid fa-check"></i> Soporte Premium</li>
                    </ul>
                    <a href="../mercadopago/checkout.php" class="btn-main" style="background: transparent; border: 1px solid var(--primary); justify-content: center;">Suscribirse</a>
                </div>
                <div class="plan-card popular">
                    <div style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: var(--primary); color: #fff; padding: 6px 20px; border-radius: 50px; font-size: 0.8rem; font-weight: 800;">RECOMENDADO</div>
                    <h3>Plan Lifetime</h3>
                    <div class="plan-price">$180.000 <span>ÚNICO PAGO</span></div>
                    <p style="color: var(--primary-light); font-weight: 800;">Ahorro de $360.000 el 1er año</p>
                    <ul class="plan-features">
                        <li><i class="fa-solid fa-check"></i> <strong>Licencia Perpetua</strong></li>
                        <li><i class="fa-solid fa-check"></i> Multi-Caja Ilimitado</li>
                        <li><i class="fa-solid fa-check"></i> Actualizaciones 2026+</li>
                    </ul>
                    <a href="../mercadopago/checkout.php" class="btn-main" style="justify-content: center;">Comprar Licencia Ahora</a>
                </div>
                <div class="plan-card">
                    <h3>Plan Premium</h3>
                    <div class="plan-price">$35.000 <span>/mes</span></div>
                    <ul class="plan-features">
                        <li><i class="fa-solid fa-check"></i> Todo lo del Plan Básico</li>
                        <li><i class="fa-solid fa-check"></i> Respaldos Automáticos</li>
                        <li><i class="fa-solid fa-check"></i> Soporte Prioritario</li>
                    </ul>
                    <a href="../mercadopago/checkout.php" class="btn-main" style="background: transparent; border: 1px solid var(--primary); justify-content: center;">Suscribirse</a>
                </div>
            </div>
        </div>
    </section>

    <footer style="padding: 60px 0; border-top: 1px solid var(--border);">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 30px;">
            <div class="logo-box"><div class="logo-img"></div><div class="logo-img logo-white"></div></div>
            <div style="text-align: right; color: var(--text-dim); font-size: 0.85rem;">
                <p>CajaYa SpA - RUT: 77.XXX.XXX-X | Santiago, Chile</p>
                <p>© 2026 CajaYa. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        const univ = document.getElementById('universe');
        const syms = ['$', '%', '+', '-'];
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
            document.getElementById('timer').innerText = `${h < 10 ? '0'+h : h}:${m < 10 ? '0'+m : m}:${s < 10 ? '0'+s : s}`;
        }, 1000);
    </script>
</body>
</html>
