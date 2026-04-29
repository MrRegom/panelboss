<?php
/**
 * admin/planes.php — Gestión de Precios de Planes
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/Database.php';
require_once __DIR__ . '/../src/Repositories/PlanRepository.php';

// IMPORTANTE: Decirle a PHP que use el Namespace correcto
use App\Repositories\PlanRepository;

session_start();
// Autenticación básica de admin
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$planRepo = new PlanRepository();
$message = "";

// Procesar actualización de precio
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['slug'], $_POST['price'])) {
    $slug = $_POST['slug'];
    $price = (float)$_POST['price'];
    if ($planRepo->updatePrice($slug, $price)) {
        $message = "✅ Precio de '$slug' actualizado a $" . number_format($price, 0, ',', '.') . " CLP.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Planes - CajaYa</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #0071E3; --bg: #f5f5f7; --card: #ffffff; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: #1d1d1f; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: 40px auto; background: var(--card); padding: 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); }
        h1 { font-size: 28px; font-weight: 700; margin-bottom: 30px; letter-spacing: -0.5px; }
        .alert { padding: 15px 20px; border-radius: 12px; margin-bottom: 25px; font-size: 14px; font-weight: 500; }
        .alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #86868b; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #f2f2f7; }
        td { padding: 20px 15px; border-bottom: 1px solid #f2f2f7; }
        .plan-name { font-weight: 600; font-size: 16px; color: #1d1d1f; }
        .plan-slug { color: #0071e3; font-family: monospace; background: rgba(0,113,227,0.05); padding: 2px 6px; border-radius: 4px; font-size: 13px; }
        .price-input-group { display: flex; align-items: center; gap: 10px; }
        .price-input { padding: 10px 15px; border: 1px solid #d2d2d7; border-radius: 10px; width: 140px; font-size: 16px; font-weight: 600; }
        .btn-save { background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 10px; cursor: pointer; font-weight: 600; transition: all 0.2s; }
        .btn-save:hover { background: #0077ed; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,113,227,0.2); }
        .back-link { text-decoration: none; color: var(--primary); font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; gap: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Volver al Panel</a>
    
    <h1>Gestión de Precios</h1>

    <?php if ($message): ?>
        <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> <?php echo $message; ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Nombre del Plan</th>
                <th>Identificador (Slug)</th>
                <th>Precio (CLP)</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($plans as $plan): ?>
            <tr>
                <td><span class="plan-name"><?php echo htmlspecialchars($plan['name']); ?></span></td>
                <td><span class="plan-slug"><?php echo htmlspecialchars($plan['slug']); ?></span></td>
                <form method="POST">
                    <td>
                        <div class="price-input-group">
                            <input type="hidden" name="slug" value="<?php echo $plan['slug']; ?>">
                            <input type="number" name="price" class="price-input" value="<?php echo (int)$plan['price']; ?>">
                        </div>
                    </td>
                    <td>
                        <button type="submit" class="btn-save">Actualizar</button>
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="margin-top: 50px; background: #fafafa; padding: 25px; border-radius: 15px; border: 1px solid #f2f2f7;">
        <h3 style="font-size: 14px; margin-top: 0; color: #1d1d1f;"><i class="fa-solid fa-lightbulb"></i> Tips para el administrador:</h3>
        <ul style="font-size: 13px; color: #86868b; padding-left: 20px; line-height: 1.8;">
            <li>Para realizar pruebas sin riesgo, cambia el precio del plan <b>lifetime</b> a 100 pesos.</li>
            <li>El plan <b>test</b> también está disponible para validaciones técnicas rápidas.</li>
            <li>Recuerda volver a poner <b>180.000</b> cuando termines de probar para que los clientes paguen el precio real.</li>
        </ul>
    </div>
</div>

</body>
</html>
