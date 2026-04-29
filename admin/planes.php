<?php
/**
 * admin/planes.php — Gestión de Precios (VERSION FIX 3 PLANES)
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/Database.php';
require_once __DIR__ . '/../src/Repositories/PlanRepository.php';

use App\Repositories\PlanRepository;
use App\Services\AuthService;

AuthService::check();

$planRepo = new PlanRepository();
$message = "";

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['slug'], $_POST['price'])) {
    if ($planRepo->updatePrice($_POST['slug'], (float)$_POST['price'])) {
        $message = "Precio actualizado correctamente.";
    }
}

// Obtener planes directamente
$allPlans = $planRepo->getAll();
$plans = [];
foreach ($allPlans as $p) {
    if (in_array($p['slug'], ['mensual', 'lifetime', 'empresa'])) {
        $plans[] = $p;
    }
}
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Planes | PanelBoss</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #0f1114; }
        .card-plan { background: #1a1d21; border: 1px solid #2d3238; border-radius: 15px; }
        .btn-update { background: #0071E3; border: none; font-weight: 700; padding: 12px; }
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
                <h2 class="fw-bold mb-1">Gestión Comercial</h2>
                <p class="text-muted mb-4">Configura los precios de los 3 planes de CajaYa.cl</p>

                <?php if ($message): ?>
                    <div class="alert alert-success border-0"><?= $message ?></div>
                <?php endif; ?>

                <div class="row g-4">
                    <?php foreach ($plans as $plan): ?>
                    <div class="col-md-4">
                        <div class="card card-plan p-4">
                            <span class="badge bg-primary mb-2" style="width:fit-content;"><?= strtoupper($plan['slug']) ?></span>
                            <h4 class="fw-bold"><?= htmlspecialchars($plan['name']) ?></h4>
                            <hr class="opacity-10">
                            <form method="POST">
                                <input type="hidden" name="slug" value="<?= $plan['slug'] ?>">
                                <div class="mb-4">
                                    <label class="form-label text-muted small fw-bold">PRECIO (CLP)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-0 text-muted">$</span>
                                        <input type="number" name="price" class="form-control bg-dark border-0 text-white fw-bold" value="<?= (int)$plan['price'] ?>" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 btn-update">
                                    <i class="fa-solid fa-rotate me-2"></i> Actualizar
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/js/adminlte.min.js"></script>
</body>
</html>
