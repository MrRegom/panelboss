<?php
namespace App\Config;

/**
 * Configuración de Seguridad para la API CajaYa
 */
class SecurityConfig {
    // LLAVE MAESTRA: En producción esto debería venir de una variable de entorno (.env)
    public const JWT_SECRET = 'CAJAYA_SECRET_KEY_2026_PRO_V4';
    
    // Algoritmo de firma
    public const JWT_ALGO = 'HS256';
    
    // Duración del token (1 hora)
    public const TOKEN_EXPIRY = 3600; 
}
