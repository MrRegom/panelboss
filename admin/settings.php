<?php
require_once __DIR__ . '/includes/bootstrap.php';
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
<html lang="es">
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
                            <h3 class="fw-bold mb-0">Configuración del Sistema</h3>
                            <p class="text-muted small">Gestiona los enlaces de descarga y versiones de CajaYa</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="app-content px-4">
                <div class="row g-4">
                    <div class="col-md-7">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="card-title fw-bold mb-0">Software POS</h5>
                            </div>
                            <div class="card-body p-4">
                                <form id="formUpload" enctype="multipart/form-data">
                                    <div class="mb-4">
                                        <label class="small fw-bold text-muted mb-2">SUBIR NUEVA VERSIÓN (.EXE)</label>
                                        <input type="file" class="form-control" name="installer" id="installerFile" accept=".exe" required>
                                        <div class="form-text text-muted">El archivo se alojará en el servidor y actualizará el link de descarga.</div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="small fw-bold text-muted mb-2">ETIQUETA DE VERSIÓN</label>
                                        <input type="text" class="form-control" name="version" placeholder="Ej: 2.4.0" required>
                                    </div>

                                    <div class="progress mb-4 d-none" style="height: 8px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%"></div>
                                    </div>

                                    <div class="text-end border-top pt-4">
                                        <button type="submit" class="btn btn-primary px-5 fw-bold">
                                            <i class="fa-solid fa-cloud-arrow-up me-2"></i> SUBIR Y ACTUALIZAR
                                        </button>
                                    </div>
                                </form>

                                <hr class="my-5 opacity-10">

                                <form id="formSettings">
                                    <h6 class="fw-bold mb-4 text-primary">Configuración de Rutas</h6>
                                    <div class="mb-4">
                                        <label class="small fw-bold text-muted mb-2">URL DE DESCARGA DIRECTA</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa-solid fa-link text-muted"></i>
                                            </span>
                                            <input type="url" class="form-control" name="download_url" value="<?= htmlspecialchars($downloadUrl) ?>" required>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="small fw-bold text-muted mb-2">VERSIÓN ACTUAL EN PRODUCCIÓN</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa-solid fa-code-branch text-muted"></i>
                                            </span>
                                            <input type="text" class="form-control" name="current_version" value="<?= htmlspecialchars($currentVersion) ?>" required>
                                        </div>
                                    </div>

                                    <div class="text-end border-top pt-4">
                                        <button type="submit" class="btn btn-primary px-5 fw-bold">
                                            <i class="fa-solid fa-floppy-disk me-2"></i> GUARDAR CONFIGURACIÓN
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm" style="background: var(--primary-soft);">
                            <div class="card-body p-4">
                                <h5 class="fw-bold text-primary mb-4"><i class="fa-solid fa-lightbulb me-2"></i> Guía Rápida</h5>
                                <div class="d-flex gap-3 mb-4">
                                    <div class="icon-circle bg-white shadow-sm p-3 rounded-circle text-primary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-shield-check"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Seguridad de Archivos</h6>
                                        <p class="small text-muted mb-0">Solo se permiten archivos .exe para garantizar la integridad del instalador.</p>
                                    </div>
                                </div>
                                <div class="d-flex gap-3">
                                    <div class="icon-circle bg-white shadow-sm p-3 rounded-circle text-primary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-envelope-circle-check"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Notificación Automática</h6>
                                        <p class="small text-muted mb-0">Al cambiar la versión aquí, los nuevos prospectos recibirán automáticamente el link actualizado.</p>
                                    </div>
                                </div>
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
        $('#formUpload').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const btn = $(this).find('button[type="submit"]');
            const progress = $('.progress');
            const progressBar = $('.progress-bar');

            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Procesando...');
            progress.removeClass('d-none');

            $.ajax({
                url: 'api/upload_installer.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    const xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            const percentComplete = Math.round((evt.loaded / evt.total) * 100);
                            progressBar.css('width', percentComplete + '%').text(percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(res) {
                    btn.prop('disabled', false).html('<i class="fa-solid fa-cloud-arrow-up me-2"></i> SUBIR Y ACTUALIZAR');
                    if(res.success) {
                        Swal.fire({ icon: 'success', title: '¡Éxito!', text: res.message }).then(() => location.reload());
                    } else {
                        Swal.fire('Error', res.message, 'error');
                        progress.addClass('d-none');
                    }
                }
            });
        });

        $('#formSettings').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Guardando...');

            $.post('api/save_settings.php', $(this).serialize(), function(res) {
                btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-2"></i> GUARDAR CONFIGURACIÓN');
                if(res.success) {
                    Swal.fire({ icon: 'success', title: 'Configuración Guardada', text: res.message, confirmButtonColor: '#6A37B7' });
                }
            }, 'json');
        });
    });
    </script>
</body>
</html>
