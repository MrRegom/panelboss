<?php
/**
 * auth/google_redirect.php — Inicia el flujo de Google OAuth
 */
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

// 1. Cargar Variables de Entorno (desde la raíz)
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// 2. Capturar el plan que el usuario seleccionó
if (isset($_GET['plan'])) {
    $_SESSION['pending_plan'] = $_GET['plan'];
}

// 3. Configurar Cliente de Google
$client = new Google\Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);

// URL de retorno (Callback)
// Nota: Ajusta esto a tu dominio real (ej: https://panel.cajaya.cl/auth/callback.php)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$redirectUri = "$protocol://$host/pagina/auth/callback.php";
$client->setRedirectUri($redirectUri);

$client->addScope("email");
$client->addScope("profile");

// 4. Redirigir a Google
$authUrl = $client->createAuthUrl();
header('Location: ' . $authUrl);
exit;
