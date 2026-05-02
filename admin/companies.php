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
    <title>Empresas | CajaYa Premium</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
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
                            <h3 class="fw-bold mb-0">Directorio de Empresas</h3>
                            <p class="text-muted small mb-0">Gestión de partners y clientes corporativos.</p>
                        </div>
                        <div class="col-sm-6 text-end">
                            <button class="btn btn-silk shadow-sm px-4" onclick="openCompanyModal()">
                                <i class="fa-solid fa-plus me-2"></i> Nueva Empresa
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content px-4">
                <div class="container-fluid">
                    <div class="card card-silk border-0 shadow-sm">
                        <div class="table-responsive">
                            <table id="companiesTable" class="table silk-table w-100">
                                <thead>
                                    <tr>
                                        <th>EMPRESA</th>
                                        <th>RUT / ID</th>
                                        <th>TELÉFONO</th>
                                        <th>ESTADO</th>
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

    <!-- Modal Empresa -->
    <div class="modal fade" id="modalCompany" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="companyModalTitle">Registrar Empresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formCompany">
                    <input type="hidden" name="id" id="comp_id">
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">NOMBRE DE LA EMPRESA</label>
                            <input type="text" class="form-control" name="name" id="comp_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">RUT / ID FISCAL</label>
                            <input type="text" class="form-control" name="rut" id="comp_rut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">TELÉFONO</label>
                            <input type="text" class="form-control" name="phone" id="comp_phone">
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold text-muted">EMAIL</label>
                            <input type="email" class="form-control" name="email" id="comp_email">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">GUARDAR EMPRESA</button>
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
    let table;

    function openCompanyModal(data = null) {
        $('#formCompany')[0].reset();
        if(data) {
            $('#companyModalTitle').text('Editar Empresa');
            $('#comp_id').val(data.id);
            $('#comp_name').val(data.name);
            $('#comp_rut').val(data.rut);
            $('#comp_phone').val(data.phone);
            $('#comp_email').val(data.email);
        } else {
            $('#companyModalTitle').text('Registrar Empresa');
            $('#comp_id').val('');
        }
        $('#modalCompany').modal('show');
    }

    function deleteCompany(id, name) {
        Swal.fire({
            title: '¿Eliminar empresa?',
            text: `Vas a eliminar "${name}".`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('api/delete_company.php', { id: id }, function(res) {
                    if(res.success) {
                        Swal.fire('Eliminado', 'Empresa removida.', 'success');
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                }, 'json');
            }
        });
    }

    $(document).ready(function() {
        table = $('#companiesTable').DataTable({
            ajax: 'api/get_companies.php',
            columns: [
                { 
                    data: 'name', 
                    render: (d) => `
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 bg-indigo bg-opacity-10 text-indigo d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">${d.charAt(0)}</div>
                            <div class="fw-bold">${d}</div>
                        </div>` 
                },
                { data: 'rut', render: d => `<span class="text-muted small">${d || '-'}</span>` },
                { data: 'phone', render: d => `<span class="small">${d || '-'}</span>` },
                { 
                    data: 'status', 
                    render: d => `<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3">ACTIVA</span>` 
                },
                { 
                    data: null, 
                    className: 'text-end',
                    render: (d, t, row) => {
                        let rowData = JSON.stringify(row).replace(/"/g, '&quot;');
                        return `
                        <button class="btn btn-link text-primary p-2" onclick='openCompanyModal(${rowData})'><i class="fa-solid fa-edit"></i></button>
                        <button class="btn btn-link text-danger p-2" onclick="deleteCompany(${row.id}, '${row.name}')"><i class="fa-solid fa-trash"></i></button>`
                    }
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-4 d-flex justify-content-between align-items-center"lf>rt<"p-4 d-flex justify-content-between align-items-center"ip>'
        });

        $('#formCompany').on('submit', function(e) {
            e.preventDefault();
            $.post('api/save_company.php', $(this).serialize(), function(res) {
                if(res.success) {
                    Swal.fire('Éxito', res.message, 'success');
                    $('#modalCompany').modal('hide');
                    table.ajax.reload(null, false);
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 'json');
        });
    });
    </script>
</body>
</html>
