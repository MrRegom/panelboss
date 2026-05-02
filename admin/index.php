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
            <div class="app-content-header py-4 animate-in">
                <div class="container-fluid px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-extrabold mb-0 gradient-text" style="font-size: 1.8rem;">CajaYa Intelligence Hub</h3>
                        <p class="text-muted small">Ecosistema Global • Telemetría en Tiempo Real</p>
                    </div>
                    <button class="btn btn-primary shadow-lg px-4 py-2 rounded-pill fw-bold border-0" data-bs-toggle="modal" data-bs-target="#modalGenerateLicense" style="background: var(--silk-purple);">
                        <i class="fa-solid fa-bolt-lightning me-2"></i> NUEVA LICENCIA
                    </button>
                </div>
            </div>

            <div class="app-content px-4 pb-5">
                <div class="container-fluid">
                    <!-- Bento Grid Metrics -->
                    <div class="row g-4 mb-4">
                        <div class="col-lg-3 col-md-6 animate-in delay-1">
                            <div class="glass-card p-4 h-100">
                                <div class="glow-icon"><i class="fa-solid fa-id-card"></i></div>
                                <p class="text-muted small fw-bold text-uppercase mb-1">Licencias Totales</p>
                                <div class="metric-value"><?= number_format($total_licenses) ?></div>
                                <div class="text-success small fw-bold mt-2"><i class="fa-solid fa-arrow-trend-up me-1"></i> +12% este mes</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 animate-in delay-2">
                            <div class="glass-card p-4 h-100 border-success border-opacity-25">
                                <div class="glow-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;"><i class="fa-solid fa-satellite-dish"></i></div>
                                <p class="text-muted small fw-bold text-uppercase mb-1">Activas / Online</p>
                                <div class="metric-value text-success"><?= number_format($active_licenses) ?></div>
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 mt-2" style="font-size: 0.6rem;">LIVE STATUS</span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 animate-in delay-3">
                            <div class="glass-card p-4 h-100">
                                <div class="glow-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;"><i class="fa-solid fa-building"></i></div>
                                <p class="text-muted small fw-bold text-uppercase mb-1">Empresas Partner</p>
                                <div class="metric-value"><?= number_format($total_companies) ?></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 animate-in delay-4">
                            <div class="glass-card p-4 h-100" style="background: linear-gradient(135deg, #7c3aed 0%, #3b82f6 100%); border: none;">
                                <div class="glow-icon" style="background: rgba(255,255,255,0.2); color: white;"><i class="fa-solid fa-users-viewfinder"></i></div>
                                <p class="text-white-50 small fw-bold text-uppercase mb-1">Prospectos Cloud</p>
                                <div class="metric-value text-white"><?= number_format($total_leads) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Recent Activity Table -->
                        <div class="col-lg-8 animate-in delay-3">
                            <div class="glass-card p-4 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h6 class="fw-bold mb-0">Monitor de Leads Recientes</h6>
                                    <a href="leads.php" class="btn btn-light btn-sm rounded-pill px-3 fw-bold">Ver todos</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead>
                                            <tr class="text-muted small fw-bold text-uppercase" style="font-size: 0.65rem; border-bottom: 2px solid #f4f6f9;">
                                                <th class="py-3">IDENTIDAD</th>
                                                <th class="py-3 text-center">ESTADO</th>
                                                <th class="py-3 text-end">MARCA DE TIEMPO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_leads as $lead): ?>
                                            <tr>
                                                <td class="py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width:36px; height:36px; font-size: 0.8rem;">
                                                            <?= strtoupper(substr($lead['full_name'], 0, 1)) ?>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold text-dark small"><?= htmlspecialchars($lead['full_name']) ?></div>
                                                            <div class="x-small text-muted"><?= htmlspecialchars($lead['email']) ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center"><span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill small" style="font-size: 0.6rem;">NUEVO REGISTRO</span></td>
                                                <td class="text-end small text-muted fw-medium"><?= date('d M, H:i', strtotime($lead['created_at'])) ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Infrastructure Card -->
                        <div class="col-lg-4 animate-in delay-4">
                            <div class="infra-card p-5 h-100">
                                <div class="position-relative z-index-2">
                                    <h6 class="fw-bold mb-4 opacity-75">NODO CENTRAL US-WEST</h6>
                                    <div class="mb-5">
                                        <div class="small fw-bold mb-1 text-white-50 text-uppercase" style="font-size: 0.65rem;">Latencia de Red</div>
                                        <div class="h1 fw-extrabold mb-0">24.5<span class="fs-4 fw-normal opacity-50 ms-1">ms</span></div>
                                    </div>
                                    <div class="mb-5">
                                        <div class="small fw-bold mb-1 text-white-50 text-uppercase" style="font-size: 0.65rem;">Sincronización Cloud</div>
                                        <div class="h1 fw-extrabold mb-0">99.98<span class="fs-4 fw-normal opacity-50 ms-1">%</span></div>
                                    </div>
                                    <div class="mt-auto d-flex align-items-center">
                                        <div class="pulse-green me-3"></div>
                                        <span class="small fw-bold text-success">NÚCLEO OPERATIVO ACTIVO</span>
                                    </div>
                                </div>
                                <i class="fa-solid fa-microchip position-absolute opacity-10" style="font-size: 14rem; bottom: -40px; right: -40px; color: white;"></i>
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
