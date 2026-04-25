<?php
require_once __DIR__ . '/../../vendor/autoload.php';

// Carga de variables de entorno simple
$envPath = __DIR__ . '/../../.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) $_ENV[trim($parts[0])] = trim($parts[1], " \"'");
    }
}

$provider = $_GET['provider'] ?? 'google';

if ($provider === 'google') {
    $clientId = $_ENV['GOOGLE_CLIENT_ID'];
    $redirectUri = 'https://api.cajaya.cl/auth-callback.php?provider=google';
    $scope = 'email profile';
    
    $url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
        'client_id' => $clientId,
        'redirect_uri' => $redirectUri,
        'response_type' => 'code',
        'scope' => $scope,
        'access_type' => 'online'
    ]);
    
    header("Location: " . $url);
    exit;
}
