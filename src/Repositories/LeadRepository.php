<?php
namespace App\Repositories;

use PDO;

class LeadRepository {
    private \PDO $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM leads ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCount(): int {
        return (int) $this->db->query("SELECT COUNT(*) FROM leads")->fetchColumn();
    }
}
