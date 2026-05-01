<?php
/**
 * admin/catalogo.php — Gestión Avanzada con Carga de Imágenes (Versión PRO V102)
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo | CajaYa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
    
    <style>
        .img-mini { width: 40px; height: 40px; object-fit: contain; background: #fff; border: 1px solid var(--border-color); border-radius: 8px; padding: 4px; cursor: pointer; transition: 0.2s; }
        .img-mini:hover { transform: scale(1.1); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .ean-tech { font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: var(--primary-purple); cursor: pointer; background: var(--primary-soft); padding: 4px 8px; border-radius: 6px; font-weight: 600; }
        
        .btn-action { 
            padding: 6px; font-size: 14px; border-radius: 8px; border: 1px solid var(--border-color);
            background: #fff; color: var(--text-muted); cursor: pointer; margin-left: 4px; transition: 0.2s;
        }
        .btn-action:hover { color: var(--primary-purple); border-color: var(--primary-purple); background: var(--primary-soft); }

        /* Photo Area */
        .photo-upload-container {
            width: 100%; height: 180px; border: 2px dashed var(--border-color); border-radius: 12px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            cursor: pointer; position: relative; overflow: hidden; background: #f8fafc;
            transition: 0.2s;
        }
        .photo-upload-container:hover { border-color: var(--primary-purple); background: var(--primary-soft); }
        .photo-upload-container img { max-height: 100%; object-fit: contain; z-index: 1; }
        .photo-upload-container .upload-hint { position: absolute; bottom: 15px; font-size: 0.7rem; color: var(--text-muted); z-index: 2; font-weight: 600; }
        .photo-upload-container .camera-icon { color: var(--border-color); font-size: 32px; position: absolute; z-index: 0; }

        .epic-photo-view { max-width: 100%; max-height: 400px; object-fit: contain; background: #fff; border-radius: 16px; padding: 15px; margin-bottom: 25px; box-shadow: 0 20px 50px rgba(0,0,0,0.15); }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid px-4">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header py-4">
                <div class="container-fluid px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="fw-bold mb-0">Catálogo Maestro</h3>
                            <p class="text-muted small">Gestión global de productos para el ecosistema CajaYa</p>
                        </div>
                        <button class="btn btn-primary" onclick="openEditModal()">
                            <i class="fa-solid fa-plus me-2"></i> NUEVO PRODUCTO
                        </button>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid px-4">
                    <div class="card p-4 mb-4">
                        <div class="row align-items-end g-3">
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted mb-2">FILTRAR POR CATEGORÍA</label>
                                <select id="filterCategory" class="form-select">
                                    <option value="">Todas las categorías</option>
                                    <?php foreach($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="catalogTable" class="table align-middle w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 60px">IMG</th>
                                            <th style="width: 150px">CÓDIGO EAN</th>
                                            <th>ARTÍCULO / DESCRIPCIÓN</th>
                                            <th>CATEGORÍA</th>
                                            <th class="text-end" style="width: 120px">ACCIONES</th>
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

    <!-- Modal Form (Crear/Editar) -->
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Ficha de Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formProduct" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="prod_id">
                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-12 text-center">
                                <div class="photo-upload-container mx-auto" onclick="$('#prod_image').click()">
                                    <i class="fa-solid fa-cloud-arrow-up camera-icon"></i>
                                    <img src="" id="preview_img" style="display:none">
                                    <div class="upload-hint">Sube una imagen profesional (PNG/JPG)</div>
                                </div>
                                <input type="file" name="image" id="prod_image" class="d-none" accept="image/*">
                            </div>
                            
                            <div class="col-12">
                                <label>CÓDIGO DE BARRAS (EAN)</label>
                                <input type="text" class="form-control" name="barcode" id="prod_barcode" required placeholder="Escanee o escriba el código">
                            </div>
                            <div class="col-12">
                                <label>DESCRIPCIÓN DEL PRODUCTO</label>
                                <input type="text" class="form-control" name="name" id="prod_name" required placeholder="Ej: Coca Cola 2.5L">
                            </div>
                            <div class="col-12">
                                <label>CATEGORÍA DEL MAESTRO</label>
                                <select class="form-select" name="category_id" id="prod_category">
                                    <option value="">- Seleccionar Categoría -</option>
                                    <?php foreach($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100 py-3">
                            <i class="fa-solid fa-save me-2"></i> GUARDAR EN EL CATÁLOGO
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal View (Épico) -->
    <div class="modal fade" id="modalView" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-body p-5 text-center">
                    <h4 id="view_name" class="fw-bold text-dark mb-4">Nombre</h4>
                    <img src="" id="view_img" class="epic-photo-view">
                    <div id="view_barcode" class="ean-tech d-inline-block px-5 py-3 fs-5">000000000000</div>
                    <div class="mt-5">
                        <button class="btn btn-light px-5 py-2 fw-bold" data-bs-dismiss="modal">Cerrar</button>
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
                        const img = data ? `/api/catalog/image.php?barcode=${row.barcode}&license_key=${licenseKey}` : 'https://placehold.co/80x80?text=📦';
                        return `<img src="${img}" class="img-mini" onclick='openViewModal(${JSON.stringify(row).replace(/'/g, "&apos;")})'>`;
                    }
                },
                { data: 'barcode', render: (d) => `<span class="ean-tech" onclick="copyEan('${d}')">${d}</span>` },
                { data: 'name', render: (d) => `<span class="text-dark fw-bold">${d}</span>` },
                { data: 'category_name', render: (d) => `<span class="badge bg-light text-muted border">${d || '-'}</span>` },
                { 
                    data: null, 
                    className: 'text-end',
                    render: function(data, type, row) {
                        const rowData = JSON.stringify(row).replace(/'/g, "&apos;");
                        return `
                            <button class="btn-action" onclick='openViewModal(${rowData})' title="Ver Detalle"><i class="fa-solid fa-eye text-primary"></i></button>
                            <button class="btn-action" onclick='openEditModal(${rowData})' title="Editar"><i class="fa-solid fa-pen"></i></button>
                        `;
                    }
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-3 d-flex justify-content-between align-items-center"lf>rt<"p-3 d-flex justify-content-between align-items-center"ip>'
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
        const img = data.image_path ? `/api/catalog/image.php?barcode=${data.barcode}&license_key=${licenseKey}` : 'https://placehold.co/400x400?text=Sin+Imagen';
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
