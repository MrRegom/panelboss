<?php
/**
 * admin/planes.php — Gestión de Precios (VERSION DEFINITIVA 3 PLANES)
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/Database.php';
require_once __DIR__ . '/../src/Repositories/PlanRepository.php';

use App\Repositories\PlanRepository;
use App\Services\AuthService;

AuthService::check();

$planRepo = new PlanRepository();
$message = "";

// Procesar actualización de precio
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['slug'], $_POST['price'])) {
    $slug = $_POST['slug'];
    $price = (float)$_POST['price'];
    if ($planRepo->updatePrice($slug, $price)) {
        $message = "Precio del plan " . strtoupper($slug) . " actualizado con éxito.";
    }
}

// Obtener solo los 3 planes comerciales
$plansRaw = $planRepo->getAll();
$plans = array_filter($plansRaw, function($p) {
    return in_array($p['slug'], ['mensual', 'lifetime', 'empresa']);
});

// Ordenar para que siempre salgan en el mismo orden
usort($plans, function($a, $b) {
    $order = ['mensual' => 1, 'lifetime' => 2, 'empresa' => 3];
    return ($order[$a['slug']] ?? 9) - ($order[$b['slug']] ?? 9);
});
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Planes | PanelBoss PRO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .card-plan { 
            background: rgba(255,255,255,0.03); 
            border: 1px solid rgba(255,255,255,0.05) !important; 
            transition: all 0.3s ease;
        }
        .card-plan:hover { border-color: #0071E3 !important; transform: translateY(-5px); }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid px-4">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown user-menu"> 
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"> 
                            <span class="d-none d-md-inline fw-semibold me-2"><?= $_SESSION['user_name'] ?? 'Admin' ?></span>
                            <i class="fa-solid fa-circle-user fs-4"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header py-4">
                <div class="container-fluid px-4">
                    <h3 class="fw-bold mb-0">Gestión Comercial</h3>
                    <p class="text-muted small">Configuración de los 3 planes principales de la landing page.</p>
                </div>
            </div>
            
            <div class="app-content">
                <div class="container-fluid px-4">
                    
                    <?php if ($message): ?>
                        <div class="alert alert-success border-0 shadow-sm mb-4">
                            <i class="fa-solid fa-circle-check me-2"></i> <?= $message ?>
                        </div>
                    <?php endif; ?>

                    <div class="row g-4">
                        <?php foreach ($plans as $plan): ?>
                        <div class="col-md-4">
                            <div class="card card-plan shadow-sm h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3">
                                            <i class="fa-solid fa-gem"></i>
                                        </div>
                                        <span class="badge bg-dark border border-secondary"><?= strtoupper($plan['slug']) ?></span>
                                    </div>
                                    <h5 class="fw-bold"><?= htmlspecialchars($plan['name']) ?></h5>
                                    <p class="text-muted small mb-4">Gestión de precio para el despliegue dinámico en CajaYa.cl</p>
                                    
                                    <form method="POST">
                                        <input type="hidden" name="slug" value="<?= $plan['slug'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted">PRECIO ACTUAL (CLP)</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-dark border-secondary text-muted">$</span>
                                                <input type="number" name="price" class="form-control bg-dark border-secondary fw-bold text-white" value="<?= (int)$plan['price'] ?>" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                                            <i class="fa-solid fa-rotate me-2"></i> Actualizar Precio
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-5 p-4 rounded-4 bg-warning bg-opacity-10 border border-warning border-opacity-25">
                        <h6 class="text-warning fw-bold mb-2"><i class="fa-solid fa-shield-halved me-2"></i> Modo Operaciones</h6>
                        <p class="text-muted small mb-0">
                            Recuerda que para pruebas de integración, puedes bajar el precio del plan <strong>Lifetime</strong> a 100. 
                            No olvides restaurarlo a su valor comercial (180.000) antes del lanzamiento oficial.
                        </p>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/js/adminlte.min.js"></script>
</body>
</html>
