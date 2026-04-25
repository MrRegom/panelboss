<?php
require_once __DIR__ . '/../vendor/autoload.php';
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
    <title>Prospectos - CajaYa Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
    <style>
        .avatar-img { width: 32px; height: 32px; border-radius: 50%; }
        .badge-google { background: #ea4335; color: white; }
        .badge-microsoft { background: #00a4ef; color: white; }
    </style>
</head>
<body>
    <div class="page">
        <header class="navbar navbar-expand-md navbar-light d-print-none">
            <div class="container-xl">
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="index.php">CajaYa Admin</a>
                </h1>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item">
                        <a href="logout.php" class="nav-link">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </header>
        
        <div class="page-wrapper">
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">Gestión de Prospectos (Leads)</h2>
                            <div class="text-muted mt-1">Usuarios que han mostrado interés y descargado la demo.</div>
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
                                        <th>Usuario</th>
                                        <th>Email</th>
                                        <th>Proveedor</th>
                                        <th>Licencia Demo</th>
                                        <th>Fecha Registro</th>
                                        <th class="w-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($leads as $lead): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex py-1 align-items-center">
                                                <img src="<?php echo $lead['avatar_url'] ?: 'https://ui-avatars.com/api/?name=' . urlencode($lead['full_name']); ?>" class="avatar-img me-2">
                                                <div class="flex-fill">
                                                    <div class="font-weight-medium"><?php echo htmlspecialchars($lead['full_name']); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-muted"><?php echo htmlspecialchars($lead['email']); ?></td>
                                        <td>
                                            <span class="badge badge-outline <?php echo $lead['provider'] === 'google' ? 'badge-google' : 'badge-microsoft'; ?>">
                                                <?php echo ucfirst($lead['provider']); ?>
                                            </span>
                                        </td>
                                        <td class="text-muted font-monospace"><?php echo $lead['demo_license_key']; ?></td>
                                        <td><?php echo date('d M Y, H:i', strtotime($lead['created_at'])); ?></td>
                                        <td>
                                            <a href="mailto:<?php echo $lead['email']; ?>" class="btn btn-sm btn-ghost-primary">Contactar</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($leads)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">No hay prospectos registrados aún.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
