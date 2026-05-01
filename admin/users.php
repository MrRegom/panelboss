<?php
require_once __DIR__ . '/includes/bootstrap.php';
use App\Services\AuthService;
AuthService::check();

$userName = $_SESSION['user_name'] ?? 'Administrador';
?>
<!DOCTYPE html>
<html lang="es">
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
                            <h3 class="fw-bold mb-0">Gestión de Usuarios</h3>
                            <p class="text-muted small">Administradores y personal de soporte</p>
                        </div>
                        <div class="col-sm-6 text-end">
                            <button class="btn btn-primary" id="btnNewUser">
                                <i class="fa-solid fa-user-plus me-2"></i> NUEVO USUARIO
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="app-content px-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <table id="usersTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="ps-4">Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Último Acceso</th>
                                    <th class="text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Usuario -->
    <div class="modal fade" id="modalUser" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Ficha de Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formUser">
                    <input type="hidden" name="id" id="user_id">
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label class="small fw-bold text-muted mb-2">NOMBRE COMPLETO</label>
                            <input type="text" class="form-control" name="full_name" id="full_name" required placeholder="Ej: Juan Pérez">
                        </div>
                        <div class="mb-4">
                            <label class="small fw-bold text-muted mb-2">EMAIL / USUARIO</label>
                            <input type="email" class="form-control" name="email" id="email" required placeholder="email@ejemplo.com">
                        </div>
                        <div class="mb-4">
                            <label class="small fw-bold text-muted mb-2">CONTRASEÑA</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Mínimo 8 caracteres">
                        </div>
                        <div class="mb-0">
                            <label class="small fw-bold text-muted mb-2">ROL DE ACCESO</label>
                            <select class="form-select" name="role" id="role">
                                <option value="admin">Administrador (Control Total)</option>
                                <option value="soporte">Soporte (Solo Lectura/Edición)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">GUARDAR USUARIO</button>
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
                { data: 'full_name', className: 'ps-4', render: (d) => '<span class="fw-bold text-dark">'+d+'</span>' },
                { data: 'email', render: (d) => '<span class="text-muted">'+d+'</span>' },
                { data: 'role', render: function(d){ return '<span class="badge bg-primary bg-opacity-10 text-primary border-0">'+d.toUpperCase()+'</span>'; } },
                { data: 'status', render: function(d){
                    const color = d === 'active' ? 'success' : 'danger';
                    return '<span class="badge bg-'+color+' bg-opacity-10 text-'+color+' border-0">'+d.toUpperCase()+'</span>';
                }},
                { data: 'last_login', render: function(d){ return d ? '<span class="small text-muted">'+new Date(d).toLocaleString()+'</span>' : '<span class="small text-muted italic">Nunca</span>'; } },
                { data: null, className: 'text-end pe-4', render: function(d){
                    const icon = d.status === 'active' ? 'fa-user-slash text-danger' : 'fa-user-check text-success';
                    return '<button class="btn btn-sm btn-light border me-1 btn-edit"><i class="fa-solid fa-pen text-primary"></i></button>' +
                           '<button class="btn btn-sm btn-light border btn-toggle" data-id="'+d.id+'" data-status="'+d.status+'"><i class="fa-solid '+icon+'"></i></button>';
                }}
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-3 d-flex justify-content-between align-items-center"lf>rt<"p-3 d-flex justify-content-between align-items-center"ip>'
        });

        $('#btnNewUser').on('click', function() {
            $('#formUser')[0].reset();
            $('#user_id').val('');
            $('#modalTitle').text('Nuevo Usuario');
            $('#modalUser').modal('show');
        });

        $('#usersTable').on('click', '.btn-edit', function() {
            const data = table.row($(this).parents('tr')).data();
            $('#user_id').val(data.id);
            $('#full_name').val(data.full_name);
            $('#email').val(data.email);
            $('#role').val(data.role);
            $('#password').val('');
            $('#modalTitle').text('Editar Usuario');
            $('#modalUser').modal('show');
        });

        $(document).on('click', '.btn-toggle', function() {
            const id = $(this).data('id');
            const status = $(this).data('status');
            $.post('api/toggle_user_status.php', {id, status}, function(res) {
                if(res.success) table.ajax.reload();
            }, 'json');
        });

        $('#formUser').on('submit', function(e) {
            e.preventDefault();
            $.post('api/save_user.php', $(this).serialize(), function(res) {
                if(res.success) {
                    $('#modalUser').modal('hide');
                    table.ajax.reload();
                    Swal.fire({ icon: 'success', title: '¡Listo!', text: res.message, toast: true, position: 'top-end', showConfirmButton: false, timer: 1500 });
                }
            }, 'json');
        });
    });
    </script>
</body>
</html>
