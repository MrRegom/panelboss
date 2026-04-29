<?php

namespace App\Services;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

/**
 * Servicio Profesional para la integración con Mercado Pago SDK v3
 * Implementa el flujo de 'Checkout Pro' actualizado a 2026
 */
class MercadoPagoService
{
    public function __construct()
    {
        // En SDK v3, basta con setear el Access Token. 
        // El SDK detecta si es producción o sandbox automáticamente por el prefijo APP_USR- o TEST-.
        $accessToken = $_ENV['MP_ACCESS_TOKEN'] ?? '';
        \MercadoPago\MercadoPagoConfig::setAccessToken($accessToken);
    }

    public function createPreference($title, $price, $external_reference)
    {
        // 1. Intentar leer de variables de entorno normales
        $accessToken = $_ENV['MP_ACCESS_TOKEN'] ?? $_SERVER['MP_ACCESS_TOKEN'] ?? getenv('MP_ACCESS_TOKEN') ?? '';
        
        // 2. Si falla, BUSCAR el archivo .env manualmente
        if (empty($accessToken)) {
            $currentDir = __DIR__;
            $foundEnv = null;
            // Buscar hasta 4 niveles arriba
            for ($i = 0; $i < 4; $i++) {
                $check = $currentDir . '/.env';
                if (file_exists($check)) { $foundEnv = $check; break; }
                $checkPublic = $currentDir . '/public/.env';
                if (file_exists($checkPublic)) { $foundEnv = $checkPublic; break; }
                $currentDir = dirname($currentDir);
            }

            if ($foundEnv) {
                $content = file_get_contents($foundEnv);
                if (preg_match('/MP_ACCESS_TOKEN\s*=\s*(.*)/', $content, $matches)) {
                    $accessToken = trim($matches[1], "\"' ");
                }
            } else {
                return "ERROR: No encontré el archivo .env en ninguna ruta conocida desde " . __DIR__;
            }
        }

        if (empty($accessToken)) {
            return "ERROR: Archivo .env encontrado en $foundEnv pero MP_ACCESS_TOKEN está vacío o mal escrito.";
        }

        $url = "https://api.mercadopago.com/checkout/preferences";
        
        $data = [
            "items" => [
                [
                    "title" => $title,
                    "quantity" => 1,
                    "unit_price" => (float)$price,
                    "currency_id" => "CLP"
                ]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json"
        ]);
        // Mimetizarse EXACTAMENTE con curl
        curl_setopt($ch, CURLOPT_USERAGENT, "curl/7.81.0");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response, true);

        if ($httpCode >= 200 && $httpCode < 300 && isset($result['init_point'])) {
            return $result['init_point'];
        }

        $tokenDebug = substr($accessToken, 0, 15) . "...";
        $errorMsg = "HTTP $httpCode - Token [$tokenDebug] - Resp: " . $response;
        error_log("Error Manual MP: " . $errorMsg);
        
        if (ini_get('display_errors')) {
            echo "Error detallado de MP (cURL Debug): " . $errorMsg;
        }

        return null;
    }

    public function getPayment($paymentId)
    {
        $accessToken = $_ENV['MP_ACCESS_TOKEN'] ?? '';
        $url = "https://api.mercadopago.com/v1/payments/$paymentId";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "User-Agent: CajaYa-POS/1.0"
        ]);
        
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
