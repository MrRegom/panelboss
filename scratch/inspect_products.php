<?php
require 'admin/includes/bootstrap.php';
$db = App\Config\Database::getConnection();
$stmt = $db->query("SELECT * FROM master_products LIMIT 1");
print_r($stmt->fetch(PDO::FETCH_ASSOC));
