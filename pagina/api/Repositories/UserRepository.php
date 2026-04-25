<?php
namespace App\Repositories;

use PDO;
use App\Config\Database;

class UserRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function createUser(string $email): bool {
        // Al insertar en auth.users, el TRIGGER de Postgres que creamos
        // va a interceptar esto y creará el Tenant y el Profile automáticamente.
        $stmt = $this->db->prepare("INSERT INTO auth.users (email, raw_user_meta_data) VALUES (:email, :meta)");
        $meta = json_encode(['full_name' => 'Usuario Manual']);
        return $stmt->execute([
            ':email' => $email,
            ':meta' => $meta
        ]);
    }

    public function emailExists(string $email): bool {
        $stmt = $this->db->prepare("SELECT id FROM auth.users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return (bool) $stmt->fetch();
    }
}
