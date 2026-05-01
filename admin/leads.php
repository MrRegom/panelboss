<?php
require_once __DIR__ . '/includes/bootstrap.php';
use App\Services\AuthService;
use App\Config\Database;

AuthService::check();

$db = Database::getConnection();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prospectos | Mica Gold Enterprise</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
    <style>
        /* Ajuste específico para el look de cápsulas en tablas */
        #leadsTable { border-spacing: 0 12px !important; border-collapse: separate !important; }
        #leadsTable tbody tr { 
            background: #fff !important; 
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02) !important;
            transition: transform 0.2s;
        }
        #leadsTable tbody tr:hover { transform: scale(1.005); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05) !important; }
        #leadsTable tbody td { padding: 20px !important; border: none !important; }
        #leadsTable tbody td:first-child { border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
        #leadsTable tbody td:last-child { border-top-right-radius: 12px; border-bottom-right-radius: 12px; }
    </style>
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
            <div class="app-content-header-premium">
                <div class="container-fluid px-5">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <h4 class="text-primary fw-bold mb-1 text-uppercase">Directorio de Prospectos</h4>
                            <h1 class="fw-extrabold mb-0" style="font-size: 2.5rem; letter-spacing: -1.5px;">Gestión de Leads</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid px-5 pb-5">
                    <div class="table-responsive">
                        <table id="leadsTable" class="table premium-table w-100">
                            <thead>
                                <tr>
                                    <th>USUARIO</th>
                                    <th>EMAIL</th>
                                    <th>PROVEEDOR</th>
                                    <th>LICENCIA</th>
                                    <th>REGISTRO</th>
                                    <th class="text-end">ACCIONES</th>
                                </tr>
                            </thead>
                        </table>
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
        const table = $('#leadsTable').DataTable({
            ajax: 'api/get_leads.php',
            columns: [
                { 
                    data: 'full_name',
                    render: (d) => `
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">${d ? d.charAt(0).toUpperCase() : 'U'}</div>
                            <div class="fw-bold">${d || 'Usuario'}</div>
                        </div>`
                },
                { data: 'email', render: (d) => `<span class="text-muted small">${d}</span>` },
                { 
                    data: 'provider',
                    render: (d) => `<span class="badge-ms text-uppercase">${d || 'Directo'}</span>`
                },
                { data: 'demo_license', render: (d) => d ? `<code class="small text-primary fw-bold bg-transparent">${d}</code>` : '-' },
                { data: 'created_at', render: (d) => `<span class="text-muted small">${new Date(d).toLocaleDateString()}</span>` },
                { 
                    data: null, 
                    className: 'text-end',
                    render: (d, t, r) => `
                        <button class="btn btn-light btn-sm rounded-3 border">
                            <i class="fa-solid fa-comment-dots text-primary"></i>
                        </button>`
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"mb-4 d-flex justify-content-between align-items-center"lf>rt<"mt-4 d-flex justify-content-between align-items-center"ip>'
        });
    });
    </script>
</body>
</html>
