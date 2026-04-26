<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajaYa - Tu negocio vende más. Tú trabajas menos. | SII 2026</title>
    
    <meta name="description" content="El POS más confiable de Chile. Certificado SII 2026, 100% Offline y Plan Lifetime. Prueba gratis por 30 días y automatiza tu negocio hoy.">
    
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
            --urgency: #dc2626;
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

        .container { max-width: 1100px; margin: 0 auto; padding: 0 25px; width: 100%; }

        /* --- SALES UNIVERSE --- */
        .sales-universe {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: -1; overflow: hidden; opacity: 0.2;
        }
        .symbol {
            position: absolute; color: var(--primary); font-family: 'Outfit', sans-serif;
            font-weight: 900; opacity: 0.15; animation: float-random linear infinite;
        }
        @keyframes float-random {
            0% { transform: translateY(110vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.25; }
            90% { opacity: 0.25; }
            100% { transform: translateY(-10vh) rotate(360deg); opacity: 0; }
        }

        /* --- URGENCY BANNER --- */
        .urgency-banner {
            background: var(--urgency); color: #fff; text-align: center; padding: 10px 0;
            font-size: 0.85rem; font-weight: 800; position: sticky; top: 0; z-index: 1200;
        }

        /* --- HEADER --- */
        header {
            padding: 15px 0; position: sticky; top: 40px; z-index: 1000;
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
            background: var(--primary); color: #fff; padding: 10px 22px; border-radius: 10px;
            font-weight: 700; text-decoration: none; box-shadow: 0 0 20px rgba(124, 58, 237, 0.4);
            transition: 0.3s; border: none; display: inline-flex; align-items: center; gap: 8px; font-size: 0.9rem;
        }
        .btn-neon:hover { transform: translateY(-2px); box-shadow: 0 0 30px rgba(124, 58, 237, 0.6); }

        /* --- HERO --- */
        .hero { padding: 80px 0; }
        .hero-title { font-size: 4.2rem; font-weight: 900; line-height: 1.1; margin-bottom: 25px; letter-spacing: -2px; }
        .text-gradient { background: linear-gradient(135deg, #fff 0%, var(--primary) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-desc { font-size: 1.2rem; color: var(--text-muted); margin-bottom: 40px; max-width: 600px; }
        
        .hero-trust { display: flex; gap: 20px; margin-top: 35px; opacity: 0.8; flex-wrap: wrap; }
        .trust-item { display: flex; align-items: center; gap: 8px; font-size: 0.8rem; background: rgba(255,255,255,0.03); padding: 8px 15px; border-radius: 50px; border: 1px solid var(--border); }
        .trust-item i { color: var(--success); }

        /* --- PROOF SECTION --- */
        .proof-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; margin: 40px 0; }
        .proof-card { background: var(--bg-card); padding: 30px; border-radius: 20px; border: 1px solid var(--border); transition: 0.3s; }
        .proof-card:hover { border-color: var(--primary); }
        .client-info { display: flex; align-items: center; gap: 12px; margin-top: 20px; }
        .client-avatar { width: 40px; height: 40px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; }

        /* --- SOFTWARE PREVIEW --- */
        .sw-preview { padding: 80px 0; border-top: 1px solid var(--border); }
        .sw-grid { display: grid; grid-template-columns: 1fr 1.2fr; gap: 50px; align-items: center; margin-bottom: 80px; }
        .sw-img { width: 100%; border-radius: 15px; border: 1px solid var(--border); box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
        .sw-content h3 { font-size: 2.2rem; margin-bottom: 20px; font-family: 'Outfit'; }

        /* --- COMPARISON --- */
        .comp-table { width: 100%; border-collapse: separate; border-spacing: 0; background: var(--bg-card); border-radius: 20px; overflow: hidden; border: 1px solid var(--border); margin: 50px 0; }
        .comp-table th, .comp-table td { padding: 22px; text-align: center; border-bottom: 1px solid var(--border); }
        .comp-table .feature { text-align: left; padding-left: 35px; font-weight: 600; font-size: 0.95rem; }
        .comp-table .cajaya-col { background: rgba(124, 58, 237, 0.08); font-weight: 800; color: #fff; }

        /* --- PRICING --- */
        .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; margin-top: 50px; }
        .price-card { background: var(--bg-card); border: 1px solid var(--border); padding: 50px 40px; border-radius: 24px; text-align: center; display: flex; flex-direction: column; transition: 0.3s; }
        .price-card.featured { border-color: var(--primary); box-shadow: 0 0 40px rgba(124, 58, 237, 0.15); transform: scale(1.03); }
        .price-tag { font-size: 2.8rem; font-weight: 900; margin: 20px 0; }
        .price-tag span { font-size: 0.9rem; color: var(--text-muted); font-weight: 400; }
        .price-features { list-style: none; margin: 30px 0; text-align: left; flex-grow: 1; }
        .price-features li { margin-bottom: 12px; display: flex; align-items: center; gap: 10px; font-size: 0.9rem; }
        .price-features i { color: var(--success); }

        /* --- FAQ --- */
        .faq-item { background: rgba(255,255,255,0.02); border: 1px solid var(--border); border-radius: 15px; margin-bottom: 15px; }
        .faq-question { padding: 22px 25px; cursor: pointer; display: flex; justify-content: space-between; font-weight: 700; transition: 0.3s; }
        .faq-answer { padding: 0 25px; max-height: 0; overflow: hidden; transition: 0.4s; color: var(--text-muted); font-size: 0.95rem; }
        .faq-item.active .faq-answer { padding: 0 25px 22px; max-height: 300px; }

        /* --- FOOTER --- */
        footer { padding: 60px 0; background: #08080c; border-top: 1px solid var(--border); }
        .footer-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr; gap: 40px; }

        /* --- RESPONSIVE --- */
        @media (max-width: 992px) {
            .hero-title { font-size: 3.2rem; text-align: center; }
            .hero-desc { text-align: center; margin: 0 auto 35px; }
            .hero-btns { justify-content: center; display: flex; flex-wrap: wrap; gap: 15px; }
            .sw-grid { grid-template-columns: 1fr; text-align: center; }
            .proof-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; text-align: center; }
        }
    </style>
</head>
<body>

    <div class="sales-universe" id="universe"></div>

    <div class="urgency-banner">
        🔥 OFERTA: Mes Gratis + Instalación (Solo 3 cupos disponibles hoy. Tiempo restante: <span id="countdown">02:45:12</span>)
    </div>

    <header>
        <div class="container nav-wrapper">
            <a href="#hero" class="logo-container">
                <div class="logo-base"></div>
                <div class="logo-overlay"></div>
            </a>
            <nav style="display: flex; gap: 25px;" class="nav-desktop">
                <a href="#demo" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Cómo funciona</a>
                <a href="#precios" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Planes</a>
                <a href="#faq" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Preguntas</a>
            </nav>
            <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-neon">Prueba Gratis 30 Días</a>
        </div>
    </header>

    <section id="hero" class="hero">
        <div class="container">
            <div style="max-width: 850px;">
                <h1 class="hero-title">
                    Tu negocio vende más. <br> <span class="text-gradient">Tú trabajas menos.</span>
                </h1>
                <p class="hero-desc">
                    Controla tus ventas y stock con el sistema más confiable de Chile. Certificado SII 2026, 100% Offline y soporte premium incluido.
                </p>
                <div class="hero-btns" style="display: flex; gap: 15px;">
                    <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-neon" style="padding: 18px 35px; font-size: 1.1rem;">Empezar Prueba Gratis Ahora <i class="fa-solid fa-rocket"></i></a>
                    <a href="https://wa.me/56959764771" style="display: inline-flex; align-items: center; gap: 10px; color: #fff; text-decoration: none; font-weight: 600; padding: 18px 25px; border: 1px solid var(--border); border-radius: 12px; transition: 0.3s;">Consultar por WhatsApp <i class="fa-brands fa-whatsapp" style="color: #25d366;"></i></a>
                </div>
                <div class="hero-trust">
                    <div class="trust-item"><i class="fa-solid fa-shield-check"></i> Certificado SII 2026</div>
                    <div class="trust-item"><i class="fa-solid fa-rotate"></i> 30 Días de Garantía</div>
                    <div class="trust-item"><i class="fa-solid fa-users"></i> +400 Negocios confían</div>
                </div>
            </div>
        </div>
    </section>

    <!-- SOCIAL PROOF -->
    <section class="container" style="padding: 40px 0;">
        <div class="proof-grid">
            <div class="proof-card">
                <p>"El cierre de caja pasó de ser una pesadilla a un clic. La integración con el SII funciona impecable."</p>
                <div class="client-info">
                    <div class="client-avatar">R</div>
                    <div><strong>Roberto M.</strong><br><span style="font-size: 0.75rem; color: var(--text-muted);">Minimarket Santiago</span></div>
                </div>
            </div>
            <div class="proof-card" style="border-color: var(--primary);">
                <p>"Invertir en el Plan Lifetime fue lo mejor. Un solo pago y me olvidé de las cuotas para siempre."</p>
                <div class="client-info">
                    <div class="client-avatar">S</div>
                    <div><strong>Sandra P.</strong><br><span style="font-size: 0.75rem; color: var(--text-muted);">Botillería Providencia</span></div>
                </div>
            </div>
            <div class="proof-card">
                <p>"Se cortó el internet en el local y pudimos seguir vendiendo sin problemas. Muy confiable."</p>
                <div class="client-info">
                    <div class="client-avatar">J</div>
                    <div><strong>Juan Carlos L.</strong><br><span style="font-size: 0.75rem; color: var(--text-muted);">Ferretería Maipú</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- SOFTWARE PREVIEW -->
    <section id="demo" class="sw-preview">
        <div class="container">
            <div class="sw-grid">
                <div class="sw-content">
                    <h3 style="color: var(--primary);">Dashboard de Control</h3>
                    <p style="color: var(--text-muted); margin-bottom: 25px;">Visualiza tus ventas, márgenes y productos más vendidos en tiempo real. Alertas automáticas de stock bajo para que nunca dejes de vender.</p>
                    <ul style="list-style: none; display: grid; gap: 12px;">
                        <li><i class="fa-solid fa-check" style="color: var(--success);"></i> Reportes X y Z inmediatos</li>
                        <li><i class="fa-solid fa-check" style="color: var(--success);"></i> Acceso remoto desde celular</li>
                        <li><i class="fa-solid fa-check" style="color: var(--success);"></i> Control de mermas y gastos</li>
                    </ul>
                </div>
                <img src="assets/cajaya_software_interface_v1.png" alt="Dashboard CajaYa" class="sw-img">
            </div>
            <div class="sw-grid" style="direction: rtl;">
                <div class="sw-content" style="direction: ltr;">
                    <h3 style="color: var(--primary);">Ventas Ultra-Rápidas</h3>
                    <p style="color: var(--text-muted); margin-bottom: 25px;">Diseñado para la velocidad. Compatible con scanners, gavetas de dinero e impresoras térmicas. Funciona 100% sin conexión.</p>
                    <ul style="list-style: none; display: grid; gap: 12px;">
                        <li><i class="fa-solid fa-check" style="color: var(--success);"></i> Pago con Tarjeta/Efectivo/Transferencia</li>
                        <li><i class="fa-solid fa-check" style="color: var(--success);"></i> Búsqueda inteligente de productos</li>
                        <li><i class="fa-solid fa-check" style="color: var(--success);"></i> Sincronización automática con la nube</li>
                    </ul>
                </div>
                <img src="assets/cajaya_pos_selling_v1.png" alt="POS CajaYa" class="sw-img" style="direction: ltr;">
            </div>
        </div>
    </section>

    <!-- COMPARATIVA -->
    <section class="container" style="padding: 60px 0;">
        <h2 style="text-align: center; font-size: 2.8rem; margin-bottom: 40px; font-family: 'Outfit';">CajaYa vs Otros Sistemas</h2>
        <table class="comp-table">
            <thead>
                <tr>
                    <th class="feature">Característica</th>
                    <th class="cajaya-col">CajaYa</th>
                    <th>Competencia</th>
                </tr>
            </thead>
            <tbody>
                <tr><td class="feature">Modo Offline Real</td><td class="cajaya-col">SÍ (Sigue vendiendo)</td><td>No (Se bloquea)</td></tr>
                <tr><td class="feature">Plan Lifetime</td><td class="cajaya-col">SÍ (Pago único)</td><td>No (Mensualidad eterna)</td></tr>
                <tr><td class="feature">Soporte Premium 24/7</td><td class="cajaya-col">SÍ (Inmediato)</td><td>Sistema de tickets</td></tr>
                <tr><td class="feature">Garantía de Satisfacción</td><td class="cajaya-col">30 Días (100% Devolución)</td><td>Sin reembolso</td></tr>
            </tbody>
        </table>
    </section>

    <!-- PRECIOS -->
    <section id="precios" style="padding: 80px 0; background: #08080c;">
        <div class="container">
            <h2 style="text-align: center; font-size: 3rem; margin-bottom: 50px;">Elige tu camino al éxito</h2>
            <div class="pricing-grid">
                <div class="price-card">
                    <h3>Básico</h3>
                    <div class="price-tag">$20.000 <span>/mes</span></div>
                    <ul class="price-features">
                        <li><i class="fa-solid fa-check"></i> Integración SII Completa</li>
                        <li><i class="fa-solid fa-check"></i> Gestión de Inventario</li>
                        <li><i class="fa-solid fa-check"></i> Reportes X/Z Diarios</li>
                        <li><i class="fa-solid fa-check"></i> Soporte Premium</li>
                    </ul>
                    <a href="#" class="btn-neon" style="background: transparent; border: 1px solid var(--primary); justify-content: center;">Suscribirse</a>
                </div>
                <div class="price-card featured">
                    <div style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: var(--primary); color: #fff; padding: 4px 15px; border-radius: 50px; font-size: 0.7rem; font-weight: 800;">PLAN RECOMENDADO</div>
                    <h3>Plan Lifetime</h3>
                    <div class="price-tag">$180.000 <span>ÚNICO PAGO</span></div>
                    <p style="color: var(--primary); font-weight: 700; margin-bottom: 15px; font-size: 0.85rem;">¡Ahorras $360.000 el primer año!</p>
                    <ul class="price-features">
                        <li><i class="fa-solid fa-check"></i> <strong>Licencia de por vida</strong></li>
                        <li><i class="fa-solid fa-check"></i> Multi-Caja Ilimitado</li>
                        <li><i class="fa-solid fa-check"></i> Actualizaciones Legales Incluidas</li>
                        <li><i class="fa-solid fa-check"></i> Sin mensualidades NUNCA MÁS</li>
                    </ul>
                    <a href="#" class="btn-neon" style="justify-content: center;">Comprar Ahora</a>
                    <p style="font-size: 0.7rem; color: var(--text-muted); margin-top: 15px;">Incluye Garantía de 30 días.</p>
                </div>
                <div class="price-card">
                    <h3>Premium</h3>
                    <div class="price-tag">$35.000 <span>/mes</span></div>
                    <ul class="price-features">
                        <li><i class="fa-solid fa-check"></i> Todo lo del Plan Básico</li>
                        <li><i class="fa-solid fa-check"></i> Respaldos Automáticos Cloud</li>
                        <li><i class="fa-solid fa-check"></i> Acceso Multi-Usuario</li>
                        <li><i class="fa-solid fa-check"></i> Atención Prioritaria</li>
                    </ul>
                    <a href="#" class="btn-neon" style="background: transparent; border: 1px solid var(--primary); justify-content: center;">Suscribirse</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="container" style="padding: 100px 0;">
        <h2 style="text-align: center; font-size: 2.8rem; margin-bottom: 50px;">Preguntas Frecuentes</h2>
        <div style="max-width: 800px; margin: 0 auto;">
            <div class="faq-item">
                <div class="faq-question">¿Qué pasa si no me gusta el sistema? <i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer">Ofrecemos 30 días de garantía total. Si sientes que CajaYa no es para ti, te devolvemos el 100% de tu dinero sin preguntas. Tu inversión está segura con nosotros.</div>
            </div>
            <div class="faq-item">
                <div class="faq-question">¿Es compatible con mi impresora térmica? <i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer">Sí. CajaYa es compatible con el 99% de las impresoras térmicas (USB, Bluetooth, Red) de 58mm y 80mm. Nuestro equipo técnico te ayuda a configurarla gratis.</div>
            </div>
            <div class="faq-item">
                <div class="faq-question">¿Tengo que pagar por actualizaciones del SII? <i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer">No. Todas las actualizaciones legales para cumplir con la normativa vigente y futura del SII (2026+) están incluidas en todos nuestros planes sin costo adicional.</div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container footer-grid">
            <div>
                <div class="logo-container" style="margin-bottom: 20px;">
                    <div class="logo-base"></div>
                    <div class="logo-overlay"></div>
                </div>
                <p style="font-size: 0.9rem; color: var(--text-muted);">Potenciando a las Pymes chilenas con tecnología robusta y offline-first.</p>
            </div>
            <div></div>
            <div style="text-align: right;">
                <h5 style="margin-bottom: 15px;">Información Legal</h5>
                <p style="font-size: 0.8rem; color: var(--text-muted);">CajaYa SpA - RUT: 77.XXX.XXX-X</p>
                <p style="font-size: 0.8rem; color: var(--text-muted);">Santiago, Chile</p>
                <p style="font-size: 0.8rem; color: var(--text-muted);">hola@cajaya.cl</p>
            </div>
        </div>
    </footer>

    <script>
        // SALES UNIVERSE
        const universe = document.getElementById('universe');
        const symbols = ['$', '%', '+', '-', '×', '÷', '='];
        for (let i = 0; i < 40; i++) {
            const span = document.createElement('span');
            span.className = 'symbol';
            span.innerText = symbols[Math.floor(Math.random() * symbols.length)];
            span.style.left = Math.random() * 100 + 'vw';
            span.style.fontSize = (Math.random() * 20 + 10) + 'px';
            span.style.animationDelay = (Math.random() * 15) + 's';
            span.style.animationDuration = (Math.random() * 10 + 15) + 's';
            universe.appendChild(span);
        }

        // COUNTDOWN TIMER
        let time = 9912; 
        setInterval(() => {
            time--;
            let h = Math.floor(time / 3600);
            let m = Math.floor((time % 3600) / 60);
            let s = time % 60;
            document.getElementById('countdown').innerText = 
                `${h < 10 ? '0'+h : h}:${m < 10 ? '0'+m : m}:${s < 10 ? '0'+s : s}`;
        }, 1000);

        // FAQ
        document.querySelectorAll('.faq-question').forEach(item => {
            item.addEventListener('click', () => {
                item.parentElement.classList.toggle('active');
            });
        });
    </script>

</body>
</html>
