<?php
/**
 * auth/callback.php — Recibe el token de Google y procesa el login/registro
 */
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Config/Database.php';
require_once __DIR__ . '/../../src/Services/SocialAuthService.php';

use App\Config\Database;
use App\Services\SocialAuthService;

// 1. Cargar Variables de Entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// 2. Configurar Cliente de Google
$client = new Google\Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$redirectUri = "$protocol://$host/pagina/auth/callback.php";
$client->setRedirectUri($redirectUri);

if (!isset($_GET['code'])) {
    header('Location: ../index.php');
    exit;
}

try {
    // 3. Intercambiar código por Token
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // 4. Obtener datos del perfil
    $googleService = new Google\Service\Oauth2($client);
    $userinfo = $googleService->userinfo->get();

    $userData = [
        'email'    => $userinfo->email,
        'name'     => $userinfo->name,
        'id'       => $userinfo->id,
        'picture'  => $userinfo->picture,
        'provider' => 'google'
    ];

    // 5. Procesar en el SocialAuthService
    $db = Database::getConnection();
    $authService = new SocialAuthService($db);
    $result = $authService->handleSocialLogin($userData);

    if ($result['success']) {
        // Guardar en sesión
        $_SESSION['user_email'] = $userData['email'];
        $_SESSION['user_name']  = $userData['name'];
        $_SESSION['user_id']    = $result['user']['id'];

        // 6. FLUJO INTELIGENTE: ¿Había un pago pendiente?
        if (isset($_SESSION['pending_plan'])) {
            $plan = $_SESSION['pending_plan'];
            unset($_SESSION['pending_plan']); // Limpiar para que no se repita
            
            // Redirigir directo al checkout de MercadoPago
            header("Location: ../mercadopago/checkout.php?plan=$plan");
            exit;
        }

        // Si no había plan pendiente, ir al panel o landing
        header('Location: ../index.php?auth=success');
        exit;
    }

} catch (Exception $e) {
    die("Error en la autenticación: " . $e->getMessage());
}
