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
                    <h3 class="fw-bold mb-0">📘 Documentación de Integración</h3>
                    <p class="text-muted small">Guía técnica para el uso del catálogo de productos vía API</p>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid px-4">
                    <div class="card p-5 border-0 shadow-sm" style="background: #111827;">
                        <h4 class="text-primary mb-4">1. Autenticación</h4>
                        <p>Todas las peticiones deben incluir el parámetro <code>license_key</code>.</p>
                        
                        <h4 class="text-primary mb-4 mt-5">2. Obtener Catálogo</h4>
                        <div class="bg-black p-3 rounded mb-3">
                            <span class="badge bg-success">GET</span> <code>https://panel.cajaya.cl/api/catalog/list.php?license_key=TU_CLAVE</code>
                        </div>

                        <h4 class="text-primary mb-4 mt-5">3. Obtener Imágenes</h4>
                        <div class="bg-black p-3 rounded">
                            <span class="badge bg-success">GET</span> <code>https://panel.cajaya.cl/api/catalog/image.php?barcode=780...&license_key=TU_CLAVE</code>
                        </div>

                        <div class="alert alert-info mt-5 bg-info bg-opacity-10 border-info text-info">
                            <i class="fa-solid fa-lightbulb me-2"></i>
                            <strong>Tip:</strong> Puedes usar la licencia <code>DEVELOPER-TEST</code> para pruebas de integración.
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
