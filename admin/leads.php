<?php
require_once __DIR__ . '/includes/bootstrap.php';
use App\Services\AuthService;
use App\Config\Database;

AuthService::check();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prospectos | CajaYa Silk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
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
                        <div class="col-sm-12">
                            <h3 class="fw-bold mb-0">Prospectos Cloud</h3>
                            <p class="text-muted small mb-0">Gestión estratégica de clientes potenciales y registros entrantes.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content px-4">
                <div class="container-fluid">
                    <div class="card card-silk border-0 shadow-sm">
                        <div class="table-responsive">
                            <table id="leadsTable" class="table silk-table w-100">
                                <thead>
                                    <tr>
                                        <th>IDENTIDAD</th>
                                        <th>EMAIL</th>
                                        <th>PROVEEDOR</th>
                                        <th>LICENCIA DEMO</th>
                                        <th>FECHA REGISTRO</th>
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
        $('#leadsTable').DataTable({
            ajax: 'api/get_leads.php',
            columns: [
                { 
                    data: 'full_name',
                    render: (d) => `<div class="fw-bold small text-dark">${d || 'N/A'}</div>`
                },
                { data: 'email', render: d => `<span class="text-muted small">${d}</span>` },
                { 
                    data: 'provider',
                    render: (d) => `<span class="badge bg-light text-muted border-0 px-3 py-1 rounded-pill small">${d || 'Directo'}</span>`
                },
                { data: 'demo_license', render: d => d ? `<code class="text-primary fw-bold">${d}</code>` : '<span class="text-muted opacity-50">-</span>' },
                { data: 'created_at', render: d => `<span class="text-muted small">${new Date(d).toLocaleDateString()}</span>` },
                { 
                    data: null, 
                    className: 'text-end',
                    render: () => `
                        <button class="btn btn-link text-primary p-2"><i class="fa-solid fa-paper-plane"></i></button>
                        <button class="btn btn-link text-danger p-2"><i class="fa-solid fa-trash-can"></i></button>`
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-4 d-flex justify-content-between align-items-center"lf>rt<"p-4 d-flex justify-content-between align-items-center"ip>'
        });
    });
    </script>
</body>
</html>
