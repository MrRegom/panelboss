<?php
require 'admin/includes/bootstrap.php';
$db = App\Config\Database::getConnection();
$tables = $db->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'")->fetchAll(PDO::FETCH_COLUMN);
print_r($tables);
