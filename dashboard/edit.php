<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Config\Database;

$id = $_GET['id'] ?? null;
if (!$id) die("ID no proporcionado.");

$db = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("UPDATE licenses SET status = ?, plan = ?, expires_at = ? WHERE id = ?");
    $stmt->execute([$_POST['status'], $_POST['plan'], !empty($_POST['expires_at']) ? $_POST['expires_at'] : null, $id]);
    header("Location: index.php?updated=1");
    exit;
}

$stmt = $db->prepare("SELECT * FROM licenses WHERE id = ?");
$stmt->execute([$id]);
$l = $stmt->fetch();
if (!$l) die("Licencia no encontrada.");
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8"/>
    <title>PanelBoss - Editar Licencia</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet"/>
  </head>
  <body>
    <div class="page">
      <div class="page-wrapper">
        <div class="container-xl mt-5">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header"><h3 class="card-title">Gestionar Licencia: <?= htmlspecialchars($l['license_key']) ?></h3></div>
                <div class="card-body">
                  <form method="POST">
                    <div class="mb-3">
                      <label class="form-label">Estado</label>
                      <select name="status" class="form-select">
                        <option value="pending" <?= $l['status'] == 'pending' ? 'selected' : '' ?>>Pendiente</option>
                        <option value="active" <?= $l['status'] == 'active' ? 'selected' : '' ?>>Activa</option>
                        <option value="revoked" <?= $l['status'] == 'revoked' ? 'selected' : '' ?>>Revocada</option>
                        <option value="expired" <?= $l['status'] == 'expired' ? 'selected' : '' ?>>Expirada</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Plan</label>
                      <select name="plan" class="form-select">
                        <option value="basic" <?= $l['plan'] == 'basic' ? 'selected' : '' ?>>Basic</option>
                        <option value="pro" <?= $l['plan'] == 'pro' ? 'selected' : '' ?>>Pro</option>
                        <option value="enterprise" <?= $l['plan'] == 'enterprise' ? 'selected' : '' ?>>Enterprise</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Expiración</label>
                      <input type="date" name="expires_at" class="form-control" value="<?= $l['expires_at'] ?>">
                    </div>
                    <div class="form-footer">
                      <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                      <a href="index.php" class="btn btn-link w-100">Cancelar</a>
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
