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
                            <h3 class="fw-bold mb-0">Gestión de Licencias</h3>
                            <p class="text-muted small">Control maestro de llaves y planes de servicio</p>
                        </div>
                        <div class="col-sm-6 text-end">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalGenerateLicense">
                                <i class="fa-solid fa-plus me-2"></i> NUEVA LICENCIA
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
                                <table id="licensesTable" class="table table-hover align-middle mb-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">LLAVE (LICENSE KEY)</th>
                                            <th>EMPRESA</th>
                                            <th>PLAN</th>
                                            <th>ESTADO</th>
                                            <th>EXPIRACIÓN</th>
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

    <!-- Modal: Generar Licencia -->
    <div class="modal fade" id="modalGenerateLicense" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Forjar Nueva Licencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formGenerateLicense">
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label class="small fw-bold text-muted mb-2">SELECCIONAR EMPRESA</label>
                            <select class="form-select" name="company_id" required>
                                <option value="">Busque o seleccione empresa...</option>
                                <?php
                                $companies = $db->query("SELECT id, name FROM companies ORDER BY name ASC")->fetchAll();
                                foreach($companies as $c) { echo "<option value='{$c['id']}'>{$c['name']}</option>"; }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="small fw-bold text-muted mb-2">KEY PERSONALIZADA (OPCIONAL)</label>
                            <input type="text" class="form-control" name="custom_key" placeholder="Ej: CAJAYA-PRO-2026">
                        </div>
                        <div class="mb-4">
                            <label class="small fw-bold text-muted mb-2">PLAN ASOCIADO</label>
                            <select class="form-select" name="plan" required>
                                <option value="BASIC">BASIC</option>
                                <option value="PRO">PRO</option>
                                <option value="ENTERPRISE">ENTERPRISE</option>
                                <option value="DEMO">DEMO</option>
                            </select>
                        </div>
                        <div class="mb-0">
                            <label class="small fw-bold text-muted mb-2">FECHA DE EXPIRACIÓN</label>
                            <input type="date" class="form-control" name="expires_at">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">GENERAR LLAVE MAESTRA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Detalles de Empresa -->
    <div class="modal fade" id="modalCompanyDetails" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-primary"><i class="fa-solid fa-building me-2"></i>Ficha del Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" id="detailsContent">
                    <!-- Dinámico -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Editar Licencia -->
    <div class="modal fade" id="modalEditLicense" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-pen-to-square me-2"></i>Editar Licencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditLicense">
                    <div class="modal-body p-4">
                        <input type="hidden" name="id" id="edit_license_id">
                        <input type="hidden" name="action" value="update_full">
                        
                        <div class="mb-4">
                            <label class="small fw-bold text-muted mb-2">TRANSFERIR A EMPRESA</label>
                            <select class="form-select" name="company_id" id="edit_company_id" required>
                                <?php foreach($companies as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold text-muted mb-2">NIVEL DE PLAN</label>
                            <select class="form-select" name="plan" id="edit_plan" required>
                                <option value="BASIC">BASIC</option>
                                <option value="PRO">PRO</option>
                                <option value="ENTERPRISE">ENTERPRISE</option>
                                <option value="DEMO">DEMO</option>
                            </select>
                        </div>

                        <div class="mb-0">
                            <label class="small fw-bold text-muted mb-2">NUEVA FECHA DE EXPIRACIÓN</label>
                            <input type="date" class="form-control" name="expires_at" id="edit_expires_at">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">ACTUALIZAR LICENCIA</button>
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
                { data: 'license_key', className: 'ps-4', render: (d) => '<code>'+d+'</code>' },
                { 
                    data: 'company_name', 
                    render: (d, t, r) => `<a href="javascript:void(0)" class="text-primary text-decoration-none fw-bold company-link" data-id="${r.id}">${d || 'N/A'}</a>` 
                },
                { data: 'plan', render: (d) => '<span class="badge bg-light text-muted border">'+(d || 'BASIC')+'</span>' },
                { data: 'status', render: (d) => {
                    const color = d === 'active' ? 'success' : 'warning';
                    return '<span class="badge bg-'+color+' bg-opacity-10 text-'+color+' border-0 px-3">'+d.toUpperCase()+'</span>';
                }},
                { data: 'expires_at', render: (d) => d ? '<span class="small text-muted">'+new Date(d).toLocaleDateString()+'</span>' : '<span class="badge bg-light text-muted border">Perpetua</span>' },
                { data: null, className: 'text-end pe-4', render: (d, t, r) => {
                    const statusIcon = r.status === 'active' ? 'fa-ban text-danger' : 'fa-check text-success';
                    return `
                        <div class="btn-group">
                            <button class="btn btn-sm btn-light border btn-edit" data-id="${r.id}" title="Editar"><i class="fa-solid fa-pen text-primary"></i></button>
                            <button class="btn btn-sm btn-light border btn-toggle-status" data-id="${r.id}" data-status="${r.status}"><i class="fa-solid ${statusIcon}"></i></button>
                            <button class="btn btn-sm btn-light border btn-delete" data-id="${r.id}"><i class="fa-solid fa-trash text-muted"></i></button>
                        </div>`;
                }}
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-3 d-flex justify-content-between align-items-center"lf>rt<"p-3 d-flex justify-content-between align-items-center"ip>'
        });

        $('#licensesTable').on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            Swal.fire({ title: '¿Eliminar licencia?', text: "Esta acción no se puede deshacer.", icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Sí, eliminar' }).then((result) => {
                if (result.isConfirmed) {
                    $.post('api/delete_license.php', { id: id }, (res) => { if(res.success){ table.ajax.reload(); Swal.fire('Eliminado', res.message, 'success'); } }, 'json');
                }
            });
        });

        $('#licensesTable').on('click', '.btn-toggle-status', function() {
            const id = $(this).data('id');
            const newStatus = $(this).data('status') === 'active' ? 'suspended' : 'active';
            $.post('api/update_license.php', { action: 'toggle_status', id: id, status: newStatus }, () => table.ajax.reload(), 'json');
        });

        $('#licensesTable').on('click', '.company-link', function() {
            const data = table.row($(this).closest('tr')).data();
            const activationDate = data.activated_at ? new Date(data.activated_at).toLocaleDateString('es-CL') : 'Pendiente';
            const content = `
                <div class="text-center mb-4">
                    <h5 class="fw-bold mb-1">${data.company_name}</h5>
                    <span class="text-muted small">RUT: ${data.rut || 'No registrado'}</span>
                </div>
                <div class="p-3 bg-light rounded border mb-3">
                    <label class="small fw-bold text-primary d-block mb-1 text-uppercase">Email de Contacto</label>
                    <div class="fw-bold">${data.email || 'N/A'}</div>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded border">
                            <label class="small fw-bold text-primary d-block mb-1 text-uppercase">Teléfono</label>
                            <div class="fw-bold">${data.phone || 'N/A'}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded border">
                            <label class="small fw-bold text-primary d-block mb-1 text-uppercase">Activación</label>
                            <div class="fw-bold">${activationDate}</div>
                        </div>
                    </div>
                </div>`;
            $('#detailsContent').html(content);
            $('#modalCompanyDetails').modal('show');
        });

        $('#licensesTable').on('click', '.btn-edit', function() {
            const data = table.row($(this).closest('tr')).data();
            $('#edit_license_id').val(data.id);
            $('#edit_company_id').val(data.company_id || '');
            $('#edit_plan').val(data.plan || 'BASIC');
            if(data.expires_at) $('#edit_expires_at').val(data.expires_at.split(' ')[0]);
            $('#modalEditLicense').modal('show');
        });

        $('#formEditLicense').on('submit', function(e) {
            e.preventDefault();
            $.post('api/update_license.php', $(this).serialize(), (res) => {
                if(res.success){ $('#modalEditLicense').modal('hide'); table.ajax.reload(); Swal.fire({ icon: 'success', title: 'Actualizado', toast: true, position: 'top-end', showConfirmButton: false, timer: 1500 }); }
            }, 'json');
        });

        $('#formGenerateLicense').on('submit', function(e) {
            e.preventDefault();
            $.post('api/save_license.php', $(this).serialize(), (res) => {
                if(res.success){ $('#modalGenerateLicense').modal('hide'); table.ajax.reload(); Swal.fire({ icon: 'success', title: 'Generada', text: 'Licencia creada con éxito', confirmButtonColor: '#6A37B7' }); }
            }, 'json');
        });
    });
    </script>
</body>
</html>
