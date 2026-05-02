<?php

namespace App\Repositories;

use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findAll() {
        $sql = "SELECT id, rut, full_name, email, role, status, last_login FROM users ORDER BY created_at DESC";
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Busca un usuario por su RUT.
     */
    public function findByRut(string $rut): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE rut = :rut LIMIT 1");
        $stmt->execute([':rut' => $rut]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /**
     * Busca un usuario por su ID.
     * 
     * @param int $id
     * @return array|null
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, name, email, role, created_at FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }
}
