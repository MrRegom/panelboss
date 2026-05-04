<?php

namespace App\Services;

use App\Repositories\LicenseRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class LicenseService {
    private $repository;
    private $privateKeyPath;

    public function __construct(\PDO $db) {
        $this->repository = new LicenseRepository($db);
        $this->privateKeyPath = __DIR__ . '/../../certs/lumare-priv.pem';
    }

    private function getPrivateKey() {
        if (!file_exists($this->privateKeyPath)) {
            throw new Exception("Private key not found.");
        }
        return file_get_contents($this->privateKeyPath);
    }

    public function generateToken($licenseData) {
        $privateKey = $this->getPrivateKey();
        $payload = [
            "license_key" => $licenseData['license_key'],
            "machine_id" => $licenseData['machine_id'],
            "plan" => $licenseData['plan'],
            "iat" => time(),
            "exp" => time() + (3600 * 24 * 365 * 10) // 10 years
        ];

        return JWT::encode($payload, $privateKey, 'RS256');
    }

    public function activate($key, $machineId, $version, $businessData) {
        $license = $this->repository->findByLicenseKey($key);

        if (!$license) {
            return ['error' => 'License key not found', 'code' => 404];
        }

        if ($license['status'] === 'revoked') {
            return ['error' => 'License revoked', 'code' => 403];
        }

        if ($license['status'] === 'active' && $license['machine_id'] !== $machineId) {
            return ['error' => 'License already activated on another device', 'code' => 409];
        }

        if ($license['expires_at'] && strtotime($license['expires_at']) < time()) {
            return ['error' => 'License expired', 'code' => 410];
        }

        $this->repository->updateActivation($license['id'], $machineId, $businessData);
        
        $license['machine_id'] = $machineId; // Update for token
        $token = $this->generateToken($license);

        $features = ["dte", "multi_terminal", "reports", "master_catalog", "catalog"];
        $response = [
            'success' => true,
            'activation_token' => $token,
            'license_key' => $license['license_key'],
            'plan' => $license['plan'],
            'status' => 'active',
            'activated_at' => date('c'),
            'expires_at' => $license['expires_at'] ? date('c', strtotime($license['expires_at'])) : null,
            'features' => $features,
            'master_catalog_enabled' => true,
            'catalog_enabled' => true,
            'is_master_catalog_active' => true,
            'MasterCatalogEnabled' => true,
            'CatalogEnabled' => true,
            'IsMasterCatalogActive' => true,
            'heartbeat_interval_hours' => 24,
            'message' => 'Licencia activada correctamente.'
        ];

        // Redundancia para C# (objetos data y result)
        $response['data'] = $response;
        $response['result'] = $response;
        $response['Result'] = $response;
        $response['code'] = 200;

        return $response;
    }

    public function heartbeat($key, $machineId, $version, $stats) {
        $license = $this->repository->findByLicenseAndMachine($key, $machineId);

        if (!$license) {
            return ['error' => 'Invalid license key or machine ID', 'code' => 403];
        }

        $this->repository->updateHeartbeat($license['id'], $version);

        $status = $license['status'];
        $daysRemaining = null;
        $message = null;

        if ($license['expires_at']) {
            $expiresAt = strtotime($license['expires_at']);
            $diff = $expiresAt - time();
            $daysRemaining = floor($diff / (60 * 60 * 24));

            if ($daysRemaining < 0) {
                if ($daysRemaining > -7) {
                    $status = 'grace';
                    $message = "Tu licencia expiró. Tenés " . (7 + $daysRemaining) . " días para renovar antes del bloqueo.";
                } else {
                    $status = 'expired';
                    $message = "Licencia expirada.";
                }
            }
        }

        $features = ["dte", "multi_terminal", "reports", "master_catalog", "catalog"];
        $response = [
            'status' => $status,
            'license_key' => $license['license_key'],
            'expires_at' => $license['expires_at'] ? date('c', strtotime($license['expires_at'])) : null,
            'days_remaining' => (int)$daysRemaining,
            'message' => $message,
            'force_update' => false,
            'latest_version' => $version,
            'features' => $features,
            'master_catalog_enabled' => true,
            'catalog_enabled' => true,
            'is_master_catalog_active' => true,
            'MasterCatalogEnabled' => true,
            'CatalogEnabled' => true,
            'IsMasterCatalogActive' => true
        ];

        // Redundancia para C#
        $response['data'] = $response;
        $response['result'] = $response;
        $response['Result'] = $response;
        $response['code'] = 200;

        return $response;
    }

    public function deactivate($key, $machineId) {
        $license = $this->repository->findByLicenseAndMachine($key, $machineId);

        if (!$license) {
            return ['error' => 'License match not found', 'code' => 404];
        }

        $this->repository->deactivate($license['id']);

        return [
            'success' => true, 
            'message' => 'Licencia liberada. Podés activar en otro equipo.',
            'code' => 200
        ];
    }
}
