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
    <title>Licencias | CajaYa Pro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
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
                        <div class="col-sm-6">
                            <h3 class="fw-bold mb-0">Gestión de Licencias</h3>
                            <p class="text-muted small mb-0">Control de activación y vigencia de planes.</p>
                        </div>
                        <div class="col-sm-6 text-end">
                            <button class="btn btn-silk shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalGenerateLicense">
                                <i class="fa-solid fa-plus me-2"></i> Generar Licencia
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content px-4">
                <div class="container-fluid">
                    <div class="card card-silk border-0 shadow-sm">
                        <div class="table-responsive">
                            <table id="licensesTable" class="table silk-table w-100">
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
            <?php include __DIR__ . '/includes/footer.php'; ?>
        </main>
    </div>

    <!-- Modal Generar Licencia -->
    <div class="modal fade" id="modalGenerateLicense" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Generar Nueva Licencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formGenerateLicense">
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">PLAN</label>
                            <select class="form-select" name="plan" required>
                                <option value="BASIC">BASIC</option>
                                <option value="PRO">PRO</option>
                                <option value="ENTERPRISE">ENTERPRISE</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">FECHA DE EXPIRACIÓN (OPCIONAL)</label>
                            <input type="date" class="form-control" name="expires_at">
                            <div class="form-text text-muted">Dejar vacío para licencia perpetua.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary px-4 fw-bold w-100 py-2">GENERAR LICENCIA</button>
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
                { data: 'license_key', render: d => `<code class="text-primary fw-bold small">${d}</code>` },
                { data: 'company_name', className: 'fw-bold small' },
                { data: 'plan', render: d => `<span class="badge bg-light text-dark border small px-2">${d}</span>` },
                { 
                    data: 'status', 
                    render: d => `<span class="fw-bold small ${d === 'active' ? 'text-success' : 'text-warning'} text-uppercase">${d}</span>` 
                },
                { data: 'expires_at', render: d => `<span class="text-muted small">${d ? new Date(d).toLocaleDateString() : '-'}</span>` },
                { 
                    data: null, 
                    className: 'text-end',
                    render: (d, t, row) => {
                        let rowData = JSON.stringify(row).replace(/"/g, '&quot;');
                        return `
                        <button class="btn btn-link text-primary p-1" onclick='openEditLicense(${rowData})'><i class="fa-solid fa-edit"></i></button>
                        <button class="btn btn-link text-danger p-1" onclick="deleteLicense(${row.id}, '${row.license_key}')"><i class="fa-solid fa-trash"></i></button>`
                    }
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-4 d-flex justify-content-between align-items-center"lf>rt<"p-4 d-flex justify-content-between align-items-center"ip>'
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

        // Form Edit Submit
        $('#formEditLicense').on('submit', function(e) {
            e.preventDefault();
            $.post('api/update_license.php', $(this).serialize(), function(res) {
                if(res.success) {
                    Swal.fire('Actualizado', 'Licencia modificada.', 'success');
                    $('#modalEditLicense').modal('hide');
                    table.ajax.reload(null, false);
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 'json');
        });
    });

    function openEditLicense(data) {
        $('#edit_lic_id').val(data.id);
        $('#edit_lic_key').val(data.license_key);
        $('#edit_lic_plan').val(data.plan);
        $('#edit_lic_status').val(data.status);
        $('#edit_lic_expires').val(data.expires_at ? data.expires_at.split(' ')[0] : '');
        $('#modalEditLicense').modal('show');
    }

    function deleteLicense(id, key) {
        Swal.fire({
            title: '¿Eliminar licencia?',
            text: `Vas a eliminar la llave ${key}.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('api/delete_license.php', { id: id }, function(res) {
                    if(res.success) {
                        Swal.fire('Eliminado', 'La licencia ha sido removida.', 'success');
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                }, 'json');
            }
        });
    }
    </script>

    <!-- Modal Editar Licencia -->
    <div class="modal fade" id="modalEditLicense" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Editar Licencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditLicense">
                    <input type="hidden" name="id" id="edit_lic_id">
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">LLAVE</label>
                            <input type="text" class="form-control bg-light" id="edit_lic_key" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">PLAN</label>
                            <select class="form-select" name="plan" id="edit_lic_plan" required>
                                <option value="BASIC">BASIC</option>
                                <option value="PRO">PRO</option>
                                <option value="ENTERPRISE">ENTERPRISE</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">ESTADO</label>
                            <select class="form-select" name="status" id="edit_lic_status" required>
                                <option value="active">ACTIVE</option>
                                <option value="pending">PENDING</option>
                                <option value="suspended">SUSPENDED</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">EXPIRACIÓN</label>
                            <input type="date" class="form-control" name="expires_at" id="edit_lic_expires">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">GUARDAR CAMBIOS</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
