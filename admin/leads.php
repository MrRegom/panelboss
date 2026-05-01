<?php
require_once __DIR__ . '/includes/bootstrap.php';
use App\Services\AuthService;
use App\Config\Database;
use App\Repositories\LeadRepository;

AuthService::check();

$db = Database::getConnection();
$repo = new LeadRepository($db);
$leads = $repo->getAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prospectos | PanelBoss PRO</title>
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
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header py-4">
                <div class="container-fluid px-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="fw-bold mb-0">Gestión de Prospectos</h3>
                            <p class="text-muted small">Usuarios que han descargado la demo de CajaYa</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid px-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">Usuario</th>
                                            <th>Email</th>
                                            <th>Proveedor</th>
                                            <th>Licencia Demo</th>
                                            <th>WhatsApp</th>
                                            <th>Fecha Registro</th>
                                            <th class="text-end pe-4">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($leads as $lead): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <img src="<?= $lead['avatar_url'] ?: 'https://ui-avatars.com/api/?name=' . urlencode($lead['full_name']) ?>" class="rounded-circle me-3 border" width="35">
                                                    <span class="fw-bold text-dark"><?= htmlspecialchars($lead['full_name']) ?></span>
                                                </div>
                                            </td>
                                            <td class="text-muted"><?= htmlspecialchars($lead['email']) ?></td>
                                            <td>
                                                <?php if($lead['provider'] == 'google'): ?>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger border-0"><i class="fab fa-google me-1"></i> Google</span>
                                                <?php else: ?>
                                                    <span class="badge bg-info bg-opacity-10 text-info border-0"><i class="fab fa-microsoft me-1"></i> Microsoft</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><code><?= $lead['demo_license_key'] ?></code></td>
                                            <td>
                                                <?php if($lead['whatsapp']): ?>
                                                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $lead['whatsapp']) ?>" target="_blank" class="btn btn-sm btn-light border text-success fw-bold">
                                                        <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted small">Sin número</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-muted small"><?= date('d/m/Y H:i', strtotime($lead['created_at'])) ?></td>
                                            <td class="text-end pe-4">
                                                <a href="mailto:<?= $lead['email'] ?>" class="btn btn-sm btn-light border" title="Enviar Email">
                                                    <i class="fa-solid fa-envelope text-primary"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php if (empty($leads)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">No hay prospectos registrados aún.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/js/adminlte.min.js"></script>
</body>
</html>
