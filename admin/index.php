<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Services\AuthService;
use App\Config\Database;

AuthService::check();

try {
    $db = Database::getConnection();
    $total_licenses = $db->query("SELECT COUNT(*) FROM licenses")->fetchColumn();
    $active_licenses = $db->query("SELECT COUNT(*) FROM licenses WHERE status = 'active'")->fetchColumn();
    $total_companies = $db->query("SELECT COUNT(*) FROM companies")->fetchColumn();
} catch (\Exception $e) {
    die("Error de base de datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | PanelBoss Enterprise</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font: Inter (Estándar en Software Moderno) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <!-- Header con Usuario y Logout -->
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid px-4">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown user-menu"> 
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"> 
                            <span class="d-none d-md-inline fw-semibold me-2"><?= $_SESSION['user_name'] ?? 'Admin' ?></span>
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-user-tie text-white small"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" style="background: var(--bg-card);">
                            <li><a href="logout.php" class="dropdown-item py-2 text-danger fw-medium"><i class="fa-solid fa-right-from-bracket me-2"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Sidebar Sobrio -->
        <aside class="app-sidebar shadow-sm" data-bs-theme="dark">
            <div class="sidebar-brand"> 
                <a href="./index.php" class="brand-link border-0"> 
                    <span class="brand-text">PANELBOSS <span class="text-primary">PRO</span></span> 
                </a> 
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-3">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview">
                        <li class="nav-item mb-2"> <a href="./index.php" class="nav-link active"> <i class="nav-icon fa-solid fa-house"></i> <p>Dashboard</p> </a> </li>
                        <li class="nav-header small text-muted px-4 mt-3">OPERACIONES</li>
                        <li class="nav-item mb-2"> <a href="./licenses.php" class="nav-link"> <i class="nav-icon fa-solid fa-key"></i> <p>Licencias</p> </a> </li>
                        <li class="nav-item mb-2"> <a href="./companies.php" class="nav-link"> <i class="nav-icon fa-solid fa-building"></i> <p>Empresas</p> </a> </li>
                        <li class="nav-header small text-muted px-4 mt-3">SISTEMA</li>
                        <li class="nav-item mb-2"> <a href="./users.php" class="nav-link"> <i class="nav-icon fa-solid fa-users-gear"></i> <p>Usuarios</p> </a> </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Contenido Profesional -->
        <main class="app-main">
            <div class="app-content-header py-4">
                <div class="container-fluid px-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="fw-semibold mb-0">Vista General</h3>
                            <p class="text-muted small">Resumen ejecutivo del ecosistema CajaYa</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid px-4">
                    <!-- Cards Estilo SaaS -->
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="small-box">
                                <div class="inner">
                                    <p>Total Licencias</p>
                                    <h2><?= number_format($total_licenses) ?></h2>
                                </div>
                                <div class="icon"> <i class="fa-solid fa-id-card"></i> </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="small-box">
                                <div class="inner">
                                    <p>Terminales Online</p>
                                    <h2><?= number_format($active_licenses) ?></h2>
                                </div>
                                <div class="icon"> <i class="fa-solid fa-signal"></i> </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="small-box">
                                <div class="inner">
                                    <p>Empresas Activas</p>
                                    <h2><?= number_format($total_companies) ?></h2>
                                </div>
                                <div class="icon"> <i class="fa-solid fa-briefcase"></i> </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Información de Infraestructura -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-semibold mb-0">Estado de Infraestructura</h5>
                                    <span class="badge bg-primary bg-opacity-10 text-primary border-0">Estable</span>
                                </div>
                                <p class="text-muted small mb-0">
                                    Núcleo de servicios desplegado sobre **PostgreSQL 17** (Puerto 5433). 
                                    La arquitectura multi-tenant está sincronizada y lista para escalamiento horizontal.
                                </p>
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
