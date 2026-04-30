<?php
/**
 * admin/catalogo.php — Gestión Avanzada con Carga de Imágenes (Versión Corregida)
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
        
        /* Table Compact */
        .table { border: 1px solid var(--border); }
        .table thead th { background: #161b22; color: #8b949e; font-size: 11px; padding: 10px 15px; border-bottom: 1px solid var(--border); }
        .table tbody td { padding: 6px 15px !important; border-bottom: 1px solid var(--border); vertical-align: middle; }
        
        .img-mini { width: 32px; height: 32px; object-fit: contain; background: #fff; border-radius: 4px; padding: 2px; cursor: pointer; }
        .ean-tech { font-family: 'JetBrains Mono', monospace; font-size: 11px; color: #58a6ff; cursor: pointer; background: rgba(88,166,255,0.05); padding: 2px 6px; border-radius: 4px; }
        
        .btn-action { 
            padding: 4px 8px; font-size: 12px; border-radius: 4px; border: 1px solid var(--border);
            background: transparent; color: #8b949e; cursor: pointer; margin-left: 4px;
        }
        .btn-action:hover { color: #fff; border-color: #fff; }
        .btn-action.view { color: #58a6ff; border-color: rgba(88,166,255,0.3); }

        /* Modal Elite */
        .modal-content { background: #161b22 !important; border: 1px solid var(--border); border-radius: 12px; }
        .form-control, .form-select { background: #0d1117 !important; border: 1px solid var(--border) !important; border-radius: 6px; color: #fff !important; font-size: 13px; padding: 10px; }
        
        /* Photo Area */
        .photo-upload-container {
            width: 100%; height: 160px; border: 2px dashed var(--border); border-radius: 10px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            cursor: pointer; position: relative; overflow: hidden; background: #0d1117;
            transition: 0.2s;
        }
        .photo-upload-container:hover { border-color: var(--accent); background: rgba(0, 113, 227, 0.05); }
        .photo-upload-container img { max-height: 100%; object-fit: contain; z-index: 1; }
        .photo-upload-container .upload-hint { position: absolute; bottom: 10px; font-size: 10px; color: #555; z-index: 2; }
        .photo-upload-container .camera-icon { color: #555; font-size: 24px; position: absolute; z-index: 0; }

        .epic-photo-view { max-width: 100%; max-height: 350px; object-fit: contain; background: #fff; border-radius: 12px; padding: 10px; margin-bottom: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.5); }
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
                    <h5 class="fw-bold m-0 text-white">Catálogo Maestro</h5>
                    <button class="btn btn-primary btn-sm px-4" onclick="openEditModal()" style="border-radius: 4px;">
                        <i class="fa-solid fa-plus me-1"></i> NUEVO PRODUCTO
                    </button>
                </div>

                <div class="row mb-3 align-items-end g-2">
                    <div class="col-md-3">
                        <label class="small text-muted mb-1">Filtrar por Categoría:</label>
                        <select id="filterCategory" class="form-select form-select-sm">
                            <option value="">Todas</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="catalogTable" class="table align-middle w-100">
                        <thead>
                            <tr>
                                <th style="width: 40px">IMG</th>
                                <th style="width: 140px">CÓDIGO (EAN)</th>
                                <th>ARTÍCULO / DESCRIPCIÓN</th>
                                <th>CATEGORÍA</th>
                                <th class="text-end" style="width: 110px">ACCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Form (Crear/Editar) -->
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold" id="editModalTitle">Ficha de Producto</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formProduct" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="prod_id">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <!-- Area de Foto -->
                            <div class="col-12 mb-2">
                                <div class="photo-upload-container" onclick="$('#prod_image').click()">
                                    <i class="fa-solid fa-camera camera-icon"></i>
                                    <img src="" id="preview_img" style="display:none">
                                    <div class="upload-hint">Click para cargar foto del producto</div>
                                </div>
                                <input type="file" name="image" id="prod_image" class="d-none" accept="image/*">
                            </div>
                            
                            <div class="col-12">
                                <label class="small text-muted mb-1">CÓDIGO EAN</label>
                                <input type="text" class="form-control" name="barcode" id="prod_barcode" required placeholder="Ej: 7800000000000">
                            </div>
                            <div class="col-12">
                                <label class="small text-muted mb-1">NOMBRE COMPLETO</label>
                                <input type="text" class="form-control" name="name" id="prod_name" required placeholder="Nombre descriptivo">
                            </div>
                            <div class="col-12">
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
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">GUARDAR REGISTRO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal View (Épico) -->
    <div class="modal fade" id="modalView" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-4 text-center">
                    <h5 id="view_name" class="fw-bold text-white mb-3">Nombre</h5>
                    <img src="" id="view_img" class="epic-photo-view">
                    <div id="view_barcode" class="ean-tech d-inline-block px-4 py-2 fs-6">000000000000</div>
                    <div class="mt-4">
                        <button class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
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
            ajax: {
                url: 'api/get_master_catalog.php',
                data: function(d) { d.category_id = $('#filterCategory').val(); }
            },
            pageLength: 50,
            ordering: false,
            columns: [
                { 
                    data: 'image_path',
                    render: function(data, type, row) {
                        const img = data ? `/api/catalog/image.php?barcode=${row.barcode}&license_key=${licenseKey}` : 'https://placehold.co/50x50?text=📦';
                        return `<img src="${img}" class="img-mini" onclick='openViewModal(${JSON.stringify(row).replace(/'/g, "&apos;")})'>`;
                    }
                },
                { data: 'barcode', render: (d) => `<span class="ean-tech" onclick="copyEan('${d}')">${d}</span>` },
                { data: 'name', render: (d) => `<span class="text-white fw-medium">${d}</span>` },
                { data: 'category_name', render: (d) => `<span class="small text-uppercase text-muted">${d || '-'}</span>` },
                { 
                    data: null, 
                    className: 'text-end',
                    render: function(data, type, row) {
                        const rowData = JSON.stringify(row).replace(/'/g, "&apos;");
                        return `
                            <button class="btn-action view" onclick='openViewModal(${rowData})' title="Ver Detalle"><i class="fa-solid fa-eye"></i></button>
                            <button class="btn-action" onclick='openEditModal(${rowData})' title="Editar"><i class="fa-solid fa-pen"></i></button>
                        `;
                    }
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-2 d-flex justify-content-between align-items-center"lf>rt<"p-2 d-flex justify-content-between align-items-center"ip>'
        });

        $('#filterCategory').on('change', function() { table.ajax.reload(); });

        // Preview Image logic
        $('#prod_image').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) { 
                    $('#preview_img').attr('src', e.target.result).show();
                    $('.camera-icon, .upload-hint').hide();
                }
                reader.readAsDataURL(file);
            }
        });

        $('#formProduct').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: 'api/save_product.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if(res.success) {
                        Swal.fire({ icon: 'success', title: res.message, toast: true, position: 'top-end', showConfirmButton: false, timer: 1500 });
                        $('#modalEdit').modal('hide');
                        table.ajax.reload(null, false);
                    }
                }
            });
        });
    });

    function openEditModal(data = null) {
        $('#formProduct')[0].reset();
        $('#preview_img').hide();
        $('.camera-icon, .upload-hint').show();
        
        if(data) {
            $('#editModalTitle').text('Editar Producto');
            $('#prod_id').val(data.id);
            $('#prod_barcode').val(data.barcode).prop('readonly', true);
            $('#prod_name').val(data.name);
            $('#prod_category').val(data.category_id);
            
            if(data.image_path) {
                const imgUrl = `/api/catalog/image.php?barcode=${data.barcode}&license_key=${licenseKey}`;
                $('#preview_img').attr('src', imgUrl).show();
                $('.camera-icon, .upload-hint').hide();
            }
        } else {
            $('#editModalTitle').text('Nuevo Producto');
            $('#prod_id').val('');
            $('#prod_barcode').prop('readonly', false);
        }
        $('#modalEdit').modal('show');
    }

    function openViewModal(data) {
        $('#view_name').text(data.name);
        $('#view_barcode').text(data.barcode);
        const img = data.image_path ? `/api/catalog/image.php?barcode=${data.barcode}&license_key=${licenseKey}` : 'https://placehold.co/300x300?text=Sin+Imagen';
        $('#view_img').attr('src', img);
        $('#modalView').modal('show');
    }

    function copyEan(text) {
        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({ icon: 'success', title: 'Copiado', toast: true, position: 'top-end', showConfirmButton: false, timer: 1000 });
        });
    }
    </script>
</body>
</html>
