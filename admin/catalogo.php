<?php
require_once __DIR__ . '/includes/bootstrap.php';
use App\Services\AuthService;
use App\Config\Database;

AuthService::check();

try {
    $db = Database::getConnection();
    // Corregido: La tabla correcta es master_products
    $categories = $db->query("SELECT DISTINCT category FROM master_products ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
} catch (Exception $e) {
    $categories = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo Maestro | Azure Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
</head>
<body class="layout-fixed sidebar-expand-lg bg-light">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid px-3">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="fa-solid fa-bars"></i> </a> </li>
                    <li class="nav-item ms-3"> <span class="text-white fw-semibold small">CajaYa | Catálogo Maestro</span> </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="ms-page-header d-flex justify-content-between align-items-center">
                <h1 class="ms-page-title">Catálogo Maestro</h1>
                <button class="btn btn-ms-primary" data-bs-toggle="modal" data-bs-target="#modalAddProduct">
                    <i class="fa-solid fa-plus me-2"></i> Nuevo Producto
                </button>
            </div>

            <div class="app-content px-4">
                <div class="container-fluid">
                    <div class="card card-ms mb-4 p-3">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted mb-1">FILTRAR CATEGORÍA</label>
                                <select id="categoryFilter" class="form-select form-select-sm">
                                    <option value="">Todas</option>
                                    <?php foreach($categories as $cat) echo "<option value='".htmlspecialchars($cat)."'>".htmlspecialchars($cat)."</option>"; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card card-ms">
                        <div class="table-responsive">
                            <table id="catalogTable" class="table ms-table w-100">
                                <thead>
                                    <tr>
                                        <th>IMG</th>
                                        <th>EAN</th>
                                        <th>DESCRIPCIÓN</th>
                                        <th>CATEGORÍA</th>
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
                    render: (d) => `<img src="${d || 'img/no-image.png'}" class="border" style="width:32px; height:32px; object-fit:cover;">` 
                },
                { data: 'ean', className: 'small fw-semibold' },
                { data: 'description', className: 'small' },
                { data: 'category', render: d => `<span class="badge bg-light text-dark border small">${d}</span>` },
                { 
                    data: null, 
                    className: 'text-end',
                    render: (d, t, r) => `
                        <button class="btn btn-link btn-sm text-primary p-0 me-2"><i class="fa-solid fa-edit"></i></button>
                        <button class="btn btn-link btn-sm text-danger p-0"><i class="fa-solid fa-trash"></i></button>`
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"p-3 d-flex justify-content-between align-items-center"lf>rt<"p-3 d-flex justify-content-between align-items-center"ip>'
        });

        $('#categoryFilter').on('change', function() {
            table.column(3).search($(this).val()).draw();
        });
    });
    </script>
</body>
</html>
