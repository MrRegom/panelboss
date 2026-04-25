<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Config\Database;
use App\Services\SocialAuthService;

// Carga de variables de entorno
$envPath = __DIR__ . '/../../.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) $_ENV[trim($parts[0])] = trim($parts[1], " \"'");
    }
}

$provider = $_GET['provider'] ?? 'google';
$code = $_GET['code'] ?? null;

if (!$code) {
    die("Error: No se recibió código de autorización.");
}

// 1. Intercambiar código por token de acceso (Google)
$tokenUrl = "https://oauth2.googleapis.com/token";
$postData = [
    'code' => $code,
    'client_id' => $_ENV['GOOGLE_CLIENT_ID'],
    'client_secret' => $_ENV['GOOGLE_CLIENT_SECRET'],
    'redirect_uri' => 'https://api.cajaya.cl/auth-callback.php?provider=google',
    'grant_type' => 'authorization_code'
];

$ch = curl_init($tokenUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
$response = curl_exec($ch);
$tokenData = json_decode($response, true);
curl_close($ch);

if (!isset($tokenData['access_token'])) {
    die("Error al obtener token de Google.");
}

// 2. Obtener datos del usuario
$userUrl = "https://www.googleapis.com/oauth2/v2/userinfo?access_token=" . $tokenData['access_token'];
$userData = json_decode(file_get_contents($userUrl), true);
$userData['provider'] = 'google';

// 3. Procesar con nuestro servicio (Guardar en DB y crear Licencia)
$authService = new SocialAuthService(Database::getConnection());
$result = $authService->handleSocialLogin($userData);

// 4. Mostrar página de éxito profesional
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Bienvenido a CajaYa!</title>
    <link rel="stylesheet" href="https://api.cajaya.cl/css/style.css"> <!-- Reutilizamos estilos si existen -->
    <style>
        body { background: #04010a; color: white; font-family: 'Inter', sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .success-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(147, 51, 234, 0.3); padding: 3rem; border-radius: 24px; text-align: center; max-width: 500px; box-shadow: 0 0 50px rgba(147, 51, 234, 0.2); }
        .license-box { background: rgba(0,0,0,0.5); border: 1px dashed #9333ea; padding: 1.5rem; border-radius: 12px; margin: 2rem 0; font-family: monospace; font-size: 1.2rem; color: #0ea5e9; letter-spacing: 2px; }
        .btn-download { background: linear-gradient(135deg, #9333ea, #0ea5e9); color: white; padding: 1.2rem 2.5rem; border-radius: 12px; text-decoration: none; font-weight: bold; display: inline-block; transition: transform 0.3s; }
        .btn-download:hover { transform: translateY(-3px); }
        h1 { font-size: 2.5rem; margin-bottom: 0.5rem; }
        p { color: #94a3b8; }
    </style>
</head>
<body>
    <div class="success-card">
        <div style="font-size: 4rem; margin-bottom: 1rem;">🎉</div>
        <h1>¡Hola, <?php echo htmlspecialchars($userData['name']); ?>!</h1>
        <p>Tu cuenta ha sido creada con éxito. Aquí tienes tu acceso para empezar hoy mismo:</p>
        
        <div class="license-box">
            <?php echo $result['license_key']; ?>
        </div>
        
        <p style="margin-bottom: 2rem;">Copia esta llave y úsala al abrir la aplicación.</p>
        
        <a href="<?php echo $result['download_url']; ?>" class="btn-download">
            ⬇️ Descargar CajaYa para Windows
        </a>
        
        <p style="margin-top: 2rem; font-size: 0.8rem;">También te enviamos una copia a <strong><?php echo $userData['email']; ?></strong></p>
    </div>
</body>
</html>
