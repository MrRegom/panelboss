<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Services\AuthService;
use App\Config\Database;

AuthService::check();

$db = Database::getConnection();
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Licencias | PanelBoss PRO</title>
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
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" style="background: var(--bg-card);">
                            <li><a href="logout.php" class="dropdown-item py-2 text-danger fw-medium"><i class="fa-solid fa-right-from-bracket me-2"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <aside class="app-sidebar shadow-sm" data-bs-theme="dark">
            <div class="sidebar-brand"> 
                <a href="./index.php" class="brand-link border-0"> 
                    <span class="brand-text">PANELBOSS <span class="text-primary">PRO</span></span> 
                </a> 
            </div>
            <div class="sidebar-wrapper px-2">
                <nav class="mt-3">
                    <ul class="nav sidebar-menu flex-column">
                        <li class="nav-item"> <a href="./index.php" class="nav-link"> <i class="nav-icon fa-solid fa-house"></i> <p>Dashboard</p> </a> </li>
                        <li class="nav-header small text-muted px-4 mt-3">OPERACIONES</li>
                        <li class="nav-item"> <a href="./licenses.php" class="nav-link active"> <i class="nav-icon fa-solid fa-key"></i> <p>Licencias</p> </a> </li>
                        <li class="nav-item"> <a href="./companies.php" class="nav-link"> <i class="nav-icon fa-solid fa-building"></i> <p>Empresas</p> </a> </li>
                        <li class="nav-header small text-muted px-4 mt-3">SISTEMA</li>
                        <li class="nav-item"> <a href="./users.php" class="nav-link"> <i class="nav-icon fa-solid fa-users-gear"></i> <p>Usuarios</p> </a> </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <main class="app-main">
            <div class="app-content-header py-4">
                <div class="container-fluid px-4">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h3 class="fw-semibold mb-0">Listado de Licencias</h3>
                            <p class="text-muted small">Gestión de llaves y planes de servicio</p>
                        </div>
                        <div class="col-sm-6 text-end">
                            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalGenerateLicense">
                                <i class="fa-solid fa-plus me-2"></i> NUEVA LICENCIA
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="app-content">
                <div class="container-fluid px-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <table id="licensesTable" class="table table-hover dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>KEY</th>
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

    <!-- Modal Restaurado -->
    <div class="modal fade" id="modalGenerateLicense" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="background-color: var(--bg-card);">
                <div class="modal-header border-bottom border-white border-opacity-10">
                    <h5 class="modal-title fw-bold">Crear Nueva Licencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formGenerateLicense">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">PLAN</label>
                            <select class="form-select bg-dark border-secondary" name="plan" required>
                                <option value="BASIC">BASIC</option>
                                <option value="PRO">PRO</option>
                                <option value="ENTERPRISE">ENTERPRISE</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">FECHA DE EXPIRACIÓN (OPCIONAL)</label>
                            <input type="date" class="form-control bg-dark border-secondary" name="expires_at">
                            <div class="form-text text-muted">Dejar vacío para licencia perpetua.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-top border-white border-opacity-10">
                        <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary px-4">Generar Licencia</button>
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
        const table = $('#licensesTable').DataTable({
            ajax: 'api/get_licenses.php',
            columns: [
                { data: 'license_key', render: function(data){ return '<code class="text-primary fw-bold">'+data+'</code>'; } },
                { data: 'company_name', render: function(data){ return data ? '<span class="fw-medium">'+data+'</span>' : '<span class="opacity-50">N/A</span>'; } },
                { data: 'plan', render: function(data){ return '<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">'+(data || 'BASIC')+'</span>'; } },
                { data: 'status', render: function(data){
                    const color = data === 'active' ? 'success' : 'warning';
                    return '<span class="badge bg-'+color+' bg-opacity-10 text-'+color+' border border-'+color+' border-opacity-25 px-3">'+data.toUpperCase()+'</span>';
                }},
                { data: 'expires_at', render: function(data){ return data ? new Date(data).toLocaleDateString() : 'Perpetua'; } },
                { data: null, className: 'text-end', render: function(data){
                    return '<button class="btn btn-sm btn-outline-primary border-0"><i class="fa-solid fa-edit"></i></button>';
                }}
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"row mb-3"<"col-sm-6"l><"col-sm-6"f>>rt<"row mt-3"<"col-sm-6"i><"col-sm-6"p>>'
        });

        $('#formGenerateLicense').on('submit', function(e) {
            e.preventDefault();
            $.post('api/save_license.php', $(this).serialize(), function(response) {
                if(response.success) {
                    Swal.fire('¡Éxito!', 'Licencia creada: ' + response.key, 'success');
                    $('#modalGenerateLicense').modal('hide');
                    table.ajax.reload();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }, 'json');
        });
    });
    </script>
</body>
</html>
