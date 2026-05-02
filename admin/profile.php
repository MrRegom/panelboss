<?php
require_once __DIR__ . '/includes/bootstrap.php';
use App\Services\AuthService;
use App\Config\Database;

AuthService::check();

$db = Database::getConnection();
$userId = $_SESSION['user_id'];

// Obtener datos actuales del usuario
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    header("Location: logout.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil | CajaYa Silk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin-custom.css">
    <style>
        .profile-card {
            max-width: 700px;
            margin: 0 auto;
            border-radius: 24px;
        }
        .avatar-huge {
            width: 100px;
            height: 100px;
            background: var(--silk-purple);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 2.5rem;
            margin: 0 auto 20px;
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.3);
        }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg">
    <div class="app-wrapper">
        <?php include __DIR__ . '/includes/header.php'; ?>
        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header py-4">
                <div class="container-fluid px-4 text-center">
                    <h3 class="fw-bold mb-0">Configuración de Perfil</h3>
                    <p class="text-muted small">Gestiona tu identidad y seguridad en la plataforma</p>
                </div>
            </div>

            <div class="app-content px-4 pb-5">
                <div class="card profile-card border-0 shadow-sm overflow-hidden">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <div class="avatar-huge">
                                <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                            </div>
                            <h4 class="fw-bold"><?= htmlspecialchars($user['full_name']) ?></h4>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill"><?= strtoupper($user['role']) ?></span>
                        </div>

                        <form id="profileForm">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="small fw-bold text-muted mb-2">MI RUT (No editable)</label>
                                    <input type="text" class="form-control bg-light" value="<?= $user['rut'] ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-muted mb-2">NOMBRE COMPLETO</label>
                                    <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="small fw-bold text-muted mb-2">CORREO ELECTRÓNICO</label>
                                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                                </div>
                                
                                <div class="col-12">
                                    <hr class="my-4 opacity-50">
                                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-shield-halved me-2 text-primary"></i> Cambiar Contraseña</h5>
                                    <p class="small text-muted mb-4">Deja los campos en blanco si no deseas cambiar tu contraseña.</p>
                                </div>

                                <div class="col-md-6">
                                    <label class="small fw-bold text-muted mb-2">NUEVA CONTRASEÑA</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="••••••••">
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-muted mb-2">CONFIRMAR CONTRASEÑA</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="••••••••">
                                </div>

                                <div class="col-12 mt-5">
                                    <div class="alert alert-info border-0 py-3 mb-4 rounded-3 small">
                                        <i class="fa-solid fa-circle-info me-2"></i> Para guardar cambios, ingresa tu contraseña actual por seguridad.
                                    </div>
                                    <div class="mb-4">
                                        <label class="small fw-bold text-dark mb-2">CONTRASEÑA ACTUAL</label>
                                        <input type="password" name="current_password" class="form-control border-primary" required placeholder="Ingresa tu clave actual">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow">GUARDAR ACTUALIZACIONES</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php include __DIR__ . '/includes/footer.php'; ?>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        $('#profileForm').on('submit', function(e) {
            e.preventDefault();
            
            // Validar contraseñas nuevas si se ingresaron
            const pass = $('#new_password').val();
            const confirm = $('#confirm_password').val();
            
            if(pass && pass !== confirm) {
                Swal.fire('Error', 'Las nuevas contraseñas no coinciden.', 'error');
                return;
            }

            $.post('api/update_profile.php', $(this).serialize(), function(res) {
                if(res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
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
