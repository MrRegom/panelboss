<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Repositories\LicenseRepository;

$repo = new LicenseRepository();
$licenses = $repo->getAll();
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>PanelBoss - Gestión de Licencias</title>
    <!-- CSS files -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root { --tblr-font-sans-serif: 'Inter var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; }
      body { font-feature-settings: "cv03", "cv04", "cv11"; }
    </style>
  </head>
  <body>
    <div class="page">
      <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-xl">
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href=".">PanelBoss</a>
          </h1>
        </div>
      </header>
      <div class="page-wrapper">
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">Listado de Licencias</h2>
              </div>
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <a href="create.php" class="btn btn-primary d-none d-sm-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Nueva Licencia
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container-xl">
            <div class="card">
              <div class="table-responsive">
                <table class="table table-vcenter card-table">
                  <thead>
                    <tr>
                      <th>Key</th>
                      <th>Empresa</th>
                      <th>Plan</th>
                      <th>Estado</th>
                      <th>Expiración</th>
                      <th>Último Latido</th>
                      <th class="w-1"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($licenses as $l): ?>
                    <tr>
                      <td><code><?= htmlspecialchars($l['license_key']) ?></code></td>
                      <td class="text-secondary"><?= htmlspecialchars($l['business_name'] ?? 'N/A') ?></td>
                      <td><span class="badge bg-blue-lt"><?= strtoupper($l['plan']) ?></span></td>
                      <td>
                        <?php 
                        $statusClass = [
                            'active' => 'bg-success',
                            'pending' => 'bg-warning',
                            'revoked' => 'bg-danger',
                            'expired' => 'bg-secondary'
                        ][$l['status']] ?? 'bg-info';
                        ?>
                        <span class="badge <?= $statusClass ?>"><?= ucfirst($l['status']) ?></span>
                      </td>
                      <td class="text-secondary"><?= $l['expires_at'] ?? 'Perpetua' ?></td>
                      <td class="text-secondary"><?= $l['last_heartbeat_at'] ?? '-' ?></td>
                      <td><a href="edit.php?id=<?= $l['id'] ?>">Editar</a></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js" defer></script>
  </body>
</html>
