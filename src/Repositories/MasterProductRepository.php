<?php

namespace App\Repositories;

use App\Config\Database;
use PDO;

/**
 * MasterProductRepository — Acceso a datos para el Catálogo Global de CajaYa
 * Aplica principios de Repository Pattern y Clean Architecture.
 */
class MasterProductRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Busca un producto por su código de barras (EAN)
     */
    public function getByBarcode(string $barcode): ?array
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM master_products p 
                LEFT JOIN product_categories c ON p.category_id = c.id 
                WHERE p.barcode = :barcode AND p.is_active = TRUE";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['barcode' => $barcode]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Lista productos con paginación y búsqueda
     */
    public function list(int $limit = 50, int $offset = 0, string $search = ''): array
    {
        $params = ['limit' => $limit, 'offset' => $offset];
        $where = "";

        if ($search) {
            $where = "WHERE p.name ILIKE :search OR p.barcode LIKE :search OR p.brand ILIKE :search";
            $params['search'] = "%$search%";
        }

        $sql = "SELECT p.*, c.name as category_name 
                FROM master_products p 
                LEFT JOIN product_categories c ON p.category_id = c.id 
                $where 
                ORDER BY p.name ASC 
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        
        // PDO bindValue para enteros en LIMIT/OFFSET
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        if ($search) {
            $stmt->bindValue(':search', $params['search'], PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Guarda o actualiza un producto en el catálogo maestro
     */
    public function save(array $data): bool
    {
        if (isset($data['id'])) {
            $sql = "UPDATE master_products SET 
                    name = :name, brand = :brand, category_id = :category_id, 
                    description = :description, image_path = :image_path, 
                    is_active = :is_active, attributes = :attributes, 
                    updated_at = CURRENT_TIMESTAMP 
                    WHERE id = :id";
        } else {
            $sql = "INSERT INTO master_products 
                    (barcode, name, brand, category_id, description, image_path, attributes) 
                    VALUES 
                    (:barcode, :name, :brand, :category_id, :description, :image_path, :attributes)";
        }

        $stmt = $this->db->prepare($sql);
        
        // Convertir atributos a JSON si es un array
        $attributes = isset($data['attributes']) ? json_encode($data['attributes']) : null;

        $params = [
            'name'        => $data['name'],
            'brand'       => $data['brand'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'description' => $data['description'] ?? null,
            'image_path'  => $data['image_path'] ?? null,
            'attributes'  => $attributes
        ];

        if (isset($data['id'])) {
            $params['id'] = $data['id'];
            $params['is_active'] = $data['is_active'] ?? true;
        } else {
            $params['barcode'] = $data['barcode'];
        }

        return $stmt->execute($params);
    }

    /**
     * Obtiene todas las categorías
     */
    public function getCategories(): array
    {
        $sql = "SELECT * FROM product_categories ORDER BY name ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
