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

    /**
     * Crea una preferencia de pago (Link de cobro) usando SDK v3
     */
    public function createPreference($title, $price, $external_reference)
    {
        try {
            $client = new \MercadoPago\Client\Preference\PreferenceClient();
            
            $preference = $client->create([
                "items" => [
                    [
                        "id" => $external_reference,
                        "title" => $title,
                        "quantity" => 1,
                        "unit_price" => (float)$price,
                        "currency_id" => "CLP"
                    ]
                ],
                "external_reference" => $external_reference
            ]);

            return $preference->init_point; 
        } catch (\Exception $e) {
            $this->logError($e);
            return null;
        }
    }

    /**
     * Obtiene los detalles de un pago específico por su ID.
     * Útil para validar notificaciones de Webhook.
     */
    public function getPayment($paymentId)
    {
        try {
            $client = new \MercadoPago\Client\Payment\PaymentClient();
            return $client->get($paymentId);
        } catch (\Exception $e) {
            $this->logError($e);
            return null;
        }
    }

    private function logError(\Exception $e)
    {
        $errorMsg = $e->getMessage();
        if (method_exists($e, 'getApiResponse')) {
            $response = $e->getApiResponse();
            $errorMsg .= " - Detalle: " . json_encode($response->getContent());
        }
        error_log("Mercado Pago v3 Error: " . $errorMsg);
        
        if (ini_get('display_errors')) {
            echo "Error detallado de MP: " . $errorMsg;
        }
    }
}
