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
    <title>Enterprise Hub | Mica Gold</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid px-4">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link text-white" data-lte-toggle="sidebar" href="#" role="button"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                </ul>
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <span class="badge-ms"><i class="fa-solid fa-server me-2"></i> US-WEST-2 NODE</span>
                    </li>
                    <li class="nav-item dropdown user-menu"> 
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center p-0" data-bs-toggle="dropdown"> 
                            <img src="https://ui-avatars.com/api/?name=Admin&background=f59e0b&color=fff" class="rounded-circle" style="width: 32px;" alt="">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-2 rounded-4">
                            <li><a href="logout.php" class="dropdown-item py-2 text-danger fw-bold"><i class="fa-solid fa-power-off me-2"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header-premium">
                <div class="container-fluid px-5">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h4 class="text-primary fw-bold mb-1">MICA GOLD PORTAL</h4>
                            <h1 class="fw-extrabold mb-0" style="font-size: 3rem; letter-spacing: -2px;">Vista de Operaciones</h1>
                        </div>
                        <div class="col-md-5 text-md-end mt-4 mt-md-0">
                            <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                <button class="btn btn-white border px-4" onclick="exportData()"><i class="fa-solid fa-cloud-download me-2"></i>REPORTES</button>
                                <button class="btn btn-ms px-4" data-bs-toggle="modal" data-bs-target="#modalGenerateLicense"><i class="fa-solid fa-bolt-lightning me-2"></i>DESPLEGAR LICENCIA</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid px-5 pb-5">
                    <!-- Metrics Bento Grid -->
                    <div class="row g-4 mb-5">
                        <div class="col-lg-3 col-md-6">
                            <div class="card p-4 border-0">
                                <p class="text-muted small fw-bold text-uppercase mb-2">Total Licencias</p>
                                <div class="d-flex align-items-end justify-content-between">
                                    <h2 class="fw-extrabold mb-0"><?= number_format($total_licenses) ?></h2>
                                    <div class="text-success small fw-bold"><i class="fa-solid fa-caret-up me-1"></i> 12%</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card p-4 border-0">
                                <p class="text-muted small fw-bold text-uppercase mb-2">Terminales Online</p>
                                <div class="d-flex align-items-end justify-content-between">
                                    <h2 class="fw-extrabold mb-0 text-success"><?= number_format($active_licenses) ?></h2>
                                    <div class="status-indicator-live"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card p-4 border-0">
                                <p class="text-muted small fw-bold text-uppercase mb-2">Empresas Activas</p>
                                <h2 class="fw-extrabold mb-0"><?= number_format($total_companies) ?></h2>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card p-4 border-0 bg-dark text-white">
                                <p class="text-white-50 small fw-bold text-uppercase mb-2">Prospectos (Leads)</p>
                                <h2 class="fw-extrabold mb-0"><?= number_format($total_leads) ?></h2>
                            </div>
                        </div>
                    </div>

                    <div class="row g-5">
                        <div class="col-lg-8">
                            <div class="card border-0 p-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-bold mb-0">Monitor de Tráfico</h5>
                                    <span class="x-small text-muted fw-bold">REAL-TIME DATA</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr class="text-muted small fw-bold text-uppercase">
                                                <th>Identidad</th>
                                                <th>Status</th>
                                                <th class="text-end">Registro</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_leads as $lead): ?>
                                            <tr>
                                                <td>
                                                    <div class="fw-bold"><?= htmlspecialchars($lead['full_name']) ?></div>
                                                    <div class="x-small text-muted"><?= htmlspecialchars($lead['email']) ?></div>
                                                </td>
                                                <td><span class="badge-ms">ACTIVO</span></td>
                                                <td class="text-end small text-muted"><?= date('H:i', strtotime($lead['created_at'])) ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card border-0 p-5 bg-primary text-white overflow-hidden" style="min-height: 300px;">
                                <i class="fa-solid fa-microchip position-absolute opacity-10" style="font-size: 10rem; bottom: -20px; right: -20px;"></i>
                                <h5 class="fw-bold mb-4">Infraestructura</h5>
                                <div class="mb-4">
                                    <div class="small fw-bold mb-1 opacity-75 text-uppercase">API Latency</div>
                                    <div class="h4 fw-extrabold mb-0">42.8ms</div>
                                </div>
                                <div class="mb-4">
                                    <div class="small fw-bold mb-1 opacity-75 text-uppercase">Uptime</div>
                                    <div class="h4 fw-extrabold mb-0">99.998%</div>
                                </div>
                                <div class="mt-auto">
                                    <span class="badge bg-white bg-opacity-20 text-white border-0 px-3 py-2">ESTABLE</span>
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
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-extrabold">Desplegar Nueva Licencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formGenerateLicense">
                    <div class="modal-body p-5">
                        <div class="mb-4">
                            <label class="x-small fw-bold text-muted mb-2 text-uppercase">Cliente Maestro</label>
                            <select class="form-select py-3" name="company_id" required>
                                <option value="">Seleccione empresa...</option>
                                <?php foreach($companies_list as $c) { echo "<option value='{$c['id']}'>{$c['name']}</option>"; } ?>
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="x-small fw-bold text-muted mb-2 text-uppercase">Nivel de Plan</label>
                                <select class="form-select" name="plan" required>
                                    <option value="BASIC">BASIC</option>
                                    <option value="PRO">PRO</option>
                                    <option value="ENTERPRISE">ENTERPRISE</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="x-small fw-bold text-muted mb-2 text-uppercase">Expira</label>
                                <input type="date" class="form-control" name="expires_at">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 p-5">
                        <button type="submit" class="btn btn-ms w-100 py-3 fw-bold">FORJAR LLAVE DE ACCESO</button>
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
            Swal.fire({ title: 'Procesando Reporte', text: 'Se está compilando el estado maestro.', icon: 'info', timer: 1500, showConfirmButton: false });
        }
        $('#formGenerateLicense').on('submit', function(e) {
            e.preventDefault();
            $.post('api/save_license.php', $(this).serialize(), (res) => {
                if(res.success){ $('#modalGenerateLicense').modal('hide'); Swal.fire('Generada', 'Licencia activa.', 'success').then(() => location.reload()); }
            }, 'json');
        });
    </script>
</body>
</html>
