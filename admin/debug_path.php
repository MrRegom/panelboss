<?php
/**
 * DEBUG TEMPORAL - Eliminar después del diagnóstico
 * Acceder a: http://TU_DOMINIO/admin/debug_path.php
 */
require_once __DIR__ . '/includes/bootstrap.php';
use App\Services\AuthService;
use App\Config\Database;
AuthService::check();

$db = Database::getConnection();
$sample = $db->query("SELECT barcode, image_path FROM master_products WHERE image_path != '' LIMIT 1")->fetch(PDO::FETCH_ASSOC);

$barcode = $sample['barcode'];
$imgPath = $sample['image_path'];

// Rutas candidatas a probar
$candidates = [
    '/' . $imgPath,
    '../' . $imgPath,
    '../imagenes_productos/' . $barcode . '.jpg',
    '/imagenes_productos/' . $barcode . '.jpg',
];

$serverRoot = $_SERVER['DOCUMENT_ROOT'];
$scriptDir  = dirname($_SERVER['SCRIPT_FILENAME']);
?>
<!DOCTYPE html><html><head><title>Debug Rutas</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head><body class="p-4">
<h4>Debug de Rutas de Imágenes</h4>
<table class="table table-bordered">
<thead><tr><th>Ruta Probada</th><th>Imagen</th></tr></thead>
<tbody>
<?php foreach ($candidates as $path): ?>
<tr>
    <td><code><?= htmlspecialchars($path) ?></code></td>
    <td><img src="<?= htmlspecialchars($path) ?>" style="width:60px;height:60px;object-fit:contain;border:1px solid #ccc"
        onerror="this.style.border='2px solid red'; this.alt='❌ NO CARGA'">
        <span class="ms-2 small text-muted"><?= htmlspecialchars($path) ?></span>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<hr>
<p><strong>DOCUMENT_ROOT:</strong> <code><?= $serverRoot ?></code></p>
<p><strong>Script Dir:</strong> <code><?= $scriptDir ?></code></p>
<p><strong>URL Base:</strong> <code><?= (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] ?></code></p>
</body></html>
