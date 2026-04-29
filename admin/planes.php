<?php
/**
 * admin/planes.php — Gestión de Precios de Planes
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/Database.php';
require_once __DIR__ . '/../src/Repositories/PlanRepository.php';

session_start();
// Aquí iría tu lógica de verificación de sesión de admin
// if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit; }

$planRepo = new PlanRepository();
$message = "";

// Procesar actualización de precio
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['slug'], $_POST['price'])) {
    $slug = $_POST['slug'];
    $price = (float)$_POST['price'];
    if ($planRepo->updatePrice($slug, $price)) {
        $message = "✅ Precio actualizado correctamente.";
    } else {
        $message = "❌ Error al actualizar el precio.";
    }
}

$plans = $planRepo->getAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Planes - PanelBoss</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #F5F5F7; color: #1D1D1F; padding: 40px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        h1 { font-weight: 600; margin-bottom: 30px; font-size: 24px; border-bottom: 1px solid #eee; padding-bottom: 20px; }
        .alert { padding: 15px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #E8F5E9; color: #2E7D32; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 15px; color: #86868B; font-weight: 400; font-size: 13px; text-transform: uppercase; border-bottom: 1px solid #F5F5F7; }
        td { padding: 20px 15px; border-bottom: 1px solid #F5F5F7; }
        .price-input { padding: 8px 12px; border: 1px solid #D2D2D7; border-radius: 8px; width: 120px; font-size: 15px; }
        .btn-save { background: #0071E3; color: white; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: 0.2s; }
        .btn-save:hover { background: #0077ED; }
        .badge { font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 4px; background: #eee; }
    </style>
</head>
<body>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="index.php" style="color: #0071E3; text-decoration: none; font-size: 14px;">&larr; Volver al Dashboard</a>
        <span class="badge">CONFIGURACIÓN DE PAGOS</span>
    </div>

    <h1>Gestión de Planes y Precios</h1>

    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Plan</th>
                <th>Slug</th>
                <th>Precio Actual (CLP)</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($plans as $plan): ?>
            <tr>
                <form method="POST">
                    <td><strong><?php echo htmlspecialchars($plan['name']); ?></strong></td>
                    <td><code><?php echo htmlspecialchars($plan['slug']); ?></code></td>
                    <td>
                        <input type="hidden" name="slug" value="<?php echo $plan['slug']; ?>">
                        <input type="number" name="price" class="price-input" value="<?php echo (int)$plan['price']; ?>" step="100">
                    </td>
                    <td>
                        <button type="submit" class="btn-save">Guardar</button>
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="margin-top: 40px; font-size: 12px; color: #86868B; line-height: 1.6;">
        <strong>Instrucciones:</strong><br>
        • Cambia el precio y dale a "Guardar". Los cambios se reflejan al instante en la web.<br>
        • Para hacer pruebas, usa el plan <code>test</code> o baja el <code>lifetime</code> a 100.<br>
        • No olvides volver a subir el precio a 180000 cuando termines tus pruebas.
    </div>
</div>

</body>
</html>
