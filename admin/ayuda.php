<?php
require_once __DIR__ . '/includes/bootstrap.php';
use App\Services\AuthService;
AuthService::check();
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Documentación API | PanelBoss</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid px-4">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header py-4">
                <div class="container-fluid px-4">
                    <h3 class="fw-bold mb-0 text-primary">📘 Centro de Integración para Partners</h3>
                    <p class="text-muted small">Guía técnica completa para el despliegue del catálogo CajaYa</p>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid px-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <!-- SECCIÓN: LICENCIA DE PRUEBAS -->
                            <div class="card p-4 border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #1e293b 0%, #111827 100%);">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3 text-primary">
                                        <i class="fa-solid fa-vial-circle-check fs-4"></i>
                                    </div>
                                    <h4 class="mb-0 fw-bold">Entorno de Desarrollo (Sandbox)</h4>
                                </div>
                                <p>El partner debe utilizar la siguiente licencia para todas las pruebas de integración iniciales:</p>
                                <div class="table-responsive">
                                    <table class="table table-dark table-borderless align-middle mb-0">
                                        <thead>
                                            <tr class="text-muted small">
                                                <th>PARÁMETRO</th>
                                                <th>VALOR REQUERIDO</th>
                                                <th>ESTADO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><code>license_key</code></td>
                                                <td><span class="badge bg-primary fs-6 p-2">DEVELOPER-TEST</span></td>
                                                <td><span class="text-success"><i class="fa-solid fa-circle-check me-1"></i> ACTIVA</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- SECCIÓN: ENDPOINTS -->
                            <div class="card p-4 border-0 shadow-sm" style="background: #1a1a1a;">
                                <h4 class="fw-bold mb-4">Endpoints de Sincronización</h4>
                                
                                <div class="mb-5">
                                    <h5 class="text-info"><i class="fa-solid fa-list-check me-2"></i> 1. Catálogo Completo</h5>
                                    <p class="text-muted small">Retorna el maestro de productos actualizado (+7,000 items).</p>
                                    <div class="bg-black p-3 rounded-3 border border-secondary d-flex align-items-center">
                                        <span class="badge bg-success me-3">GET</span>
                                        <code>https://panel.cajaya.cl/api/catalog/list.php?license_key=DEVELOPER-TEST</code>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h5 class="text-info"><i class="fa-solid fa-image me-2"></i> 2. Servidor de Imágenes</h5>
                                    <p class="text-muted small">Proxy de alto rendimiento para visualización de productos.</p>
                                    <div class="bg-black p-3 rounded-3 border border-secondary d-flex align-items-center">
                                        <span class="badge bg-success me-3">GET</span>
                                        <code>https://panel.cajaya.cl/api/catalog/image.php?barcode={843...}&license_key=DEVELOPER-TEST</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/js/adminlte.min.js"></script>
</body>
</html>
