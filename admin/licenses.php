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
    <title>Licencias | Azure Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
</head>
<body class="layout-fixed sidebar-expand-lg bg-light">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid px-3">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="fa-solid fa-bars"></i> </a> </li>
                    <li class="nav-item ms-3"> <span class="text-white fw-semibold small">CajaYa | Gestión de Licencias</span> </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="ms-page-header d-flex justify-content-between align-items-center">
                <h1 class="ms-page-title">Gestión de Licencias</h1>
                <button class="btn btn-ms-primary" data-bs-toggle="modal" data-bs-target="#modalGenerateLicense">
                    <i class="fa-solid fa-plus me-2"></i> Nueva Licencia
                </button>
            </div>

            <div class="app-content px-4">
                <div class="container-fluid">
                    <div class="card card-ms">
                        <div class="table-responsive">
                            <table id="licensesTable" class="table ms-table w-100">
                                <thead>
                                    <tr>
                                        <th>LLAVE</th>
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
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/js/adminlte.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#licensesTable').DataTable({
            ajax: 'api/get_licenses.php',
            columns: [
                { data: 'license_key', render: d => `<code class="text-primary small fw-bold">${d}</code>` },
                { data: 'company_name', className: 'small fw-semibold' },
                { data: 'plan', render: d => `<span class="badge bg-light text-dark border small">${d}</span>` },
                { 
                    data: 'status', 
                    render: d => `<span class="small fw-bold ${d === 'active' ? 'text-success' : 'text-warning'} text-uppercase">${d}</span>` 
                },
                { data: 'expires_at', render: d => `<span class="text-muted small">${d ? new Date(d).toLocaleDateString() : '-'}</span>` },
                { 
                    data: null, 
                    className: 'text-end',
                    render: () => `
                        <button class="btn btn-link btn-sm p-0 me-2 text-primary"><i class="fa-solid fa-edit"></i></button>
                        <button class="btn btn-link btn-sm p-0 text-danger"><i class="fa-solid fa-trash"></i></button>`
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-3 d-flex justify-content-between align-items-center"lf>rt<"p-3 d-flex justify-content-between align-items-center"ip>'
        });
    });
    </script>
</body>
</html>
