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
        // 1. Intentar de $_ENV (estándar)
        $accessToken = $_ENV['MP_ACCESS_TOKEN'] ?? getenv('MP_ACCESS_TOKEN') ?? '';
        
        // 2. Si falla, buscar el archivo .env "a mano"
        if (empty($accessToken)) {
            $dirs = [
                __DIR__ . '/../../.env',           // Raíz desde Services
                __DIR__ . '/../../public/.env',    // Public desde Services
                $_SERVER['DOCUMENT_ROOT'] . '/.env',
                $_SERVER['DOCUMENT_ROOT'] . '/../.env'
            ];
            
            foreach ($dirs as $path) {
                if (file_exists($path)) {
                    $content = file_get_contents($path);
                    if (preg_match('/^\s*MP_ACCESS_TOKEN\s*=\s*[\'"]?([^\s\'"]+)[\'"]?/m', $content, $matches)) {
                        $accessToken = $matches[1];
                        break;
                    }
                }
            }
        }

        if (empty($accessToken)) {
            die("ERROR CRÍTICO: No se pudo cargar el MP_ACCESS_TOKEN tras buscar en 4 rutas. Verifica que el archivo .env en 'public/' tenga permisos de lectura para el servidor web.");
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
            ],
            "external_reference" => (string)$external_reference,
            "back_urls" => [
                "success" => "https://cajaya.cl/mercadopago/success.php",
                "failure" => "https://cajaya.cl/mercadopago/failure.php",
                "pending" => "https://cajaya.cl/mercadopago/pending.php"
            ],
            "auto_return" => "approved",
            "notification_url" => "https://cajaya.cl/api/mercadopago/webhook.php"
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 201 || $httpCode === 200) {
            $json = json_decode($response, true);
            return $json['init_point'] ?? false;
        }

        // Si falla, queremos ver POR QUÉ
        die("ERROR MP: HTTP $httpCode - Respuesta: $response");
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
