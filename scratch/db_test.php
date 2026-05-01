<?php
try {
    require 'admin/includes/bootstrap.php';
    $db = App\Config\Database::getConnection();
    $db->query("SELECT 1 FROM master_catalog LIMIT 1");
    echo "OK: Table exists";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
