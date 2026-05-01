<?php
require_once __DIR__ . '/includes/bootstrap.php';
use App\Services\AuthService;
use App\Config\Database;

AuthService::check();

$db = Database::getConnection();
$companies = $db->query("SELECT id, name FROM companies ORDER BY name")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Licencias | CajaYa Premium</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid px-4">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link text-white" data-lte-toggle="sidebar" href="#" role="button"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header mb-5">
                <div class="container-fluid px-5">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h2 class="fw-extrabold mb-1">Gestión de Licencias</h2>
                            <p class="text-muted small mb-0">Control maestro de llaves y planes de servicio.</p>
                        </div>
                        <div class="col-md-5 text-md-end mt-4 mt-md-0">
                            <button class="btn btn-premium-indigo" data-bs-toggle="modal" data-bs-target="#modalGenerateLicense">
                                <i class="fa-solid fa-plus me-2"></i> NUEVA LICENCIA
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid px-5 pb-5">
                    <div class="table-responsive">
                        <table id="licensesTable" class="table premium-table w-100">
                            <thead>
                                <tr>
                                    <th>LLAVE (LICENSE KEY)</th>
                                    <th>EMPRESA</th>
                                    <th>PLAN</th>
                                    <th>ESTADO</th>
                                    <th>EXPIRACIÓN</th>
                                    <th class="text-end">ACCIONES</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modals (Simplified for context) -->
    <div class="modal fade" id="modalGenerateLicense" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 p-4">
                    <h5 class="fw-bold mb-0">Generar Licencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formGenerateLicense">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="small fw-bold mb-1">EMPRESA</label>
                            <select class="form-select" name="company_id" required>
                                <option value="">Seleccione...</option>
                                <?php foreach($companies as $c) echo "<option value='{$c['id']}'>{$c['name']}</option>"; ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="small fw-bold mb-1">PLAN</label>
                                <select class="form-select" name="plan">
                                    <option value="BASIC">BASIC</option>
                                    <option value="PRO">PRO</option>
                                    <option value="ENTERPRISE">ENTERPRISE</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="small fw-bold mb-1">EXPIRACIÓN</label>
                                <input type="date" class="form-control" name="expires_at">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-premium-indigo w-100 py-3 mt-3">ACTIVAR LLAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        $('#licensesTable').DataTable({
            ajax: 'api/get_licenses.php',
            columns: [
                { data: 'license_key', render: d => `<code class="text-indigo fw-bold small">${d}</code>` },
                { data: 'company_name', render: d => `<span class="fw-bold">${d}</span>` },
                { data: 'plan', render: d => `<span class="badge-premium badge-demo">${d}</span>` },
                { 
                    data: 'status', 
                    render: d => `<span class="badge-premium ${d === 'active' ? 'badge-active' : 'badge-pending'}">${d}</span>` 
                },
                { data: 'expires_at', render: d => `<span class="text-muted small">${d ? new Date(d).toLocaleDateString() : 'N/A'}</span>` },
                { 
                    data: null, 
                    className: 'text-end',
                    render: (d, t, r) => `
                        <div class="btn-group">
                            <button class="btn btn-light btn-sm border me-1"><i class="fa-solid fa-pen text-primary"></i></button>
                            <button class="btn btn-light btn-sm border"><i class="fa-solid fa-trash text-danger"></i></button>
                        </div>`
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"mb-4 d-flex justify-content-between"lf>rt<"mt-4 d-flex justify-content-between"ip>'
        });
    });
    </script>
</body>
</html>
