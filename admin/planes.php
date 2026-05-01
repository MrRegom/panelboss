<?php
/**
 * admin/planes.php — Gestión de Precios
 */
require_once __DIR__ . '/includes/bootstrap.php';

use App\Config\Database;
use App\Services\AuthService;

AuthService::check();

$message = "";
$db = Database::getConnection();

// --- LÓGICA DE AUTO-SANACIÓN (Para Hostinger) ---
// Verificamos si los 3 planes existen, si no, los creamos.
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

// Procesar actualización de plan (V62)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['slug'], $_POST['price'], $_POST['name'])) {
    $slug = $_POST['slug'];
    $price = (float)$_POST['price'];
    $name = $_POST['name'];
    
    $stmt = $db->prepare("UPDATE subscription_plans SET name = ?, price = ?, updated_at = NOW() WHERE slug = ?");
    if ($stmt->execute([$name, $price, $slug])) {
        $message = "Plan " . strtoupper($slug) . " actualizado correctamente: $name ($" . number_format($price, 0, ',', '.') . ")";
    }
}

// Obtener planes ordenados
$stmt = $db->query("SELECT * FROM subscription_plans WHERE slug IN ('mensual', 'lifetime', 'empresa') ORDER BY 
    CASE 
        WHEN slug = 'mensual' THEN 1 
        WHEN slug = 'lifetime' THEN 2 
        WHEN slug = 'empresa' THEN 3 
    END");
$plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Planes | CajaYa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #0c0e11; }
        .card-plan { 
            background: #1a1e23; 
            border: 1px solid rgba(255,255,255,0.05); 
            border-radius: 20px; 
            transition: 0.3s;
        }
        .btn-update { background: #0071E3; border: none; font-weight: 700; border-radius: 12px; padding: 12px; }
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
                <p class="text-muted mb-4">Configura los precios de los 3 planes de la landing page.</p>

                <?php if ($message): ?>
                    <div class="alert alert-primary border-0 shadow-sm mb-4"><?= $message ?></div>
                <?php endif; ?>

                <div class="row g-4">
                    <?php foreach ($plans as $plan): ?>
                    <div class="col-md-4">
                        <div class="card card-plan h-100 p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary bg-opacity-25 text-primary border border-primary border-opacity-50 px-3 py-2"><?= strtoupper($plan['slug']) ?></span>
                            </div>
                            <form method="POST">
                                <input type="hidden" name="slug" value="<?= $plan['slug'] ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">NOMBRE DEL PLAN</label>
                                    <input type="text" name="name" class="form-control bg-dark border-0 text-white fw-bold mb-3" value="<?= htmlspecialchars($plan['name']) ?>" required style="border-radius: 12px; padding: 12px;">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-muted small fw-bold">VALOR (CLP)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-0 text-muted" style="border-radius: 12px 0 0 12px;">$</span>
                                        <input type="number" name="price" class="form-control bg-dark border-0 text-white fw-bold" value="<?= (int)$plan['price'] ?>" required style="border-radius: 0 12px 12px 0;">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 btn-update">
                                    <i class="fa-solid fa-save me-2"></i> Guardar Cambios
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
