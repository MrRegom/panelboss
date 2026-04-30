<?php
/**
 * admin/catalogo.php — Visor de Catálogo Maestro CajaYa
 */

// MODO DEBUG TEMPORAL PARA IDENTIFICAR ERROR 500
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/Database.php';
require_once __DIR__ . '/../src/Repositories/MasterProductRepository.php';

use App\Services\AuthService;
use App\Repositories\MasterProductRepository;

AuthService::check();

$repo = new MasterProductRepository();
$search = $_GET['search'] ?? '';
$page = (int)($_GET['page'] ?? 1);
$limit = 20;
$offset = ($page - 1) * $limit;

$products = $repo->list($limit, $offset, $search);

// Obtenemos una licencia activa para previsualizar las fotos en el panel
$db = Database::getConnection();
$stmtLic = $db->query("SELECT license_key FROM licenses WHERE status = 'active' LIMIT 1");
$licenseKey = $stmtLic->fetchColumn() ?: 'MASTER-KEY';
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Catálogo Maestro | CajaYa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #0c0e11; }
        .product-card { 
            background: #1a1e23; 
            border: 1px solid rgba(255,255,255,0.05); 
            border-radius: 15px; 
            overflow: hidden;
            transition: 0.3s;
        }
        .product-card:hover { transform: translateY(-5px); border-color: #0071E3; }
        .img-container { height: 150px; background: #252a31; display: flex; align-items: center; justify-content: center; position: relative; }
        .img-container img { max-height: 100%; max-width: 100%; object-fit: contain; }
        .ean-badge { position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.7); font-size: 10px; padding: 4px 8px; border-radius: 5px; }
        .search-box { background: #1a1e23; border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; color: #fff; padding: 12px 20px; width: 100%; }
        .btn-action { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; font-size: 14px; margin-left: 5px; }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-dark">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#"> <i class="fa-solid fa-bars"></i> </a> </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main p-4">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <h2 class="fw-bold mb-1">Catálogo Maestro</h2>
                        <p class="text-muted mb-0">Gestión global de productos e imágenes optimizadas.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="/import_catalog.php" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-file-import me-2"></i>Sincronizar CSV</a>
                        <button class="btn btn-primary btn-sm"><i class="fa-solid fa-plus me-2"></i>Nuevo Producto</button>
                    </div>
                </div>

                <!-- Buscador -->
                <div class="mb-4">
                    <form method="GET">
                        <div class="position-relative">
                            <input type="text" name="search" class="search-box" placeholder="Buscar por EAN, Nombre o Marca..." value="<?= htmlspecialchars($search) ?>">
                            <button type="submit" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-white">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="row g-4">
                    <?php if (empty($products)): ?>
                        <div class="col-12 text-center py-5">
                            <i class="fa-solid fa-box-open fa-3x mb-3 opacity-20"></i>
                            <p class="text-muted">No se encontraron productos. Ejecuta la sincronización para empezar.</p>
                        </div>
                    <?php endif; ?>

                    <?php foreach ($products as $p): ?>
                    <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                        <div class="product-card">
                            <div class="img-container">
                                <?php if ($p['image_path']): ?>
                                    <img src="/api/catalog/image.php?barcode=<?= $p['barcode'] ?>&license_key=<?= $licenseKey ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                                <?php else: ?>
                                    <i class="fa-solid fa-image fa-2x opacity-10"></i>
                                <?php endif; ?>
                                <div class="ean-badge"><?= $p['barcode'] ?></div>
                            </div>
                            <div class="p-3">
                                <small class="text-primary fw-bold text-uppercase" style="font-size: 10px;"><?= htmlspecialchars($p['brand'] ?: 'Genérico') ?></small>
                                <h6 class="text-truncate mb-1" title="<?= htmlspecialchars($p['name']) ?>"><?= htmlspecialchars($p['name']) ?></h6>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <small class="text-muted"><?= htmlspecialchars($p['category_name'] ?: 'Sin categoría') ?></small>
                                    <div>
                                        <a href="#" class="btn-action bg-primary bg-opacity-10 text-primary"><i class="fa-solid fa-pen"></i></a>
                                        <a href="#" class="btn-action bg-danger bg-opacity-10 text-danger"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Paginación Simple -->
                <div class="mt-5 d-flex justify-content-center">
                    <nav>
                        <ul class="pagination">
                            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">Anterior</a>
                            </li>
                            <li class="page-item active"><span class="page-link"><?= $page ?></span></li>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/js/adminlte.min.js"></script>
</body>
</html>
