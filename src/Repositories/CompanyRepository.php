<?php
namespace App\Repositories;
use PDO;

class CompanyRepository {
    private $db;
    public function __construct(PDO $db) { $this->db = $db; }

    public function findAll() {
        return $this->db->query("SELECT * FROM companies ORDER BY name ASC")->fetchAll();
    }
}
