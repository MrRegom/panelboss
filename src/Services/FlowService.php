<?php

namespace App\Services;

/**
 * FlowService — Integración con Flow.cl (pasarela de pagos chilena)
 * Implementa el flujo de pago con firma HMAC-SHA256 según documentación oficial.
 * Soporta sandbox y producción via variable de entorno FLOW_ENV.
 *
 * @see https://www.flow.cl/docs/api.html
 */
class FlowService
{
    /** URL base del API de Flow según el entorno */
    private string $apiUrl;

    /** API Key proporcionada por Flow en el panel de configuración */
    private string $apiKey;

    /** Secret Key para firma HMAC-SHA256 */
    private string $secretKey;

    public function __construct()
    {
        $this->apiKey    = $_ENV['FLOW_API_KEY']    ?? '';
        $this->secretKey = $_ENV['FLOW_SECRET_KEY'] ?? '';

        // Selección automática de entorno: sandbox o producción
        $env = strtolower($_ENV['FLOW_ENV'] ?? 'sandbox');
        $this->apiUrl = ($env === 'production')
            ? 'https://www.flow.cl/api'
            : 'https://sandbox.flow.cl/api';
    }

    // =========================================================================
    // FIRMA
    // =========================================================================

    /**
     * Genera la firma HMAC-SHA256 requerida por Flow.
     * Ordena los parámetros alfabéticamente y los concatena key+value.
     */
    private function sign(array $params): string
    {
        // Ordenar por clave (requisito de Flow)
        ksort($params);

        $toSign = '';
        foreach ($params as $key => $value) {
            $toSign .= $key . $value;
        }

        return hash_hmac('sha256', $toSign, $this->secretKey);
    }

    // =========================================================================
    // CREAR ORDEN DE PAGO
    // =========================================================================

    /**
     * Crea una orden de pago en Flow y retorna la URL de pago al cliente.
     *
     * @param string $orderId          Referencia interna única (ej: CJY-1234567890)
     * @param string $subject          Descripción del producto (ej: "CajaYa - Plan Lifetime")
     * @param int    $amount           Monto en CLP (sin decimales)
     * @param string $email            Email del comprador
     * @param string $urlConfirmation  URL donde Flow enviará el IPN (webhook POST)
     * @param string $urlReturn        URL donde el cliente es redirigido tras pagar
     *
     * @return array{url: string, token: string}|null
     */
    public function createPaymentOrder(
        string $orderId,
        string $subject,
        int    $amount,
        string $email,
        string $urlConfirmation,
        string $urlReturn
    ): ?array {
        $params = [
            'apiKey'          => $this->apiKey,
            'commerceOrder'   => $orderId,
            'subject'         => $subject,
            'currency'        => 'CLP',
            'amount'          => $amount,
            'email'           => $email,
            'paymentMethod'   => 9,              // 9 = todos los medios disponibles
            'urlConfirmation' => $urlConfirmation,
            'urlReturn'       => $urlReturn,
        ];

        // Agregar firma al payload
        $params['s'] = $this->sign($params);

        $response = $this->post('/payment/create', $params);

        if (!$response || !isset($response['url'], $response['token'])) {
            error_log('[FlowService] Error al crear orden: ' . json_encode($response));
            return null;
        }

        return [
            'url'   => $response['url'] . '?token=' . $response['token'],
            'token' => $response['token'],
        ];
    }

    // =========================================================================
    // VERIFICAR ESTADO DEL PAGO (para IPN y confirm)
    // =========================================================================

    /**
     * Obtiene el estado de un pago por su token.
     * Usar tanto en el webhook (IPN) como en la página de retorno.
     *
     * @param string $token Token retornado por Flow
     * @return array|null   Datos completos del pago
     */
    public function getPaymentStatus(string $token): ?array
    {
        $params = [
            'apiKey' => $this->apiKey,
            'token'  => $token,
        ];
        $params['s'] = $this->sign($params);

        $response = $this->get('/payment/getStatus', $params);

        if (!$response || !isset($response['status'])) {
            error_log('[FlowService] Error al consultar estado: ' . json_encode($response));
            return null;
        }

        return $response;
    }

    /**
     * Mapea el código de estado de Flow a un string legible.
     * 1 = pendiente, 2 = pagado, 3 = rechazado, 4 = anulado
     */
    public function mapStatus(int $flowStatus): string
    {
        return match ($flowStatus) {
            1 => 'pending',
            2 => 'success',
            3 => 'failed',
            4 => 'cancelled',
            default => 'unknown',
        };
    }

    // =========================================================================
    // HTTP HELPERS
    // =========================================================================

    /**
     * Realiza una petición POST al API de Flow con cURL.
     */
    private function post(string $endpoint, array $params): ?array
    {
        $ch = curl_init($this->apiUrl . $endpoint);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
        ]);

        $raw  = curl_exec($ch);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($err) {
            error_log('[FlowService][cURL POST] ' . $err);
            return null;
        }

        return json_decode($raw, true);
    }

    /**
     * Realiza una petición GET al API de Flow con cURL.
     */
    private function get(string $endpoint, array $params): ?array
    {
        $url = $this->apiUrl . $endpoint . '?' . http_build_query($params);
        $ch  = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
        ]);

        $raw = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            error_log('[FlowService][cURL GET] ' . $err);
            return null;
        }

        return json_decode($raw, true);
    }
}
