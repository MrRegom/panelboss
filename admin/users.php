<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Services\AuthService;
AuthService::check();

$userName = $_SESSION['user_name'] ?? 'Administrador';
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Usuarios | PanelBoss PRO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <!-- Header con Usuario y Logout -->
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid px-4">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown user-menu"> 
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"> 
                            <span class="d-none d-md-inline fw-semibold me-2"><?= $userName ?></span>
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
                <a href="./index.php" class="brand-link border-0 text-center"> 
                    <span class="brand-text">PANELBOSS <span class="text-primary">PRO</span></span> 
                </a> 
            </div>
            <div class="sidebar-wrapper px-2">
                <nav class="mt-3">
                    <ul class="nav sidebar-menu flex-column">
                        <li class="nav-item"> <a href="./index.php" class="nav-link"> <i class="nav-icon fa-solid fa-house"></i> <p>Dashboard</p> </a> </li>
                        <li class="nav-header small text-muted px-4 mt-3">OPERACIONES</li>
                        <li class="nav-item"> <a href="./licenses.php" class="nav-link"> <i class="nav-icon fa-solid fa-key"></i> <p>Licencias</p> </a> </li>
                        <li class="nav-item"> <a href="./companies.php" class="nav-link"> <i class="nav-icon fa-solid fa-building"></i> <p>Empresas</p> </a> </li>
                        <li class="nav-header small text-muted px-4 mt-3">SISTEMA</li>
                        <li class="nav-item"> <a href="./users.php" class="nav-link active"> <i class="nav-icon fa-solid fa-users-gear"></i> <p>Usuarios</p> </a> </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <main class="app-main">
            <div class="app-content-header py-4">
                <div class="container-fluid px-4">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h3 class="fw-semibold mb-0">Gestión de Usuarios</h3>
                            <p class="text-muted small">Administradores y personal de soporte</p>
                        </div>
                        <div class="col-sm-6 text-end">
                            <button class="btn btn-primary shadow-sm" id="btnNewUser">
                                <i class="fa-solid fa-user-plus me-2"></i> NUEVO USUARIO
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="app-content px-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <table id="usersTable" class="table table-hover dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Último Acceso</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Usuario -->
    <div class="modal fade" id="modalUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="background-color: var(--bg-card);">
                <div class="modal-header border-bottom border-white border-opacity-10">
                    <h5 class="modal-title fw-bold" id="modalTitle">Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formUser">
                    <input type="hidden" name="id" id="user_id">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">NOMBRE COMPLETO</label>
                            <input type="text" class="form-control bg-dark border-secondary" name="full_name" id="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">EMAIL / USUARIO</label>
                            <input type="email" class="form-control bg-dark border-secondary" name="email" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">CONTRASEÑA</label>
                            <input type="password" class="form-control bg-dark border-secondary" name="password" id="password" placeholder="Dejar vacío para no cambiar">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">ROL</label>
                            <select class="form-select bg-dark border-secondary" name="role" id="role">
                                <option value="admin">Administrador</option>
                                <option value="soporte">Soporte</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-top border-white border-opacity-10">
                        <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary px-4">Guardar Usuario</button>
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
        const table = $('#usersTable').DataTable({
            ajax: 'api/get_users.php',
            columns: [
                { data: 'full_name', render: function(data){ return '<span class="fw-medium">'+data+'</span>'; } },
                { data: 'email' },
                { data: 'role', render: function(data){ return '<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">'+data.toUpperCase()+'</span>'; } },
                { data: 'status', render: function(data){
                    const color = data === 'active' ? 'success' : 'danger';
                    return '<span class="badge bg-'+color+' bg-opacity-10 text-'+color+' border border-'+color+' border-opacity-25 px-2 small">'+data.toUpperCase()+'</span>';
                }},
                { data: 'last_login', render: function(data){ return data ? new Date(data).toLocaleString() : 'Nunca'; } },
                { data: null, className: 'text-end', render: function(data){
                    const icon = data.status === 'active' ? 'fa-user-slash' : 'fa-user-check';
                    const btnClass = data.status === 'active' ? 'btn-outline-danger' : 'btn-outline-success';
                    return '<button class="btn btn-sm btn-outline-primary border-0 me-1 btn-edit"><i class="fa-solid fa-pen-to-square"></i></button>' +
                           '<button class="btn btn-sm '+btnClass+' border-0 btn-toggle" data-id="'+data.id+'" data-status="'+data.status+'"><i class="fa-solid '+icon+'"></i></button>';
                }}
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' }
        });

        // NUEVO USUARIO
        $('#btnNewUser').on('click', function() {
            $('#formUser')[0].reset();
            $('#user_id').val('');
            $('#modalTitle').text('Nuevo Usuario');
            $('#modalUser').modal('show');
        });

        // EDITAR USUARIO (CORRECCIÓN)
        $('#usersTable').on('click', '.btn-edit', function() {
            const data = table.row($(this).parents('tr')).data();
            $('#user_id').val(data.id);
            $('#full_name').val(data.full_name);
            $('#email').val(data.email);
            $('#role').val(data.role);
            $('#password').val(''); // Contraseña siempre vacía por seguridad
            $('#modalTitle').text('Editar Usuario');
            $('#modalUser').modal('show');
        });

        // Toggle Status
        $(document).on('click', '.btn-toggle', function() {
            const id = $(this).data('id');
            const status = $(this).data('status');
            $.post('api/toggle_user_status.php', {id, status}, function(res) {
                if(res.success) table.ajax.reload();
            }, 'json');
        });

        // Save User
        $('#formUser').on('submit', function(e) {
            e.preventDefault();
            $.post('api/save_user.php', $(this).serialize(), function(res) {
                if(res.success) {
                    $('#modalUser').modal('hide');
                    table.ajax.reload();
                    Swal.fire('¡Listo!', res.message, 'success');
                }
            }, 'json');
        });
    });
    </script>
</body>
</html>
