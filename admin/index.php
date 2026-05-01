<?php
require_once __DIR__ . '/includes/bootstrap.php';
use App\Services\AuthService;
use App\Config\Database;

AuthService::check();

try {
    $db = Database::getConnection();
    $total_licenses = $db->query("SELECT COUNT(*) FROM licenses")->fetchColumn();
    $active_licenses = $db->query("SELECT COUNT(*) FROM licenses WHERE status = 'active'")->fetchColumn();
    $total_companies = $db->query("SELECT COUNT(*) FROM companies")->fetchColumn();
    $total_leads = $db->query("SELECT COUNT(*) FROM leads")->fetchColumn();
    
    // Obtener últimos leads para dar "vida" al dashboard
    $recent_leads = $db->query("SELECT full_name, email, created_at FROM leads ORDER BY created_at DESC LIMIT 5")->fetchAll();
} catch (\Exception $e) {
    die("Error de base de datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vista General | PanelBoss Gold</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid px-4">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                    <li class="nav-item d-none d-sm-block ms-3">
                        <span class="text-muted small fw-bold">PROYECTO: <span class="text-dark">CAJAYA ENTERPRISE</span></span>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <span class="status-indicator status-online shadow-sm">
                            <i class="fa-solid fa-circle me-2" style="font-size: 0.5rem;"></i> SISTEMA ESTABLE
                        </span>
                    </li>
                    <li class="nav-item dropdown user-menu"> 
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center p-0" data-bs-toggle="dropdown"> 
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px; border: 2px solid #fff;">
                                <i class="fa-solid fa-user-tie text-white"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-2 rounded-4">
                            <li><h6 class="dropdown-header text-muted small fw-bold">CUENTA</h6></li>
                            <li><a href="#" class="dropdown-item rounded-3 py-2"><i class="fa-solid fa-user me-2"></i> Perfil</a></li>
                            <li><hr class="dropdown-divider opacity-10"></li>
                            <li><a href="logout.php" class="dropdown-item rounded-3 py-2 text-danger fw-bold"><i class="fa-solid fa-right-from-bracket me-2"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="page-header">
                <div class="container-fluid px-5">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h1 class="page-title mb-1">Centro de Operaciones</h1>
                            <p class="text-muted lead mb-0">Monitorización global del ecosistema POS CajaYa.</p>
                        </div>
                        <div class="col-md-5 text-end d-none d-md-block">
                            <div class="btn-group shadow-sm rounded-4 overflow-hidden">
                                <button class="btn btn-white border px-4 py-2 bg-white fw-bold">EXPORTAR</button>
                                <button class="btn btn-primary px-4 py-2 fw-bold">NUEVA LICENCIA</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid px-5">
                    <!-- Dashboard Cards -->
                    <div class="row g-4">
                        <div class="col-lg-3 col-md-6">
                            <div class="card-premium">
                                <div class="card-icon bg-primary bg-opacity-10 text-primary">
                                    <i class="fa-solid fa-id-card"></i>
                                </div>
                                <p class="label">Total Licencias</p>
                                <h2 class="value"><?= number_format($total_licenses) ?></h2>
                                <div class="mt-3 small text-muted">
                                    <i class="fa-solid fa-arrow-up text-success me-1"></i> <span class="fw-bold text-dark">+12%</span> vs mes anterior
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card-premium">
                                <div class="card-icon bg-success bg-opacity-10 text-success">
                                    <i class="fa-solid fa-signal"></i>
                                </div>
                                <p class="label">Terminales Online</p>
                                <h2 class="value"><?= number_format($active_licenses) ?></h2>
                                <div class="mt-3">
                                    <span class="badge bg-success bg-opacity-10 text-success border-0 px-2 py-1 small">REAL TIME</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card-premium">
                                <div class="card-icon bg-info bg-opacity-10 text-info">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div>
                                <p class="label">Empresas Activas</p>
                                <h2 class="value"><?= number_format($total_companies) ?></h2>
                                <div class="mt-3 small text-muted">
                                    Infraestructura <span class="text-dark fw-bold">Multi-tenant</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card-premium" style="background: var(--sidebar-bg);">
                                <div class="card-icon bg-white bg-opacity-10 text-white">
                                    <i class="fa-solid fa-user-plus"></i>
                                </div>
                                <p class="label text-white-50">Prospectos (Leads)</p>
                                <h2 class="value text-white"><?= number_format($total_leads) ?></h2>
                                <div class="mt-3 small text-white-50">
                                    Potenciales clientes registrados
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Secondary Row -->
                    <div class="row mt-5 g-4">
                        <!-- Recent Activity -->
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm rounded-5 overflow-hidden">
                                <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold mb-0">Últimos Prospectos</h5>
                                    <a href="leads.php" class="btn btn-light btn-sm fw-bold">Ver todos</a>
                                </div>
                                <div class="card-body p-0">
                                    <table class="premium-table">
                                        <thead>
                                            <tr>
                                                <th>NOMBRE</th>
                                                <th>EMAIL</th>
                                                <th>REGISTRO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_leads as $lead): ?>
                                            <tr>
                                                <td class="fw-bold"><?= htmlspecialchars($lead['full_name']) ?></td>
                                                <td class="text-muted"><?= htmlspecialchars($lead['email']) ?></td>
                                                <td class="small text-muted"><?= date('d/m/Y H:i', strtotime($lead['created_at'])) ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- System Health -->
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm rounded-5" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
                                <div class="card-body p-5">
                                    <h5 class="fw-bold mb-4">Estado del Sistema</h5>
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="bg-success rounded-circle me-3" style="width: 10px; height: 10px;"></div>
                                        <div>
                                            <p class="mb-0 fw-bold">NÚCLEO POSTGRESQL 17</p>
                                            <span class="text-white-50 small">Sincronización al 99.9%</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="bg-success rounded-circle me-3" style="width: 10px; height: 10px;"></div>
                                        <div>
                                            <p class="mb-0 fw-bold">API ENDPOINTS</p>
                                            <span class="text-white-50 small">Latencia 45ms</span>
                                        </div>
                                    </div>
                                    <div class="mt-5 p-3 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10">
                                        <p class="small mb-0 opacity-75 italic">
                                            "Infraestructura escalable desplegada sobre arquitectura multi-instancia."
                                        </p>
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
