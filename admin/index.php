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
    
    $recent_leads = $db->query("SELECT full_name, email, created_at FROM leads ORDER BY created_at DESC LIMIT 5")->fetchAll();
    $companies_list = $db->query("SELECT id, name FROM companies ORDER BY name ASC")->fetchAll();
} catch (\Exception $e) {
    die("Error de base de datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control | CajaYa SaaS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
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
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item dropdown user-menu"> 
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"> 
                            <span class="text-white small fw-medium me-2"><?= $_SESSION['user_name'] ?? 'Admin' ?></span>
                            <img src="https://ui-avatars.com/api/?name=Admin&background=fff&color=000" class="rounded-circle border" style="width: 28px;" alt="">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-2 rounded-3">
                            <li><a href="logout.php" class="dropdown-item py-2 text-danger small fw-bold"><i class="fa-solid fa-power-off me-2"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="py-5 bg-white border-bottom mb-4">
                <div class="container-fluid px-5">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1">Panel General</h2>
                            <p class="text-muted small mb-0">Gestión centralizada del ecosistema de licencias y partners.</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <div class="d-flex gap-2 justify-content-md-end">
                                <button class="btn btn-outline" onclick="exportData()">
                                    <i class="fa-solid fa-download me-2"></i> Reporte
                                </button>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalGenerateLicense">
                                    <i class="fa-solid fa-plus me-2"></i> Nueva Licencia
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid px-5">
                    <!-- Metrics Row -->
                    <div class="row g-4 mb-5">
                        <div class="col-lg-3 col-md-6">
                            <div class="bento-card-light">
                                <span class="text-muted small fw-bold text-uppercase opacity-50">Total Licencias</span>
                                <div class="h3 fw-bold mt-2 mb-0"><?= number_format($total_licenses) ?></div>
                                <div class="mt-2 text-success small fw-bold"><i class="fa-solid fa-chart-line me-1"></i> +4.5%</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="bento-card-light">
                                <span class="text-muted small fw-bold text-uppercase opacity-50">Cajas Online</span>
                                <div class="h3 fw-bold mt-2 mb-0 text-success"><?= number_format($active_licenses) ?></div>
                                <div class="mt-2 text-muted small fw-bold">Live Sync Activo</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="bento-card-light">
                                <span class="text-muted small fw-bold text-uppercase opacity-50">Empresas</span>
                                <div class="h3 fw-bold mt-2 mb-0"><?= number_format($total_companies) ?></div>
                                <div class="mt-2 text-muted small fw-bold">Core Multi-tenant</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="bento-card-light">
                                <span class="text-muted small fw-bold text-uppercase opacity-50">Prospectos</span>
                                <div class="h3 fw-bold mt-2 mb-0"><?= number_format($total_leads) ?></div>
                                <div class="mt-2 text-muted small fw-bold">Nuevos registros</div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Activity -->
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom p-4">
                                    <h5 class="fw-bold mb-0">Actividad Reciente</h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>USUARIO</th>
                                                <th>CANAL</th>
                                                <th>FECHA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_leads as $lead): ?>
                                            <tr>
                                                <td class="fw-bold py-3"><?= htmlspecialchars($lead['full_name']) ?></td>
                                                <td><span class="badge bg-slate bg-opacity-10 text-slate border">CLOUD</span></td>
                                                <td class="text-muted small"><?= date('d/m/Y H:i', strtotime($lead['created_at'])) ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Health -->
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom p-4">
                                    <h5 class="fw-bold mb-0">Infraestructura</h5>
                                </div>
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div>
                                            <div class="fw-bold small">Capa de Datos</div>
                                            <div class="text-muted x-small">PostgreSQL 17 Optimized</div>
                                        </div>
                                        <div class="status-pill active">STABLE</div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div>
                                            <div class="fw-bold small">API Gateway</div>
                                            <div class="text-muted x-small">Endpoint Latency: 42ms</div>
                                        </div>
                                        <div class="status-pill active">99.9%</div>
                                    </div>
                                    <hr class="opacity-10 my-4">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <p class="x-small text-muted mb-0">Sistema operando bajo arquitectura distribuida de alto rendimiento.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal: Nueva Licencia -->
    <div class="modal fade" id="modalGenerateLicense" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold">Generar Licencia de Servicio</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formGenerateLicense">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="x-small fw-bold text-muted mb-2 text-uppercase">Cliente / Empresa</label>
                            <select class="form-select" name="company_id" required>
                                <option value="">Seleccione empresa...</option>
                                <?php foreach($companies_list as $c) { echo "<option value='{$c['id']}'>{$c['name']}</option>"; } ?>
                            </select>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="x-small fw-bold text-muted mb-2 text-uppercase">Plan</label>
                                <select class="form-select" name="plan" required>
                                    <option value="BASIC">BASIC</option>
                                    <option value="PRO">PRO</option>
                                    <option value="ENTERPRISE">ENTERPRISE</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="x-small fw-bold text-muted mb-2 text-uppercase">Expiración</label>
                                <input type="date" class="form-control" name="expires_at">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 mt-3">ACTIVAR LICENCIA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function exportData() {
            Swal.fire({ title: 'Exportando...', text: 'Generando reporte maestro.', icon: 'info', timer: 1500, showConfirmButton: false });
        }
        $('#formGenerateLicense').on('submit', function(e) {
            e.preventDefault();
            $.post('api/save_license.php', $(this).serialize(), (res) => {
                if(res.success){ $('#modalGenerateLicense').modal('hide'); Swal.fire('Éxito', 'Licencia generada.', 'success').then(() => location.reload()); }
            }, 'json');
        });
    </script>
</body>
</html>
