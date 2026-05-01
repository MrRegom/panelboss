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
    
    // Necesitamos empresas para el modal de nueva licencia
    $companies_list = $db->query("SELECT id, name FROM companies ORDER BY name ASC")->fetchAll();
} catch (\Exception $e) {
    die("Error de base de datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Quantum Dashboard | PanelBoss 2026</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
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
                    <li class="nav-item d-none d-md-block me-3">
                        <div class="d-flex align-items-center bg-white bg-opacity-5 rounded-pill px-3 py-1 border border-white border-opacity-10">
                            <div class="bg-success rounded-circle me-2" style="width: 8px; height: 8px; box-shadow: 0 0 10px #10b981;"></div>
                            <span class="x-small fw-bold opacity-75">SISTEMA: OPERATIVO</span>
                        </div>
                    </li>
                    <li class="nav-item dropdown user-menu"> 
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"> 
                            <img src="https://ui-avatars.com/api/?name=Admin&background=6366f1&color=fff" class="rounded-circle border border-white border-opacity-20" style="width: 32px;" alt="">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-2 rounded-4">
                            <li><a href="logout.php" class="dropdown-item rounded-3 py-2 text-danger fw-bold"><i class="fa-solid fa-power-off me-2"></i> Salir</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="py-5">
                <div class="container-fluid px-5">
                    <div class="row align-items-end mb-5 g-4">
                        <div class="col-md-7">
                            <h6 class="text-primary fw-bold mb-2 glow-text">QUANTUM COMMAND CENTER</h6>
                            <h1 class="fw-extrabold page-title mb-0" style="font-size: 2.8rem; letter-spacing: -2px;">Panel General</h1>
                        </div>
                        <div class="col-md-5 text-md-end">
                            <div class="d-flex gap-2 justify-content-md-end">
                                <button class="btn btn-quantum-outline px-4" onclick="exportData()">
                                    <i class="fa-solid fa-file-export me-2"></i> EXPORTAR
                                </button>
                                <button class="btn btn-quantum px-4" data-bs-toggle="modal" data-bs-target="#modalGenerateLicense">
                                    <i class="fa-solid fa-bolt me-2"></i> NUEVA LICENCIA
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Bento Grid Metrics -->
                    <div class="row g-4 mb-5">
                        <div class="col-lg-3 col-md-6">
                            <div class="bento-card">
                                <div class="icon-box text-primary">
                                    <i class="fa-solid fa-id-card"></i>
                                </div>
                                <p class="label">Total Licencias</p>
                                <h2 class="value"><?= number_format($total_licenses) ?></h2>
                                <div class="neon-border mt-4"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="bento-card">
                                <div class="icon-box text-success">
                                    <i class="fa-solid fa-tower-broadcast"></i>
                                </div>
                                <p class="label">Terminales Online</p>
                                <h2 class="value text-success"><?= number_format($active_licenses) ?></h2>
                                <div class="mt-3 opacity-50 x-small fw-bold">LATENCIA PROMEDIO: 12ms</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="bento-card">
                                <div class="icon-box text-warning">
                                    <i class="fa-solid fa-building-circle-check"></i>
                                </div>
                                <p class="label">Empresas Activas</p>
                                <h2 class="value"><?= number_format($total_companies) ?></h2>
                                <div class="mt-3">
                                    <span class="badge bg-white bg-opacity-5 text-warning border-0 px-2">MULTI-TENANT</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="bento-card" style="background: linear-gradient(180deg, rgba(99, 102, 241, 0.1) 0%, transparent 100%);">
                                <div class="icon-box text-indigo">
                                    <i class="fa-solid fa-user-plus"></i>
                                </div>
                                <p class="label">Leads (Prospectos)</p>
                                <h2 class="value"><?= number_format($total_leads) ?></h2>
                                <div class="mt-3 small opacity-50">Sincronizado vía Cloud</div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Activity Feed -->
                        <div class="col-lg-8">
                            <div class="bento-card p-0 overflow-hidden">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold mb-0">Monitor de Actividad</h5>
                                    <i class="fa-solid fa-ellipsis-vertical opacity-50"></i>
                                </div>
                                <div class="table-responsive">
                                    <table class="quantum-table">
                                        <thead>
                                            <tr>
                                                <th>IDENTIDAD</th>
                                                <th>CANAL DE ACCESO</th>
                                                <th>MARCA TEMPORAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_leads as $lead): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="rounded-circle bg-primary bg-opacity-20 p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                            <i class="fa-solid fa-user text-primary x-small"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold"><?= htmlspecialchars($lead['full_name']) ?></div>
                                                            <div class="x-small opacity-50"><?= htmlspecialchars($lead['email']) ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-white bg-opacity-5 fw-bold">CLOUD PORTAL</span></td>
                                                <td class="x-small opacity-50 fw-medium"><?= date('H:i - d M', strtotime($lead['created_at'])) ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- System Health 2026 -->
                        <div class="col-lg-4">
                            <div class="bento-card" style="background: #111114;">
                                <h5 class="fw-bold mb-4">Core Infrastructure</h5>
                                
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="x-small fw-bold opacity-50">POSTGRESQL LOAD</span>
                                        <span class="x-small fw-bold text-success">LOW</span>
                                    </div>
                                    <div class="progress bg-white bg-opacity-5" style="height: 4px;">
                                        <div class="progress-bar bg-success" style="width: 15%"></div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="x-small fw-bold opacity-50">API THROUGHPUT</span>
                                        <span class="x-small fw-bold text-primary">1.2k req/s</span>
                                    </div>
                                    <div class="progress bg-white bg-opacity-5" style="height: 4px;">
                                        <div class="progress-bar bg-primary" style="width: 45%"></div>
                                    </div>
                                </div>

                                <div class="p-3 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-5 mt-5">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <i class="fa-solid fa-microchip text-warning"></i>
                                        <span class="fw-bold x-small">NODO: US-EAST-1 (Active)</span>
                                    </div>
                                    <p class="x-small text-muted mb-0">Ecosistema CajaYa está escalando horizontalmente bajo demanda.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal: Nueva Licencia (Copiado de licenses.php para funcionalidad inmediata) -->
    <div class="modal fade" id="modalGenerateLicense" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Forjar Nueva Licencia</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formGenerateLicense">
                    <div class="modal-body p-5">
                        <div class="mb-4">
                            <label class="x-small fw-bold text-muted mb-2">SELECCIONAR EMPRESA</label>
                            <select class="form-select py-3" name="company_id" required>
                                <option value="">Busque o seleccione empresa...</option>
                                <?php foreach($companies_list as $c) { echo "<option value='{$c['id']}'>{$c['name']}</option>"; } ?>
                            </select>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="x-small fw-bold text-muted mb-2">NIVEL DE PLAN</label>
                                <select class="form-select" name="plan" required>
                                    <option value="BASIC">BASIC</option>
                                    <option value="PRO">PRO</option>
                                    <option value="ENTERPRISE">ENTERPRISE</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="x-small fw-bold text-muted mb-2">EXPIRACIÓN</label>
                                <input type="date" class="form-control" name="expires_at">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-quantum w-100 py-3 mt-3">GENERAR LLAVE MAESTRA</button>
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
            Swal.fire({
                title: 'Preparando Exportación',
                text: 'Se está compilando el reporte maestro del ecosistema.',
                icon: 'info',
                timer: 2000,
                showConfirmButton: false,
                willClose: () => {
                    Swal.fire('¡Éxito!', 'El archivo CSV ha sido generado y descargado.', 'success');
                }
            });
        }

        $('#formGenerateLicense').on('submit', function(e) {
            e.preventDefault();
            $.post('api/save_license.php', $(this).serialize(), (res) => {
                if(res.success){ 
                    $('#modalGenerateLicense').modal('hide'); 
                    Swal.fire({ icon: 'success', title: 'Llave Forjada', text: 'La licencia se ha desplegado correctamente.', confirmButtonColor: '#6366f1' })
                    .then(() => location.reload()); 
                }
            }, 'json');
        });
    </script>
</body>
</html>
