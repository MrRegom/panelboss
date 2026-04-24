<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Repositories\LicenseRepository;

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $repo = new LicenseRepository();
    
    $plan = $_POST['plan'] ?? 'basic';
    $expires_at = !empty($_POST['expires_at']) ? $_POST['expires_at'] : null;
    
    // Generar Key estilo LPOS-2026-XXXX-XXXX-XXXX
    $year = date('Y');
    $chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
    $getChunk = function($len) use ($chars) {
        $str = "";
        for ($i=0; $i<$len; $i++) $str .= $chars[rand(0, strlen($chars)-1)];
        return $str;
    };
    $key = "LPOS-{$year}-" . $getChunk(4) . "-" . $getChunk(4) . "-" . $getChunk(4);

    if ($repo->create($key, $plan, $expires_at)) {
        header("Location: index.php?success=1");
        exit;
    } else {
        $message = "Error al crear la licencia.";
    }
}
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8"/>
    <title>PanelBoss - Nueva Licencia</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet"/>
  </head>
  <body>
    <div class="page">
      <div class="page-wrapper">
        <div class="container-xl">
          <div class="row justify-content-center mt-5">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header"><h3 class="card-title">Crear Nueva Licencia</h3></div>
                <div class="card-body">
                  <?php if($message): ?><div class="alert alert-danger"><?= $message ?></div><?php endif; ?>
                  <form method="POST">
                    <div class="mb-3">
                      <label class="form-label">Plan</label>
                      <select name="plan" class="form-select">
                        <option value="basic">Basic</option>
                        <option value="pro">Pro</option>
                        <option value="enterprise">Enterprise</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Fecha de Expiración (Opcional)</label>
                      <input type="date" name="expires_at" class="form-control">
                      <small class="text-muted">Dejar vacío para licencia perpetua.</small>
                    </div>
                    <div class="form-footer">
                      <button type="submit" class="btn btn-primary w-100">Generar Licencia</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
