<?php
/**
 * admin/catalogo.php — Gestión Avanzada del Catálogo Maestro (DataTables + AJAX)
 */

require_once __DIR__ . '/includes/bootstrap.php';

use App\Config\Database;
use App\Services\AuthService;
use App\Repositories\MasterProductRepository;

AuthService::check();

$repo = new MasterProductRepository();
$categories = $repo->getCategories();

// Obtener licencia maestra para previsualización
$db = Database::getConnection();
$stmtLic = $db->query("SELECT license_key FROM licenses WHERE status = 'active' LIMIT 1");
$licenseKey = $stmtLic->fetchColumn() ?: 'MASTER-KEY';
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Catálogo Maestro | CajaYa Enterprise</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
    <style>
        :root { --accent: #0071E3; }
        body { font-family: 'Inter', sans-serif; background: #0c0e11; }
        .table img { width: 45px; height: 45px; object-fit: contain; background: #1a1e23; border-radius: 8px; cursor: pointer; transition: 0.2s; }
        .table img:hover { transform: scale(1.1); box-shadow: 0 4px 12px rgba(0,0,0,0.5); }
        .badge-ean { font-family: monospace; font-size: 11px; background: rgba(255,255,255,0.05); color: #888; padding: 2px 6px; border-radius: 4px; }
        .btn-action { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: 0.2s; }
        .btn-action:hover { transform: translateY(-2px); }
        
        /* Modal Zoom */
        #modalZoom img { max-width: 100%; border-radius: 12px; }
        
        /* Custom DataTable Dark */
        .dataTables_wrapper .dataTables_paginate .page-link { background: #1a1e23; border-color: #2d3238; color: #fff; }
        .dataTables_wrapper .dataTables_paginate .page-item.active .page-link { background: var(--accent); border-color: var(--accent); }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-dark border-bottom border-white border-opacity-10">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main p-4">
            <div class="container-fluid">
                <div class="row align-items-center mb-4">
                    <div class="col-md-6">
                        <h2 class="fw-bold mb-1">Catálogo Maestro</h2>
                        <p class="text-muted small">Gestión centralizada de productos globales (7,000+ registros)</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="/import_catalog.php" class="btn btn-outline-success me-2 border-0 bg-success bg-opacity-10 text-success">
                            <i class="fa-solid fa-file-import me-2"></i>Sincronizar CSV
                        </a>
                        <button class="btn btn-primary px-4 shadow-sm" onclick="openProductModal()">
                            <i class="fa-solid fa-plus me-2"></i>NUEVO PRODUCTO
                        </button>
                    </div>
                </div>

                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="card-body p-4">
                        <table id="catalogTable" class="table table-hover align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 60px">FOTO</th>
                                    <th>CÓDIGO / NOMBRE</th>
                                    <th>MARCA</th>
                                    <th>CATEGORÍA</th>
                                    <th class="text-end">ACCIONES</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal: Agregar/Editar Producto -->
    <div class="modal fade" id="modalProduct" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg bg-dark">
                <div class="modal-header border-bottom border-white border-opacity-10">
                    <h5 class="modal-title fw-bold" id="modalTitle">Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formProduct">
                    <input type="hidden" name="id" id="prod_id">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label text-muted small fw-bold">CÓDIGO DE BARRAS (EAN)</label>
                                <input type="text" class="form-control bg-black border-secondary" name="barcode" id="prod_barcode" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small fw-bold">NOMBRE DEL PRODUCTO</label>
                                <input type="text" class="form-control bg-black border-secondary" name="name" id="prod_name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">MARCA</label>
                                <input type="text" class="form-control bg-black border-secondary" name="brand" id="prod_brand">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">CATEGORÍA</label>
                                <select class="form-select bg-black border-secondary" name="category_id" id="prod_category">
                                    <option value="">Sin Categoría</option>
                                    <?php foreach($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small fw-bold">DESCRIPCIÓN</label>
                                <textarea class="form-control bg-black border-secondary" name="description" id="prod_description" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top border-white border-opacity-10">
                        <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary px-4">Guardar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Zoom -->
    <div class="modal fade" id="modalZoom" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 text-center">
                    <img src="" id="zoomImg" class="shadow-lg">
                </div>
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/js/adminlte.min.js"></script>
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
            columns: [
                { 
                    data: 'image_path',
                    render: function(data, type, row) {
                        const url = data ? `/api/catalog/image.php?barcode=${row.barcode}&license_key=${licenseKey}` : 'https://placehold.co/100x100?text=No+Img';
                        return `<img src="${url}" class="zoomable" onclick="zoomImage('${url}')">`;
                    }
                },
                { 
                    data: 'name',
                    render: function(data, type, row) {
                        return `<div><span class="badge-ean">${row.barcode}</span><br><div class="fw-bold text-white mt-1">${data}</div></div>`;
                    }
                },
                { data: 'brand', render: (data) => data || '<span class="text-muted small">Genérico</span>' },
                { data: 'category_name', render: (data) => data || '<span class="text-muted small">Sin Categoría</span>' },
                { 
                    data: null, 
                    className: 'text-end',
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn-action bg-primary bg-opacity-10 text-primary border-0" onclick='openProductModal(${JSON.stringify(row)})'>
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn-action bg-danger bg-opacity-10 text-danger border-0" onclick="deleteProduct(${row.id})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"row align-items-center mb-3"<"col-sm-6"l><"col-sm-6 text-end"f>>rt<"row align-items-center mt-3"<"col-sm-6"i><"col-sm-6 text-end"p>>'
        });

        $('#formProduct').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Guardando...');

            $.post('api/save_product.php', $(this).serialize(), function(res) {
                btn.prop('disabled', false).html('Guardar Producto');
                if(res.success) {
                    Swal.fire('¡Éxito!', res.message, 'success');
                    $('#modalProduct').modal('hide');
                    table.ajax.reload(null, false);
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 'json');
        });
    });

    function zoomImage(url) {
        $('#zoomImg').attr('src', url);
        $('#modalZoom').modal('show');
    }

    function openProductModal(data = null) {
        $('#formProduct')[0].reset();
        if(data) {
            $('#modalTitle').text('Editar Producto');
            $('#prod_id').val(data.id);
            $('#prod_barcode').val(data.barcode).prop('readonly', true);
            $('#prod_name').val(data.name);
            $('#prod_brand').val(data.brand);
            $('#prod_category').val(data.category_id);
            $('#prod_description').val(data.description);
        } else {
            $('#modalTitle').text('Nuevo Producto');
            $('#prod_id').val('');
            $('#prod_barcode').prop('readonly', false);
        }
        $('#modalProduct').modal('show');
    }

    function deleteProduct(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "El producto será eliminado permanentemente del catálogo maestro.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('api/delete_product.php', { id: id }, function(res) {
                    if(res.success) {
                        Swal.fire('Eliminado', res.message, 'success');
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                }, 'json');
            }
        });
    }
    </script>
</body>
</html>
