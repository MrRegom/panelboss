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
    <title>CajaYa - El Punto de Venta que nunca se detiene</title>
    <meta name="description" content="Software POS empresarial con sincronización multi-caja, modo offline y boleta electrónica integrada.">
    <link rel="stylesheet" href="assets/css/modern.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="bg-glow"></div>

    <header>
        <div class="container nav">
            <div class="logo">
                <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 40px;">
                <span>CajaYa</span>
            </div>
            <div class="nav-links">
                <a href="<?= $downloadUrl ?>" class="btn-primary" style="padding: 0.6rem 1.2rem; font-size: 0.9rem;">DESCARGAR DEMO</a>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <span class="badge">🚀 LANZAMIENTO OFICIAL - ABRIL 2026</span>
                <h1>El POS que trabaja<br><span style="color: var(--primary)">donde tú estés.</span></h1>
                <p>Vende sin internet, sincroniza múltiples cajas en tiempo real y controla tu negocio desde cualquier lugar.</p>
                
                <div class="hero-actions" style="margin-bottom: 4rem;">
                    <a href="<?= $downloadUrl ?>" class="btn-primary" style="margin-bottom: 1rem;">DESCARGAR DEMO GRATIS</a>
                    <div style="margin-top: 15px;">
                        <span style="color: var(--text-muted); font-size: 0.8rem; display: block; margin-bottom: 10px;">O REGÍSTRATE AL INSTANTE:</span>
                        <a href="../admin/auth/google" class="btn-google">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google" style="width: 18px;">
                            Conectar con Google
                        </a>
                    </div>
                </div>

                <!-- SHOWCASE DE LA APP CON ANIMACIÓN -->
                <div class="product-showcase">
                    <img src="assets/img/app-preview.png" alt="CajaYa App" class="img-fluid reveal-app">
                </div>
            </div>
        </section>

        <!-- SECCIÓN DE BENEFICIOS (TODOS LOS CARDS) -->
        <section class="container" id="beneficios" style="padding: 100px 0;">
            <div style="text-align: center; margin-bottom: 4rem;">
                <h2 style="font-size: 2.5rem; font-weight: 800;">Todo lo que necesitas para ganar</h2>
            </div>
            <div class="features">
                <div class="feature-card">
                    <i class="fa-solid fa-cloud-slash"></i>
                    <h3>Modo Offline</h3>
                    <p>Venta continua sin depender de la señal.</p>
                </div>
                <div class="feature-card">
                    <i class="fa-solid fa-sync"></i>
                    <h3>Sincronización</h3>
                    <p>Tus cajas siempre alineadas en tiempo real.</p>
                </div>
                <div class="feature-card">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <h3>Boleta SII</h3>
                    <p>Emisión directa y automática al SII.</p>
                </div>
                <div class="feature-card">
                    <i class="fa-solid fa-chart-line"></i>
                    <h3>Reportes Pro</h3>
                    <p>Dashboard de ventas en vivo desde el celular.</p>
                </div>
                <div class="feature-card">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <h3>Stock Global</h3>
                    <p>Control de inventario multi-sucursal.</p>
                </div>
                <div class="feature-card">
                    <i class="fa-solid fa-shield-halved"></i>
                    <h3>Seguridad RSA</h3>
                    <p>Encriptación de grado bancario en tus datos.</p>
                </div>
            </div>
        </section>

        <section class="container" style="padding: 100px 0; text-align: center; border-top: 1px solid var(--border);">
            <h2 style="font-size: 3rem; font-weight: 800; margin-bottom: 2rem;">¿Listo para escalar tu negocio?</h2>
            <p style="color: var(--text-muted); max-width: 600px; margin: 0 auto 3rem;">Únete a los negocios que ya están vendiendo más rápido y con menos errores.</p>
            <a href="<?= $downloadUrl ?>" class="btn-primary">DESCARGAR INSTALADOR .EXE</a>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>© 2026 CajaYa - Desarrollado por PanelBoss Pro. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script>
        ScrollReveal().reveal('.feature-card', { 
            delay: 200,
            distance: '50px',
            origin: 'bottom',
            interval: 100 
        });
        ScrollReveal().reveal('h1, .badge, .hero p', { 
            delay: 100,
            distance: '30px',
            origin: 'top',
            interval: 150
        });
    </script>
</body>
</html>
