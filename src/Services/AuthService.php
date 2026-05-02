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
    private $db;

    public function __construct($db = null) {
        $this->db = $db;
    }

    /**
     * Procesa el inicio de sesión tradicional para el Panel usando RUT
     */
    public function login($rut, $password) {
        // Limpiamos el RUT antes de consultar
        $rut = $this->cleanRut($rut);
        
        $stmt = $this->db->prepare("SELECT * FROM users WHERE rut = :rut AND status = 'active' LIMIT 1");
        $stmt->execute(['rut' => $rut]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_rut'] = $user['rut'];
            $_SESSION['user_role'] = $user['role_id'];
            return true;
        }
        return false;
    }

    /**
     * Limpia un RUT (quita puntos, guiones y espacios)
     */
    public static function cleanRut($rut) {
        return str_replace(['.', '-', ' '], '', strtoupper($rut));
    }

    /**
     * Valida si un RUT es válido (Dígito verificador)
     */
    public static function validateRut($rut) {
        $rut = self::cleanRut($rut);
        if (strlen($rut) < 2) return false;
        
        $dv = substr($rut, -1);
        $numero = substr($rut, 0, strlen($rut) - 1);
        
        $i = 2;
        $suma = 0;
        foreach (array_reverse(str_split($numero)) as $v) {
            if ($i == 8) $i = 2;
            $suma += $v * $i;
            $i++;
        }
        
        $dvr = 11 - ($suma % 11);
        if ($dvr == 11) $dvr = 0;
        if ($dvr == 10) $dvr = 'K';
        
        return strtoupper($dvr) == strtoupper($dv);
    }
    
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

    /**
     * Verifica si hay una sesión activa en el panel (Simple Check)
     */
    public static function check() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit;
        }
    }

    /**
     * Cierra la sesión de forma segura
     */
    public static function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: login.php");
        exit;
    }
}
