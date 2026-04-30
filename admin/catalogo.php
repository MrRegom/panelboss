<?php
/**
 * admin/catalogo.php — Gestión Minimalista y Eficiente del Catálogo Maestro
 */

require_once __DIR__ . '/includes/bootstrap.php';

use App\Config\Database;
use App\Services\AuthService;
use App\Repositories\MasterProductRepository;

AuthService::check();

$repo = new MasterProductRepository();
$categories = $repo->getCategories();

$db = Database::getConnection();
$stmtLic = $db->query("SELECT license_key FROM licenses WHERE status = 'active' LIMIT 1");
$licenseKey = $stmtLic->fetchColumn() ?: 'MASTER-KEY';
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Catálogo | CajaYa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    
    <style>
        :root { --accent: #0071E3; --bg: #0d1117; --border: rgba(255,255,255,0.1); }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: #c9d1d9; font-size: 13px; }
        
        /* Compact DataTable */
        .table { margin: 0 !important; border: 1px solid var(--border); }
        .table thead th { 
            background: #161b22; color: #8b949e; font-size: 11px; text-transform: uppercase; 
            padding: 10px 15px; border-bottom: 1px solid var(--border);
        }
        .table tbody td { padding: 8px 15px !important; border-bottom: 1px solid var(--border); vertical-align: middle; }
        .table tbody tr:hover { background: rgba(255,255,255,0.02); }

        /* Minimal Elements */
        .img-mini { width: 32px; height: 32px; object-fit: contain; background: #fff; border-radius: 4px; padding: 2px; }
        .ean-tech { 
            font-family: 'JetBrains Mono', monospace; font-size: 11px; color: #58a6ff; 
            cursor: pointer; padding: 2px 6px; background: rgba(88,166,255,0.1); border-radius: 4px;
        }
        .btn-action { 
            padding: 4px 8px; font-size: 12px; border-radius: 4px; border: 1px solid var(--border);
            background: transparent; color: #8b949e; cursor: pointer;
        }
        .btn-action:hover { color: #fff; border-color: #fff; }

        /* Minimalist Modal */
        .modal-content { background: #161b22 !important; border: 1px solid var(--border); border-radius: 8px; }
        .modal-header { border-bottom: 1px solid var(--border); padding: 12px 20px; }
        .modal-footer { border-top: 1px solid var(--border); padding: 12px 20px; }
        .form-control, .form-select { 
            background: #0d1117 !important; border: 1px solid var(--border) !important; 
            border-radius: 4px; color: #fff !important; font-size: 13px; padding: 8px 12px;
        }
        .form-control:focus { border-color: var(--accent) !important; box-shadow: none; }

        /* Search Box */
        .dataTables_filter input { 
            background: #0d1117; border: 1px solid var(--border); border-radius: 4px; padding: 5px 10px; color: #fff;
        }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand border-bottom border-white border-opacity-10">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#"> <i class="fa-solid fa-bars text-white"></i> </a> </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main p-3">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold m-0 text-white">Catálogo Maestro <span class="text-muted fw-normal fs-6 ms-2">| Gestión Directa</span></h5>
                    <button class="btn btn-primary btn-sm px-3" onclick="openModal()" style="border-radius: 4px;">
                        <i class="fa-solid fa-plus me-1"></i> NUEVO PRODUCTO
                    </button>
                </div>

                <div class="table-responsive">
                    <table id="catalogTable" class="table align-middle w-100">
                        <thead>
                            <tr>
                                <th style="width: 40px">IMG</th>
                                <th>EAN / NOMBRE</th>
                                <th>MARCA</th>
                                <th>CATEGORÍA</th>
                                <th class="text-end" style="width: 100px">ACCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Minimalista -->
    <div class="modal fade" id="modalProduct" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold" id="modalTitle">Producto</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formProduct">
                    <input type="hidden" name="id" id="prod_id">
                    <div class="modal-body p-3">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="small text-muted mb-1">EAN BARCODE</label>
                                <input type="text" class="form-control" name="barcode" id="prod_barcode" required>
                            </div>
                            <div class="col-12">
                                <label class="small text-muted mb-1">DESCRIPCIÓN</label>
                                <input type="text" class="form-control" name="name" id="prod_name" required>
                            </div>
                            <div class="col-6">
                                <label class="small text-muted mb-1">MARCA</label>
                                <input type="text" class="form-control" name="brand" id="prod_brand">
                            </div>
                            <div class="col-6">
                                <label class="small text-muted mb-1">CATEGORÍA</label>
                                <select class="form-select" name="category_id" id="prod_category">
                                    <option value="">- Seleccionar -</option>
                                    <?php foreach($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link text-muted p-0 me-3 text-decoration-none" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary px-4 btn-sm">GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    const licenseKey = '<?= $licenseKey ?>';
    let table;

    $(document).ready(function() {
        table = $('#catalogTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'api/get_master_catalog.php',
            pageLength: 50,
            ordering: false,
            columns: [
                { 
                    data: 'image_path',
                    render: function(data, type, row) {
                        const img = data ? `/api/catalog/image.php?barcode=${row.barcode}&license_key=${licenseKey}` : 'https://placehold.co/50x50?text=📦';
                        return `<img src="${img}" class="img-mini">`;
                    }
                },
                { 
                    data: 'name',
                    render: function(data, type, row) {
                        return `<div class="d-flex align-items-center gap-2"><span class="ean-tech" onclick="copyEan('${row.barcode}')">${row.barcode}</span> <span class="text-white">${data}</span></div>`;
                    }
                },
                { data: 'brand', render: (d) => d || '-' },
                { data: 'category_name', render: (d) => d || '-' },
                { 
                    data: null, 
                    className: 'text-end',
                    render: function(data, type, row) {
                        return `
                            <button class="btn-action" onclick='openModal(${JSON.stringify(row)})'><i class="fa-solid fa-pen"></i></button>
                            <button class="btn-action" onclick="deleteProd(${row.id})"><i class="fa-solid fa-trash"></i></button>
                        `;
                    }
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-2 d-flex justify-content-between align-items-center"<"d-flex align-items-center"l><"d-flex"f>>rt<"p-2 d-flex justify-content-between align-items-center"ip>'
        });

        $('#formProduct').on('submit', function(e) {
            e.preventDefault();
            $.post('api/save_product.php', $(this).serialize(), function(res) {
                if(res.success) {
                    $('#modalProduct').modal('hide');
                    table.ajax.reload(null, false);
                }
            }, 'json');
        });
    });

    function copyEan(text) {
        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({ icon: 'success', title: 'Copiado', toast: true, position: 'top-end', showConfirmButton: false, timer: 1000 });
        });
    }

    function openModal(data = null) {
        $('#formProduct')[0].reset();
        if(data) {
            $('#modalTitle').text('Editar Producto');
            $('#prod_id').val(data.id);
            $('#prod_barcode').val(data.barcode).prop('readonly', true);
            $('#prod_name').val(data.name);
            $('#prod_brand').val(data.brand);
            $('#prod_category').val(data.category_id);
        } else {
            $('#modalTitle').text('Nuevo Producto');
            $('#prod_id').val('');
            $('#prod_barcode').prop('readonly', false);
        }
        $('#modalProduct').modal('show');
    }

    function deleteProd(id) {
        if(confirm('¿Eliminar producto?')) {
            $.post('api/delete_product.php', { id: id }, function() { table.ajax.reload(null, false); });
        }
    }
    </script>
</body>
</html>
