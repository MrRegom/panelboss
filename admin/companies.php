<?php
require_once __DIR__ . '/includes/bootstrap.php';
use App\Services\AuthService;
AuthService::check();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empresas | PanelBoss PRO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown user-menu"> 
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"> 
                            <span class="d-none d-md-inline fw-semibold me-2"><?= $_SESSION['user_name'] ?? 'Admin' ?></span>
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-user-tie text-white small"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2">
                            <li><a href="logout.php" class="dropdown-item py-2 text-danger fw-medium"><i class="fa-solid fa-right-from-bracket me-2"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header py-4">
                <div class="container-fluid px-4">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h3 class="fw-bold mb-0">Gestión de Empresas</h3>
                            <p class="text-muted small">Administración de clientes corporativos y tenants</p>
                        </div>
                        <div class="col-sm-6 text-end">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddCompany">
                                <i class="fa-solid fa-plus me-2"></i> AGREGAR EMPRESA
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="app-content">
                <div class="container-fluid px-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="companiesTable" class="table table-hover align-middle mb-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="ps-4" style="width: 80px">ID</th>
                                            <th>Empresa</th>
                                            <th>RUT / ID FISCAL</th>
                                            <th>Fecha Registro</th>
                                            <th class="text-end pe-4">Acciones</th>
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

    <!-- Modal: Agregar Empresa -->
    <div class="modal fade" id="modalAddCompany" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Registrar Nueva Empresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formAddCompany">
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label class="small fw-bold text-muted mb-2">NOMBRE COMERCIAL</label>
                            <input type="text" class="form-control" name="name" required placeholder="Ej: Distribuidora Santiago">
                        </div>
                        <div class="mb-4">
                            <label class="small fw-bold text-muted mb-2">RUT / IDENTIFICACIÓN FISCAL</label>
                            <input type="text" class="form-control" name="rut" placeholder="Ej: 76.123.456-K">
                        </div>
                        <div class="mb-0">
                            <label class="small fw-bold text-muted mb-2">EMAIL DE CONTACTO</label>
                            <input type="email" class="form-control" name="email" placeholder="contacto@empresa.com">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">GUARDAR EMPRESA</button>
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
        const table = $('#companiesTable').DataTable({
            ajax: 'api/get_companies.php',
            columns: [
                { data: 'id', className: 'ps-4', render: (d) => '<span class="text-muted small">#'+d+'</span>' },
                { data: 'name', render: (d) => '<span class="fw-bold text-dark">'+d+'</span>' },
                { data: 'rut', render: (d) => d ? '<span class="text-muted">'+d+'</span>' : '<span class="text-muted small italic">Sin RUT</span>' },
                { data: 'created_at', render: (d) => d ? '<span class="small text-muted">'+new Date(d).toLocaleDateString()+'</span>' : 'N/A' },
                { data: null, className: 'text-end pe-4', render: (d) => {
                    return '<button class="btn btn-sm btn-light border"><i class="fa-solid fa-pencil text-primary"></i></button>';
                }}
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-3 d-flex justify-content-between align-items-center"lf>rt<"p-3 d-flex justify-content-between align-items-center"ip>'
        });

        $('#formAddCompany').on('submit', function(e) {
            e.preventDefault();
            const $btn = $(this).find('button[type="submit"]');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Guardando...');
            
            $.post('api/save_company.php', $(this).serialize(), function(res) {
                if(res.success) {
                    Swal.fire({ icon: 'success', title: 'Éxito', text: res.message, toast: true, position: 'top-end', showConfirmButton: false, timer: 1500 });
                    $('#modalAddCompany').modal('hide');
                    table.ajax.reload();
                    $('#formAddCompany')[0].reset();
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
                $btn.prop('disabled', false).html('GUARDAR EMPRESA');
            }, 'json');
        });
    });
    </script>
</body>
</html>
