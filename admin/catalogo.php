<?php
/**
 * admin/catalogo.php — Gestión Enterprise del Catálogo Maestro (Estilo Master-Detail)
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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=JetBrains+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    
    <style>
        :root { 
            --accent: #0071E3; 
            --bg-main: #0c0e12; 
            --bg-card: #151921; 
            --text-muted: #8b949e;
        }
        body { font-family: 'Outfit', sans-serif; background: var(--bg-main); color: #e6edf3; }
        
        /* DataTable Style (Hospital Style Reference) */
        .dataTables_wrapper .dataTables_filter input { 
            background: #1a1f29; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff; padding: 8px 15px;
        }
        .table thead th { 
            background: #1a1f29; color: #fff; text-transform: uppercase; font-size: 11px; 
            letter-spacing: 1px; padding: 15px; border-bottom: 2px solid var(--accent); 
        }
        .table tbody tr { background: transparent; transition: 0.2s; border-bottom: 1px solid rgba(255,255,255,0.03); }
        .table tbody tr:hover { background: rgba(0, 113, 227, 0.05); }
        .table td { padding: 15px !important; vertical-align: middle; }

        /* Row Elements */
        .product-thumb { width: 45px; height: 45px; object-fit: contain; background: #fff; border-radius: 8px; padding: 4px; }
        .ean-badge { 
            font-family: 'JetBrains Mono', monospace; font-size: 11px; color: var(--accent); 
            background: rgba(0, 113, 227, 0.1); padding: 3px 8px; border-radius: 5px; cursor: copy;
        }
        .ean-badge:hover { background: var(--accent); color: #fff; }

        /* Modal Enterprise Split-View */
        .modal-xl { max-width: 950px; }
        .modal-content { 
            background: #fff !important; color: #333 !important; border-radius: 12px; overflow: hidden; 
            box-shadow: 0 30px 60px rgba(0,0,0,0.5);
        }
        .modal-header { background: #1a1f29; border: none; padding: 15px 25px; }
        .modal-header .modal-title { font-size: 18px; color: #fff; font-weight: 600; }
        
        .detail-sidebar { background: #f8f9fa; border-right: 1px solid #eee; padding: 30px; text-align: center; }
        .detail-main { padding: 30px 40px; }
        
        .section-title { 
            color: var(--accent); font-size: 13px; font-weight: 700; text-transform: uppercase; 
            margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 8px; display: flex; align-items: center; gap: 10px;
        }
        .info-label { color: #888; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 2px; }
        .info-value { color: #222; font-size: 15px; font-weight: 500; margin-bottom: 20px; }
        
        .status-badge-lg { 
            background: #e6f4ea; color: #1e7e34; padding: 8px 20px; border-radius: 8px; 
            font-size: 12px; font-weight: 700; display: inline-block; margin-top: 15px;
        }

        .btn-action { 
            width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; 
            border-radius: 6px; border: 1px solid #eee; background: #fff; color: #555; transition: 0.2s;
        }
        .btn-action:hover { background: var(--accent); color: #fff; border-color: var(--accent); }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand border-bottom border-white border-opacity-10">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#"> <i class="fa-solid fa-bars-staggered text-white"></i> </a> </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main p-4">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-0">Catálogo Maestro</h2>
                        <p class="text-muted small">Gestión técnica de inventario global</p>
                    </div>
                    <button class="btn btn-primary px-4 fw-bold shadow-sm" onclick="openEditModal()" style="border-radius: 8px;">
                        <i class="fa-solid fa-plus me-2"></i>NUEVO PRODUCTO
                    </button>
                </div>

                <div class="card bg-dark border-0 shadow-sm">
                    <div class="card-body p-0">
                        <table id="catalogTable" class="table table-hover align-middle w-100">
                            <thead>
                                <tr>
                                    <th style="width: 50px">#</th>
                                    <th>ARTÍCULO / MODELO</th>
                                    <th>CATEGORÍA</th>
                                    <th>MARCA</th>
                                    <th class="text-end">ACCIONES</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal: Detalles y Edición (Style: Hospital System) -->
    <div class="modal fade" id="modalDetail" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-box-open me-2"></i>Detalles del Producto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <!-- Sidebar Izquierdo: Visual -->
                        <div class="col-md-4 detail-sidebar">
                            <div class="bg-white p-3 rounded-4 shadow-sm mb-4 d-inline-block">
                                <img src="" id="det_img" style="max-width: 200px; max-height: 200px; object-fit: contain;">
                            </div>
                            <h4 class="fw-bold mb-1" id="det_name_title">Nombre</h4>
                            <div id="det_ean_badge" class="ean-badge mb-3">000000000000</div>
                            <br>
                            <div class="status-badge-lg">
                                <i class="fa-solid fa-check-circle me-1"></i> ESTADO DEL ACTIVO: FUNCIONAL
                            </div>
                        </div>
                        
                        <!-- Main: Información Técnica -->
                        <div class="col-md-8 detail-main">
                            <form id="formProduct">
                                <input type="hidden" name="id" id="prod_id">
                                
                                <div class="section-title">
                                    <i class="fa-solid fa-tags"></i> CLASIFICACIÓN Y ORIGEN
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="info-label">Categoría / Pasillo</div>
                                        <select class="form-select border-0 bg-light" name="category_id" id="prod_category">
                                            <option value="">Sin Categoría</option>
                                            <?php foreach($categories as $cat): ?>
                                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">PMA / Identificador EAN</div>
                                        <input type="text" class="form-control border-0 bg-light fw-bold" name="barcode" id="prod_barcode" required>
                                    </div>
                                </div>

                                <div class="section-title">
                                    <i class="fa-solid fa-microchip"></i> ESPECIFICACIONES TÉCNICAS
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="info-label">Marca / Fabricante</div>
                                        <input type="text" class="form-control border-0 bg-light" name="brand" id="prod_brand" placeholder="Ej: Lenovo">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">Nombre del Modelo</div>
                                        <input type="text" class="form-control border-0 bg-light" name="name" id="prod_name" required>
                                    </div>
                                </div>

                                <div class="section-title">
                                    <i class="fa-solid fa-clipboard-list"></i> OBSERVACIONES ADICIONALES
                                </div>
                                <div class="bg-info bg-opacity-10 p-3 rounded-3 mb-4">
                                    <textarea class="form-control border-0 bg-transparent p-0" name="description" id="prod_description" rows="3" placeholder="Sin observaciones registradas..."></textarea>
                                </div>
                                
                                <div class="text-end mt-4">
                                    <button type="button" class="btn btn-secondary px-4 me-2" data-bs-dismiss="modal" style="border-radius: 8px;">Cerrar</button>
                                    <button type="submit" class="btn btn-primary px-5 shadow" style="border-radius: 8px; background: var(--accent);">GUARDAR CAMBIOS</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-2 px-4 justify-content-between">
                    <small class="text-muted">Última modificación detectada: <?= date('Y-m-d H:i:s') ?></small>
                    <small class="text-muted">Por: <strong>Admin CajaYa</strong></small>
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

    $(document).ready(function() {
        table = $('#catalogTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'api/get_master_catalog.php',
            pageLength: 50,
            ordering: false,
            columns: [
                { 
                    data: null, 
                    render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1,
                    className: 'text-muted small fw-bold'
                },
                { 
                    data: 'name',
                    render: function(data, type, row) {
                        const img = row.image_path ? `/api/catalog/image.php?barcode=${row.barcode}&license_key=${licenseKey}` : 'https://placehold.co/100x100?text=📦';
                        return `
                            <div class="d-flex align-items-center gap-3">
                                <img src="${img}" class="product-thumb">
                                <div>
                                    <div class="fw-bold text-white fs-6">${data}</div>
                                    <div class="text-muted small">${row.brand || 'Genérico'}</div>
                                </div>
                            </div>
                        `;
                    }
                },
                { data: 'category_name', render: (data) => `<div class="fw-bold text-white text-uppercase small">${data || 'Sin Categoría'}</div>` },
                { 
                    data: 'barcode', 
                    render: (data) => `<span class="ean-badge" onclick="copyToClipboard('${data}')">${data}</span>` 
                },
                { 
                    data: null, 
                    className: 'text-end',
                    render: function(data, type, row) {
                        return `
                            <button class="btn-action" onclick='openEditModal(${JSON.stringify(row)})'>
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        `;
                    }
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-3"<"row align-items-center"<"col-sm-6"l><"col-sm-6 text-end"f>>>rt<"p-3"<"row align-items-center"<"col-sm-6"i><"col-sm-6 text-end"p>>>'
        });

        $('#formProduct').on('submit', function(e) {
            e.preventDefault();
            $.post('api/save_product.php', $(this).serialize(), function(res) {
                if(res.success) {
                    Swal.fire({ icon: 'success', title: 'Actualizado', toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
                    $('#modalDetail').modal('hide');
                    table.ajax.reload(null, false);
                }
            }, 'json');
        });
    });

    function openEditModal(data = null) {
        $('#formProduct')[0].reset();
        if(data) {
            $('#modalTitle').text('Ficha Técnica del Producto');
            $('#prod_id').val(data.id);
            $('#prod_barcode').val(data.barcode).prop('readonly', true);
            $('#prod_name').val(data.name);
            $('#prod_brand').val(data.brand);
            $('#prod_category').val(data.category_id);
            $('#prod_description').val(data.description);
            
            // Visuals
            $('#det_name_title').text(data.name);
            $('#det_ean_badge').text(data.barcode);
            const img = data.image_path ? `/api/catalog/image.php?barcode=${data.barcode}&license_key=${licenseKey}` : 'https://placehold.co/300x300?text=📦';
            $('#det_img').attr('src', img);
        } else {
            $('#modalTitle').text('Nuevo Registro Maestro');
            $('#prod_id').val('');
            $('#prod_barcode').prop('readonly', false);
            $('#det_name_title').text('Nuevo Producto');
            $('#det_ean_badge').text('000000000000');
            $('#det_img').attr('src', 'https://placehold.co/300x300?text=📦');
        }
        $('#modalDetail').modal('show');
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({ icon: 'success', title: 'Copiado: ' + text, toast: true, position: 'top-end', showConfirmButton: false, timer: 1500 });
        });
    }
    </script>
</body>
</html>
