<?php
/**
 * admin/catalogo.php — Gestión Elite del Catálogo Maestro
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    
    <style>
        :root { --accent: #0071E3; --bg-main: #0d1117; --bg-card: #161b22; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-main); color: #c9d1d9; }
        
        /* Layout */
        .app-header { background: rgba(13, 17, 23, 0.8) !important; backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.05); }
        
        /* DataTable Premium */
        .table { border-collapse: separate; border-spacing: 0 10px; }
        .table thead th { border: none; color: #8b949e; font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; padding: 15px; }
        .table tbody tr { background: var(--bg-card); transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-radius: 12px; }
        .table tbody tr:hover { transform: translateY(-2px); background: #1c2128; box-shadow: 0 8px 20px rgba(0,0,0,0.4); }
        .table td { border: none; padding: 18px !important; }
        .table td:first-child { border-radius: 12px 0 0 12px; }
        .table td:last-child { border-radius: 0 12px 12px 0; }

        /* Elements */
        .img-preview { width: 55px; height: 55px; object-fit: contain; background: #0d1117; border-radius: 12px; cursor: zoom-in; border: 1px solid rgba(255,255,255,0.05); transition: 0.3s; }
        .img-preview:hover { transform: scale(1.15); border-color: var(--accent); }
        
        .ean-display { 
            font-family: 'JetBrains Mono', monospace; 
            font-size: 12px; 
            color: #58a6ff; 
            background: rgba(88, 166, 255, 0.1); 
            padding: 5px 12px; 
            border-radius: 8px; 
            cursor: pointer;
            border: 1px solid rgba(88, 166, 255, 0.15);
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .ean-display:hover { background: rgba(88, 166, 255, 0.2); border-color: #58a6ff; color: #fff; }
        .ean-display i { font-size: 10px; opacity: 0.5; }

        /* Modal Elite */
        .modal-content { 
            background: rgba(22, 27, 34, 0.7) !important; 
            backdrop-filter: blur(25px) saturate(180%); 
            border: 1px solid rgba(255,255,255,0.1); 
            border-radius: 24px; 
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
        }
        .form-control, .form-select { 
            background: rgba(0,0,0,0.2) !important; 
            border: 1px solid rgba(255,255,255,0.08) !important; 
            border-radius: 12px; 
            color: #fff !important;
            padding: 14px;
            font-size: 14px;
        }
        .form-control:focus { border-color: var(--accent) !important; box-shadow: 0 0 0 4px rgba(0, 113, 227, 0.15); }
        
        .btn-action { width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; border-radius: 12px; transition: 0.2s; border: none; }
        .btn-action.edit { background: rgba(88, 166, 255, 0.1); color: #58a6ff; }
        .btn-action.delete { background: rgba(248, 81, 73, 0.1); color: #f85149; }
        .btn-action:hover { transform: scale(1.1); filter: brightness(1.2); }

        /* Custom Search */
        .dataTables_filter input { 
            background: var(--bg-card); 
            border: 1px solid rgba(255,255,255,0.1); 
            border-radius: 12px; 
            padding: 10px 20px; 
            color: #fff;
            min-width: 300px;
        }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main p-4">
            <div class="container-fluid">
                <div class="row align-items-center mb-5 mt-2">
                    <div class="col-md-6">
                        <h1 class="fw-bold mb-1 text-white letter-spacing-tight">Catálogo Maestro</h1>
                        <p class="text-muted small mb-0">Gestión de inventario global con sincronización en tiempo real</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="btn btn-primary px-4 py-2 fw-bold" onclick="openProductModal()" style="border-radius: 14px; background: var(--accent); border: none;">
                            <i class="fa-solid fa-plus-circle me-2"></i>NUEVO PRODUCTO
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="catalogTable" class="table align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>VISUAL</th>
                                <th>IDENTIFICACIÓN Y NOMBRE</th>
                                <th>MARCA</th>
                                <th>CATEGORÍA</th>
                                <th class="text-end">ACCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal: Agregar/Editar Producto -->
    <div class="modal fade" id="modalProduct" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 p-4 pb-0">
                    <h3 class="modal-title fw-bold text-white" id="modalTitle">Nuevo Producto</h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formProduct">
                    <input type="hidden" name="id" id="prod_id">
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label text-muted small fw-bold mb-2">CÓDIGO EAN (BARCODE)</label>
                                <input type="text" class="form-control" name="barcode" id="prod_barcode" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small fw-bold mb-2">DESCRIPCIÓN COMERCIAL</label>
                                <input type="text" class="form-control" name="name" id="prod_name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold mb-2">MARCA</label>
                                <input type="text" class="form-control" name="brand" id="prod_brand">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold mb-2">CATEGORÍA</label>
                                <select class="form-select" name="category_id" id="prod_category">
                                    <option value="">Sin Categoría</option>
                                    <?php foreach($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-link text-muted text-decoration-none me-auto" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary px-5 py-3 fw-bold" style="border-radius: 14px;">GUARDAR PRODUCTO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Zoom -->
    <div class="modal fade" id="modalZoom" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0 shadow-none">
                <div class="modal-body p-0 text-center">
                    <img src="" id="zoomImg" class="rounded-5 img-fluid shadow-2xl" style="max-height: 80vh;">
                </div>
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    const licenseKey = '<?= $licenseKey ?>';
    let table;

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        background: '#161b22',
        color: '#fff'
    });

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
                    width: '70px',
                    render: function(data, type, row) {
                        const url = data ? `/api/catalog/image.php?barcode=${row.barcode}&license_key=${licenseKey}` : 'https://placehold.co/100x100?text=No+Img';
                        return `<img src="${url}" class="img-preview" onclick="zoomImage('${url}')">`;
                    }
                },
                { 
                    data: 'name',
                    render: function(data, type, row) {
                        return `
                            <div class="d-flex flex-column gap-2">
                                <div class="ean-display" onclick="copyToClipboard('${row.barcode}', this)">
                                    <i class="fa-solid fa-barcode"></i>
                                    ${row.barcode}
                                    <i class="fa-solid fa-copy ms-1"></i>
                                </div>
                                <span class="fw-bold text-white fs-6">${data}</span>
                            </div>
                        `;
                    }
                },
                { data: 'brand', render: (data) => data ? `<span class="badge bg-secondary bg-opacity-10 text-secondary p-2 px-3 border border-secondary border-opacity-20">${data}</span>` : '-' },
                { data: 'category_name', render: (data) => data ? `<span class="text-muted small">${data}</span>` : '-' },
                { 
                    data: null, 
                    className: 'text-end',
                    render: function(data, type, row) {
                        return `
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn-action edit" onclick='openProductModal(${JSON.stringify(row)})' title="Editar">
                                    <i class="fa-solid fa-pen-nib"></i>
                                </button>
                                <button class="btn-action delete" onclick="deleteProduct(${row.id})" title="Eliminar">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"row align-items-center mb-4"<"col-sm-6"l><"col-sm-6 text-end"f>>rt<"row align-items-center mt-4"<"col-sm-6"i><"col-sm-6 text-end"p>>'
        });

        $('#formProduct').on('submit', function(e) {
            e.preventDefault();
            $.post('api/save_product.php', $(this).serialize(), function(res) {
                if(res.success) {
                    Toast.fire({ icon: 'success', title: 'Cambios guardados' });
                    $('#modalProduct').modal('hide');
                    table.ajax.reload(null, false);
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 'json');
        });
    });

    function copyToClipboard(text, el) {
        navigator.clipboard.writeText(text).then(() => {
            Toast.fire({ icon: 'success', title: 'Copiado al portapapeles' });
            $(el).css('background', 'rgba(88, 166, 255, 0.4)').delay(200).queue(function(next){
                $(this).css('background', 'rgba(88, 166, 255, 0.1)');
                next();
            });
        });
    }

    function zoomImage(url) {
        $('#zoomImg').attr('src', url);
        $('#modalZoom').modal('show');
    }

    function openProductModal(data = null) {
        $('#formProduct')[0].reset();
        if(data) {
            $('#modalTitle').text('Ficha de Producto');
            $('#prod_id').val(data.id);
            $('#prod_barcode').val(data.barcode).prop('readonly', true);
            $('#prod_name').val(data.name);
            $('#prod_brand').val(data.brand);
            $('#prod_category').val(data.category_id);
        } else {
            $('#modalTitle').text('Nuevo Registro');
            $('#prod_id').val('');
            $('#prod_barcode').prop('readonly', false);
        }
        $('#modalProduct').modal('show');
    }

    function deleteProduct(id) {
        Swal.fire({
            title: '¿Confirmar eliminación?',
            text: "Se eliminará permanentemente del catálogo maestro.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f85149',
            confirmButtonText: 'Eliminar ahora',
            background: '#161b22',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('api/delete_product.php', { id: id }, function(res) {
                    if(res.success) {
                        Toast.fire({ icon: 'success', title: 'Registro eliminado' });
                        table.ajax.reload(null, false);
                    }
                }, 'json');
            }
        });
    }
    </script>
</body>
</html>
