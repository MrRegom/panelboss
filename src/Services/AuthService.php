<?php
namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Config\SecurityConfig;
use Exception;

/**
 * Servicio de Autenticación mediante JWT
 */
class AuthService {
    
    /**
     * Genera un Token de acceso basado en la licencia
     */
    public static function generateToken($licenseId, $licenseKey) {
        $issuedAt = time();
        $expire = $issuedAt + SecurityConfig::TOKEN_EXPIRY;
        
        $payload = [
            'iss' => 'api.cajaya.cl',
            'aud' => 'cajaya_pos_app',
            'iat' => $issuedAt,
            'nbf' => $issuedAt,
            'exp' => $expire,
            'data' => [
                'license_id' => $licenseId,
                'license_key' => $licenseKey
            ]
        ];
        
        return [
            'access_token' => JWT::encode($payload, SecurityConfig::JWT_SECRET, SecurityConfig::JWT_ALGO),
            'expires_in' => SecurityConfig::TOKEN_EXPIRY,
            'token_type' => 'Bearer'
        ];
    }
    
    /**
     * Valida un Token JWT
     */
    public static function validateToken($token) {
        try {
            $decoded = JWT::decode($token, new Key(SecurityConfig::JWT_SECRET, SecurityConfig::JWT_ALGO));
            return (array) $decoded->data;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Extrae el Bearer Token del Header de Authorization
     */
    public static function getBearerToken() {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
}
