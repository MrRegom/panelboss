<?php
require_once __DIR__ . '/includes/bootstrap.php';
use App\Services\AuthService;
AuthService::check();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Documentación API | PanelBoss PRO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
    <style>
        :root {
            --ios-bg: #f5f5f7;
            --code-bg: #1e1e1e;
        }
        .api-card {
            border-radius: 24px;
            border: 1px solid rgba(0,0,0,0.05) !important;
            overflow: hidden;
        }
        .method-badge {
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        .code-block {
            background: var(--code-bg);
            border-radius: 16px;
            padding: 20px;
            position: relative;
            font-family: 'Fira Code', monospace;
            box-shadow: inset 0 2px 10px rgba(0,0,0,0.2);
        }
        .code-block code {
            color: #d4d4d4;
            font-size: 0.9rem;
        }
        .code-block .url-param { color: #ce9178; }
        .code-block .url-base { color: #9cdcfe; }
        
        .copy-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(255,255,255,0.1);
            border: none;
            color: #fff;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.7rem;
            cursor: pointer;
            transition: 0.2s;
        }
        .copy-btn:hover { background: rgba(255,255,255,0.2); }

        .section-nav {
            position: sticky;
            top: 20px;
        }
        .nav-doc-link {
            display: block;
            padding: 10px 15px;
            color: #636e72;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 5px;
            font-weight: 500;
            transition: 0.2s;
        }
        .nav-doc-link:hover, .nav-doc-link.active {
            background: var(--primary-soft);
            color: var(--primary-color);
        }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid px-4">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 border-0">API STATUS: ONLINE</span>
                    </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header py-4">
                <div class="container-fluid px-2 px-md-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="fw-bold mb-2" style="letter-spacing: -1px;">Developer Hub</h1>
                            <p class="text-muted lead">Documentación técnica para integración de catálogo y sincronización de datos.</p>
                        </div>
                        <div class="col-md-4 text-end d-none d-md-block">
                            <img src="img/api-icon.png" alt="" style="height: 100px; opacity: 0.8; filter: drop-shadow(0 10px 20px rgba(106, 55, 183, 0.2));">
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid px-2 px-md-4 pb-5">
                    <div class="row">
                        <!-- Navegación Superior (Nuevo Estilo) -->
                        <div class="col-12 mb-4">
                            <div class="d-flex gap-2 p-2 bg-white rounded-4 shadow-sm border overflow-auto">
                                <a href="#sandbox" class="btn btn-sm btn-light px-4 py-2 rounded-3 fw-bold active">Entorno Sandbox</a>
                                <a href="#catalog" class="btn btn-sm btn-light px-4 py-2 rounded-3 fw-bold">Catálogo Maestro</a>
                                <a href="#images" class="btn btn-sm btn-light px-4 py-2 rounded-3 fw-bold">Servidor de Imágenes</a>
                                <a href="#auth" class="btn btn-sm btn-light px-4 py-2 rounded-3 fw-bold">Autenticación v4.0</a>
                            </div>
                        </div>

                        <!-- Contenido Principal (Ahora ocupa todo el ancho) -->
                        <div class="col-12">
                            <!-- Auth Section (NUEVA) -->
                            <section id="auth" class="mb-5">
                                <div class="card api-card shadow-sm border-0 bg-white overflow-hidden">
                                    <div class="card-header bg-dark text-white p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary p-3 rounded-3 me-3">
                                                <i class="fa-solid fa-shield-halved fa-2x"></i>
                                            </div>
                                            <div>
                                                <h4 class="mb-0 fw-bold">Autenticación v4.0 y Activación</h4>
                                                <span class="badge bg-warning text-dark">ACTUALIZADO</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-5">
                                        <h5>1. Activación de Licencia y Máquina (Una sola vez)</h5>
                                        <p>Para activar una nueva máquina y vincularla a una licencia adquirida, envíe los datos por <code>POST</code>. Utilice su llave maestra de API en el header <code>X-Client-Id</code>.</p>
                                        
                                        <div class="bg-dark p-3 rounded-4 mb-4">
                                            <code class="text-warning small">
                                                curl -X POST "https://api.cajaya.cl/activate.php" \<br>
                                                -H "Content-Type: application/json" \<br>
                                                -H "X-Client-Id: {TU_API_SHARED_KEY}" \<br>
                                                -d '{<br>
                                                &nbsp;&nbsp;"license_key": "CJYA-DEMO-XXXXX",<br>
                                                &nbsp;&nbsp;"machine_id": "TEST-MACHINE-001",<br>
                                                &nbsp;&nbsp;"hostname": "localhost",<br>
                                                &nbsp;&nbsp;"version": "1.0.0",<br>
                                                &nbsp;&nbsp;"business_name": "Mi Negocio Test",<br>
                                                &nbsp;&nbsp;"rut": "12345678-9",<br>
                                                &nbsp;&nbsp;"email": "test@example.com",<br>
                                                &nbsp;&nbsp;"address": "Calle Falsa 123",<br>
                                                &nbsp;&nbsp;"phone": "+56912345678"<br>
                                                }'
                                            </code>
                                        </div>

                                        <h5>2. Obtención de Token (Login diario)</h5>
                                        <p>Una vez que la máquina está activada, solicite un Token JWT (Bearer) que expirará en 1 hora. 
                                        <strong>No requiere enviar ningún Body o JSON.</strong> Sólo envíe una petición POST vacía, incluyendo su Licencia en el Header <code>X-Client-Id</code>.</p>
                                        
                                        <div class="bg-dark p-3 rounded-4 mb-4">
                                            <code class="text-warning small">
                                                curl -X POST "https://api.cajaya.cl/auth/login.php" \<br>
                                                -H "X-Client-Id: CJYA-DEMO-XXXXX"
                                            </code>
                                        </div>

                                        <div class="alert bg-success bg-opacity-10 border-0 rounded-4 p-3 mb-4">
                                            <div class="small text-success">
                                                <i class="fa-solid fa-check-circle me-1"></i>
                                                <strong>Respuesta esperada:</strong> Recibirá un JSON con la propiedad <code>data.token</code>. Ese es el Token JWT que debe utilizar en los siguientes pasos.
                                            </div>
                                        </div>

                                        <h5>3. Uso del Token en la API (Catálogo, etc.)</h5>
                                        <p>Envíe el token recibido en el header <code>Authorization</code> de sus siguientes peticiones seguras.</p>
                                        
                                        <div class="bg-dark p-3 rounded-4 mb-0">
                                            <code class="text-warning small">
                                                curl -X POST "https://api.cajaya.cl/catalog/list.php" \<br>
                                                -H "Authorization: Bearer {TU_TOKEN_AQUÍ}"
                                            </code>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Sandbox Section -->
                            <section id="sandbox" class="mb-5">
                                <div class="card api-card shadow-sm border-0 bg-white">
                                    <div class="card-body p-5">
                                        <div class="d-flex align-items-center mb-4">
                                            <div class="bg-primary rounded-4 d-flex align-items-center justify-content-center me-3" style="width: 54px; height: 54px;">
                                                <i class="fa-solid fa-flask text-white fs-4"></i>
                                            </div>
                                            <div>
                                                <h4 class="fw-bold mb-0">Entorno de Pruebas</h4>
                                                <span class="text-muted small">Configuración inicial para Partners</span>
                                            </div>
                                        </div>
                                        <p class="text-muted">Utilice la siguiente licencia global para validar sus peticiones durante la fase de desarrollo. No tiene límites de tasa (rate limiting) para facilitar el debug.</p>
                                        
                                        <div class="bg-light rounded-4 p-4 d-flex align-items-center justify-content-between border">
                                            <div>
                                                <span class="d-block small fw-bold text-muted mb-1">GLOBAL LICENSE KEY</span>
                                                <code class="fs-5 fw-bold text-primary">DEVELOPER-TEST</code>
                                            </div>
                                            <span class="badge bg-success bg-opacity-10 text-success px-4 py-2 border-0">ACTIVE SANDBOX</span>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Endpoints Section -->
                            <section id="catalog" class="mb-5">
                                <h3 class="fw-bold mb-4">Endpoints de Productos</h3>
                                
                                <div class="card api-card shadow-sm border-0 mb-4">
                                    <div class="card-body p-5">
                                        <div class="d-flex align-items-start justify-content-between mb-4">
                                            <div>
                                                <span class="method-badge bg-primary text-white mb-2 d-inline-block">POST</span>
                                                <h5 class="fw-bold">Obtener Catálogo Maestro</h5>
                                                <p class="text-muted small">Retorna el listado completo de productos (+7,000 items) en formato JSON.</p>
                                            </div>
                                        </div>

                                        <div class="code-block mb-4">
                                            <button class="copy-btn"><i class="fa-regular fa-copy me-1"></i> Copiar</button>
                                            <code>
                                                <span class="url-base">https://api.cajaya.cl/catalog/</span>list.php
                                            </code>
                                        </div>

                                        <div class="bg-dark p-3 rounded-4 mb-3">
                                            <code class="text-warning small">
                                                curl -X POST "https://api.cajaya.cl/catalog/list.php" \<br>
                                                -H "X-Client-Id: DEVELOPER-TEST"
                                            </code>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="images" class="mb-5">
                                <div class="card api-card shadow-sm border-0">
                                    <div class="card-body p-5">
                                        <div class="d-flex align-items-start justify-content-between mb-4">
                                            <div>
                                                <span class="method-badge bg-primary text-white mb-2 d-inline-block">POST</span>
                                                <h5 class="fw-bold">Servidor de Imágenes</h5>
                                                <p class="text-muted small">Endpoint optimizado para servir imágenes de productos vía Barcode.</p>
                                            </div>
                                        </div>

                                        <div class="code-block mb-4">
                                            <button class="copy-btn"><i class="fa-regular fa-copy me-1"></i> Copiar</button>
                                            <code>
                                                <span class="url-base">https://api.cajaya.cl/catalog/</span>image.php?<span class="url-param">barcode</span>={EAN13}
                                            </code>
                                        </div>
                                        
                                        <div class="bg-dark p-3 rounded-4 mb-3">
                                            <code class="text-warning small">
                                                curl -X POST "https://api.cajaya.cl/catalog/image.php?barcode=8434165469037" \<br>
                                                -H "X-Client-Id: DEVELOPER-TEST"
                                            </code>
                                        </div>

                                        <div class="alert bg-primary bg-opacity-5 border-0 rounded-4 p-4 mb-0">
                                            <div class="d-flex gap-3">
                                                <i class="fa-solid fa-circle-info text-primary fs-4"></i>
                                                <div class="small text-muted">
                                                    <strong class="text-primary d-block mb-1">Nota de Rendimiento:</strong>
                                                    Este endpoint utiliza una capa de caché de alto rendimiento. Las imágenes se sirven en formato WebP para minimizar el consumo de ancho de banda en dispositivos móviles.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </section>

                             <!-- Auth Section -->
                             <section id="auth" class="mb-5">
                                 <h3 class="fw-bold mb-4">Seguridad y Autenticación</h3>
                                 <div class="card api-card shadow-sm border-0">
                                     <div class="card-body p-5">
                                         <p class="text-muted">Para los endpoints de sistema (Activación y Heartbeat), se debe incluir el identificador de cliente en los headers de la petición.</p>
                                         
                                         <div class="table-responsive">
                                             <table class="table table-bordered align-middle">
                                                 <thead class="bg-light">
                                                     <tr>
                                                         <th>Header</th>
                                                         <th>Valor</th>
                                                         <th>Descripción</th>
                                                     </tr>
                                                 </thead>
                                                 <tbody>
                                                     <tr>
                                                         <td><code class="text-primary">X-Client-Id</code></td>
                                                         <td><code>{TU_API_KEY}</code></td>
                                                         <td>Identificador único proporcionado por el administrador.</td>
                                                     </tr>
                                                 </tbody>
                                             </table>
                                         </div>

                                         <div class="alert bg-warning bg-opacity-10 border-0 rounded-4 p-4 mt-3">
                                             <div class="d-flex gap-3">
                                                 <i class="fa-solid fa-triangle-exclamation text-warning fs-4"></i>
                                                 <div class="small text-muted">
                                                     <strong class="text-warning d-block mb-1">Nota importante:</strong>
                                                     Anteriormente este campo se llamaba <code>X-API-KEY</code>. A partir de la v2.4, se ha renombrado a <code>X-Client-Id</code> para mayor claridad semántica.
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </section>
                         </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/js/adminlte.min.js"></script>
    <script>
        // Simple Copy to Clipboard
        document.querySelectorAll('.copy-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const code = this.nextElementSibling.innerText;
                navigator.clipboard.writeText(code);
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fa-solid fa-check me-1"></i> Copiado';
                setTimeout(() => this.innerHTML = originalText, 2000);
            });
        });
    </script>
</body>
</html>
