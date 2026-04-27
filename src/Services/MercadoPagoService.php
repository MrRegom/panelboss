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
        // Configuración inicial para SDK v3
        // Token de Prueba (Debes reemplazarlo por tu Access Token de MP)
        MercadoPagoConfig::setAccessToken("APP_USR-6317423040933451-021714-00000000000000000000000000000000-000000000"); // REEMPLAZAR
        
        // Opcional: Configurar el entorno (puedes omitirlo para usar el default)
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
    }

    /**
     * Crea una preferencia de pago (Link de cobro) usando SDK v3
     */
    public function createPreference($title, $price, $external_reference)
    {
        try {
            $client = new PreferenceClient();

            // URLs de retorno
            $backUrls = [
                "success" => "https://" . $_SERVER['HTTP_HOST'] . "/mercadopago/confirm.php?status=success",
                "failure" => "https://" . $_SERVER['HTTP_HOST'] . "/mercadopago/confirm.php?status=failure",
                "pending" => "https://" . $_SERVER['HTTP_HOST'] . "/mercadopago/confirm.php?status=pending"
            ];

            $preference = $client->create([
                "items" => [
                    [
                        "title" => $title,
                        "quantity" => 1,
                        "unit_price" => (float)$price,
                        "currency_id" => "CLP"
                    ]
                ],
                "back_urls" => $backUrls,
                "auto_return" => "approved",
                "external_reference" => $external_reference
            ]);

            return $preference->init_point; 
        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
            
            // Intentar extraer el detalle si es un error de la API
            if (method_exists($e, 'getApiResponse')) {
                $response = $e->getApiResponse();
                $errorMsg .= " - Detalle: " . json_encode($response->getContent());
            }

            error_log("Mercado Pago v3 Error: " . $errorMsg);
            
            if (ini_get('display_errors')) {
                echo "Error detallado de MP: " . $errorMsg;
            }
            return null;
        }
    }
}
