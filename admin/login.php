<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Services\AuthService;

session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new AuthService(\App\Config\Database::getConnection());
    if ($auth->login($_POST['email'], $_POST['password'])) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Credenciales inválidas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PanelBoss | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="login-page bg-body-secondary">
    <div class="login-box">
        <div class="login-logo"> <a href="../index.php"><b>PanelBoss</b>PRO</a> </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Inicia sesión para administrar el sistema</p>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form action="" method="post">
                    <div class="input-group mb-3"> 
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                        <div class="input-group-text"> <span class="fa-solid fa-envelope"></span> </div>
                    </div>
                    <div class="input-group mb-3"> 
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-text"> <span class="fa-solid fa-lock"></span> </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-grid gap-2"> <button type="submit" class="btn btn-primary">Ingresar</button> </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
