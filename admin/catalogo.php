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
    <title>Catálogo Maestro | CajaYa Premium</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid px-3">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                    <li class="nav-item ms-3"> <span class="fw-bold small opacity-75">SISTEMA DE GESTIÓN DE PRODUCTOS</span> </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="ms-page-header d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="ms-page-title">Catálogo Maestro</h1>
                    <p class="text-muted small mb-0">Base de datos global para el ecosistema de terminales.</p>
                </div>
                <button class="btn btn-cajaya shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalAddProduct">
                    <i class="fa-solid fa-plus me-2"></i> NUEVO PRODUCTO
                </button>
            </div>

            <div class="app-content px-5">
                <div class="container-fluid">
                    <div class="card card-ms mb-4 p-4 border-0 shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted mb-2 text-uppercase">Filtrar Categoría</label>
                                <select id="categoryFilter" class="form-select">
                                    <option value="">Todas las categorías</option>
                                    <!-- Aquí irían los nombres de categorías reales si hubiera una tabla de relación, por ahora se filtra por ID o se deja dinámico -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card card-ms border-0 shadow-sm">
                        <div class="table-responsive">
                            <table id="catalogTable" class="table ms-table w-100">
                                <thead>
                                    <tr>
                                        <th>IMG</th>
                                        <th>CÓDIGO / BARCODE</th>
                                        <th>ARTÍCULO / PRODUCTO</th>
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
                    render: (d) => `<img src="${d || 'img/no-image.png'}" class="rounded-2 border" style="width:36px; height:36px; object-fit:cover;">` 
                },
                { data: 'barcode', className: 'fw-bold text-primary small' }, // Corregido: barcode en lugar de ean
                { data: 'name', className: 'fw-medium' }, // Corregido: name en lugar de description
                { 
                    data: 'is_active', 
                    render: d => d == 1 ? '<span class="badge bg-success bg-opacity-10 text-success small border-0">ACTIVO</span>' : '<span class="badge bg-danger bg-opacity-10 text-danger small">INACTIVO</span>' 
                },
                { 
                    data: null, 
                    className: 'text-end',
                    render: (d, t, r) => `
                        <button class="btn btn-link text-primary p-1"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-link text-danger p-1"><i class="fa-solid fa-trash"></i></button>`
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-4 d-flex justify-content-between align-items-center"lf>rt<"p-4 d-flex justify-content-between align-items-center"ip>'
        });
    });
    </script>
</body>
</html>
