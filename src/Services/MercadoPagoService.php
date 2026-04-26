<?php

namespace App\Services;

use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

/**
 * Servicio Profesional para la integración con Mercado Pago
 * Implementa el flujo de 'Checkout Pro'
 */
class MercadoPagoService
{
    public function __construct()
    {
        // Token de Prueba (Debes reemplazarlo por tu Access Token de MP)
        // Para pruebas usamos un Access Token de prueba de un usuario vendedor de prueba
        SDK::setAccessToken("APP_USR-6317423040933451-021714-00000000000000000000000000000000-000000000"); // REEMPLAZAR
    }

    /**
     * Crea una preferencia de pago (Link de cobro)
     * 
     * @param string $title Nombre del producto
     * @param int $price Precio en CLP
     * @param string $id Identificador interno de la orden
     * @return string URL de pago (init_point)
     */
    public function createPreference($title, $price, $external_reference)
    {
        try {
            $preference = new Preference();

            // Creamos el ítem (el producto)
            $item = new Item();
            $item->title = $title;
            $item->quantity = 1;
            $item->unit_price = $price;
            $item->currency_id = "CLP";

            $preference->items = array($item);
            $preference->external_reference = $external_reference;

            // URLs de retorno
            $preference->back_urls = array(
                "success" => "http://" . $_SERVER['HTTP_HOST'] . "/panelboss/mercadopago/confirm.php?status=success",
                "failure" => "http://" . $_SERVER['HTTP_HOST'] . "/panelboss/mercadopago/confirm.php?status=failure",
                "pending" => "http://" . $_SERVER['HTTP_HOST'] . "/panelboss/mercadopago/confirm.php?status=pending"
            );
            $preference->auto_return = "approved";

            $preference->save();

            return $preference->init_point; // URL para redirigir al usuario
        } catch (\Exception $e) {
            error_log("Mercado Pago Error: " . $e->getMessage());
            return null;
        }
    }
}
