<?php
namespace App\Repositories;

use PDO;
use App\Config\Database;

class SettingRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->ensureTableExists();
    }

    private function ensureTableExists() {
        $sql = "CREATE TABLE IF NOT EXISTS system_settings (
            id SERIAL PRIMARY KEY,
            setting_key VARCHAR(50) UNIQUE NOT NULL,
            setting_value TEXT NOT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->db->exec($sql);

        // Valores por defecto
        $this->setDefault('download_url', 'https://cajaya.cl/LumarePOS-Setup-1.0.0.exe');
        $this->setDefault('current_version', '1.0.0');
    }

    private function setDefault($key, $value) {
        $sql = "INSERT INTO system_settings (setting_key, setting_value) 
                VALUES (:key, :value) 
                ON CONFLICT (setting_key) DO NOTHING";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['key' => $key, 'value' => $value]);
    }

    public function get($key) {
        $stmt = $this->db->prepare("SELECT setting_value FROM system_settings WHERE setting_key = :key");
        $stmt->execute(['key' => $key]);
        return $stmt->fetchColumn();
    }

    public function update($key, $value) {
        $stmt = $this->db->prepare("UPDATE system_settings SET setting_value = :value, updated_at = NOW() WHERE setting_key = :key");
        return $stmt->execute(['key' => $key, 'value' => $value]);
    }
}
