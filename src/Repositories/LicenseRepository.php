<?php

namespace App\Repositories;

use App\Config\Database;
use PDO;

class LicenseRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findByLicenseKey($key) {
        $stmt = $this->db->prepare("SELECT * FROM licenses WHERE license_key = :key LIMIT 1");
        $stmt->execute(['key' => $key]);
        return $stmt->fetch();
    }

    public function findByLicenseAndMachine($key, $machineId) {
        $stmt = $this->db->prepare("SELECT * FROM licenses WHERE license_key = :key AND machine_id = :machine_id LIMIT 1");
        $stmt->execute(['key' => $key, 'machine_id' => $machineId]);
        return $stmt->fetch();
    }

    public function updateActivation($id, $machineId, $businessData) {
        $stmt = $this->db->prepare("
            UPDATE licenses 
            SET status = 'active', 
                machine_id = :machine_id, 
                activated_at = NOW(),
                business_name = :business_name,
                rut = :rut,
                email = :email,
                address = :address,
                phone = :phone
            WHERE id = :id
        ");
        
        return $stmt->execute(array_merge(['id' => $id, 'machine_id' => $machineId], $businessData));
    }

    public function updateHeartbeat($id, $version) {
        $stmt = $this->db->prepare("
            UPDATE licenses 
            SET last_heartbeat_at = NOW(), 
                heartbeat_count = heartbeat_count + 1,
                current_version = :version
            WHERE id = :id
        ");
        return $stmt->execute(['id' => $id, 'version' => $version]);
    }

    public function deactivate($id) {
        $stmt = $this->db->prepare("
            UPDATE licenses 
            SET status = 'pending', 
                machine_id = NULL, 
                activated_at = NULL 
            WHERE id = :id
        ");
        return $stmt->execute(['id' => $id]);
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM licenses ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function create($licenseKey, $plan, $expiresAt = null) {
        $stmt = $this->db->prepare("
            INSERT INTO licenses (license_key, plan, expires_at, status, created_at) 
            VALUES (:key, :plan, :expires_at, 'pending', NOW())
        ");
        return $stmt->execute([
            'key' => $licenseKey,
            'plan' => $plan,
            'expires_at' => $expiresAt
        ]);
    }

    public function createHeartbeatLog($licenseId, $machineId, $version, $stats) {
        $stmt = $this->db->prepare("
            INSERT INTO heartbeats_log (license_id, machine_id, version, stats, timestamp) 
            VALUES (:license_id, :machine_id, :version, :stats, NOW())
        ");
        return $stmt->execute([
            'license_id' => $licenseId,
            'machine_id' => $machineId,
            'version' => $version,
            'stats' => json_encode($stats)
        ]);
    }
}
