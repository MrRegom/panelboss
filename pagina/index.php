<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajaYa - El Sistema POS Definitivo</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Outfit:wght@600;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Efectos de iluminación traseros -->
    <div class="bg-orb orb-1"></div>
    <div class="bg-orb orb-2"></div>
    <div class="bg-grid"></div>
    
    <header class="navbar">
        <div class="logo-container">
            <img src="assets/logo.png" alt="CajaYa Logo" class="main-logo" style="height: 60px; width: auto; display: block;">
        </div>
        <nav>
            <a href="#beneficios" class="nav-link-desktop">Beneficios</a>
            <a href="#faq" class="nav-link-desktop">Preguntas</a>
            <a href="#registro" class="btn-primary-small">Descargar Demo</a>
        </nav>
    </header>

    <main>
        <!-- Hero Section (Impacto visual con texto a la izq y foto a la der) -->
        <section class="hero">
            <div class="hero-container">
                <div class="hero-content fade-in">
                    <div class="hero-badge">⚡ EL POS DE OTRO NIVEL</div>
                    <h1>El corazón digital de tu negocio,<br><span class="text-gradient">sin límites.</span></h1>
                    <p>Vende sin depender de internet, emite boletas del SII al instante y controla el stock de todas tus cajas en tiempo real. Combinamos tecnología corporativa con extrema facilidad de uso.</p>
                    <div class="hero-actions">
                        <a href="#registro" class="btn-primary">Descargar Demo Ahora</a>
                        <a href="#beneficios" class="btn-outline">Explorar Tecnología</a>
                    </div>
                </div>
                
                <div class="hero-image fade-in">
                    <div class="dashboard-glow"></div>
                    <img src="assets/cajaya_pos_mockup.png" alt="CajaYa POS Dashboard" class="dashboard-img">
                    
                    <!-- Elementos flotantes decorativos -->
                    <div class="float-badge float-top-right">
                        <span class="icon">✅</span> SII Integrado
                    </div>
                    <div class="float-badge float-bottom-left">
                        <span class="icon">🚀</span> Stock Local
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Grid (8 Beneficios) -->
        <section id="beneficios" class="features-section">
            <div class="section-title fade-in">
                <h2>Todo lo que necesitas, y mucho más</h2>
                <p>Tecnología invencible diseñada para tu tranquilidad financiera.</p>
            </div>

            <div class="features-grid">
                <!-- 1 -->
                <div class="feature-card glass-card fade-in">
                    <div class="icon-wrapper">💰</div>
                    <h3>100% Gratuito</h3>
                    <p>Sin costos ocultos. Digitaliza tu negocio sin afectar tu presupuesto. Transparencia total.</p>
                </div>
                <!-- 2 -->
                <div class="feature-card glass-card fade-in">
                    <div class="icon-wrapper">🧾</div>
                    <h3>Boleta Electrónica</h3>
                    <p>Cumple con el SII fácilmente. Emisión directa, centralizada y automatizada sin engorros.</p>
                </div>
                <!-- 3 -->
                <div class="feature-card glass-card highlight-card fade-in">
                    <div class="icon-wrapper">🌐</div>
                    <h3>Vende sin Internet</h3>
                    <p>Tu local jamás se detiene. Nuestra arquitectura LAN sigue operando y las boletas quedan en cola automática.</p>
                </div>
                <!-- 4 -->
                <div class="feature-card glass-card fade-in">
                    <div class="icon-wrapper">🔒</div>
                    <h3>Stock Seguro</h3>
                    <p>Bloqueo de concurrencia. Imposible vender stock negativo, incluso si dos cajas venden a la vez.</p>
                </div>
                <!-- 5 -->
                <div class="feature-card glass-card fade-in">
                    <div class="icon-wrapper">💻</div>
                    <h3>Multi-Caja Unificado</h3>
                    <p>1 sola licencia, 1 sola base de datos. Todas tus cajas sincronizadas viendo el inventario en milisegundos.</p>
                </div>
                <!-- 6 -->
                <div class="feature-card glass-card fade-in">
                    <div class="icon-wrapper">🖼️</div>
                    <h3>Precarga de Imágenes</h3>
                    <p>Catálogo visual instantáneo. Escanea el producto y nosotros ponemos la foto por arte de magia.</p>
                </div>
                <!-- 7 -->
                <div class="feature-card glass-card fade-in">
                    <div class="icon-wrapper">🏷️</div>
                    <h3>Hardware Plug & Play</h3>
                    <p>Conexión directa a impresoras, gavetas y etiquetadoras. Adiós a las lentitudes del navegador web.</p>
                </div>
                <!-- 8 -->
                <div class="feature-card glass-card fade-in">
                    <div class="icon-wrapper">🎧</div>
                    <h3>Soporte Experto 24/7</h3>
                    <p>No estás solo. Te acompañamos día y noche para resolver tus dudas y potenciar tu crecimiento.</p>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section id="faq" class="faq-section fade-in">
            <div class="section-title">
                <h2>Resolviendo tus dudas</h2>
                <p>Respuestas claras sobre nuestra infraestructura</p>
            </div>
            <div class="faq-container">
                <details class="faq-item glass-card">
                    <summary>¿Cómo funciona CajaYa si no hay internet?</summary>
                    <div class="faq-content">
                        Gracias a nuestro motor híbrido, el sistema instalado en tu PC se comunica por tu red local (LAN). Si el proveedor de internet falla, sigues abriendo la caja y emitiendo el ticket sin problema. Las boletas electrónicas se envían solas apenas regrese la conexión.
                    </div>
                </details>
                <details class="faq-item glass-card">
                    <summary>¿Tengo que descargar algo pesado?</summary>
                    <div class="faq-content">
                        No. Utilizamos una arquitectura de <strong>Cliente Liviano</strong>. El instalador pesa menos de 10MB. Se instala en segundos sin bases de datos complejas que pongan lenta tu computadora.
                    </div>
                </details>
                <details class="faq-item glass-card">
                    <summary>¿Se conecta directamente al SII?</summary>
                    <div class="faq-content">
                        Sí, la integración es nativa. Gestionamos los folios para que todas tus cajas facturen de forma sincronizada sin choques ni configuraciones de terceros.
                    </div>
                </details>
                <details class="faq-item glass-card">
                    <summary>¿Es de verdad 100% Gratuito?</summary>
                    <div class="faq-content">
                        Sí, la funcionalidad básica para operar tu negocio no tiene costo. Nuestro objetivo es democratizar la tecnología de alto nivel para todos los minimarkets y botillerías.
                    </div>
                </details>
            </div>
        </section>

        <!-- CTA / Registration -->
        <section id="registro" class="cta-section fade-in">
            <div class="cta-container">
                <div class="cta-text">
                    <h2>Únete a la nueva era.</h2>
                    <p>Pruébalo ahora mismo. Conecta tu cuenta y accede a una demo interactiva en menos de 10 segundos. Sin tarjetas de crédito, sin compromisos.</p>
                </div>
                <div class="cta-form">
                    <div class="social-login-container">
                        <div class="social-login">
                            <a href="https://api.cajaya.cl/auth.php?provider=google" class="btn-social google">
                                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google">
                                Continuar con Google
                            </a>
                        </div>
                        
                        <div class="divider">
                            <span>O solicita tu demo gratuita</span>
                        </div>

                        <form class="modern-form">
                            <input type="email" placeholder="Correo electrónico corporativo" required>
                            <button type="submit" class="btn-primary w-100" style="margin-top: 0.5rem; background: var(--bg-dark); border: 1px solid var(--primary);">Solicitar Demo Manual</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/56900000000" class="whatsapp-float" target="_blank" rel="noopener noreferrer">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
            <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
        </svg>
    </a>

    <script src="js/main.js"></script>
</body>
</html>
