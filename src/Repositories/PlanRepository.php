<?php

namespace App\Repositories;

use App\Config\Database;
use PDO;

/**
 * Repository para gestionar los planes de suscripción.
 */
class PlanRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Obtiene todos los planes disponibles.
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM subscription_plans ORDER BY price ASC");
        return $stmt->fetchAll();
    }

    /**
     * Busca un plan por su slug (ej: 'lifetime', 'mensual').
     */
    public function getBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM subscription_plans WHERE slug = :slug LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    /**
     * Actualiza el precio de un plan.
     */
    public function updatePrice($slug, $newPrice) {
        $stmt = $this->db->prepare("UPDATE subscription_plans SET price = :price, updated_at = NOW() WHERE slug = :slug");
        return $stmt->execute(['slug' => $slug, 'price' => $newPrice]);
    }
}
