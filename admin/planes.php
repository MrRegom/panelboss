<?php
/**
 * admin/planes.php — Gestión de Precios (V102)
 */
require_once __DIR__ . '/includes/bootstrap.php';

use App\Config\Database;
use App\Services\AuthService;

AuthService::check();

$message = "";
$db = Database::getConnection();

// --- LÓGICA DE AUTO-SANACIÓN ---
$slugsNeeded = ['mensual', 'lifetime', 'empresa'];
foreach ($slugsNeeded as $sn) {
    $check = $db->prepare("SELECT id FROM subscription_plans WHERE slug = ?");
    $check->execute([$sn]);
    if (!$check->fetch()) {
        $insert = $db->prepare("INSERT INTO subscription_plans (name, slug, price, duration_days, description) VALUES (?, ?, ?, ?, ?)");
        if ($sn === 'mensual')  $insert->execute(['Plan Mensual', 'mensual', 20000, 30, 'Suscripción Mensual']);
        if ($sn === 'lifetime') $insert->execute(['Plan Lifetime', 'lifetime', 180000, 9999, 'Licencia Vitalicia']);
        if ($sn === 'empresa')  $insert->execute(['Plan Empresa', 'empresa', 35000, 30, 'Plan para Empresas']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['slug'], $_POST['price'], $_POST['name'], $_POST['description'])) {
    $slug = $_POST['slug'];
    $price = (float)$_POST['price'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    $stmt = $db->prepare("UPDATE subscription_plans SET name = ?, price = ?, description = ?, updated_at = NOW() WHERE slug = ?");
    if ($stmt->execute([$name, $price, $description, $slug])) {
        $message = "Plan " . strtoupper($slug) . " actualizado correctamente.";
    }
}

$stmt = $db->query("SELECT * FROM subscription_plans WHERE slug IN ('mensual', 'lifetime', 'empresa') ORDER BY 
    CASE 
        WHEN slug = 'mensual' THEN 1 
        WHEN slug = 'lifetime' THEN 2 
        WHEN slug = 'empresa' THEN 3 
    END");
$plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Planes | CajaYa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand">
            <div class="container-fluid px-4">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#"> <i class="fa-solid fa-bars-staggered"></i> </a> </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header py-4">
                <div class="container-fluid px-4">
                    <h3 class="fw-bold mb-0">Gestión Comercial</h3>
                    <p class="text-muted small">Configura los precios y beneficios que se muestran en la landing page</p>
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
                            <div class="card border-0 shadow-sm h-100 p-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border-0 px-3 py-2"><?= strtoupper($plan['slug']) ?></span>
                                    <i class="fa-solid fa-shield-heart text-primary opacity-25 fs-4"></i>
                                </div>
                                <form method="POST">
                                    <input type="hidden" name="slug" value="<?= $plan['slug'] ?>">
                                    
                                    <div class="mb-3">
                                        <label class="small fw-bold text-muted mb-2 text-uppercase">Nombre del Plan</label>
                                        <input type="text" name="name" class="form-control fw-bold" value="<?= htmlspecialchars($plan['name']) ?>" required>
                                    </div>

                                    <div class="mb-4">
                                        <label class="small fw-bold text-muted mb-2 text-uppercase">Valor CLP</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0 text-muted fw-bold">$</span>
                                            <input type="number" name="price" class="form-control fw-bold" value="<?= (int)$plan['price'] ?>" required>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="small fw-bold text-muted mb-2 text-uppercase d-flex justify-content-between">
                                            <span>Beneficios</span>
                                            <span class="text-primary" style="font-size: 0.65rem;">Soporta **Negrita**</span>
                                        </label>
                                        <textarea name="description" class="form-control" rows="6" style="font-size: 0.85rem;" placeholder="Ej: Integración SII&#10;Soporte 24/7"><?= htmlspecialchars($plan['description']) ?></textarea>
                                        <div class="form-text small text-muted mt-2">Un beneficio por cada línea.</div>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                                        <i class="fa-solid fa-save me-2"></i> ACTUALIZAR PLAN
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/js/adminlte.min.js"></script>
</body>
</html>
