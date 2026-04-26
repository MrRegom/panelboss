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
            --accent: #f97316; /* Naranja para CTA de alta conversión */
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

        .container { max-width: 1100px; margin: 0 auto; padding: 0 25px; width: 100%; }

        /* --- SALES UNIVERSE --- */
        .sales-universe {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: -1; overflow: hidden; opacity: 0.3;
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
            background: #ef4444; color: #fff; text-align: center; padding: 12px 0;
            font-size: 0.9rem; font-weight: 800; position: sticky; top: 0; z-index: 1200;
        }

        /* --- HEADER --- */
        header {
            padding: 20px 0; position: sticky; top: 44px; z-index: 1000;
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
        
        .btn-cta {
            background: var(--accent); color: #fff; padding: 12px 25px; border-radius: 12px;
            font-weight: 800; text-decoration: none; box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
            transition: 0.3s; border: none; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(249, 115, 22, 0.6); }

        /* --- HERO --- */
        .hero { padding: 80px 0; }
        .hero-title { font-size: 4.8rem; font-weight: 900; line-height: 1; margin-bottom: 30px; letter-spacing: -3px; }
        .hero-desc { font-size: 1.3rem; color: var(--text-muted); margin-bottom: 45px; max-width: 600px; }
        
        .hero-stats { display: flex; gap: 30px; margin-top: 40px; }
        .stat-card { text-align: center; }
        .stat-card h3 { font-size: 1.8rem; color: #fff; font-family: 'Outfit'; }
        .stat-card p { font-size: 0.75rem; color: var(--text-muted); }

        /* --- PROOF SECTION --- */
        .proof-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 60px; }
        .proof-card { background: var(--bg-card); padding: 30px; border-radius: 20px; border: 1px solid var(--border); }
        .proof-card p { font-style: italic; font-size: 0.9rem; margin-bottom: 20px; }
        .client-info { display: flex; align-items: center; gap: 12px; }
        .client-avatar { width: 40px; height: 40px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; }

        /* --- SOFTWARE PREVIEW --- */
        .sw-preview { padding: 100px 0; background: rgba(124, 58, 237, 0.03); border-radius: 40px; margin: 50px 0; }
        .sw-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
        .sw-img { width: 100%; border-radius: 20px; border: 1px solid var(--border); box-shadow: 0 20px 50px rgba(0,0,0,0.6); transition: 0.5s; }
        .sw-img:hover { transform: scale(1.02); }

        /* --- COMPARISON --- */
        .comp-table { width: 100%; border-collapse: separate; border-spacing: 0; background: var(--bg-card); border-radius: 24px; overflow: hidden; margin-top: 50px; }
        .comp-table th, .comp-table td { padding: 25px; text-align: center; border-bottom: 1px solid var(--border); }
        .comp-table .feature { text-align: left; padding-left: 40px; font-weight: 600; }
        .comp-table .cajaya-col { background: rgba(124, 58, 237, 0.1); color: #fff; font-weight: 800; }

        /* --- PRICING --- */
        .pricing-section { padding: 100px 0; }
        .price-card { background: var(--bg-card); border: 1px solid var(--border); padding: 50px 35px; border-radius: 30px; display: flex; flex-direction: column; position: relative; transition: 0.3s; }
        .price-card.featured { border-color: var(--accent); box-shadow: 0 0 40px rgba(249, 115, 22, 0.2); transform: scale(1.05); z-index: 10; }
        .price-tag { font-size: 3rem; font-weight: 900; margin: 20px 0; }
        .price-features { list-style: none; margin: 30px 0; flex-grow: 1; text-align: left; }
        .price-features li { margin-bottom: 12px; display: flex; align-items: center; gap: 10px; font-size: 0.95rem; }
        .price-features i { color: var(--success); }

        /* --- FAQ --- */
        .faq-item { background: var(--bg-card); border: 1px solid var(--border); border-radius: 18px; margin-bottom: 15px; }
        .faq-question { padding: 25px; cursor: pointer; display: flex; justify-content: space-between; font-weight: 700; }
        .faq-answer { padding: 0 25px; max-height: 0; overflow: hidden; transition: 0.4s; color: var(--text-muted); }
        .faq-item.active .faq-answer { padding: 0 25px 25px; max-height: 300px; }

        /* --- FOOTER --- */
        footer { padding: 80px 0; background: #050508; border-top: 1px solid var(--border); }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1.5fr; gap: 50px; }

        /* --- RESPONSIVE --- */
        @media (max-width: 992px) {
            .hero-title { font-size: 3.5rem; }
            .sw-grid { grid-template-columns: 1fr; }
            .proof-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="sales-universe" id="universe"></div>

    <div class="urgency-banner">
        ⚠️ ÚLTIMOS CUPOS: Oferta Instalación Gratis finaliza en <span id="countdown">02:45:12</span>. (Solo 3 cupos disponibles hoy)
    </div>

    <header>
        <div class="container nav-wrapper">
            <a href="#hero" class="logo-container">
                <div class="logo-base"></div>
                <div class="logo-overlay"></div>
            </a>
            <nav style="display: flex; gap: 30px; align-items: center;">
                <a href="#demo" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Cómo funciona</a>
                <a href="#precios" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Planes</a>
                <a href="https://wa.me/56959764771" class="btn-cta" style="background: transparent; border: 1px solid var(--accent); padding: 8px 15px;">Hablar con Soporte</a>
            </nav>
            <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-cta">Prueba Gratis 30 Días</a>
        </div>
    </header>

    <section id="hero" class="hero">
        <div class="container">
            <div style="text-align: center; max-width: 900px; margin: 0 auto;">
                <div style="background: rgba(124, 58, 237, 0.1); display: inline-block; padding: 6px 15px; border-radius: 50px; color: var(--accent); font-weight: 800; font-size: 0.75rem; margin-bottom: 20px;">
                    🚀 POS CHILENO CERTIFICADO SII 2026
                </div>
                <h1 class="hero-title">Tu negocio vende más. <br> <span style="background: linear-gradient(90deg, #fff, var(--primary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Tú trabajas menos.</span></h1>
                <p class="hero-desc" style="margin: 0 auto 40px;">Controla tus ventas y stock con el sistema que no se detiene si se cae el internet. Instalación en 10 minutos.</p>
                <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                    <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-cta" style="padding: 20px 45px; font-size: 1.2rem;">Empezar mi Prueba Gratis <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="hero-stats" style="justify-content: center;">
                    <div class="stat-card"><h3>+400</h3><p>NEGOCIOS CONFÍAN</p></div>
                    <div class="stat-card"><h3>100%</h3><p>OFFLINE-READY</p></div>
                    <div class="stat-card"><h3>24/7</h3><p>SOPORTE PREMIUM</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- PRUEBA SOCIAL -->
    <section class="container" style="padding: 60px 0;">
        <div class="proof-grid">
            <div class="proof-card">
                <p>"Desde que uso CajaYa, el cierre de caja pasó de 40 minutos a 1 clic. La boleta electrónica vuela."</p>
                <div class="client-info">
                    <div class="client-avatar">R</div>
                    <div><strong>Roberto M.</strong><br><span style="font-size: 0.75rem; color: var(--text-muted);">Dueño de Minimarket</span></div>
                </div>
            </div>
            <div class="proof-card" style="border-color: var(--accent);">
                <p>"El Plan Lifetime fue la mejor inversión. Dejé de pagar 30 lucas mensuales para siempre."</p>
                <div class="client-info">
                    <div class="client-avatar" style="background: var(--accent);">S</div>
                    <div><strong>Sandra P.</strong><br><span style="font-size: 0.75rem; color: var(--text-muted);">Dueña de Botillería</span></div>
                </div>
            </div>
            <div class="proof-card">
                <p>"Se nos fue el internet por 3 horas y el sistema ni se inmutó. Sincronizó todo al volver. Impresionante."</p>
                <div class="client-info">
                    <div class="client-avatar">J</div>
                    <div><strong>Juan Carlos L.</strong><br><span style="font-size: 0.75rem; color: var(--text-muted);">Ferretería El Trébol</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- EL SOFTWARE POR DENTRO -->
    <section id="demo" class="container sw-preview">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 3rem;">Visualiza tu éxito</h2>
            <p style="color: var(--text-muted);">No es solo un software, es el control total de tu caja.</p>
        </div>
        <div class="sw-grid">
            <div style="text-align: left;">
                <h3 style="font-size: 2rem; margin-bottom: 20px;">Dashboard de Inteligencia</h3>
                <p style="margin-bottom: 30px; color: var(--text-muted);">Mira cuánto estás ganando realmente. Gráficos en tiempo real de tus productos más vendidos y alertas de stock bajo automáticas.</p>
                <ul style="list-style: none; display: grid; gap: 15px;">
                    <li><i class="fa-solid fa-check" style="color: var(--success);"></i> Reportes X y Z en 2 segundos</li>
                    <li><i class="fa-solid fa-check" style="color: var(--success);"></i> Acceso desde tu celular</li>
                    <li><i class="fa-solid fa-check" style="color: var(--success);"></i> Control de mermas y gastos</li>
                </ul>
            </div>
            <div>
                <img src="assets/cajaya_software_interface_v1.png" alt="Dashboard CajaYa" class="sw-img">
            </div>
        </div>
        <div class="sw-grid" style="margin-top: 80px;">
            <div style="order: 2;">
                <h3 style="font-size: 2rem; margin-bottom: 20px;">Ventas en un toque</h3>
                <p style="margin-bottom: 30px; color: var(--text-muted);">Diseñado para pantallas táctiles. Busca productos por código de barra, nombre o categorías visuales con fotos.</p>
                <ul style="list-style: none; display: grid; gap: 15px;">
                    <li><i class="fa-solid fa-check" style="color: var(--success);"></i> Compatible con gavetas y scanners</li>
                    <li><i class="fa-solid fa-check" style="color: var(--success);"></i> Formas de pago múltiples</li>
                    <li><i class="fa-solid fa-check" style="color: var(--success);"></i> 100% Offline (Vende sin Internet)</li>
                </ul>
            </div>
            <div style="order: 1;">
                <img src="assets/cajaya_pos_selling_v1.png" alt="POS CajaYa" class="sw-img">
            </div>
        </div>
    </section>

    <!-- COMPARATIVA -->
    <section class="container" style="padding: 80px 0;">
        <h2 style="text-align: center; font-size: 2.8rem; margin-bottom: 50px;">CajaYa vs La Competencia</h2>
        <table class="comp-table">
            <thead>
                <tr>
                    <th class="feature">Característica</th>
                    <th class="cajaya-col">CajaYa</th>
                    <th>Otros POS</th>
                </tr>
            </thead>
            <tbody>
                <tr><td class="feature">Costos Mensuales</td><td class="cajaya-col">$0 (Plan Lifetime)</td><td>$30.000+ eternos</td></tr>
                <tr><td class="feature">Internet Caído</td><td class="cajaya-col">Sigue Vendiendo</td><td>Sistema bloqueado</td></tr>
                <tr><td class="feature">Soporte por WhatsApp</td><td class="cajaya-col">SÍ (Inmediato)</td><td>Sistema de tickets</td></tr>
                <tr><td class="feature">Garantía de Satisfacción</td><td class="cajaya-col">30 días (100% devolución)</td><td>No reembolsable</td></tr>
            </tbody>
        </table>
    </section>

    <!-- PRECIOS -->
    <section id="precios" class="pricing-section container">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 3.5rem;">Planes Claros. Sin Letra Chica.</h2>
        </div>
        <div class="pricing-grid">
            <div class="price-card">
                <h3>Básico</h3>
                <div class="price-tag">$20.000 <span>/mes</span></div>
                <ul class="price-features">
                    <li><i class="fa-solid fa-check"></i> Integración SII Completa</li>
                    <li><i class="fa-solid fa-check"></i> Inventario Profesional</li>
                    <li><i class="fa-solid fa-check"></i> Reportes X/Z en 1 clic</li>
                    <li><i class="fa-solid fa-check"></i> Soporte Premium</li>
                </ul>
                <a href="#" class="btn-cta" style="background: transparent; border: 1px solid var(--border);">Empezar Gratis</a>
            </div>
            <div class="price-card featured">
                <div class="badge-recommended">EL MÁS BUSCADO</div>
                <h3>Plan Lifetime</h3>
                <div class="price-tag">$180.000 <span>ÚNICO PAGO</span></div>
                <p style="font-size: 0.8rem; color: var(--accent); font-weight: 800; margin-bottom: 10px;">¡Ahorras $360.000 el primer año!</p>
                <ul class="price-features">
                    <li><i class="fa-solid fa-check"></i> <strong>Licencia de por vida</strong></li>
                    <li><i class="fa-solid fa-check"></i> Actualizaciones Legales Incluidas</li>
                    <li><i class="fa-solid fa-check"></i> Sin mensualidades, NUNCA MÁS</li>
                    <li><i class="fa-solid fa-check"></i> Multi-Caja Ilimitado</li>
                </ul>
                <a href="#" class="btn-cta">Comprar Licencia para Siempre</a>
                <p style="font-size: 0.7rem; color: var(--text-muted); margin-top: 15px;">Incluye Garantía de 30 días.</p>
            </div>
            <div class="price-card">
                <h3>Premium</h3>
                <div class="price-tag">$35.000 <span>/mes</span></div>
                <ul class="price-features">
                    <li><i class="fa-solid fa-check"></i> Todo lo del Plan Básico</li>
                    <li><i class="fa-solid fa-check"></i> Respaldos Automáticos Cloud</li>
                    <li><i class="fa-solid fa-check"></i> Multi-Sucursal Avanzado</li>
                    <li><i class="fa-solid fa-check"></i> Atención Prioritaria</li>
                </ul>
                <a href="#" class="btn-cta" style="background: transparent; border: 1px solid var(--border);">Empezar Gratis</a>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="container" style="padding: 100px 0;">
        <h2 style="text-align: center; margin-bottom: 50px;">Resolviendo tus dudas</h2>
        <div style="max-width: 800px; margin: 0 auto;">
            <div class="faq-item">
                <div class="faq-question">¿Qué pasa si no me gusta el sistema? <i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer">Tienes 30 días de garantía total. Si sientes que CajaYa no es para ti, te devolvemos el 100% de tu dinero sin preguntas. Tu inversión está segura.</div>
            </div>
            <div class="faq-item">
                <div class="faq-question">¿Sirve para mi negocio? (Botillería, Almacén, etc) <i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer">CajaYa está optimizado para Retail: Minimarkets, Botillerías, Ferreterías y Tiendas de Ropa. Si vendes productos físicos, CajaYa es tu mejor aliado.</div>
            </div>
            <div class="faq-item">
                <div class="faq-question">¿Incluye actualizaciones del SII? <i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer">Sí. Todas las actualizaciones legales necesarias para emitir boletas y facturas electrónicas 2026 están incluidas sin costo extra, incluso en el Plan Lifetime.</div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="logo-container" style="margin-bottom: 20px;">
                        <div class="logo-base"></div>
                        <div class="logo-overlay"></div>
                    </div>
                    <p style="font-size: 0.9rem; color: var(--text-muted);">Transformando la gestión de las Pymes chilenas con tecnología robusta y offline-first.</p>
                </div>
                <div style="text-align: right;">
                    <h5 style="margin-bottom: 15px;">Institucional</h5>
                    <p style="font-size: 0.8rem; color: var(--text-muted);">CajaYa SpA - RUT: 77.XXX.XXX-X</p>
                    <p style="font-size: 0.8rem; color: var(--text-muted);">Santiago, Chile</p>
                    <p style="font-size: 0.8rem; color: var(--text-muted);">hola@cajaya.cl</p>
                </div>
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
        let time = 9912; // 02:45:12 en segundos
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
