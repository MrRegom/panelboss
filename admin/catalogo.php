<?php
require_once __DIR__ . '/includes/bootstrap.php';
use App\Services\AuthService;
use App\Config\Database;

AuthService::check();

$db = Database::getConnection();
$categories = $db->query("SELECT DISTINCT category FROM master_catalog ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo Maestro | CajaYa Premium</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid px-4">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link text-white" data-lte-toggle="sidebar" href="#" role="button"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header mb-5">
                <div class="container-fluid px-5">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h2 class="fw-extrabold mb-1">Catálogo Maestro</h2>
                            <p class="text-muted small mb-0">Gestión global de productos para el ecosistema CajaYa.</p>
                        </div>
                        <div class="col-md-5 text-md-end mt-4 mt-md-0">
                            <button class="btn btn-premium-gold" data-bs-toggle="modal" data-bs-target="#modalAddProduct">
                                <i class="fa-solid fa-plus me-2"></i> NUEVO PRODUCTO
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid px-5 pb-5">
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <label class="small fw-bold text-muted mb-2 text-uppercase">Filtrar por Categoría</label>
                                <select id="categoryFilter" class="form-select">
                                    <option value="">Todas las categorías</option>
                                    <?php foreach($categories as $cat) echo "<option value='".htmlspecialchars($cat)."'>".htmlspecialchars($cat)."</option>"; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="catalogTable" class="table premium-table w-100">
                            <thead>
                                <tr>
                                    <th>IMG</th>
                                    <th>CÓDIGO EAN</th>
                                    <th>ARTÍCULO / DESCRIPCIÓN</th>
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
                    render: (d) => `<img src="${d || 'img/no-image.png'}" class="rounded-3" style="width:40px; height:40px; object-fit:cover; border:1px solid #eee;">` 
                },
                { data: 'ean', render: d => `<span class="fw-bold">${d}</span>` },
                { data: 'description', className: 'fw-medium' },
                { data: 'category', render: d => `<span class="badge-premium badge-demo">${d}</span>` },
                { 
                    data: null, 
                    className: 'text-end',
                    render: (d, t, r) => `
                        <div class="btn-group">
                            <button class="btn btn-light btn-sm border me-1"><i class="fa-solid fa-pen text-primary"></i></button>
                            <button class="btn btn-light btn-sm border"><i class="fa-solid fa-trash text-danger"></i></button>
                        </div>`
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
            dom: '<"mb-4 d-flex justify-content-between"lf>rt<"mt-4 d-flex justify-content-between"ip>'
        });

        $('#categoryFilter').on('change', function() {
            table.column(3).search($(this).val()).draw();
        });
    });
    </script>
</body>
</html>
