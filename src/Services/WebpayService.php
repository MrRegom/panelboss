<?php

namespace App\Services;

use Transbank\Webpay\WebpayPlus;
use Transbank\Webpay\WebpayPlus\Transaction;

/**
 * Servicio Profesional para la integración con Webpay Plus
 * Basado en Clean Architecture y SRP.
 */
class WebpayService
{
    private $transaction;

    public function __construct()
    {
        // Configuramos el SDK para ambiente de Integración (Pruebas)
        // Por defecto el SDK viene listo para usar las llaves de prueba de Transbank
        $this->transaction = new Transaction();
    }

    /**
     * Inicia una transacción en Webpay
     * 
     * @param string $buyOrder Identificador único de la compra
     * @param string $sessionId Identificador de sesión del usuario
     * @param int $amount Monto de la transacción (CLP)
     * @param string $returnUrl URL a la que Webpay redirigirá tras el pago
     * @return object Token y URL de redirección
     */
    public function createTransaction($buyOrder, $sessionId, $amount, $returnUrl)
    {
        try {
            $response = $this->transaction->create($buyOrder, $sessionId, $amount, $returnUrl);
            return $response;
        } catch (\Exception $e) {
            // Loguear el error para auditoría técnica
            error_log("Webpay Create Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Confirma el resultado de una transacción
     * 
     * @param string $token Token recibido desde Webpay
     * @return object Detalle de la transacción (status, amount, etc)
     */
    public function commitTransaction($token)
    {
        try {
            $response = $this->transaction->commit($token);
            return $response;
        } catch (\Exception $e) {
            error_log("Webpay Commit Error: " . $e->getMessage());
            return null;
        }
    }
}
