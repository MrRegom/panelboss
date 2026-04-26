<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajaYa - POS Profesional Certificado SII 2026 | Prueba Gratis</title>
    
    <meta name="description" content="El sistema POS más confiable de Chile. Certificado SII 2026, 100% Offline y Plan Lifetime. Prueba gratis por 30 días y automatiza tu negocio hoy.">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Outfit:wght@500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #7c3aed;
            --accent: #a855f7;
            --bg-deep: #0a0910;
            --bg-card: #0f0e1a;
            --text-main: #f8fafc;
            --text-muted: #8b8a9e;
            --border: rgba(168, 85, 247, 0.15);
            --success: #22c55e;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            background-color: var(--bg-deep);
            background-image: radial-gradient(circle at top right, rgba(168, 85, 247, 0.12) 0%, transparent 40%);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
            position: relative;
        }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 25px; width: 100%; }

        /* --- SALES UNIVERSE BACKGROUND --- */
        .sales-universe {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: -1; overflow: hidden;
        }
        .symbol {
            position: absolute; color: var(--accent); font-family: 'Outfit', sans-serif;
            font-weight: 900; opacity: 0.15; animation: float-random linear infinite;
        }
        @keyframes float-random {
            0% { transform: translateY(110vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.25; }
            90% { opacity: 0.25; }
            100% { transform: translateY(-10vh) rotate(360deg); opacity: 0; }
        }

        /* --- PROMO BANNER (URGENCIA) --- */
        .promo-banner {
            background: linear-gradient(90deg, #7c3aed, #db2777, #7c3aed);
            background-size: 200% auto;
            color: #fff; text-align: center; padding: 10px 0;
            font-size: 0.85rem; font-weight: 800; position: sticky; top: 0; z-index: 1100;
            animation: shimmer 4s linear infinite;
        }
        @keyframes shimmer { 0% { background-position: 0% center; } 100% { background-position: 200% center; } }

        /* --- HEADER --- */
        header {
            padding: 15px 0; position: sticky; top: 38px; z-index: 1000;
            background: rgba(10, 9, 16, 0.95); backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border);
        }
        .nav-wrapper { display: flex; justify-content: space-between; align-items: center; }
        
        .logo-container { position: relative; height: 40px; width: 130px; overflow: hidden; }
        .logo-base, .logo-overlay {
            position: absolute; top: 0; left: 0; height: 100%; width: 100%;
            background-image: url('assets/img/logo.png'); background-size: contain; background-repeat: no-repeat;
        }
        .logo-overlay { filter: brightness(0) invert(1); clip-path: inset(0 57% 0 0); z-index: 2; }
        
        .btn-neon {
            background: var(--accent); color: #fff; padding: 10px 22px; border-radius: 10px;
            font-weight: 700; text-decoration: none; box-shadow: 0 0 20px rgba(168, 85, 247, 0.4);
            transition: 0.3s; border: none; display: inline-flex; align-items: center; gap: 8px; font-size: 0.9rem;
        }

        /* --- HERO --- */
        .hero { padding: 80px 0; }
        .hero-grid { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 60px; align-items: center; }
        .hero-title { font-size: 4.2rem; font-weight: 900; line-height: 1.1; margin-bottom: 25px; letter-spacing: -2px; }
        .text-gradient { background: linear-gradient(135deg, #fff 0%, var(--accent) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-desc { font-size: 1.2rem; color: var(--text-muted); margin-bottom: 40px; }
        
        .hero-trust { display: flex; gap: 20px; margin-top: 30px; opacity: 0.7; }
        .trust-item { display: flex; align-items: center; gap: 8px; font-size: 0.8rem; }
        .trust-item i { color: var(--success); }

        /* --- COMPARISON TABLE --- */
        .comparison-section { padding: 80px 0; background: rgba(255,255,255,0.01); }
        .comp-table { width: 100%; border-collapse: collapse; background: var(--bg-card); border-radius: 20px; overflow: hidden; border: 1px solid var(--border); }
        .comp-table th, .comp-table td { padding: 20px; text-align: center; border-bottom: 1px solid var(--border); }
        .comp-table th { background: rgba(124, 58, 237, 0.1); font-family: 'Outfit'; }
        .comp-table .feature-name { text-align: left; font-weight: 600; padding-left: 30px; }
        .comp-table .highlight { color: var(--accent); font-weight: 800; }

        /* --- PREVIEW SECTION --- */
        .preview-section { padding: 80px 0; }
        .preview-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 50px; }
        .preview-card { background: var(--bg-card); border-radius: 20px; padding: 20px; border: 1px solid var(--border); text-align: center; }
        .preview-card img { width: 100%; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .preview-card h4 { margin-bottom: 10px; font-size: 1.2rem; }

        /* --- PRICING --- */
        .pricing-section { padding: 80px 0; background: #08080c; }
        .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; }
        .price-card { background: var(--bg-card); border: 1px solid var(--border); padding: 50px 40px; border-radius: 24px; position: relative; transition: 0.3s; text-align: center; display: flex; flex-direction: column; }
        .price-card.featured { border-color: var(--accent); box-shadow: 0 0 40px rgba(168, 85, 247, 0.15); transform: scale(1.05); }
        .price-tag { font-size: 2.8rem; font-weight: 900; margin: 20px 0; }
        .price-tag span { font-size: 1rem; color: var(--text-muted); font-weight: 400; }
        .price-features { list-style: none; margin: 30px 0; text-align: left; flex-grow: 1; }
        .price-features li { margin-bottom: 12px; display: flex; align-items: center; gap: 10px; font-size: 0.95rem; }
        .price-features i { color: var(--success); }

        .badge-recommended { position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: var(--accent); color: #fff; padding: 4px 15px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; }

        /* --- FAQ --- */
        .faq-section { padding: 80px 0; }
        .faq-item { background: rgba(255,255,255,0.02); border: 1px solid var(--border); border-radius: 15px; margin-bottom: 15px; overflow: hidden; }
        .faq-question { padding: 20px 25px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: 600; transition: 0.3s; }
        .faq-question:hover { background: rgba(168, 85, 247, 0.05); }
        .faq-answer { padding: 0 25px; max-height: 0; overflow: hidden; transition: 0.4s; color: var(--text-muted); font-size: 0.95rem; }
        .faq-item.active .faq-answer { padding: 0 25px 25px; max-height: 300px; }

        /* --- FOOTER --- */
        footer { padding: 60px 0; border-top: 1px solid var(--border); background: #050508; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 40px; }
        .footer-logo { margin-bottom: 20px; display: inline-block; }
        .footer-legal { font-size: 0.8rem; color: var(--text-muted); margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 20px; }

        /* --- RESPONSIVE --- */
        @media (max-width: 992px) {
            .hero-grid { grid-template-columns: 1fr; text-align: center; }
            .hero-title { font-size: 3rem; }
            .hero-desc { margin: 0 auto 30px; }
            .preview-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; text-align: center; }
        }
    </style>
</head>
<body>

    <div class="sales-universe" id="universe"></div>

    <div class="promo-banner">
        🔥 Oferta Limitada: Mes Gratis + Instalación (Quedan solo 3 cupos para esta semana)
    </div>

    <header>
        <div class="container nav-wrapper">
            <a href="#hero" class="logo-container">
                <div class="logo-base"></div>
                <div class="logo-overlay"></div>
            </a>
            <nav style="display: flex; gap: 30px;" class="nav-desktop">
                <a href="#demo" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Demo</a>
                <a href="#precios" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Precios</a>
                <a href="#faq" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Ayuda</a>
            </nav>
            <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-neon">Prueba Gratis</a>
        </div>
    </header>

    <section id="hero" class="hero">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <h1 class="hero-title">
                        Vende sin límites, <br> <span class="text-gradient">crece sin miedos.</span>
                    </h1>
                    <p class="hero-desc">
                        El sistema POS que no se detiene si se cae el internet. Certificado SII 2026, gestión de stock real y reportes profesionales en un clic.
                    </p>
                    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                        <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-neon" style="padding: 18px 35px; font-size: 1.1rem;">Empieza Gratis Ahora <i class="fa-solid fa-rocket"></i></a>
                        <a href="https://wa.me/56959764771" style="display: inline-flex; align-items: center; gap: 10px; color: #fff; text-decoration: none; font-weight: 600; padding: 18px 25px; border: 1px solid var(--border); border-radius: 12px; transition: 0.3s;">Hablemos por WhatsApp <i class="fa-brands fa-whatsapp" style="color: #25d366;"></i></a>
                    </div>
                    <div class="hero-trust">
                        <div class="trust-item"><i class="fa-solid fa-shield-check"></i> Certificado SII 2026</div>
                        <div class="trust-item"><i class="fa-solid fa-rotate"></i> 30 días de garantía</div>
                        <div class="trust-item"><i class="fa-solid fa-headset"></i> Soporte Chileno 24/7</div>
                    </div>
                </div>
                <div class="hero-visual">
                    <img src="assets/cajaya_hardware_mockup.png" alt="Hardware CajaYa" class="mockup-img" style="width: 100%;">
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION PREVIEW (VIDEO/DEMO PLACEHOLDER) -->
    <section id="demo" class="preview-section">
        <div class="container">
            <div style="text-align: center;">
                <h2 style="font-size: 3rem;">El Software por dentro</h2>
                <p style="color: var(--text-muted);">Diseñado para ser rápido, intuitivo y profesional.</p>
            </div>
            <div class="preview-grid">
                <div class="preview-card">
                    <img src="assets/cajaya_software_interface_v1.png" alt="Dashboard CajaYa">
                    <h4>Dashboard Inteligente</h4>
                    <p style="font-size: 0.9rem; color: var(--text-muted);">Controla tus ventas, márgenes y stock en tiempo real desde cualquier lugar.</p>
                </div>
                <div class="preview-card">
                    <img src="assets/cajaya_pos_selling_v1.png" alt="POS Ventas">
                    <h4>Terminal de Ventas Ultra-Rápido</h4>
                    <p style="font-size: 0.9rem; color: var(--text-muted);">Vende en segundos, incluso sin conexión a internet. Sincronización automática.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TABLA COMPARATIVA -->
    <section class="comparison-section">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 50px; font-size: 2.8rem;">¿Por qué elegir CajaYa?</h2>
            <table class="comp-table">
                <thead>
                    <tr>
                        <th>Característica</th>
                        <th class="highlight">CajaYa</th>
                        <th>Otros POS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="feature-name">Modo Offline Real</td>
                        <td><i class="fa-solid fa-circle-check" style="color: var(--success);"></i> 100% Funcional</td>
                        <td><i class="fa-solid fa-circle-xmark" style="color: #ff4d4d;"></i> Requiere Internet</td>
                    </tr>
                    <tr>
                        <td class="feature-name">Plan Lifetime (Pago Único)</td>
                        <td class="highlight">SÍ, Disponible</td>
                        <td><i class="fa-solid fa-circle-xmark" style="color: #ff4d4d;"></i> Mensualidad eterna</td>
                    </tr>
                    <tr>
                        <td class="feature-name">Certificación SII 2026</td>
                        <td><i class="fa-solid fa-circle-check" style="color: var(--success);"></i> Actualizado</td>
                        <td><i class="fa-solid fa-circle-minus" style="color: #f59e0b;"></i> Varía según proveedor</td>
                    </tr>
                    <tr>
                        <td class="feature-name">Soporte por WhatsApp</td>
                        <td><i class="fa-solid fa-circle-check" style="color: var(--success);"></i> Inmediato</td>
                        <td><i class="fa-solid fa-circle-minus" style="color: #f59e0b;"></i> Tickets lentos</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- PRICING -->
    <section id="precios" class="pricing-section">
        <div class="container">
            <div style="text-align: center; margin-bottom: 60px;">
                <h2 style="font-size: 3.5rem;">Invierte en tu tranquilidad</h2>
                <p style="color: var(--text-muted);">Todos los planes incluyen 30 días de prueba gratis.</p>
            </div>
            <div class="pricing-grid">
                <div class="price-card">
                    <h3>Plan Básico</h3>
                    <div class="price-tag">$20.000 <span>/mes</span></div>
                    <ul class="price-features">
                        <li><i class="fa-solid fa-check"></i> Integración SII (Boletas/Facturas)</li>
                        <li><i class="fa-solid fa-check"></i> Gestión de Inventario</li>
                        <li><i class="fa-solid fa-check"></i> Reportes X y Z diarios</li>
                        <li><i class="fa-solid fa-check"></i> Soporte por WhatsApp</li>
                    </ul>
                    <a href="#" class="btn-neon" style="justify-content: center; background: transparent; border: 1px solid var(--accent);">Suscribirse</a>
                </div>
                <div class="price-card featured">
                    <div class="badge-recommended">EL MÁS POPULAR</div>
                    <h3>Plan Premium</h3>
                    <div class="price-tag">$35.000 <span>/mes</span></div>
                    <ul class="price-features">
                        <li><i class="fa-solid fa-check"></i> <strong>Todo lo del Plan Básico</strong></li>
                        <li><i class="fa-solid fa-check"></i> <strong>Soporte 24/7 Prioritario</strong></li>
                        <li><i class="fa-solid fa-check"></i> <strong>Respaldos Automáticos en Nube</strong></li>
                        <li><i class="fa-solid fa-check"></i> Acceso Multiusuario</li>
                    </ul>
                    <a href="#" class="btn-neon" style="justify-content: center;">Empezar Gratis</a>
                </div>
                <div class="price-card">
                    <h3>Plan Lifetime</h3>
                    <div class="price-tag">$180.000 <span>pago único</span></div>
                    <ul class="price-features">
                        <li><i class="fa-solid fa-check"></i> <strong>Licencia Perpetua (Para siempre)</strong></li>
                        <li><i class="fa-solid fa-check"></i> Multi Caja Ilimitado</li>
                        <li><i class="fa-solid fa-check"></i> Actualizaciones 2026 Incluidas</li>
                        <li><i class="fa-solid fa-check"></i> Sin cuotas mensuales nunca más</li>
                    </ul>
                    <a href="#" class="btn-neon" style="justify-content: center; background: var(--success); box-shadow: 0 0 20px rgba(34, 197, 94, 0.3);">Comprar Licencia</a>
                    <p style="font-size: 0.7rem; color: var(--text-muted); margin-top: 15px;">Solo 5 cupos disponibles este mes.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ EXPANDIDA -->
    <section id="faq" class="faq-section">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 50px; font-size: 3rem;">Preguntas Frecuentes</h2>
            <div style="max-width: 850px; margin: 0 auto;">
                <div class="faq-item">
                    <div class="faq-question">¿Funciona con mi impresora térmica actual? <i class="fa-solid fa-chevron-down"></i></div>
                    <div class="faq-answer">Sí. CajaYa es compatible con el 99% de las impresoras térmicas (58mm y 80mm) vía USB, Bluetooth o Red. Nuestro equipo técnico te ayuda con la configuración inicial gratis.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">¿Qué pasa si el SII cambia la normativa? <i class="fa-solid fa-chevron-down"></i></div>
                    <div class="faq-answer">Nosotros nos encargamos. El sistema se actualiza automáticamente para cumplir con todas las normativas del SII vigentes y futuras (2026+).</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">¿Puedo migrar mis datos desde otro sistema? <i class="fa-solid fa-chevron-down"></i></div>
                    <div class="faq-answer">¡Absolutamente! Te ayudamos a importar tus productos, clientes e inventario desde Excel de forma masiva para que empieces a vender el mismo día.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">¿Tienen garantía de devolución? <i class="fa-solid fa-chevron-down"></i></div>
                    <div class="faq-answer">Sí. Ofrecemos 30 días de garantía total. Si el sistema no se adapta a tu negocio, te devolvemos el 100% de tu dinero sin preguntas.</div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="logo-container footer-logo">
                        <div class="logo-base"></div>
                        <div class="logo-overlay"></div>
                    </div>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Empoderando a las Pymes chilenas con tecnología de vanguardia y offline-first.</p>
                </div>
                <div>
                    <h5 style="margin-bottom: 20px;">Contacto</h5>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">Soporte: +56 9 5976 4771</p>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">Email: hola@cajaya.cl</p>
                </div>
                <div>
                    <h5 style="margin-bottom: 20px;">Institucional</h5>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">CajaYa SpA</p>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">RUT: 77.XXX.XXX-X</p>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">Santiago, Chile</p>
                </div>
            </div>
            <div class="footer-legal">
                © 2026 CajaYa. Todos los derechos reservados. | <a href="#" style="color: var(--text-muted);">Términos y Condiciones</a>
            </div>
        </div>
    </footer>

    <script>
        // SALES UNIVERSE GENERATOR
        const universe = document.getElementById('universe');
        const symbols = ['$', '%', '+', '-', '×', '÷', '='];
        for (let i = 0; i < 45; i++) {
            const span = document.createElement('span');
            span.className = 'symbol';
            span.innerText = symbols[Math.floor(Math.random() * symbols.length)];
            span.style.left = Math.random() * 100 + 'vw';
            span.style.fontSize = (Math.random() * 25 + 12) + 'px';
            span.style.animationDelay = (Math.random() * 20) + 's';
            span.style.animationDuration = (Math.random() * 12 + 18) + 's';
            universe.appendChild(span);
        }

        // FAQ INTERACTIVITY
        document.querySelectorAll('.faq-question').forEach(item => {
            item.addEventListener('click', () => {
                const parent = item.parentElement;
                parent.classList.toggle('active');
            });
        });
    </script>

</body>
</html>
