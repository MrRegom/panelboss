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
        <?php include __DIR__ . '/includes/header.php'; ?>
        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header py-4">
                <div class="container-fluid px-4">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h3 class="fw-bold mb-0">CajaYa Intelligence Hub</h3>
                            <p class="text-muted small mb-0">Monitor de operaciones globales y telemetría de licencias.</p>
                        </div>
                        <div class="col-sm-6 text-end">
                            <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                <button class="btn btn-silk px-4" data-bs-toggle="modal" data-bs-target="#modalGenerateLicense">
                                    <i class="fa-solid fa-bolt me-2"></i> Nueva Licencia
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content px-4">
                <div class="container-fluid">
                    <!-- Metrics Bento Grid -->
                    <div class="row g-4 mb-4">
                        <div class="col-lg-3 col-md-6">
                            <div class="card card-silk border-0 shadow-sm p-4 h-100">
                                <p class="text-muted small fw-bold text-uppercase mb-2">Licencias Totales</p>
                                <div class="d-flex align-items-end justify-content-between">
                                    <h2 class="fw-bold mb-0"><?= number_format($total_licenses) ?></h2>
                                    <div class="text-success small fw-bold"><i class="fa-solid fa-caret-up me-1"></i> 12%</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card card-silk border-0 shadow-sm p-4 h-100">
                                <p class="text-muted small fw-bold text-uppercase mb-2">Activas / Online</p>
                                <div class="d-flex align-items-end justify-content-between">
                                    <h2 class="fw-bold mb-0 text-success"><?= number_format($active_licenses) ?></h2>
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1" style="font-size: 0.6rem;">LIVE</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card card-silk border-0 shadow-sm p-4 h-100">
                                <p class="text-muted small fw-bold text-uppercase mb-2">Empresas Partner</p>
                                <h2 class="fw-bold mb-0"><?= number_format($total_companies) ?></h2>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card bg-indigo text-white border-0 shadow-sm p-4 h-100">
                                <p class="text-white-50 small fw-bold text-uppercase mb-2">Prospectos Cloud</p>
                                <h2 class="fw-bold mb-0"><?= number_format($total_leads) ?></h2>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="card card-silk border-0 shadow-sm p-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h6 class="fw-bold mb-0">Actividad Reciente (Leads)</h6>
                                    <a href="leads.php" class="btn btn-link text-primary p-0 small fw-bold text-decoration-none">Ver todos</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead>
                                            <tr class="text-muted small fw-bold text-uppercase" style="font-size: 0.65rem;">
                                                <th>NOMBRE / EMAIL</th>
                                                <th>STATUS</th>
                                                <th class="text-end">REGISTRO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_leads as $lead): ?>
                                            <tr>
                                                <td>
                                                    <div class="fw-bold text-dark small"><?= htmlspecialchars($lead['full_name']) ?></div>
                                                    <div class="x-small text-muted"><?= htmlspecialchars($lead['email']) ?></div>
                                                </td>
                                                <td><span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded small" style="font-size: 0.6rem;">NUEVO</span></td>
                                                <td class="text-end small text-muted"><?= date('d/m H:i', strtotime($lead['created_at'])) ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-navy text-white border-0 shadow-sm p-4 h-100 position-relative overflow-hidden" style="background-color: #001f3f !important;">
                                <i class="fa-solid fa-microchip position-absolute opacity-10" style="font-size: 10rem; bottom: -20px; right: -20px;"></i>
                                <h6 class="fw-bold mb-4">Infraestructura US-WEST</h6>
                                <div class="mb-4">
                                    <div class="small fw-bold mb-1 text-white-50 text-uppercase" style="font-size: 0.6rem;">Latencia Promedio</div>
                                    <div class="h3 fw-bold mb-0">24.5ms</div>
                                </div>
                                <div class="mb-4">
                                    <div class="small fw-bold mb-1 text-white-50 text-uppercase" style="font-size: 0.6rem;">Sincronización</div>
                                    <div class="h3 fw-bold mb-0">99.98%</div>
                                </div>
                                <div class="mt-auto">
                                    <div class="d-flex align-items-center">
                                        <div class="spinner-grow spinner-grow-sm text-success me-2" role="status"></div>
                                        <span class="small fw-bold text-success">SISTEMA OPERATIVO</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php include __DIR__ . '/includes/footer.php'; ?>
        </main>
    </div>

    <!-- Modal: Nueva Licencia (Simplificado) -->
    <div class="modal fade" id="modalGenerateLicense" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Desplegar Licencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formGenerateLicense">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1 text-uppercase">Empresa Cliente</label>
                            <select class="form-select" name="company_id" required>
                                <option value="">Seleccione empresa...</option>
                                <?php foreach($companies_list as $c) { echo "<option value='{$c['id']}'>{$c['name']}</option>"; } ?>
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">Plan</label>
                                <select class="form-select" name="plan" required>
                                    <option value="BASIC">BASIC</option>
                                    <option value="PRO">PRO</option>
                                    <option value="ENTERPRISE">ENTERPRISE</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">Expira</label>
                                <input type="date" class="form-control" name="expires_at">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">GENERAR LLAVE</button>
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
        $('#formGenerateLicense').on('submit', function(e) {
            e.preventDefault();
            $.post('api/save_license.php', $(this).serialize(), (res) => {
                if(res.success){ $('#modalGenerateLicense').modal('hide'); Swal.fire('Generada', 'Licencia activa.', 'success').then(() => location.reload()); }
            }, 'json');
        });
    </script>
</body>
</html>
