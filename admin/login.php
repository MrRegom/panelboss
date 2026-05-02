<?php
require_once __DIR__ . '/includes/bootstrap.php';
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
    <title>Acceso Corporativo | CajaYa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6a37b7;
            --primary-hover: #562a9c;
            --bg-lavender: #f1ecf9;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-lavender);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 440px;
            padding: 50px;
            border-radius: 40px;
            box-shadow: 0 20px 40px rgba(106, 55, 183, 0.1);
        }
        .brand-logo {
            display: block;
            margin: 0 auto 40px;
            height: 45px;
        }
        h2 {
            font-weight: 700;
            color: #1a1a1a;
            font-size: 1.8rem;
            letter-spacing: -1px;
            margin-bottom: 8px;
            text-align: center;
        }
        p.subtitle {
            color: #636e72;
            font-size: 0.95rem;
            text-align: center;
            margin-bottom: 35px;
        }
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #2d3436;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-control {
            border-radius: 16px;
            padding: 14px 20px;
            border: 2px solid #f1f3f5;
            background: #f8f9fa;
            font-weight: 500;
            transition: 0.3s;
        }
        .form-control:focus {
            border-color: var(--primary-color);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(106, 55, 183, 0.05);
            outline: none;
        }
        .btn-login {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 16px;
            padding: 16px;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            margin-top: 15px;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(106, 55, 183, 0.2);
        }
        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(106, 55, 183, 0.3);
            color: white;
        }
        .alert {
            border-radius: 16px;
            border: none;
            font-weight: 500;
            font-size: 0.9rem;
        }
        .footer-text {
            text-align: center;
            margin-top: 30px;
            font-size: 0.8rem;
            color: #b2bec3;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <img src="img/logo.png" alt="CajaYa" class="brand-logo">
        
        <h2>Panel de Control</h2>
        <p class="subtitle">Accede a la gestión inteligente de CajaYa</p>

        <?php if ($error): ?>
            <div class="alert alert-danger mb-4">
                <i class="fa-solid fa-circle-exclamation me-2"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="email" class="form-control" placeholder="ejemplo@cajaya.cl" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-login">Ingresar al Sistema</button>
        </form>

        <div class="footer-text">
            &copy; 2026 CAJAYA ENTERPRISE &bull; V4.0
        </div>
    </div>
</body>
</html>
