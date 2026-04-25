<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';
use App\Services\AuthService;
use App\Repositories\SettingRepository;

try {
    AuthService::check();
} catch (\Exception $e) {
    die("Error de Autenticación: " . $e->getMessage());
}

$userName = $_SESSION['user_name'] ?? 'Administrador';

try {
    $repo = new SettingRepository();
    $downloadUrl = $repo->get('download_url');
    $currentVersion = $repo->get('current_version');
} catch (\Exception $e) {
    die("Error de Base de Datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Configuración | PanelBoss PRO</title>
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
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown user-menu"> 
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"> 
                            <span class="d-none d-md-inline fw-semibold me-2"><?= $userName ?></span>
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-user-tie text-white small"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2">
                            <li><a href="logout.php" class="dropdown-item py-2 text-danger fw-medium"><i class="fa-solid fa-right-from-bracket me-2"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header py-4">
                <div class="container-fluid px-4">
                    <div class="row align-items-center">
                        <div class="col-sm-12">
                            <h3 class="fw-semibold mb-0">Configuración del Sistema</h3>
                            <p class="text-muted small">Gestiona los enlaces de descarga y versiones de CajaYa</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="app-content px-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header border-0 pb-0">
                                <h5 class="card-title fw-bold">Software POS</h5>
                            </div>
                            <div class="card-body p-4">
                                <form id="formSettings">
                                    <div class="mb-4">
                                        <label class="form-label text-muted small fw-bold">URL DE DESCARGA (.EXE)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark border-secondary text-primary">
                                                <i class="fa-solid fa-download"></i>
                                            </span>
                                            <input type="url" class="form-control bg-dark border-secondary" name="download_url" value="<?= htmlspecialchars($downloadUrl) ?>" required>
                                        </div>
                                        <div class="form-text text-muted">Este es el link que se envía por correo a los clientes.</div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label text-muted small fw-bold">VERSIÓN ACTUAL</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark border-secondary text-primary">
                                                <i class="fa-solid fa-code-branch"></i>
                                            </span>
                                            <input type="text" class="form-control bg-dark border-secondary" name="current_version" value="<?= htmlspecialchars($currentVersion) ?>" required>
                                        </div>
                                    </div>

                                    <div class="text-end border-top pt-3 mt-4">
                                        <button type="submit" class="btn btn-primary px-5">
                                            <i class="fa-solid fa-floppy-disk me-2"></i> GUARDAR CAMBIOS
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 bg-primary bg-opacity-10">
                            <div class="card-body p-4">
                                <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-circle-info me-2"></i> Instrucciones</h5>
                                <p class="small text-muted mb-3">Aquí puedes actualizar el instalador que tus clientes descargan. Sigue estas recomendaciones:</p>
                                <ul class="small text-muted mb-0">
                                    <li class="mb-2">Asegúrate de que el archivo .exe esté subido al servidor o a un CDN.</li>
                                    <li class="mb-2">Usa siempre rutas absolutas (empezando con https://).</li>
                                    <li class="mb-2">Al cambiar la versión, asegúrate de que el archivo físico coincida.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        $('#formSettings').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Guardando...');

            $.post('api/save_settings.php', $(this).serialize(), function(res) {
                btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-2"></i> GUARDAR CAMBIOS');
                if(res.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: res.message,
                        icon: 'success',
                        confirmButtonColor: '#2563eb'
                    });
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 'json');
        });
    });
    </script>
</body>
</html>
