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
        $accessToken = $_ENV['MP_ACCESS_TOKEN'] ?? '';
        $url = "https://api.mercadopago.com/checkout/preferences";
        
        $data = [
            "items" => [
                [
                    "id" => $external_reference,
                    "title" => $title,
                    "quantity" => 1,
                    "unit_price" => (float)$price,
                    "currency_id" => "CLP"
                ]
            ],
            "back_urls" => [
                "success" => "https://cajaya.cl/mercadopago/confirm.php?status=success",
                "failure" => "https://cajaya.cl/mercadopago/confirm.php?status=failure",
                "pending" => "https://cajaya.cl/mercadopago/confirm.php?status=pending"
            ],
            "auto_return" => "approved",
            "external_reference" => $external_reference,
            "notification_url" => "https://cajaya.cl/mercadopago/webhook.php"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response, true);

        if ($httpCode >= 200 && $httpCode < 300 && isset($result['init_point'])) {
            return $result['init_point'];
        }

        $errorMsg = "HTTP $httpCode - " . $response;
        error_log("Error Manual MP: " . $errorMsg);
        
        if (ini_get('display_errors')) {
            echo "Error detallado de MP (cURL): " . $errorMsg;
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
