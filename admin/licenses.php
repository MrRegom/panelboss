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

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

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

    <!-- Modal: Detalles de Empresa -->
    <div class="modal fade" id="modalCompanyDetails" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg" style="background-color: var(--bg-card);">
                <div class="modal-header border-bottom border-white border-opacity-10">
                    <h5 class="modal-title fw-bold text-info"><i class="fa-solid fa-building me-2"></i>Ficha del Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" id="detailsContent">
                    <!-- Se llena con JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Editar Expiración -->
    <div class="modal fade" id="modalEditExpiration" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="background-color: var(--bg-card);">
                <div class="modal-header border-bottom border-white border-opacity-10">
                    <h5 class="modal-title fw-bold text-warning"><i class="fa-solid fa-calendar-day me-2"></i>Vencimiento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditExpiration">
                    <div class="modal-body p-4">
                        <input type="hidden" name="id" id="edit_license_id">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">NUEVA FECHA</label>
                            <input type="date" class="form-control bg-dark border-secondary" name="expires_at" id="edit_expires_at" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top border-white border-opacity-10">
                        <button type="submit" class="btn btn-primary w-100">Actualizar Fecha</button>
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
                { 
                    data: 'company_name', 
                    render: function(data, type, row){ 
                        return `<a href="javascript:void(0)" class="text-info text-decoration-none fw-medium company-link" data-id="${row.id}">${data || 'N/A'}</a>`; 
                    } 
                },
                { data: 'plan', render: function(data){ return '<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">'+(data || 'BASIC')+'</span>'; } },
                { data: 'status', render: function(data){
                    const color = data === 'active' ? 'success' : 'warning';
                    return '<span class="badge bg-'+color+' bg-opacity-10 text-'+color+' border border-'+color+' border-opacity-25 px-3">'+data.toUpperCase()+'</span>';
                }},
                { data: 'expires_at', render: function(data){ return data ? new Date(data).toLocaleDateString() : 'Perpetua'; } },
                { data: null, className: 'text-end', render: function(data, type, row){
                    const statusIcon = row.status === 'active' ? 'fa-ban text-warning' : 'fa-check text-success';
                    const statusTitle = row.status === 'active' ? 'Suspender' : 'Activar';
                    return `
                        <div class="btn-group shadow-sm">
                            <button class="btn btn-sm btn-dark btn-edit" data-id="${row.id}" data-date="${row.expires_at}" title="Editar Fecha">
                                <i class="fa-solid fa-calendar-day text-info"></i>
                            </button>
                            <button class="btn btn-sm btn-dark btn-toggle-status" data-id="${row.id}" data-status="${row.status}" title="${statusTitle}">
                                <i class="fa-solid ${statusIcon}"></i>
                            </button>
                            <button class="btn btn-sm btn-dark btn-delete" data-id="${row.id}" title="Eliminar">
                                <i class="fa-solid fa-trash-can text-danger"></i>
                            </button>
                        </div>
                    `;
                }}
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"row mb-3"<"col-sm-6"l><"col-sm-6"f>>rt<"row mt-3"<"col-sm-6"i><"col-sm-6"p>>'
        });

        // Eliminar Licencia
        $('#licensesTable').on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: '¿Eliminar licencia?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('api/delete_license.php', { id: id }, function(res) {
                        if(res.success) {
                            Swal.fire('Eliminado', 'La licencia ha sido borrada.', 'success');
                            table.ajax.reload();
                        }
                    }, 'json');
                }
            });
        });

        // Alternar Estado (Activar/Suspender)
        $('#licensesTable').on('click', '.btn-toggle-status', function() {
            const id = $(this).data('id');
            const currentStatus = $(this).data('status');
            const newStatus = currentStatus === 'active' ? 'suspended' : 'active';
            
            $.post('api/update_license.php', { action: 'toggle_status', id: id, status: newStatus }, function(res) {
                if(res.success) {
                    Swal.fire('Estado Actualizado', 'La licencia ahora está ' + newStatus, 'success');
                    table.ajax.reload();
                }
            }, 'json');
        });

        // Ver Detalles de Empresa
        $('#licensesTable').on('click', '.company-link', function() {
            const data = table.row($(this).closest('tr')).data();
            const activationDate = data.activated_at ? new Date(data.activated_at).toLocaleDateString('es-CL', { day: '2-digit', month: 'long', year: 'numeric' }) : 'Pendiente de activación';
            
            const content = `
                <div class="mb-4 text-center">
                    <div class="h4 text-info fw-bold mb-1">${data.company_name}</div>
                    <div class="text-white-50 small">RUT: ${data.rut || 'No registrado'}</div>
                    <div class="mt-2"><span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3">Activado el: ${activationDate}</span></div>
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <div class="p-3 rounded bg-dark border border-secondary shadow-sm">
                            <label class="text-info small d-block mb-1 fw-bold">EMAIL CORPORATIVO</label>
                            <div class="text-white fs-5">${data.email || 'N/A'}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded bg-dark border border-secondary shadow-sm h-100">
                            <label class="text-info small d-block mb-1 fw-bold">TELÉFONO</label>
                            <div class="text-white">${data.phone || 'N/A'}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded bg-dark border border-secondary shadow-sm h-100">
                            <label class="text-info small d-block mb-1 fw-bold">CIUDAD/REGIÓN</label>
                            <div class="text-white">${data.address ? data.address.split(',')[0] : 'N/A'}</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 rounded bg-dark border border-secondary shadow-sm">
                            <label class="text-info small d-block mb-1 fw-bold">DIRECCIÓN COMPLETA</label>
                            <div class="text-white small">${data.address || 'Sin dirección registrada'}</div>
                        </div>
                    </div>
                </div>
            `;
            $('#detailsContent').html(content);
            $('#modalCompanyDetails').modal('show');
        });

        // Abrir Modal Editar Expiración
        $('#licensesTable').on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            const date = $(this).data('date');
            $('#edit_license_id').val(id);
            if(date) $('#edit_expires_at').val(date.split(' ')[0]);
            $('#modalEditExpiration').modal('show');
        });

        // Guardar Nueva Fecha
        $('#formEditExpiration').on('submit', function(e) {
            e.preventDefault();
            const $btn = $(this).find('button[type="submit"]');
            const originalText = $btn.html();
            
            $btn.prop('disabled', true).html('<i class="fas fa-sync fa-spin me-2"></i> Procesando cambios...');
            Swal.fire({ 
                title: 'Sincronizando con el servidor...', 
                html: 'Aplicando nueva fecha de expiración',
                allowOutsideClick: false, 
                didOpen: () => { Swal.showLoading() } 
            });

            $.post('api/update_license.php', $(this).serialize(), function(response) {
                // Forzamos 2.5 segundos de "épica"
                setTimeout(() => {
                    if(response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualización Exitosa!',
                            text: 'La licencia ha sido actualizada correctamente.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('Error', response.message, 'error');
                        $btn.prop('disabled', false).html(originalText);
                    }
                }, 2500);
            }, 'json');
        });

        $('#formGenerateLicense').on('submit', function(e) {
            e.preventDefault();
            const $btn = $(this).find('button[type="submit"]');
            const originalText = $btn.html();

            $btn.prop('disabled', true).html('<i class="fas fa-magic fa-spin me-2"></i> Forjando llave...');
            Swal.fire({ 
                title: 'Generando Nueva Licencia...', 
                html: 'Creando accesos criptográficos seguros',
                allowOutsideClick: false, 
                didOpen: () => { Swal.showLoading() } 
            });

            $.post('api/save_license.php', $(this).serialize(), function(response) {
                // Forzamos 2.5 segundos de "épica"
                setTimeout(() => {
                    if(response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Licencia Forjada!',
                            text: 'La nueva llave ha sido creada con éxito.',
                            confirmButtonText: 'Genial'
                        });
                        $('#modalGenerateLicense').modal('hide');
                        table.ajax.reload();
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                    $btn.prop('disabled', false).html(originalText);
                }, 2500);
            }, 'json');
        });
    });
    </script>
</body>
</html>
