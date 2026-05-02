<?php
require_once __DIR__ . '/includes/bootstrap.php';
use App\Services\AuthService;
use App\Config\Database;

AuthService::check();

try {
    $db = Database::getConnection();
    // La tabla correcta es master_products
    $categories = $db->query("SELECT DISTINCT category_id FROM master_products ORDER BY category_id")->fetchAll(PDO::FETCH_COLUMN);
} catch (Exception $e) {
    $categories = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo Maestro | CajaYa Silk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
                            <h3 class="fw-bold mb-0">Catálogo Maestro</h3>
                            <p class="text-muted small mb-0">Gestión de productos globales para el ecosistema CajaYa.</p>
                        </div>
                        <div class="col-sm-6 text-end">
                            <button class="btn btn-silk shadow-sm px-4" onclick="openEditModal()">
                                <i class="fa-solid fa-plus me-2"></i> Nuevo Artículo
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content px-4">
                <div class="container-fluid">
                    <div class="card card-silk border-0 shadow-sm">
                        <div class="table-responsive">
                            <table id="catalogTable" class="table silk-table w-100">
                                <thead>
                                    <tr>
                                        <th>VISTA PREVIA</th>
                                        <th>CÓDIGO BARRA</th>
                                        <th>ARTÍCULO / PRODUCTO</th>
                                        <th>MARCA</th>
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

    <!-- Modal Edit/New Product -->
    <div class="modal fade" id="modalEditProduct" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="editModalTitle">Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formProduct" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="prod_id">
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <img src="https://placehold.co/120x120?text=Subir+Foto" id="preview_img" class="rounded shadow-sm" style="width:120px; height:120px; object-fit: cover; cursor:pointer;" onclick="$('#prod_image').click()">
                                <div class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-1" style="width:30px; height:30px; cursor:pointer;" onclick="$('#prod_image').click()">
                                    <i class="fa-solid fa-camera"></i>
                                </div>
                            </div>
                            <input type="file" name="image" id="prod_image" class="d-none" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted fw-bold mb-1">CÓDIGO EAN</label>
                            <input type="text" class="form-control" name="barcode" id="prod_barcode" required placeholder="Ej: 780000000000">
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted fw-bold mb-1">NOMBRE DEL PRODUCTO</label>
                            <input type="text" class="form-control" name="name" id="prod_name" required placeholder="Ej: Coca Cola 3L">
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted fw-bold mb-1">MARCA</label>
                            <input type="text" class="form-control" name="brand" id="prod_brand" placeholder="Ej: CCU">
                        </div>
                        <div class="mb-0">
                            <label class="small text-muted fw-bold mb-1">ID CATEGORÍA (OPCIONAL)</label>
                            <input type="number" class="form-control" name="category_id" id="prod_category" placeholder="ID de categoría">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">GUARDAR CAMBIOS</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal View (Foto y Datos) -->
    <div class="modal fade" id="modalView" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <img src="" id="view_img" class="img-fluid rounded shadow-sm mb-3" style="max-height: 250px; object-fit: contain;">
                    <h5 id="view_name" class="fw-bold text-dark mb-1">Nombre del Producto</h5>
                    <div id="view_barcode" class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mt-2" style="font-family: monospace; font-size: 1rem;">000000000000</div>
                    <div class="mt-4">
                        <button class="btn btn-secondary px-4" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
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

    function openViewModal(barcode, name) {
        $('#view_name').text(name);
        $('#view_barcode').text(barcode);
        let src = barcode ? `img-proxy.php?b=${barcode}` : 'https://placehold.co/300x300?text=S/I';
        $('#view_img').attr('src', src);
        $('#modalView').modal('show');
    }

    function openEditModal(data = null) {
        $('#formProduct')[0].reset();
        if(data) {
            $('#editModalTitle').text('Editar Producto');
            $('#prod_id').val(data.id);
            $('#prod_barcode').val(data.barcode).prop('readonly', true);
            $('#prod_name').val(data.name);
            $('#prod_brand').val(data.brand);
            $('#prod_category').val(data.category_id);
            let src = data.barcode ? `img-proxy.php?b=${data.barcode}` : 'https://placehold.co/120x120?text=Subir+Foto';
            $('#preview_img').attr('src', src);
        } else {
            $('#editModalTitle').text('Nuevo Artículo');
            $('#prod_id').val('');
            $('#prod_barcode').prop('readonly', false);
            $('#preview_img').attr('src', 'https://placehold.co/120x120?text=Subir+Foto');
        }
        $('#modalEditProduct').modal('show');
    }

    function deleteProduct(id, name) {
        Swal.fire({
            title: '¿Eliminar producto?',
            text: `Vas a eliminar "${name}". Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7c3aed',
            cancelButtonColor: '#6c757d',
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

    $(document).ready(function() {
        table = $('#catalogTable').DataTable({
            ajax: 'api/get_master_catalog.php',
            columns: [
                { 
                    data: 'image_path', 
                    render: (d, type, row) => {
                        let barcode = row.barcode;
                        let name = row.name ? row.name.replace(/'/g, "\\'") : '';
                        let src = barcode ? `img-proxy.php?b=${barcode}` : '';
                        return `<img src="${src}" class="img-catalog-silk" style="cursor: pointer;" onclick="openViewModal('${barcode}', '${name}')" onerror="this.src='https://placehold.co/100x100?text=S/I'">`;
                    }
                },
                { data: 'barcode', className: 'fw-bold text-primary small' },
                { data: 'name', className: 'fw-semibold text-dark' },
                { data: 'brand', className: 'small text-muted' },
                { 
                    data: 'is_active', 
                    render: d => d == 1 ? '<span class="badge bg-success bg-opacity-10 text-success px-3 py-2 border-0 rounded-pill small">ACTIVO</span>' : '<span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill small">INACTIVO</span>' 
                },
                { 
                    data: null, 
                    className: 'text-end',
                    render: (d, type, row) => {
                        let barcode = row.barcode;
                        let name = row.name ? row.name.replace(/'/g, "\\'") : '';
                        let rowData = JSON.stringify(row).replace(/"/g, '&quot;');
                        return `
                        <button class="btn btn-link text-primary p-2" onclick="openViewModal('${barcode}', '${name}')"><i class="fa-solid fa-eye"></i></button>
                        <button class="btn btn-link text-secondary p-2" onclick='openEditModal(${rowData})'><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-link text-danger p-2" onclick="deleteProduct(${row.id}, '${name}')"><i class="fa-solid fa-trash"></i></button>
                        `;
                    }
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-4 d-flex justify-content-between align-items-center"lf>rt<"p-4 d-flex justify-content-between align-items-center"ip>'
        });

        // Preview Image
        $('#prod_image').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) { $('#preview_img').attr('src', e.target.result); }
                reader.readAsDataURL(file);
            }
        });

        // Form Submit
        $('#formProduct').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: 'api/save_product.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res) {
                    if(res.success) {
                        Swal.fire({ icon: 'success', title: 'Éxito', text: res.message, timer: 2000, showConfirmButton: false });
                        $('#modalEditProduct').modal('hide');
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                }
            });
        });
    });
    </script>
</body>
</html>
