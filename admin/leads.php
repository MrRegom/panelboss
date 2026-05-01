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
    <title>Prospectos | CajaYa SaaS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid px-4">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                    <li class="nav-item ms-3">
                        <span class="text-white small fw-bold">PROSPECTOS</span>
                    </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="py-5 bg-white border-bottom mb-4">
                <div class="container-fluid px-5">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <h2 class="fw-bold mb-1">Gestión de Prospectos</h2>
                            <p class="text-muted small mb-0">Usuarios que han interactuado con el ecosistema o descargado la demo.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid px-5 pb-5">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="leadsTable" class="table align-middle mb-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">USUARIO</th>
                                            <th>EMAIL</th>
                                            <th>PROVEEDOR</th>
                                            <th>LICENCIA DEMO</th>
                                            <th>WHATSAPP</th>
                                            <th>REGISTRO</th>
                                            <th class="text-end pe-4">ACCIONES</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        const table = $('#leadsTable').DataTable({
            ajax: 'api/get_leads.php',
            columns: [
                { 
                    data: 'full_name',
                    className: 'ps-4 py-3',
                    render: (d, t, r) => {
                        const initial = d ? d.charAt(0).toUpperCase() : 'U';
                        return `
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center fw-bold text-primary me-3" style="width: 36px; height: 36px; font-size: 14px;">${initial}</div>
                                <div class="fw-bold text-dark">${d || 'Usuario'}</div>
                            </div>`;
                    }
                },
                { data: 'email', render: (d) => `<span class="text-muted small">${d}</span>` },
                { 
                    data: 'provider',
                    render: (d) => {
                        if (d === 'google') return '<span class="badge bg-danger bg-opacity-10 text-danger border-0 small"><i class="fa-brands fa-google me-1"></i> Google</span>';
                        return '<span class="badge bg-light text-muted border small">Directo</span>';
                    }
                },
                { data: 'demo_license', render: (d) => d ? `<code class="small text-indigo fw-bold">${d}</code>` : '<span class="text-muted small">-</span>' },
                { data: 'whatsapp', render: (d) => d || '<span class="text-muted x-small">Sin número</span>' },
                { data: 'created_at', render: (d) => `<span class="text-muted small">${new Date(d).toLocaleDateString()} ${new Date(d).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>` },
                { 
                    data: null, 
                    className: 'text-end pe-4',
                    render: (d, t, r) => `
                        <a href="https://wa.me/${r.whatsapp}" target="_blank" class="btn btn-outline btn-sm">
                            <i class="fa-solid fa-envelope text-primary"></i>
                        </a>`
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-4 d-flex justify-content-between align-items-center border-bottom bg-light bg-opacity-25"lf>rt<"p-4 d-flex justify-content-between align-items-center border-top"ip>'
        });
    });
    </script>
</body>
</html>
