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
                            <button class="btn btn-silk shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalAddProduct">
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
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/js/adminlte.min.js"></script>

    <script>
    $(document).ready(function() {
        const table = $('#catalogTable').DataTable({
            ajax: 'api/get_master_catalog.php',
            columns: [
                { 
                    data: 'image_path', 
                    render: (d, type, row) => {
                        // Las carpetas storage/ e imagenes_productos/ están fuera del
                        // web root de panel.cajaya.cl (nginx apunta a /admin/).
                        // Usamos el proxy PHP para servir las imágenes desde el filesystem.
                        let barcode = row.barcode;
                        let src = barcode ? `img-proxy.php?b=${barcode}` : '';
                        return `<img src="${src}" class="img-catalog-silk" onerror="this.src='https://placehold.co/100x100?text=S/I'">`;
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
                    render: () => `
                        <button class="btn btn-link text-primary p-2"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-link text-danger p-2"><i class="fa-solid fa-trash"></i></button>`
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-4 d-flex justify-content-between align-items-center"lf>rt<"p-4 d-flex justify-content-between align-items-center"ip>'
        });
    });
    </script>
</body>
</html>
