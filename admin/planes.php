<?php
/**
 * admin/planes.php — Gestión de Precios (INTEGRADO EN PANEL)
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
        $message = "Precio actualizado con éxito.";
    }
}

$plansRaw = $planRepo->getAll();
$plans = array_filter($plansRaw, function($p) {
    return in_array($p['slug'], ['mensual', 'lifetime', 'empresa']);
});
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Planes | PanelBoss PRO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
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
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-user-tie text-white small"></i>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header py-4">
                <div class="container-fluid px-4">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h3 class="fw-semibold mb-0">Configuración Comercial</h3>
                            <p class="text-muted small">Gestión de precios y planes de suscripción</p>
                        </div>
                    </div>
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
                            <div class="card shadow-sm border-0 h-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05) !important;">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3">
                                            <i class="fa-solid fa-tags"></i>
                                        </div>
                                        <span class="badge bg-dark border border-secondary text-muted"><?= strtoupper($plan['slug']) ?></span>
                                    </div>
                                    <h5 class="fw-bold mb-1"><?= htmlspecialchars($plan['name']) ?></h5>
                                    <p class="text-muted small mb-4"><?= htmlspecialchars($plan['description'] ?? 'Plan estándar de servicio CajaYa.') ?></p>
                                    
                                    <form method="POST">
                                        <input type="hidden" name="slug" value="<?= $plan['slug'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted">PRECIO ACTUAL (CLP)</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-dark border-secondary text-muted">$</span>
                                                <input type="number" name="price" class="form-control bg-dark border-secondary fw-bold text-white" value="<?= (int)$plan['price'] ?>" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                            <i class="fa-solid fa-save me-2"></i> Actualizar Precio
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-5 p-4 rounded-4" style="background: rgba(255,159,10, 0.05); border: 1px dashed rgba(255,159,10, 0.2);">
                        <h6 class="text-warning fw-bold mb-2"><i class="fa-solid fa-triangle-exclamation me-2"></i> Zona de Pruebas</h6>
                        <p class="text-muted small mb-0">
                            Para realizar validaciones de pago sin gastar dinero real, baja el precio del plan <strong>lifetime</strong> a 100. 
                            Una vez terminada la prueba, asegúrate de volver a subirlo a su precio comercial para evitar pérdidas.
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
