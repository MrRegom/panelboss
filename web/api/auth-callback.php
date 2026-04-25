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

// 3. Procesar con nuestro servicio
$authService = new SocialAuthService(Database::getConnection());
$result = $authService->handleSocialLogin($userData);

// 4. Enviar Correo Electrónico Profesional
\App\Services\EmailService::sendLicenseKey(
    $userData['email'], 
    $userData['name'], 
    $result['license_key']
);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Bienvenido a CajaYa!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #04010a; color: white; font-family: 'Inter', sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .success-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(147, 51, 234, 0.3); padding: 3rem; border-radius: 24px; text-align: center; max-width: 500px; box-shadow: 0 0 50px rgba(147, 51, 234, 0.2); position: relative; overflow: hidden; }
        .license-container { position: relative; margin: 2rem 0; }
        .license-box { background: rgba(0,0,0,0.5); border: 1px dashed #9333ea; padding: 1.5rem; border-radius: 12px; font-family: monospace; font-size: 1.2rem; color: #0ea5e9; letter-spacing: 2px; display: flex; align-items: center; justify-content: center; gap: 10px; cursor: pointer; transition: all 0.3s; }
        .license-box:hover { border-style: solid; background: rgba(147, 51, 234, 0.1); }
        .copy-badge { position: absolute; top: -10px; right: -10px; background: #22c55e; color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: bold; display: none; }
        .btn-download { background: linear-gradient(135deg, #9333ea, #0ea5e9); color: white; padding: 1.2rem 2.5rem; border-radius: 12px; text-decoration: none; font-weight: bold; display: inline-block; transition: transform 0.3s; width: 100%; box-sizing: border-box; }
        .btn-download:hover { transform: translateY(-3px); }
        h1 { font-size: 2.2rem; margin-bottom: 0.5rem; }
        p { color: #94a3b8; line-height: 1.6; }
        .welcome-back { color: #f59e0b; font-weight: bold; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem; display: block; }
    </style>
</head>
<body>
    <div class="success-card">
        <div style="margin-bottom: 1.5rem;">
            <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 60px;">
        </div>

        <?php if (!$result['is_new']): ?>
            <span class="welcome-back">¡Qué bueno verte de nuevo!</span>
        <?php endif; ?>

        <h1>¡Felicidades, <?php echo explode(' ', $userData['name'])[0]; ?>!</h1>
        
        <p>
            <?php echo $result['is_new'] 
                ? 'Tu acceso a la nueva era de ventas está listo. Aquí tienes tu llave maestra:' 
                : 'Tu cuenta está activa y lista para seguir creciendo. Esta es tu llave:'; 
            ?>
        </p>
        
        <div class="license-container">
            <div class="license-box" id="licenseBox" onclick="copyLicense()">
                <span id="licenseText"><?php echo $result['license_key']; ?></span>
                <i class="fa-regular fa-copy" style="font-size: 0.9rem; opacity: 0.6;"></i>
            </div>
            <div id="copyBadge" class="copy-badge">¡LLAVE COPIADA! 🚀</div>
        </div>
        
        <p style="margin-bottom: 2rem; font-size: 0.9rem;">Copia la llave y pégala cuando abras la App de CajaYa en tu PC.</p>
        
        <a href="<?php echo $result['download_url']; ?>" class="btn-download">
            <i class="fa-solid fa-cloud-arrow-down me-2"></i> Descargar CajaYa v1.0.0
        </a>
        
        <p style="margin-top: 2rem; font-size: 0.8rem; opacity: 0.7;">
            Te hemos enviado un respaldo a <strong><?php echo $userData['email']; ?></strong>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        // Lanzar fuegos artificiales al cargar
        window.onload = function() {
            var end = Date.now() + (3 * 1000);
            var colors = ['#9333ea', '#0ea5e9'];

            (function frame() {
                confetti({
                    particleCount: 2,
                    angle: 60,
                    spread: 55,
                    origin: { x: 0 },
                    colors: colors
                });
                confetti({
                    particleCount: 2,
                    angle: 120,
                    spread: 55,
                    origin: { x: 1 },
                    colors: colors
                });

                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
            }());
        };

        function copyLicense() {
            const text = document.getElementById('licenseText').innerText;
            navigator.clipboard.writeText(text).then(() => {
                const badge = document.getElementById('copyBadge');
                badge.style.display = 'block';
                setTimeout(() => {
                    badge.style.display = 'none';
                }, 2000);
                
                // Un pequeño estallido extra al copiar
                confetti({
                    particleCount: 100,
                    spread: 70,
                    origin: { y: 0.6 },
                    colors: ['#22c55e']
                });
            });
        }
    </script>
</body>
</html>
